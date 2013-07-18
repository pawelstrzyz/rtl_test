<?php
/*
  $Id: platnosci_validation.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  Autor: Platnosci.pl <oscommerce@platnosci.pl>
  http://www.platnosci.pl
*/
  class platnosci_validation {
    var $payback_login;

    function validate($login) {
    $this->payback_login = $login;
      if (!empty($this->payback_login) && !eregi("^[0-9a-zA-Z_-]*$", $this->payback_login)) return -1;
      return $this->is_valid();
    }

    function is_valid() {
      return true;
    }

  }
?>