<?php
/*
  $Id: \includes\boxes\best_sellers.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
	if (isset($current_category_id) && ($current_category_id > 0)) {
			$best_sellers_query = tep_db_query("select distinct p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_status = '1' and c.categories_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and '" . (int)$current_category_id . "' in (c.categories_id, c.parent_id) order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);
	} else {
			$best_sellers_query = tep_db_query("select distinct p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c  where p.products_status = '1' and c.categories_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS);  
	}

	if (tep_db_num_rows($best_sellers_query) >= MIN_DISPLAY_BESTSELLERS) {
		 $boxHeading = BOX_HEADING_BESTSELLERS;
		 $corner_left = 'rounded';
		 $corner_right = 'rounded';

		 $box_base_name = 'best_sellers'; // for easy unique box template setup (added BTSv1.2)

		 $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

		 $rows = 0;

		 $boxContent = '<table border="0" width="100%" cellspacing="0" cellpadding="1">';

		 while ($best_sellers = tep_db_fetch_array($best_sellers_query)) {
			$rows++;
			$boxContent .= '<tr><td align="center" width="12%">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="boxContents" align="left" width="88%"><a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id']) . '">' . osc_trunc_string($best_sellers['products_name'], 50, 1) . '</a></td></tr>';
			$boxContent .= '<tr><td align="center" width="100%" colspan="2">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</td></tr>';
		 }

		 $boxContent .= '</table>';

		 include (bts_select('boxes', $box_base_name)); // BTS 1.5
	}
?>