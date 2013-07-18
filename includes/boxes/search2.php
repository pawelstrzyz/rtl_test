<?php
/*
  $Id: search.php,v 1.22 2003/02/10 22:31:05 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- search //-->
<?php
  //$info_box_contents = array();
  //$info_box_contents[] = array('text' => BOX_HEADING_SEARCH);

  //new infoBoxHeading($info_box_contents, false, false);

  $info_box_contents = array();
  $info_box_contents[] = array('form' => tep_draw_form('quick_find2', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get'),
                               'align' => 'left',
                               'text' =>tep_draw_input_field('keywords', '', 'size="10" maxlength="30" style="width:100%; height:17px; color:#1d1d1d " value="' . IMAGE_BUTTON_QUICK_FIND . '" onClick="this.value=\'\' "') . '
							  
							   
<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-top:9px">
  <tr valign="middle">
    <td align="left"><a href="' . tep_href_link(FILENAME_ADVANCED_SEARCH) . '" class="adv">'. BOX_SEARCH_ADVANCED_SEARCH .'</a></td>
    <td align="right">'. tep_hide_session_id() . tep_image_submit('submit.gif', IMAGE_BUTTON_CONTINUE)  . '</td>
  </tr>
</table>
							   '  ); 

  new infoBox($info_box_contents);  
  
?>
<!-- search_eof //-->
