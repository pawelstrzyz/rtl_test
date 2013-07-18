<?php
/*
  $Id: newsletters_subscribe_error.php 1 2007-12-20 23:52:06Z  $
  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org
  Copyright (c) 2000,2001 The Exchange Project
  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

require('includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEWSLETTERS);
$location = ' &raquo; <a href="' . tep_href_link(FILENAME_NEWSLETTERS_SUBSCRIBE_ERROR, '', 'NONSSL') . '" class="headerNavigation">' . NAVBAR_TITLE . '</a>';

  $content = newsletters_subscribe_error;
  $javascript = 'form_check.js.php';

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
