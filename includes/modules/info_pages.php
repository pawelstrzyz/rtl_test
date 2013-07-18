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
$rows = 0;
echo '<table border="0" cellspacing="0" cellpadding="3" align="center">';

while ($page = tep_db_fetch_array($page_query)) {
 $rows++;

 $target="";
 if($page['link_target']== 1)  {
   $target="_blank";
 } else {
   $target="_self";
 }

 switch ($page['page_type']) {
  case 1:  
   $link = FILENAME_CONDITIONS;
   break;
  case 2:  
   $link = FILENAME_CONTACT_US;
   break;
  case 3:  
   $link = FILENAME_PRIVACY;
   break;
  case 4:  
   $link = FILENAME_SHIPPING;
   break;
  default:
   $link = FILENAME_PAGES . '?pages_id=' . $page['pages_id'];
  break;
 } // end switch

 if($page['intorext'] == 1)  {
      echo '<tr><td class="boxContents"><a class="boxLink" target="'.$target.'" href="' . $page['externallink'] . '"><b>' . $page['pages_title'] . '</b></a></td><td>|</td>';
 } else {
      echo '<td class="boxContents"><a class="boxLink" target="'.$target.'" href="' . tep_href_link($link) . '"><b>' . $page['pages_title'] . '</b></a></td><td>|</td>';
 }
}

	echo '<td class="boxContents"><a class="boxLink" href="' .tep_href_link('contact_us.php'). '"><b>' .BOX_INFORMATION_CONTACT. '</b></a></td><td>|</td>';
	echo '<td class="boxContents"><a class="boxLink" href="' .tep_href_link(FILENAME_ADVANCED_SEARCH). '"><b>' .BOX_HEADING_SEARCH. '</b></a></td><td>|</td>';
	echo '<td class="boxContents"><a class="boxLink" href="' .tep_href_link(FILENAME_LOGIN). '"><b>' .HEADER_TITLE_LOGIN. '</b></a></td>';

echo '</table>';
?>
<!-- info_pages_eof //-->

