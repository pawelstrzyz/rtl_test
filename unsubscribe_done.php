<?php
////////////////////////////////////////////////////////////////////////////
// $Id: Newsletter Unsubscribe, v 1.0 (/catalog/unsubscribe_done.php) 2003/01/24
// Programed By: Christopher Bradley (www.wizardsandwars.com)
//
// Developed for osCommerce, Open Source E-Commerce Solutions
// http://www.oscommerce.com
// Copyright (c) 2003 osCommerce
//
// Released under the GNU General Public License
//
//   mod eSklep-Os http://www.esklep-os.com
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////
// ############ anti aspirateur #########
// require ('aspilock_heap.php');
// ######### anti aspirateur ##########
require('includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_UNSUBSCRIBE);
$email_to_unsubscribe=$HTTP_GET_VARS['email'];
$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_UNSUBSCRIBE, '', 'NONSSL'));
  
///////////////////////////////////////////////////////////////////////////////////////////

/// Check and see if the email exists in the database, and is subscribed to the newsletter.
$cus_subscribe_raw = "SELECT subscribers_id FROM subscribers WHERE customers_newsletter = '1' AND subscribers_email_address = '" . $email_to_unsubscribe . "'";
$cus_subscribe_query = tep_db_query($cus_subscribe_raw);
$cus_subscribe = tep_db_fetch_array($cus_subscribe_query);

  $content = unsubscribe_done;

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>