<?php
/*
  $Id: categories_css.php 1 2007-12-20 23:52:06Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com/

  Based on: main_categories.php Ver. 1.0 by Gustavo Barreto

  History: 1.0 Creation

  Released under the GNU General Public License

*/

$boxHeading = BOX_HEADING_CATEGORIES;
$corner_left = 'rounded';
$corner_right = 'square';
$box_base_name = 'categories_css'; // for easy unique box template setup (added BTSv1.2)

$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

$boxContent = '';

// bof BTSv1.2
if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.tpl.php')) {
  require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.tpl.php');
}
// eof BTSv1.2

?>
<!-- show_subcategories_eof //-->
