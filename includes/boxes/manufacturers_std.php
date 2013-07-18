<?php
/*
  $Id: \includes\boxes\manufacturers.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

  $manufacturers_query = tep_db_query("select distinct m.manufacturers_id, m.manufacturers_name from " . TABLE_MANUFACTURERS . " m left join " . TABLE_PRODUCTS . " p on m.manufacturers_id = p.manufacturers_id left join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c on p.products_id = p2c.products_id left join " . TABLE_CATEGORIES . " c on p2c.categories_id = c.categories_id where c.categories_status = '1' and p.products_status = '1' order by m.manufacturers_name");
  if ($number_of_rows = tep_db_num_rows($manufacturers_query)) {
    $boxHeading = BOX_HEADING_MANUFACTURERS;
    $corner_left = 'rounded';
    $corner_right = 'rounded';

    $box_base_name = 'manufacturers'; // for easy unique box template setup (added BTSv1.2)
    $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

	if ($number_of_rows <= MAX_DISPLAY_MANUFACTURERS_IN_A_LIST) {

// Display a list

      $boxContent = '';
      while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {

        $manufacturers_name = ((strlen($manufacturers['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? substr($manufacturers['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' : $manufacturers['manufacturers_name']);
        if (isset($HTTP_GET_VARS['manufacturers_id']) && ($HTTP_GET_VARS['manufacturers_id'] == $manufacturers['manufacturers_id'])) $manufacturers_name = '<b>' . $manufacturers_name .'</b>';
        $boxContent .= '<a class="boxLink" href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manufacturers['manufacturers_id']) . '">' . $manufacturers_name . '</a><br>';

      }

      $boxContent = substr($boxContent, 0, -4);

    } else {

// Display a drop-down

      $manufacturers_array = array();

      if (MAX_MANUFACTURERS_LIST < 2) {
        $manufacturers_array[] = array('id' => '', 'text' => PULL_DOWN_DEFAULT);
      }

      while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {

        $manufacturers_name = ((strlen($manufacturers['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? substr($manufacturers['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' : $manufacturers['manufacturers_name']);

        $manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
                                       'text' => $manufacturers_name);
      }

      $boxContent = '<center>'.tep_draw_form('manufacturers', tep_href_link(FILENAME_DEFAULT, '', 'NONSSL', false), 'get');

      $boxContent .= tep_draw_pull_down_menu('manufacturers_id', $manufacturers_array, (isset($HTTP_GET_VARS['manufacturers_id']) ? $HTTP_GET_VARS['manufacturers_id'] : ''), 'onChange="this.form.submit();" size="' . MAX_MANUFACTURERS_LIST . '"');

      $boxContent .= tep_hide_session_id();
      $boxContent .= '</form></center>';
    }

    include (bts_select('boxes', $box_base_name)); // BTS 1.5
  }

?>