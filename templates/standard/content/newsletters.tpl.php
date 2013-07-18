<?php
/*
  $Id: \templates\standard\content\newsletters.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
	<tr>  
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo NAVBAR_TITLE; ?></td>
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
	    <td CLASS="main"><? echo TEXT_ORIGIN_EXPLAIN_TOP; ?></td>
       </tr>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>
	   <tr>
	    <td>
         <form NAME="newsletter" ACTION="<? echo tep_href_link(FILENAME_NEWSLETTERS_SUBSCRIBE, '', 'NONSSL'); ?>" METHOD="post" onSubmit="return verify(this);">
         <input type="hidden" name="submitted" value="true">
         <table cellspacing=2 cellpadding=2 border=0 width="75%" class="topBarTitle">
          <tr>
           <td class="main"><? echo TEXT_EMAIL; ?>&nbsp;&nbsp;&nbsp;</td>
           <td>&nbsp;</td>
           <td><input type="text" name="Email" value="" size="25" maxlength="50"></td>
          </tr>
          <tr>
           <td CLASS="main"><? echo TEXT_EMAIL_FORMAT; ?>&nbsp;&nbsp;&nbsp;</td>
           <td>&nbsp;</td>
           <td CLASS="main"><input type="radio" name="email_type" value="HTML"><? echo TEXT_EMAIL_HTML; ?></input> - <input type="radio" name="email_type" value="TEXT" checked><? echo TEXT_EMAIL_TXT; ?></input></td>
          </tr>
          <tr>
           <td CLASS="main"><? echo TEXT_GENDER; ?>&nbsp;&nbsp;&nbsp;</td>
           <td>&nbsp;</td>
           <td CLASS="main"><input type="radio" name="gender" value="m"  checked><? echo TEXT_GENDER_MR; ?></input> - <input type="radio" name="gender" value="f"><? echo TEXT_GENDER_MRS; ?></input></td>
          </tr>
          <tr>
           <td CLASS="main"><? echo TEXT_FIRST_NAME; ?>&nbsp;&nbsp;&nbsp;</td>
           <td>&nbsp;</td>
           <td><input type="text" name="firstname" value="" size="25" maxlength="50"></td>
          </tr>
          <tr>
           <td CLASS="main"><? echo TEXT_LAST_NAME; ?>&nbsp;&nbsp;&nbsp;</td>
           <td>&nbsp;</td>
		   <td class="main"><input type="text" name="lastname" value="" size="25" maxlength="50"></td>
          </tr>
          <tr>
           <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
            <td>&nbsp;</td>
            <td class="main"><?php  echo tep_get_country_list('country',  $subscribers_country_id ) . '&nbsp;' ;?></td>
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
        <td><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
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