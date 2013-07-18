<?php
/*
  $Id: \includes\boxes\newsletter.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
$boxHeading = BOX_HEADING_SUBSCRIBERS;
$corner_left = 'rounded';
$corner_right = 'rounded';
$box_base_name = 'newsletter'; // for easy unique box template setup (added BTSv1.2)
$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)
?>
<?php
$boxContent = '<table border="0" width="100%" cellspacing="0" cellpadding="1" align="center">';
$boxContent .= '  <tr>
	   
	   <tr><td align="left" class="boxContents"><input type="text" name="Email" value="" maxlength="35" style="width: 120px;"> </td><td class="boxContents">' . TEXT_EMAIL . '</td></tr>
	   <tr><td align="left" class="boxContents"><input type="text" name="lastname" value=""  maxlength="35" style="width: 120px;"></td><td class="boxContents">'.TEXT_NAME.'</td></tr>
		<tr><td ></td><td align="left">'. tep_image_submit('button_quick_find.gif') . '</form></td></tr>
		 <td class="smallText" align="center" colspan="2"><span class="smallText">&nbsp;'.TEXT_BOX1.' <a class="boxLink" href="' . tep_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'NONSSL') . '"><u>'.TEXT_BOX2.'</u></a></span></td></tr>';
$boxContent .= '</table>';
//<tr><td align="left" >'.tep_draw_form('newsletter', tep_href_link(FILENAME_NEWSLETTERS_SUBSCRIBE, '', 'NONSSL', false), 'post'). ''. TEXT_EMAIL . '</td></tr>
include (bts_select('boxes', $box_base_name)); // BTS 1.5
?>