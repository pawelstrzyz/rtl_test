<?php
/*
  $Id: przelewy24.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  Autor: Przelewy24.pl <serwis@przelewy24.pl>
  http://www.przelewy24.pl

  //michal.bajer@horyzont.net
  //2006-01-02,03

  mod eSklep-Os http://www.esklep-os.com
*/

  class przelewy24 {
    var $code, $title, $description, $enabled;

// class constructor
    function przelewy24() {
      global $order;

      $this->code = 'przelewy24';
      $this->title = MODULE_PAYMENT_PRZELEWY24_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_PRZELEWY24_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_PRZELEWY24_SORT_ORDER;
      
      $this->enabled = ((MODULE_PAYMENT_PRZELEWY24_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_PRZELEWY24_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_PRZELEWY24_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();

      //$this -> form_action_url = 'https://secure.przelewy24.pl/index.php';
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PRZELEWY24_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_PRZELEWY24_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
             return false;
    }

    function before_process() {
      return false;
    }

    function after_process() {
             global $insert_id,$osCsid,$languages_id;

             session_regenerate_id();
             $osCsid=session_id();

             tep_db_query("DELETE FROM ".TABLE_ORDERS." WHERE p24_session_id='".$osCsid."'"); // delete old session_id

                   $tmp = tep_db_query("select code from " . TABLE_LANGUAGES . " where languages_id = '" . (int)$languages_id . "'");
                   $T = tep_db_fetch_array($tmp);
                   $languages_code = $T["code"];
                   if(!in_array($languages_code,array("pl","PL","en","EN"))) $languages_code="pl";

             tep_db_query("UPDATE ".TABLE_ORDERS." SET p24_session_id='".$osCsid."',p24_languages_code='".$languages_code."' WHERE orders_id='".$insert_id."'");

             tep_redirect(tep_href_link('checkout_przelewy24.php?orders_id='.$insert_id.'&languages_code='.$languages_code, '', 'SSL'));
             exit;
    }

    function output_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PRZELEWY24_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values
      ('Włącz Moduł Przelewy24', 'MODULE_PAYMENT_PRZELEWY24_STATUS', 'True', 'Chcesz uruchomić płatności przez Przelewy24?', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values
      ('ID w serwisie Przelewy24.pl', 'MODULE_PAYMENT_PRZELEWY24_ID', '0000', 'Numer ID jakim posługujesz się w serwisie Przelewy24', '6', '4', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values
      ('Kolejność wyświetlania.', 'MODULE_PAYMENT_PRZELEWY24_SORT_ORDER', '0', 'Kolejność wyświetlania. Najniższe wyświetlane są na początku.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values
      ('Strefa Płatności', 'MODULE_PAYMENT_PRZELEWY24_ZONE', '0', 'Jeżeli wybrano strefę ten rodzaj płatności będzie aktywny tylko dla niej.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values
      ('Ustaw Status Zamówienia', 'MODULE_PAYMENT_PRZELEWY24_ORDER_STATUS_ID', '0', 'Ustaw status zamówień realizowanych tą formą płatności', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");

      tep_db_query("ALTER TABLE ".TABLE_ORDERS." ADD COLUMN p24_session_id varchar(255) not null default ''");
      tep_db_query("ALTER TABLE ".TABLE_ORDERS." ADD COLUMN p24_languages_code varchar(25) not null default ''");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
      tep_db_query("ALTER TABLE ".TABLE_ORDERS." DROP COLUMN p24_session_id");
      tep_db_query("ALTER TABLE ".TABLE_ORDERS." DROP COLUMN p24_languages_code");
    }

    function keys() {
      return array('MODULE_PAYMENT_PRZELEWY24_STATUS', 'MODULE_PAYMENT_PRZELEWY24_ID', 'MODULE_PAYMENT_PRZELEWY24_ZONE', 'MODULE_PAYMENT_PRZELEWY24_ORDER_STATUS_ID','MODULE_PAYMENT_PRZELEWY24_SORT_ORDER');
    }
  }
?>