<?php
/*
  $Id: \includes\modules\related_products.php; 10.07.2006

  mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
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


// Begin - show related products
  $listing_sql = "select " . $select_column_list . " p.products_id, p.products_quantity, p.products_price, p.products_retail_price, p.products_tax_class_id from " . TABLE_PRODUCTS_OPTIONS_PRODUCTS . ", " . TABLE_PRODUCTS_DESCRIPTION . " pd, ". TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c WHERE p.products_id = p2c.products_id and c.categories_id = p2c.categories_id and c.categories_status=1 and pop_products_id_slave = p.products_id and pd.products_id=p.products_id and language_id = '" . (int)$languages_id . "' and pop_products_id_master = '".$HTTP_GET_VARS['products_id']."' and p.products_status=1 order by pop_order_id, pop_id";


  //TotalB2B start
  $query_special_prices_hide_result = SPECIAL_PRICES_HIDE;
  $special_hide = $query_special_prices_hide_result;

  $related_query = tep_db_query($listing_sql);
  if ( tep_db_num_rows($related_query)>0 ) {
  ?>
   <table border="0" width="100%" cellspacing="0" cellpadding="0" class="templateinfoBox">
    <tr>
     <td class="main">
      <?php
        $info_box_contents = array();
      $info_box_contents[] = array('text' => sprintf(TABLE_HEADING_RELATED_PRODUCTS));
      new contentBoxHeading($info_box_contents);
      ?>
     </td>
    </tr>
    <tr>
     <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
    </tr>
    <tr>
     <td class="main">
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
		    <tr>
         <td>
         <?php
         include(DIR_WS_MODULES . 'product_listing_prod.php');
         ?>
         </td>
			  </tr>
       </table>
     </td>
    </tr>
   </table>
   <?php
  }
?>
