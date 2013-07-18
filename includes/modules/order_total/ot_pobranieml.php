<?php
  class ot_pobranieml {
    var $title, $output;

    function ot_pobranieml() {
      $this->code = 'ot_pobranieml';
      $this->title = MODULE_PAYMENT_POBRANIEML_TITLE;
      $this->description = MODULE_PAYMENT_POBRANIEML_DESCRIPTION;
      $this->enabled = (( defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'tak')) ? 'nie' : MODULE_PAYMENT_POBRANIEML_STATUS); 
      $this->sort_order = MODULE_PAYMENT_POBRANIEML_SORT_ORDER;
      $this->minimum = MODULE_PAYMENT_POBRANIEML_MINIMUM;
      $this->include_tax = MODULE_PAYMENT_POBRANIEML_INC_TAX;
      $this->howto = MODULE_PAYMENT_POBRANIEML_HOWTO;
      $this->calculate_tax = MODULE_PAYMENT_POBRANIEML_CALC_TAX;
      $this->tax_class = MODULE_PAYMENT_POBRANIEML_TAX_CLASS;
      $this->tax_groups = MODULE_PAYMENT_POBRANIEML_TAX_GROUPS;
      $this->tax_groups = MODULE_PAYMENT_POBRANIEML_TABLE_VALUE;
//      $this->credit_class = true;
      $this->output = array();
    }


    function process() {
     global $order, $currencies, $stawka;


      $od_amount = $this->calculate_fee($this->get_order_total());
      if ($od_amount>0) {
      $this->addition = $od_amount;
      $this->output[] = array('title' => $this->title . ':',
                              'text' => '<b>' . $currencies->format($od_amount) . '</b>',
                              'value' => $od_amount);
    $order->info['total'] = $order->info['total'] + $od_amount;
	}
}


function calculate_fee($amount) {
    global $order, $customer_id, $payment, $method, $cart;
    $do = false;
    
    if ($amount > $this->minimum) {
    $table = split("[,]" , MODULE_PAYMENT_POBRANIEML_TYPE);
    for ($i = 0; $i < count($table); $i++) {
          if ($payment == $table[$i]) $do = true;
    }
   
    $ship2ot_table = split("[,]", MODULE_PAYMENT_POBRANIEML_S_TYPE);
    for ($i = 0; $i < count($ship2ot_table); $i++) {
	$ship2ot_table[$i] = trim($ship2ot_table[$i]);
	$ship2ot_table[$i] = $ship2ot_table[$i] . '_' .$ship2ot_table[$i];
    	if ($GLOBALS['shipping']['id'] == $ship2ot_table[$i]) $doo = true;
    } 
    
 
// xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
// Modyfikacja pobrania uzalezniona od wagi paczki
//
// Createdy by Jaroslaw Sternal alias Jaras on www.oscommerce.pl    

	$stawka = 0; //op3ata sta3a
	$od_pc = 0.5; //% pobrania od kwoty
	$pobranie = 0; //kwota pobrania
	
// definicja stawek pobrania w zaleznosci od wagi (w gramach)
// cena stawki za pobranie wynika z różnicy ceny przesylki pobraniowej priorytetowej
// i paczki priorytetowej (bez ubezpieczenia). 
	$TABLE_VALUE = '5000:4.50,10000:5.00,15000:6.00,20000:5.00,30000:7.00';

//oblicza kwote pobrania wg. powyzszej tabeli
      $TABLE_pobranie = split("[:,]" , $TABLE_VALUE);
      $size = sizeof($TABLE_pobranie);
      for ($i=0, $n=$size; $i<$n; $i+=2) {
        if ($_SESSION['waga'] <= $TABLE_pobranie[$i]) {
          $pobranie = $TABLE_pobranie[$i+1];
          break;
        }
      }

$doo = true; //wlacza zawsze naliczanie pobrania, nawet przy darmowej przesylce    
    if ($do && $doo) {
// Calculate tax reduction if necessary
    if($this->calculate_tax == 'tak') {

// Calculate main tax reduction
    $tod_amount = round($pobranie*100*0.22)/100; //vat od pobrania
    $order->info['tax'] = $order->info['tax'] + $tod_amount;
	$order->info['total'] = $tod_amount + $order->info['total'];

// Calculate tax group deductions
      reset($order->info['tax_groups']);
      while (list($key, $value) = each($order->info['tax_groups'])) {
		if ($key == 'VAT-22') {
        $god_amount = $pobranie*0.22; //tu dolicza do wszystkich vatow
        $order->info['tax_groups'][$key] = $order->info['tax_groups'][$key] + $god_amount;
		}
      }
	  }
// od_amount - stawka netto za pobranie	  

	$amount = $amount + $order->info['shipping_cost'];		 // doliczenie paczki do ceny
	$od_amount = $pobranie;	 // kwota pobrania
	}
	}
	return $od_amount;
}
// koniec modyfikacji
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx	
	
function get_order_total() {
    global  $order, $cart;
    $order_total = $order->info['total'];
// Check if gift voucher is in cart and adjust total
    $products = $cart->get_products();
    for ($i=0; $i<sizeof($products); $i++) {
      $t_prid = tep_get_prid($products[$i]['id']);
      $gv_query = tep_db_query("select products_price, products_tax_class_id, products_model from " . TABLE_PRODUCTS . " where products_id = '" . $t_prid . "'");
      $gv_result = tep_db_fetch_array($gv_query);
      if (ereg('^GIFT', addslashes($gv_result['products_model']))) {
        $qty = $cart->get_quantity($t_prid);
        $products_tax = tep_get_tax_rate($gv_result['products_tax_class_id']);
        if ($this->include_tax =='nie') {
           $gv_amount = $gv_result['products_price'] * $qty;
        } else {
          $gv_amount = ($gv_result['products_price'] + tep_calculate_tax($gv_result['products_price'],$products_tax)) * $qty;
        }
        $order_total=$order_total - $gv_amount;
      }
    }
    if ($this->include_tax == 'nie') $order_total=$order_total-$order->info['tax'];
    if ($this->tax_class > 0) { 
	$this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']); 
    }

	$order_total=$order_total-$order->info['shipping_cost'];
    return $order_total;
  }


    function check() {
      if (!isset($this->check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_POBRANIEML_STATUS'");
        $this->check = tep_db_num_rows($check_query);
      }

      return $this->check;
    }

    function keys() {
      return array('MODULE_PAYMENT_POBRANIEML_STATUS', 'MODULE_PAYMENT_POBRANIEML_SORT_ORDER','MODULE_PAYMENT_POBRANIEML_HOWTO','MODULE_PAYMENT_POBRANIEML_MINIMUM', 'MODULE_PAYMENT_POBRANIEML_TYPE', 'MODULE_PAYMENT_POBRANIEML_INC_TAX', 'MODULE_PAYMENT_POBRANIEML_S_TYPE', 'MODULE_PAYMENT_POBRANIEML_TAX_CLASS', 'MODULE_PAYMENT_POBRANIEML_CALC_TAX', 'MODULE_PAYMENT_POBRANIEML_TABLE_VALUE');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Pokazuj', 'MODULE_PAYMENT_POBRANIEML_STATUS', 'tak', 'Czy chcesz włączyć opłatę za pobranie ?', '6', '1','tep_cfg_select_option(array(\'tak\', \'nie\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sortowanie', 'MODULE_PAYMENT_POBRANIEML_SORT_ORDER', '111', 'Porządek sortowania.', '6', '2', now())");
// ze wzgledu na zmiane w cenniku Poczty Polskiej opcja zostrala wylaczona w wersji 1.1
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Rodzaj pobrania', 'MODULE_PAYMENT_POBRANIEML_HOWTO', 'wpłata STANDARD', 'Sposób w jaki zostaną; przekazane nam pieniądze', '6', '5', 'tep_cfg_select_option(array(\'wpłata STANDARD\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Wliczać Podatek', 'MODULE_PAYMENT_POBRANIEML_INC_TAX', 'tak', 'Wlicz podatek do przeliczeń', '6', '6','tep_cfg_select_option(array(\'tak\', \'nie\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Klasa podatku', 'MODULE_PAYMENT_POBRANIEML_TAX_CLASS', '0', 'Wybierz klasę podatku', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Przelicz podatek', 'MODULE_PAYMENT_POBRANIEML_CALC_TAX', 'nie', 'Przelicz podatek dla zmienionej opłaty.', '6', '5','tep_cfg_select_option(array(\'tak\', \'nie\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Minimalna wartość', 'MODULE_PAYMENT_POBRANIEML_MINIMUM', '', 'Minimalna wartość zamówienia dla naliczania opłaty', '6', '2', now())");
    tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Włącz pobranie dla płatności', 'MODULE_PAYMENT_POBRANIEML_TYPE', 'cod', 'Rodzaj płatności dla naliczania opłaty', '6', '7', now())");
    tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Włącz pobranie dla przesyłki', 'MODULE_PAYMENT_POBRANIEML_S_TYPE', 'tableml', 'Rodzaj przesyłki dla której naliczana jest opłata', '6', '8', now())");
    tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Włącz pobranie dla przeysłki', 'MODULE_PAYMENT_POBRANIEML_TABLE_VALUE', '5000:4.5,10000:5.0,15000:6.0,20000:5.0,30000:7.0', 'tabela pobrania [waga:kwota]', '6', '9', now())");
    }

    function remove() {
      $keys = '';
      $keys_array = $this->keys();
      for ($i=0; $i<sizeof($keys_array); $i++) {
        $keys .= "'" . $keys_array[$i] . "',";
      }
      $keys = substr($keys, 0, -1);

      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . ")");
    }
  }
?>