<?php
/*
  $Id: \templates\standard\content\checkout_confirmation.tpl.php; 10.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

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
      
 <tr>
  <td class="subTileModule"><b><?php echo HEADING_SHIPPING_INFORMATION; ?></b></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="0" class="">
    <tr class="infoBoxContents">
     <?php
     if ($sendto != false) {
     ?>
     <td width="100%" valign="top">
	    <table border="0" width="100%" cellspacing="1" cellpadding="3">
       <tr>
        <td valign="top" width="30%" class="ProductHead"><?php echo '<b>' . HEADING_DELIVERY_ADDRESS . '</b>' . (($customer_id>0 || (defined('PURCHASE_WITHOUT_ACCOUNT_SEPARATE_SHIPPING') && PURCHASE_WITHOUT_ACCOUNT_SEPARATE_SHIPPING=='true') )? ' <a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL') . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>':''); ?></td>
        <td class="ProductHead" valign="top" width="70%"><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br>'); ?></td>
       </tr>

       <tr>
        <td valign="top" width="30%" class="ProductHead"><?php echo '<b>' . HEADING_BILLING_ADDRESS . '</b> <a href="' . (($customer_id==0)?tep_href_link(FILENAME_CREATE_ACCOUNT, 'guest=guest', 'SSL'):tep_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL')) . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>
        <td class="ProductHead" valign="top" width="70%"><?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br>'); ?></td>
       </tr>

       <?php
       if ($order->info['shipping_method']) {
       ?>
       <tr>
        <td valign="top" width="30%" class="ProductHead"><?php echo '<b>' . HEADING_SHIPPING_METHOD . '</b> <a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>
        <td class="ProductHead" valign="top" width="70%"><?php echo $order->info['shipping_method']; ?></td>
       </tr>
       <?php
       }
       ?>

       <tr>
        <td valign="top" width="30%" class="ProductHead"><?php echo '<b>' . HEADING_PAYMENT_METHOD . '</b> <a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>
        <td class="ProductHead" valign="top" width="70%"><?php echo $order->info['payment_method']; ?></td>
       </tr>

       <?php
       if ($order->info['giftwrap_method']) {
       ?>
       <tr>
        <td class="ProductHead" valign="top" width="30%"><b><?php echo HEADING_GIFTWRAP_METHOD; ?></b></td>
        <td class="ProductHead" valign="top" width="70%"><?php echo $order->info['giftwrap_method']; ?></td>
       </tr>
       <?php
       }
       ?>
      </table>
	   </td>
     <?php
     }
     ?>
     </tr>
   </table>
  </td>
 </tr>
 
 <tr>
  <td class="subTileModule"><b><?php echo HEADING_PRODUCTS_INFORMATION; ?></b></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
     <tr class="infoBoxContents">
	    <td width="<?php echo (($sendto != false) ? '70%' : '100%'); ?>" valign="top">
       <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
         <td>
	        <table border="0" width="100%" cellspacing="1" cellpadding="2">
          <?php
          if (sizeof($order->info['tax_groups']) > 1) {
          ?>
          <tr>
           <td class="subTileModule" colspan="2"><?php echo '<b>' . HEADING_PRODUCTS . '</b> <a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>
           <td class="smallText" align="right"><b><?php echo HEADING_TAX; ?></b></td>
           <td class="smallText" align="right"><b><?php echo HEADING_TOTAL; ?></b></td>
          </tr>

		      <?php
          } else {
          ?>
  		    <tr>
           <td class="main" colspan="3"><?php echo '<b>' . HEADING_PRODUCTS . '</b> <a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>
          </tr>
          <?php
          }
?>
          <tr>
           <td class="ProductHead" align="center"><b><?php echo HEADING_PRODUCT; ?></b></td>
           <td class="ProductHead" align="center"><b><?php echo HEADING_QTY; ?></b></td>
           <td class="ProductHead" align="right"><b><?php echo HEADING_WARTOSC; ?></b></td>
<?php
          for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
           echo '          <tr>' . "\n" .
                '           <td class="main" valign="top" width="70%">' . $order->products[$i]['name'] . "\n";
           if (STOCK_CHECK == 'true') {
            //++++ QT Pro: Begin Changed code
            echo $check_stock[$i];
            //++++ QT Pro: End Changed Code
           }

           if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
            for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
             echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '</i></small></nobr>';
            }
           }

           echo '           </td>' . "\n";
           echo '           <td class="main" align="center" valign="top" width="5%">' . $order->products[$i]['qty'] . '</td>';


           if (sizeof($order->info['tax_groups']) > 1) {
		        echo '          <td class="main" valign="top" align="right" width="25%">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n";
		       }

           //TotalB2B start
           echo '           <td class="main" align="right" valign="top" width="25%">' . $currencies->display_price_nodiscount($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . '</td>' . "\n" .'          </tr>' . "\n";
           //TotalB2B end
          }
          ?>
          </table>
	       </td>
        </tr>
       </table>
	    </td>
     </tr>



    <tr class="infoBoxContents">
     <td width="100%" valign="top" align="right">
	    <table border="0" cellspacing="0" cellpadding="2">
      <?php
      if (MODULE_ORDER_TOTAL_INSTALLED) {
       echo $order_total_modules->output();
      }
      ?>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>



 
 <?php
 if (is_array($payment_modules->modules)) {
  if ($confirmation = $payment_modules->confirmation()) {
   $payment_info = $confirmation['title'];
   if (!tep_session_is_registered('payment_info')) tep_session_register('payment_info');
 ?>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <tr>
  <td class="subTileModule"><b><?php echo HEADING_PAYMENT_INFORMATION; ?></b></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" cellspacing="0" cellpadding="2">
       <tr>
        <td class="main" colspan="4"><?php echo $confirmation['title']; ?></td>
       </tr>
       <?php
       for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) {
       ?>
        <tr>
         <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
         <td class="main"><?php echo $confirmation['fields'][$i]['title']; ?></td>
         <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
         <td class="main"><?php echo $confirmation['fields'][$i]['field']; ?></td>
        </tr>
       <?php
       }
       ?>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 <?php
 }
 }
 ?>
 
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <?php
 if (tep_not_null($order->info['comments'])) {
 ?>
 <tr>
  <td class="subTileModule"><?php echo '<b>' . HEADING_ORDER_COMMENTS . '</b> <a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>
 </tr>
 
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td class="main"><?php echo nl2br(tep_output_string_protected($order->info['comments'])) . tep_draw_hidden_field('comments', $order->info['comments']); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 
 <?php
 }
 ?>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
 </tr>
 
 <!-- Przyciski BOF -->
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', ''); ?></td>         
        <td align="left" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT) . '">' . tep_image_button('button_back.gif', 'back') . '</a>'; ?> </td>
        <td align="right" class="main">
         <?php
         if (isset($$payment->form_action_url)) {
          $form_action_url = $$payment->form_action_url;
         } else {
          $form_action_url = tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
         }

         echo tep_draw_form('checkout_confirmation', $form_action_url, 'post');

         if (is_array($payment_modules->modules)) {
          echo $payment_modules->process_button();
         }

         echo tep_image_submit('button_confirm_order.gif', IMAGE_BUTTON_CONFIRM_ORDER) . '</form>' . "\n";
         ?>
        </td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 <!-- Przyciski EOF -->
 
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
     <td width="25%">
	  <table border="0" width="100%" cellspacing="0" cellpadding="0">
       <tr>
        <td width="50%" align="right"><?php echo tep_draw_separator('pixel_silver.gif', '1', '5'); ?></td>
        <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
       </tr>
      </table>
	 </td>
     <td width="25%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
     <td width="25%">
	  <table border="0" width="100%" cellspacing="0" cellpadding="0">
       <tr>
        <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
        <td><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/checkout_bullet.gif'); ?></td>
        <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
       </tr>
      </table>
	 </td>
     <td width="25%">
	  <table border="0" width="100%" cellspacing="0" cellpadding="0">
       <tr>
        <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
        <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '1', '5'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
    <tr>
     <td align="center" width="25%" class="checkoutBarFrom"><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '" class="checkoutBarFrom">' . CHECKOUT_BAR_DELIVERY . '</a>'; ?></td>
     <td align="center" width="25%" class="checkoutBarFrom"><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '" class="checkoutBarFrom">' . CHECKOUT_BAR_PAYMENT . '</a>'; ?></td>
     <td align="center" width="25%" class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>
     <td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_FINISHED; ?></td>
    </tr>
   </table>
  </td>
 </tr>
</table>