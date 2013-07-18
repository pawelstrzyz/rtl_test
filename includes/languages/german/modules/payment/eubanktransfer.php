<?php
/*
  $Id: eubanktransfer.php,v 1.8 2006/04/22 12:00:00 by Onkel Flo

	Thanks to all the developers from the EU-Standard Bank Transfer module $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
*/

define('MODULE_PAYMENT_EU_BANKTRANSFER_TEXT_TITLE', 'Europäische Banküberweisung');
define('MODULE_PAYMENT_EU_BANKTRANSFER_TEXT_DESCRIPTION', '' .
'<br />Bitte verwenden Sie folgende Daten für die Überweisung des Gesamtbetrages.
<br />Als Verwendungszweck geben Sie bitte Ihren Namen und Ihre Bestellnummer an.<br />' .
'<br />Konto: ' . MODULE_PAYMENT_EU_ACCOUNT_HOLDER .
'<br />Konto IBAN: ' . MODULE_PAYMENT_EU_IBAN .
'<br />BIC / SWIFT-Code: ' . MODULE_PAYMENT_EU_BIC .
'<br />Bank: ' . MODULE_PAYMENT_EU_BANKNAME .
'<br /><br />Ihre Bestellung wird nicht versandt, bis wir das Geld erhalten haben!<br />');

define('MODULE_PAYMENT_EU_BANKTRANSFER_TEXT_EMAIL_FOOTER', 'Bitte verwenden Sie folgende Daten für die Überweisung des Gesamtbetrages.
Als Verwendungszweck geben Sie bitte Ihren Namen und Ihre Bestellnummer an.' . "\n\n" .
"Konto: " . preg_replace( '!<br.*>!iU', "\n", MODULE_PAYMENT_EU_ACCOUNT_HOLDER ) . "\n\n" .
"Konto IBAN: " . MODULE_PAYMENT_EU_IBAN . "\n\n" .
"BIC / SWIFT-Code: " . MODULE_PAYMENT_EU_BIC . "\n\n" .
"Bank: " . MODULE_PAYMENT_EU_BANKNAME . "\n\n" .
'Sollte die Überweisung nicht innerhalb von 7 Tagen bei uns eingegangen sein,
wird Ihre Bestellung storniert.'. "\n\n" .
'Ihre Bestellung wird nicht versendet, bis wir das Geld erhalten haben!');
?>