<?php
/*
  $Id: flash_variables.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

// Hello everyone. My name is Chris Sullivan, and I am contributing this package so that the
// osCommerce community will finally have a real grasp on tackling flash and osCommerce. I have
// included a .fla (flash file), a .swf (compiled flash movie), and a .php file so that you can
// truly see ALL that goes into making this work. After unzipping header.swf and flash_variables.php 
// (this file) into your root catalog directory (generally http://www.yourstore.com/catalog/) just 
// replace the header.php file (found in /catalog/includes/) with the one I have included. You will 
// instantly have a flash navigation system that maintains osCommerce session ids.

// If you find this useful, I would appreciate any donations which you feel like making. They can be made 
// through PayPal by making a donation to "csull@bellsouth.net" (no quotes).

// Thanks, and I hope you find this useful.
// - Chris Sullivan
//   csull@bellsouth.net

require('includes/application_top.php');

if (isset($_GET['action']) && $_GET['action'] == 'flash_variables') {
	if (tep_session_is_registered('customer_id')) {
		print "&customer_id=" . $customer_first_name;
		print "&osCsid=" . str_replace("osCsid=", "", $SID);
	} else {
		print "&customer_id=Guest";
		print "&osCsid=" . str_replace("osCsid=", "", $SID);
	}
} else {
	print "&customer_id=Guest";
	print "&osCsid=" . str_replace("osCsid=", "", $SID);
}

?>