<?php
/*
  $Id: \templates\standard\content\tell_a_friend.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('email_friend', tep_href_link(FILENAME_TELL_A_FRIEND, 'action=process&products_id=' . $HTTP_GET_VARS['products_id'])); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
	<tr>  
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="22" height="40"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo sprintf(HEADING_TITLE, $product_info[ products_name ]); ?></td>
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_right.gif" border="0" alt="" width="16" height="40"></td>	
	</tr> 
 </table></td>
      </tr>	  
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <!-- Naglowek EOF -->

 <?php
 if ($messageStack->size('friend') > 0) {
 ?>
 <tr>
  <td><?php echo $messageStack->output('friend'); ?></td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <?php
 }

 if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'success')) {
 ?>
 <tr>
  <td class="main" align="center"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/table_background_man_on_board.gif', HEADING_TITLE, '0', '0', 'align="left"') . TEXT_EMAIL_SUCCESSFUL_SENT; ?></td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td align="right"><?php echo '<a href="' . FILENAME_PRODUCT_INFO, '?products_id=' . $tell_products_id . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
  </td>
 </tr>
 
 <?php
 } else {
 ?>
 

 <tr>
  <td>
   <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
     <td class="main"><b><?php echo FORM_TITLE_CUSTOMER_DETAILS; ?></b></td>
     <td class="inputRequirement" align="right"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
    </tr>

    <tr>
     <td colspan="2">
      <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
       <tr class="infoBoxContents">
        <td>
         <table border="0" cellspacing="0" cellpadding="2">
          <tr>
           <td class="main"><?php echo FORM_FIELD_CUSTOMER_NAME; ?></td>
           <td class="main"><?php echo tep_draw_input_field('from_name', $from_name); ?></td>
          </tr>
          <tr>
           <td class="main"><?php echo FORM_FIELD_CUSTOMER_EMAIL; ?></td>
           <td class="main"><?php echo tep_draw_input_field('from_email_address', $from_email_address); ?></td>
          </tr>
         </table>
        </td>
       </tr>
      </table>
     </td>
    </tr>

    <tr>
     <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
    </tr>

    <tr>
     <td class="main" colspan="2"><b><?php echo FORM_TITLE_FRIEND_DETAILS; ?></b></td>
    </tr>

    <tr>
     <td colspan="2">
      <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
       <tr class="infoBoxContents">
        <td>
         <table border="0" cellspacing="0" cellpadding="2">
          <tr>
           <td class="main"><?php echo FORM_FIELD_FRIEND_NAME; ?></td>
           <td class="main"><?php echo tep_draw_input_field('to_name') . '&nbsp;<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>'; ?></td>
          </tr>
          <tr>
           <td class="main"><?php echo FORM_FIELD_FRIEND_EMAIL; ?></td>
           <td class="main"><?php echo tep_draw_input_field('to_email_address') . '&nbsp;<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>'; ?></td>
          </tr>
         </table>
        </td>
       </tr>
      </table>
     </td>
    </tr>

    <tr>
     <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
    </tr>

    <tr>
     <td class="main" colspan="2"><b><?php echo FORM_TITLE_FRIEND_MESSAGE; ?></b></td>
    </tr>

    <tr>
     <td colspan="2">
      <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
       <tr class="infoBoxContents">
        <td align="center"><?php echo tep_draw_textarea_field('message', 'soft', 60, 8); ?></td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
    </tr>

    <?php
    // BOF Anti Robot Registration v2.5
    if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'tell_a_friend') &&  TELL_FRIEND_VALIDATION == 'true') {
       ?>
       <tr>
        <td class="main" colspan="2"><b><?php echo CATEGORY_ANTIROBOTREG; ?></b></td>
       </tr>
       <tr>
        <td colspan="2">
         <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
           <td>
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
             <?php
             if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'tell_a_friend') && TELL_FRIEND_VALIDATION == 'true') {
              if ($is_read_only == false || (strstr($PHP_SELF,'tell_a_friend')) ) {
               $sql = "DELETE FROM " . TABLE_ANTI_ROBOT_REGISTRATION . " WHERE timestamp < '" . (time() - 3600) . "' OR session_id = '" . tep_session_id() . "'";
               if( !$result = tep_db_query($sql) ) { die('Could not delete validation key'); }
               $reg_key = gen_reg_key();
               $sql = "INSERT INTO ". TABLE_ANTI_ROBOT_REGISTRATION . " VALUES ('" . tep_session_id() . "', '" . $reg_key . "', '" . time() . "')";
               if( !$result = tep_db_query($sql) ) { die('Could not check registration information'); }
               ?>
               <tr>
                <td class="main">
                 <table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                   <td class="main">
                    <table border="0" cellspacing="0" cellpadding="1" width="100%">
                     <tr>
                      <td class="main"><?php echo ENTRY_ANTIROBOTREG; ?></td>
                      <td class="main">
                       <?php
                       $check_anti_robotreg_query = tep_db_query("select session_id, reg_key, timestamp from anti_robotreg where session_id = '" . tep_session_id() . "'");
                       $new_guery_anti_robotreg = tep_db_fetch_array($check_anti_robotreg_query);
                       $validation_images = '<img src="validation_png.php?rsid=' . $new_guery_anti_robotreg['session_id'] . '">';
                       if ($entry_antirobotreg_error == true) {
                        ?>
                        <span>
                        <?php
                        echo $validation_images . '</td><td valign="middle">';
                        echo tep_draw_input_field('antirobotreg') . '';
                       } else {
                        ?>
                        <span>
                        <?php
                        echo $validation_images . '</td><td valign="middle">';
                        echo tep_draw_input_field('antirobotreg', $account['entry_antirobotreg']);
                       }
                       ?>
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
             }
             ?>
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
       // EOF Anti Robot Registration v2.5
       ?>
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
        <td><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['products_id']) . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
        <td align="right"><?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
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
 }
 ?>

</table>
</form>