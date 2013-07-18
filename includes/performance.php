<?php
/*
  $Id: performance.php 1 2007-12-20 23:52:06Z  $
  orig : performance.php,v 1.5 2004/11/21 00:04:53 Chemo Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

  if (DISPLAY_PAGE_PARSE_TIME == 'true') {
    $time_start = explode(' ', PAGE_PARSE_START_TIME);
    $time_end = explode(' ', microtime());
    $parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
    echo '<div align="center"><span class="smallText">Current Parse Time: <b>' . $parse_time . ' s</b> with <b>' . sizeof($debug['QUERIES']) . ' queries</b></span></div>';
    if (DISPLAY_QUERIES == 'true') {
      echo '<b>QUERY DEBUG:</b> ';
      print_array($debug);
      echo '<hr>';
      echo '<b>SESSION:</b> ';
      print_array($_SESSION);
      echo '<hr>';
      echo '<b>COOKIE:</b> ';
      print_array($_COOKIE);
      echo '<b>POST:</b> ';
      print_array($_POST);
      echo '<hr>';
      echo '<b>GET:</b> ';
      print_array($_GET);
    } # END if request
  }
  unset($debug);
?>
