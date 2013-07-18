<?php
/*
  $Id: \includes\boxes\advsearch.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

  $boxHeading = BOX_HEADING_SEARCH;
  $corner_left = 'rounded';
  $corner_right = 'rounded';
  $boxContent_attributes = ' align="center"';

  $box_base_name = 'advsearch'; // for easy unique box template setup (added BTSv1.2)

  $boxContent = '<center>'.tep_draw_form('advanced_search', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get');
  $boxContent .= '<table border="0" width="90%" cellspacing="0" cellpadding="0">
					<tr>
						<td class="boxContents" valign="top" align="left">' . tep_draw_hidden_field('search_in_description','0') . tep_draw_input_field('keywords', '', 'style="width:120px;" maxlength="30"') . '</td>
						<td class="boxContents" valign="top" align="left">' . BOX_ADVSEARCH_KW . '</td>
						</tr>
						<tr><td class="boxContents" valign="top" colspan="2" height="3"></td></tr>
					<tr>
						<td class="boxContents" valign="top" align="left">' . tep_draw_input_field('pfrom','',' style="width:50px;" maxlength="8"') . BOX_ADVSEARCH_PRICESEP . tep_draw_input_field('pto','','style="width:50px;" maxlength="8"') . '</td>
						<td class="boxContents" valign="top" align="left">' . BOX_ADVSEARCH_PRICERANGE . '</td>
						</tr>
						<tr><td class="boxContents" valign="top" colspan="2" height="3"></td></tr>
					<tr>
						<td class="boxContents" valign="top" align="left">' . tep_draw_pull_down_menu('categories_id', tep_get_categories(array(array('id' => '', 'text' => BOX_ADVSEARCH_ALLCAT)))) . '</td>
						<td class="boxContents" valign="top" align="left">' . BOX_ADVSEARCH_CAT . '</td>
						</tr>
					<tr><td class="boxContents" valign="top" colspan="2" height="3"></td></tr>
					<tr><td class="boxContents" valign="top"  ></td>
					<td class="boxContents" valign="top" align="left">' . tep_image_submit('button_quick_find.gif', BOX_HEADING_ADVSEARCH) . '</td></tr>
					<tr><td class="boxContents" valign="top" colspan="2" height="2">&nbsp;</td></tr>
					<tr><td width="100% class="boxContents" valign="top" align="center"><a class="boxLink" href="' . tep_href_link(FILENAME_ADVANCED_SEARCH) . '">' . BOX_SEARCH_ADVANCED_SEARCH . '</a></td></tr></table>';
  $boxContent .= '</form></center>';

  include (bts_select('boxes', $box_base_name)); // BTS 1.5

  $boxContent_attributes = '';
?>