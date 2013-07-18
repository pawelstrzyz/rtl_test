<?php
/*
  $Id: eubanktransfer.php,v 1.9.1 2006/07/04 12:00:00 jb_gfx

	Thanks to all the developers from the EU-Standard Bank Transfer module $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
*/

define('MODULE_PAYMENT_EU_BANKTRANSFER_TEXT_TITLE', 'European Bank Transfer');
define('MODULE_PAYMENT_EU_BANKTRANSFER_TEXT_DESCRIPTION',
	'Please transfer the total amount to the following bank account.' . '<br />'.
	'Enter your name and your invoice number in the subject field' . '<br /><br />'.
	'Account: ' . MODULE_PAYMENT_EU_ACCOUNT_HOLDER . '<br />'.
	'Account IBAN: ' . MODULE_PAYMENT_EU_IBAN . '<br />'.
	'BIC / SWIFT code: ' . MODULE_PAYMENT_EU_BIC . '<br />'.
	'Bank: ' . MODULE_PAYMENT_EU_BANKNAME . '<br /><br />'.
	'We will ship your order as soon as we receive your payment.' . '<br />');

define('MODULE_PAYMENT_EU_BANKTRANSFER_TEXT_EMAIL_FOOTER',
	'Please transfer the total amount to the following bank account.' . "\n" .
	'Enter your name and your invoice number in the subject field.' . "\n\n" .
	'Account holder: ' . preg_replace( '!<br.*>!iU', "\n", MODULE_PAYMENT_EU_ACCOUNT_HOLDER ) . "\n\n" .
	"Account IBAN: " . MODULE_PAYMENT_EU_IBAN . "\n\n" .
	"BIC / SWIFT code: " . MODULE_PAYMENT_EU_BIC . "\n\n" .
	"Bank name: " . MODULE_PAYMENT_EU_BANKNAME . "\n\n" .
	'Please make sure your payment is with us within 7 days or your order will be cancelled.'. "\n\n" .
	'We will ship your order as soon as we receive your payment.');
?>
