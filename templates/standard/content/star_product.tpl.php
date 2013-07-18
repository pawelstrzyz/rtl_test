<?php
/*
  $Id: \templates\standard\content\star_product.tpl.php; 21.08.2007

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
	<tr>  
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo HEADING_TITLE; ?></td>
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_left.gif" border="0" alt="" width="30" height="35"></td>	
	</tr> 
 </table></td>
      </tr>	  
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <!-- Naglowek EOF -->
 <tr>
  <td>

 <?php

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
   while (list($column, $value) = each($define_list)) {
    if ($value) $column_list[] = $column;
   }

   $select_column_list = '';

   for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
      switch ($column_list[$i]) {
        case 'PRODUCT_LIST_MODEL':
          $select_column_list .= 'p.products_model, ';
          break;
        case 'PRODUCT_LIST_NAME':
          $select_column_list .= 'pd.products_name, ';
          break;
          case 'PRODUCT_LIST_DESCRIPTION':
 	        $select_column_list .= 'pd.products_description, ';
          break;
        case 'PRODUCT_LIST_QUANTITY':
          $select_column_list .= 'p.products_quantity, ';
          break;
        case 'PRODUCT_LIST_MAXORDER':
          $select_column_list .= 'p.products_maxorder, ';
          break;
        case 'PRODUCT_LIST_IMAGE':
          $select_column_list .= 'p.products_image, ';
          break;
        case 'PRODUCT_LIST_WEIGHT':
          $select_column_list .= 'p.products_weight, ';
          break;
        case 'PRODUCT_LIST_PRODUCTS_AVAILABILITY':
          $select_column_list .= 'p.products_availability_id, ';
          break;
      }
    }

// $featured_products_array = array();

 $listing_sql = "select " . $select_column_list . " p.products_id, p.products_quantity, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, p.products_date_added, m.manufacturers_name from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id left join " . TABLE_STAR_PRODUCT . " f on p.products_id = f.products_id left join " .TABLE_PRODUCTS_TO_CATEGORIES. " p2c on p2c.products_id = p.products_id left join " .TABLE_CATEGORIES. " c on c.categories_id = p2c.categories_id where c.categories_status='1' and p.products_status = '1' and f.status = '1' order by p.products_date_added DESC, pd.products_name";

   include($modules_folder . 'product_listing.php');

   ?>
  </td>
 </tr>
</table>