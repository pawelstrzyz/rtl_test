<?php
/*
  $Id: \includes\boxes\loginbox.php; 05.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

$corner_left = 'rounded';
$corner_right = 'rounded';

$box_base_name = 'loginbox'; // for easy unique box template setup (added BTSv1.2)

$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)
require(DIR_WS_LANGUAGES . $language . '/' . $box_base_name . '_box.php'); //

if ( (!strstr($_SERVER['PHP_SELF'],'login.php')) and (!strstr($_SERVER['PHP_SELF'],'create_account.php')) and !tep_session_is_registered('customer_id') )  {
 if (!tep_session_is_registered('customer_id')) {
     $boxHeading = BOX_LOGIN_HEADING;
     $boxContent = "" . tep_draw_form('login', tep_href_link(FILENAME_LOGIN, 'action=process', 'SSL')) ."
        <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"1\"><tr>
         <td align=\"center\" class=\"boxText\">" . ENTRY_EMAIL_ADDRESS . "</td>
        </tr>
        <tr>
         <td align=\"center\" class=\"boxText\"><input type=\"text\" name=\"email_address\" maxlength=\"96\" size=\"20\" value=\"\"></td>
        </tr>
        <tr>
         <td align=\"center\" class=\"boxText\">" . ENTRY_PASSWORD . "</td>
        </tr>
        <tr>
         <td align=\"center\" class=\"boxText\"><input type=\"password\" name=\"password\" maxlength=\"40\" size=\"20\" value=\"\"></td>
        </tr>";
		     $boxContent .= "<tr>
         <td align=\"center\" class=\"boxText\"><br>" . tep_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN) . "</td>
        </tr>
       </table>
	   </form>
	   <BR>
       <center>
       <A class=\"boxLink\" HREF=\"" . tep_href_link(FILENAME_LOGIN, '', 'SSL') . "\">" . LOGIN_BOX_SECURE_LOGIN . "</A><BR>
        " . tep_draw_separator('pixel_trans.gif', '9', '2') . "<BR><A class=\"boxLink\" HREF=\"" . tep_href_link(FILENAME_CREATE_ACCOUNT, '','SSL') . "\">" . LOGIN_BOX_NEW_USER . "</A><BR>
        " . tep_draw_separator('pixel_trans.gif', '9', '2') . "<BR><A class=\"boxLink\" HREF=\"" . tep_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . "\">" . LOGIN_BOX_PASSWORD_FORGOTTEN . "</A>
       </center>";
       include (bts_select('boxes', $box_base_name)); // BTS 1.5
    ?>
  <?php
 } else {

  // If you want to display anything when the user IS logged in, put it
  // in here...  Possibly a "You are logged in as :" text or something.
 }
 ?>
 <!-- loginbox_eof //-->
 <?php
 // WebMakers.com Added: My Account Info Box
 } else {
  if (tep_session_is_registered('customer_id')) {
   $boxHeading = BOX_HEADING_LOGIN_BOX_MY_ACCOUNT;
   $boxContent =
   '<table border="0" width="100%" cellspacing="0" cellpadding="1"><tr>
    <td align="center" width="20">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" width="155">
     <a class="boxLink" href="' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . LOGIN_BOX_MY_ACCOUNT . '</a><td></tr><tr>
    <tr><td align="center" width="100%" colspan="2">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</td></tr>
	 <td align="center" width="20">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" width="155">
	 <a class="boxLink" href="' . tep_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL') . '">' . LOGIN_BOX_ACCOUNT_EDIT . '</a><td></tr><tr>
    <tr><td align="center" width="100%" colspan="2">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</td></tr>
    <td align="center" width="20">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" width="155">
	 <a class="boxLink" href="' . tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . LOGIN_BOX_ADDRESS_BOOK . '</a><td></tr><tr>
    <tr><td align="center" width="100%" colspan="2">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</td></tr>
    <td align="center" width="20">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" width="155">
	 <a class="boxLink" href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">' . LOGIN_BOX_ACCOUNT_HISTORY . '</a><td></tr><tr>
    <tr><td align="center" width="100%" colspan="2">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</td></tr>
    <td align="center" width="20">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" width="155">
	 <a class="boxLink" href="' . tep_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'NONSSL') . '">' . LOGIN_BOX_PRODUCT_NOTIFICATIONS . '</a><td></tr><tr>
    <tr><td align="center" width="100%" colspan="2">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</td></tr>
    <td align="center" width="20">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" width="155">
	<a class="boxLink" href="' . tep_href_link(FILENAME_LOGOFF, '', 'NONSSL') . '">' . HEADER_TITLE_LOGOFF . '</a>
    </td>
   </tr></table>';
  include (bts_select('boxes', $box_base_name)); // BTS 1.5
   ?>
   <?php
 }
}
?>