<?php
/*
  $Id: przelewy24_error.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  //michal.bajer@horyzont.net
  //2006-01-02,03

  mod eSklep-Os http://www.esklep-os.com
*/

  require('includes/application_top.php');

  if (strlen($languge)==0) {
      //load language texts
      $tmp = tep_db_query("select directory from " . TABLE_LANGUAGES . " where code = '" . $_POST['lang_code'] . "'");
      $T = tep_db_fetch_array($tmp);
      $language = $T["directory"];
      if (strlen($language)==0) $language='polish';
  }

      // include the language translations
//      require(DIR_WS_LANGUAGES . $language . '.php');
      require(DIR_WS_LANGUAGES . $language . '/' . 'przelewy24.php');

  require(DIR_WS_LANGUAGES . $language . '/' . 'przelewy24_error.php');

   $cart->reset(true);

// unregister session variables used during checkout
  tep_session_unregister('sendto');
  tep_session_unregister('billto');
  tep_session_unregister('shipping');
  tep_session_unregister('payment');
  tep_session_unregister('comments');

  session_regenerate_id();
  $osCsid=session_id();


  $breadcrumb->add(NAVBAR_TITLE_1);
  $breadcrumb->add(NAVBAR_TITLE_2);

  $content = CONTENT_PRZELEWY24_ERROR;

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
