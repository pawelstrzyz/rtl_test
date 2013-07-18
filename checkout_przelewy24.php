<?php
/*
  $Id: checkout_przelewy24.php 1 2007-12-20 23:52:06Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  //michal.bajer@horyzont.net
  //2006-01-02,03

  mod eSklep-Os http://www.esklep-os.com
*/

  require('includes/application_top.php');

// if the customer is not logged on, redirect them to the shopping cart page
  if (!tep_session_is_registered('customer_id')) {
    tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
  }


// load selected payment module
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment($payment);

// load the selected shipping module
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping($shipping);

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

  require(DIR_WS_CLASSES . 'order_total.php');
  $order_total_modules = new order_total;

  $order_totals = $order_total_modules->process();

  require(DIR_WS_LANGUAGES . $language . '/' . 'checkout_przelewy24.php');

  $languages_code=isset($HTTP_GET_VARS['languages_code'])&&strlen($HTTP_GET_VARS['languages_code'])>0?$HTTP_GET_VARS['languages_code']:'pl';


      $my_currency = 'PLN';

      $session_id=session_id();

      $process_button_string = tep_draw_hidden_field('p24_session_id', $session_id) .
             tep_draw_hidden_field('p24_id_sprzedawcy', MODULE_PAYMENT_PRZELEWY24_ID) .
             tep_draw_hidden_field('p24_kwota', number_format(($order->info['total'] * $currencies->get_value($my_currency)), 2, ".", "")*100) .
             tep_draw_hidden_field('p24_opis', 'Zamowienie nr '.$HTTP_GET_VARS['orders_id'].', ' . $order->customer['firstname'] . ' ' . $order->customer['lastname'].', ' . date('Ymdhi').', '. STORE_NAME) .
             //tep_draw_hidden_field('p24_opis', 'TEST_ERR') .
             tep_draw_hidden_field('p24_return_url_ok', tep_href_link('przelewy24.php', '', 'SSL')) .
             tep_draw_hidden_field('p24_language', $languages_code) .
             tep_draw_hidden_field('p24_email', $order->customer['email_address']) .
             tep_draw_hidden_field('p24_klient', $order->delivery['firstname'] . ' ' . $order->delivery['lastname']) .
             tep_draw_hidden_field('p24_adres', $order->delivery['street_address']) .
             tep_draw_hidden_field('p24_miasto', $order->delivery['city']) .
             tep_draw_hidden_field('p24_kod', $order->delivery['postcode']) .
             tep_draw_hidden_field('p24_kraj', $order->delivery['country']['iso_code_2']) .
             tep_draw_hidden_field('p24_return_url_error', tep_href_link('przelewy24_error.php', '', 'SSL'))
             ;


  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_CHECKOUT_PRZELEWY24, '', 'SSL'));

  $content = CONTENT_CHECKOUT_PRZELEWY24;

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
