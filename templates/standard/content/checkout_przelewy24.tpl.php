<?php
/*
  $Id: \templates\standard\content\checkout_przelewy24.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('order', 'https://secure.przelewy24.pl/index.php'); ?>

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
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="4" cellpadding="2">
       <tr>
        <td valign="top"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/przelewy24_logo.gif', HEADING_TITLE); ?></td>
        <td valign="top" class="main"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?><div align="center" class="pageHeading"><?php echo HEADING_TITLE; ?></div><br><?php echo TEXT_SUCCESS; ?><br><br>
        <h4><?php echo TEXT_THANKS_FOR_SHOPPING.TEXT_CONTINUE; ?></h4></td>
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
  <td align="right" class="main"><?php echo $process_button_string.tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
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
     <td width="25%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
     <td width="25%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
     <td width="25%">
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
       <tr>
        <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
        <td width="50%"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/checkout_bullet.gif'); ?></td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td align="center" width="25%" class="checkoutBarFrom"><?php echo CHECKOUT_BAR_DELIVERY; ?></td>
     <td align="center" width="25%" class="checkoutBarFrom"><?php echo CHECKOUT_BAR_PAYMENT; ?></td>
     <td align="center" width="25%" class="checkoutBarFrom"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>
     <td align="center" width="25%" class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_FINISHED; ?></td>
    </tr>
   </table>
  </td>
 </tr>
</table>
</form>
