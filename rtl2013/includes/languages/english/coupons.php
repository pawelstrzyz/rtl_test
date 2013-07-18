<?php
/*
 * coupons.php
 * August 4, 2006
 * author: Kristen G. Thorson
 * ot_discount_coupon_codes version 3.0
 *
 * 
 * Released under the GNU General Public License
 *
 */

define('HEADING_TITLE', 'Kupony rabatowe');
define('HEADING_TITLE_VIEW_MANUAL', 'Jeżeli chcesz skorzystać z pomocy kliknij tutaj');

define('TEXT_DISCOUNT_COUPONS_ID', 'Kod kuponu:');
define('TEXT_DISCOUNT_COUPONS_DESCRIPTION', 'Opis:');
define('TEXT_DISCOUNT_COUPONS_AMOUNT', 'Wielkość rabatu:');
define('TEXT_DISCOUNT_COUPONS_TYPE', 'Rodzaj rabatu:');
define('TEXT_DISCOUNT_COUPONS_DATE_START', 'Data początkowa:');
define('TEXT_DISCOUNT_COUPONS_DATE_END', 'Data końcowa:');
define('TEXT_DISCOUNT_COUPONS_MAX_USE', 'Max ilość użycia:');
define('TEXT_DISCOUNT_COUPONS_MIN_ORDER', 'Minimalne zamówienie<br>(należy wpisać wartość netto):');
define('TEXT_DISCOUNT_COUPONS_MIN_ORDER_TYPE', 'Rodzaj minimalnego zamówienia:');
define('TEXT_DISCOUNT_COUPONS_NUMBER_AVAILABLE', 'Ilość dostepnych kuponów:');

define('TEXT_DISPLAY_NUMBER_OF_DISCOUNT_COUPONS', 'Items');
define('TEXT_DISPLAY_UNLIMITED', 'unlimited' );
define('TEXT_DISPLAY_SHIPPING_DISCOUNT', 'off shipping');

define('TEXT_INFO_DISCOUNT_AMOUNT_HINT', 'Jeżeli wartość rabatu ma byc w wartości kwotowej  <i>(należy podać kwotę netto)</i>.<br>W celu uzycia wartości procentowej rabatu, należy wprowadzić ułamkową wartość dziesiętną.  np: 0.10 w celu nadania rabatu 10%');
define('TEXT_INFO_DISCOUNT_AMOUNT', 'Rabat<br>(kwota netto):');
define('TEXT_INFO_DISCOUNT_TYPE', 'Rodzaj rabatu:');
define('TEXT_INFO_DATE_START', 'Start:');
define('TEXT_INFO_DATE_END', 'Koniec:');
define('TEXT_INFO_MAX_USE', 'Ilość użyć:');
define('TEXT_INFO_MIN_ORDER', 'Min<br>zamówienie:');
define('TEXT_INFO_MIN_ORDER_TYPE', 'rodzaj zamówienia:');
define('TEXT_INFO_NUMBER_AVAILABLE', 'Ilość kuponów:');

define('TEXT_INFO_HEADING_DELETE_DISCOUNT_COUPONS', 'Usunięcie kuponu rabatowego');
define('TEXT_INFO_DELETE_INTRO', 'Czy napewno usunąć ten kupon ?');

define('ERROR_DISCOUNT_COUPONS_NO_AMOUNT', 'Proszę wprowadzić wartość rabatu.' );

//exclusions
define('IMAGE_PRODUCT_EXCLUSIONS', 'Wykluczenie produktów');
define('IMAGE_MANUFACTURER_EXCLUSIONS', 'Wykluczenie producentów');
define('IMAGE_CATEGORY_EXCLUSIONS', 'Wykluczenie kategorii');
define('IMAGE_CUSTOMER_EXCLUSIONS', 'Wykluczenie użytkowników');
define('IMAGE_SHIPPING_ZONE_EXCLUSIONS', 'Wykluczenie stref dostawy');
//end exclusions

define('IMAGE_NEW_COUPON', 'Nowy kupon');
?>
