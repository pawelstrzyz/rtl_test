<?php
/*
$Id: \templates\standard\content\product_info.tpl.php; 30.06.2006

 mod eSklep-Os http://www.esklep-os.com

Licencja: GNU General Public License
*/



?>

<script type="text/javascript" src="includes/javascript/prototype/prototype.js"></script>
<script type="text/javascript" src="includes/javascript/prototype/effects.js"></script>
<script type="text/javascript" src="includes/javascript/prototype/window.js"></script>
<script type="text/javascript" src="includes/javascript/prototype/window_effects.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo (bts_select('stylesheet','themes/default.css')); // BTSv1.5 ?>">
<link rel="stylesheet" type="text/css" href="<?php echo (bts_select('stylesheet','themes/spread.css')); // BTSv1.5 ?>">

<table border="0" width="100%" cellspacing="0" cellpadding="0">

	<?php
	// Brak produktow BOF
	///////////////////////////////////////////////////////////////////////////////
	if ($product_check['total'] < 1) {
	?>

	<tr>
		<td><h3><?php new infoBox(array(array('text' => TEXT_PRODUCT_NOT_FOUND))); ?></h3></td>
	</tr>
	<tr>
		<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	</tr>

	<tr>
		<td>
			<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
				<tr class="infoBoxContents">
					<td>
						<table border="0" width="100%" cellspacing="0" cellpadding="2">
							<tr>
								<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
								<td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
								<td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<?php
	///////////////////////////////////////////////////////////////////////////////
	// Brak produktow EOF

	} else {

	$product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, p.products_image_pop, pd.products_url, p.products_price, p.products_retail_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id,  p.products_availability_id, p.products_maxorder  from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);

	tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and language_id = '" . (int)$languages_id . "'");

	//TotalB2B start
	$product_info['products_price'] = tep_xppp_getproductprice($product_info['products_id']);
	//TotalB2B end
	
    if (DISPLAY_PRICE_BRUTTO_NETTO == 'true') {
	    $display_nb = 1;
	  } else {
	    $display_nb = 0;
    }	

	if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
		//TotalB2B start
		$query_special_prices_hide_result = SPECIAL_PRICES_HIDE;
		if ($query_special_prices_hide_result== 'true') {
			$products_price = '<span class="Cena" id="nowaCena">' .$currencies->display_price($product_info['products_id'],$product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb) . '';
			$nuPrice = $currencies->display_price($product_info['products_id'],$product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])). '</span>';
			$vat_stawka = tep_get_tax_rate($product_info['products_tax_class_id']);
		} else {
			$products_price = '<span class="SmallPriceProduct"><s>'.$currencies->display_price_nodiscount($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s></span><br><span class="productSpecialPrice" id="nowaCena">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb) . '</span>';
			$nuPrice = $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id']));
			$vat_stawka = tep_get_tax_rate($product_info['products_tax_class_id']);
		}
		//TotalB2B end
	} else {
		$products_price = '<span class="Cena" id="nowaCena">' .$currencies->display_price($product_info['products_id'], $product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']),1,$display_nb). '</span>';
		$nuPrice = $currencies->display_price($product_info['products_id'], $product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
		$vat_stawka = tep_get_tax_rate($product_info['products_tax_class_id']);
	}

	$tysiac = trim($currencies->currencies[$currency]['thousands_point']);
	if ($tysiac !='') {
		$nuPrice = str_replace($tysiac, "", $nuPrice);
	}
	$decimal = trim($currencies->currencies[$currency]['decimal_point']);
	if ($decimal !='.') {
		$nuPrice = str_replace($decimal, ".", $nuPrice);
	}
	if (tep_not_null($product_info['products_model'])) {
		//$products_name = '' . $product_info['products_name'] . '<br><span class="smallText">[' . $product_info['products_model'] . ']</span>';
		$products_name = '' . $product_info['products_name'] . '';
	} else {
		$products_name = '' . $product_info['products_name'] . '';
	}

	$products_availability = $product_info['products_availability_id'];
    $products_availability_info_query = tep_db_query("select e.products_availability_name from " . TABLE_PRODUCTS_AVAILABILITY . " e where e.products_availability_id = '" . (int)$products_availability . "' and e.language_id = '" . (int)$languages_id . "'");
    $products_availability_info = tep_db_fetch_array($products_availability_info_query);
	$products_availability_name = $products_availability_info['products_availability_name'];

	$the_manufacturer_query = tep_db_query("select m.manufacturers_id, m.manufacturers_name from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on (m.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$languages_id . "'), " . TABLE_PRODUCTS . " p  where p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and p.manufacturers_id = m.manufacturers_id");
	$the_manufacturers = tep_db_fetch_array($the_manufacturer_query);

	?>

 <!-- Naglowek BOF -->
	<tr>  
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="22" height="40"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo HEADING_PRODUCT_INFO; ?></td>
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_right.gif" border="0" alt="" width="16" height="40"></td>
	</tr> 
 </table></td>
      </tr>	  
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
     <!-- Naglowek EOF -->
    
    	<?php
    	// BOF: WebMakers.com Added: Show Category and Image /////////////////////////
    	if (SHOW_CATEGORIES=='1') {
    		?>
    		<tr>
    			<td colspan="2">
    				<table align="right">
    					<tr>
    						<td class="main" align="center"><?php echo tep_image(DIR_WS_IMAGES . tep_get_categories_image(tep_get_products_catagory_id($product_info_values['products_id']))); ?></td>
    					</tr>
    					<tr>
    						<td class="main" align="center"><?php echo tep_get_categories_name(tep_get_products_catagory_id($product_info_values['products_id'])); ?></td>
    					</tr>
    				</table>
    			</td>
    		</tr>
    		<tr>
    			<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
    		</tr>
    		<?php
    	}
    	
    	// EOF: WebMakers.com Added: Show Category and Image /////////////////////////
    	?>
    	
    		<tr>
    			<td>
    			  <!-- Glowna tabela zdjecia, ceny kup, opcje ///////////////////////////-->
    				<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    					<tr class="infoBoxContents">
    						<td>
    							<table width="100%" cellspacing="0" cellpadding="0" border="0">
    								<tr>
    									<td>
    										<!-- Tabelka naglowka produktu BOF -->
    										<table border="0" cellspacing="0" cellpadding="0" width="100%">
    											<tbody>
    												<!-- Nazwa produktu BOF -->
    												<tr>
    													<td width="100%" align="left" colspan="5">
    														<table width="100%" cellspacing="0" cellpadding="2" border="0">
    															<tr>
    																<td class="ProductInfoTile"><?php echo $products_name; ?></td>
    															</tr>
    														</table>
    													</td>
    												</tr>
    												<tr>
    													<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>
    												</tr>
    												<!-- Nazwa produktu EOF -->
    	
    												<!-- Glowne zdjecie produktu oraz informacje o cenie, producencie, dostepnosci  BOF -->
    												<tr>
    													<td valign="top">
    														<table border="0" cellspacing="0" cellpadding="0" width="190">
    															<tr>
    																<!-- Zdjecie BOF -->
    	                              <?php
    																// Pobranie dodatkowych obrazkow
    																$tab_szer = DISPLAY_IMAGE_WIDTH + 20;
    																$tab_wys = DISPLAY_IMAGE_HEIGHT + 20;
    																$szerokosc = DISPLAY_IMAGE_WIDTH + 10;
    																$wysokosc = DISPLAY_IMAGE_HEIGHT + 10;
    																$img_path = DIR_WS_IMAGES;
    																?>
    																<td valign="middle" align="center">
    																	<?php
    																	// BOF Wyswietlanie obrazka glownego /////////
    																	if (tep_not_null($product_info['products_image'])) {
    																		?>
    																		<TABLE cellspacing="0" cellpadding="2" align="center" border="0" width="100%">
    																			<TR>
    																				<TD align=center>
    																					<?php require('fotoimage.php'); ?>
    																					<INPUT TYPE="hidden" NAME="current_photo_path" VALUE="">
    																					<TABLE BORDER=0 ALIGN=CENTER cellpadding="0" cellspacing="0">
    																						<TR>
    																							<TD ALIGN="CENTER" width="<?php echo $tab_szer ; ?>" height="<?php echo $tab_wys ; ?>">
    																								<?php
    																								if ($product_info[products_image] != '') { ?>
    													                                                <table class="dia" cellpadding="0" cellspacing="0" width="<?php echo $szerokosc; ?>" height="<?php echo $wysokosc; ?>">
    													                                                <tr><td>
    																										<A HREF="javascript:ShowBigPicture(current_picture)" name="big_photo_link">
    																										<IMG name="big_photo" border="0" alt="" src="<?php echo tep_obrazek(DIR_WS_IMAGES . $product_info[products_image], DISPLAY_IMAGE_WIDTH, DISPLAY_IMAGE_HEIGHT); ?>"></A>
    																									</td></tr></table>
    																								<?php } ?>
    																							</TD>
    																						</TR>
    																					</TABLE>
    																				</td>
    																			</tr>
    																		</table>
    																	<?php
    																	} // EOF Wyswietlanie obrazka glownego /////////
    																	?>
    																</td>
    															</tr>
    															<!-- Zdjecie EOF -->
    	
    														</table>
    													</td>
    	
    													<!-- Data dodania, producent, cena, przycisk kup teraz BOF -->
    													<td valign="top" height="100%" width="100%">
    														<table border="0" cellspacing="0" cellpadding="0" width="100%">
    															<tbody>
    																<?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product')); 
    																///////////// begin recently_viewed
    																if (!tep_session_is_registered('recently_viewed')) {
    																	tep_session_register('recently_viewed');
    																	$recently_viewed = $HTTP_GET_VARS['products_id'] . ';';
    																}
    																$dup_recent_viewed = 'n';
    																$recent_products = split(';',$recently_viewed);
    																foreach ($recent_products as $recent) {
    																	if ($recent == $HTTP_GET_VARS['products_id']) $dup_recent_viewed = 'y';
    																}//foreach ($recent_products as $recent) {
    																if ($dup_recent_viewed == 'n') $recently_viewed = $HTTP_GET_VARS['products_id'] . ';' . $recently_viewed ;
    																///////////// end recently_viewed
    	
    																?>
    																<tr>
    																	<td>
    																		<table border="0" cellspacing="1" cellpadding="5" width="100%" class="TableFrame">
    																			<?php
    																			// Numer katalogowy BOF ////////////////////
    																			if (tep_not_null($product_info['products_model'])) {
    																			?>
    																				<tr>
    																					<td class="ProductHead" width="50%"><B><?php echo CATALOG_NUMBER; ?></B></td>
    																					<td class="ProductHead" width="50%"><?php echo $product_info['products_model']; ?></td>
    																				</tr>
    																			<?php
    																			}
    																			// Numer katalogowy EOF ////////////////////
    	
    																			// Producent BOF ///////////////////////////
    																			if (tep_not_null($the_manufacturers['manufacturers_name'])) {
    																			?>
    																				<tr>
    																					<td class="ProductHead" width="50%"><?php echo '<b>' .BOX_HEADING_MANUFACTURER_INFO. '</b>' ?></TD>
    																					<td class="ProductHead" width="50%"><?php echo '<a class="boxLink" href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $the_manufacturers['manufacturers_id']) . '">' .$the_manufacturers['manufacturers_name'] . '</a>'; ?></TD>
    																				</TR>
    																			<?php
    																			}
    																			// Producent EOF ///////////////////////////
    	
    																			// Dostepnosc produktu BOF /////////////////
    																			if (tep_not_null($products_availability_info['products_availability_name'])) {
    																			?>
    																				<tr>
    																					<td class="ProductHead" width="50%"><B><?php echo TEXT_AVAILABILITY; ?></B></td>
    																					<td class="ProductHead" width="50%"><?php echo $products_availability_name; ?></td>
    																				</tr>
    																			<?php
    																			}
    																			// Dostepnosc produktu EOF /////////////////
    	
    																		  // Maksymalna ilosc zamawianych przedmiotow BOF
    																			//MAXIMUM quantity code
    																			if (tep_not_null($product_info['products_maxorder']) && MAXIMUM_ORDERS == 'true') {
    																				if ($product_info['products_maxorder'] > 0) {;
    																				?>
    																					<tr>
    																						<td class="ProductHead" width="50%"><b><?php echo MAXIMUM_ORDER_TEXT; ?></b></TD>
    																						<td class="ProductHead" width="50%"><?php echo ''.$product_info['products_maxorder'].''; ?></TD>
    																					</TR>
    																				<?php
    																				}
    																			}
    																			//End: MAXIMUM quantity code
    																			// Maksymalna ilosc zamawianych przedmiotow BOF
    																			?>
    																		</table>
    																	</td>
    																</tr>
    																<tr>
    																	<td><td height="1"></td>
    																</tr>
    																<!-- Cena produktu BOF ////////////////////////-->
    																<tr>
    																	<td valign="top">
    																		<TABLE cellSpacing="2" cellPadding="0" border="0" width="100%" class="TableFrame">
    																			<tbody>
    																				<TR>
    																					<TD align="center" class="main">
    																						<?php
    																						$query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;
    																						if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
    																							if ($product_info['products_price'] > 0) {
    																								include($modules_folder . 'ezier_new_fields.php');
    																							} else {
    																								echo '<b>'.TEMPORARY_NO_PRICE.'</b>' ;
    																							}
    																						} else {
    																							echo '<span class="smallText"><b>' . PRICES_LOGGED_IN_TEXT . '</b></span>';
    																						}
    																						?>
    																					</td>
    																				</TR>
    																			</tbody>
    																		</table>
    																	</td>
    																</tr>
    															</tbody>
    														</table>
    													</td>
    													<!-- Cena produktu EOF ////////////////////////-->
    												</tr>
    	
    												<!-- Dodatkowe opcje produktu BOF /////////////-->
    												<?php
    												$products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    												$products_attributes = tep_db_fetch_array($products_attributes_query);
    												if ($products_attributes['total'] > 0) {
    													if ($currencies->currencies[$currency]['symbol_right'] != '') {
    														$symbol = trim($currencies->currencies[$currency]['symbol_right']);
    														$nuPrice = eregi_replace($symbol,"",$nuPrice);
    													} elseif ($currencies->currencies[$currency]['symbol_left'] != '') {
    														$symbol = trim($currencies->currencies[$currency]['symbol_left']);
    														$nuPrice = eregi_replace($symbol,"",$nuPrice);
    													} elseif ($currencies->currencies[$currency]['symbol_left'] == '' && $currencies->currencies[$currency]['symbol_lright'] == '' ) {
    														$symbol = '';
    														$nuPrice = $nuPrice;
    													}
    													?>
    													<TR>
    														<TD align="center" class="main" valign="top" colspan="2">
    	                          	<TABLE cellSpacing="2" cellPadding="0" border="0" width="100%">
    	                            	<tr>
    	                              	<td valign="top">
    																		<input type="hidden" name="nuPrice" value="<?php echo eregi_replace($symbol,"",$nuPrice); ?>">
    																		<input type="hidden" name="vat_stawka" value="<?php echo $vat_stawka; ?>">
    																		<?php
    																		//Options as Images. This whole php clause needs to be added
    																		if (OPTIONS_AS_IMAGES_ENABLED == 'true') include ('options_images.php');
    	
    																		if (OPTIONS_AS_IMAGES_ENABLED == 'false') {
    																	  	$products_id=(preg_match("/^\d{1,10}(\{\d{1,10}\}\d{1,10})*$/",$HTTP_GET_VARS['products_id']) ? $HTTP_GET_VARS['products_id'] : (int)$HTTP_GET_VARS['products_id']);
    																			//++++ QT Pro: Begin Changed code //////////
    																			require(DIR_WS_CLASSES . 'pad_' . PRODINFO_ATTRIBUTE_PLUGIN . '.php');
    																			$class = 'pad_' . PRODINFO_ATTRIBUTE_PLUGIN;
    																			$pad = new $class($products_id);
    																			echo $pad->draw();
    																			//++++ QT Pro: End Changed Code ////////////
    																		}
    																		?>
    																	</td>
    																	<td>
    	                                	<TABLE cellSpacing="2" cellPadding="0" border="0" width="100%">
    	 	                            			<!-- Cena z wyposazeniem dodatkowym BOF -->
    																			<?php
    	  																	require(DIR_WS_INCLUDES . 'javascript/price_with_attributes.js.php');
    																			?>
    																		<!-- Cena z wyposazeniem dodatkowym EOF -->
    																		</table>
    	                      					</td>
    																</tr>
    															</table>
    														</td>
    													</tr>
    												<?php
    												}
    												?>
    												<!-- Dodatkowe opcje produktu EOF -->
    	 		<tr>
    				<td colspan="2"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
    			</tr>
    	
    												<TR>
    												  <td colspan="2" align="right">
    												    <TABLE cellSpacing="2" cellPadding="2" border="0">
    												      <tr>
    																<!-- Ilosc zamawianych produktow BOF -->
    																<?php
    																	if ($_GET['quant'] != '') {
    																		echo '<td class="main" align="righ">'.ENTRY_CANTIDAD.'&nbsp;&nbsp;<input type="text" name="quantity" value="'.$_GET['quant'].'" maxlength="4" size="4"></td>';
    																} elseif ($_GET['quant'] == '') {
    																		echo '<td class="main" align="righ">'.ENTRY_CANTIDAD.'&nbsp;&nbsp;<input type="text" name="quantity" value="1" maxlength="4" size="4"></td>';
    																}
    																?>
    																<!-- Ilosc zamawianych produktow EOF -->
    	
    																<!-- Przycisk "do koszyka" BOF -->
    																<TD align="center" class="main">
    																<?php
    																	if ( $product_info['products_quantity'] > 0 ) {
    																		if ($product_info['products_price'] > 0) {
    																			echo tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART);
    																		} else {
    																			echo ''.TEMPORARY_NO_PRICE.'';
    																		}
    																	} else {
    																		if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
    																			echo ''.tep_image_button('button_sold.gif').'';
    																		} else if ( (STOCK_CHECK == 'false') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
    																			echo ''.tep_image_button('button_sold.gif').'';
    																		} else {
    																			echo tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART);
    																		}
    																	}
    																?>
    																</TD>
    															</TR>
    														</table>
    													</td>
    												</tr>
    												<!-- Przycisk "do koszyka" EOF -->
    												</form>
    											</tbody>
    										</table>
    										<!-- Tabelka naglowka produktu EOF -->
    									</td>
    								</tr>
    							</table>
    						</td>
    					</tr>
    				</table>
    			</td>
    		</tr>
    	
    		<!-- Dodatkowe zdjecia BOF //////////////////////-->
    		<?php
    		$images_product = tep_db_query("SELECT additional_images_id, products_id, images_description, medium_images, popup_images FROM " . TABLE_ADDITIONAL_IMAGES . " WHERE products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'");
    		if (tep_db_num_rows($images_product)) {
    			?>
    			<tr>
    				<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
    			</tr>
    			<tr>
    				<td>
    					<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    						<tr class="infoBoxContents">
    							<td>
    								<?php require($modules_folder . FILENAME_ADDITIONAL_IMAGES); ?>
    							</td>
    						</tr>
    					</table>
    				</td>
    			</tr>
    			<?php
    		}
    		?>
    		<!-- Dodatkowe zdjecia EOF //////////////////////-->
    	
    		<!-- Opis produktu BOF ////////////////////////////////////////////////////-->
    		<tr>
    			<td>
    				<table border="0" width="100%" cellspacing="0" cellpadding="2">
    					<tr>
    						<td class="subTileModule"><b><?php echo PRODUCT_INFO_DESCRIPTION; ?></b></td>
    					</tr>
    				</table>
    			</td>
    		</tr>
    	
    		<tr>
    			<td>
    				<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    					<tr class="infoBoxContents">
    						<td>
    							<table width="100%" cellspacing="0" cellpadding="2" border="0">
    								<!-- Opis BOF -->
    								<TR>
    									<td>
    										<table cellspacing="0" cellpadding="2" border="0">
    											<tr>
    												<td class="main">
    													<?php echo stripslashes($product_info['products_description']); ?>
    																								<?php
    							// start indvship
    							$extra_shipping_query = tep_db_query("select products_ship_price, products_ship_price_two from " . TABLE_PRODUCTS_SHIPPING . " where products_id = '" . (int)$products_id . "'");
    							if (tep_db_num_rows($extra_shipping_query)) {
    								$extra_shipping = tep_db_fetch_array($extra_shipping_query);
    								if($extra_shipping['products_ship_price'] == '0.00'){
    									echo '<i>(Darmowa Wysyłka)</i>';
    								} else {
    									echo '<i>(Koszt wysyłki ' . $extra_shipping['products_ship_price'];
    									if (($extra_shipping['products_ship_price_two']) > 0) {
    										echo 'zł dla jednego produktu ' . $extra_shipping['products_ship_price_two'] . 'zł dla każdego dodatkowego produktu.)</i>';
    									} else {
    										echo ' + plus standardowy koszt.)</i>';
    									}
    								}
    							}
    							// end indvship
    							?>
    												</td>
    											</tr>
    										</table>
    									</td>
    								</tr>
    								<!-- Opis EOF -->
    	
    						<!-- Dodatkowe pola w opisie produktu BOF -->
    								<tr>
    									<td>
    										<table width="100%" cellspacing="1" cellpadding="5" border="0" class="TableFrame">
    																				<?php
    													// START: Extra Fields Contribution v2.0b
    													$extra_fields_query = tep_db_query("
    													SELECT pef.products_extra_fields_status as status, pef.products_extra_fields_name as name, ptf.products_extra_fields_value as value
    														FROM ". TABLE_PRODUCTS_EXTRA_FIELDS ." pef
    														LEFT JOIN  ". TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS ." ptf
    														ON ptf.products_extra_fields_id=pef.products_extra_fields_id
    														WHERE ptf.products_id=" . (int)$HTTP_GET_VARS['products_id']." and ptf.products_extra_fields_value<>'' and (pef.languages_id='0' or pef.languages_id='".$languages_id."')
    														ORDER BY products_extra_fields_order");
    	
    													while ($extra_fields = tep_db_fetch_array($extra_fields_query)) {
    														if (! $extra_fields['status'])  // show only enabled extra field
    	?>
    	    <tr>
    			<td class="ProductHead" width="50%"><b><?php echo $extra_fields['name']; ?></b>:</td>
    			<td class="ProductHead" width="50%"> <?php echo $extra_fields['value']; ?></td>
    		</tr>
    	<?php
    	  }
    	// END: Extra Fields Contribution
    	?>
    										</table>
    									</td>
    								</tr>
    	                   <!-- Dodatkowe pola w opisie produktu EOF -->
    	              
    								<!-- data dodania BOF -->
    								<TR>
    									<td class="smallText" align="center">
    										<?php
    										if ($product_info['products_date_available'] > date('Y-m-d H:i:s')) {
    											echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($product_info['products_date_available']));
    										} else {
    											echo sprintf(TEXT_DATE_ADDED, tep_date_long($product_info['products_date_added']));
    										}
    										?>
    									</td>
    								</tr>
    								<!-- data dodania EOF -->
    							</table>
    						</td>
    					</tr>
    				</table>
    			</td>
    		</tr>
    		<!-- Opis produktu EOF ////////////////////////////////////////////////////-->
    	
    		<!-- Dodatkowe linki BOF //////////////////////////////////////////////////-->
    		<tr>
    			<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
    		</tr>
    		<tr>
    			<td>
    				<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    					<tr class="infoBoxContents">
    						<td>
    							<table width="100%" cellspacing="0" cellpadding="2" border="0">
    								<tr>
    									<td class="main">
    										<?php echo '&raquo; <a href="' . tep_href_link(FILENAME_PDF_DATASHEET, 'products_id=' . $product_info['products_id']) .'" target="_blank">' . TEXT_PDF_DOWNLOAD . ' ' .tep_image(DIR_WS_TEMPLATES.'images/misc/icons/pdf.png',TEXT_PDF_DOWNLOAD) .'</a>'; ?>
    									</td>
    								</tr>
    	
    								<?php
    								if (tep_not_null($product_info['products_url'])) {
    									?>
    									<tr>
    										<td class="main">
    											<?php echo '&raquo; ' . sprintf(TEXT_MORE_INFORMATION, tep_href_link(FILENAME_REDIRECT, 'action=url&goto=' . urlencode($product_info['products_url']), 'NONSSL', true, false)); ?>
    										</td>
    									</tr>
    									<?php
    								}
    								?>
    	
    								<tr>
    									<td class="main">
    										<?php
    										if (tep_session_is_registered('customer_id')) {
    											$check_query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS_NOTIFICATIONS . " where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and customers_id = '" . $customer_id . "'");
    											$check = tep_db_fetch_array($check_query);
    	                    $notification_exists = (($check['count'] > 0) ? true : false);
    										} else {
    											$notification_exists = false;
    										}
    	                  if ($notification_exists == true) {
    											echo '<a class="boxLink" href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=notify_remove', $request_type) . '">&raquo; ' . sprintf(BOX_NOTIFICATIONS_NOTIFY_REMOVE, tep_get_products_name($HTTP_GET_VARS['products_id'])) .'</a>';
    										} else {
    											echo '<a class="boxLink" href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=notify', $request_type) . '">&raquo; ' . sprintf(BOX_NOTIFICATIONS_NOTIFY, tep_get_products_name($HTTP_GET_VARS['products_id'])) .'</a>';
    										}
    										?>
    									</td>
    								</tr>
    	
    								<tr>
    									<td class="main">
    										<?php
    										if (isset($HTTP_GET_VARS['products_id'])) {
    											echo '<a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'products_id=' . $HTTP_GET_VARS['products_id']) . '">&raquo; ' . BOX_REVIEWS_WRITE_REVIEW .'</a>';
    										}
    										?>
    									</td>
    								</tr>
    	
    								<tr>
    									<td class="main">
    										<a class="boxLink" href="ask_a_question.php?products_id=<?php echo $product_info['products_id']; ?>">&raquo; <?php echo '' . TEXT_ASK_QUESTION . ''; ?></a>
    									</td>
    								</tr>
    							</table>
    						</td>
    					</tr>
    				</table>
    			</td>
    		</tr>
    		<!-- Dodatkowe linki EOF -->
    	
    		<!-- Komentarze BOF -->
    		<?php
    		$reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS . " where approved = 1 and products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'");
    		$reviews = tep_db_fetch_array($reviews_query);
    		if ($reviews['count'] > 0) {
    			?>
    			<tr>
    				<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
    			</tr>
    			<tr>
    				<td>
    					<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    						<tr class="infoBoxContents">
    							<td>
    								<table width="100%" cellspacing="0" cellpadding="2" border="0">
    									<tr>
    									<td class="main"><?php echo TEXT_CURRENT_REVIEWS . ' ' . $reviews['count']; ?></td>
    									</tr>
    									<tr>
    										<td class="main"><?php echo '<a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params()) . '"><B>&raquo; '.IMAGE_BUTTON_REVIEWS.'</B></a></td>'; ?>
    									</tr>
    								</table>
    							</td>
    						</tr>
    					</table>
    				</td>
    			</tr>
    		<?php
    		}
    		// Komentarze EOF
    	
    		// Previous/Next Product Buttons v3.2 ////////////////////////////////////////
    		if ($product_check['total'] >= 1) {
    			?>
    			<tr>
    				<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
    			</tr>
    			<tr>
    				<td>
    					<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    						<tr class="infoBoxContents">
    							<td>
    								<table border="0" width="100%" cellspacing="0" cellpadding="0">
    									<?php include (DIR_WS_INCLUDES . 'products_next_previous.php'); ?>
    								</table>
    							</td>
    						</tr>
    					</table>
    				</td>
    			</tr>
    			<tr>
    				<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
    			</tr>
    			<?php
    		}
    		?>
    	
    		<tr>
    			<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
    		</tr>
    		<tr>
    			<td>
    				<?php
    				include($modules_folder . FILENAME_RELATED_PRODUCTS);
    				?>
    			</td>
    		</tr>
    		<?php

	}
	?>
</table>

<?php
if ((USE_CACHE == 'true') && empty($SID)) {
	echo '<table class="infoBoxContents_Box_Menu" width="100%" cellspacing="0" cellpadding="2"><tr><td>';
	echo tep_cache_also_purchased(3600);
	echo '</td></tr></table>';
} else {
	echo '<table class="infoBoxContents_Box_Menu" width="100%" cellspacing="0" cellpadding="2"><tr><td>';
	include($modules_folder . FILENAME_ALSO_PURCHASED_PRODUCTS);
	echo '</td></tr></table>';
}
?>

