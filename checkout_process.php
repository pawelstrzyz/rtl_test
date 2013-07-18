<?php
/*
  $Id: checkout_process.php 159 2008-03-04 13:10:09Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

  include('includes/application_top.php');

  //deklaracja zmiennej zawieraj�cej dane o transakcji wysy�ane ze sklepu do mbanku
$mtransfer_mail= "https://www.mbank.com.pl/mtransfer.asp?osCsid=".$osCsid."&ServiceID=".$ServiceID."&Amount=".$Amount."&TrDate=".$TrDate."&Description=".$Description."%20nr%20zam�wienia:%20".$insert_id."\nZap�a� mtransferem, o ile jeszcze tego nie zrobi�e�</a>";

// if the customer is not logged on, redirect them to the login page
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_PAYMENT));
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }
  
// if there is nothing in the customers cart, redirect them to the shopping cart page
 	if ($cart->count_contents() < 1) {
 		tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
	}

// if no shipping method has been selected, redirect the customer to the shipping method selection page
 	if (!tep_session_is_registered('shipping') || !tep_session_is_registered('sendto')) {
 		tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
 	}
 		
  if ( (tep_not_null(MODULE_PAYMENT_INSTALLED)) && (!tep_session_is_registered('payment')) ) {
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
  }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && tep_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    }
  }

  include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_PROCESS);

// load selected payment module
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment($payment);

// load the selected shipping module
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping($shipping);

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

// Stock Check
 	$any_out_of_stock = false;
 	if (STOCK_CHECK == 'true') {
 		for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
 			if (tep_check_stock($order->products[$i]['id'], $order->products[$i]['qty'])) {
 				$any_out_of_stock = true;
 			}
 		}
 		// Out of Stock
 		if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock == true) ) {
 			tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
 		}
 	}
 		
 	$payment_modules->update_status();
 		
 	if ( ( is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($$payment) ) || (is_object($$payment) && ($$payment->enabled == false)) ) {
 		tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
 	}

  require(DIR_WS_CLASSES . 'order_total.php');
  $order_total_modules = new order_total;

  $order_totals = $order_total_modules->process();

// load the before_process function from the payment modules
  $payment_modules->before_process();

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
                          'delivery_name' => trim($order->delivery['firstname'] . ' ' . $order->delivery['lastname']), 
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
                          'payment_info' => $GLOBALS['payment_info'],
                          'cc_type' => $order->info['cc_type'], 
                          'cc_owner' => $order->info['cc_owner'], 
                          'cc_number' => $order->info['cc_number'], 
                          'cc_expires' => $order->info['cc_expires'], 
                          'date_purchased' => 'now()', 
                          'orders_status' => $order->info['order_status'], 
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

  $customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';
  if (isset($HTTP_POST_VARS['dok_zakup'])) {
     $dokument = $HTTP_POST_VARS['dok_zakup']; }
	 else {
	 $dokument = '';
  }
  $sql_data_array = array('orders_id' => $insert_id, 
                          'orders_status_id' => $order->info['order_status'], 
                          'date_added' => 'now()', 
                          'customer_notified' => $customer_notification,
                          'comments' => $dokument . $order->info['comments']);
  tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

  //kgt - discount coupons
  if( tep_session_is_registered( 'coupon' ) && is_object( $order->coupon ) ) {
	  $sql_data_array = array( 'coupons_id' => $order->coupon->coupon['coupons_id'],
                             'orders_id' => $insert_id );
	  tep_db_perform( TABLE_DISCOUNT_COUPONS_TO_ORDERS, $sql_data_array );
  }
  //end kgt - discount coupons

// initialized for the email confirmation
  $products_ordered = '';
  $subtotal = 0;
  $total_tax = 0;

  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
   // Stock Update - Joao Correia
   //++++ QT Pro: Begin Changed code
   $products_stock_attributes=null;
   if (STOCK_LIMITED == 'true') {
     $products_attributes = $order->products[$i]['attributes'];
     //      if (DOWNLOAD_ENABLED == 'true') {
     //++++ QT Pro: End Changed Code
     $stock_query_raw = "SELECT products_quantity, pad.products_attributes_filename
                        FROM " . TABLE_PRODUCTS . " p
                        LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                        ON p.products_id=pa.products_id
                        LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                        ON pa.products_attributes_id=pad.products_attributes_id
                        WHERE p.products_id = '" . tep_get_prid($order->products[$i]['id']) . "'";
     // Will work with only one option for downloadable products
     // otherwise, we have to build the query dynamically with a loop
     //++++ QT Pro: Begin Changed code
     //      $products_attributes = $order->products[$i]['attributes'];
     //++++ QT Pro: End Changed Code
     if (is_array($products_attributes)) {
       $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";
     }
     $stock_query = tep_db_query($stock_query_raw);
   } else {
     $stock_query = tep_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
   }

   if (tep_db_num_rows($stock_query) > 0) {
     $stock_values = tep_db_fetch_array($stock_query);
     //++++ QT Pro: Begin Changed code
     $actual_stock_bought = $order->products[$i]['qty'];
     $download_selected = false;
     if ((DOWNLOAD_ENABLED == 'true') && isset($stock_values['products_attributes_filename']) && tep_not_null($stock_values['products_attributes_filename'])) {
       $download_selected = true;
       $products_stock_attributes='$$DOWNLOAD$$';
     }
     //      If not downloadable and attributes present, adjust attribute stock
     if (!$download_selected && is_array($products_attributes)) {
       $all_nonstocked = true;
       $products_stock_attributes_array = array();
       foreach ($products_attributes as $attribute) {

         //**si** 14-11-05 fix missing att list
         //            if ($attribute['track_stock'] == 1) {
         //              $products_stock_attributes_array[] = $attribute['option_id'] . "-" . $attribute['value_id'];
         $products_stock_attributes_array[] = $attribute['option_id'] . "-" . $attribute['value_id'];
         if ($attribute['track_stock'] == 1) {
           //**si** 14-11-05 end
           $all_nonstocked = false;
         }
       }
       if ($all_nonstocked) {
         $actual_stock_bought = $order->products[$i]['qty'];
         //**si** 14-11-05 fix missing att list
         asort($products_stock_attributes_array, SORT_NUMERIC);
         $products_stock_attributes = implode(",", $products_stock_attributes_array);
         //**si** 14-11-05 end
       }  else {

				 asort($products_stock_attributes_array, SORT_NUMERIC);
         $products_stock_attributes = implode(",", $products_stock_attributes_array);

				$attributes_stock_query = tep_db_query("select products_stock_quantity from " . TABLE_PRODUCTS_STOCK . " where products_stock_attributes = '$products_stock_attributes' AND products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
         if (tep_db_num_rows($attributes_stock_query) > 0) {
           $attributes_stock_values = tep_db_fetch_array($attributes_stock_query);
           $attributes_stock_left = $attributes_stock_values['products_stock_quantity'] - $order->products[$i]['qty'];
           tep_db_query("update " . TABLE_PRODUCTS_STOCK . " set products_stock_quantity = '" . $attributes_stock_left . "' where products_stock_attributes = '$products_stock_attributes' AND products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
           $actual_stock_bought = ($attributes_stock_left < 1) ? $attributes_stock_values['products_stock_quantity'] : $order->products[$i]['qty'];
         } else {
           $attributes_stock_left = 0 - $order->products[$i]['qty'];
           tep_db_query("insert into " . TABLE_PRODUCTS_STOCK . " (products_id, products_stock_attributes, products_stock_quantity) values ('" . tep_get_prid($order->products[$i]['id']) . "', '" . $products_stock_attributes . "', '" . $attributes_stock_left . "')");
           $actual_stock_bought = 0;
         }
       }
     }
     if (!$download_selected) {
       $stock_left = $stock_values['products_quantity'] - $actual_stock_bought;
       tep_db_query("UPDATE " . TABLE_PRODUCTS . "
                     SET products_quantity = products_quantity - '" . $actual_stock_bought . "'
                     WHERE products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
       //++++ QT Pro: End Changed Code
       if ( ($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false') ) {
          tep_db_query("update " . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
       }
     }
     //++++ QT Pro: Begin Changed code

     //**si** 14-11-05 fix missing att list
   } else {
	   if ( is_array($order->products[$i]['attributes']) ) {
	     $products_stock_attributes_array = array();
	     foreach ($order->products[$i]['attributes'] as $attribute) {
	      $products_stock_attributes_array[] = $attribute['option_id'] . "-" . $attribute['value_id'];
		   }
		   asort($products_stock_attributes_array, SORT_NUMERIC);
		   $products_stock_attributes = implode(",", $products_stock_attributes_array);
	   }
   }
   //**si** 14-11-05 end

   //++++ QT Pro: End Changed Code
   // Update products_ordered (for bestsellers list)
   tep_db_query("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%d', $order->products[$i]['qty']) . " where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
   //++++ QT Pro: Begin Changed code
    if (!isset($products_stock_attributes)) $products_stock_attributes=null;

    $sql_data_array = array('orders_id' => $insert_id, 
                            'products_id' => tep_get_prid($order->products[$i]['id']), 
                            'products_model' => $order->products[$i]['model'], 
                            'products_name' => $order->products[$i]['name'], 
                            'products_price' => $order->products[$i]['price'], 
                            'final_price' => $order->products[$i]['final_price'], 
                            'products_tax' => $order->products[$i]['tax'], 
                            'products_quantity' => $order->products[$i]['qty'],
                            'products_stock_attributes' => $products_stock_attributes);
//++++ QT Pro: End Changed Code
    tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
    $order_products_id = tep_db_insert_id();

//------insert customer choosen option to order--------
    $attributes_exist = '0';
    $products_ordered_attributes = '';
    // START: Add products extra fields to order email
    $products_ordered_extra_fields = '';
    // END: Add products extra fields to order email

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
        $products_ordered_attributes .= "\n\t" . $attributes_values['products_options_name'] . ' ' . $attributes_values['products_options_values_name'];
      }
	}
// START: Add products extra fields to order email
$extra_fields_query = tep_db_query("
              SELECT pef.products_extra_fields_name as name, ptf.products_extra_fields_value as value
              FROM ". TABLE_PRODUCTS_EXTRA_FIELDS ." pef
              LEFT JOIN  ". TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS ." ptf
              ON ptf.products_extra_fields_id = pef.products_extra_fields_id
              WHERE ptf.products_id = " . tep_get_prid($order->products[$i]['id']) . " AND ptf.products_extra_fields_value<>'' and (pef.languages_id='0' or pef.languages_id='".$languages_id."')
              ORDER BY products_extra_fields_order");

while ($extra_fields = tep_db_fetch_array($extra_fields_query)) {
   $products_ordered_extra_fields .= "\n\t" . $extra_fields['name'] . ': ' . $extra_fields['value'];
}
// END: Add products extra fields to order email

    //------insert customer choosen option eof ----

    // Manufacturer Name
	  //Use the products ID# to find the proper Manufacturer of this specific product
		$v_query = tep_db_query("SELECT manufacturers_id FROM ".TABLE_PRODUCTS." WHERE products_id = '".$order->products[$i]['id']."'");
		$v = tep_db_fetch_array($v_query);
	  //Select the proper Manufacturers Name via the Manufacturers ID# then display that name for a human readable output
		$mfg_query = tep_db_query("SELECT manufacturers_name FROM ".TABLE_MANUFACTURERS." WHERE manufacturers_id = '".$v['manufacturers_id']."'");
		$mfg = tep_db_fetch_array($mfg_query);
    // End Manufacturer Listing

    $total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
    $total_tax += tep_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
    $total_cost += $total_products_price;

    // START: Add products extra fields to order email
    //TotalB2B start
    $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price_nodiscount($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . $products_ordered_extra_fields . "\n";
    //TotalB2B end
    // END: Add products extra fields to order email
    $products_ordered .= "\n" . BOX_HEADING_MANUFACTURER_INFO . ' : ' . $mfg['manufacturers_name'] . "\n";
  }

// lets start with the email confirmation
  $email_order = STORE_NAME . "\n"; 
	$email_order .= EMAIL_SEPARATOR . "\n"; 
// Ingo PWA
//  if ($customer_id == 0) {
    $email_order .= EMAIL_WARNING . "\n\n";
//  }
	$email_order .= EMAIL_SEPARATOR . "\n" . 
                 EMAIL_TEXT_ORDER_NUMBER . ' ' . $insert_id . "\n" .
                 (($customer_id == 0)? '' : EMAIL_TEXT_INVOICE_URL . ' ' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $insert_id, 'SSL', false) . "\n") .
                 EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";
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
   //tu sprawdzamy, czy klient wybra� mtransfer, i dodajemy link do p�atno��i w mailu z info o zakupie.
       if ($TrDate != "") {
         $email_order .= $mtransfer_mail . "\n" . EMAIL_SEPARATOR . "\n";
       } else {
       }

	$payment_class = $$payment;
    $email_order .= $order->info['payment_method'] . "\n\n";
    if ($payment_class->email_footer) { 
      $email_order .= $payment_class->email_footer . "\n\n";
    }
  }

  $temat = MakeUTF(EMAIL_TEXT_SUBJECT) . ' - ' . $insert_id;
  tep_mail($order->customer['firstname'] . ' ' . $order->customer['lastname'], $order->customer['email_address'], $temat, html_entity_decode($email_order), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

//extra info o kliencie
  $email_order .= "\n\n" . COMMENTS_EMAIL_INFO . "\n" . EMAIL_SEPARATOR . "\n" . NAME_EMAIL_INFO . $order->customer['firstname'] . " " . $order->customer['lastname'];
  if ($order->customer['company'] != '') {$email_order .= "\n" . FIRM_EMAIL_INFO . $order->customer['company'];};
  if ($order->billing['nip'] != '') {$email_order .= "\n" . NIP_ORDER_EMAIL_INFO . $order->billing['nip'];};
  if ($order->customer['nip'] != '') {$email_order .= "\n" . NIP_MAIN_EMAIL_INFO . $order->customer['nip'] . "\n";};

  $email_order .= "\n" . EMAIL_EMAIL_INFO . $order->customer['email_address'] . "\n" . PHONE_EMAIL_INFO . $order->customer['telephone']; 
  if ($order->customer['fax'] != '') {$email_order .= "\n" . FAX_GSM_EMAIL_INFO . $order->customer['fax'] . "\n\n";};
  if ($order->info['comments'] != '') {$email_order .= "\n" . EMAIL_SEPARATOR . "\n" .KOMENTARZ_EMAIL_INFO ."\n". EMAIL_SEPARATOR . "\n". $order->info['comments'] . "\n\n";};
   
   tep_mail($temat, STORE_OWNER_EMAIL_ADDRESS, $temat, html_entity_decode($email_order), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

// send emails to other people
  if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
    tep_mail($temat, SEND_EXTRA_ORDER_EMAILS_TO, $temat, html_entity_decode($email_order), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
  }

// load the after_process function from the payment modules
  $payment_modules->after_process();

  $cart->reset(true);

//zwolnienie mtransferu
  if ($_POST['TrDate'] == "Now" ) { ?>
  <!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
  <html <?php echo HTML_PARAMS; ?>>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>"> 
  <title><?php echo 'Potwierdzenie zamowienia'; ?></title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
  </head>
  <body>
  <br><br><br><br><br>
  <center>
  <h1><?php echo CONFIRM_YOUR_ORDER; ?></h1>
  <br><br><br><br><br>
  <form name="checkout_confirmation" action="https://www.mbank.com.pl/mtransfer.asp" method="get">
  <input type="hidden" name="ServiceID" value="<?= $_POST['ServiceID'] ;?>">
  <input type="hidden" name="Description" value="<?= $_POST['Description'].$_POST['insert_id'] ;?>">
  <input type="hidden" name="Amount" value="<?= str_replace(',', '', $_POST['Amount']); ?>">
  <input type="hidden" name="TrDate" value="<?= $_POST['TrDate'] ;?>">
  <input type="image" src="<?php echo (bts_select('images','buttons/'.$language.'/button_confirm_order.gif')); ?>" alt="Potwierdz zam�wienie" title=" Potwierdz zam�wienie "; ?>
  </form>
  </center>
  </body>
  </html>
<?php
}
else
{

// unregister session variables used during checkout
  tep_session_unregister('sendto');
  tep_session_unregister('billto');
  tep_session_unregister('shipping');
  tep_session_unregister('payment');
  tep_session_unregister('comments');
  //kgt - discount coupons
  tep_session_unregister('coupon');
  //end kgt - discount coupons
  
  tep_redirect(tep_href_link(FILENAME_CHECKOUT_SUCCESS, 'order_id='. $insert_id, 'SSL'));
}

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
