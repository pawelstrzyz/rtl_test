<?php
/*
  Copyright (c) 2001-2007 AllPay
  Requires PHP 4.1.0 or above.
  Author: AllPay
*/


require_once "./includes/configure.php";
//session_start();


$b = array();
if(!$link = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD))
	$b[]=1;
if(!mysql_select_db(DB_DATABASE, $link))
	$b[]=2;
	
$osCsid = substr($_POST["osCsid"], 0, 32);
$osCsid = mysql_real_escape_string($osCsid, $link);	
	
$t= time();
$z = "UPDATE sessions SET expiry = '".($t+1500)."' WHERE sesskey LIKE '".$osCsid."'";
if(!mysql_query($z, $link))
  $b[]=3;
mysql_close($link);
if(count($b) > 0)
  exit("blad: " . $b[0]);


include('includes/application_top.php');


if (in_array($_POST['t_status'], array('0','1','2'))) {
	$e=array();
	if ($_POST['id'] != MODULE_PAYMENT_ALLPAY_ID)
		$e[]=1;
	if (strlen($_POST['t_id'])<5)
		$e[]=3;
	$orginal_amount = $_POST['orginal_amount'];
	$tab = explode(" ", $orginal_amount);
	$orginal_amount = $tab[0];
	if (round($orginal_amount,2) != round($_SESSION['allpay_amount'], 2))
		$e[]=2;
	if ($_POST['control'] != $_POST['control'])
		$e[]=4;
	$aptid="Transakcja AllPay" . " numer: " . $_POST['t_id'];
	$m5 = MODULE_PAYMENT_ALLPAY_URLCPIN . ':' . MODULE_PAYMENT_ALLPAY_ID . ':' . $_SESSION['AP_CONTROL'] . ':' . $_POST['t_id'] .
    		':' . $_POST['amount'] . ':' . $_POST['email'] . ':' . $_POST['service'] . ':' . $_POST['code'] . ':' . $_POST['username'] .
			':' . $_POST['password'] . ':' . $_POST['t_status'];
	if (md5($m5) != $_POST['md5'])
		$e[]=5;
	if ($_SESSION['cart']->contents == "")
		$e[]=6;
	@ob_end_flush();
	if (count($e)!=0) {
		print "AP-OSC PROBLEM: $e[0]";
    	exit;
	}
	else {
		print "OK";
		$mf = file("checkout_process.php");
		$mf[0] = "";
		foreach($mf as $l=>$d) {
			if (strpos($d,"application_top.php")) {
				$mf[$l] = "";
				break;
			}
		}
		foreach($mf as $d)
			$mcp .= $d;
		@eval($mcp);
	}
}
else
	print "OK";

exit;
	
?>
