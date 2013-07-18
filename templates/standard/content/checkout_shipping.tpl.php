<?php
/*
  $Id: \templates\standard\content\checkout_shipping.tpl.php; 10.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('checkout_address', tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) . tep_draw_hidden_field('action', 'process'); ?>
     
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
  <td align="center">
   <table border="0" width="98%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="subTileModule"><b><?php echo TABLE_HEADING_SHIPPING_ADDRESS; ?></b></td>
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
        <td class="main" width="50%" valign="top"><?php echo (($customer_id>0 || (defined('PURCHASE_WITHOUT_ACCOUNT_SEPARATE_SHIPPING') && PURCHASE_WITHOUT_ACCOUNT_SEPARATE_SHIPPING=='true') )? TEXT_CHOOSE_SHIPPING_DESTINATION . '<br><br><a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL') . '">' . tep_image_button('button_change_address.gif', IMAGE_BUTTON_CHANGE_ADDRESS) . '</a>':'&nbsp;'); ?></td>
        <td align="right" width="50%" valign="top">
		 <table border="0" cellspacing="0" cellpadding="2">
          <tr>
           <td class="main" align="center" valign="top"><?php echo '<b>' . TITLE_SHIPPING_ADDRESS . '</b><br>' . tep_image(DIR_WS_TEMPLATES . 'images/misc/shipping_address.gif'); ?></td>
           <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> 
		  </tr>
		  <tr>
           <td class="main" valign="top"><?php echo tep_address_label($customer_id, $sendto, true, ' ', '<br>'); ?></td>
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
 
 <?php
 if (tep_count_giftwrap_modules() > 0) {
 ?>
 <tr>
  <td align="center">
   <table border="0" width="98%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="subTileModule"><b><?php echo TABLE_HEADING_GIFTWRAP_METHOD; ?></b></td>
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
       $quotes1_size = sizeof($quotes1);

       if ($quotes1_size > 1) {
       ?>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main" width="50%" valign="top"><?php echo TEXT_CHOOSE_GIFTWRAP_METHOD; ?></td>
        <td class="main" width="50%" valign="top" align="right"><?php echo '<b>' . TITLE_PLEASE_SELECT . '</b><br>' . tep_image(DIR_WS_TEMPLATES . 'images/misc/package-add.gif'); ?></td>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
       <?php
       } else {
       ?>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main" width="100%" colspan="2"><?php echo TEXT_ENTER_GIFTWRAP_INFORMATION; ?></td>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
       <?php
       }

       $radio_buttons = 0;
       for ($i=0; $i<$quotes1_size; $i++) {
       ?>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td colspan="2">
		 <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <?php
          if (isset($quotes1[$i]['error'])) {
          ?>
          <tr>
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
           <td class="main" colspan="3"><?php echo $quotes1[$i]['error']; ?></td>
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
          </tr>
          <?php
          } else {
          $size = sizeof($quotes1[$i]['methods']);
          for ($j=0, $n2=$size; $j<$n2; $j++) {
           // set the radio button to be checked if it is the method chosen
           $checked = (($quotes1[$i]['id'] . '_' . $quotes1[$i]['methods'][$j]['id'] == $giftwrap_info['id']) ? true : false);

           if ( ($quotes1[$i]['id'] . '_' . $quotes1[$i]['methods'][$j]['id'] == $giftwrap_info['id']) || (tep_count_giftwrap_modules() == (int)1) ) {
           echo '<tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
           } else {
           echo ' <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
           }
           ?>
            <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
            <td class="main" width="65%"><?php echo $quotes1[$i]['methods'][$j]['title']; ?></td>
            <?php
            if ( ($quotes1_size > 1) || ($n2 > 1) ) {
            ?>
            <td class="main"><?php echo $currencies->format($quotes1[$i]['methods'][$j]['cost']); ?></td>
            <td class="main" align="right"><?php echo tep_draw_radio_field('giftwrap', $quotes1[$i]['id'] . '_' . $quotes1[$i]['methods'][$j]['id'], $checked); ?></td>
            <?php
            } else {
            ?>
            <td class="main" align="right" colspan="2"><?php echo $currencies->format($quotes1[$i]['methods'][$j]['cost']) . tep_draw_hidden_field('giftwrap', $quotes1[$i]['id'] . '_' . $quotes1[$i]['methods'][$j]['id']); ?></td>
            <?php
            }
            ?>
            <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
           </tr>
           <?php
          $radio_buttons++;
         }
        }
        ?>
        </table>
	   </td>
       <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> 
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
 ?>

 <?php
 if (tep_count_shipping_modules() > 0) {
 ?>
 <tr>
  <td align="center">
   <table border="0" width="98%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="subTileModule"><b><?php echo TABLE_HEADING_SHIPPING_METHOD; ?></b></td>
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
       if (sizeof($quotes) > 1 && sizeof($quotes[0]) > 1) {
       ?>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main" width="50%" valign="top"><?php echo TEXT_CHOOSE_SHIPPING_METHOD; ?></td>
        <td class="main" width="50%" valign="top" align="right"><?php echo '<b>' . TITLE_PLEASE_SELECT . '</b><br>' . tep_image(DIR_WS_TEMPLATES . 'images/misc/package.gif'); ?></td>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
       <?php
	   } 
       if ($free_shipping == true) {

       ?>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td colspan="2" width="100%">
		  <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
           <td class="main" colspan="3"><b><?php echo MODULE_SHIPPING_FREEAMOUNT_TEXT_TITLE; ?></b>&nbsp;<?php echo $quotes[$i]['icon']; ?></td>
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
          </tr>
          <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, 0)">
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
           <td class="main" width="100%"><?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_SHIPPING_FREEAMOUNT_AMOUNT), MODULE_SHIPPING_FREEAMOUNT_WEIGHT_MAX) . tep_draw_hidden_field('shipping', 'free_free'); ?></td>
           <td width="10"><td class="main" align="right"><?php echo tep_draw_radio_field('shipping', 'kosztsprzedawcy_kosztsprzedawcy', 'checked'); ?></td></td>
          </tr>
         </table>
		</td>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
       <?php


       } else {
       
	   $radio_buttons = 0;
       for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
       ?>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td colspan="2">
		 <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
           <td class="main" colspan="3"><b><?php echo $quotes[$i]['module']; ?></b>&nbsp;<?php if (isset($quotes[$i]['icon']) && tep_not_null($quotes[$i]['icon'])) { echo $quotes[$i]['icon']; } ?></td>
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
          </tr>
          <?php
          if (isset($quotes[$i]['error'])) {
          ?>
           <tr>
            <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
            <td class="main" colspan="3"><?php echo $quotes[$i]['error']; ?></td>
            <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
           </tr>
           <?php
          } else {
           for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
            // set the radio button to be checked if it is the method chosen
            $checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $shipping['id']) ? true : false);

            if ( ($checked == true) || ($n == 1 && $n2 == 1) ) {
              echo '<tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
            } else {
              echo '<tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
            }
            ?>
            <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
            <td class="main" width="75%"><?php echo $quotes[$i]['methods'][$j]['title']; ?></td>
            <?php
            if ( ($n > 1) || ($n2 > 1) ) {
            ?>
             <td class="main"><?php echo $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))); ?></td>
             <td class="main" align="right"><?php echo tep_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked); ?></td>
             <?php
            } else {
             ?>
             <td class="main" align="right" colspan="2"><?php echo $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])) . tep_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); ?></td>
             <?php
            }
            ?>
            <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
           </tr>
           <?php
           $radio_buttons++;
           }
          }
          ?>
          </table>
		 </td>
         <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> 
        </tr>
       <?php
       }
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
 ?>

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
        <td align="center"><?php echo tep_draw_textarea_field('comments', 'soft', 80, 8); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 
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
        <td class="main"><?php echo '<b>' . TITLE_CONTINUE_CHECKOUT_PROCEDURE . '</b><br>' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></td>
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
        <td width="50%" align="right"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/checkout_bullet.gif'); ?></td>
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
        <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '1', '5'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
    <tr>
     <td align="center" width="25%" class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_DELIVERY; ?></td>
     <td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_PAYMENT; ?></td>
     <td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>
     <td align="center" width="25%" class="checkoutBarTo"><?php echo CHECKOUT_BAR_FINISHED; ?></td>
    </tr>
   </table>
  </td>
 </tr>
</table>
</form>