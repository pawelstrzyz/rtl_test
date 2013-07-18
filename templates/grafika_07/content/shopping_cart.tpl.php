<?php
/*
  $Id: \templates\standard\content\shopping_cart.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_SHOPPING_CART, 'action=update_product')); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
	<tr>  
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="22" height="40"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo HEADING_TITLE; ?></td>
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_right.gif" border="0" alt="" width="16" height="40"></td>	
	</tr>
 </table></td>
      </tr>	  
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <!-- Naglowek EOF -->

 <?php
 if ($cart->count_contents() > 0) {
 ?>
 <tr>
  <td>
   <?php
    $info_box_contents = array();
    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_REMOVE);

    $info_box_contents[0][] = array('params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_PRODUCTS);

    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_QUANTITY);

    $info_box_contents[0][] = array('align' => 'right',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_TOTAL);

    $any_out_of_stock = 0;
    $products = $cart->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {

     //MAXIMUM quantity code
     if(MAXIMUM_ORDERS == 'true'){
      $max_order_query = tep_db_query("select p.products_maxorder as max_quant FROM " . TABLE_PRODUCTS . " p where p.products_id = '".$products[$i]['id']."'");
      while ($max_order = tep_db_fetch_array($max_order_query))  {
       $products[$i]['max_quant']=$max_order['max_quant']; // set the cart item max var
       if (!empty($products[$i]['max_quant'])) {//add check account for if max_quant is null or '', if it is you can skip all this stuff can it's umlimited
        // okay if this product already is in basket irregardless of it's attributes selected... keep the old one
        for ($ic = 0; $ic < $i;$ic++) {
         if (tep_get_prid($products[$i]['id']) == tep_get_prid($products[$ic]['id'])) {
          $cart_notice .= sprintf(MAXIMUM_ORDER_DUPLICATE, $products[$i]["name"], $products[$i]["max_quant"]) . '<BR>'; // notify them they can not do that
          $cart_skip_prod = true;
          $cart->remove($products[$i]['id']); // remove this new item from the cart session
          $cart_skip_prod = true; // set a flag so we can bypass output of the item that was already stuck into the products array before we removed it just now
         } else {
          //$cart_notice .= ' - okay no match ';
         }
         $cart_notice .= '<BR>';
        }

        // okay now for products that have no attributes or have identical attributes
        if ($products[$i]['quantity'] > $max_order['max_quant'] ) { //add check account for if max_quant is null or '', if so let it go through.
         $products[$i]['quantity']=$products[$i]['max_quant'];
         $cart->add_cart($products[$i]['id'],$products[$i]['quantity'],$products[$i]['attributes']); // update the qty
         $cart_notice .= sprintf(MAXIMUM_ORDER_NOTICE, $products[$i]["name"], $products[$i]["max_quant"]); // notify them they can not do that
        }
       }
      }
     }

     if ($cart_skip_prod) { // still need to skip displaying the item still stuck in $products array even though we removed it from $cart
      break;
     }
     //End MAXIMUM quantity code

     // Push all attributes information in an array
     if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
      while (list($option, $value) = each($products[$i]['attributes'])) {
       echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
       $attributes = tep_db_query("select popt.products_options_name, popt.products_options_track_stock, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . (int)$products[$i]['id'] . "'
                                      and pa.options_id = '" . (int)$option . "'
                                      and pa.options_id = popt.products_options_id
                                      and pa.options_values_id = '" . (int)$value . "'
                                      and pa.options_values_id = poval.products_options_values_id
                                      and popt.language_id = '" . (int)$languages_id . "'
                                      and poval.language_id = '" . (int)$languages_id . "'");
       $attributes_values = tep_db_fetch_array($attributes);

       $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
       $products[$i][$option]['options_values_id'] = $value;
       $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
       $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
       $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
       $products[$i][$option]['track_stock'] = $attributes_values['products_options_track_stock'];
      }
     }
    }

    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
     if (($i/2) == floor($i/2)) {
      $info_box_contents[] = array('params' => 'class="productListing-even"');
     } else {
      $info_box_contents[] = array('params' => 'class="productListing-odd"');
     }

     $cur_row = sizeof($info_box_contents) - 1;

     $info_box_contents[$cur_row][] = array('align' => 'center',
                                            'params' => 'class="productListing-data" valign="top"',
                                            'text' => tep_draw_checkbox_field('cart_delete[]', $products[$i]['id']));

     $products_name = '<table border="0" cellspacing="2" cellpadding="2">' .
                                 ' <tr>' .
                                 '  <td class="productListing-data" align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">' . tep_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['name'], ALLPROD_IMAGE_WIDTH, ALLPROD_IMAGE_HEIGHT) . '</a></td>' .
                                 '  <td class="productListing-data" valign="top"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '"><b>' . $products[$i]['name'] . '</b></a>';

     if (STOCK_CHECK == 'true') {
//++++ QT Pro: Begin Changed code
        if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
          $stock_check = tep_check_stock($products[$i]['id'], $products[$i]['quantity'], $products[$i]['attributes']);
        }else{
          $stock_check = tep_check_stock($products[$i]['id'], $products[$i]['quantity']);
        }
//++++ QT Pro: End Changed Code
      if (tep_not_null($stock_check)) {
       $any_out_of_stock = 1;

       $products_name .= $stock_check;
      }
     }

     if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
      reset($products[$i]['attributes']);
      while (list($option, $value) = each($products[$i]['attributes'])) {
       $products_name .= '<br><small><i> - ' . $products[$i][$option]['products_options_name'] . ' ' . $products[$i][$option]['products_options_values_name'] . '</i></small>';
      }
     }

     $products_name .= '  </td>' .
                                  '</tr>' .
                                 '</table>';

     $info_box_contents[$cur_row][] = array('params' => 'class="productListing-data"',
                                             'text' => $products_name);

     $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => tep_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="4"') . tep_draw_hidden_field('products_id[]', $products[$i]['id']));

     //TotalB2B start
     $info_box_contents[$cur_row][] = array('align' => 'right',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => '<b>' . $currencies->display_price_nodiscount($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) . '</b>');
    }
    //TotalB2B end

    new productListingBox($info_box_contents);
  ?>
  </td>
 </tr>
 
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
 </tr>
 
 <tr>
  <td align="right" class="main"><b><?php echo SUB_TITLE_SUB_TOTAL; ?> <?php            
   
   //TotalB2B start
   global $customer_id;
   $query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;
   if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
    echo $currencies->format($cart->show_total()); 
   } else {
    echo PRICES_LOGGED_IN_TEXT;
   }
   //TotalB2B end

   ?>
   </b>
  </td>
 </tr>
 <?php
 if ($any_out_of_stock == 1) {
  if (STOCK_ALLOW_CHECKOUT == 'true') {
 ?>
 <tr>
  <td class="stockWarning" align="middle"><br><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></td>
 </tr>
 <?php
  } else {
 ?>
 <tr>
  <td class="stockWarning" align="middle"><br><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></td>
 </tr>
 <?php
  }
 }

 //MAXIMUM quantity code
 if ($cart_notice) {
 ?>
 <tr>
  <td class="stockWarning" align="middle"><br><?php echo $cart_notice; ?></td>
 </tr>
 <?php
 }
 // End MAXIMUM quantity code

 //BOF Minimalne zamowienie
 if (tep_session_is_registered('customer_id')) {
  $query = tep_db_query("select g.customers_groups_min_amount from " . TABLE_CUSTOMERS_GROUPS . " g inner join  " . TABLE_CUSTOMERS  . " c on g.customers_groups_id = c.customers_groups_id and c.customers_id = '" . $customer_id . "'");
  $query_result = tep_db_fetch_array($query);
  $customers_groups_min_amount = $query_result['customers_groups_min_amount'];
  if ($cart->show_total() < $customers_groups_min_amount) {
   ?>
   <tr>
    <td class="stockWarning" align="middle"><br><?php echo sprintf(TEXT_ORDER_UNDER_MIN_AMOUNT, $currencies->format($customers_groups_min_amount)); ?></td>
   </tr>
   <?php
  }
  } else {
  }
 //EOF Minimalne zamowienie
 ?>
 
 <!-- Przyciski BOF -->
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" cellspacing="0" cellpadding="2" align="left">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main"><?php echo tep_image_submit('button_update_cart.gif', IMAGE_BUTTON_UPDATE_CART); ?></td>
         <?php
         $back = sizeof($navigation->path)-2;
         if (isset($navigation->path[$back])) {
          ?>
          <td class="main"><?php echo '<a href="' . tep_href_link($navigation->path[$back]['page'], tep_array_to_string($navigation->path[$back]['get'], array('action')), $navigation->path[$back]['mode']) . '">' . tep_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; ?></td>
          <?php
          }
          ?>
        <td align="right" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . tep_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT) . '</a>'; ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 <!-- Przyciski EOF -->

 <?php
 } else {
 ?>
 
 <tr>
  <td align="center" class="main"><?php new infoBox(array(array('text' => TEXT_CART_EMPTY))); ?></td>
 </tr>

 <!-- Przyciski BOF -->
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td align="right" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 <!-- Przyciski BOF -->

 <?php
 }
 ?>
</table>
</form>