<?php
/*
  $Id: \templates\standard\content\create_account.tpl.php; 09.07.2006

  oscGold, Autorska dystrybucja osCommerce
  http://www.oscgold.com
  autor: Jacek Krysiak

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
        <td><table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">	
 <!-- Naglowek EOF -->
      
 <tr>
  <td class="smallText">&nbsp;&nbsp;<?php echo sprintf(TEXT_ORIGIN_LOGIN, tep_href_link(FILENAME_LOGIN, tep_get_all_get_params(), 'SSL')); ?><br>&nbsp;</td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 
<?php
 if ($messageStack->size('create_account') > 0) {
 ?>
 <tr>
  <td><?php echo $messageStack->output('create_account'); ?></td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
<?php
 }
?>


 
<tr>
<td> 


	<table border="0" cellspacing="2" cellpadding="2" width="100%">
		<tr>
			<td class="smallText">
				<?php echo OSOBA_TEXT; ?>
			</td>
		</tr>
		<tr>
			<td class="smallText">
				<form id="wybor" action="create_account.php" method="POST">
				<?php
				if (isset($_POST['osoba'])) {
					$rodzaj_osoby = $_POST['osoba'];
				   } else {
				    $rodzaj_osoby = 'fizyczna';
				}
				?>				
				<input type="radio" name="osoba" value="fizyczna" 
				<?php
				if ($rodzaj_osoby == 'fizyczna') {
					echo 'checked';
				}
				?>
				onclick="this.form.submit();"/><?php echo FORM_OSOBA_FIZYCZNA; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="osoba" value="firma" 
				<?php
				if ($rodzaj_osoby == 'firma') {
					echo 'checked';
				}
				?>
				onclick="this.form.submit();"/><?php echo FORM_OSOBA_PRAWNA; ?><br>
				</form>
			</td>
		</tr>
	</table>

</td>
</tr>

<?php echo tep_draw_form('create_account', tep_href_link(FILENAME_CREATE_ACCOUNT, (isset($HTTP_GET_VARS['guest'])? 'guest=guest':''), 'SSL'), 'post', 'onSubmit="return check_form(create_account);"') . tep_draw_hidden_field('action', 'process'); ?> 

<?php
if (isset($_POST['osoba'])) {
	$rodzaj_osoby = $_POST['osoba'];
   } else {
    $rodzaj_osoby = 'fizyczna';
}
?>
 
<!-- //////////////// FIRMA ///////////////-->
 <?php
if ($rodzaj_osoby == 'firma') {
 ?> 
	 
 <tr>
  <td align="right">
	<span class="inputRequirement"><br><?php echo POLA_OBOWIAZKOWE; ?>&nbsp;&nbsp</span>
  </td>
 </tr>
    <tr>
  <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
 </tr>
 <tr>
  <td>
		
		<legend><b><?php echo CATEGORY_COMPANY; ?></b></legend>

	  <table border="0" cellspacing="2" cellpadding="2" width="100%">

	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_COMPANY; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('company', '', 'size="35"') . '&nbsp;' . '<span class="inputRequirement">*</span>'; ?><input type="hidden" name="osoba" value="firma"></td>
	   </tr>
	   <!-- Insert by Pazio pazio@sitenet.pl start -->
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_NIP; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('nip', '', 'size="35"') . '&nbsp;' . '<span class="inputRequirement">*</span>'; ?></td>
	   </tr>
	   <!-- Insert by Pazio pazio@sitenet.pl end -->
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('email_address', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_EMAIL_ADDRESS_CONFIRM; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('email_address_confirm', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_CONFIRM) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
	   </tr>
	  </table>
		
  </td>
 </tr>
    <tr>
  <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
 </tr>
 <tr>
  <td>
		
		<legend><b><?php echo CATEGORY_ADDRESS; ?><b></legend>
	  <table border="0" cellspacing="2" cellpadding="2" width="100%">
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_STREET_ADDRESS; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('street_address', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <?php
	   if (ACCOUNT_SUBURB == 'true') {
	   ?>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_SUBURB; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('suburb', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <?php
	   }
	   ?>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_POST_CODE; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('postcode', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_CITY; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('city', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <?php
	   if (ACCOUNT_STATE == 'true') {
	   ?>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_STATE; ?></td>
		<td class="main" width="63%" align="left">
		 <?php
		 // +Country-State Selector
		 $zones_array = array();
		 $zones_query = tep_db_query("select zone_id, zone_name from " . TABLE_ZONES . " where zone_country_id = " . (int)$country . " order by zone_name");
		 while ($zones_values = tep_db_fetch_array($zones_query)) {
		  $zones_array[] = array('id' => $zones_values['zone_id'], 'text' => $zones_values['zone_name']);
		 }
		 if (count($zones_array) > 0) {
		  echo tep_draw_pull_down_menu('zone_id', $zones_array);
		 } else {
		  echo tep_draw_input_field('state');
		 }
		 // -Country-State Selector
		 if (tep_not_null(ENTRY_STATE_TEXT)) echo ' <span class="inputRequirement">' . ENTRY_STATE_TEXT;
		 ?>
		</td>
	   </tr>
	   <?php
	   }
	   ?>
	   <tr>
		<td class="main" width="37%"><b><?php echo ENTRY_COUNTRY; ?></b></td>
		<?php // +Country-State Selector ?>
		<td class="main" width="63%" align="left"><?php echo tep_get_country_list('country',$country,'onChange="return refresh_form(create_account);"') . '&nbsp;' .(tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
		<?php // -Country-State Selector ?>
	   </tr>
	  </table>
		
  </td>
 </tr>
    <tr>
  <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
 </tr>
 <tr>
  <td>
		
		<legend><b><?php echo CATEGORY_CONTACT; ?></b></legend>
	  <table border="0" cellspacing="2" cellpadding="2" width="100%">
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_FIRST_NAME; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('firstname', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_LAST_NAME; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('lastname', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></td>
	   </tr>		  
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('telephone', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_FAX_NUMBER; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('fax', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_FAX_NUMBER_TEXT . '</span>': ''); ?></td>
	   </tr>
	  </table>
		
  </td>
 </tr>
 
 <?php
	}
 ?>
 
<!-- //////////////// OSOBA FIZYCZNA ///////////////-->
 <?php
if ($rodzaj_osoby == 'fizyczna') {
 ?> 

 <tr>
  <td align="right">
	<span class="inputRequirement"><br><?php echo POLA_OBOWIAZKOWE; ?>&nbsp;&nbsp</span>
  </td>
 </tr>	 
    <tr>
  <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
 </tr>
 <tr>
  <td>
		
		<legend><b><?php echo CATEGORY_PERSONAL; ?></b></legend>
	  <table border="0" cellspacing="2" cellpadding="2" width="100%">
	   <?php
	   if (ACCOUNT_GENDER == 'true') {
	   ?>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_GENDER; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_radio_field('gender', 'm') . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('gender', 'f') . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (tep_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <?php
	   }
	   ?>		  
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_FIRST_NAME; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('firstname', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?><input type="hidden" name="osoba" value="fizyczna"></td>
	   </tr>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_LAST_NAME; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('lastname', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <?php if ( ACCOUNT_NIP == 'true') { ?>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_NIP; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('nip', '', 'size="35"')?></td>
	   </tr>	
	   <?php
	   }
	   ?>
	   <?php
	   if (ACCOUNT_DOB == 'true') {
	   ?>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('dob', '', 'size="20"') . '&nbsp;' . (tep_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <?php
	   }
	   ?>		   
	  </table>
		
  </td>
 </tr>
    <tr>
  <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
 </tr>
 <tr>
  <td>
		
		<legend><b><?php echo CATEGORY_ADDRESS; ?></b></legend>
	  <table border="0" cellspacing="2" cellpadding="2" width="100%">
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_STREET_ADDRESS; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('street_address', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <?php
	   if (ACCOUNT_SUBURB == 'true') {
	   ?>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_SUBURB; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('suburb', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <?php
	   }
	   ?>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_POST_CODE; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('postcode', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_CITY; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('city', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <?php
	   if (ACCOUNT_STATE == 'true') {
	   ?>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_STATE; ?></td>
		<td class="main" width="63%" align="left">
		 <?php
		 // +Country-State Selector
		 $zones_array = array();
		 $zones_query = tep_db_query("select zone_id, zone_name from " . TABLE_ZONES . " where zone_country_id = " . (int)$country . " order by zone_name");
		 while ($zones_values = tep_db_fetch_array($zones_query)) {
		  $zones_array[] = array('id' => $zones_values['zone_id'], 'text' => $zones_values['zone_name']);
		 }
		 if (count($zones_array) > 0) {
		  echo tep_draw_pull_down_menu('zone_id', $zones_array);
		 } else {
		  echo tep_draw_input_field('state');
		 }
		 // -Country-State Selector
		 if (tep_not_null(ENTRY_STATE_TEXT)) echo ' <span class="inputRequirement">' . ENTRY_STATE_TEXT;
		 ?>
		</td>
	   </tr>
	   <?php
	   }
	   ?>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_COUNTRY; ?></td>
		<?php // +Country-State Selector ?>
		<td class="main" width="63%" align="left"><?php echo tep_get_country_list('country',$country,'onChange="return refresh_form(create_account);"') . '&nbsp;' .(tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
		<?php // -Country-State Selector ?>
	   </tr>
	  </table>
		
  </td>
 </tr>
    <tr>
  <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
 </tr>
 <tr>
  <td>
		
		<legend><b><?php echo CATEGORY_CONTACT; ?></b></legend>
	  <table border="0" cellspacing="2" cellpadding="2" width="100%">
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('email_address', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_EMAIL_ADDRESS_CONFIRM; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('email_address_confirm', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_CONFIRM) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
	   </tr>   		  
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('telephone', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_FAX_NUMBER; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('fax', '', 'size="35"') . '&nbsp;' . (tep_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_FAX_NUMBER_TEXT . '</span>': ''); ?></td>
	   </tr>
	  </table>
		
  </td>
 </tr>
 
 <?php
	}
 ?>	 
 
 <?php
 // Ingo PWA Beginn
 if (!isset($HTTP_GET_VARS['guest'])) {
 ?>
    <tr>
  <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
 </tr>
 <tr>
  <td>
		
		<legend><b><?php echo CATEGORY_OPTIONS; ?></b></legend>
		
	  <table border="0" cellspacing="2" cellpadding="2" width="100%">
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_NEWSLETTER; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_checkbox_field('newsletter', '1') . '&nbsp;' . (tep_not_null(ENTRY_NEWSLETTER_TEXT) ? '<span class="inputRequirement">' . ENTRY_NEWSLETTER_TEXT . '</span>': ''); ?></td>
	   </tr>
	   <tr>
		<td colspan="2" class="smallText">
			<?php echo ZGODA_DANE_OSOBOWE; ?>				
		</td>
	   </tr>
	  </table>
		
  </td>
 </tr>
    <tr>
  <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
 </tr>
 <!-- BOC Added for Account Agreement -->
 <?php
 } // Ingo PWA Ende
 ?>
 <?php
 if (!isset($HTTP_GET_VARS['guest']) && (PROMO_POLECONY_STATUS == 'true')) {
 ?>
 <tr>
  <td>
		
		<legend><b><?php echo TITLE_PROMOCJA_POLECONY; ?></b></legend>
	  <table border="0" cellspacing="2" cellpadding="2" width="100%">
	   <tr>
		<td class="main" width="37%"><?php echo ENTRY_EMIAL_POLECAJACY; ?></td>
		<td class="main" width="63%" align="left"><?php echo tep_draw_input_field('polecajacy', '', 'size="35"'); ?></td>
	   </tr>
	  </table>
		
  </td>
 </tr>
   <tr>
  <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
 </tr>
 <?php
 }
 ?>

 <tr>
  <td>
		
		<legend><b><?php echo TEXT_ACCOUNT_AGREEMENT; ?></b></legend>
	  <table border="0" cellspacing="2" cellpadding="2">
	   <tr>
		<td class="main"><?php echo tep_draw_checkbox_field('agreement', '1') . '&nbsp;' . (tep_not_null(ENTRY_AGREEMENT_TEXT) ? '<span class="inputRequirement">' . ENTRY_AGREEMENT_TEXT . '</span>' . ENTRY_AGREEMENT : ''); ?> </td>
	   </tr>
	   <tr>
		<td colspan="2" class="smallText">
			<?php echo PRZETWARZANIE_DANYCH; ?>
		</td>
	   </tr>		   
	  </table>
		
  </td>
 </tr>
    <tr>
  <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
 </tr>
 <!-- EOC Added for Account Agreement --> 

 <!-- // BOF Anti Robot Registration v2.2-->
 <?php
 if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'create_account') &&  ACCOUNT_CREATE_VALIDATION == 'true') {
 ?>
 <tr>
  <td>
		
		<legend><b><?php echo CATEGORY_ANTIROBOTREG; ?></b></legend>
	  <table align="left" border="0" cellspacing="2" cellpadding="2" width="100%">
	   <?php
	  if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'create_account') &&  ACCOUNT_CREATE_VALIDATION == 'true') {
		if ($is_read_only == false || (strstr($PHP_SELF,'create_account')) ) {
		  $sql = "DELETE FROM " . TABLE_ANTI_ROBOT_REGISTRATION . " WHERE timestamp < '" . (time() - 3600) . "' OR session_id = '" . tep_session_id() . "'";
		  if( !$result = tep_db_query($sql) ) { die('Could not delete validation key'); }
			$reg_key = gen_reg_key();
			$sql = "INSERT INTO ". TABLE_ANTI_ROBOT_REGISTRATION . " VALUES ('" . tep_session_id() . "', '" . $reg_key . "', '" . time() . "')";
			if( !$result = tep_db_query($sql) ) { die('Could not check registration information'); }
		 ?>
		 <tr>
		  <td class="main">
		   <table align="center" border="0" width="100%" cellspacing="0" cellpadding="1">
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
 <?php
 }
 ?>
 <!-- // EOF Anti Robot Registration v2.2-->
 <?php
 if (!isset($HTTP_GET_VARS['guest'])) {
 ?>
    <tr>
  <td align="center"><?php echo tep_draw_separator('pixel_black.gif', '95%', '1'); ?></td>
 </tr>
 <tr>
  <td>
		
		<legend><b><?php echo CATEGORY_PASSWORD; ?></b></legend>
	  <table border="0" cellspacing="2" cellpadding="2">
	   <tr>
		<td class="main"><?php echo ENTRY_EMAIL_WARNING; ?></td>
	   </tr>
	  </table>
		
  </td>
 </tr>
<?php } ?>

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
 <!-- Przyciski EOF -->

</table>
</form>
