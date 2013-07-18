<?php

 class pocztaekow {
   var $code, $title, $description, $enabled, $num_pocztaekow;

// class constructor
   function pocztaekow() {
     $this->code = 'pocztaekow';
     $this->title = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_TEXT_TITLE;
     $this->description = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_TEXT_DESCRIPTION;
     $this->sort_order = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_SORT_ORDER;
     $this->icon = '';
     $this->tax_class = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_TAX_CLASS;
     $this->enabled = ((MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_STATUS == 'True') ? true : false);

     // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
     $this->num_pocztaekow = 1;
   }

// class methods
  function quote($method = '') {
     global $order, $shipping_weight, $shipping_num_boxes, $cart, $currencies;

     $dest_country = $order->delivery['country']['iso_code_2'];
     $dest_zone = 0;
     $error = false;


     for ($i=1; $i<=$this->num_pocztaekow; $i++) {
       $countries_table = str_replace(' ','',constant('MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_COUNTRIES_' . $i));
       $country_pocztaekow = split("[;]", $countries_table);
       if (in_array($dest_country, $country_pocztaekow)) {
         $dest_zone = $i;
         break;
       }
     }

     // elari - Added to select default country if not in listing      
     if ($dest_zone == 0) {
       $dest_zone = $this->num_pocztaekow;    // the zone is the lastest zone avalaible
     }
     // elari - Added to select default country if not in listing
     if ($dest_zone == 0) {
       $error = true;      // this can no more achieve since by default the value is set to the max number of zones
     } else {
       $shipping = -1;
       $pocztaekow_cost = constant('MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_COST_' . $dest_zone);
       $pocztaekow_table = split("[:,]" , $pocztaekow_cost);
       $size = sizeof($pocztaekow_table);
       for ($i=0; $i<$size; $i+=2) {
         if ($shipping_weight <= $pocztaekow_table[$i]) {
           $shipping = $pocztaekow_table[$i+1];
           $shipping_method = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_TEXT_WAY . ' ' . $order->delivery['country']['title'] . ': ';
           if ($shipping_num_boxes > 1) {
             $shipping_method .= $shipping_num_boxes . 'x ';
           }
           $shipping_method .= $shipping_weight . ' ' . MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_TEXT_UNITS;
           break;
         }
       }

       if ($shipping == -1) {
         $shipping_cost = 0;
         $shipping_method = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_UNDEFINED_RATE;
       } else {
         $order_total = $cart->show_total();
		 $wartosc_jedn = constant('MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_JEDN_WARTOSC_' . $dest_zone);
		 $cena_jedn = constant('MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_OPLATAWARTOSCI_' . $dest_zone);
		 $wartosc = (ceil(($order_total/$wartosc_jedn)) * $cena_jedn);
         $shipping_method .= '<br>'.MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_WARTOSC. ' : ' .$currencies->display_price('',$order_total,0);
         $shipping_cost = ($shipping * $shipping_num_boxes) + $wartosc + constant('MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_HANDLING_' . $dest_zone);
       }
     }

     $this->quotes = array('id' => $this->code,
                           'module' => MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_TEXT_TITLE,
                           'methods' => array(array('id' => $this->code,
                                                    'title' => $shipping_method,
                                                    'cost' => $shipping_cost)));
     if ($this->tax_class > 0) {
       $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
     }

     if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);
     if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_INVALID_ZONE;
      return $this->quotes;
     }

   function check() {
     if (!isset($this->_check)) {
       $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_STATUS'");
       $this->_check = tep_db_num_rows($check_query);
     }
     return $this->_check;
   }

   // elari - Added to select default country if not in listing
   function install() {
     tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Włączenie modułu', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_STATUS', 'True', 'Czy włączyć moduł Przesyłka Ekonomiczna ?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
     tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Grupa VAT', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_TAX_CLASS', '0', 'Użyj następującej grupy VAT odnośnie tego kosztu wysyłki.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
     tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sortowanie', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_SORT_ORDER', '0', 'Kolejność wyświetlania wśród innych modułów wysyłki.', '6', '0', now())");
     for ($i = 1; $i <= $this->num_pocztaekow; $i++) {
        $default_countries = '';
       if ($i == 1) {
         $strefa = 'Polska';
         $default_countries = 'PL'; ///przesylka ekonomiczna krajowa
         $shipping_table = '0.35:3.9,0.5:4.2,1:5.50,2:7, 5:8.5,10:14.00,15:19,20:27,30:30';
       }
       if ($i == 2) {
         $strefa = '10';
         $default_countries = 'AL;AD;AT;BA;BG;HR;CY;DK; EE;FR;FX;DE;GI;GR; IS;IE;IL;LV;LT;LU;MK; MT;MD;MC;NL;RO;SI; ES;SE;TR;UA;VA;RS;XM'; // strefa PP10
         $shipping_table = '0.35:12.40,0.5:16.30, 1:26.60,2:46.20,3:67,4:75, 5:84,6:86,7:88,8:90,9:92, 10:95,11:100,12:105,13:110,14:116,15:124, 16:127, 17:131,18:136,19:141,20:146,30:237.40';
       }
       if ($i == 3) {
         $strefa = '11';
         $default_countries = 'BE;FI;HU;IT;NO;PT; RU;SM;CH;GB'; // PP11
         $shipping_table = '0.35:12.40,0.5:16.30, 1:26.60,2:46.20,3:67,4:75,5:84, 6:91,7:93,8:100, 9:107,10:115, 11:122,12:130,13:138,14:146, 15:154,16:162,17:170,18:178,19:186,20:194,30:309.0';
       }
       if ($i == 4) {
         $strefa = '12';
         $default_countries = 'CZ;SK'; // PP12
         $shipping_table = '0.35:12.40,0.5:16.30, 1:21,2:23,3:23,4:24,5:24, 6:30,7:30,8:30,9:30, 10:30,11:32,12:35,13:35,14:35,15:35, 16:35,17:43,18:43,19:43,20:43,30:73.40';
       }
       if ($i == 5) {
         $strefa = '13';
         $default_countries = 'BY'; // PP13
         $shipping_table = '0.35:12.40,0.5:16.30, 1:26,2:32,3:37,4:43,5:48, 6:58,7:63,8:67,9:72,10:77, 11:86,12:91,13:96,14:100, 15:105,16:118,17:122,18:127,19:131,20:136,30:213.406';
       }
       if ($i == 6) {
         $strefa = '20';
         $default_countries = 'DZ;AO;BJ;BM;BW;BF;BI;CM; CA;TD;KM;CG;DJ;EG;ER;ET; GA;GM;GH;GN;GW;KE;LS;LY; MG;MW;ML;MR;MU;MX;MA; MZ;NA;NE;NG;RW;SN;SC; SL;SO;ZA;SH;SD;SZ; TZ;TG;TN;UG;US;ZR;ZM;ZW'; //strefa P20
         $shipping_table = '0.35:12.90,0.5:16.80, 1:27.10,2:46.70,3:68,4:76,5:85, 6:89,7:92,8:100,9:108,10:114, 11:122,12:129,13:138,14:150,15:162, 16:165,17:170,18:177, 19:182,20:187,30:301.0';
       }
       if ($i == 7) {
         $strefa = '30';
        $default_countries = 'AF;AI;AG;AR;AM;AW;AZ; BS;BH;BD;BB;BZ;BT;BO; BR;IO;BN;KH;KY;CL;CN; CO;CR;CU;DM;DO;EC;SV; FK;GF;GE;GD;GP;GT;GY; HT;HN;HK;IN;ID;IR;IQ;JM;JP; JO;KZ;KP;KR;KW;KG;LA; LB;MO;MY;MQ;MN;MM; NP;AN;NI;OM;PK;PA;PY; PE;PH;QA;SA;SG;LK;SR; SY;TW;TJ;TH;TT;TM;AE;UY; UZ;VE;VN;VG;YE'; //strefa PP30
         $shipping_table = '0.35:12.90,0.5:16.80, 1:27.10,2:46.70,3:70,4:77,5:86, 6:90,7:98,8:106,9:114,10:122, 11:130,12:139,13:149,14:159, 15:169,16:173,17:178,18:185,19:194,20:200,30:322.0';
       }
       if ($i == 8) {
         $strefa = '40';
         $default_countries = 'Strefa 40 i inne niezdefiniowane kraje'; // this must be the lastest zone			//strefa D i niezdefiniowane kraje
         $shipping_table = '0.35:12.90,0.5:16.80, 1:27.10,2:46.70,3:73,4:79,5:87, 6:95,7:101,8:109,9:116,10:124, 11:133,12:142,13:153,14:163,15:173, 16:178,17:186,18:197,19:206,20:217,30:341';
       }
       tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kraje Obszaru Nr " . $i ." (strefa " . $strefa . " wg cennika Poczty Polskiej)', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_COUNTRIES_" . $i ."', '" . $default_countries . "', 'Oddzielona przecinkami lista dwuznakowych symboli ISO w ramach obszaru Nr " . $i . ".', '6', '0', now())");
       tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tablica kosztów Nr " . $i ." (strefa " . $strefa . " wg cennika Poczty Polskiej)', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_COST_" . $i ."', '" . $shipping_table . "', 'Koszty przesyłki dla Obszaru Nr " . $i . " bazujące na maksymalnej wadze sumarycznej zamowienia. Przykład: 3:8.50,7:10.50,... zamowienia do wagi 3 kosztują 8.50, do wagi 7 kosztują 10.50 w obszarze Nr " . $i . ".', '6', '0', now())");
       tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Dodatkowy stały koszt obsługi wysyłki do Obszaru Nr " . $i ."', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_HANDLING_" . $i ."', '0', 'Dodatkowy stały koszt obsługi wysyłki do tego Obszaru ', '6', '0', now())");
       tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Jednostkowa kwota deklarowanej wartości dla Obszaru Nr " . $i ."', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_JEDN_WARTOSC_" . $i ."', '50.00', 'Jednostkowa kwota deklarowanej wartości przesyłki dla Obszaru ', '6', '0', now())");
       tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Opłata za zadeklarowaną wartość jednostkową dla Obszaru Nr " . $i ."', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_OPLATAWARTOSCI_" . $i ."', '1.00', 'Opłata za zadeklarowaną wartość jednostkową przesyłki dla Obszaru ', '6', '0', now())");
     }
   }

   // elari - Added to select default country if not in listing
   function remove() {
     tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
   }

   function keys() {
     $keys = array('MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_STATUS', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_TAX_CLASS', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_SORT_ORDER');
     for ($i=1; $i<=$this->num_pocztaekow; $i++) {
       $keys[] = 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_COUNTRIES_' . $i;
       $keys[] = 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_COST_' . $i;
       $keys[] = 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_HANDLING_' . $i;
       $keys[] = 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_JEDN_WARTOSC_' . $i;
       $keys[] = 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNAW_OPLATAWARTOSCI_' . $i;
     }
     return $keys;
   }
 }

?>