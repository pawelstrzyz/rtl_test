<?php
/*
  $Id: products_next_previous.php 1 2007-12-20 23:52:06Z $
  
  by: Linda McGrath osCommerce@WebMakers.com,
  Nirvana, Yoja, Joachim de Boer, Wheeloftime,
  dAbserver, Skylla
  
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

			    if (isset($HTTP_GET_VARS['manufacturers_id'])) { 
                $products_ids = tep_db_query("select p.products_id from " . TABLE_PRODUCTS . " p where p.products_status = '1'  and p.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'");
				$category_name_query = tep_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'");
				$category_name_row = tep_db_fetch_array($category_name_query);
				$prev_next_in = PREV_NEXT_MB . '&nbsp;' . ($category_name_row['manufacturers_name']);
				$fPath = 'manufacturers_id=' . (int)$HTTP_GET_VARS['manufacturers_id'];
                } else {
				if (!$current_category_id) {
					$cPath_query = tep_db_query ("SELECT categories_id FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " WHERE products_id ='" .  (int)$HTTP_GET_VARS['products_id'] . "'");
					$cPath_row = tep_db_fetch_array($cPath_query);
					$current_category_id = $cPath_row['categories_id'];
				}
				$products_ids = tep_db_query("select p.products_id from " . TABLE_PRODUCTS . " p FORCE INDEX(products_status) , " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc where p.products_status = '1'  and p.products_id = ptc.products_id and ptc.categories_id = $current_category_id");
				$category_name_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = $current_category_id AND language_id = $languages_id");
				$category_name_row = tep_db_fetch_array($category_name_query);
				$prev_next_in = PREV_NEXT_CAT . '&nbsp;' . ($category_name_row['categories_name']);
				$fPath = 'cPath=' . $cPath;
				}
				while ($product_row = tep_db_fetch_array($products_ids)) {
					$id_array[] = $product_row['products_id'];
				}
				// calculate the previous and next
         		reset ($id_array);
				$counter = 0;
				while (list($key, $value) = each ($id_array)) {
					if ($value == (int)$HTTP_GET_VARS['products_id']) {
						$position = $counter;
						if ($key == 0)
							$previous = -1; // it was the first to be found
						else
							$previous = $id_array[$key - 1];

						if ($id_array[$key + 1])
							$next_item = $id_array[$key + 1];
						else {
							$next_item = $id_array[0];
						}
					}
					$last = $value;
					$counter++;
				}
				if ($previous == -1)
					$previous = $last;
?>

<tr>
  <td>  
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
      <tr>
	    <td align="left" class="main" valign="middle" width="80">
      <? if (($counter != 1) && ($position != 0)) {
       echo ('<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, "$fPath&products_id=$previous") . '">' .  tep_image_button('button_prev.gif', PREV_NEXT_ALT_PREVIOUS) . '</a>');
       } else {
       echo '&nbsp;';
       } ?>
      </td>
      <td align="center" class="main" valign="middle"><?php echo (PREV_NEXT_PRODUCT) . '&nbsp;' . ($position+1 . '&nbsp;' . PREV_NEXT_OF . '&nbsp;' . $counter) . '&nbsp;' . $prev_next_in; ?></td>
		  <td align="right" class="main" valign="middle" width="80">
      <? if (($counter !=1) && (($position+1) != $counter)) {
       echo ('<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, "$fPath&products_id=$next_item") . '">' . tep_image_button('button_next.gif', PREV_NEXT_ALT_NEXT) . '</a>');
       } else {
       echo '&nbsp;';
       } ?>
       </td>
      </tr>
  </table>	
  </td>
</tr>