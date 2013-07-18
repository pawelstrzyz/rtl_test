<?php
/*
  $Id: eubanktransfer.php,v 1.9.1 2006/07/04 12:00:00 jb_gfx

	Thanks to all the developers from the EU-Standard Bank Transfer module $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
*/

define('MODULE_PAYMENT_PL_BANKTRANSFER_TEXT_TITLE', 'Przelew Bankowy');
define('MODULE_PAYMENT_PL_BANKTRANSFER_TEXT_DESCRIPTION',
	'Po otrzymaniu potwierdzenia dostępności towaru, które wyślemy do Ciebie w ciągu 1-2 dni roboczych - będziesz mógł dokonać przelewu sumy zamówienia na nasze konto bankowe:' .'<br><br>'.
	'Nazwa konta: ' . MODULE_PAYMENT_PL_ACCOUNT_HOLDER . '<br>'.
	'Numer konta: ' . MODULE_PAYMENT_PL_IBAN . '<br>'.
	'Nazwa banku: ' . MODULE_PAYMENT_PL_BANKNAME . '<br><br>'.
	'Twoje zamówienie zostanie zrealizowane niezwłocznie po wpłynięciu pieniędzy na nasze konto.<br>');

define('MODULE_PAYMENT_PL_BANKTRANSFER_TEXT_EMAIL_FOOTER',
	'Po otrzymaniu potwierdzenia dostępności towaru, które wyślemy do Ciebie w ciągu 1-2 dni roboczych - będziesz mógł dokonać przelewu sumy zamówienia na nasze konto bankowe:' . "\n" .
	'W tytule przelewu proszę podać numer zamówienia' . "\n\n" .
	'Nazwa konta: ' . preg_replace( '!<br.*>!iU', "\n", MODULE_PAYMENT_PL_ACCOUNT_HOLDER ) . "\n" .
	'Numer konta: ' . MODULE_PAYMENT_PL_IBAN . "\n" .
	'Nazwa banku: ' . MODULE_PAYMENT_PL_BANKNAME . "\n\n" .
	'Twoje zamówienie zostanie zrealizowane niezwłocznie po wpłynięciu pieniędzy na nasze konto.' . "\n\n" .
	'Zespół obsługi sklepu internetowego' . "\n" .
	STORE_NAME . "\n\n" .
	'Jeżeli masz jakiekolwiek pytania odpowiedz na ten email.');

?>