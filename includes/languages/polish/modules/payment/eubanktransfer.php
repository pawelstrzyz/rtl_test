<?php
/*
  $Id: eubanktransfer.php,v 1.9.1 2006/07/04 12:00:00 jb_gfx

	Thanks to all the developers from the EU-Standard Bank Transfer module $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
*/

define('MODULE_PAYMENT_EU_BANKTRANSFER_TEXT_TITLE', 'Europejski Przelew Bankowy');
define('MODULE_PAYMENT_EU_BANKTRANSFER_TEXT_DESCRIPTION',
	'Po otrzymaniu potwierdzenia dostępności towaru prosimy o przelanie sumy zamówienia na podany niżej nr konta: ' .'<br><br>'.
	'Nazwa konta: ' . MODULE_PAYMENT_EU_ACCOUNT_HOLDER . '<br>'.
	'Numer konta IBAN: ' . MODULE_PAYMENT_EU_IBAN . '<br>'.
	'Kod BIC / SWIFT : ' . MODULE_PAYMENT_EU_BIC . '<br>'.
	'Nazwa banku: ' . MODULE_PAYMENT_EU_BANKNAME . '<br><br>'.
	'Potwierdzenie zostanie przesłane do Ciebie w ciągu kilku dni.<br>Twoje zamówienie zostanie wysłane niezwłocznie po wpłynięciu pieniędzy na konto.<br>');

define('MODULE_PAYMENT_EU_BANKTRANSFER_TEXT_EMAIL_FOOTER',
	'Po otrzymaniu potwierdzenia dostępności towaru prosimy o przelanie sumy zamówienia na podany niżej nr konta:' . "\n" .
	'W tytule przelewu proszę podać numer zamówienia' . "\n\n" .
	'Nazwa konta: ' . preg_replace( '!<br.*>!iU', "\n", MODULE_PAYMENT_EU_ACCOUNT_HOLDER ) . "\n\n" .
	"Numer konta IBAN: " . MODULE_PAYMENT_EU_IBAN . "\n\n" .
	"Kod BIC / SWIFT : " . MODULE_PAYMENT_EU_BIC . "\n\n" .
	"Nazwa banku: " . MODULE_PAYMENT_EU_BANKNAME . "\n\n" .
	'Potwierdzenie zostanie przesłane do Ciebie w ciągu kilku dni.'. "\n\n" .
	'Twoje zamówienie zostanie wysłane niezwłocznie po wpłynięciu pieniędzy na konto.');
?>