<?php
/*
  $Id: \includes\boxes\themes.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

    $boxHeading = BOX_HEADING_THEMES;
    $corner_left = 'rounded';
    $corner_right = 'rounded';
    $box_base_name = 'themes'; // for easy unique box template setup (added BTSv1.2)
    $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)
    $boxContent_attributes = ' align="center"';

    if(file_exists(DIR_WS_TEMPLATES_BASE . 'get_themes.php')) require(DIR_WS_TEMPLATES_BASE . 'get_themes.php');
    //$boxContent = tep_draw_form('themes', tep_href_link(basename($PHP_SELF), '', $request_type, false), 'get');
    $boxContent = tep_draw_form('themes', tep_href_link(basename($PHP_SELF), tep_get_all_get_params(), $request_type, false), 'get');
    //$boxContent .= tep_hidden_all_get_params();

    $tmpl_name=explode ( '/', $tplDir);
    $boxContent .= tep_draw_pull_down_menu('tplDir', get_themes(), $tmpl_name[1], 'onChange="this.form.submit();"');
    $boxContent .= '</form>';

// bof BTSv1.2
    if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.tpl.php')) {
    // if exists, load unique box template for this box from templates/boxes/
        require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.tpl.php');
    }
    else {
    // load default box template: templates/boxes/box.tpl.php
        require(DIR_WS_BOX_TEMPLATES . TEMPLATENAME_BOX);
    }
// eof BTSv1.2

  $boxContent_attributes = '';

?>