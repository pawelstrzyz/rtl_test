<?php
/*
  $Id: \includes\boxes\currencies.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

if (substr(basename($PHP_SELF), 0, 8) != 'checkout') {
  if (isset($currencies) && is_object($currencies)) {

    $boxHeading = BOX_HEADING_CURRENCIES;
    $corner_left = 'rounded';
    $corner_right = 'rounded';

    $box_base_name = 'currencies'; // for easy unique box template setup (added BTSv1.2)
    $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

	$boxContent_attributes = ' align="center"';

    reset($currencies->currencies);
    $currencies_array = array();
    while (list($key, $value) = each($currencies->currencies)) {
      $currencies_array[] = array('id' => $key, 'text' => $value['title']);
    }

    $hidden_get_variables = '';
    reset($HTTP_GET_VARS);
    while (list($key, $value) = each($HTTP_GET_VARS)) {
      if ( ($key != 'currency') && ($key != tep_session_name()) && ($key != 'x') && ($key != 'y') ) {
        $hidden_get_variables .= tep_draw_hidden_field($key, $value);
      }
    }

    $boxContent = tep_draw_form('currencies', tep_href_link(basename($PHP_SELF), '', $request_type, false), 'get');

    $boxContent .= tep_draw_pull_down_menu('currency', $currencies_array, $currency, 'onChange="this.form.submit();"');
    $boxContent .= $hidden_get_variables;
    $boxContent .= tep_hide_session_id();
    $boxContent .= '</form>';

   include (bts_select('boxes', $box_base_name)); // BTS 1.5

  $boxContent_attributes = '';
  }
}
?>