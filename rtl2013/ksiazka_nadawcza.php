<?php

require('includes/application_top.php');

if ($HTTP_GET_VARS['mkey']) {
	$key = $HTTP_GET_VARS['mkey'];
	$message = $error[$key];
	$HTTP_GET_VARS['act'] = 0;
}

if ($HTTP_GET_VARS['act'] == '') {
	$HTTP_GET_VARS['act'] = 0;
}

if (strlen($HTTP_GET_VARS['act']) == 1 && is_numeric($HTTP_GET_VARS['act'])) {
	switch ($HTTP_GET_VARS['act']) {
  	case 1:
    	// check if invoice number is a empty field .. if its not empty do this ..
			// if it is empty skip down to the check date entered code.
			if ($HTTP_POST_VARS['invoicenumbers'] != '') {
      	if (!isset($HTTP_POST_VARS['invoicenumbers'])) {
					message_handler('ERROR_BAD_INVOICENUMBERS');
				}
				$time0 = time();
				$invoicenumbers = tep_db_prepare_input($HTTP_POST_VARS['invoicenumbers']);
				$arr_no = explode(',',$invoicenumbers);
				foreach ($arr_no as $key=>$value) {
  				$arr_no[$key]=trim($value);
  				if (substr_count($arr_no[$key],'-')>0) {
    				$temp_range=explode('-',$arr_no[$key]);
    				$arr_no[$key]=implode(',',range((int) $temp_range[0], (int) $temp_range[1]));
   				}
 				}
				$invoicenumbers=implode(',',$arr_no);
			} else {
      	// CHECK DATE ENTERED, GRAB ALL ORDERS FROM THAT DATE, AND CREATE PDF FOR ORDERS
				if (!isset($HTTP_POST_VARS['startdate'])) {
					message_handler();
				}
				if ((strlen($HTTP_POST_VARS['startdate']) != 10) || verify_start_date($HTTP_POST_VARS['startdate'])) {
					message_handler('ERROR_BAD_DATE');
				}
				$time0   = time();
				$startdate = tep_db_prepare_input($HTTP_POST_VARS['startdate']);

				if (!isset($HTTP_POST_VARS['enddate'])) {
					message_handler();
				}
				if ((strlen($HTTP_POST_VARS['enddate']) != 10) || verify_end_date($HTTP_POST_VARS['enddate'])) {
					message_handler('ERROR_BAD_DATE');
				}
				$time0   = time();
				$enddate = tep_db_prepare_input($HTTP_POST_VARS['enddate']);
      }

			if ($HTTP_POST_VARS['pull_status']){
				$pull_w_status = " and o.orders_status = ". $HTTP_POST_VARS['pull_status'];
			}

			if ($HTTP_POST_VARS['pull_shipping']){
				$dlugosc = strlen($HTTP_POST_VARS['pull_shipping']);
				$pull_w_shipping = " and substr(t.title, 0 , $dlugosc) = '". $HTTP_POST_VARS['pull_shipping'] . "'";
			}

			// if there is a invoice number use first order query otherwise use second date style order query
			if ($invoicenumbers != '') {
				$orders_query = tep_db_query("select o.orders_id, h.comments, MIN(h.date_added) from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_STATUS_HISTORY . " h where o.orders_id in (" . tep_db_input($invoicenumbers) . ") and h.orders_id = o.orders_id and t.orders_id = o.orders_id and t.class = 'ot_shipping' " . $pull_w_status . $get_customer_comments . ' group by o.orders_id');
			} else {
				$orders_query = tep_db_query("select o.orders_id, h.comments, MIN(h.date_added), t.class, t.title from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_STATUS_HISTORY . " h, " . TABLE_ORDERS_TOTAL. " t where h.date_added between '" . tep_db_input($startdate) . "' and '" . tep_db_input($enddate) . " 23:59:59' and h.orders_id = o.orders_id and t.orders_id = o.orders_id and t.class = 'ot_shipping' " . $pull_w_status . $get_customer_comments . ' group by o.orders_id');
			}
 
      if (!tep_db_num_rows($orders_query) > 0) {
				message_handler('NO_ORDERS');
			}
 			$num = 0;

			require(DIR_WS_CLASSES . 'currencies.php');
			require(DIR_WS_CLASSES . 'order.php');

      require(BOOK_PRINT_INC . 'book_print_header_print.php');
      require(BOOK_PRINT_INC . 'book_print_table.php');
			require(BOOK_PRINT_INC . 'book_print_footer_print.php');
			break;

		case 0:
     	require(BOOK_PRINT_INC . 'book_print_header.php');
			require(BOOK_PRINT_INC . 'book_print_body.php');
			require(BOOK_PRINT_INC . 'book_print_footer.php');
			break;
		default:
    	message_handler();
	}	//EOSWITCH

} else {

	message_handler('ERROR_INVALID_INPUT');

}

// FUNCTION AREA
function message_handler($message=''){

	if ($message) {
		header("Location: " . tep_href_link(BOOK_PRINT_FILE, 'mkey=' . $message));
	} else {
		header("Location: " . tep_href_link(BOOK_PRINT_FILE));
	}
	exit(0);
}

function verify_start_date($startdate) {
	$error = 0;
	list($year,$month,$day) = explode('-', $startdate);

	if ((strlen($year) != 4) || !is_numeric($year)) {
		$error++;
	}
	if ((strlen($month) != 2) || !is_numeric($month)) {
		$error++;
	}
	if ((strlen($day) != 2) || !is_numeric($day)) {
		$error++;
	}
	return $error;
}

function verify_end_date($enddate) {
	$error = 0;
	list($year,$month,$day) = explode('-', $enddate);

	if ((strlen($year) != 4) || !is_numeric($year)) {
		$error++;
	}
	if ((strlen($month) != 2) || !is_numeric($month)) {
		$error++;
	}
	if ((strlen($day) != 2) || !is_numeric($day)) {
		$error++;
	}
  return $error;
}

?>