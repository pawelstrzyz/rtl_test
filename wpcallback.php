<?php
/*
  $Id: wpcallback.php,v MS1a 2003/04/06 21:30
  Author : 	Graeme Conkie (graeme@conkie.net)
  Title: WorldPay Payment Callback Module V4.0 Version 1.4

  Revisions:
  
    Version 1.8 - cleaned up coding errors in wpcallback.php
                - reduced "refresh" to 2 seconds (less chance of callback failing)
                
            Gary Burton - www.oscbooks.com
            
	Version MS1a Cleaned up code, moved static English to language file to allow for bi-lingual use,
	        Now posting language code to WP, Redirect on failure now to Checkout Payment,
			Reduced re-direct time to 8 seconds, added MD5, made callback dynamic 
			NOTE: YOU MUST CHANGE THE CALLBACK URL IN WP ADMIN TO <wpdisplay item="MC_callback">
	Version 1.4 Removes boxes to prevent users from clicking away before update, 
			Fixes currency for Yen, 
			Redirects to Checkout_Process after 10 seconds or click by user
	Version 1.3 Fixes problem with Multi Currency
	Version 1.2 Added Sort Order and Default order status to work with snapshots after 14 Jan 2003
	Version 1.1 Added Worldpay Pre-Authorisation ability
	Version 1.0 Initial Payment Module

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003
  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_WPCALLBACK);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_WPCALLBACK));

  $content = 'wpcallback';

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>