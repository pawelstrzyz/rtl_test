<?php
/*
  $Id: \templates\standard\content\create_account_success.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

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
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td>
	     <?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/table_background_man_on_board.gif', HEADING_TITLE); ?>
	    </td>
        <td class="main"><?php echo TEXT_ACCOUNT_CREATED;
         $customersenable = NEW_CUSTOMERS_ENABLED; 
         if ($customersenable=='true') {
          echo TEXT_ACCOUNT_CREATED_ENABLE;
         } else {
          echo TEXT_ACCOUNT_CREATED_DISABLE;
         }
		 $cust_status = 0;
		 ?>
		</td>
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
        <td align="right"><?php echo '<a href="' . $origin_href . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
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