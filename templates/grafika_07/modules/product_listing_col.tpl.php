<?php
$tab_wys = SMALL_IMAGE_HEIGHT+10;
$tab_szer = SMALL_IMAGE_WIDTH+10;

$szerokosc = SMALL_IMAGE_WIDTH + 6;
$wysokosc = SMALL_IMAGE_HEIGHT + 7;

$row = 0;
$col = 1;
$info_box_contents = array();

while ($listing = tep_db_fetch_array($listing_query)) {
	$listing['products_name'] = tep_get_products_name($listing['products_id']);
    $listing['products_name'] = osc_trunc_string($listing['products_name'], 50, 1);


	if ($listing['products_quantity']  > 0) {
		if ($listing['products_price'] > 0) {
			$przcisk_kup = '<form name="buy_now_' . $listing['products_id'] . '" method="post" action="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now', 'NONSSL') . '"><input type="hidden" name="products_id" value="' . $listing['products_id'] . '">' . tep_image_submit('button_buy_now.gif', IMAGE_BUTTON_IN_CART . ' ' . $listing['products_name']) . '</form>';
		} else {
			$przcisk_kup = '';
		}
	} else {
		if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
			$przcisk_kup = ' '.tep_image_button('button_sold.gif').'';
		} else {
			$przcisk_kup = '<form name="buy_now_' . $listing['products_id'] . '" method="post" action="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now', 'NONSSL') . '"><input type="hidden" name="products_id" value="' . $listing['products_id'] . '">' . tep_image_submit('button_buy_now.gif', IMAGE_BUTTON_IN_CART . ' ' . $listing['products_name']) . '</form>';
		}
	}


    //TotalB2B start
    if ($new_price = tep_get_products_special_price($listing['products_id']) ) {
        $listing_org['products_price'] = tep_xppp_getproductprice($listing['products_id']);
        $listing['products_price'] = $new_price;

        if ($listing['products_price'] > 0) {
            if ($special_hide == 'false') {
               $query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;
               if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
                  $cena_produktu = '<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($listing['products_price'],tep_get_tax_rate($listing['products_tax_class_id'])) .'</span>';
               } else {
                  $cena_produktu = '<span class="smallText">' . PRICES_LOGGED_IN_TEXT . '</span>';
               }
           } else {
                $cena_produktu = '<span class="Cena">' . $currencies->display_price($listing['products_id'], $listing_org['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) .'</span>';
            }
        } else {
             $cena_produktu = '<span class="smallText"><b>'.TEMPORARY_NO_PRICE.'</b></span>';
        }
    } else {
        $listing['products_price'] = tep_xppp_getproductprice($listing['products_id']);
        if ($listing['products_price'] > 0) {
            $cena_produktu = '<span class="Cena">' . $currencies->display_price($listing['products_id'],$listing['products_price'],tep_get_tax_rate($listing['products_tax_class_id'])).'</span>';
        } else {
            $cena_produktu = '<span class="smallText"><b>'.TEMPORARY_NO_PRICE.'</b></span>';
        }
    }
    //TotalB2B end & TotalB2B end

    echo '
    <td width="'.$szer_tab.'%" align="center" valign="top">
     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="TableFrame">
      <tr>
       <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
         <tr>
          <td align="center" valign="top" height="35">';
            if (isset($HTTP_GET_VARS['manufacturers_id'])) {
              echo '<a class="ProductTile" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">' . osc_trunc_string($listing['products_name'],50, 1) . '</a>';
            } else {
              echo '<a class="ProductTile" href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">' . osc_trunc_string($listing['products_name'], 50, 1) . '</a>';
            }
           echo '</td>
         </tr>
         <tr>
          <td align="center" valign="middle">
           <table border="0" cellspacing="0" cellpadding="0">
            <tr>
             <td align="center" valign="top">'.
	          (isset($listing['products_image']) ? '
              <div style="background-color: #FFFFFF; border: 0px; width: '.$szerokosc.'px; height: '.$wysokosc.'px; padding: 0px 0px;">
              <table border="0" cellpadding="0" cellspacing="0"><tr>
               <td class="t1"></td>
               <td class="t2"></td>
               <td class="t3"></td>
               </tr><tr>
               <td class="t4"></td>
               <td class="t5" align="center" valign="middle" height="'.SMALL_IMAGE_HEIGHT.'px" width="'.SMALL_IMAGE_WIDTH.'px">'.
               (isset($HTTP_GET_VARS['manufacturers_id']) ?
                  '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>' :
                  '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>'
               )
               .'</td><td class="t6"></td>
               </tr><tr>
               <td class="t7"></td>
               <td class="t8"></td>
               <td class="t9"></td>
               </tr></table></div>' : '').'
               </td></tr><tr><td>'.tep_draw_separator('pixel_trans.gif', '100%', '5').'</td></tr><tr><td  align="center" valign="middle" height="30">'.$cena_produktu .'</td>
              </tr>
             </table>
            </td>
           </tr>
           <tr>
            <td align="center">
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td align="center" width="50%" height="28" class="Button">';
                 if (isset($HTTP_GET_VARS['manufacturers_id'])) {
                  echo '<a class="ProductTile" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">'.tep_image_button('small_view.gif').'</a>';
                 } else {
                  echo '<a class="ProductTile" href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">'.tep_image_button('small_view.gif').'</a>';
                 }
               echo '<td align="center" width="50%" class="Button">' .$przcisk_kup.'</td>
              </tr>
             </table>
            </td>
           </tr>
          </table>
         </td>
        </tr>
       </table>
  </td>';

    $col ++;
    if ($col > $ilosc_col) {
		$span= 0;
        $col = 1;
        $row ++;
		    $span = ($ilosc_col * 2) - 1;
        if ($row < $max_wiersz) {
          echo '
          </tr>
          <tr>
           <td colspan="'.$span.'" width="100%" height="5"></td>
          </tr>
          <tr>';
        } else {
          echo '
          '
          ;
        }
	  } else {
		echo '
        <td width="5" height="100%">'.tep_draw_separator('pixel_trans.gif', '5', '1').'</td>';
    }
}

?>