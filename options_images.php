<?php
/*
  $Id: options_images.php,v 1.0 2003/08/18 

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

?>
<table border="0" cellspacing="0" cellpadding="2">
	<tr>
    <td class="main" colspan="2">
		<?php  echo TEXT_PRODUCT_OPTIONS; ?>
		</td>
	</tr>

	<?php
	$products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name, popt.products_options_images_enabled from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_name");
	while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
		$products_options_array = array();
		$products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pov.products_options_values_thumbnail, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "'" . " order by pa.products_options_sort_order, pov.products_options_values_name");
		while($products_options = tep_db_fetch_array($products_options_query)){
			$products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name'], 'thumbnail' => $products_options['products_options_values_thumbnail']);
			if ($products_options['options_values_price'] != '0') {
				$products_options_array[sizeof($products_options_array)-1]['text'] .= '(' . $products_options['price_prefix'] . $currencies->display_price($products_options['products_options_values_id'], $products_options['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .') ';
			}
		}
				
		if (isset($cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']])) {
			$selected_attribute = $cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']];
		} else {
			$selected_attribute = false;
		}

		?>
 
		<tr>
			<td class="main" valign="top">
				<?php
				echo $products_options_name['products_options_name'] . ':';
      	if (OPTIONS_IMAGES_CLICK_ENLARGE == 'true') echo '<br><i>'.TEXT_CLICK_TO_ENLARGE.'</i>';
				?>
			</td>
    
				<?php
				if ($products_options_name['products_options_images_enabled'] == 'false'){
					echo '<td class="main">' . tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute, "onChange=\"showPrice(this.form);\"") . '</td></tr>';
				} else {
					$count=0;
					$check=0;
					echo '<td class="main"><table><tr>';
					foreach ($products_options_array as $opti_array){
						echo '<td><table cellspacing="1" cellpadding="0" border="0">';
						if (OPTIONS_IMAGES_CLICK_ENLARGE == 'true')
						echo '<td align="center"><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_OPTIONS_IMAGES_POPUP, 'oID=' . $opti_array['id']) .'\')">' . tep_image(DIR_WS_IMAGES . '' . $opti_array['thumbnail'], $opti_array['text'], OPTIONS_IMAGES_WIDTH, OPTIONS_IMAGES_HEIGHT) . '</a></td></tr>';
						else echo '<tr><td align="center">' . tep_image(DIR_WS_IMAGES . '' . $opti_array['thumbnail'], $opti_array['text'], OPTIONS_IMAGES_WIDTH, OPTIONS_IMAGES_HEIGHT) . '</td></tr>';
						$opis = podziel($opti_array['text']);
						echo '<tr><td class="main" align="center">' . $opis  . '</td></tr>';
					  if ($check==0) {
					    $checked = 'checked';
						} else {
							$checked = '';
						}
						echo '<tr><td align="center"><label>'.tep_draw_radio_field('id[' . $products_options_name['products_options_id'] . ']', $opti_array['id'], $checked, 'onClick="showPrice(this.form);" price="' .$opti_array['text']. '"').'</label></td></tr></table></td>';
						$count++;
						$check++;
						if ($count%OPTIONS_IMAGES_NUMBER_PER_ROW == 0) {
							echo '</tr><tr>';
							$count = 0;
						}
					}
					echo '</table>';
				}
				?>
      </td>
		</tr>
	<?php
  }
?>
</table>
