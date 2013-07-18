<?php
/*
  $Id: \includes\boxes\languages.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

  $boxHeading = BOX_HEADING_ADVERTISE;
  $corner_left = 'rounded';
  $corner_right = 'rounded';
  $boxContent_attributes = ' align="center"';

  $box_base_name = 'banners'; // for easy unique box template setup (added BTSv1.2)
  $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

  if (!isset($lng) || (isset($lng) && !is_object($lng))) {
    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language;
  }

  $boxContent = '';

    if ($banner = tep_banner_exists('dynamic', 'lewa_kolumna')) {
      $boxContent .= '<table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td align="center">';
      $boxContent .= tep_display_banner('static', $banner);
      $boxContent .= '</td></tr></table>';
    }

  include (bts_select('boxes', $box_base_name)); // BTS 1.5

  $boxContent_attributes = '';

?>