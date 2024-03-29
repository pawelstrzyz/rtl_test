<?php
/*
  $Id: contact_us.php 1 2007-12-20 23:52:06Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

require('includes/application_top.php');

$enquiry = '';
$name = '';
$email = '';

// BOF Anti Robot Validation v2.5
if (ACCOUNT_VALIDATION == 'true' && CONTACT_US_VALIDATION == 'true') {
	require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_VALIDATION);
  include_once('includes/functions/' . FILENAME_ACCOUNT_VALIDATION);
}
// EOF Anti Robot Registration v2.5

require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CONTACT_US);

#################
$page_query = tep_db_query("select
                             p.pages_id,
                             p.sort_order,
                             p.status,
                             s.pages_title,
                             s.pages_html_text
                            from
                             " . TABLE_PAGES . " p LEFT JOIN " .TABLE_PAGES_DESCRIPTION . " s on p.pages_id = s.pages_id
                            where 
                             p.status = 1
                            and
                             s.language_id = '" . (int)$languages_id . "'
                            and 
                             p.page_type = 2");

$page_check = tep_db_fetch_array($page_query);
$pagetext=stripslashes($page_check[pages_html_text]);
#################

// BOF Anti Robot Registration v2.4
if (ACCOUNT_VALIDATION == 'true' && CONTACT_US_VALIDATION == 'true') {
	$antirobotreg = tep_db_prepare_input($HTTP_POST_VARS['antirobotreg']);
}
// EOF Anti Robot Registration v2.4

$error = false;
if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'send')) {
	// BOF Anti Robotic Registration v2.5
  if (ACCOUNT_VALIDATION == 'true' && CONTACT_US_VALIDATION == 'true') {
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

  $_POST['email'] = preg_replace( "/\n/", " ", $_POST['email'] );
  $_POST['name'] = preg_replace( "/\n/", " ", $_POST['name'] );
  $_POST['email'] = preg_replace( "/\r/", " ", $_POST['email'] );
  $_POST['name'] = preg_replace( "/\r/", " ", $_POST['name'] );
  $_POST['email'] = str_replace("Content-Type:","",$_POST['email']);
  $_POST['name'] = str_replace("Content-Type:","",$_POST['name']);

  // EOF Anti Robotic Registration v2.5
  $name = tep_db_prepare_input($HTTP_POST_VARS['name']);
  $email_address = tep_db_prepare_input($HTTP_POST_VARS['email']);
  $enquiry = tep_db_prepare_input($HTTP_POST_VARS['enquiry']);

  $name = MakeUTF($name);
  $temat = MakeUTF(EMAIL_SUBJECT);

  // BOF Anti Robot Registration v2.5
  if (!tep_validate_email($email_address)) {
  	$error = true;
    $messageStack->add('contact', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
	} elseif (!$entry_antirobotreg_error == true) {
    tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $temat, $enquiry, $name, $email_address);
    tep_redirect(tep_href_link(FILENAME_CONTACT_US, 'action=success'));
	}

  // EOF Anti Robotic Registration v2.5

} elseif (tep_session_is_registered('customer_id')) {
	$account_query = tep_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
  $account = tep_db_fetch_array($account_query);

  $from_name = $account['customers_firstname'] . ' ' . $account['customers_lastname'];
  $from_email_address = $account['customers_email_address'];
}

$enquiry = "";
$name = "";
$email = "";

$breadcrumb->add(HEADING_TITLE, tep_href_link(FILENAME_CONTACT_US, '', 'NONSSL'));

$content = CONTENT_CONTACT_US;

include (bts_select('main', $content_template)); // BTSv1.5

require(DIR_WS_INCLUDES . 'application_bottom.php');
?>