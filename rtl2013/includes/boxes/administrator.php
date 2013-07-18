<?php
/*
  $Id: administrator.php 1 2007-12-20 23:52:06Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/
?>
<!-- catalog //-->
<tr>
 <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_ADMINISTRATOR,
                     'link'  => tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('selected_box')) . 'selected_box=administrator'));
  if ($selected_box == 'administrator' || $menu_dhtml == true) {
    $contents[] = array('text'  => tep_admin_files_boxes(FILENAME_ADMIN_MEMBERS, BOX_ADMINISTRATOR_MEMBERS) .
	                                 tep_admin_files_boxes(FILENAME_ADMIN_MEMBERS_EDIT, BOX_ADMINISTRATOR_MEMBERS_EDIT) .
                                   tep_admin_files_boxes(FILENAME_ADMIN_FILES, BOX_ADMINISTRATOR_BOXES));
  }
  $box = new box;
  echo $box->menuBox($heading, $contents);
  ?>
 </td>
</tr>
<!-- catalog_eof //-->
