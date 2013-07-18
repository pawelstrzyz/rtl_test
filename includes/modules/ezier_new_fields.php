<?php
/*
  $Id: \includes\modules\ezier_new_fields.php; 04.07.2006

  mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

?>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
 <tr>
  <td height="2"></td>
 </tr>
 <tr>
  <td align="right">
  <?php 
	$products_id = $HTTP_GET_VARS['products_id'];
	
    if (DISPLAY_PRICE_BRUTTO_NETTO == 'true') {
	    $display_nb = 1;
	  } else {
	    $display_nb = 0;
    }	
  
	if (tep_session_is_registered('customer_id')) {
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
	}

	//Sprawdzenie czy sa znizki dla gosci
	$query_guest_discount = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'GUEST_DISCOUNT'");
	$query_guest_discount_result = tep_db_fetch_array($query_guest_discount);
	$guest_discount = $query_guest_discount_result['configuration_value'];    

	$query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
	$query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide);
	$special_hide = $query_special_prices_hide_result['configuration_value'];

	////////////////////////////////////////////////////////////////////////////////////////////////
	//Towar posiada cene sugerowana
	if ($product_info['products_retail_price'] != 0)	{ 
		// Get the retail price & clean up the decimal places
		$retail = osc_ez(($currencies->display_price_nodiscount($product_info['products_retail_price'],tep_get_tax_rate($product_info['products_tax_class_id']))));
		$special_flag = false;
		$cust_flag = false;
		$hide_flag = false;

		///////////////////////////////////////////////////////////////////////////////////////////////
		//Produkty z ustawiona cena promocyjna i cena producenta BOF

		if (tep_session_is_registered('customer_id')) {                           //Klient jest zalogowany

			if ($query_special_prices_hide_result['configuration_value'] == 'true') {             //Ukryte promocje na wszystkie produkty BOF
				if ($new_price = tep_get_products_special_price($product_info['products_id']) ) {   //Jest cena promocyjna
					if ($customer_discount != 0) {                  //Klient ma znizke
						$our = osc_ez(($currencies->display_price_nodiscount( $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']))));
						$special_price = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - ($product_info['products_price'] - ($product_info['products_price']*abs($customer_discount)/100))), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag = true;
						$cust_flag = true;
						$hide_flag = true;
					} else if ($customer_discount == 0) {           //Klient nie ma znizki
						$our = osc_ez(($currencies->display_price_nodiscount( $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$special_price = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - ($product_info['products_price'] - ($product_info['products_price']*abs($customer_discount)/100))), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag = true;
						$cust_flag = false;
						$hide_flag = true;
					}
				} else {                                                                            // Nie ma ceny promocyjnej
					if ($customer_discount != 0) {                  //Klient ma znizke
						$our = osc_ez(($currencies->display_price_nodiscount( $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']))));
						$special_price = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - ($product_info['products_price'] - ($product_info['products_price']*abs($customer_discount)/100))), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag =false;
						$cust_flag = true;
						$hide_flag = true;
					} else if ($customer_discount == 0) {           //Klient nie ma znizki
						$our = osc_ez(($currencies->display_price_nodiscount( $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - ($product_info['products_price'] - ($product_info['products_price']*abs($customer_discount)/100))), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag = false;
						$cust_flag = false;
						$hide_flag = true;
					}
				}
			} else if ($query_special_prices_hide_result['configuration_value'] == 'false') {     //Cena promocyjna widoczna
				if ($new_price = tep_get_products_special_price($product_info['products_id']) ) {   //Jest cena promocyjna
					$our = osc_ez(($currencies->display_price_nodiscount($product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']))));
					$special_price = osc_ez(($currencies->display_price_nodiscount((tep_get_products_special_price($product_info['products_id'])),tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)),0,$strlen);
					$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - (tep_get_products_special_price($product_info['products_id']) )), tep_get_tax_rate($product_info['products_tax_class_id'])));
					$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
					$special_flag = true;
					$cust_flag = false;
					$hide_flag = false;
				} else {                                                                             // Nie ma ceny promocyjnej
					if ($customer_discount != 0) {                  //Klient ma znizke
						$our = osc_ez(($currencies->display_price_nodiscount( $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']))));
						$special_price = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - ($product_info['products_price'] - ($product_info['products_price']*abs($customer_discount)/100))), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag =false;
						$hide_flag = true;
						$cust_flag = true;
					} else if ($customer_discount == 0) {           //Klient nie ma znizki
						$our = osc_ez(($currencies->display_price_nodiscount( $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - ($product_info['products_price'] - ($product_info['products_price']*abs($customer_discount)/100))), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag = false;
						$hide_flag = true;
						$cust_flag = false;
					}
				}
			}

		} else if  (!(tep_session_is_registered('customer_id'))) {                //Klient niezalogowany

			if ($query_special_prices_hide_result['configuration_value'] == 'true') {             //Ceny promocyjne ukryte
				if ($new_price = tep_get_products_special_price($product_info['products_id']) ) {   //Jest cena promocyjna
					if ($query_guest_discount_result['configuration_value'] != 0) {                   //Sa znizki dla niezalogowanych klientow
						$our = osc_ez(($currencies->display_price_nodiscount($product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']))));
						$special_price = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - ($product_info['products_price'] - ($product_info['products_price']*abs($query_guest_discount_result['configuration_value'])/100))), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag = true;
						$cust_flag = true;
						$hide_flag = true;
					} else if ($query_guest_discount_result['configuration_value'] == 0) {            //Nie ma znizek dla niezalogowanych klientow
						$our = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$special_price = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - ($product_info['products_price'] - ($product_info['products_price']*abs($query_guest_discount_result['configuration_value'])/100))), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag = true;
						$hide_flag = true;
						$cust_flag = false;
					}
				} else {                                                                            // Nie ma ceny promocyjnej
					if ($query_guest_discount_result['configuration_value'] != 0) {                   //Sa znizki dla niezalogowanych klientow
						$our = osc_ez(($currencies->display_price_nodiscount($product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']))));
						$special_price = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - ($product_info['products_price'] - ($product_info['products_price']*abs($query_guest_discount_result['configuration_value'])/100))), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag = true;
						$cust_flag = true;
						$hide_flag = true;
					} else if ($query_guest_discount_result['configuration_value'] == 0) {            //Nie ma znizek dla niezalogowanych klientow
						$our = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$special_price = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - ($product_info['products_price'] - ($product_info['products_price']*abs($query_guest_discount_result['configuration_value'])/100))), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag = true;
						$hide_flag = true;
						$cust_flag = false;
					}
				}
			} else if ($query_special_prices_hide_result['configuration_value'] == 'false') {     //Ceny promocyjne widoczne
				if ($new_price = tep_get_products_special_price($product_info['products_id']) ) {   //Jezeli jest cena promocyjna
					if ($query_guest_discount_result['configuration_value'] != 0) {                   //Klient niezalogowany ma znizke
  					$our = osc_ez(($currencies->display_price_nodiscount($product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']))));
 						$special_price = osc_ez(($currencies->display_price_nodiscount((tep_get_products_special_price($product_info['products_id'])),tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)),0,$strlen);
						$save2 = osc_ez($currencies->display_price_nodiscount($product_info['products_retail_price'] - (tep_get_products_special_price($product_info['products_id'])), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag = true;
						$cust_flag = true;
						$hide_flag = false;
					} else if ($query_guest_discount_result['configuration_value'] == 0) {            //Klient niezalogowany nie ma znizki
  					$our = osc_ez(($currencies->display_price_nodiscount($product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']))));
 						$special_price = osc_ez(($currencies->display_price_nodiscount((tep_get_products_special_price($product_info['products_id'])),tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)),0,$strlen);
						$save2 = osc_ez($currencies->display_price_nodiscount($product_info['products_retail_price'] - (tep_get_products_special_price($product_info['products_id'])), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag = true;
						$cust_flag = true;
						$hide_flag = false;
					}
				} else {
					if ($query_guest_discount_result['configuration_value'] != 0) {          //Sa znizki dla niezalogowanych klientow
						$our = osc_ez(($currencies->display_price_nodiscount($product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']))));
						$special_price = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - ($product_info['products_price'] - ($product_info['products_price']*abs($query_guest_discount_result['configuration_value'])/100))), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag = true;
						$cust_flag = true;
						$hide_flag = true;
					} else if ($query_guest_discount_result['configuration_value'] == 0) {          //Nie ma znizek dla niezalogowanych klientow
						$our = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$special_price = osc_ez(($currencies->display_price($product_info['products_id'], $product_info['products_price'],tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb)));
						$save2 = osc_ez($currencies->display_price_nodiscount(($product_info['products_retail_price'] - ($product_info['products_price'] - ($product_info['products_price']*abs($query_guest_discount_result['configuration_value'])/100))), tep_get_tax_rate($product_info['products_tax_class_id'])));
						$save = (((tep_get_products_special_price($product_info['products_id'])) / ($product_info['products_retail_price'])) * 100);
						$special_flag = true;
						$hide_flag = true;
						$cust_flag = false;
					}
				}
			}
		}

		$save = (100 - $save);
		$save = round($save);
		
		echo '<table border="0" cellspacing="0" cellpadding="4">';
		echo '<tr><td class="smallText" align="right" valign="middle" width="50%">' .TEXT_PRODUCTS_RETAIL_PRICE_INFO. '</td><td class="PriceRetailProduct" align="right" valign="middle" width="40%">' . $retail . '</td></tr>';
			
		if ($special_flag == true && $cust_flag == true && $hide_flag == true) {
			echo '<tr><td class="smallText" align="right" valign="middle width="60%"">' .TEXT_PRODUCTS_PRICE_INFO . '</td><td class="Cena" align="right" width="40%"><span id="nowaCena">' .  $our . '</span></td></tr>';
			echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>'.TEXT_PRODUCTS_PRICE_SPECIAL_CUST . '</b></td><td class="PriceProduct" align="right" width="40%">'. $special_price . '</td></tr>';

		} elseif ($special_flag == true && $cust_flag == false && $hide_flag == true) {
			echo '<tr><td class="smallText" align="right" valign="middle" width="60%">' .TEXT_PRODUCTS_PRICE_INFO . '</td><td class="Cena" align="right" width="40%"><span id="nowaCena">' .  $our . '</span></td></tr>';

    } else if ($special_flag == false && $cust_flag == false && $hide_flag == true) {
			echo '<tr><td class="smallText" align="right" valign="middle" width="60%">' .TEXT_PRODUCTS_PRICE_INFO. '</td><td class="Cena" align="right" width="40%"><span id="nowaCena">'. $our . '</span></td></tr>';

    } else if ($special_flag == false && $cust_flag == true && $hide_flag == true) {
			echo '<tr><td class="smallText" align="right" valign="middle" width="60%">' .TEXT_PRODUCTS_PRICE_INFO . '</td><td class="SmallPriceProduct" align="right" width="40%"><s>' .  $our . '</s></td></tr>';
			echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>'.TEXT_PRODUCTS_PRICE_SPECIAL_CUST . '</b></td><td class="Cena" align="right" width="40%"><span id="nowaCena">'. $special_price . '</span></td></tr>';

    } else if ($special_flag == true && $cust_flag == false && $hide_flag == false) {
			echo '<tr><td class="smallText" align="right" valign="middle" width="60%">' .TEXT_PRODUCTS_PRICE_INFO . '</td><td class="SmallPriceProduct" align="right" width="40%"><s>' .  $our . '</s></td></tr>';
			echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>' .TEXT_PRODUCTS_PRICE_SPECIAL_INFO . '</b></td><td class="Cena" align="right" width="40%"><span id="nowaCena">'. $special_price . '</span></td></tr>';

    } else if ($special_flag == true && $cust_flag == true && $hide_flag == false) {
			echo '<tr><td class="smallText" align="right" valign="middle" width="60%">' .TEXT_PRODUCTS_PRICE_INFO . '</td><td class="SmallPriceProduct" align="right" width="40%"><s>' .  $our . '</s></td></tr>';
			echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>' .TEXT_PRODUCTS_PRICE_SPECIAL_INFO . '</b></td><td class="Cena" align="right" width="40%"><span id="nowaCena">'. $special_price . '</span></td></tr>';

    } else if ($special_flag == false && $cust_flag == false && $hide_flag == false) {
			echo '<tr><td class="smallText" align="right" valign="middle" width="60%">' .TEXT_PRODUCTS_PRICE_INFO. '</td><td class="Cena" align="right" width="40%"><span id="nowaCena">'. $our . '</span></td></tr>';
		}

		echo '<tr><td class="smallText" align="right" valign="middle" width="50%">' .TEXT_PRODUCTS_SAVE_INFO. '</td><td class="PriceRetailProduct" align="right" width="40%"><font color="red">'. $save2 . '</font></td></tr>';  						//This line is price shown
		// echo TEXT_PRODUCTS_SAVE_INFO . $save . '%</font>';  							//This line is % shown
		// echo TEXT_PRODUCTS_SAVE_INFO . $save2 . ' (' . $save . '%)</font>';  		//This line is % and price together
		echo '</table>'; 
	  
	} else {          //Nie ma ceny sugerowanej
		echo '<table border="0" cellspacing="0" cellpadding="4">';

		if ($new_price = tep_get_products_special_price($product_info['products_id'])) {  //Jezeli jest cena promocyjna
			if ($query_special_prices_hide_result['configuration_value'] == 'true') {       //Jezeli cena promocyjna jest ukryta
				if (tep_session_is_registered('customer_id')) {
					if ($customer_discount !=0 ) {  //Jezeli jest upust dla klientow
						echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>' .TEXT_PRODUCTS_PRICE_SPECIAL_CUST . '</b></td>';   //Cena z upustem
					} else if ($customer_discount ==0 ) {
						echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>' .TEXT_PRODUCTS_PRICE_INFO . '</b></td>';   //Nasza cena
					}
				} else if (!(tep_session_is_registered('customer_id'))) {
					if ($guest_discount !=0 ) {  //Jezeli jest upust dla klientow
						echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>' .TEXT_PRODUCTS_PRICE_SPECIAL_CUST . '</b></td>';   //Cena z upustem
					} else if ($guest_discount == 0 ) {
						echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>' .TEXT_PRODUCTS_PRICE_INFO . '</b></td>';   //Nasza cena
					}
				}
			} else {
				echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>' .TEXT_PRODUCTS_PRICE_SPECIAL_INFO . '</b></td>';    //Cena promocyjna
			}
		} else {                                                                          //Jezeli nie jest cena promocyjna
			if  (!(tep_session_is_registered('customer_id'))) {                             //Jezeli nie jest zalogowany
				if ($guest_discount != 0) {  //Jezeli jest upust dla klientow i nie jest cena  promocyjna
					echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>' .TEXT_PRODUCTS_PRICE_SPECIAL_CUST . '</b></td>';    //Cena z upustem
				} else if ($guest_discount == 0) {
					echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>' .TEXT_PRODUCTS_PRICE_INFO . '</b></td>';   //Nasza cena
				}
			} else if (tep_session_is_registered('customer_id')) {
				if ($customer_discount !=0 ) {  //Jezeli jest upust dla klientow i nie jest cena  promocyjna
					echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>' .TEXT_PRODUCTS_PRICE_SPECIAL_CUST . '</b></td>';    //Cena z upustem
				} else if ($customer_discount == 0) {
					echo '<tr><td class="smallText" align="right" valign="middle" width="60%"><b>' .TEXT_PRODUCTS_PRICE_INFO . '</b></td>';   //Nasza cena
				}
			}
		}
		echo '<td align="right" valign="middle" width="40%" nowrap>'.(($product_info['products_price'] > 0) ? $products_price : ''.TEMPORARY_NO_PRICE.'') . '</td></tr>';
		echo '</table>'; 
	}
?>
  </td>
 </tr> 
</table>