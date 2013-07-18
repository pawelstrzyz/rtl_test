<?php
/*
recently_viewed.php
*/

$boxHeading = RECENTLY_VIEWED_BOX_HEADING;
$corner_left = 'rounded';
$corner_right = 'rounded';
$boxContent_attributes = ' align="center"';
$box_base_name = 'recently_viewed'; // for easy unique box template setup (added BTSv1.2)

$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

/////////// change the following lines if you would like:
$recently_viewed_box_max_lines = 10;  // maximum number of lines in recently viewed box
$recently_viewed_box_max_characters_per_line = 30;  // maximum number of characters per line in recently viewed box
/////////// change the above lines if you would like:
?>

<!-- recently_viewed //-->
<?php
if (strlen(trim($recently_viewed)>0)) {   // only display recently viewed box if there are items to be displayed
	$counter = 0;
  $info_box_contents = array();
	$recent_products = split(';',$recently_viewed);

	$boxContent = '';
	$boxContent .= '<table border="0" width="100%" cellspacing="0" cellpadding="1">';

	foreach ($recent_products as $recent) {
		if ((strlen($recent) >0) && ($counter < $recently_viewed_box_max_lines)) {
			$counter++;
			if (strlen($counter) < 2) {
				$counter = '0' . $counter;
      }//if (strlen($counter) < 2) {
    	
			$boxContent .= '<tr><td align="center" width="12%">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" align="left" width="88%"><a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $recent, 'NONSSL') . '">' . substr(tep_get_products_name($recent),0,$recently_viewed_box_max_characters_per_line) . '</a></td></tr>';
      $boxContent .= '<tr><td align="center" width="100%" colspan="2">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</td></tr>';
		}//if ((strlen($recent) >0) && ($counter < $recently_viewed_box_max_lines)) {
	}//foreach ($recent_products as $recent) {
  
	$boxContent .= '</table>';
	include (bts_select('boxes', $box_base_name)); // BTS 1.5

	$boxContent_attributes = '';

}//if (strlen(trim($recently_viewed)>0)) {   // only display recently viewed box if there are items to be displayed


?>
<!-- recently_viewed_eof //-->