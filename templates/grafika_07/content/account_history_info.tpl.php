<?php
/*
  $Id: \templates\standard\content\account_history_info.tpl.php; 09.07.2006

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
  <td>
   <table border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr>
     <td class="main" colspan="2"><b><?php echo sprintf(HEADING_ORDER_NUMBER, $HTTP_GET_VARS['order_id']) . ' <small>(' . $order->info['orders_status'] . ')</small>'; ?></b></td>
    </tr>
    <tr>
     <td class="smallText"><?php echo HEADING_ORDER_DATE . ' ' . tep_date_long($order->info['date_purchased']); ?></td>
     <td class="smallText" align="right"><?php echo HEADING_ORDER_TOTAL . ' ' . $order->info['total']; ?></td>
    </tr>
   </table>
  </td>
 </tr>
 
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
    <?php
    if ($order->delivery != false) {
    ?>
     <td width="30%" valign="top">
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td class="main"><b><?php echo HEADING_DELIVERY_ADDRESS; ?></b></td>
       </tr>
       <tr>
        <td class="main"><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br>'); ?></td>
     </tr>
       
	   <?php
       if (tep_not_null($order->info['shipping_method'])) {
       ?>
       <tr>
        <td class="main"><b><?php echo HEADING_SHIPPING_METHOD; ?></b></td>
       </tr>
       <tr>
        <td class="main"><?php echo $order->info['shipping_method']; ?></td>
       </tr>
       <?php
       }
       ?>
       
	  </table>
	 </td>
    <?php
    }
    ?>
    
	<td width="<?php echo (($order->delivery != false) ? '70%' : '100%'); ?>" valign="top">
	 <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
       <td>
	    <table border="0" width="100%" cellspacing="0" cellpadding="2">
         <?php
         if (sizeof($order->info['tax_groups']) > 1) {
         ?>
         <tr>
          <td class="main" colspan="2"><b><?php echo HEADING_PRODUCTS; ?></b></td>
          <td class="smallText" align="right"><b><?php echo HEADING_TAX; ?></b></td>
          <td class="smallText" align="right"><b><?php echo HEADING_TOTAL; ?></b></td>
         </tr>
         
		 <?php
         } else {
         ?>
         
		 <tr>
          <td class="main" colspan="3"><b><?php echo HEADING_PRODUCTS; ?></b></td>
         </tr>
         <?php
         }

         for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
          echo '          <tr>' . "\n" .
                  '           <td class="main" align="right" valign="top" width="30">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
                  '           <td class="main" valign="top">' . $order->products[$i]['name'];

          if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
           for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
            echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '</i></small></nobr>';
           }
          }

          echo '           </td>' . "\n";

          if (sizeof($order->info['tax_groups']) > 1) {
           echo '          <td class="main" valign="top" align="right">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n";
          }

          echo '           <td class="main" align="right" valign="top">' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</td>' . "\n" .'          </tr>' . "\n";
         }
         ?>
         
		</table>
	   </td>
      </tr>
     </table>
	</td>
   </tr>
  </table>
 </td>
 </tr>
 
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 
 <tr>
  <td class="main"><b><?php echo HEADING_BILLING_INFORMATION; ?></b></td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td width="30%" valign="top">
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td class="main"><b><?php echo HEADING_BILLING_ADDRESS; ?></b></td>
       </tr>
       <tr>
        <td class="main"><?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br>'); ?></td>
       </tr>
       <tr>
        <td class="main"><b><?php echo HEADING_PAYMENT_METHOD; ?></b></td>
       </tr>
       <tr>
        <td class="main"><?php echo $order->info['payment_method']; ?></td>
       </tr>
      </table>
	 </td>
     <td width="70%" valign="top">
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <?php
      for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
       echo '              <tr>' . "\n" .
               '               <td class="main" align="right" width="100%">' . $order->totals[$i]['title'] . '</td>' . "\n" .
               '               <td class="main" align="right">' . $order->totals[$i]['text'] . '</td>' . "\n" .
               '              </tr>' . "\n";
      }
      ?>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
  
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <tr>
  <td class="main"><b><?php echo HEADING_ORDER_HISTORY; ?></b></td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td valign="top">
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <?php
      $statuses_query = tep_db_query("select os.orders_status_name, osh.date_added, osh.comments from " . TABLE_ORDERS_STATUS . " os, " . TABLE_ORDERS_STATUS_HISTORY . " osh where osh.orders_id = '" . (int)$HTTP_GET_VARS['order_id'] . "' and osh.orders_status_id = os.orders_status_id and os.language_id = '" . (int)$languages_id . "' order by osh.date_added");
      while ($statuses = tep_db_fetch_array($statuses_query)) {
       echo '              <tr>' . "\n" .
               '               <td class="main" valign="top" width="70">' . tep_date_short($statuses['date_added']) . '</td>' . "\n" .
               '               <td class="main" valign="top" width="170">' . $statuses['orders_status_name'] . '</td>' . "\n" .
               '               <td class="main" valign="top">' . (empty($statuses['comments']) ? '&nbsp;' : nl2br(tep_output_string_protected($statuses['comments']))) . '</td>' . "\n" .
               '              </tr>' . "\n";
      }
      ?>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>

 <!-- start pdf //-->
 <?php
 // only display pdf invoice link if * latest * order status is 3 (delivered)
// $delivered_query = tep_db_query("select max(osh.date_added) as los,  osh.orders_status_id from " . TABLE_ORDERS_STATUS_HISTORY . " osh where osh.orders_id = '" . (int)$HTTP_GET_VARS['order_id'] . "' group by osh.orders_status_id order by los desc limit 1");

 //$delivered_status = tep_db_fetch_array($delivered_query);
 //if ($delivered_status['orders_status_id'] == 3 || DISPLAY_PDF_DELIVERED_ONLY == 'false' ){
  ?>
	<tr>
  	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 	</tr>
 	<tr>
  	<td class="main"><b><?php echo PDF_INVOICE; ?></b></td>
 	</tr>
 	<tr>
  	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 	</tr>

  <tr>
  	<td>
			<table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
      	<tr class="infoBoxContents">
				  <td  class="main">
					  <?php echo '' . PDF_DOWNLOAD_LINK . ' <a href="' . tep_href_link(FILENAME_CUSTOMER_PDF, 'order_id=' . $HTTP_GET_VARS['order_id']) . '" target="_blank"> ' . tep_image(DIR_WS_TEMPLATES.'images/misc/icons/pdf.png') . '</a>'; ?>
					</td>
	      </tr>
      </table>
    </td>
  </tr>
	<?php
// }
 ?>
 <!-- end pdf //-->

 <?php
 if (DOWNLOAD_ENABLED == 'true') include(DIR_WS_MODULES . 'downloads.php');
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
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, tep_get_all_get_params(array('order_id')), 'SSL') . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 <!-- Przyciski EOF -->

</table>