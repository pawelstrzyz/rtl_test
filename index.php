<?php
/*
  $Id: \index.php; 23.06.2006

  mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
$PHP_SELF = !strlen(basename($PHP_SELF)) ? 'index.php' : $PHP_SELF;

require('includes/application_top.php');

// the following cPath references come from application_top.php
$category_depth = (isset($_GET['manufacturers_id']) ? 'products' : 'top');
if (isset($cPath) && tep_not_null($cPath)) {
  $categories_products_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . (int)$current_category_id . "'");
  $cateqories_products = tep_db_fetch_array($categories_products_query);
  if ($cateqories_products['total'] > 0) {
    $category_depth = 'products'; // display products
  }
  $category_parent_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$current_category_id . "'");
  $category_parent = tep_db_fetch_array($category_parent_query);
  if ($category_parent['total'] > 0) {
    if ($category_depth == 'top') {
      $category_depth = 'nested'; // navigate through the categories
    } else {
      $category_depth = 'both'; // navigate through both categories & products
    }
  } else {
      $category_depth = 'products'; // category has no products, but display the 'no products' message
  }
}

require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_DEFAULT);

// Header Tag Controller BOF
if (($category_depth == 'nested') || ($category_depth == 'both')) {  //display categories
  $category_query = tep_db_query("select cd.categories_name, c.categories_image, cd.categories_htc_title_tag, cd.categories_htc_description from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$current_category_id . "' and cd.categories_id = '" . (int)$current_category_id . "' and cd.language_id = '" . (int)$languages_id . "'");
  // Header Tag Controller EOF
  $category = tep_db_fetch_array($category_query);
}

if ($category_depth == 'nested') {
  $content = CONTENT_INDEX_NESTED;
} else if ($category_depth == 'both') {
  $content = CONTENT_INDEX_BOTH;
} else if ($category_depth == 'products') {
  $content = CONTENT_INDEX_PRODUCTS;
}

if (($category_depth == 'products') || ($category_depth == 'both') || isset($_GET['manufacturers_id'])) {
  // create column list
  $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                         'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                         'PRODUCT_LIST_DESCRIPTION' => PRODUCT_LIST_DESCRIPTION,
                         'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
						             'PRODUCT_LIST_RETAIL_PRICE' => PRODUCT_LIST_RETAIL_PRICE, //EZier new field mods by Noel
                         'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
						             'PRODUCT_LIST_SAVE' => PRODUCT_LIST_SAVE, //EZier new field mod by Noel
                         'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                         'PRODUCT_LIST_MAXORDER' => PRODUCT_LIST_MAXORDER,
                         'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                         'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                         'PRODUCT_LIST_PRODUCTS_AVAILABILITY' => PRODUCT_LIST_PRODUCTS_AVAILABILITY,
                         'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);

  asort($define_list);
  $column_list = array();
  reset($define_list);
  while (list($key, $value) = each($define_list)) {
    if ($value > 0) $column_list[] = $key;
  }

  $select_column_list = '';

  for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
    switch ($column_list[$i]) {
      case 'PRODUCT_LIST_MODEL':
        $select_column_list .= 'p.products_quantity, p.products_model, ';
        break;
      case 'PRODUCT_LIST_NAME':
        $select_column_list .= 'p.products_quantity, pd.products_name, ';
        break;
        // Products Description Hack begins
      case 'PRODUCT_LIST_DESCRIPTION':
 	      $select_column_list .= 'pd.products_description, ';
        break;
        // Products Description Hack ends
      case 'PRODUCT_LIST_MANUFACTURER':
        $select_column_list .= 'p.products_quantity, ';
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $select_column_list .= 'p.products_quantity, p.products_quantity, ';
        break;
        //MAXIMUM quantity code
      case 'PRODUCT_LIST_MAXORDER':
        $select_column_list .= 'p.products_maxorder, ';
        break;
        //End: MAXIMUM quantity code
      case 'PRODUCT_LIST_IMAGE':
        $select_column_list .= 'p.products_quantity, p.products_image, ';
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $select_column_list .= 'p.products_quantity, p.products_weight, ';
        break;
      case 'PRODUCT_LIST_PRODUCTS_AVAILABILITY':
        $select_column_list .= 'p.products_availability_id, p.products_weight, ';
        break;
    }
  }

  //TotalB2B start
  // show the products of a specified manufacturer
  if (isset($HTTP_GET_VARS['manufacturers_id'])) {
    if (isset($HTTP_GET_VARS['filter_id']) && tep_not_null($HTTP_GET_VARS['filter_id'])) {
      // We are asked to show only a specific category
      $listing_sql = "select " . $select_column_list . " m.manufacturers_name, p.products_id, p.manufacturers_id, p.products_retail_price, p.products_price, p.products_tax_class_id, products_jm_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from ((" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c) left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id) left join " . TABLE_CATEGORIES . " c on p2c.categories_id = c.categories_id where c.categories_status = '1' and p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$HTTP_GET_VARS['filter_id'] . "'";
    } else {
      // We show them all
      $listing_sql = "select " . $select_column_list . " m.manufacturers_name, p.products_id, p.manufacturers_id, p.products_retail_price, p.products_price, p.products_tax_class_id, products_jm_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from (((" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m) left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id) left join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c on p.products_id = p2c.products_id) left join " . TABLE_CATEGORIES . " c on p2c.categories_id = c.categories_id where c.categories_status = '1' and p.products_status = '1' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'";
	  }
  } else {
    // show the products in a given categorie
    if (isset($HTTP_GET_VARS['filter_id']) && tep_not_null($HTTP_GET_VARS['filter_id'])) {
      // We are asked to show only specific catgeory
      $listing_sql = "select " . $select_column_list . " m.manufacturers_name, p.products_id, p.manufacturers_id, p.products_retail_price, p.products_price, p.products_tax_class_id, products_jm_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from ((" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c) left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id) left join " . TABLE_CATEGORIES . " c on c.categories_id = p2c.categories_id where c.categories_status = '1' and p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['filter_id'] . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$current_category_id . "'";
    } else {
      // We show them all
      $listing_sql = "select " . $select_column_list . " m.manufacturers_name, p.products_id, p.manufacturers_id, p.products_retail_price, p.products_price, p.products_tax_class_id, products_jm_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from (((" . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p) left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c) left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id) left join " . TABLE_CATEGORIES . " c on c.categories_id = p2c.categories_id where c.categories_status = '1' and p.products_status = '1' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$current_category_id . "'";
	  }
  }
  //TotalB2B end

  if ( (!isset($HTTP_GET_VARS['sort'])) || (!ereg('^[1-8][ad]$', $HTTP_GET_VARS['sort'])) || (substr($HTTP_GET_VARS['sort'], 0, 1) > sizeof($column_list)) ) {
    for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
      if ($column_list[$i] == 'PRODUCT_LIST_NAME') {
        $HTTP_GET_VARS['sort'] = $i+1 . 'a';
        $listing_sql .= " order by pd.products_name";
        // $HTTP_GET_VARS['sort'] = '';
        //  $listing_sql .= " order by final_price";
        break;
      }
    }
  } else {
    $sort_col = substr($HTTP_GET_VARS['sort'], 0 , 1);
    $sort_order = substr($HTTP_GET_VARS['sort'], 1);
    switch ($column_list[$sort_col-1]) {
      case 'PRODUCT_LIST_MODEL':
        $listing_sql .= " order by p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_NAME':
        $listing_sql .= " order by pd.products_name " . ($sort_order == 'd' ? 'desc' : '');
        break;
        // ########### Products Description Hack begins ###########
      case 'PRODUCT_LIST_DESCRIPTION':
	     $listing_sql .= " order by pd.products_description ". ($sort_order == 'd' ? "desc" : "");
        break;
        // ############## End Added #################
      case 'PRODUCT_LIST_MANUFACTURER':
        $listing_sql .= " order by m.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $listing_sql .= " order by p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
        //MAXIMUM quantity code
      case 'PRODUCT_LIST_MAXORDER':
        $listing_sql .= " order by p.products_maxorder " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
        //End: MAXIMUM quantity code
	    case 'PRODUCT_LIST_IMAGE':
        $listing_sql .= " order by pd.products_name";
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $listing_sql .= " order by p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
		  case 'PRODUCT_LIST_RETAIL_PRICE':
		    $listing_sql .= " order by p.products_retail_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
		    break;
		    //TotalB2B start
		    //this is a know bug
		  case 'PRODUCT_LIST_PRICE':
        $listing_sql .= " order by p.products_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
		    //TotalB2B end
      }
    }
}

if ($category_depth == 'top') { // default page
  $content = CONTENT_INDEX_DEFAULT;
}

include (bts_select('main', $content_template)); // BTSv1.5
require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-41497777-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>