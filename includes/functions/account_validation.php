<?php
/*
  $Id: account_validation.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2006 osCommerce

  Released under the GNU General Public License
*/

////
// This function validates the created profile
// search engine spiders will not know what to do here, so you will not have automatic profiles from them
  function gen_reg_key(){
	$key = '';
	$chars = array('a','b','c','d','e','f','g','h','i','j', 'k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	$count = count($chars) - 1;
	
	srand((double)microtime()*1000000);
	for($i = 0; $i < ENTRY_VALIDATION_LENGTH; $i++){
	  $key .= $chars[rand(0, $count)];
	}
	
// Replace 'O' with 'Z' to avoid confused with numeric '0'	
	$key = str_replace('O', 'Z', strtoupper($key));
    return($key);
  }
?>