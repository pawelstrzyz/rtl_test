<?php
/*

 mod eSklep-Os http://www.esklep-os.com

*/

  $boxHeading = BOX_HEADING_KONTAKT;
  $corner_left = 'rounded';
  $corner_right = 'rounded';
  $boxContent_attributes = ' align="center"';
  $box_base_name = 'kontakt'; // for easy unique box template setup (added BTSv1.2)

  $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

//  $info_box_contents = array();
//  $info_box_contents[] = array('text' => BOX_INFORMATION_CONTACT);

//  new infoBoxHeading($info_box_contents, true, true);

$boxContent = '<table border="0" cellspacing="0" cellpadding="2" width="100%" align ="center">';

if(KONTAKT_EMAIL_1 && tep_not_null(KONTAKT_EMAIL_1)) {
$boxContent .= '<tr>
				<td align="center" class="main" width="25">' . tep_image(DIR_WS_TEMPLATES . 'images/misc/icons/iemail.gif', 'e-mail') . '</td><td align="left" class="main"><a class="boxLink" href="'.FILENAME_CONTACT_US.'"><strong>'.KONTAKT_EMAIL_1.' </strong></a></td>
           </tr>';
}

if(KONTAKT_FAX_1 && tep_not_null(KONTAKT_FAX_1)) {
$boxContent .= '<tr>
				<td align="center" class="main" width="25">' . tep_image(DIR_WS_TEMPLATES . 'images/misc/icons/fax.gif', 'FAX') . '</td><td align="left" class="main"><strong>'.KONTAKT_FAX_1.'</strong></td>
             </tr>';
}

if(KONTAKT_TELEFON_1 && tep_not_null(KONTAKT_TELEFON_1)) {
$boxContent .= '<tr>
				<td align="center" class="main" width="25">' . tep_image(DIR_WS_TEMPLATES . 'images/misc/icons/t_n.gif', 'Tel') . '</td><td align="left" class="main"><strong>'.KONTAKT_TELEFON_1.'</strong></td>
			</tr>';
}

if(KONTAKT_GSM_1 && tep_not_null(KONTAKT_GSM_1)) {
 $boxContent .= '<tr>
				<td align="center" class="main" width="25">' . tep_image(DIR_WS_TEMPLATES . 'images/misc/icons/t_k.gif', 'GSM') . '</td><td align="left" class="main"><strong>'.KONTAKT_GSM_1.' </strong></td>
			</tr>';
}

if(KONTAKT_NR_GG_1 && tep_not_null(KONTAKT_NR_GG_1)) {
$boxContent .= '<tr>
				<td align="center" class="main" width="25"><img src="http://status.gadu-gadu.pl/users/status.asp?id='.KONTAKT_NR_GG_1.'&amp;styl=1" align="middle" alt="GG"></td><td align="left" class="main"><a class="boxLink" href="gg:'.KONTAKT_NR_GG_1.'"><strong>'.KONTAKT_NR_GG_1.' </strong></a></td>
			</tr>';
}

if(KONTAKT_NR_TLEN_1 && tep_not_null(KONTAKT_NR_TLEN_1)) {
$boxContent .= '<tr>
				<td align="center" class="main" width="25"><img src="http://status.tlen.pl/?u='.KONTAKT_NR_TLEN_1.'&amp;t=2" align="middle" alt="Tlen"></td><td align="left" class="main"><a class="boxLink"  href="http://ludzie.tlen.pl/'.KONTAKT_NR_TLEN_1.'"><strong>'.KONTAKT_NR_TLEN_1.' </strong></a></td>
			</tr>';
}

if(KONTAKT_NR_WP_1 && tep_not_null(KONTAKT_NR_WP_1)) {
$boxContent .= '<tr>
				<td align="center" class="main" width="25"><img src="http://kontakt.wp.pl/status.html?login='.KONTAKT_NR_WP_1.'&amp;styl=0" align="middle" alt="WP Kontakt"></td><td align="left" class="main"><strong>'.KONTAKT_NR_WP_1.' </strong></a></td>
			</tr>';

}

if(KONTAKT_SKYPE_1 && tep_not_null(KONTAKT_SKYPE_1)) {
$boxContent .= '<tr>
				<td align="center" class="main" width="25">' . tep_image(DIR_WS_TEMPLATES . 'images/misc/icons/skype.jpg', 'Skype') . '</td><td align="left" class="main"><strong><a class="boxLink" href="CALLTO://'.KONTAKT_SKYPE_1.'"> '.KONTAKT_SKYPE_1.' </a></strong></td>
			</tr>';
}

if(KONTAKT_GODZINY_1 && tep_not_null(KONTAKT_GODZINY_1)) {

}

$boxContent .= '<tr><td align="center" class="smallText" colspan="2"></td></tr>';


$boxContent .= '</table>';

include (bts_select('boxes', $box_base_name)); // BTS 1.5

$boxContent_attributes = '';

?>