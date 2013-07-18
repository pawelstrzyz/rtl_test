<?php
/*
  $Id: \templates\standard\content\conditions.tpl.php; 09.07.2006



  Licencja: GNU General Public License
*/
?>

<?php
$pay_types_url = "https://www.platnosci.pl/paygw/UTF/js/";
$pay_types_url .= MODULE_PAYMENT_PLATNOSCI_POS_ID;
$pay_types_url .= "/";
$pay_types_url .= substr(MODULE_PAYMENT_PLATNOSCI_KEY1,0,2);
$pay_types_url .= "/paytype.js";
?>

<?php echo tep_draw_form('platnosci', tep_href_link(FILENAME_PLATNOSCI, 'action=process'), 'post'); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->


<?php
 if ($messageStack->size('platnosci') > 0) {
 ?>
 <tr>
  <td><?php echo $messageStack->output('platnosci'); ?></td>
 </tr>
 <?php
 }
 ?>
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
     <td class="main" colspan="2">
		 <?php echo PLATNOSCI_DESCRIPTION; ?>
	  </td>
 <script language='JavaScript' type='text/JavaScript'
   src='<?php echo $pay_types_url;?>'>
 </script>

 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td class="main" colspan="2">
  				<script language='JavaScript' type='text/javascript'>
           	PlnDrawRadioImg(3);
					</script>
				</td>
       </tr>
       <tr>
				<td class="main" nowrap><b><?php echo TEXT_AMOUNT;?>:</b></td>
				<td class="main"><?php echo tep_draw_input_field('amount_zl'); ?> zł <?php echo tep_draw_input_field('amount_gr', '','size="4"') . ' gr&nbsp;<span class="inputRequirement">*</span>'; ?></td>
			 </tr>
       <tr>
				<td class="main" nowrap><b><?php echo ENTRY_TITLE;?> :</b></td>
				<td class="main"><?php echo tep_draw_input_field('desc', '','size="50"'). '&nbsp;<span class="inputRequirement">*</span>'; ?></td>
			 </tr>
       <tr>
				<td class="main" valign="top" nowrap><b><?php echo ENTRY_COMMENTS;?> :</b></td>
				<td class="main"><?php echo tep_draw_textarea_field('desc2', 'soft', 50, 4, tep_sanitize_string($_POST['desc2']), '', false); ?></td>
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
        <td align="right"><?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
</table>
</form>