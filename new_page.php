<?php
/*
  $Id: new_page.php
  easy new pages v1.0 for the BTS 2004/01/07
  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/
require('includes/application_top.php');

$pageFileName = basename ($PHP_SELF);
$pageName = basename ($PHP_SELF,".php"); // needs php => 4.1
// set the name of the javascript file to load (only if needed) from "includes/javascript/""
//  $javascript = 'new_page.js';

if (file_exists(DIR_WS_TEMPLATES . 'content/' . $pageName . '.tpl.php')) {
  // use the template made for this page
  $content = $pageName;
}
else {
  // or use 'static.tpl.php', or fill in which other template i.s.o. 'static' should be used
  $content = 'static';
}

// load (language dependent) texts defines from "includes/languages/.../new_page.php" if it exists
if (file_exists(DIR_WS_LANGUAGES . $language . '/' . $pageFileName)) {
  require(DIR_WS_LANGUAGES . $language . '/' . $pageFileName);
}



$breadcrumb->add(NAVBAR_TITLE, tep_href_link($pageFileName));

/******************************************************************************/
// PHP code here, but no output (output code and HTML in template file)



/******************************************************************************/

// load main_page (the $content template and $javascript are included in main_page.tpl.php)
require(DIR_WS_TEMPLATES . TEMPLATENAME_MAIN_PAGE);

require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
