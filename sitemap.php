<?php
/*
  $Id: sitemap.php 1 2007-12-20 23:52:06Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  Compatibility with Extra Pages-InfoBox CROSSOVER

	Use if you have installed the contribution Extra pages-info box w/ admin 
	http://www.oscommerce.com/community/contributions,2021


  mod eSklep-Os http://www.esklep-os.com
*/

  require('includes/application_top.php');
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SITEMAP);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SITEMAP));
  $content = 'sitemap';

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php'); 
  
  ?>