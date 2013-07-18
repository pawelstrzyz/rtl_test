<?php
/*
  $Id: printorder.php,v 1.2 12/03/2003 randynewman
  
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ORDERS_PRINTABLE);

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order($_GET['order_id']);
  
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  $customer_number_query = tep_db_query("select customers_id from " . TABLE_ORDERS . " where orders_id = '". tep_db_input(tep_db_prepare_input($HTTP_GET_VARS['order_id'])) . "'");
  $customer_number = tep_db_fetch_array($customer_number_query);

  $payment_info_query = tep_db_query("select orders_id, payment_info from " . TABLE_ORDERS . " where orders_id = '". tep_db_input(tep_db_prepare_input($HTTP_GET_VARS['order_id'])) . "'");
  $payment_info = tep_db_fetch_array($payment_info_query);
  $zam_id = $payment_info['orders_id'];
  $payment_info = $payment_info['payment_info'];
  
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE . ' - ' . TITLE_PRINT_ORDER . '&nbsp;' . $HTTP_GET_VARS['order_id']; ?></title>
<base href="<?php echo (getenv('HTTPS') == 'on' ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES; ?>print.css">
<script language="JavaScript">
<!--
function Lvl_P2P(url,closeIt,delay){ //ver1.0 4LevelWebs
    opener.location.href = url;
	if (closeIt == true)setTimeout('self.close()',delay);
}
//-->
</script>
</head>
<body marginwidth="10" marginheight="10" topmargin="10" bottommargin="10" leftmargin="10" rightmargin="10">
<!-- body_text //-->

<?php
  if ($_GET['order_id'] !=  $zam_id) {
?>

<table width="600" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr> 
    <td align="center" class="main"><table align="center" width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr> 
        <td align="center" valign="middle" class="main"><?php echo TEXT_ORDER_ERROR ; ?></td>
      </tr>
      <tr>
        <td align="center" valign="middle" class="main"><a href="javascript:;" onClick="Lvl_P2P('logout.php',true,0);return false"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/close_window.gif', 'Close Window'); ?></a></td>
      </tr>
    </table></td>
  </tr>
</table>

<?php
  } else {
?>    

<table width="600" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr> 
    <td align="center" class="main"><table align="center" width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr> 
        <td valign="top" align="left" class="main"><script language="JavaScript">
  if (window.print) {
    document.write('<a href="javascript:;" onClick="javascript:window.print()" onMouseOut=document.imprim.src="<?php echo (DIR_WS_TEMPLATES . 'images/misc/printimage.gif'); ?>" onMouseOver=document.imprim.src="<?php echo (DIR_WS_TEMPLATES . 'images/misc/printimage_over.gif'); ?>"><img src="<?php echo (DIR_WS_TEMPLATES . 'images/misc/printimage.gif'); ?>" width="43" height="28" align="absbottom" border="0" name="imprim">' + '<?php echo IMAGE_BUTTON_PRINT; ?></a></center>');
  }
  else document.write ('<h2><?php echo IMAGE_BUTTON_PRINT; ?></h2>')
        </script></td>
        <td align="right" valign="bottom" class="main"><p align="right" class="main"><a href="javascript:window.close();"><img src='<?php echo DIR_WS_TEMPLATES; ?>images/misc/close_window.jpg' border=0></a></p></td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '15'); ?></td>
  </tr>
  <tr> 
    <td><table border="0" align="center" width="100%" cellspacing="0" cellpadding="0">
      <tr> 
        <td><table border="0" align="center" width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td class="pageHeading"><?php echo nl2br(STORE_NAME_ADDRESS); ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . STORE_LOGO, STORE_NAME); ?></td>
          </tr>
          <tr> 
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
          </tr>
          <tr> 
            <td colspan="2" align="center" class="titleHeading"><b><?php echo TITLE_PRINT_ORDER . '&nbsp;' . $HTTP_GET_VARS['order_id']; ?></b></td>
          </tr>
          <tr> 
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" class="main"><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr> 
        <td class="main"><?php echo '<b>' . ENTRY_PAYMENT_METHOD . '</b> ' . $order->info['payment_method']; ?></td>
      </tr>
      <tr> 
        <td class="main"><?php echo $payment_info; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td align="center"><table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr> 
        <td align="center" valign="top"><table align="center" width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor=#000000>
          <tr> 
            <td align="center" valign="top"><table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow"> 
                <td class="dataTableHeadingContent"><b><?php echo ENTRY_SOLD_TO; ?></b></td>
              </tr>
              <tr class="dataTableRow"> 
                <td class="dataTableContent"><?php echo tep_address_format($order->customer['format_id'], $order->customer, 1, '&nbsp;', '<br>'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td align="center" valign="top"><table align="center" width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor=#000000>
          <tr> 
            <td align="center" valign="top"><table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow"> 
                <td class="dataTableHeadingContent"><b><?php echo ENTRY_SHIP_TO; ?></b></td>
              </tr>
              <tr class="dataTableRow"> 
                <td class="dataTableContent"><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, '&nbsp;', '<br>'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
  </tr>
  <tr> 
    <td><table border="0" width="100%" cellspacing="0" cellpadding="1" bgcolor=#000000>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr class="dataTableHeadingRow"> 
            <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
            <td class="dataTableHeadingContent"><?php echo BOX_HEADING_MANUFACTURER_INFO; ?></td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_EXCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_EXCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_INCLUDING_TAX; ?></td>
          </tr>
        <?php
        for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
           echo '      <tr class="dataTableRow">' . "\n" .
           '        <td class="dataTableContent" valign="top" align="right">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
           '        <td class="dataTableContent" valign="top">' . $order->products[$i]['name'] . '<br>';

           if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
             for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
               echo '<nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '</i><br></small></nobr>';
             }
           }
           // Manufacturer Listing
	         //Use the products ID# to find the proper Manufacturer of this specific product
		       $v_query = tep_db_query("SELECT manufacturers_id FROM ".TABLE_PRODUCTS." WHERE products_id = '".$order->products[$i]['id']."'");
		       $v = tep_db_fetch_array($v_query);
	         //Select the proper Manufacturers Name via the Manufacturers ID# then display that name for a human readable output
		       $mfg_query = tep_db_query("SELECT manufacturers_name FROM ".TABLE_MANUFACTURERS." WHERE manufacturers_id = '".$v['manufacturers_id']."'");
		       $mfg = tep_db_fetch_array($mfg_query);
		       echo '</td>        <td class="dataTableContent" valign="top">' . $mfg['manufacturers_name'] . '</td>';
           // End Manufacturer Listing

           echo '        </td>' . "\n" .
           '        <td class="dataTableContent" valign="top">' . $order->products[$i]['model'] . '</td>' . "\n";
           echo '        <td class="dataTableContent" align="right" valign="top">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n" .
           '        <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
           '        <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
           '        <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n";
           echo '      </tr>' . "\n";
        }
        ?>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" colspan="7"><table border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <?php
  for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
    echo '          <tr>' . "\n" .
         '            <td align="right" class="smallText" nowrap>' . $order->totals[$i]['title'] . '</td>' . "\n" .
         '            <td align="right" class="smallText" nowrap>' . $order->totals[$i]['text'] . '</td>' . "\n" .
         '          </tr>' . "\n";
  }
?>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php
  }
?>    
<!-- body_text_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>