<?php
/*
  $Id: \templates\standard\content\checkout_payment.tpl.php; 10.07.2006

 mod eSklep-Os http://www.esklep-os.com
 
  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('checkout_payment', tep_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post', 'onsubmit="return check_form();"'); ?>

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
 if (isset($HTTP_GET_VARS['payment_error']) && is_object(${$HTTP_GET_VARS['payment_error']}) && ($error = ${$HTTP_GET_VARS['payment_error']}->get_error())) {
 ?>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="main"><b><?php echo tep_output_string_protected($error['title']); ?></b></td>
    </tr>
   </table>
  </td>
 </tr>
 
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBoxNotice">
    <tr class="infoBoxNoticeContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main" width="100%" valign="top"><?php echo tep_output_string_protected($error['error']); ?></td>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
 </tr>
 <?php
 }
 ?>
 
 <tr>
  <td align="center">
   <table border="0" width="98%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="subTileModule"><b><?php echo TABLE_HEADING_BILLING_ADDRESS; ?></b></td>
    </tr>
   </table>
  </td>
 </tr>
 
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> 
        <td class="main" width="50%" valign="top"><?php echo TEXT_SELECTED_BILLING_DESTINATION; ?><br><br><?php echo '<a href="' . (($customer_id==0)?tep_href_link(FILENAME_CREATE_ACCOUNT, 'guest=guest', 'SSL'):tep_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL')) . '">' . tep_image_button('button_change_address.gif', IMAGE_BUTTON_CHANGE_ADDRESS) . '</a>'; ?></td>
        <td align="right" width="50%" valign="top">
		 <table border="0" cellspacing="0" cellpadding="2">
          <tr>
           <td class="main" align="center" valign="top"><b><?php echo TITLE_BILLING_ADDRESS; ?></b><br><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/shipping_address.gif'); ?></td>
           <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> 
		  </tr>
		  <tr>
           <td class="main" valign="top"><?php echo tep_address_label($customer_id, $billto, true, ' ', '<br>'); ?></td>
           <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> 
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
 
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 
 <tr>
  <td align="center">
   <table border="0" width="98%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="subTileModule"><b><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></b></td>
    </tr>
   </table>
  </td>
 </tr>
 
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <?php
       $selection = $payment_modules->selection();

       if (sizeof($selection) > 1) {
       ?>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main" width="50%" valign="top"><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></td>
        <td class="main" width="50%" valign="top" align="right"><b><?php echo TITLE_PLEASE_SELECT; ?></b><br><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/payment.gif'); ?></td>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
       <?php
       } else {
       ?>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main" width="100%" colspan="2"><?php echo TEXT_ENTER_PAYMENT_INFORMATION; ?></td>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
       <?php
       }

       $radio_buttons = 0;
       for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
       ?>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td colspan="2">
		 <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <?php
       if ( ($selection[$i]['id'] == $payment) || ($n == 1) ) {
        echo '               <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
       } else {
        echo '               <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
       }
       ?>
          <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
          <td class="main" colspan="3"><b><?php echo $selection[$i]['module']; ?></b></td>
          <td class="main" align="right">
           <?php
           if (sizeof($selection) > 1) {
            echo tep_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $payment));
           } else {
            echo tep_draw_hidden_field('payment', $selection[$i]['id']);
           }
       ?>
          </td>
          <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
          </tr>
          <?php
          if (isset($selection[$i]['error'])) {
          ?>
          <tr>
          <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
          <td class="main" colspan="4"><?php echo $selection[$i]['error']; ?></td>
          <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
          </tr>
          <?php
          } elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {
          ?>
          <tr>
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
           <td colspan="4">
		    <table border="0" cellspacing="0" cellpadding="2">
             <?php
             for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
             ?>
             <tr>
              <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              <td class="main"><?php echo $selection[$i]['fields'][$j]['title']; ?></td>
              <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              <td class="main"><?php echo $selection[$i]['fields'][$j]['field']; ?></td>
              <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
             </tr>
             <?php
             }
             ?>
            </table>
		   </td>
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
          </tr>
          <?php
          }
          ?>
         </table>
		</td>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
       <?php
       $radio_buttons++;
       }
       ?>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 
 
<?php
if ((TEXT_PARAGON != '') && (TEXT_FAKTURA != '')) {
?>
 
  <tr>
  <td align="center">
   <table border="0" width="98%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="subTileModule"><b><?php echo TABLE_HEADING_DOKUMENT_SPRZEDAZY; ?></b></td>
    </tr>
   </table>
  </td>
 </tr>
 
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">

       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main" width="50%" valign="top"><?php echo TEXT_SELECT_DOKUMENT_SPRZEDAZY; ?></td>
        <td class="main" width="50%" valign="top" align="right"><b><?php echo TITLE_PLEASE_SELECT; ?></b></td>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>

       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td colspan="2">
		 <table border="0" width="100%" cellspacing="0" cellpadding="2">
		  <tr id="fakt1" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="javascript:this.className='moduleRowSelected';document.getElementById('fakt2').className='moduleRow';document.forms['checkout_payment'].paragon[0].checked=true">
          <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
          <td class="main" colspan="3"><b><?php echo TEXT_PARAGON; ?></b></td>
          <td class="main" align="right"><input type="radio" name="paragon" value="paragon" checked></td>
          <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
          </tr>	
		  <?php
		  $sprawdz_nip = mysql_query("select entry_nip from address_book where customers_id = '" . $customer_id . "' && entry_nip != ''");
		  if (mysql_num_rows($sprawdz_nip) > 0) { 
		  ?>
		     <tr id="fakt2" class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="javascript:this.className='moduleRowSelected';document.getElementById('fakt1').className='moduleRow';document.forms['checkout_payment'].paragon[1].checked=true">
             <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
             <td class="main" colspan="3"><b><?php echo TEXT_FAKTURA; ?></b></td>
             <td class="main" align="right"><input type="radio" name="paragon" value="faktura"></td>
             <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
             </tr>			  
		   <?php
		   } else {
		   ?>
		     <tr id="fakt2" class="moduleRow">
             <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
             <td class="main" colspan="3"><b><?php echo TEXT_FAKTURA; ?></b><br>
			 <span class="smallText"></span><?php echo FAKTURA_NIP; ?></td>
             <td class="main" align="right"><input type="radio" name="paragon" value="faktura" disabled></td>
             <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
             </tr>	
		   <?php
		   }
		   ?>			 
         </table>
		</td>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
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
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <tr>
  <td align="center">
   <table border="0" width="98%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="subTileModule"><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
    </tr>
   </table>
  </td>
 </tr>
 
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td align="center"><?php echo tep_draw_textarea_field('comments', 'soft', '80', '5', $comments); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>

<?php
/* kgt - discount coupons */
 if( MODULE_ORDER_TOTAL_DISCOUNT_COUPON_STATUS == 'true' ) {
 ?>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <tr>
  <td align="center">
   <table border="0" width="98%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="subTileModule"><b><?php echo TABLE_HEADING_COUPON; ?></b></td>
    </tr>
   </table>
  </td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td class="main"><?php echo ENTRY_DISCOUNT_COUPON.' '.tep_draw_input_field('coupon', '', 'size="32"'); ?></td>
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
/* end kgt - discount coupons */
?>
 

 <!-- Przyciski BOF -->
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main" align="left"><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING) . '">' . tep_image_button('button_back.gif', 'back') . '</a>'; ?></td><td class="main" align="center"><b><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '</b><br>' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></td>
        <td class="main" align="right"><?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
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
     <td width="25%">
	  <table border="0" width="100%" cellspacing="0" cellpadding="0">
       <tr>
        <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
        <td><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/checkout_bullet.gif'); ?></td>
        <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
       </tr>
      </table>
	 </td>
     <td width="25%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
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
     <td align="center" width="25%" class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_PAYMENT; ?></td>
     <td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>
     <td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_FINISHED; ?></td>
    </tr>
   </table>
  </td>
 </tr>
</table>
</form>