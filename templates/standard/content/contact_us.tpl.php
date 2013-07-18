<?php
/*
  $Id: \templates\standard\content\contact_us.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('contact_us', tep_href_link(FILENAME_CONTACT_US, 'action=send')); ?>

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
 if ($messageStack->size('contact') > 0) {
 ?>
 <tr>
  <td><?php echo $messageStack->output('contact'); ?></td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
 </tr>
 <?php
 }

 if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'success')) {
 ?>
 <tr>
  <td class="main" align="center"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/table_background_man_on_board.gif', HEADING_TITLE, '0', '0', 'align="left"') . TEXT_SUCCESS; ?></td>
 </tr>
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
        <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
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
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
	    <!-- Tresc pobrana z bazy BOF -->
        <td class="main"><?php echo $pagetext; ?></td>
	    <!-- Tresc pobrana z bazy EOF -->
       </tr>
       <tr>
        <td class="main"><?php echo ENTRY_NAME; ?></td>
       </tr>
       <tr>
        <td class="main"><?php echo tep_draw_input_field('name', $from_name); ?></td>
       </tr>
       <tr>
        <td class="main"><?php echo ENTRY_EMAIL; ?></td>
       </tr>
       <tr>
        <td class="main"><?php echo tep_draw_input_field('email', $from_email_address); ?></td>
       </tr>
       <tr>
        <td class="main"><?php echo ENTRY_ENQUIRY; ?></td>
       </tr>
       <tr>
        <td><?php echo tep_draw_textarea_field('enquiry', 'soft', 48, 8, tep_sanitize_string($_POST['enquiry']), '', false); ?></td>
       </tr>
       <?php
       // BOF Anti Robot Registration v2.5
       if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'contact_us') &&  CONTACT_US_VALIDATION == 'true') {
       ?>
       <tr>
        <td class="main"><b><?php echo CATEGORY_ANTIROBOTREG; ?></b></td>
       </tr>
       <tr>
        <td>
         <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr class="infoBoxContents">
           <td>
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
             <?php
             if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'contact_us') && CONTACT_US_VALIDATION == 'true') {
              if ($is_read_only == false || (strstr($PHP_SELF,'contact_us')) ) {
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
                    <table border="0" cellspacing="0" cellpadding="2" width="100%">
                     <tr>
                      <td class="main"><?php echo ENTRY_ANTIROBOTREG; ?></td>
                      <td class="main" align="center">
                       <?php
                       $check_anti_robotreg_query = tep_db_query("select session_id, reg_key, timestamp from anti_robotreg where session_id = '" . tep_session_id() . "'");
                       $new_guery_anti_robotreg = tep_db_fetch_array($check_anti_robotreg_query);
                       $validation_images = '<img src="validation_png.php?rsid=' . $new_guery_anti_robotreg['session_id'] . '">';
                       if ($entry_antirobotreg_error == true) {
                        ?>
                        <td>
                        <?php
                        echo $validation_images . '</td><td valign="middle">';
                        echo tep_draw_input_field('antirobotreg') . '</td>';
                       } else {
                        ?>
                        <td>
                        <?php
                        echo $validation_images . '</td><td valign="middle">';
                        echo tep_draw_input_field('antirobotreg', $account['entry_antirobotreg']) . '</td>';
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
   </table>
  </td>
 </tr>
 
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
        <td align="right"><?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
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
</table>
</form>