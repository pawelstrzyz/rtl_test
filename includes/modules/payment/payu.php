<?php
/*
  $Id: payu.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License
  
  Autor: Rafał Mróz <ramroz@optimus.pl>
  http://www.portalik.com

 mod eSklep-Os http://www.esklep-os.com
*/

  class payu {
    var $code, $title, $description, $enabled;

// class constructor
    function payu() {
      global $order;

      $this->code = 'payu';
      $this->title = MODULE_PAYMENT_PAYU_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_PAYU_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_PAYU_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_PAYU_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_PAYU_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_PAYU_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();

      $this->form_action_url = 'https://www.payu.pl/send.php';
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PAYU_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_PAYU_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
      return false;
    }

    function process_button() {
      global $order, $currencies, $customer_id;
      $my_currency = 'PLN';
      $session_id=session_id();
//      $amount=str_replace(".",",");

      $process_button_string = tep_draw_hidden_field('session_id', $session_id) .
                               tep_draw_hidden_field('type', 'b') .
                               tep_draw_hidden_field('to_email', MODULE_PAYMENT_PAYU_ID) .
                               tep_draw_hidden_field('amount', number_format(($order->info['total']) * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency))) .
                               tep_draw_hidden_field('desc', $customer_id . '-' . date('Ymdhis')) .
                               tep_draw_hidden_field('return_url_desc', '<h1>Powrót&#160;do&#160;SKLEPU</h1>') .
                               tep_draw_hidden_field('return_url', tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .
                               tep_draw_hidden_field('cancel_return_url', tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));

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
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYU_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values
      ('Włącz Moduł PayU', 'MODULE_PAYMENT_PAYU_STATUS', 'True', 'Chcesz uruchomić płatności przez PayU?', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values
      ('Adres E-mail', 'MODULE_PAYMENT_PAYU_ID', 'ty@twojsklep.pl', 'Adres e-mail jakim posługujesz się w systemie PayU', '6', '4', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values
      ('Kolejność wyświetlania.', 'MODULE_PAYMENT_PAYU_SORT_ORDER', '0', 'Kolejność wyświetlania. Najniższe wyświetlane są na początku.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values
      ('Strefa Płatności', 'MODULE_PAYMENT_PAYU_ZONE', '0', 'Jeżeli wybrano strefę ten rodzaj płatności będzie aktywny tylko dla niej.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values
      ('Ustaw Status Zamówienia', 'MODULE_PAYMENT_PAYU_ORDER_STATUS_ID', '0', 'Ustaw status zamówień realizowanych tą formą płatności', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_PAYU_STATUS', 'MODULE_PAYMENT_PAYU_ID', 'MODULE_PAYMENT_PAYU_ZONE', 'MODULE_PAYMENT_PAYU_ORDER_STATUS_ID','MODULE_PAYMENT_PAYU_SORT_ORDER');
    }
  }
?>