<?php
   $star_products_query = tep_db_query("select substring(pd.products_description, 1, 450) as products_description, p.products_id, p.products_image, p.manufacturers_id, p.products_price, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price, p.products_tax_class_id, sp.products_id, sp.status, sp.expires_date from (" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_STAR_PRODUCT . " sp, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c) left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id where p.products_id = p2c.products_id and c.categories_id = p2c.categories_id and c.categories_status='1' and p.products_id = pd.products_id and p.products_status = '1' and pd.products_description != '' and sp.status = '1' and p.products_id=sp.products_id and pd.language_id = '" . $languages_id . "' ORDER BY rand() limit 1");
   $star_products = tep_db_fetch_array($star_products_query);

if (tep_db_num_rows($star_products_query) > 0) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="0" class="templateinfoBox" align="Center">
	<tr>  
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="22" height="40"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo STAR_TITLE; ?></td>
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_right.gif" border="0" alt="" width="16" height="40"></td>
    </tr>
<table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <tr>
  <td>
   <?php

   function tep_star_product_with_attributes($products_id) {
   $attributes_query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$products_id . "'");
   $attributes = tep_db_fetch_array($attributes_query);

   if ($attributes['count'] > 0) {
    return true;
   } else {
    return false;
   }
   }

   $star_products['products_name'] = tep_get_products_name($star_products['products_id']);

   $evita_cortar_palabras = explode( ' ',  $star_products["products_description"] );
   array_pop( $evita_cortar_palabras );
   $star_products["products_description"]  = implode( ' ', $evita_cortar_palabras ); 
   
   if (DISPLAY_PRICE_BRUTTO_NETTO == 'true') {
	   $display_nb = 1;
	  } else {
	   $display_nb = 0;
   }   

   if (!tep_star_product_with_attributes($star_products['products_id'])) {
      $star_products['products_price'] = tep_xppp_getproductprice($star_products['products_id']);
      $star_price = $currencies->display_price($star_products['products_id'], $star_products['products_price'], tep_get_tax_rate($star_products['products_tax_class_id']),1,$display_nb);
   } else {
      $star_price = $currencies->display_price_nodiscount($star_products['products_price'], tep_get_tax_rate($star_products['products_tax_class_id']),1,$display_nb);
   }

   $tab_szer = SMALL_IMAGE_WIDTH*1.2+24;
  $szerokosc = SMALL_IMAGE_WIDTH*1.2 + 10;
  $wysokosc = SMALL_IMAGE_HEIGHT*1.2 + 10;

   $star_products["0"] = array('align' => 'center',
                              'params' => 'valign="top"',
                              'text' => '
      <table border="0" width="100%" cellspacing="0" cellpadding="5" class="templateinfoBox">
       <tr>
        <td>
         <table border="0" cellspacing="0" cellpadding="0" align="right" width="100%">
            <tr>
             <td valign="top">
              <table border="0" cellspacing="0" cellpadding="3" width="100%" align="center">
                 <tr>
                  <td height="25" class="star-product-title">' . $star_products['products_name'] . '</td>
                   <td  align="center" valign="middle" height="100%" rowspan="4">' .
                    (($star_products['products_image'] != '') ? '<table class="dia" cellpadding="0" cellspacing="0"><tr>
										 <td width="'.$szerokosc.'" height="'.$wysokosc.'">' . tep_image(DIR_WS_IMAGES . $star_products['products_image'], $star_products['products_name'], SMALL_IMAGE_WIDTH*1.2, SMALL_IMAGE_HEIGHT*1.2) . '
										 </td></tr></table>' : '').'</td>
                  </tr>
                  <tr>
                   <td height="80%" class="star-product" valign="top">'. strip_tags($star_products["products_description"]) . '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, "products_id=" . $star_products["products_id"]). '">' . STAR_READ_MORE . '</a></td>
                  </tr>
			
                  <tr>
                   <td height="35" class="ps3" align="left">'. ITEM_PRICE . '<span class=star-product-price>'.$star_price . '</span></td>
                  </td>
                 </tr>
               <tr>
                <td align="center">
                 <table border="0" cellspacing="0" cellpadding="1" width="100%">
                  <tr>
                   <td align="center" width="100%" height="28" class="Button"><a class="ProductDescripion" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $star_products["products_id"]) . '">'.tep_image_button('small_view.gif').'</a>&nbsp;&nbsp;'
                   . (($star_products['products_price'] > 0) ? '<form name="buy_now_' . $star_products['products_id'] . '" method="post" action="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now', 'NONSSL') . '"><input type="hidden" name="products_id" value="' . $star_products['products_id'] . '"><input type="hidden" name="quantity" value="1">' . tep_image_submit('do_koszyka.gif', IMAGE_BUTTON_IN_CART . ' ' . $star_products['products_name']) . '</form>'  : '').'</td>
                  </tr>
                 </table>
                </td>
               </tr>
              </table>
             </td>
            </tr>
           </table>
        </td>
       </tr>
      </table>');

    $star_products_output = array_slice($star_products, sizeof($star_products)-1);
    
	new contentBoxindex($star_products_output);
   ?>
  </td></tr></table>
<?php } ?>