<?php
/*
  $Id: \includes\boxes\tell_a_friend.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

if ($HTTP_GET_VARS['products_id']) {
    if (basename($PHP_SELF) != FILENAME_TELL_A_FRIEND and (BOX_TELL_A_FRIEND_IS_ON=='true' and (COLUMN_RIGHT_IS_ON_LEFT=='true' or BOX_TELL_A_FRIEND_COLUMN=='left'))) 		$boxHeading = BOX_HEADING_TELL_A_FRIEND;
		$corner_left = 'rounded';
		$corner_right = 'rounded';
		$boxContent_attributes = ' align="center"';
		$box_base_name = 'tell_a_friend'; // for easy unique box template setup (added BTSv1.2)

		$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

		$boxContent = tep_draw_form('tell_a_friend', tep_href_link(FILENAME_TELL_A_FRIEND, '', 'NONSSL', false), 'get');
		$boxContent .= '<table border="0" width="100%" cellspacing="0" cellpadding="2">';
		$boxContent .= '<tr><td class="boxText" valign="top" height="3"></td></tr><tr><td align="center" class="boxText">' . BOX_TELL_A_FRIEND_TEXT . '</td></tr><tr><td align="center" class="boxText">' . tep_image_submit('button_tell_a_friend.gif', BOX_HEADING_TELL_A_FRIEND) . tep_draw_hidden_field('products_id', $HTTP_GET_VARS['products_id']) . tep_hide_session_id() . '</td></tr><tr><td class="boxText" valign="top" height="3"></td></tr></table>';

		$boxContent .= '</form>';

		include (bts_select('boxes', $box_base_name)); // BTS 1.5
		$boxContent_attributes = '';
}

?>