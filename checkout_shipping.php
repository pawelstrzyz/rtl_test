<?php
/*
  $Id: checkout_shipping.php 70 2008-02-13 20:29:08Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

  require('includes/application_top.php');
  require('includes/classes/http_client.php');

// if the customer is not logged on, redirect them to the login page
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

// Stock Check
  if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
    $products = $cart->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      if (tep_check_stock($products[$i]['id'], $products[$i]['quantity'])) {
        tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
        break;
      }
    }
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
  }

// if no shipping destination address was selected, use the customers own address as default
  if (!tep_session_is_registered('sendto')) {
    tep_session_register('sendto');
    $sendto = $customer_default_address_id;
  } else {
		// verify the selected shipping address
 		if ( (is_array($sendto) && empty($sendto)) || is_numeric($sendto) ) {
 			$check_address_query = tep_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$sendto . "'");
 			$check_address = tep_db_fetch_array($check_address_query);
	 	
 			if ($check_address['total'] != '1') {
 				$sendto = $customer_default_address_id;
 				if (tep_session_is_registered('shipping')) tep_session_unregister('shipping');
 			}    
		}
  }

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

  //BOF Minimalne zamowienie
  $query = tep_db_query("select g.customers_groups_min_amount from " . TABLE_CUSTOMERS_GROUPS . " g inner join  " . TABLE_CUSTOMERS  . " c on g.customers_groups_id = c.customers_groups_id and c.customers_id = '" . $customer_id . "'");
  $query_result = tep_db_fetch_array($query);
  $customers_groups_min_amount = $query_result['customers_groups_min_amount'];
//echo 'koszyk : '. $order->info['subtotal'];
  if ($order->info['subtotal'] < $customers_groups_min_amount) {
   tep_redirect(tep_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'));
  }
  //EOF Minimalne zamowienie

// register a random ID in the session to check throughout the checkout procedure
// against alterations in the shopping cart contents
  if (!tep_session_is_registered('cartID')) tep_session_register('cartID');
  $cartID = $cart->cartID;

// if the order contains only virtual products, forward the customer to the billing page as
// a shipping address is not needed
  if ($order->content_type == 'virtual') {
    if (!tep_session_is_registered('shipping')) tep_session_register('shipping');
    $shipping = false;
    $sendto = false;
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
  }

  $total_weight = $cart->show_weight();
  $total_count = $cart->count_contents();


// load giftwrap module
  require(DIR_WS_CLASSES . 'gift.php');
  $giftwrap_modules = new gift;

// process the selected giftwrap method
  if ( isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'process') ) {
    if (!tep_session_is_registered('giftwrap_info')) tep_session_register('giftwrap_info');

    if (tep_count_giftwrap_modules() > 0) {
      if ( (isset($HTTP_POST_VARS['giftwrap'])) && (strpos($HTTP_POST_VARS['giftwrap'], '_')) ) {
        $giftwrap_info = $HTTP_POST_VARS['giftwrap'];

        list($module, $method) = explode('_', $giftwrap_info);
        if (is_object($$module)) {
          $quote1 = $giftwrap_modules->quote1($method, $module);
          if (isset($quote1['error'])) {
            tep_session_unregister('giftwrap');
          } else {
            if ( (isset($quote1[0]['methods'][0]['title'])) && (isset($quote1[0]['methods'][0]['cost'])) ) {
              $giftwrap_info = array('id' => $giftwrap_info,
                                     'title' => $quote1[0]['module'] . ' (' . $quote1[0]['methods'][0]['title'] . ')',
                                     'cost' => $quote1[0]['methods'][0]['cost']);
            }
          }
        } else {
          tep_session_unregister('giftwrap_info');
        }
      }
    } else {
      $giftwrap_info = false;
    }    
  }

// get all available giftwrap quotes
  $quotes1 = $giftwrap_modules->quote1();

// add gift message
  if ($HTTP_GET_VARS['action'] == 'update') {
    if (tep_not_null($HTTP_POST_VARS['giftMessage']) && tep_session_is_registered('giftwrap_info')) {
      $giftMessage = tep_db_prepare_input($HTTP_POST_VARS['giftMessage']);

      if (tep_session_is_registered('customer_id')) {
        tep_db_query("update " . TABLE_ORDERS . " set giftMessage = '" . tep_db_input($giftMessage) . "' where customers_id = '" . $customer_id . "' and orders_id = '" . $order_id . "'");
      } else {
        tep_db_query("update " . TABLE_ORDERS . " set giftMessage = '" . tep_db_input($giftMessage) . "' where customers_id = '0' and orders_id = '" . $order_id . "'");
      }

      tep_session_unregister('giftwrap_info');
    }
  }


// load all enabled shipping modules
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping;

  if ( defined('MODULE_SHIPPING_FREEAMOUNT_STATUS') && (MODULE_SHIPPING_FREEAMOUNT_STATUS == 'True') ) {
    $pass = false;

	if ( ((int)MODULE_SHIPPING_FREEAMOUNT_ZONE > 0) ) {
      $check_query = tep_db_query("select zone_id, zone_country_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_FREEAMOUNT_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
      $order_shipping_country = $order->delivery['country']['id'];

      while ($check = tep_db_fetch_array($check_query)) {

        if ($check['zone_id'] < 1) {
            $pass = true;
            break;
        } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
            $pass = true;
            break;
        }
      }
     } else {
        $pass = true;
     }
    $free_shipping = false;
	  $waga = $total_weight+SHIPPING_BOX_WEIGHT;
    if ( ($pass == true) && ($order->info['subtotal'] >= MODULE_SHIPPING_FREEAMOUNT_AMOUNT) && ($waga < (int)MODULE_SHIPPING_FREEAMOUNT_WEIGHT_MAX)) {
      $free_shipping = true;
    }
  } else {
    $free_shipping = false;
  }

// process the selected shipping method
  if ( isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'process') ) {
    if (!tep_session_is_registered('comments')) tep_session_register('comments');
    if (tep_not_null($HTTP_POST_VARS['comments'])) {
      $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);
    }

    if (!tep_session_is_registered('shipping')) tep_session_register('shipping');

    if ( (tep_count_shipping_modules() > 0) || ($free_shipping == true) ) {
      if ( (isset($HTTP_POST_VARS['shipping'])) && (strpos($HTTP_POST_VARS['shipping'], '_')) ) {
        $shipping = $HTTP_POST_VARS['shipping'];

        list($module, $method) = explode('_', $shipping);
        if ( is_object($$module) || ($shipping == 'kosztsprzedawcy_kosztsprzedawcy') ) {
          if ($shipping == 'kosztsprzedawcy_kosztsprzedawcy') {
            $quote[0]['methods'][0]['title'] = MODULE_SHIPPING_FREEAMOUNT_TEXT_TITLE;
            $quote[0]['methods'][0]['cost'] = '0';
          } else {
            $quote = $shipping_modules->quote($method, $module);
          }
          if (isset($quote['error'])) {
            tep_session_unregister('shipping');
          } else {
            if ( (isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])) ) {
              $shipping = array('id' => $shipping,
                                'title' => (($free_shipping == true) ?  $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
								
								// start indvship
                                //'cost' => $quote[0]['methods'][0]['cost']);
                                'cost' => $quote[0]['methods'][0]['cost'],
                                'invcost' => $shipping_modules->get_shiptotal());
                                // end indvship


              tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
            }
          }
        } else {
          tep_session_unregister('shipping');
        }
      }
    } else {
      $shipping = false;
                
      tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
    }    
  }

// get all available shipping quotes
  $quotes = $shipping_modules->quote();

// if no shipping method has been selected, automatically select the cheapest method.
// if the modules status was changed when none were available, to save on implementing
// a javascript force-selection method, also automatically select the cheapest shipping
// method if more than one module is now enabled
  if ( !tep_session_is_registered('shipping') || ( tep_session_is_registered('shipping') && ($shipping == false) && (tep_count_shipping_modules() > 1) ) ) $shipping = $shipping_modules->cheapest();

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_SHIPPING);

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

  $content = CONTENT_CHECKOUT_SHIPPING;
  $javascript = $content . '.js';

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
