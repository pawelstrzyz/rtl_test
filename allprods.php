<?php 
/* 
 $Id: allprods.php 1 2007-12-20 23:52:06Z  $


 All Products v4.3 MS 2.2 with Images http://www.oscommerce.com/community/contributions,1501
 
 osCommerce, Open Source E-Commerce Solutions
 http://www.oscommerce.com

 Copyright (c) 2004 osCommerce

 Released under the GNU General Public License
 
  mod eSklep-Os http://www.esklep-os.com
*/ 

 require('includes/application_top.php'); 
 include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ALLPRODS); 

 $breadcrumb->add(HEADING_TITLE, tep_href_link(FILENAME_ALLPRODS, '', 'NONSSL')); 

$firstletter=$HTTP_GET_VARS['fl'];
 if (!$HTTP_GET_VARS['page']){
  $where=" pd.products_name like '$firstletter%' AND p.products_status='1' ";
 }else {
  $where=" pd.products_name like '$firstletter%' AND p.products_status='1' ";
 } 

  $content = 'allprods';

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');


?> 
