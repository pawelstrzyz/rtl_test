<?php
/*
  $infopageid: info_pages.php,v 1.22 2003/06/05 23:26:22 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

require('includes/application_top.php');

$infopageid = (int)$HTTP_GET_VARS['pages_id'];

$page_query = tep_db_query("select 
                              p.pages_id, 
                              p.status,
                              s.pages_title, 
                              s.pages_html_text                               
                            from 
                              " . TABLE_PAGES . " p LEFT JOIN " .TABLE_PAGES_DESCRIPTION . " s on p.pages_id = s.pages_id
                            where 
                              s.language_id = '" . (int)$languages_id . "'
                            and
                              p.pages_id = $infopageid");


$page_check = tep_db_fetch_array($page_query);
$pagetext=stripslashes($page_check[pages_html_text]);

$breadcrumb->add($page_check[pages_title], tep_href_link('info_pages.php?pages_id=' . $infopageid));

$content = 'info_pages';

include (bts_select('main', $content_template)); // BTSv1.5

require(DIR_WS_INCLUDES . 'application_bottom.php');

?>