<?php
/*
  $Id: przelewy24.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  Autor: Przelewy24.pl <serwis@przelewy24.pl>
  http://www.przelewy24.pl

  //michal.bajer@horyzont.net
  //2006-01-02,03

  mod eSklep-Os http://www.esklep-os.com
*/

  define('DIR_WS_ADMIN', 'admin/');
  define('DIR_WS_INCLUDES', 'includes/');
  function p24_weryfikujNOSSL($p24_id_sprzedawcy,$p24_session_id,$p24_order_id,$p24_kwota="") {
    $header  = "POST /transakcjanossl.php HTTP/1.1\r\n";
    $header .= "Host: secure.przelewy24.pl\r\n"; 
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
  
    $fp = fsockopen ("secure.przelewy24.pl", 80, $errno, $errstr, 30);
    $P[] = urlencode("p24_id_sprzedawcy")."=".urlencode($p24_id_sprzedawcy); 
    $P[] = urlencode("p24_session_id")."=".urlencode($p24_session_id); 
    $P[] = urlencode("p24_order_id")."=".urlencode($p24_order_id); 
    if($p24_kwota != "") $P[] = urlencode("p24_kwota")."=".urlencode($p24_kwota); 
    $post = join("&",$P);
  
    $req .= "Content-Length: ".strlen( $post )."\r\n\r\n";
    $req .= $post;
  
    if (!$fp) {
      die ("CONNECTION ERROR");
    } else {
      fputs ($fp, $header . $req);
      $res = false;
      while (!feof($fp)) {
        $line = ereg_replace("[\n\r]","",fgets ($fp, 1024));
        if($line != "RESULT" and !$res) continue;
        if($res)$RET[] = $line;
        else $res = true; 
      }
    }
    fclose ($fp);
    return $RET;
  }
  function p24_weryfikujSSL($p24_id_sprzedawcy,$p24_session_id,$p24_order_id,$p24_kwota="")
  {
      $url = "https://secure.przelewy24.pl/transakcja.php";
      $P[] = "p24_id_sprzedawcy=".$p24_id_sprzedawcy;
      $P[] = "p24_session_id=".$p24_session_id;
      $P[] = "p24_order_id=".$p24_order_id;
      if($p24_kwota != "") $P[] = "p24_kwota=".$p24_kwota;

      $user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_POST,1);
      if(count($P)) curl_setopt($ch, CURLOPT_POSTFIELDS,join("&",$P));
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
      curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
      if(count($H)) curl_setopt ($ch, CURLOPT_HTTPHEADER, $H);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
      $result=curl_exec ($ch);
      curl_close ($ch);
      $T = explode(chr(13).chr(10),$result);  

      foreach($T as $line){
        $line = ereg_replace("[\n\r]","",$line);
        if($line != "RESULT" and !$res) continue;
        if($res)$RET[] = $line;
        else $res = true; 
      }
      return $RET;
  }

  if(isset($_POST["p24_session_id"]) and isset($_POST["p24_order_id"])) {

      //load config
      require_once(DIR_WS_INCLUDES.'configure.php');
      require_once(DIR_WS_INCLUDES.'database_tables.php');
      require_once(DIR_WS_FUNCTIONS.'database.php');
       // make a connection to the database... now
       if (!isset($db_link)) tep_db_connect() or die('Unable to connect to database server!');
      require_once(DIR_WS_INCLUDES.'filenames.php');
      require_once(DIR_WS_FUNCTIONS.'general.php');
      require_once(DIR_WS_FUNCTIONS.'html_output.php');
      // include the mail classes
      require(DIR_WS_CLASSES . 'mime.php');
      require(DIR_WS_CLASSES . 'email.php');
      // check if sessions are supported, otherwise use the php3 compatible session class
      if (!function_exists('session_start')) {
        define('PHP_SESSION_NAME', 'osCsid');
        define('PHP_SESSION_PATH', $cookie_path);
        define('PHP_SESSION_DOMAIN', $cookie_domain);
        define('PHP_SESSION_SAVE_PATH', SESSION_WRITE_DIRECTORY);

        include(DIR_WS_CLASSES . 'sessions.php');
      }
      // define how the session functions will be used
      require(DIR_WS_FUNCTIONS . 'sessions.php');

      // set the application parameters
      $configuration_query = tep_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
      while ($configuration = tep_db_fetch_array($configuration_query)) {
        define($configuration['cfgKey'], $configuration['cfgValue']);
      }


      $isSSL=function_exists('curl_init')&&function_exists('curl_setopt')&&function_exists('curl_exec')&&function_exists('curl_close');

      //verify
      $WYNIK = $isSSL?p24_weryfikujSSL(MODULE_PAYMENT_PRZELEWY24_ID,$_POST["p24_session_id"],$_POST["p24_order_id"]):
                     p24_weryfikujNOSSL(MODULE_PAYMENT_PRZELEWY24_ID,$_POST["p24_session_id"],$_POST["p24_order_id"]);


      // read orders_id,languages_code
      $tmp = tep_db_query("select orders_id,p24_languages_code,customers_id from " . TABLE_ORDERS . " where p24_session_id = '" . $_POST["p24_session_id"] . "'");
      $T = tep_db_fetch_array($tmp);
      $orders_id = $T["orders_id"];
      $languages_code = $T["p24_languages_code"];
      $customers_id = $T["customers_id"];

      if (strlen($orders_id)>0){

                    //load language texts
                    $tmp = tep_db_query("select directory from " . TABLE_LANGUAGES . " where code = '" . $languages_code . "'");
                    $T = tep_db_fetch_array($tmp);
                    $language = $T["directory"];
                    if (strlen($language)==0) $language='polish';


                     // include the language translations
                     require(DIR_WS_LANGUAGES . $language . '.php');
                     require(DIR_WS_LANGUAGES . $language . '/' . 'przelewy24.php');

                     //load order data
                     require(DIR_WS_ADMIN.DIR_WS_CLASSES.'order.php');
                     $order=new order($orders_id);


                             // send email notification and store payment info
                             $temat = MakeUTF(EMAIL_TEXT_SUBJECT);
                             $email = EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $orders_id . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders_id, 'SSL') . "\n\n" .''.($WYNIK[0] == "TRUE"?TEXT_SUCCESS:TEXT_ERROR);
                             tep_mail($order->customer['name'], $order->customer['email_address'], $temat, $email, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
                             tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $temat, $email, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
                             tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values
                            ('" . (int)$orders_id . "', '" . $order->info['orders_status'] . "', now(), '1', '".($WYNIK[0] == "TRUE"?TEXT_SUCCESS:TEXT_ERROR)."')");

                       tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customers_id . "'");
                       tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)$customers_id . "'");
    }

    if($WYNIK[0] == "TRUE") {
     print "<html><head><meta http-equiv=\"refresh\" content=\"0;URL=przelewy24_success.php?osCsid=".$_POST["p24_session_id"]."\"></head></html>";
    } else {
      print "<html><head><meta http-equiv=\"refresh\" content=\"0;URL=przelewy24_error.php?osCsid=".$_POST["p24_session_id"]."\"></head></html>";
    }


//foreach($_POST as $key=>$value) echo $key.'='.$value.'<br>';

  }
?>