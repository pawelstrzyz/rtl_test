<?php
/*
  $Id: \includes\modules\new_products.phpp; 25.06.2006

  mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php

$modules_template = 'default_specials';
$ilosc_col = MAX_DISPLAY_COLUMN_DEFAULT_SPECIALS;
$max_display = MAX_DISPLAY_SPECIALS_PRODUCTS_MODULE;
$max_wiersz =  $max_display/$ilosc_col;

$szer_tab = round(100/$ilosc_col,0) ;

if (!isset($customer_id)) $customer_id = 0;
$boxContent = '';
$customer_group = tep_get_customers_groups_id();

if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
   $default_specials_query = tep_db_query("select p.products_id, products_quantity, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c  where c.categories_status='1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p.products_status = '1' and p.products_id = s.products_id and pd.products_id = s.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' and ((s.customers_id = '" . $customer_id . "' and s.customers_groups_id = '0') or (s.customers_id = '0' and s.customers_groups_id = '" . $customer_group . "') or (s.customers_id = '0' and s.customers_groups_id = '0')) order by RAND() limit " . $max_display);
} else {
   $default_specials_query = tep_db_query("select p.products_id, products_quantity, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c  where c.categories_status='1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p.products_status = '1' and p.products_id = s.products_id and pd.products_id = s.products_id and c.parent_id = '" . (int)$new_products_category_id . "' and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' and ((s.customers_id = '" . $customer_id . "' and s.customers_groups_id = '0') or (s.customers_id = '0' and s.customers_groups_id = '" . $customer_group . "') or (s.customers_id = '0' and s.customers_groups_id = '0')) order by RAND() limit " . $max_display);
}

$query_special_prices_hide_result = SPECIAL_PRICES_HIDE;
$special_hide = $query_special_prices_hide_result;

if (tep_db_num_rows($default_specials_query) > 0) {
?>

<!-- new_products //-->
   <?php
   include (bts_select('modules', $modules_template));
   ?>
<?php
}
?>
<!-- new_products_eof //-->