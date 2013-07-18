<?php
/*
  $Id: \includes\boxes\info_pages.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

    $page_query = tep_db_query("select  p.pages_id, p.sort_order, p.status, p.page_type, s.pages_title, s.pages_html_text, s.intorext, s.externallink, s.link_target   from " . TABLE_PAGES . " p LEFT JOIN " .TABLE_PAGES_DESCRIPTION . " s on p.pages_id = s.pages_id where p.status = 1 and s.language_id = '" .(int)$languages_id . "' order by p.sort_order, s.pages_title");

?>
<!-- info_pages //-->
<?php
$boxHeading = BOX_HEADING_INFORMATION;
$corner_left = 'rounded';
$corner_right = 'rounded';
$box_base_name = 'info_pages'; // for easy unique box template setup (added BTSv1.2)

$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

$boxHeading = BOX_HEADING_PAGES;

$rows = 0;
$boxContent = '<table border="0" width="100%" cellspacing="0" cellpadding="1">';

while ($page = tep_db_fetch_array($page_query)) {
 $rows++;

 $target="";
 if($page['link_target']== 1)  {
   $target="_blank";
 } else {
   $target="_self";
 }

 if ($page['page_type'] != '2') {
	 $link = FILENAME_PAGES;
   $param = 'pages_id=' . $page['pages_id'];
 } else {
	 $link = FILENAME_CONTACT_US;
	 $param = '';
 }

 if($page['intorext'] == 1)  {
      $boxContent .= '<tr><td align="center" width="20">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" width="155"><a class="boxLink" target="'.$target.'" href="' . $page['externallink'] . '">' . $page['pages_title'] . '</a></td></tr>';
      $boxContent .= '<tr><td align="center" width="100%" colspan="2">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</td></tr>';
 } else {
      $boxContent .= '<tr><td align="center" width="20">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" width="155"><a class="boxLink" target="'.$target.'" href="' . tep_href_link($link, $param) . '">' . $page['pages_title'] . '</a></td></tr>';
      $boxContent .= '<tr><td align="center" width="100%" colspan="2">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</td></tr>';
 }
}

	$boxContent .= '<tr><td align="center" width="20">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" width="155"><a class="boxLink" href="' .tep_href_link(FILENAME_SITEMAP). '">' .BOX_INFORMATION_SITEMAP. '</a></td></tr>';
   $boxContent .= '<tr><td align="center" width="100%" colspan="2">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</td></tr>';

if (ALL_PRODUCTS == 'true') {
	$boxContent .= '<tr><td align="center" width="20">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" valign="middle" width="155"><a class="boxLink" href="' .tep_href_link(FILENAME_ALLPRODS). '">' .BOX_INFORMATION_ALLPRODS. '</a></td></tr>';
}
$boxContent .= '</table>';
include (bts_select('boxes', $box_base_name)); // BTS 1.5
?>
<!-- info_pages_eof //-->

