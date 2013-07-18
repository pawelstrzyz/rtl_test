<?php
/*
  $Id: paypal_ipn.php 1 2007-12-20 23:52:06Z  $

  Copyright (c) 2004 osCommerce
  Released under the GNU General Public License
  
  Original Authors: Harald Ponce de Leon, Mark Evans 
  Updated by Edith Karnitsch (Terra) with help from PandA.nl, Navyhost and Zoeticlight
    

  mod eSklep-Os http://www.esklep-os.com
*/

  class paypal_ipn {
    var $code, $title, $description, $enabled, $identifier;

// class constructor
    function paypal_ipn() {
      global $order;

      $this->code = 'paypal_ipn';
      $this->title = MODULE_PAYMENT_PAYPAL_IPN_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_PAYPAL_IPN_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_PAYPAL_IPN_STATUS == 'True') ? true : false);
      $this->email_footer = MODULE_PAYMENT_PAYPAL_IPN_TEXT_EMAIL_FOOTER;
      $this->identifier = 'PayPal IPN v1.0';

      if ((int)MODULE_PAYMENT_PAYPAL_IPN_PREPARE_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_PAYPAL_IPN_PREPARE_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();

      if (MODULE_PAYMENT_PAYPAL_IPN_GATEWAY_SERVER == 'Rzeczywisty') {
        $this->form_action_url = 'https://www.paypal.pl/cgi-bin/webscr';
      } else {
        $this->form_action_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
      }
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PAYPAL_IPN_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_PAYPAL_IPN_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
        while ($check = tep_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->billing['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }

    function javascript_validation() {
      return false;
    }

    function selection() {
      return array('id' => $this->code,
                   'module' => $this->title);
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
      global $cartID, $cart_PayPal_IPN_ID, $customer_id, $languages_id, $order, $order_total_modules;

     // if (tep_session_is_registered('cartID')) {
	 // PandA.nl: register_globals fix
     if (array_key_exists('cartID', $_SESSION)) {
        $insert_order = false;

        if (tep_session_is_registered('cart_PayPal_IPN_ID')) {
          $order_id = substr($cart_PayPal_IPN_ID, strpos($cart_PayPal_IPN_ID, '-')+1);

          $curr_check = tep_db_query("select currency from " . TABLE_ORDERS . " where orders_id = '" . (int)$order_id . "'");
          $curr = tep_db_fetch_array($curr_check);

//          if ( ($curr['currency'] != $order->info['currency']) || ($cartID != substr($cart_PayPal_IPN_ID, 0, strlen($cartID))) ) {
//            $check_query = tep_db_query('select orders_id from ' . TABLE_ORDERS_STATUS_HISTORY . ' where orders_id = "' . (int)$order_id . '" limit 1');
    	 		  $check_query = tep_db_query('select orders_id from ' . TABLE_ORDERS_STATUS_HISTORY . ' where orders_id = "' . (int)$order_id . '" limit 2');  //1.4

            $update_order = false;//1.4

//            if (tep_db_num_rows($check_query) < 1) {
//              tep_db_query('delete from ' . TABLE_ORDERS . ' where orders_id = "' . (int)$order_id . '"');
			if (tep_db_num_rows($check_query) == 1) { //1.4
			  $update_order = true; //1.4
              tep_db_query('delete from ' . TABLE_ORDERS_TOTAL . ' where orders_id = "' . (int)$order_id . '"');
              tep_db_query('delete from ' . TABLE_ORDERS_STATUS_HISTORY . ' where orders_id = "' . (int)$order_id . '"');
              tep_db_query('delete from ' . TABLE_ORDERS_PRODUCTS . ' where orders_id = "' . (int)$order_id . '"');
              tep_db_query('delete from ' . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . ' where orders_id = "' . (int)$order_id . '"');
              tep_db_query('delete from ' . TABLE_ORDERS_PRODUCTS_DOWNLOAD . ' where orders_id = "' . (int)$order_id . '"');
            }

            $insert_order = true;
          //}
        } else {
          $insert_order = true;
        }

        if ($insert_order == true) {
          $order_totals = array();
          if (is_array($order_total_modules->modules)) {
            reset($order_total_modules->modules);
            while (list(, $value) = each($order_total_modules->modules)) {
              $class = substr($value, 0, strrpos($value, '.'));
              if ($GLOBALS[$class]->enabled) {
                for ($i=0, $n=sizeof($GLOBALS[$class]->output); $i<$n; $i++) {
                  if (tep_not_null($GLOBALS[$class]->output[$i]['title']) && tep_not_null($GLOBALS[$class]->output[$i]['text'])) {
                    $order_totals[] = array('code' => $GLOBALS[$class]->code,
                                            'title' => $GLOBALS[$class]->output[$i]['title'],
                                            'text' => $GLOBALS[$class]->output[$i]['text'],
                                            'value' => $GLOBALS[$class]->output[$i]['value'],
                                            'sort_order' => $GLOBALS[$class]->sort_order);
                  }
                }
              }
            }
          }

          $sql_data_array = array('customers_id' => $customer_id,
                                  'customers_name' => $order->customer['firstname'] . ' ' . $order->customer['lastname'],
                                  'customers_company' => $order->customer['company'],
                                  'customers_nip' => $order->customer['nip'],
                                  'customers_street_address' => $order->customer['street_address'],
                                  'customers_suburb' => $order->customer['suburb'],
                                  'customers_city' => $order->customer['city'],
                                  'customers_postcode' => $order->customer['postcode'],
                                  'customers_state' => $order->customer['state'],
                                  'customers_country' => $order->customer['country']['title'],
                                  'customers_telephone' => $order->customer['telephone'],
                                  'customers_email_address' => $order->customer['email_address'],
                                  'customers_address_format_id' => $order->customer['format_id'],
                                  'delivery_name' => $order->delivery['firstname'] . ' ' . $order->delivery['lastname'],
                                  'delivery_company' => $order->delivery['company'],
                                  'delivery_nip' => $order->delivery['nip'],
                                  'delivery_street_address' => $order->delivery['street_address'],
                                  'delivery_suburb' => $order->delivery['suburb'],
                                  'delivery_city' => $order->delivery['city'],
                                  'delivery_postcode' => $order->delivery['postcode'],
                                  'delivery_state' => $order->delivery['state'],
                                  'delivery_country' => $order->delivery['country']['title'],
                                  'delivery_address_format_id' => $order->delivery['format_id'],
                                  'billing_name' => $order->billing['firstname'] . ' ' . $order->billing['lastname'],
                                  'billing_company' => $order->billing['company'],
                                  'billing_nip' => $order->billing['nip'],
                                  'billing_street_address' => $order->billing['street_address'],
                                  'billing_suburb' => $order->billing['suburb'],
                                  'billing_city' => $order->billing['city'],
                                  'billing_postcode' => $order->billing['postcode'],
                                  'billing_state' => $order->billing['state'],
                                  'billing_country' => $order->billing['country']['title'],
                                  'billing_address_format_id' => $order->billing['format_id'],
                                  'payment_method' => $order->info['payment_method'],
                                  'cc_type' => $order->info['cc_type'],
                                  'cc_owner' => $order->info['cc_owner'],
                                  'cc_number' => $order->info['cc_number'],
                                  'cc_expires' => $order->info['cc_expires'],
                                  'date_purchased' => 'now()',
                                  'orders_status' => $order->info['order_status'],
                                  'currency' => $order->info['currency'],
                                  'currency_value' => $order->info['currency_value']);

		  //+1.4
		  if ( $update_order ){  
		    tep_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = "' . (int)$order_id . '"');
            $insert_id = (int)$order_id;
		  } else { 
		  //-1.4
          tep_db_perform(TABLE_ORDERS, $sql_data_array);

          $insert_id = tep_db_insert_id();
		  }//1.4

          for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
            $sql_data_array = array('orders_id' => $insert_id,
                                    'title' => $order_totals[$i]['title'],
                                    'text' => $order_totals[$i]['text'],
                                    'value' => $order_totals[$i]['value'],
                                    'class' => $order_totals[$i]['code'],
                                    'sort_order' => $order_totals[$i]['sort_order']);

            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
          }
		  //+1.4
		  $sql_data_array = array('orders_id' => $insert_id, 
                                    'orders_status_id' => $order->info['order_status'], 
                                    'date_added' => 'now()', 
									'customer_notified' => '0', 
                                    'comments' => $order->info['comments']);
          tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
		  //-1.4

          for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
            $sql_data_array = array('orders_id' => $insert_id,
                                    'products_id' => tep_get_prid($order->products[$i]['id']),
                                    'products_model' => $order->products[$i]['model'],
                                    'products_name' => $order->products[$i]['name'],
                                    'products_price' => $order->products[$i]['price'],
                                    'final_price' => $order->products[$i]['final_price'],
                                    'products_tax' => $order->products[$i]['tax'],
                                    'products_quantity' => $order->products[$i]['qty']);

            tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);

            $order_products_id = tep_db_insert_id();

            $attributes_exist = '0';
            if (isset($order->products[$i]['attributes'])) {
              $attributes_exist = '1';
              for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
                if (DOWNLOAD_ENABLED == 'true') {
                  $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename
                                       from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                       left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                       on pa.products_attributes_id=pad.products_attributes_id
                                       where pa.products_id = '" . $order->products[$i]['id'] . "'
                                       and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . $languages_id . "'
                                       and poval.language_id = '" . $languages_id . "'";
                  $attributes = tep_db_query($attributes_query);
                } else {
                  $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");
                }
                $attributes_values = tep_db_fetch_array($attributes);

                $sql_data_array = array('orders_id' => $insert_id,
                                        'orders_products_id' => $order_products_id,
                                        'products_options' => $attributes_values['products_options_name'],
                                        'products_options_values' => $attributes_values['products_options_values_name'],
                                        'options_values_price' => $attributes_values['options_values_price'],
                                        'price_prefix' => $attributes_values['price_prefix']);

                tep_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

                if ((DOWNLOAD_ENABLED == 'true') && isset($attributes_values['products_attributes_filename']) && tep_not_null($attributes_values['products_attributes_filename'])) {
                  $sql_data_array = array('orders_id' => $insert_id,
                                          'orders_products_id' => $order_products_id,
                                          'orders_products_filename' => $attributes_values['products_attributes_filename'],
                                          'download_maxdays' => $attributes_values['products_attributes_maxdays'],
                                          'download_count' => $attributes_values['products_attributes_maxcount']);

                  tep_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
                }
              }
            }
          }

          tep_session_register('cart_PayPal_IPN_ID');
          // Terra register globals fix
          $_SESSION['cart_PayPal_IPN_ID'] = $cartID . '-' . $insert_id;
        }
      }

      return false;
    }

    function process_button() {
      global $customer_id, $order, $languages_id, $currencies, $currency, $cart_PayPal_IPN_ID, $shipping;

      if (MODULE_PAYMENT_PAYPAL_IPN_CURRENCY == 'Wybrana waluta') {
        $my_currency = $currency;
      } else {
        $my_currency = substr(MODULE_PAYMENT_PAYPAL_IPN_CURRENCY, 5);
      }
     if (!in_array($my_currency, array('AUD', 'CAD', 'CHF', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HUF', 'JPY', 'NOK', 'NZD', 'PLN', 'SEK', 'SGD', 'USD'))) {
        $my_currency = 'PLN';
      }

      $parameters = array();

      if ( (MODULE_PAYMENT_PAYPAL_IPN_TRANSACTION_TYPE == 'Za sztuke') && (MODULE_PAYMENT_PAYPAL_IPN_EWP_STATUS == 'False') ) {
        $parameters['cmd'] = '_cart';
        $parameters['upload'] = '1';

        for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
          $item = $i+1;

          $tax_value = ($order->products[$i]['tax'] / 100) * $order->products[$i]['final_price'];

          $parameters['item_name_' . $item] = $order->products[$i]['name'];
          $parameters['amount_' . $item] = number_format($order->products[$i]['final_price'] * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
          $parameters['tax_' . $item] = number_format($tax_value * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
          $parameters['quantity_' . $item] = $order->products[$i]['qty'];

          if ($i == 0) {
            if (DISPLAY_PRICE_WITH_TAX == 'true') {
              $shipping_cost = $order->info['shipping_cost'];
            } else {
              $module = substr($shipping['id'], 0, strpos($shipping['id'], '_'));
              $shipping_tax = tep_get_tax_rate($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
              $shipping_cost = $order->info['shipping_cost'] + tep_calculate_tax($order->info['shipping_cost'], $shipping_tax);
            }

            $parameters['shipping_' . $item] = number_format($shipping_cost * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
          }

          if (isset($order->products[$i]['attributes'])) {
            for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
              if (DOWNLOAD_ENABLED == 'true') {
                $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename
                                     from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                     left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                     on pa.products_attributes_id=pad.products_attributes_id
                                     where pa.products_id = '" . $order->products[$i]['id'] . "'
                                     and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
                                     and pa.options_id = popt.products_options_id
                                     and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
                                     and pa.options_values_id = poval.products_options_values_id
                                     and popt.language_id = '" . $languages_id . "'
                                     and poval.language_id = '" . $languages_id . "'";
                $attributes = tep_db_query($attributes_query);
              } else {
                $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");
              }
              $attributes_values = tep_db_fetch_array($attributes);

// Unfortunately PayPal only accepts two attributes per product, so the
// third attribute onwards will not be shown at PayPal
              $parameters['on' . $j . '_' . $item] = $attributes_values['products_options_name'];
              $parameters['os' . $j . '_' . $item] = $attributes_values['products_options_values_name'];
            }
          }
        }

        $parameters['num_cart_items'] = $item;

              if(MOVE_TAX_TO_TOTAL_AMOUNT == 'True') {
           // PandA.nl move tax to total amount
           $parameters['amount'] = number_format(($order->info['total'] - $order->info['shipping_cost']) * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
           } else {
           // default
          $parameters['amount'] = number_format(($order->info['total'] - $order->info['shipping_cost'] - $order->info['tax']) * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
      }

      } else {
        $parameters['cmd'] = '_ext-enter';
        $parameters['redirect_cmd'] = '_xclick';
        $parameters['item_name'] = STORE_NAME;
        $parameters['shipping'] = '0';
      if(MOVE_TAX_TO_TOTAL_AMOUNT == 'True') {
           // PandA.nl move tax to total amount
           $parameters['amount'] = number_format($order->info['total'] * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
           } else {
           // default
          $parameters['amount'] = number_format(($order->info['total'] - $order->info['tax']) * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
      }
       }

       // billing information fix by gravyface
       // for pre-populating the fiels if customer has no PayPal account
       // only works if force shipping address is set to FALSE
      $state_abbr = tep_get_zone_code($order->delivery['country']['id'], $order->delivery['zone_id'], $order->delivery['state']);
      $name = $order->delivery['firstname'] . ' ' . $order->delivery['lastname'];

      $parameters['business'] = MODULE_PAYMENT_PAYPAL_IPN_ID;

      // let's check what has been defined in the shop admin for the shipping address
      if (MODULE_PAYMENT_PAYPAL_IPN_SHIPPING == 'True') {
      // all that matters is that we send the variables
      // what they contain is irrelevant as PayPal overwrites it with the customer's confirmed PayPal address
      // so what we send is probably not what we'll get back
      $parameters['no_shipping'] = '2';
      $parameters['address_name'] 		= $name;
      $parameters['address_street'] 	= $order->delivery['street_address'];
      $parameters['address_city'] 		= $order->delivery['city'];
      $parameters['address_zip'] 		= $order->delivery['postcode'];
      $parameters['address_state'] 		= $state_abbr;
      $parameters['address_country_code']	= $order->delivery['country']['iso_code_2'];
      $parameters['address_country']	= $order->delivery['country']['title'];
      $parameters['payer_email'] 		= $order->customer['email_address'];
     } else {
      $parameters['no_shipping'] = '1';
      $parameters['H_PhoneNumber'] 	      = $order->customer['telephone'];
      $parameters['first_name'] 		= $order->delivery['firstname'];
      $parameters['last_name'] 		= $order->delivery['lastname'];
      $parameters['address1'] 		= $order->delivery['street_address'];
      $parameters['address2'] 		= $order->delivery['suburb'];
      $parameters['city'] 			= $order->delivery['city'];
      $parameters['zip'] 			= $order->delivery['postcode'];
      $parameters['state'] 			= $state_abbr;
      $parameters['country'] 			= $order->delivery['country']['iso_code_2'];
      $parameters['email'] 			= $order->customer['email_address'];
          }

      $parameters['currency_code'] = $my_currency;
      $parameters['invoice'] = substr($cart_PayPal_IPN_ID, strpos($cart_PayPal_IPN_ID, '-')+1);
      $parameters['custom'] = $customer_id;
      $parameters['no_note'] = '1';
      $parameters['notify_url'] = tep_href_link('ext/modules/payment/paypal_ipn/ipn.php', '', 'SSL', false, false);
      $parameters['cbt'] = CONFIRMATION_BUTTON_TEXT;
      $parameters['return'] = tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
      $parameters['cancel_return'] = tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL');
      $parameters['bn'] = $this->identifier;
      $parameters['lc'] = $order->customer['country']['iso_code_2'];

      if (tep_not_null(MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE)) {
        $parameters['page_style'] = MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE;
      }

      if (MODULE_PAYMENT_PAYPAL_IPN_EWP_STATUS == 'True') {
        $parameters['cert_id'] = MODULE_PAYMENT_PAYPAL_IPN_EWP_CERT_ID;

        $random_string = rand(100000, 999999) . '-' . $customer_id . '-';

        $data = '';
        while (list($key, $value) = each($parameters)) {
          $data .= $key . '=' . $value . "\n";
        }

        $fp = fopen(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'data.txt', 'w');
        fwrite($fp, $data);
        fclose($fp);

        unset($data);

        if (function_exists('openssl_pkcs7_sign') && function_exists('openssl_pkcs7_encrypt')) {
          openssl_pkcs7_sign(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'data.txt', MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt', file_get_contents(MODULE_PAYMENT_PAYPAL_IPN_EWP_PUBLIC_KEY), file_get_contents(MODULE_PAYMENT_PAYPAL_IPN_EWP_PRIVATE_KEY), array('From' => MODULE_PAYMENT_PAYPAL_IPN_ID), PKCS7_BINARY);

          unlink(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'data.txt');

// remove headers from the signature
          $signed = file_get_contents(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt');
          $signed = explode("\n\n", $signed);
          $signed = base64_decode($signed[1]);

          $fp = fopen(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt', 'w');
          fwrite($fp, $signed);
          fclose($fp);

          unset($signed);

          openssl_pkcs7_encrypt(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt', MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt', file_get_contents(MODULE_PAYMENT_PAYPAL_IPN_EWP_PAYPAL_KEY), array('From' => MODULE_PAYMENT_PAYPAL_IPN_ID), PKCS7_BINARY);

          unlink(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt');

// remove headers from the encrypted result
          $data = file_get_contents(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt');
          $data = explode("\n\n", $data);
          $data = '-----BEGIN PKCS7-----' . "\n" . $data[1] . "\n" . '-----END PKCS7-----';

          unlink(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt');
        } else {
          exec(MODULE_PAYMENT_PAYPAL_IPN_EWP_OPENSSL . ' smime -sign -in ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'data.txt -signer ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_PUBLIC_KEY . ' -inkey ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_PRIVATE_KEY . ' -outform der -nodetach -binary > ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt');
          unlink(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'data.txt');

          exec(MODULE_PAYMENT_PAYPAL_IPN_EWP_OPENSSL . ' smime -encrypt -des3 -binary -outform pem ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_PAYPAL_KEY . ' < ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt > ' . MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt');
          unlink(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'signed.txt');

          $fh = fopen(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt', 'rb');
          $data = fread($fh, filesize(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt'));
          fclose($fh);

          unlink(MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY . '/' . $random_string . 'encrypted.txt');
        }

        $process_button_string = tep_draw_hidden_field('cmd', '_s-xclick') .
                                 tep_draw_hidden_field('encrypted', $data);

        unset($data);
      } else {
        while (list($key, $value) = each($parameters)) {
          echo tep_draw_hidden_field($key, $value);
        }
      }

      return $process_button_string;
    }

    function before_process() {
      global $cart;

      $cart->reset(true);

// unregister session variables used during checkout
      tep_session_unregister('sendto');
      tep_session_unregister('billto');
      tep_session_unregister('shipping');
      tep_session_unregister('payment');
      tep_session_unregister('comments');

      tep_session_unregister('cart_PayPal_IPN_ID');

      tep_redirect(tep_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));
    }

    function after_process() {
      return false;
    }

    function output_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYPAL_IPN_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      $check_query = tep_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " where orders_status_name = 'Przygotowane [PayPal]' limit 1");

      if (tep_db_num_rows($check_query) < 1) {
        $status_query = tep_db_query("select max(orders_status_id) as status_id from " . TABLE_ORDERS_STATUS);
        $status = tep_db_fetch_array($status_query);

        $status_id = $status['status_id']+1;

        $languages = tep_get_languages();

        foreach ($languages as $lang) {
          tep_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) values ('" . $status_id . "', '" . $lang['id'] . "', 'Przygotowane [PayPal]')");
        }
      } else {
        $check = tep_db_fetch_array($check_query);

        $status_id = $check['orders_status_id'];
      }

      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('PayPal IPN', 'MODULE_PAYMENT_PAYPAL_IPN_STATUS', 'False', 'Czy chcesz włączyć płatność za pośrednictwem PayPal ?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Serwer PayPal', 'MODULE_PAYMENT_PAYPAL_IPN_GATEWAY_SERVER', 'Testowy', 'Serwer wykorzystywany do dokonywania tranzakcji ?', '6', '2', 'tep_cfg_select_option(array(\'Testowy\',\'Rzeczywisty\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejność wyświetlania.', 'MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER', '0', 'Kolejność wyświetlania.', '6', '3', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Force shipping address?', 'MODULE_PAYMENT_PAYPAL_IPN_SHIPPING', 'False', 'If TRUE the address details for the PayPal Seller Protection Policy are sent but customers without a PayPal account must re-enter their details. If set to FALSE order is not eligible for Seller Protection but customers without acount will have their address fiels pre-populated.', '6', '4', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Adres E-Mail', 'MODULE_PAYMENT_PAYPAL_IPN_ID', '', 'Adres e-mail używany do logowania do serwisu PayPal IPN', '6', '5', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Waluta tranzakcji', 'MODULE_PAYMENT_PAYPAL_IPN_CURRENCY', 'Wybrana waluta', 'Waluta używana podczas tranzakcji w PayPal<br>Wybranie opcji <b>Wybrana waluta</b> pozwala na dokonywanie płatności w walutach dozwolonych w konfiguracji konta w serwisie PayPal.<br>Jeżeli zostanie wybrana konkretna waluta, wszystkie płatności będą przeliczane do tej waluty.', '6', '6', 'tep_cfg_select_option(array(\'Wybrana waluta\',\'Tylko USD\',\'Tylko AUD\',\'Tylko CAD\',\'Tylko EUR\',\'Tylko GBP\',\'Tylko PLN\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Strefa płatności', 'MODULE_PAYMENT_PAYPAL_IPN_ZONE', '0', 'Możesz wybrać strefę dla której będzie obowiązywał ten sposób płatności', '6', '7', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Status przygotowanego zamówienia', 'MODULE_PAYMENT_PAYPAL_IPN_PREPARE_ORDER_STATUS_ID', '" . $status_id . "', 'Status zamówienia przygotowanego do płatności poprzez serwis PayPal', '6', '8', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Status przyjętego zamówienia', 'MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID', '0', 'Status zamówienia po przekazaniu do serwisu PayPal', '6', '9', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Status opłaconego zamówienia', 'MODULE_PAYMENT_PAYPAL_IPN_COMP_ORDER_STATUS_ID', '0', 'Status zamówienia po otrzymaniu potwierdzenia płatności z serwisu PayPal', '6', '10', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Rodzaj tranzakcji', 'MODULE_PAYMENT_PAYPAL_IPN_TRANSACTION_TYPE', 'Razem', 'Określenie czy do serwisu PayPal ma być przesyłany koszt każdej pozycji zamówienia (Za sztuke), czy zbiorcza kwota (Razem)?', '6', '11', 'tep_cfg_select_option(array(\'Za sztuke\',\'Razem\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Podatek VAT', 'MOVE_TAX_TO_TOTAL_AMOUNT', 'True', 'Czy podatek VAT ma być wliczony do całości zamówienia ? Jeżeli tak, system PayPal będzie wyświetlał kwotę zawierającą podatek.', '6', '12', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Wygląd strony', 'MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE', '', 'wygląd strony używanej do dokonywania tranzakcji (definiowany w profilu PayPal)', '6', '13', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Debug E-Mail Adres', 'MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL', '', 'Adres e-mail, na który mają być przesyłane szczegóły nieudanych tranzakcji.', '6', '14', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Szyfrowane połączenie', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_STATUS', 'False', 'Czy chcesz włączyć szyfrowanie połączenia.<BR>Opcja ta wymaga instalacji usługi SSL na serwerze.?', '6', '15', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Klucz prywatny', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_PRIVATE_KEY', '', 'Lokalizacja pliku zawierającego <b>Prywatny klucz</b> do sygnowania danych. (*.pem)', '6', '16', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Klucz publiczny', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_PUBLIC_KEY', '', 'Lokalizacja pliku zawierającego <b>Publiczny klucz</b> do sygnowania danych. (*.pem)', '6', '17', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Klucz publiczny PayPal', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_PAYPAL_KEY', '', 'Lokalizacja pliku zawierającego <b>Publiczny klucz PayPal</b> do sygnowania danych.', '6', '18', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('ID Certyfikatu PayPal', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_CERT_ID', '', 'ID Certyfikatu PayPal (znajduje się w ustawieniach szyfrowania w serwisie PayPal.', '6', '19', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Katalog roboczy', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY', '', 'Katalog, w którym mają być przechowywane pliki tymczasowe. (pamiętaj o slashu na końcu ścieżki)', '6', '20', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Lokalizacja OpenSSL', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_OPENSSL', '/usr/bin/openssl', 'Lokalizacja programu OpenSSL.', '6', '21', now())");

    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

   function keys() {
    // PandA.nl move tax to total amount added: ", 'MOVE_TAX_TO_TOTAL_AMOUNT'"
     return array('MODULE_PAYMENT_PAYPAL_IPN_STATUS', 'MODULE_PAYMENT_PAYPAL_IPN_GATEWAY_SERVER', 'MODULE_PAYMENT_PAYPAL_IPN_ID', 'MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER', 'MODULE_PAYMENT_PAYPAL_IPN_CURRENCY', 'MODULE_PAYMENT_PAYPAL_IPN_ZONE', 'MODULE_PAYMENT_PAYPAL_IPN_SHIPPING', 'MODULE_PAYMENT_PAYPAL_IPN_PREPARE_ORDER_STATUS_ID', 'MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID', 'MODULE_PAYMENT_PAYPAL_IPN_COMP_ORDER_STATUS_ID', 'MODULE_PAYMENT_PAYPAL_IPN_TRANSACTION_TYPE', 'MOVE_TAX_TO_TOTAL_AMOUNT', 'MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE', 'MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL',  'MODULE_PAYMENT_PAYPAL_IPN_EWP_STATUS', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_PRIVATE_KEY', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_PUBLIC_KEY', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_PAYPAL_KEY', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_CERT_ID', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY', 'MODULE_PAYMENT_PAYPAL_IPN_EWP_OPENSSL');
   }
  }
?>