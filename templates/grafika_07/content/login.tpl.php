<?php
/*
  $Id: \templates\standard\content\login.tpl.php; 24.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>
<?php echo tep_draw_form('login', tep_href_link(FILENAME_LOGIN, 'action=process', 'SSL')); ?>
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
 if ($messageStack->size('login') > 0) {
 ?>
 <tr>
  <td><?php echo $messageStack->output('login'); ?></td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <?php
 }
 if ($cart->count_contents() > 0) {
 ?>
 <tr>
  <td class="smallText"><?php echo TEXT_VISITORS_CART; ?></td>
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
     <td class="main" width="100%" valign="top"><b><?php echo HEADING_RETURNING_CUSTOMER; ?></b></td>
    </tr>
	   <tr>
  <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
 </tr>
    <tr>
     <td width="100%" height="100%" valign="top">
      <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
       <tr class="infoBoxContents">
        <td>
         <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
           <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
           <td class="main" colspan="2"><?php echo TEXT_RETURNING_CUSTOMER; ?></td>
          </tr>
          <tr>
           <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
           <td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS; ?></b></td>
           <td class="main"><?php echo tep_draw_input_field('email_address'); ?></td>
          </tr>
          <tr>
           <td class="main"><b><?php echo ENTRY_PASSWORD; ?></b></td>
           <td class="main"><?php echo tep_draw_password_field('password'); ?></td>
          </tr>
          <tr>
           <td class="smallText" colspan="2"><?php echo '<a href="' . tep_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?></td>
          </tr>
          <tr>
           <td colspan="2">
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
             <tr>
              <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              <td align="right"><?php echo tep_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN); ?></td>
              <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
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
   </table>
  </td>
 </tr>
 <tr>
  <td class="main" width="100%" valign="top"><b><?php echo HEADING_NEW_CUSTOMER; ?></b></td>
 </tr>
    <tr>
      <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
    </tr>
 <tr>
  <td width="100%" valign="top">
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" height="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>
       <tr>
        <td class="main" valign="top"><?php echo TEXT_NEW_CUSTOMER . '<br><br>' . TEXT_NEW_CUSTOMER_INTRODUCTION; ?></td>
       </tr>
       <tr>
        <td>
         <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
           <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL') . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
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
 // Ingo PWA Beginn
 if (defined('PURCHASE_WITHOUT_ACCOUNT') && (PURCHASE_WITHOUT_ACCOUNT == 'true')) {
 ?>
 <tr>
  <td class="main" width="100%" valign="top"><b><?php echo HEADING_PWA; ?></b></td>
 </tr>
    <tr>
       <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
    </tr>
 <tr>
  <td colspan="2" width="100%">
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" height="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>
       <tr>
        <td class="main"><?php echo TEXT_GUEST_INTRODUCTION; ?></td>
       </tr>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>
       <tr>
        <td>
         <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
           <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_CREATE_ACCOUNT, 'guest=guest', 'SSL') . '">' . tep_image_button('button_checkout.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
           <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
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
 }
 // Ingo PWA Ende
 ?>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="main"><b><?php echo TEXT_NEW_CUSTOMER; ?></b></td>
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
     <td valign="top">
      <table border="0" width="100%"  cellspacing="0" cellpadding="2">
       <tr>
        <td class="main"><?php echo TEXT_NEW_CUSTOMER_INTRODUCTION; ?></td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
  </td>
 </tr>
</table>
</form>