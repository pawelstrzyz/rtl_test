<?php
   $modules_template = 'star_product';
   $star_products_query = tep_db_query("select substring(pd.products_description, 1, 450) as products_description, p.products_id, p.products_image, p.manufacturers_id, p.products_price, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price, p.products_tax_class_id, sp.products_id, sp.status, sp.expires_date from (" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_STAR_PRODUCT . " sp, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c) left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id where p.products_id = p2c.products_id and c.categories_id = p2c.categories_id and c.categories_status='1' and p.products_id = pd.products_id and p.products_status = '1' and pd.products_description != '' and sp.status = '1' and p.products_id=sp.products_id and pd.language_id = '" . $languages_id . "' ORDER BY rand() limit 1");
   $star_products = tep_db_fetch_array($star_products_query);

if (tep_db_num_rows($star_products_query) > 0) {
?>


   <?php
   include (bts_select('modules', $modules_template));
   ?>
   
<?php } ?>