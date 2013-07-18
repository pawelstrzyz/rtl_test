<?php
/*
  $Id: configuration_cache_read.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

  $config_cache_file = 'tmp/config_cache.php';              // this should be to a file in a folder *outside* of your webroot with 777 permissions.
//  $config_cache_file = '';              // this should be to a file in a folder *outside* of your webroot with 777 permissions.

  $config_cache_read = false;
  if (isset($config_cache_file) && $config_cache_file != '') {
    if (file_exists($config_cache_file)) {
      include($config_cache_file);
      $config_cache_read = true;
    }
  }

  if ($config_cache_read == false) {
    $configuration_query = tep_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
    while ($configuration = tep_db_fetch_array($configuration_query)) {
      define($configuration['cfgKey'], $configuration['cfgValue']);
    }
  }

?>