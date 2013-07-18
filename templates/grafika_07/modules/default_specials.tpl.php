<table border="0" width="100%" cellspacing="0" cellpadding="0" class="templateinfoBox">
	<tr>  
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="22" height="40"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo BOX_HEADING_SPECIALS; ?></td>
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_right.gif" border="0" alt="" width="16" height="40"></td>	
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
$col = 0;

  echo '
                      <table cellspacing=0 cellpadding=0>
                       <tr><td></td></tr>
                       <tr><td height=8></td></tr>
                       <tr><td class=bg>
                            <table cellspacing=0 cellpadding=0>
                             <tr>
       ';
while ($default_specials = tep_db_fetch_array($default_specials_query)) {
    $default_specials['products_name'] = tep_get_products_name($default_specials['products_id']);
    $default_specials['products_name'] = osc_trunc_string($default_specials['products_name'], 50, 1);
   $product_query = tep_db_query("select products_description  from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$default_specials['products_id'] . "' and language_id = '" . (int)1 . "'");
   $product = tep_db_fetch_array($product_query);
   $default_specials['products_description'] = $product['products_description'];
	if ($default_specials['products_quantity']  > 0) {
		if ($default_specials['products_price'] > 0) {
			$przcisk_kup = '<form name="buy_now_' . $default_specials['products_id'] . '" method="post" action="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now', 'NONSSL') . '"><input type="hidden" name="products_id" value="' . $default_specials['products_id'] . '"><input type="hidden" name="quantity" value="1">' . tep_image_submit('button_buy_now.gif', IMAGE_BUTTON_IN_CART . ' ' . $default_specials['products_name']) . '</form>';
		} else {
			$przcisk_kup = '';
		}
	} else {
		if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
			$przcisk_kup = ' '.tep_image_button('button_sold.gif').'';
		} else {
			$przcisk_kup = '<form name="buy_now_' . $default_specials['products_id'] . '" method="post" action="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now', 'NONSSL') . '"><input type="hidden" name="products_id" value="' . $default_specials['products_id'] . '"><input type="hidden" name="quantity" value="1">' . tep_image_submit('button_buy_now.gif', IMAGE_BUTTON_IN_CART . ' ' . $default_specials['products_name']) . '</form>';
		}
	}

    if (DISPLAY_PRICE_BRUTTO_NETTO == 'true') {
 	    $display_nb = 1;
 	  } else {
	    $display_nb = 0;
    }	
	
    //TotalB2B start
    if ($new_price = tep_get_products_special_price($default_specials['products_id']) ) {
        $default_specials_org['products_price'] = tep_xppp_getproductprice($default_specials['products_id']);
        $default_specials['products_price'] = $new_price;

        if ($default_specials['products_price'] > 0) {
            if ($special_hide == 'false') {
               $query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;
               if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
                  $cena_produktu = '<span class="smallText">'. TABLE_HEADING_PRICE . ':&nbsp;<span class="smallText"><s>' . $currencies->display_price($default_specials['products_id'], $default_specials_org['products_price'], tep_get_tax_rate($default_specials['products_tax_class_id'])) . '</s></span><br><span class="productSpecialPrice">' . $currencies->display_price_nodiscount($default_specials['products_price'],tep_get_tax_rate($default_specials['products_tax_class_id']),1,$display_nb) .'</span>';
               } else {
                  $cena_produktu = '<span class="smallText">'. TABLE_HEADING_PRICE . ':</span><br><span class="Cena">' . PRICES_LOGGED_IN_TEXT . '</span>';
               }
           } else {
                $cena_produktu = '<span class="Cena">' . $currencies->display_price($default_specials['products_id'], $default_specials_org['products_price'], tep_get_tax_rate($default_specials['products_tax_class_id']),1,$display_nb) .'</span>';
            }
        } else {
             $cena_produktu = '<span class="smallText"><b>'.TEMPORARY_NO_PRICE.'</b></span>';
        }
    } else {
        $default_specials['products_price'] = tep_xppp_getproductprice($default_specials['products_id']);
        if ($default_specials['products_price'] > 0) {
            $cena_produktu = '<span class="smallText">'. TABLE_HEADING_PRICE . ':<br></span><span class="Cena">' . $currencies->display_price($default_specials['products_id'],$default_specials['products_price'],tep_get_tax_rate($default_specials['products_tax_class_id']),1,$display_nb).'</span>';
        } else {
            $cena_produktu = '<span class="smallText"><b>'.TEMPORARY_NO_PRICE.'</b></span>';
        }
    }
    //TotalB2B end & TotalB2B end

    echo '
                             <td width=255 valign=top>
                                  <table border=0  cellspacing=0 cellpadding=0 width=230 align=center>
                                   <tr><td width=140 valign=top><br><b><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $default_specials['products_id']) . '">' . $default_specials['products_name'] . '</a></b><br><br><br><span class=ps3>'.$cena_produktu .'</span><br><br></td>
                                   <td><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $default_specials['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $default_specials['products_image'], $default_specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></td></tr>

								   <tr><td colspan=2 height=6></td></tr>
                                   <tr><td colspan=2><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $default_specials["products_id"]) . '">'.tep_image_button('small_view.gif').'</a>&nbsp;' .$przcisk_kup.'</td></tr>
                                   <tr><td colspan=2 height=6></td></tr>
                                  </table>
                                 </td>
        ';
    $col ++;
    if ($col > 1) {
      $col = 0;
      $row ++;
      echo '                                 
                             </tr>
                             <tr><td colspan=3 align=center><img src=templates/grafika_07/images/m24.gif width=535 height=1></td></tr>
                             <tr>
           ';
    } else echo '<td width=1></td>';
  }
  echo '
                             </tr>                             
                            </table>
       ';
?>
   </tr>
   </table>
  </td>
 </tr>
</table>