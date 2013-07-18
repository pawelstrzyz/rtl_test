<?php
/*
  $Id: \includes\boxes\shopping_cart.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
  global $customer_id;
  
  $boxHeading = BOX_HEADING_SHOPPING_CART;
  $corner_left = 'rounded';
  $corner_right = 'rounded';
  $boxLink = '<a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' .tep_image(DIR_WS_TEMPLATES . 'images/infobox/arrow_right.gif') .'</a>';

  $box_base_name = 'shopping_cart'; // for easy unique box template setup (added BTSv1.2)
  $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)
	  
  $boxContent = '';
  if ($cart->count_contents() > 0) {

    if (DISPLAY_PRICE_BRUTTO_NETTO == 'true') {
 	   $display_nb = 1;
 	  } else {
	   $display_nb = 0;
    }    

    $boxContent = '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
    $products = $cart->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      $boxContent .= '<tr><td align="right" valign="top" class="boxContents">';

      if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
        $boxContent .= '<span class="newItemInCart">';
      } else {
        $boxContent .= '<span class="boxContents">';
      }

      $products_tax = tep_get_tax_rate($products[$i]['tax_class_id']);

			$cost = $currencies->display_price_nodiscount($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity'], $display_nb);
			$cost_netto = $currencies->display_price_nodiscount($products[$i]['final_price'], 0, $products[$i]['quantity'], $display_nb);

//      $cost = (tep_add_tax($products[$i]['final_price'], $products_tax) * $products[$i]['quantity']). '';
// 	    $cost_netto = (tep_add_tax($products[$i]['final_price'], 0) * $products[$i]['quantity']). '';

      $boxContent .= $products[$i]['quantity'] . '&nbsp;x&nbsp;</span></td><td valign="top" class="boxContents"><a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">';
      
      if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
        $boxContent .= '<span class="newItemInCart">';
      } else {
        $boxContent .= '<span class="boxContents">';
      }

      $boxContent .= $products[$i]['name'] ;
      $boxContent .= '<td align="right" valign="top" class="boxContents">';

      $query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;
      if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
	    if (DISPLAY_PRICE_BRUTTO_NETTO == 'true') {
		     $boxContent .= '<nobr>' . $cost_netto . '</nobr><br>' . '<span class="smallText">'.TEXT_NETTO.'</span><br>';
			 $boxContent .= '<nobr>' . $cost . '</nobr><br>' . '<span class="smallText">'.TEXT_BRUTTO.'</span>';
	 	  } else {
	        $boxContent .= '<nobr>' . $cost . '</nobr>';
	    }  	  
      } else {
       $boxContent .= '';
      }
      $boxContent .= '</span></a></td></tr>';

      if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
        tep_session_unregister('new_products_id_in_cart');
      }
    }
    $boxContent .= '</table>';
  } else {
    $boxContent .= '<span class="boxContents">&nbsp;&nbsp;&nbsp;'.BOX_SHOPPING_CART_EMPTY.'</span>';
  }

  //TotalB2B start
  $query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;
  if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
      if (DISPLAY_PRICE_BRUTTO_NETTO == 'true') {
         $box_text = $currencies->format($cart->show_total_netto()) . '<span class="smallText">'.TEXT_NETTO.'</span><br>' .
			   $currencies->format($cart->show_total()) . '<span class="smallText">'.TEXT_BRUTTO.'</span>';
 	    } else {
          $box_text = $currencies->format($cart->show_total()); 
      }    
  } else {
      $box_text = PRICES_LOGGED_IN_TEXT;
  }
  if ($cart->count_contents() > 0) {
    $boxContent .= tep_draw_separator();
    $boxContent .= '<div align="right" class="boxContents">' . $box_text . '</div>';
	$boxContent .= '<br><center><a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . tep_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT) . '</a></center>';
  }
  //TotalB2B end

  include (bts_select('boxes', $box_base_name)); // BTS 1.5
  $boxLink = '';

?>