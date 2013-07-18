<?php
/*
  $Id: logoff.php 177 2008-03-24 16:18:08Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGOFF);

  $breadcrumb->add(NAVBAR_TITLE);

// Ingo PWA
  if ($customer_id == 0) {
    tep_session_unregister('pwa_array_customer');
    tep_session_unregister('pwa_array_address');
    tep_session_unregister('pwa_array_shipping');
  }

  tep_session_unregister('customer_id');
  tep_session_unregister('customer_default_address_id');
  tep_session_unregister('customer_first_name');
  tep_session_unregister('customer_country_id');
  tep_session_unregister('customer_zone_id');
  tep_session_unregister('comments');
  //kgt - discount coupons
  tep_session_unregister('coupon');
  //end kgt - discount coupons
  tep_session_unregister('noaccount');
	tep_session_unregister('recently_viewed'); // for customer's security, this line of code removes the recently_viewed info after logoff

  $cart->reset();

	$content = CONTENT_LOGOFF;

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
