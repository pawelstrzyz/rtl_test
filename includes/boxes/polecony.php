<?php
/*
  $Id: \includes\boxes\info_pages.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

$boxHeading = BOX_HEADING_POLECONY;
$corner_left = 'rounded';
$corner_right = 'rounded';
$box_base_name = 'polecony'; // for easy unique box template setup (added BTSv1.2)

$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

$boxContent = '<table border="0" width="100%" cellspacing="0" cellpadding="3">';

$boxContent .= '<tr><td class="boxContents" width="100%" align="center">';
$boxContent .= BOX_CONTENT_POLECONY . '</td></tr>';
$boxContent .= '<tr><td align="center" class="boxContents"><A class="boxLink" HREF="' . tep_href_link(FILENAME_DESC_POLECONY) . '"><b>"'.BOX_DESC_POLECONY.'"</b></a></td></tr>';

if (tep_session_is_registered('customer_id')) {
		 $boxContent .= '<tr><td align="center"class="boxContents"><A class="boxLink" HREF="' . tep_href_link(FILENAME_FORM_POLECONY) . '"><b>'.BOX_LINK_POLECONY.'</b></a></td></tr>';
}

$boxContent .= '</table>';

include (bts_select('boxes', $box_base_name)); // BTS 1.5
?>
