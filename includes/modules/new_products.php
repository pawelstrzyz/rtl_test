<?php
/*
  $Id: \includes\modules\new_products.phpp; 25.06.2006

  mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php

$modules_template = 'new_products';
$ilosc_col = MAX_DISPLAY_COLUMN_NEW_PRODUCTS;
$max_display = MAX_DISPLAY_NEW_PRODUCTS;

$max_wiersz =  $max_display/$ilosc_col;
$szer_tab = round(100/$ilosc_col,0) ;

//TotalB2B start
if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $new_products_query = tep_db_query("select distinct p.products_id, products_quantity, p.products_image, p.products_tax_class_id, products_retail_price, if(s.status, s.specials_new_products_price, p.products_price) as products_price, manufacturers_id from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where c.categories_status='1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and products_status = '1' order by p.products_date_added desc limit " . $max_display);

} else {
	$subcategories_array = array();
	tep_get_subcategories($subcategories_array, $new_products_category_id);
	$new_products_category_id_list = tep_array_values_to_string($subcategories_array);
	if ($new_products_category_id_list =='') {
		$new_products_category_id_list .= $new_products_category_id;
	} else {
		$new_products_category_id_list .= ',' . $new_products_category_id;
	}

    $new_products_query = tep_db_query("select distinct p.products_id, products_quantity, p.products_image, p.products_tax_class_id, products_retail_price, if(s.status, s.specials_new_products_price, p.products_price) as products_price, manufacturers_id from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where c.categories_status='1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . (int)$new_products_category_id . "' and p.products_status = '1' order by rand() desc limit " . $max_display);
}
//TotalB2B end

$query_special_prices_hide_result = SPECIAL_PRICES_HIDE;
$special_hide = $query_special_prices_hide_result;

if (tep_db_num_rows($new_products_query) > 0) {
?>
<!-- new_products //-->

   <?php
   include (bts_select('modules', $modules_template));
   ?>


<?php
}
?>
<!-- new_products_eof //-->