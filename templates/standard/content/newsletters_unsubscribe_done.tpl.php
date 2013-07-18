<?php
/*
  $Id: \templates\standard\content\newsletters_unsubscribe_done.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

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
        <?php
        // If we found the customers email address, and they currently subscribe
        if ($cus_subscribe) {
        // Unsubscribe them
        tep_db_query("UPDATE customers SET customers_newsletter = '0' WHERE customers_email_address = '" .$email_to_unsubscribe . "'");
        tep_db_query("UPDATE subscribers SET customers_newsletter = '0' WHERE subscribers_email_address = '" .$email_to_unsubscribe . "'");
//              tep_db_query("DELETE from subscribers WHERE subscribers_email_address = '" .$email_to_unsubscribe . "'");

        ?>
        <td class="main"><?php echo UNSUBSCRIBE_DONE_TEXT_INFORMATION . $email_to_unsubscribe; ?></td>
        <?php 
        // Otherwise, we want to display an error message (This should never occur, unless they try to unsubscribe twice)
        } else {
        ?>
        <td class="main"><?php echo UNSUBSCRIBE_ERROR_INFORMATION . $email_to_unsubscribe; ?></td>
        <?php
        }
        ?>
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
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
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