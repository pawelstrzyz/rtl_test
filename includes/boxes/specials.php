<?php
/*
  $Id: \includes\boxes\specials.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
   $query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;
   
   if (DISPLAY_PRICE_BRUTTO_NETTO == 'true') {
 	   $display_nb = 1;
 	  } else {
	   $display_nb = 0;
   }   
	 
   $boxHeading = BOX_HEADING_SPECIALS;
   $corner_left = 'rounded';
   $corner_right = 'rounded';
   $boxContent_attributes = ' align="center"';
   $szerokosc = SMALL_IMAGE_WIDTH+10;
   $wysokosc = SMALL_IMAGE_HEIGHT+10;

   $box_base_name = 'specials'; // for easy unique box template setup (added BTSv1.2)
   $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)
   $boxLink = '<a class="boxLink" href="' . tep_href_link(FILENAME_SPECIALS) . '">' .tep_image(DIR_WS_TEMPLATES . 'images/infobox/arrow_right.gif') .'</a>';

   //TotalB2B start
   if (!isset($customer_id)) $customer_id = 0;
     $boxContent = '';
     //$boxContent .= '<marquee behavior="scroll"
     //                   direction="up"
     //                   height="250"
     //                   width="170"
     //                   scrollamount="1"
     //                   scrolldelay="30"
     //                   truespeed="true" onmouseover="this.stop()" onmouseout="this.start()">';

     $customer_group = tep_get_customers_groups_id();
     $rp_query = tep_db_query("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c  where c.categories_status='1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p.products_status = '1' and p.products_id = s.products_id and pd.products_id = s.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' and ((s.customers_id = '" . $customer_id . "' and s.customers_groups_id = '0') or (s.customers_id = '0' and s.customers_groups_id = '" . $customer_group . "') or (s.customers_id = '0' and s.customers_groups_id = '0')) order by RAND() limit " . 1);
     if (tep_db_num_rows($rp_query)) {
       while ($random_product = tep_db_fetch_array($rp_query)) {

          $random_product['products_price'] = tep_xppp_getproductprice($random_product['products_id']);
          $random_product['specials_new_products_price'] = tep_get_products_special_price($random_product['products_id']);
          $query_special_prices_hide_result = SPECIAL_PRICES_HIDE;

          $boxContent .= '<table border="0" cellpadding="2" cellspacing="0" width="100%"><tr><td align="center">';

		  if ($random_product['products_image'] != ''){
  				$boxContent .= '<table class="dia" cellpadding="0" cellspacing="0">';
  				$boxContent .= '<tr><td width="'.$szerokosc.'" height="'.$wysokosc.'">';
                $boxContent .= '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product["products_id"]) . '">' . tep_image(DIR_WS_IMAGES . $random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>';
  				$boxContent .= '</td></tr></table>';
          }

		  $boxContent .= '</td></tr><tr><td>'.tep_draw_separator('pixel_trans.gif', '100%', '5').'</td></tr><tr><td class="smallText" align="center">';
  
          if ($query_special_prices_hide_result == 'true') {
            $boxContent .= '<a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">' . osc_trunc_string($random_product['products_name'], 50, 1) . '</a><br><span class="productSpecialPrice">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id']),1,$display_nb) . '</span>';
          } else {
            if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
              $boxContent .= '<a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">' . osc_trunc_string($random_product['products_name'], 50, 1) . '</a><br><s>' . $currencies->display_price($random_product['products_id'], $random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id']),1,$display_nb) . '</span>';
            } else {
              $boxContent .= '<a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">' . osc_trunc_string($random_product['products_name'], 50 ,1) . '</a><br><span class="smallText"><b>' .PRICES_LOGGED_IN_TEXT. '</b></span>';
            }
         }

         $boxContent .= '</td></tr><tr><td class="smallText" align="center"><b><a class="boxLink" href="'.tep_href_link(FILENAME_SPECIALS).'">'.WHATS_NEW_ALL.'</a></b>';
         $boxContent .= '</td></tr></table>';
       }
       //$boxContent .= '</marquee>';
       include (bts_select('boxes', $box_base_name)); // BTS 1.5
     }

    $boxLink = '';

    $boxContent_attributes = '';

?>