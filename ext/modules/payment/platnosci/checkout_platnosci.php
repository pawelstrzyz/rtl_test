<?php
/*
  $Id: checkout_platnosci.php 1 2007-12-20 23:52:06Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  Autor: Platnosci.pl <oscommerce@platnosci.pl>
  http://www.platnosci.pl
*/

define('MODULE_PAYMENT_PLATNOSCI_FINAL_CONFIRMATION', 'yes');

chdir('../../../../');
require('includes/application_top.php');

// if the customer is not logged on, redirect them to the login page
if (!tep_session_is_registered('customer_id')) {
	$navigation->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_PAYMENT));
  tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
}

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($cart->count_contents() < 1) {
	tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
}

// avoid hack attempts during the checkout procedure by checking the internal cartID
if (isset($cart->cartID) && tep_session_is_registered('cartID')) {
	if ($cart->cartID != $cartID) {
  	tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  }
}

// if no shipping method has been selected, redirect the customer to the shipping method selection page
if (!tep_session_is_registered('shipping')) {
	tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
}

if (!tep_session_is_registered('payment')) tep_session_register('payment');
if (isset($HTTP_POST_VARS['payment'])) $payment = $HTTP_POST_VARS['payment'];

if (!tep_session_is_registered('comments')) tep_session_register('comments');
if (tep_not_null($HTTP_POST_VARS['comments'])) {
	$comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);
}

// load the selected payment module
require(DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment($payment);

require(DIR_WS_CLASSES . 'order.php');
$order = new order;

$payment_modules->update_status();

if ( ( is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($$payment) ) || (is_object($$payment) && ($$payment->enabled == false)) ) {
	tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
}

if (is_array($payment_modules->modules)) {
	$payment_modules->pre_confirmation_check();
}

// load the selected shipping module
require(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping($shipping);

require(DIR_WS_CLASSES . 'order_total.php');
$order_total_modules = new order_total;

// Stock Check
$any_out_of_stock = false;
if (STOCK_CHECK == 'true') {
	for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
  	if (tep_check_stock($order->products[$i]['id'], $order->products[$i]['qty'])) {
    	$any_out_of_stock = true;
    }
  }
  // Out of Stock
  if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock == true) ) {
  	tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
  }
}

require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_CONFIRMATION);

$breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);
  
if (MODULE_ORDER_TOTAL_INSTALLED) {
	$order_total_modules->process();
  // echo $order_total_modules->output();
}
  
if (is_array($payment_modules->modules)) {
	$confirmation = $payment_modules->confirmation();
};

if (isset($$payment->form_action_url)) {
	$form_action_url = $$payment->form_action_url;
} else {
	$form_action_url = tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
}

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">">
  <title><?php echo 'Potwierdzenie zamówienia'; ?></title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<br><br><br><br><br>
<center>
<?php
echo tep_draw_form('checkout_confirmation', $form_action_url, 'post');

if (is_array($payment_modules->modules)) {
	echo $payment_modules->process_button();
}

$image='button_confirm_order.gif';
$alt=IMAGE_BUTTON_CONFIRM_ORDER;
$image_submit = '<input type="image" src="../../../../' . tep_output_string(DIR_WS_LANGUAGES . $language . '/images/buttons/' . $image) . '" border="0" alt="' . tep_output_string($alt) . '"';

if (tep_not_null($alt)) $image_submit .= ' title=" ' . tep_output_string($alt) . ' "';

if (tep_not_null($parameters)) $image_submit .= ' ' . $parameters;

$image_submit .= '>';

echo $image_submit;
echo '</form>' . "\n";
?>
<SCRIPT language="JavaScript">
	  document.forms['checkout_confirmation'].js.value=1;
	  document.forms['checkout_confirmation'].submit();
</SCRIPT>
</center>
</body>
</html>