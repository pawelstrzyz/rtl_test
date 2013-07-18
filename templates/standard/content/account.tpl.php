<?php
/*
  $Id: \templates\standard\content\account.tpl.php; 10.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
	<tr>  
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo HEADING_TITLE; ?></td>
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_left.gif" border="0" alt="" width="30" height="35"></td>	
	</tr> 
 </table></td>
      </tr>	  
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <!-- Naglowek EOF -->

 <?php
 if ($messageStack->size('account') > 0) {
 ?>
 <tr>
  <td><?php echo $messageStack->output('account'); ?></td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <?php
 }

 if (tep_count_customer_orders() > 0) {
 ?>
 <tr>
  <td>
   <table border="0" cellspacing="0" cellpadding="2">
    <tr>
     <td class="main"><b><?php echo OVERVIEW_PREVIOUS_ORDERS; ?></b></td>
     <td class="main"><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '"><u>' . OVERVIEW_SHOW_ALL_ORDERS . '</u></a>'; ?></td>
    </tr>
   </table>
  </td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	    <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main" align="center" valign="top"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/arrow_south_east.gif'); ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td>
		     <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <?php
          $orders_query = tep_db_query("select o.orders_id, o.date_purchased, o.delivery_name, o.delivery_country, o.billing_name, o.billing_country, ot.text as order_total, s.orders_status_name from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$customer_id . "' and o.orders_id = ot.orders_id and ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' order by orders_id desc limit 3");
          while ($orders = tep_db_fetch_array($orders_query)) {
           if (tep_not_null($orders['delivery_name'])) {
            $order_name = $orders['delivery_name'];
            $order_country = $orders['delivery_country'];
           } else {
            $order_name = $orders['billing_name'];
            $order_country = $orders['billing_country'];
           }
          ?>
           <tr class="moduleRow" onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)" onClick="document.location.href='<?php echo tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL'); ?>'">
            <td class="main" width="80"><?php echo tep_date_short($orders['date_purchased']); ?></td>
            <td class="main"><?php echo '#' . $orders['orders_id']; ?></td>
            <td class="main"><?php echo tep_output_string_protected($order_name) . ', ' . $order_country; ?></td>
            <td class="main"><?php echo $orders['orders_status_name']; ?></td>
            <td class="main" align="right"><?php echo $orders['order_total']; ?></td>
            <td class="main" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL') . '">' . tep_image_button('small_view.gif', SMALL_IMAGE_BUTTON_VIEW) . '</a>'; ?></td>
           </tr>
          <?php
          }
          ?>
         </table>
		</td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
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
 <?php
 }
 ?>
 
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="main"><b><?php echo MY_ACCOUNT_TITLE; ?></b></td>
    </tr>
   </table>
  </td>
 </tr>
    <tr>
       <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
   </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td width="60"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/account_personal.gif'); ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td>
		 <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
           <td class="main"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/arrow_green.gif') . ' <a class="boxLink" href="' . tep_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL') . '">' . MY_ACCOUNT_INFORMATION . '</a>'; ?></td>
          </tr>
          <tr>
           <td class="main"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/arrow_green.gif') . ' <a class="boxLink" href="' . tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . MY_ACCOUNT_ADDRESS_BOOK . '</a>'; ?></td>
          </tr>
          <tr>
           <td class="main"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/arrow_green.gif') . ' <a class="boxLink" href="' . tep_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL') . '">' . MY_ACCOUNT_PASSWORD . '</a>'; ?></td>
          </tr>
         </table>
		</td>
        <td width="10" align="right"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
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
  <td>
   <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="main"><b><?php echo MY_ORDERS_TITLE; ?></b></td>
    </tr>
   </table>
  </td>
 </tr>
     <tr>
       <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
   </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td width="60"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/account_orders.gif'); ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td>
		 <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
           <td class="main"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/arrow_green.gif') . ' <a class="boxLink" href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">' . MY_ORDERS_VIEW . '</a>'; ?></td>
          </tr>
         </table>
		</td>
        <td width="10" align="right"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
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
   <td>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
     <tr>
      <td class="main"><b><?php echo EMAIL_NOTIFICATIONS_TITLE; ?></b></td>
     </tr>
    </table>
   </td>
  </tr>
      <tr>
       <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
   </tr>
  <tr>
   <td>
    <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
     <tr class="infoBoxContents">
      <td>
	   <table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
         <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
         <td width="60"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/account_notifications.gif'); ?></td>
         <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
         <td>
		  <table border="0" width="100%" cellspacing="0" cellpadding="2">
           <tr>
            <td class="main"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/arrow_green.gif') . ' <a class="boxLink" href="' . tep_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL') . '">' . EMAIL_NOTIFICATIONS_NEWSLETTERS . '</a>'; ?></td>
           </tr>
           <tr>
            <td class="main"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/arrow_green.gif') . ' <a class="boxLink" href="' . tep_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL') . '">' . EMAIL_NOTIFICATIONS_PRODUCTS . '</a>'; ?></td>
           </tr>
          </table>
		 </td>
         <td width="10" align="right"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        </tr>
       </table>
	  </td>
     </tr>
    </table>
   </td>
  </tr>
  
  <?php
  if (MODULE_ORDER_TOTAL_INSTALLED) {
  ?> 
  <tr>
   <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
  </tr>
  <?php
  $order_total_modules->process();
  echo $order_total_modules->output2();
  }
  ?>
</table>