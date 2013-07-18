<?php
/*
  $Id: nogiftwrap.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

 mod eSklep-Os http://www.esklep-os.com
*/

  class nogiftwrap {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function nogiftwrap() {
      global $order;

      $this->code = 'nogiftwrap';
      $this->title = MODULE_NOGIFT_TEXT_TITLE;
      $this->description = MODULE_NOGIFT_TEXT_DESCRIPTION;
      $this->enabled = ((MODULE_NOGIFT_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_NOGIFT_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_NOGIFT_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
    }

// class methods1
    function quote($method = '') {
      $this->quotes = array('id' => $this->code,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_NOGIFT_TEXT_WAY,
                                                     'cost' => MODULE_NOGIFT_COST)));

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_NOGIFT_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Zwykłe opakowanie', 'MODULE_NOGIFT_STATUS', 'True', 'Czy chcesz włączyć opcję zwykłego pakowania przesyłki ?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Koszt pakowania', 'MODULE_NOGIFT_COST', '0.00', 'Koszt pakowania przesyłki', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Strefa', 'MODULE_NOGIFT_ZONE', '0', 'Jeżeli zostanie określona strefa - opcja będzie dotyczyła tylko tej strefy.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejność wyświetlania.', 'MODULE_NOGIFT_SORT_ORDER', '1', 'Kolejność wyświetlania opcji Prezent.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_NOGIFT_STATUS', 'MODULE_NOGIFT_COST', 'MODULE_NOGIFT_ZONE', 'MODULE_NOGIFT_SORT_ORDER');
    }
  }
?>