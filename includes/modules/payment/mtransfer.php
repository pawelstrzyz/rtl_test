<?php
/*
  $Id: mtransfer.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

 mod eSklep-Os http://www.esklep-os.com
*/

  class mtransfer {
    var $code, $title, $description, $enabled;

// class constructor
    function mtransfer() {
      global $order;

      $this->code = 'mtransfer';
      $this->title = MODULE_PAYMENT_MTRANSFER_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_MTRANSFER_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_MTRANSFER_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_MTRANSFER_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_MTRANSFER_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_MTRANSFER_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
      
      
      $this->form_action_url = HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_CHECKOUT_PROCESS;
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_MTRANSFER_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_MTRANSFER_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
      global $order, $currencies, $currency;

      $my_currency = 'PLN';
      $amount=number_format(($order->info['total']) * $currencies->get_value($my_currency), $currencies->get_decimal_places($my_currency));
      $process_button_string = tep_draw_hidden_field('ServiceID', MODULE_PAYMENT_MTRANSFER_ID) .
                               tep_draw_hidden_field('Amount', $amount) .
                               tep_draw_hidden_field('TrDate', 'Now').
                               tep_draw_hidden_field('Description', STORE_NAME);
                               

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
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_MTRANSFER_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values
      ('Włącz Moduł mTRANSFER', 'MODULE_PAYMENT_MTRANSFER_STATUS', 'True', 'Czy chcesz akceptować płatności via mTRANSFER?', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values
      ('Identyfikator', 'MODULE_PAYMENT_MTRANSFER_ID', '123456', 'Identyfikator (ServiceID) nadany przez mBank', '6', '4', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values
      ('Porządek sortowania przy wyświetlaniu.', 'MODULE_PAYMENT_MTRANSFER_SORT_ORDER', '0', 'Kolejność wyświetlania. Najniższe wyświetlane są na początku.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values
      ('Strefa Płatności', 'MODULE_PAYMENT_MTRANSFER_ZONE', '0', 'Jeżeli wybrano strefę ten rodzaj płatności będzie aktywny tylko dla niej.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values
      ('Ustaw Status Zamówienia', 'MODULE_PAYMENT_MTRANSFER_ORDER_STATUS_ID', '0', 'Ustaw status zamówień realizowanych tą formą płatności', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_MTRANSFER_STATUS', 'MODULE_PAYMENT_MTRANSFER_ID',  'MODULE_PAYMENT_MTRANSFER_ZONE', 'MODULE_PAYMENT_MTRANSFER_ORDER_STATUS_ID', 'MODULE_PAYMENT_MTRANSFER_SORT_ORDER');
    }
  }
?>