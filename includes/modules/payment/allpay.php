<?php
/*
  $Id: allpay.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Copyright (c) 2005 AllPay.pl

  Publikowane na zasadach licencji GNU General Public License
  
  Autor: AllPay.pl
  http://www.allpay.pl
*/

  class allpay {
    var $code, $title, $description, $enabled;

// class constructor
    function allpay() {
      global $order;

      $this->code = 'allpay';
      $this->title = MODULE_PAYMENT_ALLPAY_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_ALLPAY_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_ALLPAY_SORT_ORDER;
      
      $this->enabled = ((MODULE_PAYMENT_ALLPAY_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_ALLPAY_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_ALLPAY_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();

      $this -> form_action_url = 'https://ssl.allpay.eu/';
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_ALLPAY_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_ALLPAY_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
      return array('id'     => $this->code,
                   'module' => $this->title
		  );
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
    return array('title' => MODULE_PAYMENT_ALLPAY_TEXT_CONFIRMATION
		 );
	     
    
    }

    function process_button() {
      global $order, $currencies, $customer_id, $languages_id;
      $session_id=session_id();

      $my_lang = tep_db_fetch_array(tep_db_query("select code from " . TABLE_LANGUAGES . " where languages_id = '" . (int)$languages_id . "'"));

      $my_order = STORE_NAME." - ". $customer_id."\n";
      if (is_array($order->products)) {
        foreach ($order->products as $pr => $ar) {
	  if (is_array($ar)) { $my_order .= $ar['qty']."x - ".$ar['name']." => ".$ar['model'].": ".$ar['final_price']." ".$order->info['currency']."\n"; }
	}
	$my_order .= "+".$order->info['shipping_method'].": ".$order->info['shipping_cost']." ".$order->info['currency']."\n";
      }
      $delivery_name = $order->delivery['firstname']." ".$order->delivery['lastname'];
      if ($order->delivery['company']) $delivery_addr = $order->delivery['company']."\n";#ap
      $delivery_addr .= $order->delivery['street_address']." ".$order->delivery['suburb']."\n".
                        $order->delivery['city'].", ".$order->delivery['postcode']." ".$order->delivery['state']."\n".
			$order->delivery['country']['title'];

      $process_button_string = tep_draw_hidden_field('session_id', $session_id) .
                               tep_draw_hidden_field('lang', strtolower($my_lang['code'])) .
                               tep_draw_hidden_field('pay', 'yes') .
                               tep_draw_hidden_field('waluta', $order->info[currency]) .
                               tep_draw_hidden_field('osC', '1') .
                               tep_draw_hidden_field('id', MODULE_PAYMENT_ALLPAY_ID) .
			                   tep_draw_hidden_field('kanal', '0') .
			                   tep_draw_hidden_field('URL', tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .
			                   tep_draw_hidden_field('type', '3') .
			                   tep_draw_hidden_field('buttontext', 'Powrót do sklepu') .
                               tep_draw_hidden_field('kwota', round($order->info['total']*$order->info['currency_value'], 2)) .
			                   tep_draw_hidden_field('opis', 'Zamowienie ' . $customer_id . '-' . date('Ymdhis').' - '. STORE_NAME) .
                               tep_draw_hidden_field('forename', $order->billing['firstname']) .
                               tep_draw_hidden_field('surname', $order->billing['lastname']) .
			                   tep_draw_hidden_field('oscdesc', $my_order) .
			                   tep_draw_hidden_field('oscname', $delivery_name) .
			                   tep_draw_hidden_field('deladdr', $delivery_addr) .
                               tep_draw_hidden_field('street', $order->billing['street_address']) .
                               tep_draw_hidden_field('street_n1', $order->billing['suburb']) .
                               tep_draw_hidden_field('city', $order->billing['city']) .
                               tep_draw_hidden_field('bill_state', $order->billing['state']) .
                               tep_draw_hidden_field('postcode', $order->billing['postcode']) .
                               tep_draw_hidden_field('country', $order->billing['country']['title']) .
			                   tep_draw_hidden_field('comments', $order->info['comments']) . 
                               tep_draw_hidden_field('phone', $order->customer['telephone']) .
                               tep_draw_hidden_field('email', $order->customer['email_address']) .
                               tep_draw_hidden_field('return_url', tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .
                               tep_draw_hidden_field('cancel_return_url', tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));#

      if (SESSION_CHECK_IP_ADDRESS == 'True')
      {
        $process_payment_query = tep_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = 'False' where configuration_key = 'SESSION_CHECK_IP_ADDRESS'");
      }
      
      return $process_button_string;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      return false;
    }

    function output_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ALLPAY_STATUS'");#
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values
      ('Włącz moduł AllPay.pl', 'MODULE_PAYMENT_ALLPAY_STATUS', 'True', 'Chcesz uruchomić płatności przez AllPay.pl?', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values
      ('ID w serwisie AllPay.pl', 'MODULE_PAYMENT_ALLPAY_ID', '10', 'Numer ID jakim posługujesz się w serwisie AllPay', '6', '4', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values
      ('Kolejność wyświetlania.', 'MODULE_PAYMENT_ALLPAY_SORT_ORDER', '0', 'Kolejność wyświetlania. Najniższe wyświetlane są na początku.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values
      ('Strefa Płatności', 'MODULE_PAYMENT_ALLPAY_ZONE', '0', 'Jeżeli wybrano strefę ten rodzaj płatności będzie aktywny tylko dla niej.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values
      ('Ustaw Status Zamówienia', 'MODULE_PAYMENT_ALLPAY_ORDER_STATUS_ID', '0', 'Ustaw status zamówień realizowanych tą formą płatności', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_ALLPAY_STATUS', 'MODULE_PAYMENT_ALLPAY_ID', 'MODULE_PAYMENT_ALLPAY_ZONE', 'MODULE_PAYMENT_ALLPAY_ORDER_STATUS_ID','MODULE_PAYMENT_ALLPAY_SORT_ORDER');
    }
  }
?>