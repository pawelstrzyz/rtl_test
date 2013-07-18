<?php
/*
  $Id: platnosci.php 1 2007-12-20 23:52:06Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  Autor: Platnosci.pl <oscommerce@platnosci.pl>
  http://www.platnosci.pl
*/

  class platnosci{
    var $code, $title, $description, $enabled, $identifier;

    function utf82iso88592($text) {
        $text = str_replace("\xC4\x85", '±', $text);
        $text = str_replace("\xC4\x84", 'ˇ', $text);
        $text = str_replace("\xC4\x87", 'ć', $text);
        $text = str_replace("\xC4\x86", 'Ć', $text);
        $text = str_replace("\xC4\x99", 'ę', $text);
        $text = str_replace("\xC4\x98", 'Ę', $text);
        $text = str_replace("\xC5\x82", 'ł', $text);
        $text = str_replace("\xC5\x81", 'Ł', $text);
        $text = str_replace("\xC3\xB3", 'ó', $text);
        $text = str_replace("\xC3\x93", 'Ó', $text);
        $text = str_replace("\xC5\x9B", '¶', $text);
        $text = str_replace("\xC5\x9A", '¦', $text);
        $text = str_replace("\xC5\xBC", 'ż', $text);
        $text = str_replace("\xC5\xBB", 'Ż', $text);
        $text = str_replace("\xC5\xBA", 'Ľ', $text);
        $text = str_replace("\xC5\xB9", '¬', $text);
        $text = str_replace("\xc5\x84", 'ń', $text);
        $text = str_replace("\xc5\x83", 'Ń', $text);
        return $text;
    }

// class constructor
    function platnosci() {
      global $order;

      $this->code = 'platnosci';
      $this->title = MODULE_PAYMENT_PLATNOSCI_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_PLATNOSCI_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_PLATNOSCI_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_PLATNOSCI_STATUS == 'True') ? true : false);
      $this->list_enabled = ((MODULE_PAYMENT_PLATNOSCI_LIST_STATUS == 'True') ? true : false);
      $this->identifier = 'osCommerce Platnosci v 3.04';      
	  	$this->orders_status_name = 'Płatności [nowe zamówienie]';
		
    	if (MODULE_PAYMENT_PLATNOSCI_FINAL_CONFIRMATION=='yes') {
				$this -> form_action_url = 'https://www.platnosci.pl/paygw/UTF/NewPayment';
    	} else {
      	if (ENABLE_SSL == true) {
    			$this->form_action_url = HTTPS_SERVER . DIR_WS_HTTP_CATALOG . "ext/modules/payment/platnosci/checkout_platnosci.php";
      	} else {
    			$this->form_action_url = HTTP_SERVER . DIR_WS_HTTP_CATALOG . "ext/modules/payment/platnosci/checkout_platnosci.php";
      	};
    	};

			$this->active_flag = "aktywny";
			$this->inactive_flag = "nieaktywny";
	
			$pay_types_url = "https://www.platnosci.pl/paygw/UTF/xml/";
			$pay_types_url .= MODULE_PAYMENT_PLATNOSCI_POS_ID;
			$pay_types_url .= "/";
			$pay_types_url .= substr(MODULE_PAYMENT_PLATNOSCI_KEY1,0,2);
			$pay_types_url .= "/paytype.xml";
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $pay_types_url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	$pay_types_response = curl_exec($ch);
    	curl_close($ch);

    	$parser = xml_parser_create();
    	xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    	xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    	xml_parse_into_struct($parser, $pay_types_response, $values, $tags);
    	xml_parser_free($parser);

    	foreach ($tags as $key=>$val) {
      	if ($key == "paytype") {
        	$paytypes = $val;
          for ($i=0; $i < count($paytypes); $i+=2) {
          	$offset = $paytypes[$i] + 1;
            $len = $paytypes[$i + 1] - $offset;
            $payvalues = array_slice($values, $offset, $len);
            for ($j=0; $j < count($payvalues); $j++) {
//            	$pay_item[$payvalues[$j]["tag"]] = $this -> utf82iso88592($payvalues[$j]["value"]);
            	$pay_item[$payvalues[$j]["tag"]] = iconv('ISO-8859-2', 'UTF-8', $payvalues[$j]["value"]);
            }
            $this -> payment_types[] = array(
                     'pay_type' => $pay_item['type'],
                     'enabled' => $pay_item['enable'],
                     'img_url'	=> $pay_item['img'],
                     'title'	=> $pay_item['name'],
                     'description'	=> $pay_item['name']
    				);
          }
        } else {
        	continue;
        }
    	}
  						
    	$this->platnosci_status = array(
							'1' => array('desc'=>'nowa', 'conf_key'=>'MODULE_PAYMENT_PLATNOSCI_STATUS_1'),
							'2' => array('desc'=>'anulowana', 'conf_key'=>'MODULE_PAYMENT_PLATNOSCI_STATUS_2'),
							'3' => array('desc'=>'odrzucona', 'conf_key'=>'MODULE_PAYMENT_PLATNOSCI_STATUS_3'),
							'4' => array('desc'=>'rozpoczęta', 'conf_key'=>'MODULE_PAYMENT_PLATNOSCI_STATUS_4'),
							'5' => array('desc'=>'oczekuje na odbiór', 'conf_key'=>'MODULE_PAYMENT_PLATNOSCI_STATUS_5'),
							'6' => array('desc'=>'autoryzacja odmowna', 'conf_key'=>'MODULE_PAYMENT_PLATNOSCI_STATUS_6'),
							'7' => array('desc'=>'środki odrzuconej', 'conf_key'=>'MODULE_PAYMENT_PLATNOSCI_STATUS_7'),
							'99' => array('desc'=>'zakończona', 'conf_key'=>'MODULE_PAYMENT_PLATNOSCI_STATUS_99'),
							'888' => array('desc'=>'błędny status', 'conf_key'=>'MODULE_PAYMENT_PLATNOSCI_STATUS_888'),
			);
						
			$this->error_message = array(
							"100" => "brak parametru pos id",
							"101" => "brak parametru session id",
							"102" => "brak parametru ts",
							"103" => "brak parametru sig",
							"104" => "brak parametru desc",
							"105" => "brak parametru client ip",
							"106" => "brak parametru first name",
							"107" => "brak parametru last name",
							"108" => "brak parametru street",
							"109" => "brak parametru city",
							"110" => "brak parametru post code",
							"111" => "brak parametru amount",
							"112" => "błędny numer konta bankowego",
							"200" => "inny chwilowy błąd",
							"201" => "inny chwilowy błąd bazy danych",
							"202" => "POS o podanym identyfikatorze jest zablokowany",
							"203" => "niedozwolona wartość pay_type dla danego pos_id",
							"204" => "podana metoda płatności (wartość pay_type) jest chwilowo zablokowana dla danego pos_id, np. przerwa konserwacyjna bramki płatniczej",
							"205" => "kwota transakcji mniejsza od wartości minimalnej",
							"206" => "kwota transakcji większa od wartości maksymalnej",
							"207" => "przekroczona wartość wszystkich transakcji dla jednego klienta w ostatnim przedziale czasowym",
							"208" => "POS działa w wariancie ExpressPayment lecz nie nastapiła aktywacja tego wariantu współpracy (czekamy na zgode działu obsługi klienta)",
							"209" => "błedny numer pos_id lub pos_auth_key",
							"500" => "transakcja nie istnieje",
							"501" => "brak autoryzacji dla danej transakcji",
							"502" => "transakcja rozpoczęta wcześniej",
							"503" => "autoryzacja do transakcji była juz przeprowadzana",
							"504" => "transakcja anulowana wczesniej",
							"505" => "transakcja przekazana do odbioru wcześniej",
							"506" => "transakcja już odebrana",
							"507" => "błąd podczas zwrotu środków do klienta",
							"599" => "błędny stan transakcji, np. nie można uznać transakcji kilka razy lub inny, prosimy o kontakt",
							"999" => "inny błąd krytyczny - prosimy o kontakt	"
			);
	

      if (is_object($order)) $this->update_status();
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PLATNOSCI_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_PLATNOSCI_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
        global $HTTP_POST_VARS, $Platnosci_pay_type;
        
    $constans_array = get_defined_constants();
    $ALLOWED_PAY_TYPE_ARRAY =	array();
    $ALLOWED_PAY_TYPE_ARRAY_IMG =	array();
    
    foreach ($this->payment_types as $key=>$value) {
    	if ($value['enabled']=="true") {
    	    $ALLOWED_PAY_TYPE_ARRAY[] = array('id' => $value['pay_type'], 'text' => $value['title']);
    	    $ALLOWED_PAY_TYPE_ARRAY_IMG[$value['pay_type']] = $value['img_url'];
    	}
    }

    $fields = array();
  
    if ($this->list_enabled) {
        $default='';
        if (tep_session_is_registered('Platnosci_pay_type')) $default = $Platnosci_pay_type;
    	$ALLOWED_PAY_TYPE_ARRAY[] = array('id' => '', 'text' => "-- wybierz typ --");
        $fields[] = array(
	    'title' => MODULE_PAYMENT_PLATNOSCI_TEXT_PAYMENT_TYPE,
        'field' => tep_draw_pull_down_menu('pay_type', $ALLOWED_PAY_TYPE_ARRAY, $default)
      );
    } else {
        
        $script = "<script language='JavaScript' type='text/JavaScript'>\n".
        "function radio_button_sel(i) {\n".
        "if (document.getElementById && !document.all && document.getElementById(i)){\n".
        "document.getElementById(i).checked=true;\n".
        "}\n".
        "if (document.all && document.all[i]){\n".
        "document.all[i].checked=true;\n".
        "}}\n</script> \n";
        echo $script;        
        
        foreach ($ALLOWED_PAY_TYPE_ARRAY as $key => $payment) {
        if (tep_session_is_registered('Platnosci_pay_type')) {   
          if ($payment['id'] == $Platnosci_pay_type) {
              $checked=true;    
          } else {
              $checked=false;    
          }
        } else $checked=false;
        $img_file = $ALLOWED_PAY_TYPE_ARRAY_IMG[$payment['id']];
        $display_image = '<img src="'.$img_file.'" alt="'.$payment['text'].'" title="'.$payment['text'].'" onclick="javascript:radio_button_sel(\''.$payment['id'].'\')">';          
        $fields[] = array(
          'title' => $display_image,
    	  'field' => tep_draw_radio_field('pay_type', $value = $payment['id'], $checked, 'id="'.$payment['id'].'"') 
        );
      }
    }
    
    
    if (MODULE_PAYMENT_PLATNOSCI_PAYBACK == 'włączony')
    $fields[] = array('title' => MODULE_PAYMENT_PLATNOSCI_TEXT_PAYBACK_LOGIN,
                   'field' => tep_draw_input_field('payback_login', $this->payback_login));

    return array('id' => $this->code,
                   'module' => $this->title,
                   'fields' => $fields );
    }

    function pre_confirmation_check() {
      global $HTTP_POST_VARS, $Platnosci_pay_type;

        include(DIR_WS_CLASSES . 'platnosci_validation.php');

        $platnosci_validation = new platnosci_validation();
        $result = $platnosci_validation->validate($HTTP_POST_VARS['payback_login']);

        $error = '';
        switch ($result) {
          case -1:
            $error = sprintf(TEXT_PLATNOSCIVAL_ERROR_PAYBACKLOGIN_WRONG_FORMAT, $platnosci_validation->payback_login);
            break;
        }

        $this->payback_login = $platnosci_validation->payback_login;
		if ( ($result == false) || ($result < 1) ) {
          $payment_error_return = 'payback_login=' . urlencode($this->payback_login) . '&payment_error=' . $this->code . '&error=' . urlencode($error) . '&pay_type=' . urlencode($HTTP_POST_VARS['pay_type']);
          tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
        }
        
        if ( strlen(urlencode($HTTP_POST_VARS['pay_type'])) < 1 ) {
          $error = sprintf(TEXT_PLATNOSCIVAL_ERROR_PAY_TYPE_NOT_SELECTED);
          $payment_error_return = 'payback_login=' . urlencode($this->payback_login) . '&payment_error=' . $this->code . '&error=' . urlencode($error) . '&pay_type=' . urlencode($HTTP_POST_VARS['pay_type']);
          tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
        } else {
            if (tep_session_is_registered('Platnosci_pay_type')) {
                $Platnosci_pay_type = urlencode($HTTP_POST_VARS['pay_type']);
            } else {
                tep_session_register('Platnosci_pay_type');
                $Platnosci_pay_type = urlencode($HTTP_POST_VARS['pay_type']);
            }
        }
    }

    function confirmation() {
      global $cartID, $cart_Platnosci_ID, $customer_id, $languages_id, $cart, $order, $order_total_modules, $HTTP_POST_VARS;

      if (MODULE_PAYMENT_PLATNOSCI_FINAL_CONFIRMATION=='yes') {
           
      if ( tep_session_is_registered('cartID') && ($cartID <> '')) {
        $insert_order = false;

        if (tep_session_is_registered('cart_Platnosci_ID')) {
          $order_id = substr($cart_Platnosci_ID, strpos($cart_Platnosci_ID, '-')+1);

          $curr_check = tep_db_query("select currency from " . TABLE_ORDERS . " where orders_id = '" . (int)$order_id . "'");
          $curr = tep_db_fetch_array($curr_check);

          if ( ($curr['currency'] != $order->info['currency']) || ($cartID != substr($cart_Platnosci_ID, 0, strlen($cartID))) ) {
            $check_query = tep_db_query('select orders_id from ' . TABLE_ORDERS_STATUS_HISTORY . ' where orders_id = "' . (int)$order_id . '" limit 1');

            if (tep_db_num_rows($check_query) < 1) {
              tep_db_query('delete from ' . TABLE_ORDERS . ' where orders_id = "' . (int)$order_id . '"');
              tep_db_query('delete from ' . TABLE_ORDERS_TOTAL . ' where orders_id = "' . (int)$order_id . '"');
              tep_db_query('delete from ' . TABLE_ORDERS_STATUS_HISTORY . ' where orders_id = "' . (int)$order_id . '"');
              tep_db_query('delete from ' . TABLE_ORDERS_PRODUCTS . ' where orders_id = "' . (int)$order_id . '"');
              tep_db_query('delete from ' . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . ' where orders_id = "' . (int)$order_id . '"');
              tep_db_query('delete from ' . TABLE_ORDERS_PRODUCTS_DOWNLOAD . ' where orders_id = "' . (int)$order_id . '"');
            }

            $insert_order = true;
          }
        } else {
          $insert_order = true;
        }

        if ($insert_order == true) {
          $order_totals = array();
          if (is_array($order_total_modules->modules)) {
            reset($order_total_modules->modules);
            while (list(, $value) = each($order_total_modules->modules)) {
              $class = substr($value, 0, strrpos($value, '.'));
              if ($GLOBALS[$class]->enabled) {
                for ($i=0, $n=sizeof($GLOBALS[$class]->output); $i<$n; $i++) {
                  if (tep_not_null($GLOBALS[$class]->output[$i]['title']) && tep_not_null($GLOBALS[$class]->output[$i]['text'])) {
                    $order_totals[] = array('code' => $GLOBALS[$class]->code,
                                            'title' => $GLOBALS[$class]->output[$i]['title'],
                                            'text' => $GLOBALS[$class]->output[$i]['text'],
                                            'value' => $GLOBALS[$class]->output[$i]['value'],
                                            'sort_order' => $GLOBALS[$class]->sort_order);
                  }
                }
              }
            }
          }

          $sql_data_array = array('customers_id' => $customer_id,
                                  'customers_name' => $order->customer['firstname'] . ' ' . $order->customer['lastname'],
                                  'customers_company' => $order->customer['company'],
                                  'customers_nip' => $order->customer['nip'],
                                  'customers_street_address' => $order->customer['street_address'],
                                  'customers_suburb' => $order->customer['suburb'],
                                  'customers_city' => $order->customer['city'],
                                  'customers_postcode' => $order->customer['postcode'],
                                  'customers_state' => $order->customer['state'],
                                  'customers_country' => $order->customer['country']['title'],
                                  'customers_telephone' => $order->customer['telephone'],
                                  'customers_email_address' => $order->customer['email_address'],
                                  'customers_address_format_id' => $order->customer['format_id'],
                                  'delivery_name' => $order->delivery['firstname'] . ' ' . $order->delivery['lastname'],
                                  'delivery_company' => $order->delivery['company'],
                                  'delivery_nip' => $order->delivery['nip'],
                                  'delivery_street_address' => $order->delivery['street_address'],
                                  'delivery_suburb' => $order->delivery['suburb'],
                                  'delivery_city' => $order->delivery['city'],
                                  'delivery_postcode' => $order->delivery['postcode'],
                                  'delivery_state' => $order->delivery['state'],
                                  'delivery_country' => $order->delivery['country']['title'],
                                  'delivery_address_format_id' => $order->delivery['format_id'],
                                  'billing_name' => $order->billing['firstname'] . ' ' . $order->billing['lastname'],
                                  'billing_company' => $order->billing['company'],
                                  'billing_nip' => $order->billing['nip'],
                                  'billing_street_address' => $order->billing['street_address'],
                                  'billing_suburb' => $order->billing['suburb'],
                                  'billing_city' => $order->billing['city'],
                                  'billing_postcode' => $order->billing['postcode'],
                                  'billing_state' => $order->billing['state'],
                                  'billing_country' => $order->billing['country']['title'],
                                  'billing_address_format_id' => $order->billing['format_id'],
                                  'payment_method' => $order->info['payment_method'],
                                  'cc_type' => $order->info['cc_type'],
                                  'cc_owner' => $order->info['cc_owner'],
                                  'cc_number' => $order->info['cc_number'],
                                  'cc_expires' => $order->info['cc_expires'],
                                  'date_purchased' => 'now()',
                                  'orders_status' => MODULE_PAYMENT_PLATNOSCI_PREPARE_ORDER_STATUS_ID,
                                  'currency' => $order->info['currency'],
                                  'currency_value' => $order->info['currency_value']);

          tep_db_perform(TABLE_ORDERS, $sql_data_array);

          $insert_id = tep_db_insert_id();
          
          for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
            $sql_data_array = array('orders_id' => $insert_id,
                                    'title' => $order_totals[$i]['title'],
                                    'text' => $order_totals[$i]['text'],
                                    'value' => $order_totals[$i]['value'],
                                    'class' => $order_totals[$i]['code'],
                                    'sort_order' => $order_totals[$i]['sort_order']);

            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
          }

          for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
            $sql_data_array = array('orders_id' => $insert_id,
                                    'products_id' => tep_get_prid($order->products[$i]['id']),
                                    'products_model' => $order->products[$i]['model'],
                                    'products_name' => $order->products[$i]['name'],
                                    'products_price' => $order->products[$i]['price'],
                                    'final_price' => $order->products[$i]['final_price'],
                                    'products_tax' => $order->products[$i]['tax'],
                                    'products_quantity' => $order->products[$i]['qty']);

            tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);

            $order_products_id = tep_db_insert_id();

            $attributes_exist = '0';
            if (isset($order->products[$i]['attributes'])) {
              $attributes_exist = '1';
              for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
                if (DOWNLOAD_ENABLED == 'true') {
                  $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename
                                       from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                       left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                       on pa.products_attributes_id=pad.products_attributes_id
                                       where pa.products_id = '" . $order->products[$i]['id'] . "'
                                       and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . $languages_id . "'
                                       and poval.language_id = '" . $languages_id . "'";
                  $attributes = tep_db_query($attributes_query);
                } else {
                  $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");
                }
                $attributes_values = tep_db_fetch_array($attributes);

                $sql_data_array = array('orders_id' => $insert_id,
                                        'orders_products_id' => $order_products_id,
                                        'products_options' => $attributes_values['products_options_name'],
                                        'products_options_values' => $attributes_values['products_options_values_name'],
                                        'options_values_price' => $attributes_values['options_values_price'],
                                        'price_prefix' => $attributes_values['price_prefix']);

                tep_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

                if ((DOWNLOAD_ENABLED == 'true') && isset($attributes_values['products_attributes_filename']) && tep_not_null($attributes_values['products_attributes_filename'])) {
                  $sql_data_array = array('orders_id' => $insert_id,
                                          'orders_products_id' => $order_products_id,
                                          'orders_products_filename' => $attributes_values['products_attributes_filename'],
                                          'download_maxdays' => $attributes_values['products_attributes_maxdays'],
                                          'download_count' => $attributes_values['products_attributes_maxcount']);

                  tep_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
                }
              }
            }
          }

          tep_session_register('cart_Platnosci_ID');
          $cart_Platnosci_ID = $cartID . '-' . $insert_id;
        }
      } else {
          $cart->cartID=$cart->generate_cart_id();
          tep_redirect(tep_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
      }

     
	    $selected_payment = '';
        $order_id = substr($cart_Platnosci_ID, strpos($cart_Platnosci_ID, '-')+1);

		$fields[] = array('title' => MODULE_PAYMENT_PLATNOSCI_TEXT_ORDER_ID,
                          'field' => $order_id);
		if (MODULE_PAYMENT_PLATNOSCI_PAYBACK == 'włączony')
		$fields[] = array('title' => MODULE_PAYMENT_PLATNOSCI_TEXT_PAYBACK_LOGIN,
	                      'field' => $HTTP_POST_VARS['payback_login']?$HTTP_POST_VARS['payback_login']:'nie podano');
		
         return array('id' => $this->code,
	                   'module' => $this->title,
	                   'fields' => $fields
         );
																			
      } else {
        return false;
      }
    }

    function process_button() {
      global $customer_id, $order, $languages_id, $currencies, $currency, $cart_Platnosci_ID, $shipping;

    if (MODULE_PAYMENT_PLATNOSCI_FINAL_CONFIRMATION=='yes') {
      
      $my_currency = 'PLN';
						switch($_SESSION['language'])	//--- http://userpage.chemie.fu-berlin.de/diverse/doc/ISO_3166.html
						{
						    case "english"	: $mylang = "EN"; break;
						    case "polish"	: $mylang = "PL"; break;
						    case "german"	: $mylang = "DE"; break;
						}

      $parameters = array();
								
      $parameters['language'] = $mylang;
      $parameters['session_id'] = $cart_Platnosci_ID . '-' . substr(md5(time()), 16);
      $parameters['order_id'] = substr($cart_Platnosci_ID, strpos($cart_Platnosci_ID, '-')+1);
      $parameters['pay_type'] = urlencode($HTTP_POST_VARS['pay_type']);
      $parameters['js'] = 0;
      $parameters['pos_id'] = MODULE_PAYMENT_PLATNOSCI_POS_ID;
      $parameters['pos_auth_key'] = MODULE_PAYMENT_PLATNOSCI_POS_AUTH_KEY;
      $parameters['amount'] = number_format(($order->info['total'] * $currencies->get_value($my_currency)), 2, ".", "")*100;
      $parameters['payback_login'] = urlencode($HTTP_POST_VARS['payback_login']);
      $parameters['desc'] = STORE_NAME . ' - Klient: ' . $order->billing['firstname'] . ' ' . $order->billing['lastname'];
      $parameters['desc2'] = 'Numer klienta: ' . $customer_id . '. ' . $products;
      $parameters['first_name'] = $order->billing['firstname'];
      $parameters['last_name'] = $order->billing['lastname'];
      $parameters['street'] = $order->billing['street_address'];
      $parameters['street_hn'] = $order->billing['suburb'];
      $parameters['city'] = $order->billing['city'];
      $parameters['post_code'] = $order->billing['postcode'];
      $parameters['country'] = $order->billing['country']['iso_code_2'];
      $parameters['phone'] = $order->customer['telephone'];
      $parameters['email'] = $order->customer['email_address'];
      $parameters['client_ip'] = $_SERVER["REMOTE_ADDR"];
             
      $process_button_string='';    
      while (list($key, $value) = each($parameters)) {
          $process_button_string .= tep_draw_hidden_field($key, $value);
      }
        
      } else {
      $process_button_string='';    
      $parameters = array();
	  $parameters['pay_type'] = urlencode($HTTP_POST_VARS['pay_type']);
   	  $parameters['payback_login'] = urlencode($HTTP_POST_VARS['payback_login']);
	    while (list($key, $value) = each($parameters)) {
          $process_button_string .= tep_draw_hidden_field($key, $value);
        }
      }
      
      return $process_button_string;
    }

    function before_process() {
      global $customer_id, $order, $sendto, $billto, $payment, $currencies, $cart, $cart_Platnosci_ID;
      global $$payment;

      include(DIR_WS_CLASSES . 'order_total.php');
      $order_total_modules = new order_total;

      $order_totals = $order_total_modules->process();

      $order_id = substr($cart_Platnosci_ID, strpos($cart_Platnosci_ID, '-')+1);

      $sql_data_array = array('orders_id' => $order_id,
                              'orders_status_id' => MODULE_PAYMENT_PLATNOSCI_PREPARE_ORDER_STATUS_ID,
                              'date_added' => 'now()',
                              'customer_notified' => (SEND_EMAILS == 'true') ? '1' : '0',
                              'comments' => $order->info['comments']);

      tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);


      //kgt - discount coupons
      if( tep_session_is_registered( 'coupon' ) && $order->info['coupon'] != '' ) {
         $sql_data_array = array( 'coupons_id' => $order->info['coupon'],
                           'orders_id' => $insert_id );
      tep_db_perform( TABLE_DISCOUNT_COUPONS_TO_ORDERS, $sql_data_array );
      }
      //end kgt - discount coupons	 

      // initialized for the email confirmation
      $products_ordered = '';
      $subtotal = 0;
      $total_tax = 0;

      for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
        if (STOCK_LIMITED == 'true') {
          if (DOWNLOAD_ENABLED == 'true') {
            $stock_query_raw = "SELECT products_quantity, pad.products_attributes_filename
                                FROM " . TABLE_PRODUCTS . " p
                                LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                ON p.products_id=pa.products_id
                                LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                ON pa.products_attributes_id=pad.products_attributes_id
                                WHERE p.products_id = '" . tep_get_prid($order->products[$i]['id']) . "'";
// Will work with only one option for downloadable products
// otherwise, we have to build the query dynamically with a loop
            $products_attributes = $order->products[$i]['attributes'];
            if (is_array($products_attributes)) {
              $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";
            }
            $stock_query = tep_db_query($stock_query_raw);
          } else {
            $stock_query = tep_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
          }
          if (tep_db_num_rows($stock_query) > 0) {
            $stock_values = tep_db_fetch_array($stock_query);
// do not decrement quantities if products_attributes_filename exists
            if ((DOWNLOAD_ENABLED != 'true') || (!$stock_values['products_attributes_filename'])) {
              $stock_left = $stock_values['products_quantity'] - $order->products[$i]['qty'];
            } else {
              $stock_left = $stock_values['products_quantity'];
            }
            tep_db_query("update " . TABLE_PRODUCTS . " set products_quantity = '" . $stock_left . "' where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
            if ( ($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false') ) {
              tep_db_query("update " . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
            }
          }
        }

// Update products_ordered (for bestsellers list)
        tep_db_query("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%d', $order->products[$i]['qty']) . " where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");

//------insert customer choosen option to order--------
        $attributes_exist = '0';
        $products_ordered_attributes = '';
        if (isset($order->products[$i]['attributes'])) {
          $attributes_exist = '1';
          for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
            if (DOWNLOAD_ENABLED == 'true') {
              $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename
                                   from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                   left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                                   on pa.products_attributes_id=pad.products_attributes_id
                                   where pa.products_id = '" . $order->products[$i]['id'] . "'
                                   and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
                                   and pa.options_id = popt.products_options_id
                                   and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
                                   and pa.options_values_id = poval.products_options_values_id
                                   and popt.language_id = '" . $languages_id . "'
                                   and poval.language_id = '" . $languages_id . "'";
              $attributes = tep_db_query($attributes_query);
            } else {
              $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");
            }
            $attributes_values = tep_db_fetch_array($attributes);

            $products_ordered_attributes .= "\n\t" . $attributes_values['products_options_name'] . ' ' . $attributes_values['products_options_values_name'];
          }
        }
//------insert customer choosen option eof ----
        $total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
        $total_tax += tep_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
        $total_cost += $total_products_price;
		$products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price_nodiscount($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
      }

// lets start with the email confirmation
      $email_order = STORE_NAME . "\n" .
                     EMAIL_SEPARATOR . "\n" .
                     EMAIL_TEXT_ORDER_NUMBER . ' ' . $order_id . "\n" .
                     EMAIL_TEXT_INVOICE_URL . ' ' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $order_id, 'SSL', false) . "\n" .
                     EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";
      if ($order->info['comments']) {
        $email_order .= tep_db_output($order->info['comments']) . "\n\n";
      }
      $email_order .= EMAIL_TEXT_PRODUCTS . "\n" .
                      EMAIL_SEPARATOR . "\n" .
                      $products_ordered .
                      EMAIL_SEPARATOR . "\n";

      for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
        $email_order .= strip_tags($order_totals[$i]['title']) . ' ' . strip_tags($order_totals[$i]['text']) . "\n";
      }

      if ($order->content_type != 'virtual') {
        $email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" .
                        EMAIL_SEPARATOR . "\n" .
                        tep_address_label($customer_id, $sendto, 0, '', "\n") . "\n";
      }

      $email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .
                      EMAIL_SEPARATOR . "\n" .
                      tep_address_label($customer_id, $billto, 0, '', "\n") . "\n\n";

      if (is_object($$payment)) {
        $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" .
                        EMAIL_SEPARATOR . "\n";
        $payment_class = $$payment;
        $email_order .= $payment_class->title . "\n\n";
        if ($payment_class->email_footer) {
          $email_order .= $payment_class->email_footer . "\n\n";
        }
      }

      tep_mail($order->customer['firstname'] . ' ' . $order->customer['lastname'], $order->customer['email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

// send emails to other people
      if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
        tep_mail('', SEND_EXTRA_ORDER_EMAILS_TO, EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
      }
      
// send email to shop's administrator
      if (MODULE_PAYMENT_PLATNOSCI_ORDER_NOTIFICATION == 'True') {
        tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
      }

// load the after_process function from the payment modules
      $this->after_process();

      $cart->reset(true);

// unregister session variables used during checkout
      tep_session_unregister('sendto');
      tep_session_unregister('billto');
      tep_session_unregister('shipping');
      tep_session_unregister('payment');
      tep_session_unregister('comments');

      tep_session_unregister('cart_Platnosci_ID');
      tep_session_unregister('Platnosci_pay_type');
      //kgt - discount coupons
      tep_session_unregister('coupon');
      //end kgt - discount coupons
      tep_redirect(tep_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));
    }

    function after_process() {
      return false;
    }

    function get_error() {
      global $HTTP_GET_VARS;

      if (isset($HTTP_GET_VARS['ErrMsg']) && tep_not_null($HTTP_GET_VARS['ErrMsg'])) {
        $error = stripslashes(urldecode($HTTP_GET_VARS['ErrMsg']));
      } elseif (isset($HTTP_GET_VARS['Err']) && tep_not_null($HTTP_GET_VARS['Err'])) {
        $error = stripslashes(urldecode($HTTP_GET_VARS['Err']));
      } elseif (isset($HTTP_GET_VARS['error']) && tep_not_null($HTTP_GET_VARS['error'])) {
        $error = stripslashes(urldecode($HTTP_GET_VARS['error']));
      } else {
        $error = MODULE_PAYMENT_PLATNOSCI_TEXT_ERROR_MESSAGE;
      }

						$errormsg = isset($this->error_message[$error])?$this->error_message[$error]:$error;
      
						return array('title' => MODULE_PAYMENT_PLATNOSCI_TITLE_ERROR_MESSAGE,
                   'error' => $errormsg);
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PLATNOSCI_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
					
	    foreach ($this->platnosci_status as $key=>$value) {
		    $orders_status_name = 'Płatności [' . $value['desc'] . ']';
            $check_query = tep_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " where orders_status_name = '" . $orders_status_name . "' limit 1");
	          if (tep_db_num_rows($check_query) < 1) {
	             $status_query = tep_db_query("select max(orders_status_id) as status_id from " . TABLE_ORDERS_STATUS);
	             $status = tep_db_fetch_array($status_query);
	             $status_id = $status['status_id']+1;
	             if ($key == 99) $status_processing = $status_id;
	        		$languages = tep_get_languages();
	                foreach ($languages as $lang) {
	                        tep_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) values ('" . $status_id . "', '" . $lang['id'] . "', '" . $orders_status_name . "')");
	                }
	          } else {
	            $check = tep_db_fetch_array($check_query);
	            $status_id = $check['orders_status_id'];
	            if ($key == 99) $status_processing = $status_id;
	          }
	         tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, date_added) values ('Status - " . $orders_status_name . "', '" . $value['conf_key'] . "', '" . $status_id . "', 'Status obsługi płatności zamówienia w systemie Platnosci.pl', '6', now())");
        };

        $check_query = tep_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " where orders_status_name = '" . $this->orders_status_name . "' limit 1");

        if (tep_db_num_rows($check_query) < 1) {
            $status_query = tep_db_query("select max(orders_status_id) as status_id from " . TABLE_ORDERS_STATUS);
            $status = tep_db_fetch_array($status_query);
            $status_id = $status['status_id']+1;
            $languages = tep_get_languages();
            foreach ($languages as $lang) {
                tep_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) values ('" . $status_id . "', '" . $lang['id'] . "', '" . $this->orders_status_name . "')");
            }
        } else {
            $check = tep_db_fetch_array($check_query);
            $status_id = $check['orders_status_id'];
        }

      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejność wyświetlania.', 'MODULE_PAYMENT_PLATNOSCI_SORT_ORDER', '0', 'Na której pozycji będzie wyświetlany moduł Płatności.pl.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Aktywny moduł Platnosci.pl', 'MODULE_PAYMENT_PLATNOSCI_STATUS', 'True', 'Czy chcesz uruchomić płatności poprzez Platnosci.pl?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Identyfikator Punktu Płatności w serwisie Platnosci.pl (pos_id)', 'MODULE_PAYMENT_PLATNOSCI_POS_ID', '', 'Identyfikator twojego Punktu Płatności w serwisie Platnosci.pl (dostępny w panelu administracyjnym Platnosci.pl)', '6', '2', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Klucz autoryzacji płatności (pos_auth_key)', 'MODULE_PAYMENT_PLATNOSCI_POS_AUTH_KEY', '', 'Klucz autoryzacji płatności w serwisie Platnosci.pl (dostępny w panelu administracyjnym Platnosci.pl)', '6', '3', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Klucz (MD5)', 'MODULE_PAYMENT_PLATNOSCI_KEY1', '', 'Klucz podpisu Punktu Płatności. Dostępny w Panelu Admistracyjnym Płatności (\"Konfiguracja Punktu Płatności\")', '6', '4', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Drugi klucz (MD5)', 'MODULE_PAYMENT_PLATNOSCI_KEY2', '', 'Drugi klucz podpisu Punktu Płatności. Dostępny w Panelu Admistracyjnym Płatności (\"Konfiguracja Punktu Płatności\")', '6', '5', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Aktywny program lojalnościowy PayBACK', 'MODULE_PAYMENT_PLATNOSCI_PAYBACK', 'włączony', 'Czy chcesz nagradzać punktami PayBACK (<a href=\"http://www.payback.pl\" target=\"_blank\">www.payback.pl</a>) transakcje dokonywane za pośrednictwem Platnosci.pl?', '6', '6', 'tep_cfg_select_option(array(\'włączony\', \'wyłączony\'), ', now())");
	  	tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Wstępny status zamówień', 'MODULE_PAYMENT_PLATNOSCI_PREPARE_ORDER_STATUS_ID', '" . $status_id . "', 'Wstępny status zamówień przygotowywanych przez tą metodę płatności', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Status zamówień potwierdzonych', 'MODULE_PAYMENT_PLATNOSCI_ORDER_STATUS_ID', '" . $status_processing . "', 'Status zamówień opłaconych tą metodą i potwierdzonych przez Płatności', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('E-Mail blędnych transakcji', 'MODULE_PAYMENT_PLATNOSCI_DEBUG_EMAIL', '', 'Adres email, na który będą wysyłane parametry błędnych transakcji (możesz pozostawić to pole puste)', '6', '4', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Powiadamianie o zamówieniach', 'MODULE_PAYMENT_PLATNOSCI_ORDER_NOTIFICATION', 'True', 'Powiadamianie właściciela sklepu o nowych zamówieniach (na adres email Administaratora, podany w konfiguracji sklepu)', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
//--- Payment's types
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Lista kanałów płatności jako lista wybieralna lub lista radio', 'MODULE_PAYMENT_PLATNOSCI_LIST_STATUS', 'True', 'Czy chcesz wyświetlać liste kanałów płatności jako liste wybieralną?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
    }

    function remove() {
        tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
        foreach ($this->platnosci_status as $key=>$value) 
             tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key = '" . $value['conf_key'] . "'");
             
	    foreach ($this->platnosci_status as $key=>$value) {
	        $orders_status_name = 'Płatności [' . $value['desc'] . ']';
	        tep_db_query("delete from " . TABLE_ORDERS_STATUS . " where orders_status_name = '" . $orders_status_name . "'");
        };
	        tep_db_query("delete from " . TABLE_ORDERS_STATUS . " where orders_status_name = '" . $this->orders_status_name . "'");
        
    }

    function keys() {
     $keys =  array('MODULE_PAYMENT_PLATNOSCI_STATUS', 'MODULE_PAYMENT_PLATNOSCI_POS_ID', 'MODULE_PAYMENT_PLATNOSCI_POS_AUTH_KEY', 'MODULE_PAYMENT_PLATNOSCI_PREPARE_ORDER_STATUS_ID', 'MODULE_PAYMENT_PLATNOSCI_ORDER_STATUS_ID', 'MODULE_PAYMENT_PLATNOSCI_PAYBACK', 'MODULE_PAYMENT_PLATNOSCI_KEY1', 'MODULE_PAYMENT_PLATNOSCI_KEY2', 'MODULE_PAYMENT_PLATNOSCI_DEBUG_EMAIL', 'MODULE_PAYMENT_PLATNOSCI_ORDER_NOTIFICATION','MODULE_PAYMENT_PLATNOSCI_SORT_ORDER','MODULE_PAYMENT_PLATNOSCI_LIST_STATUS');
     return $keys;
    }
  }
?>
