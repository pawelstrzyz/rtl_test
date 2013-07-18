<?php
/*
  $Id: customers.php 91 2008-02-16 19:06:45Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
  
  mod eSklep-Os http://www.esklep-os.com
*/
?>
<fieldset>
<legend> Ostatnio zarejestrowani klienci (<a href="<?php echo tep_href_link(FILENAME_CUSTOMERS,'','NONSSL');?>">Przeglądaj</a>)</legend>
<table border="0" width="100%" cellspacing="0" cellpadding="4" style="border-color: #424242; border-width: 1px; border-style: solid;">
  <tr class="dataTableHeadingRow">
    <td class="dataTableHeadingContent"><?php echo ADMIN_INDEX_CUSTOMERS_TITLE; ?></td>
    <td class="dataTableHeadingContent"><?php echo ADMIN_INDEX_CUSTOMERS_DATE; ?></td>
  </tr>
<?php
  $customers_query = tep_db_query("select c.customers_id, c.customers_lastname, c.customers_firstname, ci.customers_info_date_account_created from " . TABLE_CUSTOMERS . " c, " . TABLE_CUSTOMERS_INFO . " ci where c.customers_id = ci.customers_info_id order by ci.customers_info_date_account_created desc limit 10");
  while ($customers = tep_db_fetch_array($customers_query)) {
    $firma_query = mysql_query("select entry_company from address_book where customers_id = '" . $customers['customers_id'] . "'");
    $firma = tep_db_fetch_array($firma_query);
	if ($firma['entry_company'] != '') {
		$zmienna = ' (firma: <b>' . $firma['entry_company'] .'</b>)'; }
		else {
		$zmienna = '';
	}
    echo '  <tr class="dataTableRow" onmouseover="rowOverEffect(this);" onmouseout="rowOutEffect(this);">' .
         '    <td class="dataTableContent"><a href="' . tep_href_link(FILENAME_CUSTOMERS, 'cID=' . (int)$customers['customers_id'] . '&action=edit') . '">' . tep_output_string_protected($customers['customers_firstname'] . ' ' . $customers['customers_lastname']). $zmienna . '</td>' .
         '    <td class="dataTableContent">' . $customers['customers_info_date_account_created'] . '</td>' .
         '  </tr>';
  }
?>
</table>
</fieldset>
