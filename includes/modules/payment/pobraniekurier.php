<?php

  class pobraniekurier {
    var $code, $title, $description, $enabled;

// class constructor
    function pobraniekurier() {
      global $order;

      $this->code = 'pobraniekurier';
      $this->title = MODULE_PAYMENT_POBRANIEKURIER_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_POBRANIEKURIER_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_POBRANIEKURIER_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_POBRANIEKURIER_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_POBRANIEKURIER_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_POBRANIEKURIER_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_POBRANIEKURIER_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_POBRANIEKURIER_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        while ($check = tep_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }

// disable the module if the order only contains virtual products
      if ($this->enabled == true) {
        if ($order->content_type == 'virtual') {
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
      return false;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      return false;
    }

    function get_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_POBRANIEKURIER_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Włącz płatność za pobraniem', 'MODULE_PAYMENT_POBRANIEKURIER_STATUS', 'True', 'Czy chcesz włączyć płatność przy odbiorze za przesyłkę Kurierem ?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Strefa płatności', 'MODULE_PAYMENT_POBRANIEKURIER_ZONE', '0', 'Możesz wybrać strefę dla której będzie obowiązywał ten sposób płatności', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejność wyświetlania', 'MODULE_PAYMENT_POBRANIEKURIER_SORT_ORDER', '0', 'Kolejność wyświetlania', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Status zamówienia', 'MODULE_PAYMENT_POBRANIEKURIER_ORDER_STATUS_ID', '0', 'Ustaw status zamówienia dla tej metody płatności', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
   }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_POBRANIEKURIER_STATUS', 'MODULE_PAYMENT_POBRANIEKURIER_ZONE', 'MODULE_PAYMENT_POBRANIEKURIER_ORDER_STATUS_ID', 'MODULE_PAYMENT_POBRANIEKURIER_SORT_ORDER');
    }
  }
?>