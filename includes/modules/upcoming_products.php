<?php
/*
  $Id: \includes\modules\upcoming_products.phpp; 25.06.2006

  mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

$modules_template = 'upcoming_products';
$ilosc_col = MAX_DISPLAY_COLUMN_UPCOMING_PRODUCTS;
$max_display = MAX_DISPLAY_UPCOMING_PRODUCTS;
$max_wiersz =  $max_display/$ilosc_col;

$szer_tab = round(100/$ilosc_col,0) ;

$expected_query = tep_db_query("select p.products_id, p.products_image, pd.products_name, products_date_available as date_expected from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_id = p2c.products_id and c.categories_id = p2c.categories_id and c.categories_status=1 and to_days(products_date_available) >= to_days(now()) and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by " . EXPECTED_PRODUCTS_FIELD . " " . EXPECTED_PRODUCTS_SORT . " limit " . $max_display);

if (tep_db_num_rows($expected_query) > 0) {

?>

<!-- upcoming_products //-->

   <?php
   include (bts_select('modules', $modules_template));
   ?>

<?php
}
?>
<!-- upcoming_products_eof //-->