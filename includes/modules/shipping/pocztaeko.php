<?php
/*
poprawiono rowniez clase weight - funkcja convert nic nie robi, zwraca otrzymana wartosc wagi bez konwersji. 
Pamietac tez aby w konfiguracji sklepu ustawic rowniez wlasciwa tare opakowania doliczana zawsze do wagi zamowienia.
SART 31.08.2005

 $Id: pocztaeko.php 1 2007-12-20 23:52:06Z kamelianet $
  Some changes to zonesworld for MS2
  by Paul Mathot 2004/05/12
  added: $shipping_num_boxes and shippingtax
  it's a direct replacement for zones.php now
  credits to the osCommerce team and elari

 osCommerce, Open Source E-Commerce Solutions
 http://www.oscommerce.com

 Copyright (c) 2002-2003 elari for osCommerce
 Released under the GNU General Public License

 USAGE
 By default, the module comes with support for 1 zone.  This can be
 easily changed by editing the line below in the pocztaeko constructor
 that defines $this->num_pocztaeko.

 elari
 i have made some change to this module, that come now with 3 default zone
 1 : NL can be changed for your country
 2 : AT,BE,GB,DE,FR,GL,IS,IE,IT,NO,DK,PL,ES,SE,CH,FI,PT,IL,GR   that are other European country except NL defined in zone 1
 3 : All Other World Country not defined.
     If you define more zone, keep in mind that this is the lastest zone that will be used for country not listed
 Next, you will want to activate the module by going to the Admin screen,
 clicking on Modules, then clicking on Shipping.  A list of all shipping
 modules should appear.  Click on the green dot next to the one labeled
 pocztaeko.php.  A list of settings will appear to the right.  Click on the
 Edit button.

 PLEASE NOTE THAT YOU WILL LOSE YOUR CURRENT SHIPPING RATES AND OTHER
 SETTINGS IF YOU TURN OFF THIS SHIPPING METHOD.  Make sure you keep a
 backup of your shipping settings somewhere at all times.
 If you want an additional handling charge applied to orders that use this
 method, set the Handling Fee field.

 Next, you will need to define which countries are in each zone.  Determining
 this might take some time and effort.  You should group a set of countries
 that has similar shipping charges for the same weight.  For instance, when
 shipping from the US, the countries of Japan, Australia, New Zealand, and
 Singapore have similar shipping rates.  As an example, one of my customers
 is using this set of zones:
   1: USA
   2: Canada
   3: Austria, Belgium, Great Britain, France, Germany, Greenland, Iceland,
      Ireland, Italy, Norway, Holland/Netherlands, Denmark, Poland, Spain,
      Sweden, Switzerland, Finland, Portugal, Israel, Greece
   4: Japan, Australia, New Zealand, Singapore
   5: Taiwan, China, Hong Kong

 When you enter these country lists, enter them into the Zone X Countries
 fields, where "X" is the number of the zone.  They should be entered as
 two character ISO country codes in all capital letters.  They should be
 separated by commas with no spaces or other punctuation. For example:
   1: US
   2: CA
   3: AT,BE,GB,FR,DE,GL,IS,IE,IT,NO,NL,DK,PL,ES,SE,CH,FI,PT,IL,GR
   4: JP,AU,NZ,SG
   5: TW,CN,HK

 Now you need to set up the shipping rate tables for each zone.  Again,
 some time and effort will go into setting the appropriate rates.  You
 will define a set of weight ranges and the shipping price for each
 range.  For instance, you might want an order than weighs more than 0
 and less than or equal to 3 to cost 5.50 to ship to a certain zone.
 This would be defined by this:  3:5.5

 You should combine a bunch of these rates together in a comma delimited
 list and enter them into the "Zone X Shipping Table" fields where "X"
 is the zone number.  For example, this might be used for Zone 1:
   1:3.5,2:3.95,3:5.2,4:6.45,5:7.7,6:10.4,7:11.85, 8:13.3,9:14.75,10:16.2,11:17.65,
   12:19.1,13:20.55,14:22,15:23.45

 The above example includes weights over 0 and up to 15.  Note that
 units are not specified in this explanation since they should be
 specific to your locale.

 CAVEATS
 At this time, it does not deal with weights that are above the highest amount
 defined.  This will probably be the next area to be improved with the
 module.  For now, you could have one last very high range with a very
 high shipping rate to discourage orders of that magnitude.  For
 instance:  999:1000

 If you want to be able to ship to any country in the world, you will
 need to enter every country code into the Country fields. For most
 shops, you will not want to enter every country.  This is often
 because of too much fraud from certain places. If a country is not
 listed, then the module will add a $0.00 shipping charge and will
 indicate that shipping is not available to that destination.
 PLEASE NOTE THAT THE ORDER CAN STILL BE COMPLETED AND PROCESSED!
 elari : this has been changed, now the country not listed use the rate defined for
 lastest zone

 It appears that the osC shipping system automatically rounds the
 shipping weight up to the nearest whole unit.  This makes it more
 difficult to design precise shipping tables.  If you want to, you
 can hack the shipping.php file to get rid of the rounding.

 Lastly, there is a limit of 255 characters on each of the Zone
 Shipping Tables and Zone Countries.

 mod eSklep-Os http://www.esklep-os.com
*/

 class pocztaeko {
   var $code, $title, $description, $enabled, $num_pocztaeko;

// class constructor
   function pocztaeko() {
     $this->code = 'pocztaeko';
     $this->title = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_TEXT_TITLE;
     $this->description = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_TEXT_DESCRIPTION;
     $this->sort_order = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_SORT_ORDER;
     $this->icon = '';
     $this->tax_class = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_TAX_CLASS;
     $this->enabled = ((MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_STATUS == 'True') ? true : false);

     // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
     $this->num_pocztaeko = 8;
   }

// class methods
  function quote($method = '') {
     global $order, $shipping_weight, $shipping_num_boxes;

     $dest_country = $order->delivery['country']['iso_code_2'];
     $dest_zone = 0;
     $error = false;

     for ($i=1; $i<=$this->num_pocztaeko; $i++) {
       $countries_table = str_replace(' ','',constant('MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_COUNTRIES_' . $i));
       $country_pocztaeko = split("[;]", $countries_table);
       if (in_array($dest_country, $country_pocztaeko)) {
         $dest_zone = $i;
         break;
       }
     }

     // elari - Added to select default country if not in listing      
     if ($dest_zone == 0) {
       $dest_zone = $this->num_pocztaeko;    // the zone is the lastest zone avalaible
     }
     // elari - Added to select default country if not in listing
     if ($dest_zone == 0) {
       $error = true;      // this can no more achieve since by default the value is set to the max number of zones
     } else {
       $shipping = -1;
       $pocztaeko_cost = constant('MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_COST_' . $dest_zone);
       $pocztaeko_table = split("[:,]" , $pocztaeko_cost);
       $size = sizeof($pocztaeko_table);
       for ($i=0; $i<$size; $i+=2) {
         if ($shipping_weight <= $pocztaeko_table[$i]) {
           $shipping = $pocztaeko_table[$i+1];
           $shipping_method = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_TEXT_WAY . ' ' . $order->delivery['country']['title'] . ': ';
           if ($shipping_num_boxes > 1) {
             $shipping_method .= $shipping_num_boxes . 'x ';
           }
           $shipping_method .= $shipping_weight . ' ' . MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_TEXT_UNITS;
           break;
         }
       }

       if ($shipping == -1) {
         $shipping_cost = 0;
         $shipping_method = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_UNDEFINED_RATE;
       } else {
         $shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_HANDLING_' . $dest_zone);
       }
     }

     $this->quotes = array('id' => $this->code,
                           'module' => MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_TEXT_TITLE,
                           'methods' => array(array('id' => $this->code,
                                                    'title' => $shipping_method,
                                                    'cost' => $shipping_cost)));
     if ($this->tax_class > 0) {
       $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
     }

     if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);
     if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_INVALID_ZONE;
      return $this->quotes;
     }

   function check() {
     if (!isset($this->_check)) {
       $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_STATUS'");
       $this->_check = tep_db_num_rows($check_query);
     }
     return $this->_check;
   }

   // elari - Added to select default country if not in listing
   function install() {
     tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Włączenie modułu', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_STATUS', 'True', 'Czy włączyć moduł Przesyłka Ekonomiczna ?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
     tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Grupa VAT', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_TAX_CLASS', '0', 'Użyj następującej grupy VAT odnośnie tego kosztu wysyłki.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
     tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sortowanie', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_SORT_ORDER', '0', 'Kolejność wyświetlania wśród innych modułów wysyłki.', '6', '0', now())");
     //tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Koszt Pobrania', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_KOSZT_POBRANIA', '6', 'Dodatkowy koszt wysyłki gdy za pobraniem (tylko obszar Polski).', '6', '0', now())");
     for ($i = 1; $i <= $this->num_pocztaeko; $i++) {
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
       tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kraje Obszaru Nr " . $i ." (strefa " . $strefa . " wg cennika Poczty Polskiej)', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_COUNTRIES_" . $i ."', '" . $default_countries . "', 'Oddzielona przecinkami lista dwuznakowych symboli ISO w ramach obszaru Nr " . $i . ".', '6', '0', now())");
       tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tablica kosztów Nr " . $i ." (strefa " . $strefa . " wg cennika Poczty Polskiej)', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_COST_" . $i ."', '" . $shipping_table . "', 'Koszty przesyłki dla Obszaru Nr " . $i . " bazujące na maksymalnej wadze sumarycznej zamowienia. Przykład: 3:8.50,7:10.50,... zamowienia do wagi 3 kosztują 8.50, do wagi 7 kosztują 10.50 w obszarze Nr " . $i . ".', '6', '0', now())");
       tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Dodatkowy stały koszt obsługi wysyłki do Obszaru Nr " . $i ."', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_HANDLING_" . $i ."', '0', 'Dodatkowy stały koszt obsługi wysyłki do tego Obszaru ', '6', '0', now())");
     }
   }

   // elari - Added to select default country if not in listing
   function remove() {
     tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
   }

   function keys() {
     //$keys = array('MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_STATUS', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_TAX_CLASS', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_SORT_ORDER','MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_KOSZT_POBRANIA');
     $keys = array('MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_STATUS', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_TAX_CLASS', 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_SORT_ORDER');
     for ($i=1; $i<=$this->num_pocztaeko; $i++) {
       $keys[] = 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_COUNTRIES_' . $i;
       $keys[] = 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_COST_' . $i;
       $keys[] = 'MODULE_SHIPPING_PRZESYLKA_EKONOMICZNA_HANDLING_' . $i;
     }
     return $keys;
   }
 }
/*
A1: AT,BY,BG,HR,CZ,DK,GL,EE,ET,NL,LT,LU,LV,SK,SI,CH,LI,UA,VA,HU
A2: AL,BE,CY,FI,FR,AD,MC,GI,GR,ES,IE,IS,IL,MK,MT,MD,DE,NO,PT,RU,RO,SE,TR,GB,IE,IT,SM
B: ZA,DZ,AO,BJ,BM,BW,BF,BI,TD,DJ,EG,ER,GA,GM,GH,GN,GW,CM,CA,KE,KM,CG,LS,LR,LY,MG,MW,ML,MA,MR,MU,MX,MZ,NA,NE,NG,CG,CF,CV,RE,RW,SN,SC,SL,SO,US,SZ,SD,SH,ST,TZ,TG,TN,UG,CI,ZM,ZW
C: AF,AI,AG,AN,SA,AR,AM,AZ,BS,BH,BD,BB,BZ,BT,BO,BR,BN,VG,CL,CN,HK,MO,DM,DO,EC,PH,GD,GY,GF,GP,GT,HT,HN,IN,ID,IQ,IR,JM,JP,YE,JO,KY,KH,QA,KZ,KG,CO,KP,KR,CR,CU,KW,LA,LB,MY,MQ,MN,MM,NP,NI,OM,PK,PA,PY,PE,GE,SG,LK,SR,SY,KN,LC,VC,TJ,TH,TW,TT,TM,UY,UZ,VE,VN,AE
D: AU,FJ,KI,NR,NC,NZ,PG,PF,VU,

BOSNIA I HERCEGOWINA? - BRAK CENY
WYSPY OWCZE
ffALKLANDY - BRAK CENY
SALWADOR
SERBIA I CZARNOGORA
TRISTAN DA CUNHA
WYSPA WNIEBOWSTAPIENIA
*/
?>