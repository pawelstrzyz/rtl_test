<?php
/*
  $Id: newsletters_subscribe.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

require('includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEWSLETTERS);

$error = false;

$newsletter_email = tep_db_prepare_input($HTTP_POST_VARS['Email']);
$newsletter_lastname = tep_db_prepare_input($HTTP_POST_VARS['lastname']);

if (strlen($newsletter_email) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
  $error = true;
} elseif (tep_validate_email($newsletter_email) == false) {
  $error = true;
}

if ($error == false) {
  $subscribers_info = tep_db_query("select subscribers_id from " . TABLE_SUBSCRIBERS . " where subscribers_email_address = '" . $newsletter_email . "' ");
  $date_now = date('Ymd');

  if (!tep_db_num_rows($subscribers_info)) {
    $gender = '' ;
    tep_db_query("insert into " . TABLE_SUBSCRIBERS . " (subscribers_email_address, subscribers_lastname, language, subscribers_email_type, date_account_created, customers_newsletter,  subscribers_blacklist, hardiness_zone, status_sent1,  source_import) values ('" . strtolower($newsletter_email) . "',  '" . ucwords(strtolower($newsletter_lastname)) . "',  'English',  '" . $HTTP_POST_VARS['email_type'] . "',  now() ,  '1',  '0', '" . $domain4 . "', '1', 'subscribe_newsletter')");
  } else {
    tep_db_query("update " . TABLE_SUBSCRIBERS . " set customers_newsletter = '" . '1' . "', subscribers_email_type = '" . $HTTP_POST_VARS['email_type'] . "'  where subscribers_email_address  = '" . $newsletter_email . "' ");
  }

  if ($email_type  == "HTMLXX") {
    // build the message content
    $newsletter_id='3';
    $newsletter_query = "select p.newsletter_info_subject, p.newsletter_info_logo, p.newsletter_info_title, p.newsletter_info_greetings, p.newsletter_info_intro, p.newsletter_info_promo1_name, p.newsletter_info_promo1_des, p.newsletter_info_promo1_img, p.newsletter_info_promo1_url, p.newsletter_info_promo1_link, p.newsletter_info_promo2_name, p.newsletter_info_promo2_des, p.newsletter_info_promo2_img, p.newsletter_info_promo2_url, p.newsletter_info_promo2_link, p.newsletter_info_final_para, p.newsletter_info_closing, q.newsletter_email_address, q.newsletter_template, q.newsletter_user, q.newsletter_site_name, q.newsletter_site_url, q.newsletter_phone, q.newsletter_mailing_address, q.newsletter_template from newsletter_info p , newsletter q where p.newsletter_id = '" . $newsletter_id . "' and q.newsletter_id = p.newsletter_id ";
    $newsletter = tep_db_query($newsletter_query);
    $newsletter_values = tep_db_fetch_array($newsletter);
    $gender = $HTTP_POST_VARS['gender'];
    if ($gender == 'F') {
      $email_greet1 = EMAIL_GREET_MS;
    } else {
      $email_greet1 = EMAIL_GREET_MR;
    }
    $customers_email_address = tep_db_prepare_input($HTTP_POST_VARS['Email']) ;
    $from = 'STORE <customerservice@mystore.com>'  ;
    $subject = tep_db_prepare_input($newsletter_values['newsletter_info_subject'])  ;
    $firstname = tep_db_prepare_input($HTTP_POST_VARS['firstname']);
    $lastname = tep_db_prepare_input($HTTP_POST_VARS['lastname']);
    $name = tep_db_prepare_input($HTTP_POST_VARS['firstname']) . " " . tep_db_prepare_input($HTTP_POST_VARS['lastname']);
    $store_owner = '';
    $store_owner_email = '';
    $domain4 = trim($domain4);
    $email_address = strtolower(tep_db_prepare_input($HTTP_POST_VARS['Email']));
    $gender = $gender;
    $email_text .= BLOCK1 . $newsletter_values['newsletter_info_title'] . BLOCK2 . $newsletter_values['newsletter_info_promo1_name'] . BLOCK3 . $newsletter_values['newsletter_info_promo1_url'] . BLOCK4 . $newsletter_values['newsletter_info_promo1_img'] . BLOCK5 . $newsletter_values['newsletter_info_promo1_des'] . BLOCK6 . $newsletter_values['newsletter_info_promo1_url'] . BLOCK7 . $newsletter_values['newsletter_info_promo1_link'] . BLOCK8 . BLOCK9 . $email_greet1  . $firstname . ' ' .  $lastname . ', ' . $newsletter_values['newsletter_info_greetings'] . '<br>' . BLOCK10 . '<br>' . $newsletter_values['newsletter_info_intro'] . BLOCK11 .  BLOCK12 .  BLOCK13 .  BLOCK14 .  BLOCK15 .  BLOCK16 .  BLOCK17 . $newsletter_values['newsletter_info_final_para'] . BLOCK18 . $newsletter_values['newsletter_info_closing'] . BLOCK19 . BLOCK20 . $email_address . BLOCK22  . BLOCK23 . 'email=' . $email_address . '&action=view' . BLOCK23A . BLOCK24 . 'email=' . $email_address . '&action=view' . BLOCK24A . BLOCK25 ;
    tep_mail1($name, $email_address, $subject, $email_text, $store_owner, $store_owner_email, '');
  } else {
    $message .= EMAIL_WELCOME . CLOSING_BLOCK1 . CLOSING_BLOCK2 . CLOSING_BLOCK3 . UNSUBSCRIBE . $newsletter_email ;
//    tep_mail('', strtolower($newsletter_email), EMAIL_WELCOME_SUBJECT, $message, STORE_OWNER, EMAIL_FROM);
  }
  tep_redirect(tep_href_link(FILENAME_NEWSLETTERS_SUBSCRIBE_SUCCESS, '', 'NONSSL'));
} else {
  tep_redirect(tep_href_link(FILENAME_NEWSLETTERS_SUBSCRIBE_ERROR, '', 'NONSSL'));
}
?>