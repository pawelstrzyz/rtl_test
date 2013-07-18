<?php
/*
 * ot_discount_coupon.php
 * August 4, 2006
 * author: Kristen G. Thorson
 * 
 * ot_discount_coupon_codes version 2.0
 *
 * Released under the GNU General Public License
 * 
 */

  define('MODULE_ORDER_TOTAL_DISCOUNT_COUPON_TITLE', 'Kupon rabatowy');
  define('MODULE_ORDER_TOTAL_DISCOUNT_COUPON_TAX_NOT_APPLIED', 'Podatek VAT od kwoty rabatu');
/*
Use this to define how the order total line will display on the order confirmation, invoice, etc.
You can insert variables to have dynamic data display.
Variables:
[code]
[coupon_desc]
[percent_discount]
[coupons_min_order]
[coupons_number_available]
[tax_desc]
*/
  define('MODULE_ORDER_TOTAL_DISCOUNT_COUPON_DISPLAY_FILE', 'Kupon rabatowy nr [code]');
  define('MODULE_ORDER_TOTAL_DISCOUNT_COUPON_TEXT_SHIPPING_DISCOUNT', 'off shipping');
?>
