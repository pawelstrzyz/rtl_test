<?php
/*
  $Id: \templates\standard\content\checkout_success.tpl.php; 10.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('order', tep_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=update', 'SSL')); ?>

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

 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
	 <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
	   <tr>
        <td align="center">
	     <h4><?php echo TEXT_SUCCESS; ?></h4>
        </td>
       </tr>
       <tr>
        <td class="main">
        <?php
		if ($global['global_product_notifications'] != '1') {
        if ($customer_id != 0) {
         echo TEXT_NOTIFY_PRODUCTS . '<br><p class="productsNotifications">';
         $products_displayed = array();
         for ($i=0, $n=sizeof($products_array); $i<$n; $i++) {
          if (!in_array($products_array[$i]['id'], $products_displayed)) {
           echo tep_draw_checkbox_field('notify[]', $products_array[$i]['id']) . ' ' . $products_array[$i]['text'] . '<br>';
           $products_displayed[] = $products_array[$i]['id'];
          }
         }
        echo '</p>';
		}
        } else {
         echo TEXT_SEE_ORDERS . '<br><br>' . TEXT_CONTACT_STORE_OWNER;
        }
        ?>
        <h5><?php echo TEXT_THANKS_FOR_SHOPPING; ?></h5>
        </td>
       </tr>
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

 <!-- Przyciski BOF -->
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
	<tr class="infoBoxContents">
	 <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
	   <tr>
	    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
	    <td align="right" class="main"><?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
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
     <td width="25%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
     <td width="25%">
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
       <tr>
        <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
        <td width="50%"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/checkout_bullet.gif'); ?></td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td align="center" width="25%" class="checkoutBarFrom"><?php echo CHECKOUT_BAR_DELIVERY; ?></td>
     <td align="center" width="25%" class="checkoutBarFrom"><?php echo CHECKOUT_BAR_PAYMENT; ?></td>
     <td align="center" width="25%" class="checkoutBarFrom"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>
     <td align="center" width="25%" class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_FINISHED; ?></td>
    </tr>
   </table>
  </td>
 </tr>

 <?php if (DOWNLOAD_ENABLED == 'true') include(DIR_WS_MODULES . 'downloads.php'); ?>

</table>
</form>