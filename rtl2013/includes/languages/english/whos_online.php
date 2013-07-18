<?php
/*
  $Id: whos_online.php 1 2007-12-20 23:52:06Z  $
// corection french by azer
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

// added for version 1.9 - to be translated to the right language BOF ******
define('AZER_WHOSONLINE_WHOIS_URL', 'http://www.dnsstuff.com/tools/whois.ch?ip='); //for version 2.9 by azer - whois ip
define('TEXT_NOT_AVAILABLE', '   <b>Uwaga:</b> N/A = IP niedostępne'); //for version 2.9 by azer was missing
define('TEXT_LAST_REFRESH', 'Ostatnie odświeżenie o '); //for version 2.9 by azer was missing
define('TEXT_EMPTY', 'Pusty'); //for version 2.8 by azer was missing
define('TEXT_MY_IP_ADDRESS', 'Mój adres IP '); //for version 2.8 by azer was missing
define('TABLE_HEADING_COUNTRY', 'Kraj'); // azerc : 25oct05 for contrib whos_online with country and flag
// added for version 1.9 EOF *************************************************

define('HEADING_TITLE', 'Kto jest OnLine (wersja rozszerzona)');
define('TABLE_HEADING_ONLINE', 'Online');
define('TABLE_HEADING_CUSTOMER_ID', 'ID');
define('TABLE_HEADING_FULL_NAME', 'Nazwa');
define('TABLE_HEADING_IP_ADDRESS', 'Adres IP');
define('TABLE_HEADING_ENTRY_TIME', 'Wejście');
define('TABLE_HEADING_LAST_CLICK', 'Ostatnie kliknięcie');
define('TABLE_HEADING_LAST_PAGE_URL', 'Ostatni URL');
define('TABLE_HEADING_ACTION', 'Działanie');
define('TABLE_HEADING_SHOPPING_CART', 'Koszyk');
define('TEXT_SHOPPING_CART_SUBTOTAL', 'Podsuma');
define('TEXT_NUMBER_OF_CUSTOMERS', 'Wizytujący online (stan zmieniony na  nieaktywny po 5 minutach. Usunięty po 15 minutach.)');
define('TABLE_HEADING_HTTP_REFERER', 'Referer');
define('TEXT_HTTP_REFERER_URL', 'HTTP Referer URL');
define('TEXT_HTTP_REFERER_FOUND', 'Tak');
define('TEXT_HTTP_REFERER_NOT_FOUND', 'Nie znaleziony');
define('TEXT_STATUS_ACTIVE_CART', 'Aktywny z Koszykiem');
define('TEXT_STATUS_ACTIVE_NOCART', 'Aktywny bez Koszyka');
define('TEXT_STATUS_INACTIVE_CART', 'Nieaktywny z Koszykiem');
define('TEXT_STATUS_INACTIVE_NOCART', 'Nieaktywny bez Koszyka');
define('TEXT_STATUS_NO_SESSION_BOT', 'Nieaktywny Bot bez sesji?'); //check if right description
define('TEXT_STATUS_INACTIVE_BOT', 'Nieaktywny Bot z sesją '); //check if right description
define('TEXT_STATUS_ACTIVE_BOT', 'Aktywny Bot z sesją '); //check if right description
define('TABLE_HEADING_COUNTRY', 'Kraj');
define('TABLE_HEADING_USER_SESSION', 'Sesja');
define('TEXT_IN_SESSION', 'Tak');
define('TEXT_NO_SESSION', 'Nie');

define('TEXT_OSCID', 'osCsid');
define('TEXT_PROFILE_DISPLAY', 'Profil wyświetlania');
define('TEXT_USER_AGENT', 'Przeglądarka');
define('TEXT_ERROR', 'Błąd!');
define('TEXT_ADMIN', 'Admin');
define('TEXT_DUPLICATE_IP', 'Zdublowanych IP');
define('TEXT_BOTS', 'Boty');
define('TEXT_ME', 'Ja sam!');
define('TEXT_ALL', 'Wszystko');
define('TEXT_REAL_CUSTOMERS', 'Kupujących');

define('TEXT_YOUR_IP_ADDRESS', 'Twój adres IP');
define('TEXT_SET_REFRESH_RATE', 'Czas odświeżania');
define('TEXT_NONE_', 'Brak');
define('TEXT_CUSTOMERS', 'Kupujący');
?>