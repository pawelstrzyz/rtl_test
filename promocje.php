<?php

require('includes/application_top.php');

tep_db_query("TRUNCATE " . TABLE_SPECIALS . "");

$selectquery="select products_id, products_price from ". TABLE_PRODUCTS ."";
$exists_query = tep_db_query($selectquery);

//for ($i=0, $n=sizeof($exists); $i<$n; $i++) {
while ($exists = tep_db_fetch_array($exists_query)) {

	$products_id = $exists['products_id'];
  $products_price = $exists['products_price'];

	$specials_price = $products_price * 0.9;
  $day = '31';
  $month = '07';
  $year = '2007';

  //TotalB2B start
	$checkbox_customers_groups = 'false';
  $customers_groups = 'false';
	if ($checkbox_customers_groups == false) $customers_groups = 0;
	$checkbox_customers = 'false';
  $customers = '';
	if ($checkbox_customers == false) $customers = 0;
  //TotalB2B end

	$expires_date = '';
	if (tep_not_null($day) && tep_not_null($month) && tep_not_null($year)) {
		$expires_date = $year;
		$expires_date .= (strlen($month) == 1) ? '0' . $month : $month;
		$expires_date .= (strlen($day) == 1) ? '0' . $day : $day;
	}

  //TotalB2B start
	tep_db_query("insert into " . TABLE_SPECIALS . " (products_id, specials_new_products_price, specials_date_added, expires_date, status, customers_groups_id, customers_id) values ('" . (int)$products_id . "', '" . tep_db_input($specials_price) . "', now(), '" . tep_db_input($expires_date) . "', '1', ".(int)$customers_groups.", ".(int)$customers.")");
  //TotalB2B end

}

echo 'Skonczylem ...<br><br>';

echo '<a href=index.php>Kliknij tutaj</a>';

?>