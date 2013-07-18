<?php
/*
  $Id: \templates\standard\content\account_edit.tpl.php; 10.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('account_edit', tep_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'), 'post', 'onSubmit="return check_form(account_edit);"') . tep_draw_hidden_field('action', 'process'); ?>

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
 if ($messageStack->size('account_edit') > 0) {
 ?>
 <tr>
  <td><?php echo $messageStack->output('account_edit'); ?></td>
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
        <td class="main"><b><?php echo MY_ACCOUNT_TITLE; ?></b></td>
        <td class="inputRequirement" align="right"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
       </tr>
      </table>
	 </td>
    </tr>
    
	<tr>
     <td>
	  <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
       <tr class="infoBoxContents">
        <td>
		 <table border="0" cellspacing="2" cellpadding="2">
          <?php
          if (ACCOUNT_GENDER == 'true') {
           if (isset($gender)) {
            $male = ($gender == 'm') ? true : false;
           } else {
            $male = ($account['customers_gender'] == 'm') ? true : false;
           }
           $female = !$male;
          ?>
          <tr>
           <td class="main"><?php echo ENTRY_GENDER; ?></td>
           <td class="main"><?php echo tep_draw_radio_field('gender', 'm', $male) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('gender', 'f', $female) . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (tep_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?></td>
          </tr>
          <?php
          }
          ?>
          
		  <tr>
           <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
           <td class="main"><?php echo tep_draw_input_field('firstname', $account['customers_firstname']) . '&nbsp;' . (tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></td>
          </tr>
          <tr>
           <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
           <td class="main"><?php echo tep_draw_input_field('lastname', $account['customers_lastname']) . '&nbsp;' . (tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></td>
          </tr>
          
		  <?php
          if (ACCOUNT_DOB == 'true') {
          ?>
          <tr>
           <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
           <td class="main"><?php echo tep_draw_input_field('dob', tep_date_short($account['customers_dob'])) . '&nbsp;' . (tep_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>': ''); ?></td>
          </tr>
          <?php
          }
          ?>

		  <tr>
           <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
           <td class="main"><?php echo tep_draw_input_field('email_address', $account['customers_email_address']) . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
          </tr>
          <tr>
           <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
           <td class="main"><?php echo tep_draw_input_field('telephone', $account['customers_telephone']) . '&nbsp;' . (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?></td>
          </tr>
          <tr>
           <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
           <td class="main"><?php echo tep_draw_input_field('fax', $account['customers_fax']) . '&nbsp;' . (tep_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_FAX_NUMBER_TEXT . '</span>': ''); ?></td>
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
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
 </tr>

 <!-- // BOF Anti Robot Registration v2.2-->
 <?php
 if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'account_edit') &&  ACCOUNT_EDIT_VALIDATION == 'true') {
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
    if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'account_edit') &&  ACCOUNT_EDIT_VALIDATION == 'true') {
      if ($is_read_only == false || (strstr($PHP_SELF,'account_edit')) ) {
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
          ?>
         <?php
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
 ?>
 <!-- // EOF Anti Robot Registration v2.2-->


 <!-- Przyciski BOF -->
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