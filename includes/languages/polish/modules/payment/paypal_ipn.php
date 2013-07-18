<?php
/*
  $Id: paypal_ipn.php 1 2007-12-20 23:52:06Z  $

  Copyright (c) 2004 osCommerce
  Released under the GNU General Public License
  
  Original Authors: Harald Ponce de Leon, Mark Evans 
  Updates by PandA.nl, Navyhost, Zoeticlight, David, gravyface, AlexStudio, windfjf and Terra
    
*/

  define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_TITLE', 'PayPal (karta kredytowa)');
  define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_DESCRIPTION', 'PayPal IPN');

  // Sets the text for the "continue" button on the PayPal Payment Complete Page
  // Maximum of 60 characters!  
  define('CONFIRMATION_BUTTON_TEXT', 'Zakończa zamówienie');
  
define('EMAIL_PAYPAL_PENDING_NOTICE', 'Zamówienie oczekuje obecnie na realizację.');

define('EMAIL_TEXT_SUBJECT', 'Realizacja zamówienia');
define('EMAIL_TEXT_ORDER_NUMBER', 'Numer zamówienia:');
define('EMAIL_TEXT_INVOICE_URL', 'Szczególy:');
define('EMAIL_TEXT_DATE_ORDERED', 'Data zamówienia:');
define('EMAIL_TEXT_PRODUCTS', 'Produkty');
define('EMAIL_TEXT_SUBTOTAL', 'Podsuma:');
define('EMAIL_TEXT_TAX', 'Podatek:        ');
define('EMAIL_TEXT_SHIPPING', 'Przesylka: ');
define('EMAIL_TEXT_TOTAL', 'Razem:    ');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Adres dostawy');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Adres do platnosci');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Sposób zaplaty');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', '');

define('PAYPAL_ADDRESS', 'Adres użytkownika PayPal');

/* Jezeli w e-mailu ma byc na koncu jakis dodatkowy tekst, to mozna go wpisac tutaj.*/
/* Uzyj \n aby przejsc do nowej linii */
define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_EMAIL_FOOTER', '');
  
  
?>
