<?php
/*
  $Id: \includes\modules\related_products.php; 10.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

if (isset($HTTP_GET_VARS['products_id'])) {

 // create column list
 $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                      'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                      'PRODUCT_LIST_DESCRIPTION' => PRODUCT_LIST_DESCRIPTION,
                      'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
 						          'PRODUCT_LIST_RETAIL_PRICE' => PRODUCT_LIST_RETAIL_PRICE,
                      'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
						          'PRODUCT_LIST_SAVE' => PRODUCT_LIST_SAVE,
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

 $listing_sql = "select " . $select_column_list . " op2.products_id, p.products_quantity, p.products_price, p.products_retail_price, p.products_tax_class_id ".
       "FROM "  . TABLE_ORDERS_PRODUCTS . " op1 " .
       " INNER JOIN " . TABLE_ORDERS_PRODUCTS . " op2
       ON op2.orders_id = op1.orders_id ".
       "AND op2.products_id != '" . (int)$HTTP_GET_VARS['products_id'] . "' ".
       " INNER JOIN " . TABLE_PRODUCTS . " p ".
       "ON p.products_id = op2.products_id AND p.products_status='1' ".
       " INNER JOIN " .TABLE_PRODUCTS_DESCRIPTION . " pd ".
       "ON pd.products_id = op2.products_id AND pd.language_id='".$languages_id."'".
       " INNER JOIN " .TABLE_PRODUCTS_TO_CATEGORIES . " p2c ".
       "ON p2c.products_id = op2.products_id " .
       " INNER JOIN " .TABLE_CATEGORIES . " c ".
       "ON c.categories_id = p2c.categories_id " .

       "WHERE c.categories_status='1' and op1.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' ".
       "GROUP BY op2.products_id, p.products_image ".
       "ORDER BY 3 DESC ".
       "LIMIT ".MAX_DISPLAY_ALSO_PURCHASED;

 $orders_query = tep_db_query($listing_sql);

 if ( tep_db_num_rows($orders_query) >= MIN_DISPLAY_ALSO_PURCHASED ){
 ?>
  <table border="0" width="100%" cellspacing="0" cellpadding="0" class="templateinfoBox">
   <tr>
    <td class="main">
        <?php
        $info_box_contents = array();
        $info_box_contents[] = array('text' => TEXT_ALSO_PURCHASED_PRODUCTS);
        new contentBoxHeading($info_box_contents);
        ?>
    </td>
   </tr>
   <tr>
    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
   </tr>
   <tr>
    <td>
     <?php
      include(DIR_WS_MODULES . 'product_listing_prod.php');
     ?>
    </td>
   </tr>
  </table>
 <?php
 }
}
 ?>
