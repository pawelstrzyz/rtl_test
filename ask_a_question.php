<?php
/*
  $Id: ask_a_question.php 52 2008-02-09 20:42:33Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

require('includes/application_top.php');

$from_email_address = '';
$from_name = '';
$message = '';

// BOF Anti Robot Validation v2.5
if (ACCOUNT_VALIDATION == 'true' && ASKAQUESTION_VALIDATION == 'true') {
	require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_VALIDATION);
  include_once('includes/functions/' . FILENAME_ACCOUNT_VALIDATION);
}
// EOF Anti Robot Registration v2.5

if (!tep_session_is_registered('customer_id') && (ALLOW_GUEST_TO_TELL_A_FRIEND == 'false')) {
	$navigation->set_snapshot();
  tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
}

$valid_product = false;
if (isset($HTTP_GET_VARS['products_id'])) {
	$product_info_query = tep_db_query("select pd.products_name, p.products_model,  p.products_image from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'");
  if (tep_db_num_rows($product_info_query)) {
  	$valid_product = true;
    $product_info = tep_db_fetch_array($product_info_query);
  }
}

if ($valid_product == false) {
	tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['products_id']));
}

require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ASK_QUESTION);

// BOF Anti Robot Registration v2.4
if (ACCOUNT_VALIDATION == 'true' && ASKAQUESTION_VALIDATION == 'true') {
	$antirobotreg = tep_db_prepare_input($HTTP_POST_VARS['antirobotreg']);
}
// EOF Anti Robot Registration v2.4

$error = false;

if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process')) {
	// BOF Anti Robotic Registration v2.5
  if (ACCOUNT_VALIDATION == 'true' && ASKAQUESTION_VALIDATION == 'true') {
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
    if ($entry_antirobotreg_error == true) $messageStack->add('friend', $text_antirobotreg_error);
  }

  $_POST['from_email_address'] = preg_replace( "/\n/", " ", $_POST['from_email_address'] );
  $_POST['from_name'] = preg_replace( "/\n/", " ", $_POST['from_name'] );
  $_POST['from_email_address'] = preg_replace( "/\r/", " ", $_POST['from_email_address'] );
  $_POST['from_name'] = preg_replace( "/\r/", " ", $_POST['from_name'] );
  $_POST['from_email_address'] = str_replace("Content-Type:","",$_POST['from_email_address']);
  $_POST['from_name'] = str_replace("Content-Type:","",$_POST['from_name']);
  // EOF Anti Robotic Registration v2.5

  $from_email_address = tep_db_prepare_input($HTTP_POST_VARS['from_email_address']);
  $from_name = tep_db_prepare_input($HTTP_POST_VARS['from_name']);
  $message = tep_db_prepare_input($HTTP_POST_VARS['enquiry']);

  if (empty($from_name)) {
  	$error = true;
    $messageStack->add('friend', ERROR_FROM_NAME);
  }
  if (!tep_validate_email($from_email_address)) {
  	$error = true;
    $messageStack->add('friend', ERROR_FROM_ADDRESS);
  }

  if ($error == false) {
  	$email_subject = sprintf(TEXT_EMAIL_SUBJECT, $from_name, STORE_NAME);
    $email_body = sprintf(TEXT_EMAIL_INTRO, STORE_OWNER, $from_name, $product_info['products_name'], $product_info['products_model'], STORE_NAME) . "\n\n";

    if (tep_not_null($message)) {
    	$email_body .= $message . "\n\n";
    }

    $email_body .= sprintf(TEXT_EMAIL_LINK, tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['products_id'])) . "\n\n" .
                     sprintf(TEXT_EMAIL_SIGNATURE, STORE_NAME . "\n" . HTTP_SERVER . DIR_WS_CATALOG . "\n");

    $email_subject = MakeUTF($email_subject);

    tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $email_subject, $email_body, $from_name, $from_email_address);

    $messageStack->add_session('header', sprintf(TEXT_EMAIL_SUCCESSFUL_SENT, $product_info['products_name'], STORE_OWNER), 'success');
    tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['products_id']));
  }

} elseif (tep_session_is_registered('customer_id')) {
	$account_query = tep_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
  $account = tep_db_fetch_array($account_query);

  $from_name = $account['customers_firstname'] . ' ' . $account['customers_lastname'];
  $from_email_address = $account['customers_email_address'];
}

$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_ASK_QUESTION, 'products_id=' . $HTTP_GET_VARS['products_id']));

$content = 'ask_a_question';

include (bts_select('main', $content_template)); // BTSv1.5

require(DIR_WS_INCLUDES . 'application_bottom.php');

?>