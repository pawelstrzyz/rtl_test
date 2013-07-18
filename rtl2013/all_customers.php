<?php
/*
  $Id: all_customers.php, v1.0 March 21, 2005 18:45:00
  adapted by Robert Goth June 24, 2005

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 - 2004 osCommerce

  written by Jared Call at client' suggestion
  some code nicked and modified from /catalog/admin/customers.php
  Released under the GNU General Public License
*/

// entry for bouncing csv string back as file
// Turn on output buffering
ob_start();
if (isset($_POST['csv'])) {
   if (isset($HTTP_POST_VARS['saveas'])) {  // rebound posted csv as save file
		  $savename= $HTTP_POST_VARS['saveas'] . ".csv";
   }
else $savename='unknown.csv';
   $csv_string = '';
   if ($HTTP_POST_VARS['csv']) $csv_string=$HTTP_POST_VARS['csv'];
     if (strlen($csv_string)>0){
       header("Expires: Mon, 26 Nov 1962 00:00:00 GMT");
       header("Last-Modified: " . gmdate('D,d M Y H:i:s') . ' GMT');
       header("Cache-Control: no-cache, must-revalidate");
       header("Pragma: no-cache");
       header("Content-Type: text/csv");
       header("Content-Disposition: attachment; filename=$savename");
       echo html_entity_decode(stripslashes($csv_string), ENT_QUOTES);
     }
   else echo "CSV string empty";
     exit;
};

require('includes/application_top.php');

?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/css/stylesheet.css">
<script language="javascript" src="includes/javascript/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="3" style="border-color: #424242; border-width: 1px; border-style: solid;">

      <tr>
        <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php

// Used to determine sorting order by field
  switch ($orderby) {

   case "email" :
   $db_orderby = "c.customers_email_address";
   break;

   	case "address":
	$db_orderby = "a.entry_street_address";
	break;

	case "city":
	$db_orderby = "a.entry_city";
	break;

	case "state":
	$db_orderby = "z.zone_name";
	break;

	case "country":
	$db_orderby = "co.countries_name";
	break;

	case "telephone":
	$db_orderby = "c.customers_telephone";
	break;

	case "pcode":
	$db_orderby = "a.entry_postcode";
	break;

   default :
   $db_orderby = "a.entry_lastname";;
   break;

   }


   $customers_query_raw = "SELECT c.customers_id , c.customers_default_address_id, c.customers_email_address, c.customers_fax, c.customers_telephone, a.entry_company, a.address_book_id, a.customers_id, a.entry_firstname, a.entry_lastname, a.entry_street_address, a.entry_suburb, a.entry_city, a.entry_state, a.entry_postcode, a.entry_country_id, a.entry_zone_id, z.zone_name, co.countries_name FROM " . TABLE_CUSTOMERS . " c INNER JOIN " . TABLE_ADDRESS_BOOK . " a ON c.customers_default_address_id = a.address_book_id INNER JOIN " . TABLE_COUNTRIES . " co ON entry_country_id = co.countries_id LEFT OUTER JOIN ". TABLE_ZONES ." z ON a.entry_zone_id = z.zone_id ORDER BY $db_orderby $sorted";

  $customers_query = tep_db_query($customers_query_raw);


 //BOF HEADER  ?>
<tr class="dataTableHeadingRow">
<? /*<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_NUMBER; ?></td> */ ?>
<td class="dataTableHeadingContent"><?php echo tep_sort_order ($orderby, $sorted, FULL_NAME, 'name');?></td>
<td class="dataTableHeadingContent"><?php echo tep_sort_order ($orderby, $sorted, EMAIL, 'email');?></td>
<td class="dataTableHeadingContent"><?php
  										echo tep_sort_order ($orderby, $sorted, ADDRESS, 'address');?></td>
<td class="dataTableHeadingContent"><?php echo tep_sort_order ($orderby, $sorted, CITY_NAME, 'city');?></td>
<td class="dataTableHeadingContent"><?php echo tep_sort_order ($orderby, $sorted, STATE, 'state');?></td>
<td class="dataTableHeadingContent"><?php echo tep_sort_order ($orderby, $sorted, POSTAL_CODE, 'pcode');?></td>
<td class="dataTableHeadingContent"><?php echo tep_sort_order ($orderby, $sorted, CONTRY_NAME, 'country');?></td>
<td class="dataTableHeadingContent"><?php echo tep_sort_order ($orderby, $sorted, TELEPHONE_NUMBER, 'telephone');

//EOF HEADER
?></td>

		   	 </tr>

  <?PHP
  $num_rows = tep_db_num_rows($customers_query);
  while ($customers = tep_db_fetch_array($customers_query)) {
	  if ( tep_not_null($customers['customers_id']) ) {
	  $rows++;
	    if (strlen($rows) < 2) {
      $rows = '0' . $rows;
    }
	$csv_accum .= "\n";

		  $email = '<a href="mailto:' . $customers['customers_email_address'] . '">'
		            . $customers['customers_email_address'] . '</a>';
		  $full_name = '<a href="customers.php?cID=' . $customers['customers_id'] . '&action=edit"> ' . $customers['entry_lastname'] . ", " . $customers['entry_firstname'] . '</a>';
?>
		      <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
		      	 <? /*  <td align="left" class="dataTableContent"><?php echo $rows; ?>.</td> */ ?>
				   <td class="dataTableContent"><?php mirror_out($full_name);?></td>
		      	  <td class="dataTableContent"><?php  mirror_out($email); ?></td>
		      	  <td class="dataTableContent"><?php mirror_out($customers['entry_street_address']); ?></td>
		          <td class="dataTableContent"><?php mirror_out($customers['entry_city']); ?></td>
		      	  <td class="dataTableContent"><?php mirror_out($customers['zone_name']); ?></td>
		      	  <td class="dataTableContent"><?php mirror_out($customers['entry_postcode']); ?></td>
		      	  <td class="dataTableContent"><?php mirror_out($customers['countries_name']); ?></td>
				      <td class="dataTableContent"><?php mirror_out($customers['customers_telephone']); ?></td>

		   	 </tr>

	      <?php
      } else { }
  }
?>

<!-- body_text_eof //-->
  </tr>
  <?PHP
			 if ($num_rows>0 && !$print) {
?>


				<td class="smallText" colspan="4"><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method=post>
				<input type='hidden' name='csv' value='<?php echo $csv_accum; ?>'>
				<?php //suggested file name for csv, include year and month ?>
				<input type='hidden' name='saveas' value='Lista_klientow_<?php echo date("Y" . "_" . "m" . "_" . "d" . "_" . "Hi"); ?>'><input type="submit" value="<?php echo TEXT_BUTTON_REPORT_SAVE ;?>"></form>
				</td>
</tr>
<?php }; // end button for Save CSV ?>
</table>


<!-- body_eof //-->





<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
</body>
</html>
