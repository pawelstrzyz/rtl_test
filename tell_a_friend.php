<?php
/*
  $Id: tell_a_friend.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

require('includes/application_top.php');

$to_name = '';
$to_email_address = '';
$email_text = '';

// BOF Anti Robot Validation v2.4
if (ACCOUNT_VALIDATION == 'true' && TELL_FRIEND_VALIDATION == 'true') {
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_VALIDATION);
  include_once('includes/functions/' . FILENAME_ACCOUNT_VALIDATION);
}
// EOF Anti Robot Registration v2.4

require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_TELL_A_FRIEND);

// BOF Anti Robot Registration v2.4
if (ACCOUNT_VALIDATION == 'true' && TELL_FRIEND_VALIDATION == 'true') {
  $antirobotreg = tep_db_prepare_input($HTTP_POST_VARS['antirobotreg']);
}
// EOF Anti Robot Registration v2.4


//check for valid product
$valid_product = "false";

$tell_products_id = $HTTP_GET_VARS['products_id'];

if (!tep_session_is_registered('customer_id') && (ALLOW_GUEST_TO_TELL_A_FRIEND == 'false')) {
  $navigation->set_snapshot();
  tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
} elseif (tep_session_is_registered('customer_id')) {
  $account_query = tep_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
  $account = tep_db_fetch_array($account_query);
  $from_name = $account['customers_firstname'] . ' ' . $account['customers_lastname'];
  $from_email_address = $account['customers_email_address'];
}

$product_info_query = tep_db_query("select pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'");
if (tep_db_num_rows($product_info_query)) {
  $valid_product = "true";
  $product_info = tep_db_fetch_array($product_info_query);
} else{
  $valid_product = "false";
  if (!isset($HTTP_GET_VARS['action'])) {
    tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $tell_products_id));
  }
}


$error = false;
if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process')) {
  // BOF Anti Robotic Registration v2.5
  if (ACCOUNT_VALIDATION == 'true' && TELL_FRIEND_VALIDATION == 'true') {
    $sql = "SELECT * FROM " . TABLE_ANTI_ROBOT_REGISTRATION . " WHERE session_id = '" . tep_session_id() . "' LIMIT 1";
    if( !$result = tep_db_query($sql) ) {
      $error = true;
      $entry_antirobotreg_error = true;
      $text_antirobotreg_error = ERROR_VALIDATION_1;
    } else {
      $entry_antirobotreg_error = false;
      $anti_robot_row = tep_db_fetch_array($result);
      if (( strtoupper($HTTP_POST_VARS['antirobotreg']) != $anti_robot_row['reg_key'] ) || ($anti_robot_row['reg_key'] == '') || (strlen($antirobotreg) != ENTRY_VALIDATION_LENGTH)) {
        $error = true;
        $entry_antirobotreg_error = true;
        $text_antirobotreg_error = ERROR_VALIDATION_2;
      } else {
        $sql = "DELETE FROM " . TABLE_ANTI_ROBOT_REGISTRATION . " WHERE session_id = '" . tep_session_id() . "'";
        if( !$result = tep_db_query($sql) ) {
          $error = true;
          $entry_antirobotreg_error = true;
          $text_antirobotreg_error = ERROR_VALIDATION_3;
        } else {
          $sql = "OPTIMIZE TABLE " . TABLE_ANTI_ROBOT_REGISTRATION . "";
          if( !$result = tep_db_query($sql) ) {
            $error = true;
            $entry_antirobotreg_error = true;
            $text_antirobotreg_error = ERROR_VALIDATION_4;
          } else {
            $entry_antirobotreg_error = false;
          }
        }
      }
    }
    if ($entry_antirobotreg_error == true) $messageStack->add('contact', $text_antirobotreg_error);
  }
  // EOF Anti Robotic Registration v2.5

  $_POST['to_email_address'] = preg_replace( "/\n/", " ", $_POST['to_email_address'] );
  $_POST['to_name'] = preg_replace( "/\n/", " ", $_POST['to_name'] );
  $_POST['to_email_address'] = preg_replace( "/\r/", " ", $_POST['to_email_address'] );
  $_POST['to_name'] = preg_replace( "/\r/", " ", $_POST['to_name'] );
  $_POST['to_email_address'] = str_replace("Content-Type:","",$_POST['to_email_address']);
  $_POST['to_name'] = str_replace("Content-Type:","",$_POST['to_name']);

  $to_email_address = tep_db_prepare_input($HTTP_POST_VARS['to_email_address']);
  $to_name = tep_db_prepare_input($HTTP_POST_VARS['to_name']);
  $from_email_address = tep_db_prepare_input($HTTP_POST_VARS['from_email_address']);
  $from_name = tep_db_prepare_input($HTTP_POST_VARS['from_name']);
  $message = tep_db_prepare_input($HTTP_POST_VARS['message']);

  if (empty($from_name)) {
    $error = "true";
    if(($HTTP_GET_VARS['action'] == 'process')){
      $messageStack->add('friend', ERROR_FROM_NAME, 'error');
    }
  }

  if (!tep_validate_email($from_email_address)) {
    $error = "true";
    if(($HTTP_GET_VARS['action'] == 'process')){
      $messageStack->add('friend', ERROR_FROM_ADDRESS, 'error');
    }
  }

  if (empty($to_name)) {
    $error = "true";
    if(($HTTP_GET_VARS['action'] == 'process')){
      $messageStack->add('friend', ERROR_TO_NAME, 'error');
    }
  }

  if (!tep_validate_email($to_email_address)) {
    $error = "true";
    if(($HTTP_GET_VARS['action'] == 'process')){
      $messageStack->add('friend', ERROR_TO_ADDRESS, 'error');
    }
  }

  $email_subject = sprintf(TEXT_EMAIL_SUBJECT, $from_name, STORE_NAME);

  $email_text = sprintf(TEXT_EMAIL_INTRO, $to_name, $from_name, $product_info['products_name'], STORE_NAME) . "\n\n";

	if (tep_not_null($message)) {
    $email_text .= $message;
  }
  $email_text .= "\n\n";
  $email_text .= TEXT_EMAIL_LINK_TEXT . '<a href="' . HTTP_SERVER  . DIR_WS_CATALOG . FILENAME_PRODUCT_INFO . '?products_id='.$tell_products_id .'">' .  HTTP_SERVER  . DIR_WS_CATALOG . FILENAME_PRODUCT_INFO . '?products_id='. $tell_products_id . '</a>' . "\n\n";
  $email_text .= TEXT_EMAIL_SIGNATURE. STORE_NAME . "\n" . '<a href="' . HTTP_SERVER  . DIR_WS_CATALOG .'">' .  HTTP_SERVER  . DIR_WS_CATALOG . '</a>';

    // BOF Anti Robot Registration v2.5
    if ($error == 'true') {
      $error = true;
	} elseif (!$entry_antirobotreg_error == true) {
    tep_mail($to_name, $to_email_address, $email_subject, $email_text, $from_email_name, $from_email_address, $attachment_file, $attachment_name, $attachment_type);
    $messageStack->add_session('header', sprintf(TEXT_EMAIL_SUCCESSFUL_SENT, $product_info['products_name'], tep_output_string_protected($to_name)), 'success');
    tep_redirect(tep_href_link(FILENAME_TELL_A_FRIEND, 'action=success&products_id='.$tell_products_id.''));
	}

} elseif (tep_session_is_registered('customer_id')) {
	$account_query = tep_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
  $account = tep_db_fetch_array($account_query);

  $from_name = $account['customers_firstname'] . ' ' . $account['customers_lastname'];
  $from_email_address = $account['customers_email_address'];

}

$to_email_address = "";
$to_name = "";
$message = "";

$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_TELL_A_FRIEND, 'products_id=' . $tell_products_id));

$content = CONTENT_TELL_A_FRIEND;

include (bts_select('main', $content_template)); // BTSv1.5

require(DIR_WS_INCLUDES . 'application_bottom.php');

?>