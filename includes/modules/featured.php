<?php
/*
  $Id: \includes\modules\featured.phpp; 25.06.2006

  mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php

$modules_template = 'featured';
$ilosc_col = MAX_DISPLAY_COLUMN_FEATURED_PRODUCTS;
$max_display = MAX_DISPLAY_FEATURED_PRODUCTS;

$max_wiersz =  $max_display/$ilosc_col;
$szer_tab = round(100/$ilosc_col,0) ;

if(FEATURED_PRODUCTS_DISPLAY == 'true') {
	$featured_products_category_id = $featured_products_category_id;
	$cat_name_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . $featured_products_category_id . "' limit 1");
	$cat_name_fetch = tep_db_fetch_array($cat_name_query);
	$cat_name = $cat_name_fetch['categories_name'];
	$info_box_contents = array();

	if ( (!isset($featured_products_category_id)) || ($featured_products_category_id == '0') ) {
		$info_box_contents[] = array('text' => '<a class="headerNavigationFeatured" href="' . tep_href_link(FILENAME_FEATURED_PRODUCTS) . '">' . TABLE_HEADING_FEATURED_PRODUCTS . '</a>');
//		$info_box_contents[] = array('text' => sprintf(TABLE_HEADING_FEATURED_PRODUCTS_CATEGORY, $cat_name));
	} else {
		$info_box_contents[] = array('text' => sprintf(TABLE_HEADING_FEATURED_PRODUCTS_CATEGORY, $cat_name));
	}
	if ( (!isset($featured_products_category_id)) || ($featured_products_category_id == '0') ) {
		list($usec, $sec) = explode(' ', microtime());
		srand( (float) $sec + ((float) $usec * 100000) );
		$mtm= rand();
		//TotalB2B start

        $featured_products_query = tep_db_query("select distinct p.products_id, products_quantity, p.products_image, p.products_tax_class_id, s.status as specstat, s.specials_new_products_price, p.products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c using(products_id) left join " . TABLE_CATEGORIES . " c using(categories_id) left join " . TABLE_FEATURED . " f on p.products_id = f.products_id left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id where c.categories_status='1' and p.products_status = '1' and f.status = '1' order by rand() DESC limit " . $max_display);

	} else {
		$subcategories_array = array();
		tep_get_subcategories($subcategories_array, $featured_products_category_id);
		$featured_products_category_id_list = tep_array_values_to_string($subcategories_array);
		if ($featured_products_category_id_list == '') {
			$featured_products_category_id_list .= $featured_products_category_id;
		} else {
			$featured_products_category_id_list .= ',' . $featured_products_category_id;
		}
		$featured_products_query = tep_db_query("select distinct p.products_id, products_quantity, p.products_image, p.products_tax_class_id, products_retail_price, s.status as specstat, s.specials_new_products_price, p.products_price from ((" . TABLE_PRODUCTS . " p) left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c) left join " . TABLE_FEATURED . " f on p.products_id = f.products_id where c.categories_status='1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id in (" . $featured_products_category_id_list . ") and p.products_status = '1' and f.status = '1' order by rand() DESC limit " . $max_display);
	}
	//TotalB2B end

	$query_special_prices_hide_result = SPECIAL_PRICES_HIDE;
	$special_hide = $query_special_prices_hide_result;

if (tep_db_num_rows($featured_products_query) > 0) {

?>

<!-- featured products //-->
   <?php
   include (bts_select('modules', $modules_template));
   ?>
<?php
}
}
?>
<!-- featured_products_eof //-->