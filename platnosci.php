<?php
/*
  $Id: platnosci.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PLATNOSCI);

  $breadcrumb->add(HEADING_TITLE, tep_href_link(FILENAME_PLATNOSCI));

  $content = CONTENT_PLATNOSCI;

  $error = false;
  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process')) {

   $_POST['desc'] = preg_replace( "/\n/", " ", $_POST['desc'] );
   $_POST['desc2'] = preg_replace( "/\n/", " ", $_POST['desc2'] );
   $_POST['desc'] = preg_replace( "/\r/", " ", $_POST['desc'] );
   $_POST['desc2'] = preg_replace( "/\r/", " ", $_POST['desc2'] );
   $_POST['desc'] = str_replace("Content-Type:","",$_POST['desc']);
   $_POST['desc2'] = str_replace("Content-Type:","",$_POST['desc2']);

   $desc = tep_db_prepare_input($HTTP_POST_VARS['desc']);
   $desc2 = tep_db_prepare_input($HTTP_POST_VARS['desc2']);
	 $amount_zl = tep_db_prepare_input($HTTP_POST_VARS['amount_zl']);
	 $amount_gr = tep_db_prepare_input($HTTP_POST_VARS['amount_gr']);
	 $amount = $amount_zl . '.';
	 $amount .= $amount_gr;
	 $amount = $amount * 100;

   if (strlen($desc) < 5) {
     $error = true;
     $messageStack->add('platnosci', ERROR_TITLE);
   }
   if (strlen($amount_zl) < 1) {
     $error = true;
     $messageStack->add('platnosci', ERROR_AMOUNT);
   }
   if (urlencode($HTTP_POST_VARS['pay_type']) == '') {
     $error = true;
     $messageStack->add('platnosci', ERROR_PAYTYPE);
   }

	 if ($error == false) {
	 ?>
	 <form action="https://www.platnosci.pl/paygw/ISO/NewPayment" method="POST" name="payform">

	   <input type="hidden" name="pos_id" value="<?php echo MODULE_PAYMENT_PLATNOSCI_POS_ID; ?>">
	   <input type="hidden" name="session_id" value="<?php echo substr(md5(time()), 16); ?>">
	   <input type="hidden" name="pos_auth_id" value="<?php echo MODULE_PAYMENT_PLATNOSCI_POS_AUTH_KEY; ?>">
	   <input type="hidden" name="pay_type" value="<?php echo urlencode($HTTP_POST_VARS['pay_type']); ?>">
	   <input type="hidden" name="amount" value="<?php echo $amount; ?>">
	   <input type="hidden" name="desc" value="<?php echo $desc; ?>">
	   <input type="hidden" name="desc2" value="<?php echo $desc2; ?>">
	   <input type="hidden" name="client_ip" value="<?php echo $_SERVER["REMOTE_ADDR"]; ?>">
	   <input type="hidden" name="js" value="0">

	 </form>
	 <SCRIPT language="JavaScript">
	  document.payform.js.value=1;
	  document.payform.submit();
	 </SCRIPT>
	 <?
   }
	}
  include (bts_select('main', $content_template)); // BTSv1.5
  require(DIR_WS_INCLUDES . 'application_bottom.php');

?>
