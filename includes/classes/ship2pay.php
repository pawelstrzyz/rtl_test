<?php
/*
  $Id: ship2pay.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 Edwin Bekaert (edwin@ednique.com)

  Released under the GNU General Public License

  http://forums.oscommerce.com/index.php?showtopic=36112
  
  http://www.oscommerce.com/community/contributions,1042

 mod eSklep-Os http://www.esklep-os.com
*/

////
// Class to handle links between shipping and payment

  class ship2pay {
    var $modules;

// class constructor
    function ship2pay() {
      global $language, $PHP_SELF,$shipment,$GLOBALS;
      $this->modules = array();
      $q_ship2pay = tep_db_query("SELECT shipment, payments_allowed FROM ".TABLE_SHIP2PAY." where status=1");
      while ($mods = tep_db_fetch_array($q_ship2pay)) {
        $this->modules[$mods['shipment']] = $mods['payments_allowed'];
      }
    }
    
    function get_pay_modules($ship_module){
      return $this->modules[$ship_module];
    }
   }
?>
