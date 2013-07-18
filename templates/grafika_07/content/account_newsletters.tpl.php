<?php
/*
  $Id: \templates\standard\content\account_newsletters.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('account_newsletter', tep_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL')) . tep_draw_hidden_field('action', 'process'); ?>

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
 
 <tr>
  <td class="main"><b><?php echo MY_NEWSLETTERS_TITLE; ?></b></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td>
		 <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="checkBox('newsletter_general')">
           <td class="main"><?php echo tep_draw_checkbox_field('newsletter_general', '1', (($newsletter['customers_newsletter'] == '1') ? true : false), 'onclick="checkBox(\'newsletter_general\')"'); ?></td>
           <td class="main"><b><?php echo MY_NEWSLETTERS_GENERAL_NEWSLETTER; ?></b></td>
          </tr>
          <tr>
           <td class="main">&nbsp;</td>
           <td>
		    <table border="0" cellspacing="0" cellpadding="2">
             <tr>
              <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              <td class="main"><?php echo MY_NEWSLETTERS_GENERAL_NEWSLETTER_DESCRIPTION; ?></td>
              <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
             </tr>
            </table>
		   </td>
          </tr>
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
