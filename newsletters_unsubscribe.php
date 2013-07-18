<?php
////////////////////////////////////////////////////////////////////////////
// $Id: Newsletter Unsubscribe, v 1.0 (/catalog/unsubscribe.php) 2003/01/24
// Programed By: Christopher Bradley (www.wizardsandwars.com)
//
// Developed for osCommerce, Open Source E-Commerce Solutions
// http://www.oscommerce.com
// Copyright (c) 2003 osCommerce
//
// Released under the GNU General Public License
//
//
//    mod eSklep-Os http://www.esklep-os.com
///////////////////////////////////////////////////////////////////////////

  require('includes/application_top.php');
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEWSLETTERS_UNSUBSCRIBE);
  $email_to_unsubscribe=$HTTP_GET_VARS['email'];
  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_NEWSLETTERS_UNSUBSCRIBE, '', 'NONSSL'));
  $filename_newsletter_unsubscribe_done=FILENAME_NEWSLETTERS_UNSUBSCRIBE_DONE . "?email=" . $email_to_unsubscribe;
  
////////////////////////////////////////////////////////////////////////////////////////////


  $content = newsletters_unsubscribe;

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>