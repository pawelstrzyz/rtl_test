<?php
/*
 * coupons_exclusions.php
 * September 26, 2006
 * author: Kristen G. Thorson
 * ot_discount_coupon_codes version 3.0
 *
 *
 * Released under the GNU General Public License
 *
 */

define('HEADING_TITLE', 'Wykluczenia dla kuponu :  %s');
define('HEADING_TITLE_VIEW_MANUAL', 'Jeżeli chcesz skorzystać z pomocy kliknij tutaj');
if( isset( $HTTP_GET_VARS['type'] ) && $HTTP_GET_VARS['type'] != '' ) {
	switch( $HTTP_GET_VARS['type'] ) {
		//category exclusions
		case 'categories':
			$heading_available = 'Kupon dostępny dla produktów w tych kategoriach';
			$heading_selected = 'Kupon <b>niedostępny</b> dla produktów z tych kategorii';
			break;
		//end category exclusions
		//manufacturer exclusions
		case 'manufacturers':
			$heading_available = 'Kupon dostępny dla produktów tych producentów';
			$heading_selected = 'Kupon <b>niedostępny</b> dla produktów tych kategorii';
			break;
		//end manufacturer exclusions
    //customer exclusions
		case 'customers':
			$heading_available = 'Kupon dostępny dla tych użytkowników';
			$heading_selected = 'Kupon <b>niedostępny</b> dla tych użytkowników';
			break;
		//end customer exclusions
		//product exclusions
		case 'products':
      $heading_available = 'Kupon dostępny dla tych produktów';
			$heading_selected = 'Kupon <b>niedostępny</b> dla tych produktów';
			break;
		//end product exclusions
    //shipping zone exclusions
    case 'zones' :
      $heading_available = 'Kupon dostępny dla tych stref dostawy';
      $heading_selected = 'Kupon <b>niedostępny</b> dla tych stref dostawy';
      break;
    //end zone exclusions
	}
}
define('HEADING_AVAILABLE', $heading_available);
define('HEADING_SELECTED', $heading_selected);

define('MESSAGE_DISCOUNT_COUPONS_EXCLUSIONS_SAVED', 'Nowe zasady dostepności kuponów zostały zapisane');

define('ERROR_DISCOUNT_COUPONS_NO_COUPON_CODE', 'Nie wybrano żadnego kuponu' );
define('ERROR_DISCOUNT_COUPONS_INVALID_TYPE', 'Nie mozna utworzyć wykluczenia');
define('ERROR_DISCOUNT_COUPONS_SELECTED_LIST', 'Błąd '.$HTTP_GET_VARS['type'].'.');
define('ERROR_DISCOUNT_COUPONS_ALL_LIST', 'Błąd: '.$HTTP_GET_VARS['type'].'.');
define('ERROR_DISCOUNT_COUPONS_SAVE', 'Błąd: nie mozna zapisać reguły wykluczeń');

?>
