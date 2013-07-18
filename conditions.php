<?php
/*
  $Id: conditions.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CONDITIONS);

#################
$page_query = tep_db_query("select p.pages_id, p.sort_order, p.status, s.pages_title, s.pages_html_text from " . TABLE_PAGES . " p LEFT JOIN " .TABLE_PAGES_DESCRIPTION . " s on p.pages_id = s.pages_id where p.status = 1 and s.language_id = '" . (int)$languages_id . "' and p.page_type = 1");

$page_check = tep_db_fetch_array($page_query);

$pagetext=stripslashes($page_check[pages_html_text]);

#################

  $breadcrumb->add(HEADING_TITLE, tep_href_link(FILENAME_CONDITIONS, '', 'NONSSL'));
//  $breadcrumb->add(HEADING_TITLE, tep_href_link(FILENAME_NEWSDESK_REVIEWS_ARTICLE, '', 'NONSSL')); 

  $content = CONTENT_CONDITIONS;
//  $content_template = TEMPLATENAME_STATIC;

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
