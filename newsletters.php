<?php
/*

  mod eSklep-Os http://www.esklep-os.com

*/

require('includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEWSLETTERS);

$location = ' &raquo; <a href="' . tep_href_link(FILENAME_NEWSLETTERS, '', 'NONSSL') . '" class="headerNavigation">' . NAVBAR_TITLE . '</a>';

  $content = newsletters;

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>