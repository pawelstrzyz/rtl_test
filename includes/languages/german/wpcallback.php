<?php
/*
  $Id: wpcallback.php,v MS1a 2003/04/06 21:30
  Author : 	Graeme Conkie (graeme@conkie.net)
  Title: WorldPay Payment Callback Module V4.0 Version 1.4

  Revisions:
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

define('NAVBAR_TITLE', 'WorldPay');
define('WP_TEXT_HEADING', 'Antwort von WorldPay:');
define('HEADING_TITLE', 'Danke, dass Sie bei ' . STORE_NAME . ' eingekauft haben.');
define('WP_TEXT_SUCCESS', '... Ihre Zahlung ist erfolgreich eingegangen.');
define('WP_TEXT_SUCCESS_WAIT', '<b><font color="#FF0000">Bitte warten Sie...</font></b> w�hrend Ihre Bestellung weiterbearbeitet wird.<br>Wenn Sie nicht automatisch weitergeleitet werden, bitte hier klicken.');
define('WP_TEXT_FAILURE', '... Ihre Zahlung wurde abgebrochen!');
define('WP_TEXT_FAILURE_WAIT', '<b><font color="#FF0000">Bitte warten Sie...</font></b> w�hrend Ihre Bestellung weiterbearbeitet wird.<br>Wenn Sie nicht automatisch weitergeleitet werden, bitte hier klicken.');
?>