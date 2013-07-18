<?php
/*
  $Id: \templates\standard\content\account_password.tpl.php; 10.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('account_password', tep_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'), 'post', 'onSubmit="return check_form(account_password);"') . tep_draw_hidden_field('action', 'process'); ?>

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
 if ($messageStack->size('account_password') > 0) {
 ?>
 <tr>
  <td><?php echo $messageStack->output('account_password'); ?></td>
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
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
         <td class="main"><b><?php echo MY_PASSWORD_TITLE; ?></b></td>
         <td class="inputRequirement" align="right"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
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
		 <table border="0" cellspacing="2" cellpadding="2">
          <tr>
           <td class="main"><?php echo ENTRY_PASSWORD_CURRENT; ?></td>
           <td class="main"><?php echo tep_draw_password_field('password_current') . '&nbsp;' . (tep_not_null(ENTRY_PASSWORD_CURRENT_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CURRENT_TEXT . '</span>': ''); ?></td>
          </tr>
          <tr>
           <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
           <td class="main"><?php echo ENTRY_PASSWORD_NEW; ?></td>
           <td class="main"><?php echo tep_draw_password_field('password_new') . '&nbsp;' . (tep_not_null(ENTRY_PASSWORD_NEW_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_NEW_TEXT . '</span>': ''); ?></td>
          </tr>
          <tr>
           <td class="main"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></td>
           <td class="main"><?php echo tep_draw_password_field('password_confirmation') . '&nbsp;' . (tep_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''); ?></td>
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
  
 <!-- // BOF Anti Robot Registration v2.2-->
 <?php
 if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'account_password') &&  ACCOUNT_EDIT_PASSWORD_VALIDATION == 'true') {
 ?>
  <tr>
   <td class="main"><b><?php echo CATEGORY_ANTIROBOTREG; ?></b></td>
  </tr>
  <tr>
   <td>
    <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
     <tr class="infoBoxContents">
      <td>
       <table align="left" border="0" cellspacing="2" cellpadding="2" width="100%">
        <?php
    if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'account_password') && ACCOUNT_EDIT_PASSWORD_VALIDATION == 'true') {
      if ($is_read_only == false || (strstr($PHP_SELF,'account_password')) ) {
        $sql = "DELETE FROM " . TABLE_ANTI_ROBOT_REGISTRATION . " WHERE timestamp < '" . (time() - 3600) . "' OR session_id = '" . tep_session_id() . "'";
        if( !$result = tep_db_query($sql) ) { die('Could not delete validation key'); }
        $reg_key = gen_reg_key();
        $sql = "INSERT INTO ". TABLE_ANTI_ROBOT_REGISTRATION . " VALUES ('" . tep_session_id() . "', '" . $reg_key . "', '" . time() . "')";
        if( !$result = tep_db_query($sql) ) { die('Could not check registration information'); }
         ?>
		     <tr>
			    <td class="main">
           <table border="0" cellspacing="0" cellpadding="1" width="100%">
			      <tr>
				     <td class="main"><span class="main"><?php echo ENTRY_ANTIROBOTREG; ?></span></td>
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
         <?php
         }
        }
        ?>
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
 <!-- // EOF Anti Robot Registration v2.2-->

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
        <td><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
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

</table>
</form>