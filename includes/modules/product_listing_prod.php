<?php
/*
  $Id: \includes\modules\products_listing.php; 04.07.2006

  mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

$szerokosc = ALLPROD_IMAGE_WIDTH+10;
$wysokosc = ALLPROD_IMAGE_HEIGHT+10;

// ****************************************************************************

$list_box_contents = array();

if (DISPLAY_PRICE_BRUTTO_NETTO == 'true') {
	$display_nb = 1;
  } else {
	$display_nb = 0;
}

$rows = 0;
$listing_query = tep_db_query($listing_sql);
while ($listing = tep_db_fetch_array($listing_query)) {

 if (($rows/2) == floor($rows/2)) {
  $list_box_contents[] = array('params' => 'class="productListing-even"');
 } else {
  $list_box_contents[] = array('params' => 'class="productListing-odd"');
 }

 $cur_row = sizeof($list_box_contents) - 1;

 for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
  $lc_align = '';
  $lc_params = '';

  switch ($column_list[$col]) {
          case 'PRODUCT_LIST_MODEL':
            $lc_align = '';
            $lc_text = '&nbsp;' . $listing['products_model'] . '&nbsp;';
            break;
          case 'PRODUCT_LIST_NAME':
            $lc_align = '';
            if (isset($HTTP_GET_VARS['manufacturers_id'])) {
              $lc_text = '<a class="ProductTile" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">' . osc_trunc_string($listing['products_name'],50, 1) . '</a>';
            } else {
              $lc_text = '&nbsp;<a class="ProductTile" href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">' . osc_trunc_string($listing['products_name'],50, 1) . '</a>&nbsp;';
            }
            break;
          // Products Description Hack begins
          case 'PRODUCT_LIST_DESCRIPTION':
            $lc_text = '' . osc_trunc_string(strip_tags($listing['products_description'], ''), PRODUCT_LIST_DESCRIPTION_LENGTH) . '&nbsp;';
            $col_to_span = sizeof($column_list)-1;
            if (PRODUCT_LIST_IMAGE > 0) {
              $col_to_span -= 1;
            }
            $lc_params = 'colspan="' . $col_to_span . '" valign="top"';
            break;
          // Products Description Hack ends

          case 'PRODUCT_LIST_MANUFACTURER':
            $lc_align = '';
            $lc_text = '&nbsp;<a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing['manufacturers_id']) . '">' . $listing['manufacturers_name'] . '</a>&nbsp;';
            break;
          // EZier New Fields added
          case 'PRODUCT_LIST_RETAIL_PRICE':
                  $lc_align = 'right';
                  if ((tep_not_null($listing['products_retail_price'])) && ($listing['products_retail_price']) > 0) {
                     $lc_text = '' . $currencies->display_price($listing['products_id'], $listing['products_retail_price'], tep_get_tax_rate($listing['products_tax_class_id']),1,$display_nb); 
                  } else {
                     $lc_text = '&nbsp;';
                  }
                  break;
          // End EZier New Fields added
          case 'PRODUCT_LIST_PRICE':
            $lc_align = 'right';
            if ($listing['products_price'] < 0.01 ) {
             $lc_text = ''.TEMPORARY_NO_PRICE.'';
            } else {
             //TotalB2B start
                 $listing['products_price'] = tep_xppp_getproductprice($listing['products_id']);
                   //TotalB2B start
                 if ($new_price = tep_get_products_special_price($listing['products_id'])) {
              $listing['specials_new_products_price'] = $new_price;
              $query_special_prices_hide_result = SPECIAL_PRICES_HIDE; 
              if ($query_special_prices_hide_result == 'true') {
                     $lc_text = '<span class="Cena">' . $currencies->display_price($listing['products_id'], $listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']),1,$display_nb) . '</span>';
                } else {
                     $lc_text = '<s>' .  $currencies->display_price($listing['products_id'], $listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price_nodiscount($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id']),1,$display_nb) . '</span>';
                }
                    //TotalB2B end
                   } else {
                    if (tep_not_null($listing['specials_new_products_price'])) {
               				$lc_text = '<s>' .  $currencies->display_price($listing['products_id'], $listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price($listing['products_id'], $listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id']),1,$display_nb) . '</span>';
              			} else {
                     	$lc_text = '<span class="Cena">' . (($listing['products_price'] > 0) ? $currencies->display_price($listing['products_id'], $listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']),1,$display_nb) : '') . '</span>';
              			}
             }
            }
                  break;
                // EZier New Fields added
          case 'PRODUCT_LIST_SAVE':
                 $lc_align = 'right';
                 if (tep_not_null($listing['specials_new_products_price'])) {
                    if ((tep_not_null($listing['products_retail_price'])) && ($listing['products_retail_price']) > 0) {
                     $lc_save = osc_ez($currencies->display_price_nodiscount(($listing['products_retail_price'] - $listing['specials_new_products_price']), tep_get_tax_rate($listing['products_tax_class_id']),1,$display_nb));     //Oszczedasz - wartosc kwotowa
                     $lc_text = '<font color="red">' . $lc_save . '</font>';
                  } else {
                     $lc_text = '&nbsp;';
                  }
                 } else {
                    if ((tep_not_null($listing['products_retail_price'])) && ($listing['products_retail_price']) > 0) {
                     $lc_save = osc_ez($currencies->display_price_nodiscount(($listing['products_retail_price'] - $listing['products_price']), tep_get_tax_rate($listing['products_tax_class_id']),1,$display_nb));     //Oszczedasz - wartosc kwotowa
                     $lc_text = '<font color="red">' . $lc_save . '</font>';
                  } else {
                     $lc_text = '&nbsp;';
                  }
                 }
                 break;
               // End EZier New Fields added
          case 'PRODUCT_LIST_QUANTITY':
            $lc_align = 'right';
            $lc_text = '&nbsp;' . $listing['products_quantity'] . '&nbsp;';
            break;
      //MAXIMUM quantity code
       case 'PRODUCT_LIST_MAXORDER':
            $lc_align = 'right';
            $lc_text = '&nbsp;' . $listing['products_maxorder'] . '&nbsp;';
            break;
      //End MAXIMUM quantity code
      case 'PRODUCT_LIST_WEIGHT':
            $lc_align = 'right';
            $lc_text = '&nbsp;' . $listing['products_weight'] . '&nbsp;';
            break;
      case 'PRODUCT_LIST_IMAGE':
            $lc_align = 'center';
            if (isset($HTTP_GET_VARS['manufacturers_id'])) {
              if (isset($listing['products_image'])){
                $lc_text = '<table class="dia" cellpadding="0" cellspacing="0" width="'.$szerokosc.'" height="'.$wysokosc.'"><tr><td><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], ALLPROD_IMAGE_WIDTH, ALLPROD_IMAGE_HEIGHT) . '</a></td></tr></table>';
			  }
            } else {
              if (isset($listing['products_image'])){
                $lc_text = '<table class="dia" cellpadding="0" cellspacing="0" width="'.$szerokosc.'" height="'.$wysokosc.'"><tr><td><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], ALLPROD_IMAGE_WIDTH, ALLPROD_IMAGE_HEIGHT) . '</a></td></tr></table>';
			  }
            }
            // Products Description Hack begins
            if (PRODUCT_LIST_DESCRIPTION > 0) {
             $lc_params = 'rowspan="2" ';
            }
            // Products Description Hack ends
            break;
      case 'PRODUCT_LIST_PRODUCTS_AVAILABILITY':
            $products_availability = $listing['products_availability_id'];
            $products_availability_info_query = tep_db_query("select e.products_availability_name from " . TABLE_PRODUCTS_AVAILABILITY . " e where e.products_availability_id = '" . (int)$products_availability . "' and e.language_id = '" . (int)$languages_id . "'");
            $products_availability_info = tep_db_fetch_array($products_availability_info_query);
            $lc_text = '' . $products_availability_info['products_availability_name'] . '&nbsp;';
            break;
      case 'PRODUCT_LIST_BUY_NOW':
            $lc_align = 'center';
            if ( $listing['products_quantity'] > 0 ) {
              $lc_text = (($listing['products_price'] > 0) ? '<form name="buy_now_' . $listing['products_id'] . '" method="post" action="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now', 'NONSSL') . '"><input type="hidden" name="products_id" value="' . $listing['products_id'] . '">' . tep_image_submit('shopping_cart.gif', TEXT_BUY . $listing['products_name'] . TEXT_NOW) . '</form> ' : '<b>'.tep_image_button('shopping_cart_sold.gif', TEMPORARY_NO_PRICE).'</b>'); 
            } else {
 		          if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
                $lc_text = ' '.tep_image_button('shopping_cart_sold.gif', PRODUCT_SOLD).'' ;
							} else {
								$lc_text = (($listing['products_price'] > 0) ? '<form name="buy_now_' . $listing['products_id'] . '" method="post" action="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now', 'NONSSL') . '"><input type="hidden" name="products_id" value="' . $listing['products_id'] . '">' . tep_image_submit('shopping_cart.gif', TEXT_BUY . $listing['products_name'] . TEXT_NOW) . '</form> ' : '<b>'.tep_image_button('shopping_cart_sold.gif', TEMPORARY_NO_PRICE).'</b>'); 
		         }
            }
            break;
  }

  // Products Description Hack begins
  $lc_params .= 'class="productListing-data"';
  if ($column_list[$col] == 'PRODUCT_LIST_DESCRIPTION') {
       $list_box_contents[$cur_row][] = array('align' => $lc_align,
                                                 'params' => $lc_params,
                                                 'text' => $lc_text,
                                                 'desc_flag' => 'true');
  } else {
       $list_box_contents[$cur_row][] = array('align' => $lc_align,
                                                 'params' => $lc_params,
                                                 'text'  => $lc_text);
  }
      // Products Description Hack ends
 }
    
 $rows++;
}

new productListingBox($list_box_contents);

?>