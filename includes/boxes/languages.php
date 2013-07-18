<?php
/*
  $Id: \includes\boxes\languages.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
if (substr(basename($PHP_SELF), 0, 8) != 'checkout') {
  $boxHeading = BOX_HEADING_LANGUAGES;
  $corner_left = 'rounded';
  $corner_right = 'rounded';
  $boxContent_attributes = ' align="center"';

  $box_base_name = 'languages'; // for easy unique box template setup (added BTSv1.2)
  $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

  if (!isset($lng) || (isset($lng) && !is_object($lng))) {
    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language;
  }

  $boxContent = '';

  $i=0;
  reset($lng->catalog_languages);
  while (list($key, $value) = each($lng->catalog_languages)) {
    $boxContent .= ' <a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('language', 'currency')) . 'language=' . $key, $request_type) . '">' . tep_image(DIR_WS_LANGUAGES .  $value['directory'] . '/images/' . $value['image'], $value['name']) . '</a> ';
    $i++;
    if ($i == 10) {
      $boxContent .= '<br>';
    }
  }
  include (bts_select('boxes', $box_base_name)); // BTS 1.5

  $boxContent_attributes = '';
}
?>