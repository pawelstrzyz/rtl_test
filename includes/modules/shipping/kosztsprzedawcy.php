<?php
/*
  $Id: kosztsprzedawcy.php 1 2007-12-20 23:52:06Z $ freeamount.php 2

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Copyright (c) 2003

  Released under the GNU General Public License

  ----------------------------------------------
  ane - 06/02/02 - modified freecount.php to
  allow for freeshipping on minimum order amount
  originally written by dwatkins 1/24/02
  Modified BearHappy 09/04/04
  ----------------------------------------------

  mod eSklep-Os http://www.esklep-os.com
*/

  class kosztsprzedawcy {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function kosztsprzedawcy() {
      global $order, $customer;

      $this->code = 'kosztsprzedawcy';
      $this->title = MODULE_SHIPPING_FREEAMOUNT_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_FREEAMOUNT_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_FREEAMOUNT_SORT_ORDER;
      $this->icon ='';
      $this->enabled = ((MODULE_SHIPPING_FREEAMOUNT_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_FREEAMOUNT_ZONE > 0) ) {

        $check_flag = false;
        $check_query = tep_db_query("select zone_id, zone_country_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_FREEAMOUNT_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        $order_shipping_country = $order->delivery['country']['id'];

        while ($check = tep_db_fetch_array($check_query)) {

          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
//          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
          } elseif ($check['zone_country_id'] == $order->delivery['country']['id']) {
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
      global $order, $cart, $shipping_weight, $cart_total, $currencies;

      $dest_country = $order->delivery['country']['id'];
      $currency = $order->info['currency'];
	  $get_total = false;
	  $get_weight = false;
      $cart_total = $cart->show_total();

		if (MODULE_SHIPPING_FREEAMOUNT_HIDE_SPECIALS == 'True') {
		  // 28-9-2005 Check for articles on special which should not get free shipment
		  // Adjust the cart total price for this
		  $total_specials = 0;
		  if ($cart->count_contents() > 0) {
			 $products = $cart->get_products();
			 for ($i=0, $n=sizeof($products); $i<$n; $i++) {
				if ($special_price = tep_get_products_special_price($products[$i]['id'])) {
				   $products_price = $special_price;
				   $total_specials += $products_price;
				}
			 }
		  }

	      $cart_total = $cart_total - $total_specials;
		}

	  if ($cart_total < MODULE_SHIPPING_FREEAMOUNT_AMOUNT)
	  {
		if (MODULE_SHIPPING_FREEAMOUNT_DISPLAY == 'True')
		   {
//			$this->quotes['error'] = MODULE_SHIPPING_FREEAMOUNT_TEXT_ERROR;
	    	  	$this->quotes['error'] = MODULE_SHIPPING_FREEAMOUNT_TEXT_ERROR_1.' '. $currencies->format(MODULE_SHIPPING_FREEAMOUNT_AMOUNT). ' '.MODULE_SHIPPING_FREEAMOUNT_TEXT_ERROR_2;

		   
		   }
		$get_total = false;
	   } else {
	    $get_total = true;
	   }

      if ($shipping_weight > MODULE_SHIPPING_FREEAMOUNT_WEIGHT_MAX)
	      {
			if (MODULE_SHIPPING_FREEAMOUNT_DISPLAY == 'True')
			   {
	    	  	//$this->quotes['error'] = MODULE_SHIPPING_FREEAMOUNT_TEXT_TO_HEIGHT_1;
	    	  	$this->quotes['error'] = sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_SHIPPING_FREEAMOUNT_AMOUNT), MODULE_SHIPPING_FREEAMOUNT_WEIGHT_MAX);

			   
			   }
			$get_weight = false;
	  } else {
	   $get_weight = true;
	  }

	if (($get_total == true && $get_weight == true))
	{
		$this->quotes = array('id' => $this->code,
								'module' => MODULE_SHIPPING_FREEAMOUNT_TEXT_TITLE,
								'methods' => array(array('id' => $this->code,
								'title' => MODULE_SHIPPING_FREEAMOUNT_TEXT_WAY_1.' '. $currencies->format(MODULE_SHIPPING_FREEAMOUNT_AMOUNT). ' '.MODULE_SHIPPING_FREEAMOUNT_TEXT_WAY_2,
								'cost' => MODULE_SHIPPING_FREEAMOUNT_COST)));
	}


	  if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

	  return $this->quotes;

	}

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FREEAMOUNT_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Dostawa na koszt sprzedawcy', 'MODULE_SHIPPING_FREEAMOUNT_STATUS', 'True', 'Możesz oferować przesyłkę na koszt dostawcy przy zamówieniu powyżej określoej kwoty', '6', '7', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id,  sort_order, date_added) values ('Maksymalna waga przesyłki', 'MODULE_SHIPPING_FREEAMOUNT_WEIGHT_MAX', '10', 'Podaj maksymalną wagę przesyłki na koszt sprzedawcy', '6', '8', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Włącz wyświetlanie', 'MODULE_SHIPPING_FREEAMOUNT_DISPLAY', 'True', 'Czy chcesz wyświetlać informację, jeżeli zamówenie nie osiągnęło wymaganej kwoty?', '6', '7', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id,  sort_order, date_added) values ('Minimalny koszt', 'MODULE_SHIPPING_FREEAMOUNT_AMOUNT', '600.00', 'Minimalny koszt zamówienia od którego przesyłka jest na koszt sprzedawcy', '6', '8', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id,  sort_order, set_function, date_added) values ('Wyłącz dla promocji', 'MODULE_SHIPPING_FREEAMOUNT_HIDE_SPECIALS', 'True', 'Czy dostawa na koszt sprzedawcy ma być wyłączona dla produktów objętych promocjami?', '6', '7', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejność wyświetlania', 'MODULE_SHIPPING_FREEAMOUNT_SORT_ORDER', '0', 'Kolejność wyświetlania', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Strefa dostawy', 'MODULE_SHIPPING_FREEAMOUNT_ZONE', '0', 'Możesz wybrać strefę dla której będzie obowiązywał ten sposób dostawy', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
   }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

   function keys() {
     $keys = array(
           'MODULE_SHIPPING_FREEAMOUNT_STATUS',
           'MODULE_SHIPPING_FREEAMOUNT_WEIGHT_MAX',
           'MODULE_SHIPPING_FREEAMOUNT_SORT_ORDER',
           'MODULE_SHIPPING_FREEAMOUNT_DISPLAY',
           'MODULE_SHIPPING_FREEAMOUNT_HIDE_SPECIALS',
           'MODULE_SHIPPING_FREEAMOUNT_AMOUNT',
           'MODULE_SHIPPING_FREEAMOUNT_ZONE'
           );
     return $keys;
   }
 }
?>