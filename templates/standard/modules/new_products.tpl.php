<table border="0" width="100%" cellspacing="0" cellpadding="0" class="templateinfoBox">
	<tr>  
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo NEW_PRODUCTS; ?></td>
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_left.gif" border="0" alt="" width="30" height="35"></td>	
    </tr>
<table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <tr>
  <td>
 <tr>
  <td class="modulesBox" align="center">
   <table border="0" width="100%" cellspacing="0" cellpadding="1">
   <tr>

<?php
$tab_wys = SMALL_IMAGE_HEIGHT+10;
$tab_szer = SMALL_IMAGE_WIDTH+10;

$szerokosc = SMALL_IMAGE_WIDTH + 6;
$wysokosc = SMALL_IMAGE_HEIGHT + 7;

$row = 0;
$col = 1;
$info_box_contents = array();

while ($new_products = tep_db_fetch_array($new_products_query)) {
    $new_products['products_name'] = tep_get_products_name($new_products['products_id']);
    $new_products['products_name'] = osc_trunc_string($new_products['products_name'], 50, 1);

	if ($new_products['products_quantity']  > 0) {
		if ($new_products['products_price'] > 0) {
			$przcisk_kup = '<form name="buy_now_' . $new_products['products_id'] . '" method="post" action="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now', 'NONSSL') . '"><input type="hidden" name="products_id" value="' . $new_products['products_id'] . '"><input type="hidden" name="quantity" value="1">' . tep_image_submit('button_buy_now.gif', IMAGE_BUTTON_IN_CART . ' ' . $new_products['products_name']) . '</form>';
		} else {
			$przcisk_kup = '';
		}
	} else {
		if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
			$przcisk_kup = ' '.tep_image_button('button_sold.gif').'';
		} else {
			$przcisk_kup = '<form name="buy_now_' . $new_products['products_id'] . '" method="post" action="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now', 'NONSSL') . '"><input type="hidden" name="products_id" value="' . $new_products['products_id'] . '"><input type="hidden" name="quantity" value="1">' . tep_image_submit('button_buy_now.gif', IMAGE_BUTTON_IN_CART . ' ' . $new_products['products_name']) . '</form>';
		}
	}
	
    if (DISPLAY_PRICE_BRUTTO_NETTO == 'true') {
	    $display_nb = 1;
	  } else {
	    $display_nb = 0;
    }	

    //TotalB2B start
    if ($new_price = tep_get_products_special_price($new_products['products_id']) ) {
        $new_products_org['products_price'] = tep_xppp_getproductprice($new_products['products_id']);
        $new_products['products_price'] = $new_price;

        if ($new_products['products_price'] > 0) {
            if ($special_hide == 'false') {
               $query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;
               if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
                  $cena_produktu = '<span class="smallText">'. TABLE_HEADING_PRICE . ':</span>&nbsp;<span class="smallText"><s>' . $currencies->display_price($new_products['products_id'], $new_products_org['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</s></span><br><span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_products['products_price'],tep_get_tax_rate($new_products['products_tax_class_id']),1,$display_nb) .'</span>';
               } else {
                  $cena_produktu = '<span class="smallText">'. TABLE_HEADING_PRICE . ':</span><br><span class="Cena">' . PRICES_LOGGED_IN_TEXT . '</span>';
               }
           } else {
                $cena_produktu = '<span class="Cena">' . $currencies->display_price($new_products['products_id'], $new_products_org['products_price'], tep_get_tax_rate($new_products['products_tax_class_id']),1,$display_nb) .'</span>';
            }
        } else {
             $cena_produktu = '<span class="smallText"><b>'.TEMPORARY_NO_PRICE.'</b></span>';
        }
    } else {
        $new_products['products_price'] = tep_xppp_getproductprice($new_products['products_id']);
        if ($new_products['products_price'] > 0) {
            $cena_produktu = '<span class="smallText">'. TABLE_HEADING_PRICE . ':</span><br><span class="Cena">' . $currencies->display_price($new_products['products_id'],$new_products['products_price'],tep_get_tax_rate($new_products['products_tax_class_id']),1,$display_nb).'</span>';
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
         <td align="center" valign="top" height="35">
          <a class="ProductTile" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . $new_products['products_name'] . '</a>
         </td>
        </tr>
        <tr>
         <td align="center" valign="middle">
          <table border="0" cellspacing="0" cellpadding="0">
           <tr>
           <td align="center" valign="top">'.
	       (isset($new_products['products_image']) ? '
           <div style="background-color: #FFFFFF; border: 0px; width: '.$szerokosc.'px; height: '.$wysokosc.'px; padding: 0px 0px;">
           <table border="0" cellpadding="0" cellspacing="0"><tr>
            <td class="t1"></td>
            <td class="t2"></td>
            <td class="t3"></td>
            </tr><tr>
            <td class="t4"></td>
            <td class="t5" align="center" valign="middle" height="'.SMALL_IMAGE_HEIGHT.'px" width="'.SMALL_IMAGE_WIDTH.'px">
             <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>
            </td><td class="t6"></td>
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
            <td align="center" width="50%" height="28" class="Button"><a class="ProductDescripion" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products["products_id"]) . '">'.tep_image_button('small_view.gif').'</a></td>
            <td align="center" width="50%" class="Button">' .$przcisk_kup.'</td>
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
   </tr>
   </table>
  </td>
 </tr>
</table>

