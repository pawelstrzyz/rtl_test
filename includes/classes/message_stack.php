<?php
/*
  $Id: message_stack.php 44 2008-02-01 15:52:19Z jmk $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License

 mod eSklep-Os http://www.esklep-os.com

  Example usage:

  $messageStack = new messageStack();
  $messageStack->add('general', 'Error: Error 1', 'error');
  $messageStack->add('general', 'Error: Error 2', 'warning');
  if ($messageStack->size('general') > 0) echo $messageStack->output('general');
*/

  class messageStack extends tableBox {

// class constructor
    function messageStack() {
      global $messageToStack;

      $this->messages = array();

      if (tep_session_is_registered('messageToStack')) {
        for ($i=0, $n=sizeof($messageToStack); $i<$n; $i++) {
          $this->add($messageToStack[$i]['class'], $messageToStack[$i]['text'], $messageToStack[$i]['type']);
        }
        tep_session_unregister('messageToStack');
      }
    }

// class methods
    function add($class, $message, $type = 'error') {

	  $liczba = rand(1,10000);
	  $okno = '<div id="pop_window' . $liczba . '" style="position:absolute; top:50%; left:50%; margin-left:-175px; margin-top:-90px; font-size:20px; z-index:1000">
			   <table bgcolor="white" style="border:1px; border-style:solid; border-color:#ff6600;" width="350px" height="180px" cellpadding="5" cellspacing="0" ><tr><td bgcolor="#ffffff" align="center">
			   <table width="98%" border="0" cellpadding="0" cellspacing="0"><tr><td width="50%" align="left" style="font: bold 13px tahoma,arial, sans-serif; color:#616161">UWAGA</td><td width="50%" align="right" style="font: bold 13px tahoma,arial, sans-serif; color:#616161">
			   <span tabindex="0" style="cursor:pointer" onclick="document.getElementById(\'pop_window' . $liczba . '\').innerHTML = \'\'">X</span></td></tr></table></td></tr><tr><td>				
			   <center><p style="font: bold 20px tahoma,arial, sans-serif; color:#ff6600">' . TEXT_KOMUNIKAT . '</p></center>				
			   <center><p style="font: normal 13px tahoma,arial, sans-serif; color:#616161">' . $message . '</p></center>				
			   <form name="duppp' . $liczba . '">
			   <input type="button" name="zamknij" value="' . TEXT_ZAMKNIJ . '" onclick="document.getElementById(\'pop_window' . $liczba . '\').innerHTML = \'\'">
			   </form>
			   </td></tr></table>
			   </div>';	
	
      if ($type == 'error') {
        $this->messages[] = array('params' => '', 'class' => $class, 'text' => $okno);
      } elseif ($type == 'warning') {
        $this->messages[] = array('params' => '', 'class' => $class, 'text' => $okno);
      } elseif ($type == 'success') {
        $this->messages[] = array('params' => '', 'class' => $class, 'text' => $okno);
      } else {
        $this->messages[] = array('params' => '', 'class' => $class, 'text' => $okno);
      }
    }	

    function add_session($class, $message, $type = 'error') {
      global $messageToStack;

      if (!tep_session_is_registered('messageToStack')) {
        tep_session_register('messageToStack');
        $messageToStack = array();
      }

      $messageToStack[] = array('class' => $class, 'text' => $message, 'type' => $type);
    }

    function reset() {
      $this->messages = array();
    }

    function output($class) {
      $this->table_data_parameters = 'class="messageBox"';
	  $this->table_cellpadding = '0';	  

      $output = array();
      for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
        if ($this->messages[$i]['class'] == $class) {
          $output[] = $this->messages[$i];
        }
      }
      return $this->tableBox($output);
    }

    function size($class) {
      $count = 0;

      for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
        if ($this->messages[$i]['class'] == $class) {
          $count++;
        }
      }

      return $count;
    }
  }
?>
