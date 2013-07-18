<?php
/*
  $Id: \includes\boxes\best_sellers.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

  if (isset($current_category_id) && ($current_category_id > 0)) {
    $best_sellers_query = tep_db_query("select distinct p.products_id, pd.products_name, p.products_image from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_status = '1' and c.categories_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and '" . (int)$current_category_id . "' in (c.categories_id, c.parent_id) order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);
 } else {
    $best_sellers_query = tep_db_query("select distinct p.products_id, pd.products_name, p.products_image from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c  where p.products_status = '1' and c.categories_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);  }

  if (tep_db_num_rows($best_sellers_query) >= MIN_DISPLAY_BESTSELLERS) {
   $boxHeading = BOX_HEADING_BESTSELLERS;
   $corner_left = 'rounded';
   $corner_right = 'rounded';

   $box_base_name = 'best_sellers'; // for easy unique box template setup (added BTSv1.2)

   $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)
   $boxContent_attributes = 'align="center"';

   $rows = 0;
   $szerokosc = SMALL_IMAGE_WIDTH + 6;
   $wysokosc = SMALL_IMAGE_HEIGHT + 7;

   $boxContent = '<marquee behavior="scroll"
                        direction="up"
                        height="250"
                        width="150"
                        scrollamount="1"
                        scrolldelay="30"
                        truespeed="true" onmouseover="this.stop()" onmouseout="this.start()">';


   while ($best_sellers = tep_db_fetch_array($best_sellers_query)) {
    $rows++;

   $boxContent .= '<table border="0" cellspacing="0" cellpadding="1" align="center">';
    $boxContent .= '<tr><td align="center">';
    $boxContent .= '<table border="0" cellpadding="2" cellspacing="0" width="100%"><tr><td align="center">';
    $boxContent .= '<div style="width: '.$szerokosc.'px; height: '.$wysokosc.'px; padding: 0px 0px;"><table border="0" cellpadding="0" cellspacing="0"><tr>';
    $boxContent .= '<td class="tbox1"></td>';
    $boxContent .= '<td class="tbox2"></td>';
    $boxContent .= '<td class="tbox3"></td>';
    $boxContent .= '</tr><tr>';
    $boxContent .= '<td class="tbox4"></td>';
    $boxContent .= '<td class="tbox5" align="center" valign="middle" height="'.SMALL_IMAGE_HEIGHT.'"  width="'.SMALL_IMAGE_WIDTH.'">';

    $boxContent .= '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $best_sellers['products_image'], $best_sellers['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>';

    $boxContent .= '</td><td class="tbox6"></td>';
    $boxContent .= '</tr><tr>';
    $boxContent .= '<td class="tbox7"></td>';
    $boxContent .= '<td class="tbox8"></td>';
    $boxContent .= '<td class="tbox9"></td>';
    $boxContent .= '</tr></table></div>';

    $boxContent .= '</td></tr></table></td></tr>';
    $boxContent .= '<tr><td class="boxContents" align="center"><a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id']) . '">' . osc_trunc_string($best_sellers['products_name'], 50, 1) . '</a></td></tr><tr><td>'.tep_draw_separator('pixel_trans.gif', '100%', '5').'</td></tr>';

  $boxContent .= '</table>';
  }

  $boxContent .= '</marquee>';

  include (bts_select('boxes', $box_base_name)); // BTS 1.5

  $boxLink = '';
  $boxContent_attributes = '';

  }

?>