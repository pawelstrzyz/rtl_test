<?php
/*
  $Id: \includes\boxes\manufacturer_info.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

  if (isset($HTTP_GET_VARS['products_id'])) {
    $manufacturer_query = tep_db_query("select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on (m.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$languages_id . "'), " . TABLE_PRODUCTS . " p  where p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and p.manufacturers_id = m.manufacturers_id");

    if (tep_db_num_rows($manufacturer_query)) {
      $manufacturer = tep_db_fetch_array($manufacturer_query);

      $boxHeading = BOX_HEADING_MANUFACTURER_INFO;
      $corner_left = 'rounded';
      $corner_right = 'rounded';
      $box_base_name = 'manufacturer_info'; // for easy unique box template setup (added BTSv1.2)
	  $szerokosc = SMALL_IMAGE_WIDTH+10;
      $wysokosc = SMALL_IMAGE_HEIGHT+10;

      $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

      $boxContent = '<table border="0" width="100%" cellspacing="0" cellpadding="1">';

      if (tep_not_null($manufacturer['manufacturers_image'])) {
		$boxContent .= '<tr><td align="center" class="boxContents" colspan="3"><table class="dia" cellpadding="0" cellspacing="0" width="'.$szerokosc.'" height="'.$wysokosc.'">';
		$boxContent .= '<tr><td>';
        $boxContent .= tep_image(DIR_WS_IMAGES . $manufacturer['manufacturers_image'], $manufacturer['manufacturers_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
		$boxContent .= '</td></tr></table></td></tr>';
	  }
      if (tep_not_null($manufacturer['manufacturers_url'])) {
		  $boxContent .= '<tr><td align="center" width="12%">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" align="left" width="88%"><a class="boxLink" href="' . tep_href_link(FILENAME_REDIRECT, 'action=manufacturer&manufacturers_id=' . $manufacturer['manufacturers_id']) . '" target="_blank">' . sprintf(BOX_MANUFACTURER_INFO_HOMEPAGE, $manufacturer['manufacturers_name']) . '</a></td></tr>';
			$boxContent .= '<tr><td align="center" width="100%" colspan="2">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</td></tr>';
		}

      $boxContent .= '<tr><td align="center" width="20">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents"><a class="boxLink" href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manufacturer['manufacturers_id']) . '">' . BOX_MANUFACTURER_INFO_OTHER_PRODUCTS . '</a></td></tr></table>';
	  
	  include (bts_select('boxes', $box_base_name)); // BTS 1.5

    }
  }

?>