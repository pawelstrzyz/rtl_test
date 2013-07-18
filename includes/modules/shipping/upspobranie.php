<?php

 class upspobranie {
   var $code, $title, $description, $enabled, $num_ups;

// class constructor
   function upspobranie() {
     global $order;
     $this->code = 'upspobranie';
     $this->title = MODULE_SHIPPING_UPSPOBRANIE_TEXT_TITLE;
     $this->description = MODULE_SHIPPING_UPSPOBRANIE_TEXT_DESCRIPTION;
     $this->sort_order = MODULE_SHIPPING_UPSPOBRANIE_SORT_ORDER;
     $this->icon = '';
     $this->tax_class = MODULE_SHIPPING_UPSPOBRANIE_TAX_CLASS;
     $this->enabled = ((MODULE_SHIPPING_UPSPOBRANIE_STATUS == 'True') ? true : false);

     // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
     $this->num_ups =4;

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_UPSPOBRANIE_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_UPSPOBRANIE_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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

// class methods
  function quote($method = '') {
     global $order, $shipping_weight, $shipping_num_boxes;

     $dest_country = $order->delivery['country']['iso_code_2'];
     $dest_zone = 0;
     $error = false;

     for ($i=1; $i<=$this->num_ups; $i++) {
       $countries_table = str_replace(' ','',constant('MODULE_SHIPPING_UPSPOBRANIE_COUNTRIES_' . $i));
       $country_ups = split("[;]", $countries_table);
       if (in_array($dest_country, $country_ups)) {
         $dest_zone = $i;
         break;
       }
     }

     // elari - Added to select default country if not in listing      
     if ($dest_zone == 0) {
       $dest_zone = $this->num_ups;    // the zone is the lastest zone avalaible
     }
     // elari - Added to select default country if not in listing
     if ($dest_zone == 0) {
       $error = true;      // this can no more achieve since by default the value is set to the max number of zones
     } else {
       $shipping = -1;
       $ups_cost = constant('MODULE_SHIPPING_UPSPOBRANIE_COST_' . $dest_zone);
       $ups_table = split("[:,]" , $ups_cost);
       $size = sizeof($ups_table);
       for ($i=0; $i<$size; $i+=2) {
         if ($shipping_weight <= $ups_table[$i]) {
           $shipping = $ups_table[$i+1];
           $shipping_method = MODULE_SHIPPING_UPSPOBRANIE_TEXT_WAY . ' ' . $order->delivery['country']['title'] . ': ';
           if ($shipping_num_boxes > 1) {
             $shipping_method .= $shipping_num_boxes . 'x ';
           }
           $shipping_method .= $shipping_weight . ' ' . MODULE_SHIPPING_UPSPOBRANIE_TEXT_UNITS;
           break;
         }
       }

       if ($shipping == -1) {
         $shipping_cost = 0;
         $shipping_method = MODULE_SHIPPING_UPSPOBRANIE_UNDEFINED_RATE;
       } else {
         $shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_UPSPOBRANIE_HANDLING_' . $dest_zone);
       }
     }

     $this->quotes = array('id' => $this->code,
                           'module' => MODULE_SHIPPING_UPSPOBRANIE_TEXT_TITLE,
                           'methods' => array(array('id' => $this->code,
                                                    'title' => $shipping_method,
                                                    'cost' => $shipping_cost)));
     if ($this->tax_class > 0) {
       $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
     }

     if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);
     if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_UPSPOBRANIE_INVALID_ZONE;
      return $this->quotes;
     }

   function check() {
     if (!isset($this->_check)) {
       $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_UPSPOBRANIE_STATUS'");
       $this->_check = tep_db_num_rows($check_query);
     }
     return $this->_check;
   }

   // elari - Added to select default country if not in listing
   function install() {
     tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Włączenie modułu', 'MODULE_SHIPPING_UPSPOBRANIE_STATUS', 'True', 'Czy włączyć moduł UPS za pobraniem ?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
     tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Grupa VAT', 'MODULE_SHIPPING_UPSPOBRANIE_TAX_CLASS', '0', 'Użyj następującej grupy VAT odnośnie tego kosztu wysyłki.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Strefa dostawy', 'MODULE_SHIPPING_UPSPOBRANIE_ZONE', '0', 'Wybierz strefę, dla której ma być stosowany ten sposob dostawy', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
     tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sortowanie', 'MODULE_SHIPPING_UPSPOBRANIE_SORT_ORDER', '0', 'Kolejność wyświetlania wśród innych modułów wysyłki.', '6', '0', now())");
     //tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Koszt Pobrania', 'MODULE_SHIPPING_UPSPOBRANIE_KOSZT_POBRANIA', '6', 'Dodatkowy koszt wysyłki gdy za pobraniem (tylko obszar Polski).', '6', '0', now())");
     for ($i = 1; $i <= $this->num_ups; $i++) {
        $default_countries = '';
       if ($i == 1) {
         $strefa = 'Polska';
         $default_countries = 'PL'; ///przesylka ekonomiczna krajowa
         $shipping_table = '0.5:23.00,1:24.00,5:27.50,10:28.00,20:29.50,30:30.50,50:44.00';
       }
       tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kraje Obszaru Nr " . $i ." (wg cennika UPS)', 'MODULE_SHIPPING_UPSPOBRANIE_COUNTRIES_" . $i ."', '" . $default_countries . "', 'Oddzielona średnikami lista dwuznakowych symboli ISO w ramach obszaru Nr " . $i . ".', '6', '0', now())");
       tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tablica kosztów Nr " . $i ." (wg cennika UPS)', 'MODULE_SHIPPING_UPSPOBRANIE_COST_" . $i ."', '" . $shipping_table . "', 'Koszty przesyłki dla Obszaru Nr " . $i . " bazujące na maksymalnej wadze sumarycznej zamowienia. Przykład: 3:8.50,7:10.50,... zamowienia do wagi 3 kosztują 8.50, do wagi 7 kosztują 10.50 w obszarze Nr " . $i . ".', '6', '0', now())");
       tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Dodatkowy stały koszt obsługi wysyłki do Obszaru Nr " . $i ."', 'MODULE_SHIPPING_UPSPOBRANIE_HANDLING_" . $i ."', '0', 'Dodatkowy stały koszt obsługi wysyłki do tego Obszaru ', '6', '0', now())");
     }
   }

   // elari - Added to select default country if not in listing
   function remove() {
     tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
   }

   function keys() {
     //$keys = array('MODULE_SHIPPING_UPSPOBRANIE_STATUS', 'MODULE_SHIPPING_UPSPOBRANIE_TAX_CLASS', 'MODULE_SHIPPING_UPSPOBRANIE_SORT_ORDER','MODULE_SHIPPING_UPSPOBRANIE_KOSZT_POBRANIA');
     $keys = array('MODULE_SHIPPING_UPSPOBRANIE_STATUS', 'MODULE_SHIPPING_UPSPOBRANIE_TAX_CLASS', 'MODULE_SHIPPING_UPSPOBRANIE_SORT_ORDER', 'MODULE_SHIPPING_UPSPOBRANIE_ZONE');
     for ($i=1; $i<=$this->num_ups; $i++) {
       $keys[] = 'MODULE_SHIPPING_UPSPOBRANIE_COUNTRIES_' . $i;
       $keys[] = 'MODULE_SHIPPING_UPSPOBRANIE_COST_' . $i;
       $keys[] = 'MODULE_SHIPPING_UPSPOBRANIE_HANDLING_' . $i;
     }
     return $keys;
   }
 }
?>