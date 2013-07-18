<?php
/*
  $Id: \includes\boxes\whats_new.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

  if ($random_product = tep_random_select("select distinct p.products_id, p.products_image, p.products_tax_class_id, p.products_price, p.products_retail_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_status=1 and p.products_id = p2c.products_id and c.categories_id = p2c.categories_id and c.categories_status=1 order by p.products_date_added desc limit " . MAX_RANDOM_SELECT_NEW)) {
  
    if (DISPLAY_PRICE_BRUTTO_NETTO == 'true') {
 	    $display_nb = 1;
 	  } else {
	    $display_nb = 0;
    }    

    $query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;
    $boxHeading = BOX_HEADING_WHATS_NEW;
    $corner_left = 'rounded';
    $corner_right = 'rounded';
    $boxContent_attributes = ' align="center"';

    $boxLink = '<a href="' . tep_href_link(FILENAME_PRODUCTS_NEW) . '">' .tep_image(DIR_WS_TEMPLATES . 'images/infobox/arrow_right.gif') .'</a>';
    $box_base_name = 'whats_new'; // for easy unique box template setup (added BTSv1.2)

    $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

	$random_product['products_name'] = tep_get_products_name($random_product['products_id']);
    $random_product['products_name'] = osc_trunc_string($random_product['products_name'], 50, 1);
    $random_product['specials_new_products_price'] = tep_get_products_special_price($random_product['products_id']);

	//TotalB2B start
    $random_product['products_price'] = tep_xppp_getproductprice($random_product['products_id']);
    //TotalB2B end

   if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
	  if (tep_not_null($random_product['specials_new_products_price'])) {
      //TotalB2B start
	  $random_product['specials_new_products_price'] = tep_get_products_special_price($random_product['products_id']);
      $query_special_prices_hide_result = SPECIAL_PRICES_HIDE;
      if ($query_special_prices_hide_result == 'true') {
		    $whats_new_price .= '<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id']),1,$display_nb) . '</span>';
	    } else {
		    $whats_new_price = '<s>' . $currencies->display_price($random_product['products_id'], $random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</s><br>';
            $whats_new_price .= '<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id']),1,$display_nb) . '</span>';
	    }
      //TotalB2B end
    } else {
	    $whats_new_price = (($random_product['products_price'] > 0) ? $currencies->display_price($random_product['products_id'], $random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id']),1,$display_nb) : '');
    }
   } else {
	  $whats_new_price = '<span class="smallText"><b>' .PRICES_LOGGED_IN_TEXT. '</b></span>';
   }

   if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
	  if ((NEW_FIELDS_WHATS_NEW == 'true') && ($random_product['products_retail_price'] != 0)) {
	    $whats_new_retail_price = $currencies->display_price($random_product['products_id'], $random_product['products_retail_price'], tep_get_tax_rate($random_product['products_tax_class_id']));
	    $retail = '<br><s>' . TEXT_PRODUCTS_RETAIL_PRICE_INFO . $whats_new_retail_price . '</s>';
	  } else {
	    $retail = '';
	  }
   } else {
	    $retail = '';
   }

  $szerokosc = SMALL_IMAGE_WIDTH + 6;
  $wysokosc = SMALL_IMAGE_HEIGHT + 7;
  $boxContent = '<table border="0" cellpadding="2" cellspacing="0" width="100%"><tr><td align="center">';

  if (isset($random_product['products_image'])){
  $boxContent .= '<div style="width: '.$szerokosc.'px; height: '.$wysokosc.'px; padding: 0px 0px;"><table border="0" cellpadding="0" cellspacing="0"><tr>';
  $boxContent .= '<td class="tbox1"></td>';
  $boxContent .= '<td class="tbox2"></td>';
  $boxContent .= '<td class="tbox3"></td>';
  $boxContent .= '</tr><tr>';
  $boxContent .= '<td class="tbox4"></td>';
  $boxContent .= '<td class="tbox5" align="center" valign="middle" height="'.SMALL_IMAGE_HEIGHT.'"  width="'.SMALL_IMAGE_WIDTH.'">';

    $boxContent .= '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>';

  $boxContent .= '</td><td class="tbox6"></td>';
  $boxContent .= '</tr><tr>';
  $boxContent .= '<td class="tbox7"></td>';
  $boxContent .= '<td class="tbox8"></td>';
  $boxContent .= '<td class="tbox9"></td>';
  $boxContent .= '</tr></table></div>';
  }

  $boxContent .= '</td></tr><tr><td>'.tep_draw_separator('pixel_trans.gif', '100%', '5').'</td></tr><tr><td class="smallText" align="center">';
  $boxContent .= '<a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">' . $random_product['products_name']. '<br>'. $retail. '<br>' . $whats_new_price.'</a><br>';
  
  $boxContent .= '</td></tr><tr><td class="smallText" align="center"><b><a class="boxLink" href="'.tep_href_link(FILENAME_PRODUCTS_NEW).'">'.WHATS_NEW_ALL.'</a></b>';
  
  $boxContent .= '</td></tr></table>';

    include (bts_select('boxes', $box_base_name)); // BTS 1.5

    $boxLink = '';
    $boxContent_attributes = '';

  }

?>