<?php
/*
  $Id: \includes\boxes\categories_jsc.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

$boxHeading = BOX_HEADING_CATEGORIES;
$corner_left = 'rounded';
$corner_right = 'rounded';
$box_base_name = 'categories_jsc'; // for easy unique box template setup (added BTSv1.2)
$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)
$boxContent_attributes = ' align="left"';

include(DIR_WS_CLASSES . 'jcssmenu.php');

$boxContent = '';
$boxContent .= osC_JCSSMenu::display($cPath);

  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.tpl.php')) {
  // if exists, load unique box template for this box from templates/boxes/
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.tpl.php');
  }
  else {
  // load default box template: templates/boxes/box.tpl.php
      require(DIR_WS_BOX_TEMPLATES . TEMPLATENAME_BOX);
  }


?>
<!-- categories_eof //-->