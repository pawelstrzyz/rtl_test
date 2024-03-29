<?php
/*
  $Id: currencies.php 111 2008-02-24 22:01:51Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

 mod eSklep-Os http://www.esklep-os.com
*/

////
// Class to handle currencies
// TABLES: currencies
  class currencies {
    var $currencies;

// class constructor
    function currencies() {
      $this->currencies = array();
      $currencies_query = tep_db_query("select code, title, symbol_left, symbol_right, decimal_point, thousands_point, decimal_places, value from " . TABLE_CURRENCIES);
      while ($currencies = tep_db_fetch_array($currencies_query)) {
        $this->currencies[$currencies['code']] = array('title' => $currencies['title'],
                                                       'symbol_left' => $currencies['symbol_left'],
                                                       'symbol_right' => $currencies['symbol_right'],
                                                       'decimal_point' => $currencies['decimal_point'],
                                                       'thousands_point' => $currencies['thousands_point'],
                                                       'decimal_places' => $currencies['decimal_places'],
                                                       'value' => $currencies['value']);
      }
    }

// class methods
    function format($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {
      global $currency;

      if (empty($currency_type)) $currency_type = $currency;

      if ($calculate_currency_value == true) {
        $rate = (tep_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
        $format_string = $this->currencies[$currency_type]['symbol_left'] . ' ' .number_format(tep_round($number * $rate, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . ' ' . $this->currencies[$currency_type]['symbol_right'];
      } else {
        $format_string = $this->currencies[$currency_type]['symbol_left'] . ' ' . number_format(tep_round($number, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . ' ' . $this->currencies[$currency_type]['symbol_right'];
      }

      return $format_string;
    }

    function calculate_price($products_price, $products_tax, $quantity = 1) {
      global $currency;

      return tep_round(tep_add_tax($products_price, $products_tax), $this->currencies[$currency]['decimal_places']) * $quantity;
    }

    function is_set($code) {
      if (isset($this->currencies[$code]) && tep_not_null($this->currencies[$code])) {
        return true;
      } else {
        return false;
      }
    }

    function get_value($code) {
      return $this->currencies[$code]['value'];
    }

    function get_decimal_places($code) {
      return $this->currencies[$code]['decimal_places'];
    }

	//TotalB2B start
	function display_price($products_id, $products_price, $products_tax, $quantity = 1, $podatek = 0) {
		global $customer_id;

		$query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;      
		if (($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) {
			$query_guest_discount_result = GUEST_DISCOUNT;
			$customer_discount = $query_guest_discount_result;
			if ($customer_discount >= 0) {
				$products_price = $products_price + $products_price * abs($customer_discount) / 100;
			} else {
				$products_price = $products_price - $products_price * abs($customer_discount) / 100;
			}
	  // tu jest wstawiony warunek ktory sprawdza czy ma sie wyswietlac tylko cena brutto czy tez netto
	  if ($podatek == 0) {
		return $this->format($this->calculate_price($products_price, $products_tax, $quantity));
	   } else {
		return $this->format($this->calculate_price($products_price, 0, $quantity)) . '<span class="smallText">'.TEXT_NETTO.'</span><br>' . $this->format($this->calculate_price($products_price, $products_tax, $quantity)) . '<span class="smallText">'.TEXT_BRUTTO.'</span>';
	  }	
		} elseif (tep_session_is_registered('customer_id')) {
			$query_A = tep_db_query("select m.manudiscount_discount from " . TABLE_MANUDISCOUNT .  " m, " . TABLE_PRODUCTS . " p where m.manudiscount_groups_id = 0 and m.manudiscount_customers_id = '" . $customer_id . "' and p.products_id = '" . $products_id . "' and p.manufacturers_id = m.manudiscount_manufacturers_id");
			$query_B = tep_db_query("select m.manudiscount_discount from " . TABLE_CUSTOMERS  . " c, " . TABLE_MANUDISCOUNT .  " m, " . TABLE_PRODUCTS . " p where m.manudiscount_groups_id = c.customers_groups_id  and m.manudiscount_customers_id = 0 and c.customers_id = '" . $customer_id . "' and p.products_id = '" . $products_id . "' and p.manufacturers_id = m.manudiscount_manufacturers_id");
			$query_C = tep_db_query("select m.manudiscount_discount from " . TABLE_MANUDISCOUNT .  " m, " . TABLE_PRODUCTS . " p where m.manudiscount_groups_id = 0 and m.manudiscount_customers_id = 0 and p.products_id = '" . $products_id . "' and p.manufacturers_id = m.manudiscount_manufacturers_id");
			if ($query_result = tep_db_fetch_array($query_A)) {
				$customer_discount = $query_result['manudiscount_discount'];
			} else if ($query_result = tep_db_fetch_array($query_B)) {
				$customer_discount = $query_result['manudiscount_discount'];
			} else if ($query_result = tep_db_fetch_array($query_C)) {
				$customer_discount = $query_result['manudiscount_discount'];
			} else {
				$query = tep_db_query("select g.customers_groups_discount from " . TABLE_CUSTOMERS_GROUPS . " g inner join  " . TABLE_CUSTOMERS  . " c on g.customers_groups_id = c.customers_groups_id and c.customers_id = '" . $customer_id . "'");
				$query_result = tep_db_fetch_array($query);
				$customers_groups_discount = $query_result['customers_groups_discount'];
				$query = tep_db_query("select customers_discount from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
				$query_result = tep_db_fetch_array($query);
				$customer_discount = $query_result['customers_discount'];
				$customer_discount = $customer_discount + $customers_groups_discount;
			}
			if ($customer_discount >= 0) {
				$products_price = $products_price + $products_price * abs($customer_discount) / 100;
			} else {
				$products_price = $products_price - $products_price * abs($customer_discount) / 100;
			}
	  // tu jest wstawiony warunek ktory sprawdza czy ma sie wyswietlac tylko cena brutto czy tez netto			
	  if ($podatek == 0) {
		return $this->format($this->calculate_price($products_price, $products_tax, $quantity));
	   } else {
		return $this->format($this->calculate_price($products_price, 0, $quantity)) . '<span class="smallText">'.TEXT_NETTO.'</span><br>' . $this->format($this->calculate_price($products_price, $products_tax, $quantity)) . '<span class="smallText">'.TEXT_BRUTTO.'</span>';
	  }	
		} else {
			$tekst = '<font class="smallText">'.PRICES_LOGGED_IN_TEXT.'</font>';
			return $tekst;
		}
	}

	function display_price_nodiscount($products_price, $products_tax, $quantity = 1,  $podatek = 0) {
      global $customer_id;
      $query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES; 
      if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
		  // tu jest wstawiony warunek ktory sprawdza czy ma sie wyswietlac tylko cena brutto czy tez netto
		  if ($podatek == 0) {
			return $this->format($this->calculate_price($products_price, $products_tax, $quantity));
		   } else {
			return $this->format($this->calculate_price($products_price, 0, $quantity)) . '<span class="smallText">'.TEXT_NETTO.'</span><br>' . $this->format($this->calculate_price($products_price, $products_tax, $quantity)) . '<span class="smallText">'.TEXT_BRUTTO.'</span>';
		  }	  
		} else {
		 $tekst = '<font class="smallText">'.PRICES_LOGGED_IN_TEXT.'</font>';
		  return $tekst;
	  }
    }
    //TotalB2B end

    function format1($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {
      global $currency;

      if (empty($currency_type)) $currency_type = $currency;

      if ($calculate_currency_value == true) {
        $rate = (tep_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
        $format_string = number_format(tep_round($number * $rate, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']);
				// if the selected currency is in the european euro-conversion and the default currency is euro,
				// the currency will displayed in the national currency and euro currency
        if ( (DEFAULT_CURRENCY == 'EUR') && ($currency_type == 'DEM' || $currency_type == 'BEF' || $currency_type == 'LUF' || $currency_type == 'ESP' || $currency_type == 'FRF' || $currency_type == 'IEP' || $currency_type == 'ITL' || $currency_type == 'NLG' || $currency_type == 'ATS' || $currency_type == 'PTE' || $currency_type == 'FIM' || $currency_type == 'GRD') ) {
          $format_string .= ' <small>[' . $this->format($number, true, 'EUR') . ']</small>';
        }
      } else {
        $format_string = number_format(tep_round($number, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']);
      }

      return $format_string;
    }
  }


?>
