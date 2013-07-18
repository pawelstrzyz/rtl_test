<?php
/*

 mod eSklep-Os http://www.esklep-os.com

*/

$boxHeading = 'Reklama';
$corner_left = 'rounded';
$corner_right = 'rounded';
$boxContent_attributes = ' align="center"';
$box_base_name = 'kontakt'; // for easy unique box template setup (added BTSv1.2)

$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

$boxContent = '<table border="0" cellspacing="0" cellpadding="0" width="100%" align ="center">';

$boxContent .= '<tr>
				<td align="center" class="main" valign="top">Linki ...</td></tr>';
$boxContent .= '</table>';

include (bts_select('boxes', $box_base_name)); // BTS 1.5

$boxContent_attributes = '';

?>