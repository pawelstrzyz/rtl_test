<?php
/*
  $Id: raport.php 1 2007-12-20 23:52:06Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  Autor: Platnosci.pl <oscommerce@platnosci.pl>
  http://www.platnosci.pl
*/
		function get_status($parts){
			if ($parts[1] != MODULE_PAYMENT_PLATNOSCI_POS_ID) return array('code' => false,'message' => 'błędny numer POS');	//--- bledny numer POS
			$sig = md5($parts[1].$parts[2].$parts[3].$parts[5].$parts[4].$parts[6].$parts[7].MODULE_PAYMENT_PLATNOSCI_KEY2);
			if ($parts[8] != $sig) return array('code' => false,'message' => 'błędny podpis');	//--- bledny podpis
			switch ($parts[5]) {
				case 1: return array('code' => $parts[5], 'message' => 'nowa'); break;
				case 2: return array('code' => $parts[5], 'message' => 'anulowana'); break;
				case 3: return array('code' => $parts[5], 'message' => 'odrzucona'); break;
				case 4: return array('code' => $parts[5], 'message' => 'rozpoczęta'); break;
				case 5: return array('code' => $parts[5], 'message' => 'oczekuje na odbiór'); break;
				case 6: return array('code' => $parts[5], 'message' => 'autoryzacja odmowna'); break;
				case 7: return array('code' => $parts[5], 'message' => 'płatno¶ć˝ odrzucona'); break;
				case 99: return array('code' => $parts[5], 'message' => 'płatno¶ć˝ odebrana - zakończona'); break;
				case 888: return array('code' => $parts[5], 'message' => 'błędny status'); break;
				default: return array('code' => false, 'message' => 'brak statusu'); break;
			}
		}			  

		function platnosci_session_register($variable) {
			global $session_started;
		
		  if ($session_started == true) {
		  	return session_register($variable);
		  } else {
		  	return false;
		  }
		}

		platnosci_session_register('language');
    platnosci_session_register('languages_id');
    $language = "polish";
    $languages_id = 0;
      	
  	chdir('../../../../');
  	require('includes/application_top.php');
  	$server = 'www.platnosci.pl';
  	$server_script = '/paygw/ISO/Payment/get';

		//******* MAIN  *********

  	if(!isset($_POST['pos_id']) || !isset($_POST['session_id']) || !isset($_POST['ts']) || !isset($_POST['sig'])) die('ERROR: EMPTY PARAMETERS'); //-- brak wszystkich parametrow
  	if ($_POST['pos_id'] != MODULE_PAYMENT_PLATNOSCI_POS_ID) die('ERROR: WRONG POS ID'); 	//--- bledny numer POS
  	$sig = md5( $_POST['pos_id'] . $_POST['session_id'] . $_POST['ts'] . MODULE_PAYMENT_PLATNOSCI_KEY2);
  	if ($_POST['sig'] != $sig) die('ERROR: WRONG SIGNATURE'); 	//--- bledny podpis
  
    $ts = time();
  	$sig = md5( MODULE_PAYMENT_PLATNOSCI_POS_ID . $_POST['session_id'] . $ts . MODULE_PAYMENT_PLATNOSCI_KEY1);
  
  	$parameters = "pos_id=" . MODULE_PAYMENT_PLATNOSCI_POS_ID . "&session_id=" . $_POST['session_id'] . "&ts=" . $ts . "&sig=" . $sig;

  	$fsocket = false;
  	$curl = false;
  	$result = false;

  	if (function_exists('curl_exec')) {
    	$curl = true;
  	} elseif ( (PHP_VERSION >= 4.3) && ($fp = @fsockopen('ssl://' . $server, 443, $errno, $errstr, 30)) ) {
    	$fsocket = true;
  	} elseif ($fp = @fsockopen($server, 80, $errno, $errstr, 30)) {
    	$fsocket = true;
  	}

  	if ($curl == true) {
  		$ch = curl_init();  		
			curl_setopt($ch, CURLOPT_URL, 'https://' . $server . $server_script);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	$platnosci_response = curl_exec($ch);
    	curl_close($ch);
  	} elseif ($fsocket == true) {
    	$header = 'POST ' . $server_script . ' HTTP/1.0' . "\r\n" .
              'Host: ' . $server . "\r\n" .
              'Content-Type: application/x-www-form-urlencoded' . "\r\n" .
              'Content-Length: ' . strlen($parameters) . "\r\n" .
              'Connection: close' . "\r\n\r\n";

    		@fputs($fp, $header . $parameters);

    		$platnosci_response = '';
    		while (!@feof($fp)) {
      		$res = @fgets($fp, 1024);
      		$platnosci_response .= $res;
    		}
    		@fclose($fp);
  		}

      if (eregi("<trans>.*<pos_id>([0-9]*)</pos_id>.*<session_id>([a-z0-9-]*)</session_id>.*<order_id>([0-9]*)</order_id>.*<amount>([0-9]*)</amount>.*<status>([0-9]*)</status>.*<desc>(.*)</desc>.*<ts>([0-9]*)</ts>.*<sig>([a-z0-9]*)</sig>.*</trans>", $platnosci_response, $parts))	$result = get_status($parts);
  
  		if ($result['code'] == 99 || ($result['code'] >0 && $result['code'] <=7 )) {	//--- rozpoznany status transakcji
    		if (isset($parts[3]) && is_numeric($parts[3]) && ($parts[3] > 0)) {
      		$order_query = tep_db_query("select currency, currency_value from " . TABLE_ORDERS . " where orders_id = '" . $parts[3] . "'");
      		if (tep_db_num_rows($order_query) > 0) {
        		$order = tep_db_fetch_array($order_query);
            $total_query = tep_db_query("select value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $parts[3] . "' and class = 'ot_total' limit 1");
        		$total = tep_db_fetch_array($total_query);
            $comment_status = ' (KWOTA: ' . $parts[4]/100 . ' PLN)';
        		$const_name = 'MODULE_PAYMENT_PLATNOSCI_STATUS_' . $result['code'];
        		$order_status_id = defined($const_name)?constant($const_name):DEFAULT_ORDERS_STATUS_ID;

        		if (MODULE_PAYMENT_PLATNOSCI_ORDER_STATUS_ID > 0 && $result['code'] == 99) {
          		$order_status_id = MODULE_PAYMENT_PLATNOSCI_ORDER_STATUS_ID;
        		}
            tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . $order_status_id . "', last_modified = now() where orders_id = '" . $parts[3] . "'");

        		$sql_data_array = array('orders_id' => $parts[3],
                                'orders_status_id' => $order_status_id,
                                'date_added' => 'now()',
                                'customer_notified' => '0',
                                'comments' => $comment_status);

        		tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
      		}
    		}
      } else {
    		if (tep_not_null(MODULE_PAYMENT_PLATNOSCI_DEBUG_EMAIL)) {
      		$email_body = '$_GET:' . "\n\n";
      		foreach ($_GET as $key => $value) {
        		$email_body .= $key . '=' . $value . "\n";
      		}
      		$email_body .= "\n" . '$_POST:' . "\n\n";
      		foreach ($_POST as $key => $value) {
        		$email_body .= $key . '=' . $value . "\n";
      		}
      		$email_body .= "\n" . print_r($platnosci_response,true) . "\n\n";
      		tep_mail('', MODULE_PAYMENT_PLATNOSCI_DEBUG_EMAIL, 'Platnosci Invalid Process', $email_body, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
    		}
				echo "res: " . print_r($result,true) ."\n";
    		echo "ERROR in Response\n";
  		}
      echo "OK";
?>
