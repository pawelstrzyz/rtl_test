<?php


/*
 * Punkt koñcowy obs³uguj±cy zmiany wychodz±ce (wysy³ane z) Subiekta
 */

require_once 'epall.php';

function pobierz_mapowanie_towaru($sub_id = null) {
	if (!is_null($sub_id)) {
		$rs = tw_db_query('SELECT sub_id, osc_id ' .
		'	FROM tw_towar ' .
		'		INNER JOIN ' . TABLE_PRODUCTS .
		'			ON osc_id = ' . TABLE_PRODUCTS . '.products_id ' .
		'		INNER JOIN ' . TABLE_PRODUCTS_DESCRIPTION .
		'			ON osc_id = ' . TABLE_PRODUCTS_DESCRIPTION . '.products_id ' .
		'	WHERE sub_id = ' . (int) $sub_id . ' AND language_id = ' . TW_LANGUAGE_ID);
	}
	$wynik = tw_db_fetch_array($rs);
	tw_db_free_result($rs);
	return $wynik;
}

function zapisz_mapowanie_towaru($sub_id = null, $osc_id = null) {
	if (!is_null($sub_id) && !is_null($osc_id)) {
		$sub_id = (int) $sub_id;
		$osc_id = (int) $osc_id;
		tw_db_query("DELETE FROM tw_towar WHERE sub_id = $sub_id");
		tw_db_query("INSERT INTO tw_towar (sub_id, osc_id) VALUES ($sub_id, $osc_id)");
		return true;
	} else {
		return false;
	}
}

function usun_towar($osc_id) {
	$osc_id = (int) $osc_id;
	tw_db_query('DELETE FROM ' . TABLE_PRODUCTS . ' WHERE products_id = ' . $osc_id);
	tw_db_query('DELETE FROM ' . TABLE_PRODUCTS_DESCRIPTION . ' WHERE products_id = ' . $osc_id);
	tw_db_query('DELETE FROM ' . TABLE_PRODUCTS_TO_CATEGORIES . ' WHERE products_id = ' . $osc_id);
	tw_db_query('DELETE FROM ' . TABLE_SPECIALS . ' WHERE products_id = ' . $osc_id);
	tw_db_query('DELETE FROM tw_towar WHERE osc_id = ' . $osc_id);

	// usuniêcie pól w³asnych
	if (TW_JEST_EXTRAFIELDS)
		tw_db_query('DELETE FROM ' . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . ' WHERE products_id=' . $osc_id);

	// usuniêcie zdjêæ
	$rs = tw_db_query('SELECT sub_zd_id FROM tw_zdjecie WHERE products_id = ' . $osc_id);
	while ($row = tw_db_fetch_array($rs)) {
		usun_zdjecie($row['sub_zd_id']);
	}
	tw_db_free_result($rs);
}

function usun_zdjecie($sub_zd_id) {
	$sub_zd_id = (int) $sub_zd_id;
	$rs = tw_db_query('SELECT nazwa_pliku, nazwa_pliku_temp, nazwa_pliku_miniatury, nazwa_pliku_miniatury_temp FROM tw_zdjecie WHERE sub_zd_id=' . $sub_zd_id);
	if ($row = tw_db_fetch_array($rs))
		foreach ($row as $nazwa_pliku) {
			if ($nazwa_pliku) {
				@ unlink(DIR_FS_CATALOG_IMAGES . $nazwa_pliku);
			}
		}
	tw_db_free_result($rs);
	tw_db_query('DELETE FROM tw_zdjecie WHERE sub_zd_id=' . $sub_zd_id);
}

function aktualizuj_zdjecia_towaru($products_id, $sub_zd_id = 0) {
	$products_id = (int) $products_id;
	$zdjecia = array ();
	$rs = tw_db_query('SELECT sub_zd_id, glowne, nazwa_pliku, nazwa_pliku_miniatury FROM tw_zdjecie WHERE products_id = ' . $products_id . ' ORDER BY glowne DESC, sub_zd_id');
	while ($row = tw_db_fetch_array($rs)) {
		$zdjecia[] = $row;
	}
	tw_db_free_result($rs);
	if ($zdjecia) {
		// pierwsze - g³ówne
		$zd_glowne = $zdjecia[0];
		if (TW_JEST_ULTRAPICS) {
			if ($zd_glowne['nazwa_pliku']) {
				tw_db_query('UPDATE ' . TABLE_PRODUCTS . " SET products_image = '{$zd_glowne['nazwa_pliku']}', products_image_med = '{$zd_glowne['nazwa_pliku']}', products_image_lrg = '{$zd_glowne['nazwa_pliku']}' WHERE products_id = $products_id");
			}
			if ($zd_glowne['nazwa_pliku_miniatury']) {
				tw_db_query('UPDATE ' . TABLE_PRODUCTS . " SET products_image = '{$zd_glowne['nazwa_pliku_miniatury']}', products_image_med = '{$zd_glowne['nazwa_pliku_miniatury']}' WHERE products_id = $products_id");
			}
		} else {
			if ($zd_glowne['nazwa_pliku']) {
				tw_db_query('UPDATE ' . TABLE_PRODUCTS . " SET products_image = '{$zd_glowne['nazwa_pliku']}' WHERE products_id = $products_id");
			}
		}

		// pozosta³e zdjêcia (2-7)
		if (TW_JEST_ULTRAPICS) {
			for ($i = 1; $i <= 6; $i++) {
				if (isset ($zdjecia[$i])) {
					$zd = $zdjecia[$i];
					if ($zd['nazwa_pliku']) {
						tw_db_query('UPDATE ' . TABLE_PRODUCTS . " SET products_image_sm_$i = '{$zd['nazwa_pliku']}', products_image_xl_$i = '{$zd['nazwa_pliku']}' WHERE products_id = $products_id");
					}
					if ($zd['nazwa_pliku_miniatury']) {
						tw_db_query('UPDATE ' . TABLE_PRODUCTS . " SET products_image_sm_$i = '{$zd['nazwa_pliku_miniatury']}' WHERE products_id = $products_id");
					}
				} else {
					tw_db_query('UPDATE ' . TABLE_PRODUCTS . " SET products_image_sm_$i = NULL, products_image_xl_$i = NULL WHERE products_id = $products_id");
				}
			}
		}
		
		if (TW_SA_ZDJECIA23) {
			tw_db_query('DELETE FROM ' . TABLE_PRODUCTS_IMAGES . ' WHERE products_id = ' . $products_id);
			for ($i = 0; $i < count($zdjecia); $i++) {
				tw_db_query('INSERT INTO ' . TABLE_PRODUCTS_IMAGES . ' (products_id, image, sort_order) VALUES (' . $products_id . ", '" . $zdjecia[$i]['nazwa_pliku'] . "', " . ($i * 10) . ')');
			}
		}
		
	} else {
		// usuniêto wszystkie zdjêcia
		tw_db_query('UPDATE ' . TABLE_PRODUCTS . " SET products_image = NULL WHERE products_id = $products_id");
		if (TW_JEST_ULTRAPICS) {
			tw_db_query('UPDATE ' . TABLE_PRODUCTS . " SET products_image_med = NULL, products_image_lrg = NULL, " .
			" products_image_sm_1 = NULL, products_image_xl_1 = NULL, " .
			" products_image_sm_2 = NULL, products_image_xl_2 = NULL, " .
			" products_image_sm_3 = NULL, products_image_xl_3 = NULL, " .
			" products_image_sm_4 = NULL, products_image_xl_4 = NULL, " .
			" products_image_sm_5 = NULL, products_image_xl_5 = NULL, " .
			" products_image_sm_6 = NULL, products_image_xl_6 = NULL " .
			" WHERE products_id = $products_id");
		}
		if (TW_SA_ZDJECIA23) {
			tw_db_query('DELETE FROM ' . TABLE_PRODUCTS_IMAGES . ' WHERE products_id = ' . $products_id);
		}
	}
}

function aktualizuj_slownik_pol_wlasnych(& $pola) {
	$ex_ids = explode(';', TW_PW_EXTRA_FIELDS_IDS);
	$i = 0;
	foreach ($pola as $k => $v) {
		$i = (int) $k {
			strlen($k) - 1 }
		-1; // 'wlasne3' na 2
		$v = tw_substr($v, 0, LIMIT_EXTRA_FIELDS_NAME);
		$ex_id = null;
		if (isset ($ex_ids[$i]) && $ex_ids[$i]) {
			// aktualizacja pola w³asnego
			$ex_id = (int) $ex_ids[$i];
			if ($v) { // aktualizacja nazwy pola
				$rs = tw_db_query('SELECT products_extra_fields_name FROM ' .
				TABLE_PRODUCTS_EXTRA_FIELDS . ' WHERE products_extra_fields_id= ' . $ex_id);
				if ($row = tw_db_fetch_array($rs)) {
					tw_db_query('UPDATE ' . TABLE_PRODUCTS_EXTRA_FIELDS . ' SET products_extra_fields_name = \'' . tw_db_input(/*htmlspecialchars(*/
					$v /*)*/
					) . '\' ' .
					'WHERE products_extra_fields_id = ' . $ex_id);
				} else {
					$ex_ids[$i] = null;
					$ex_id = null; // pole usuniêto - dodaæ jeszcze raz
				}
				tw_db_free_result($rs);
			} else { // usuniêcie pola
				tw_db_query('DELETE FROM ' . TABLE_PRODUCTS_EXTRA_FIELDS . ' WHERE products_extra_fields_id=' . $ex_id);
				tw_db_query('DELETE FROM ' . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . ' WHERE products_extra_fields_id=' . $ex_id);
				$ex_ids[$i] = null;
				$ex_id = null;
			}
		}
		if (is_null($ex_id) && $v) {
			// dodanie nowego pola w³asnego
			// 1.01 SP1 - czy istnieje ju¿ pole o tej nazwie?
			$efrs = tw_db_query('SELECT products_extra_fields_id FROM ' . TABLE_PRODUCTS_EXTRA_FIELDS . 
			' WHERE products_extra_fields_name = \'' . tw_db_input($v) . '\'');
			if ($efrs) {
				$efrow = tw_db_fetch_array($efrs);
				tw_db_free_result($efrs);
				if ($efrow) {
					$ex_id = array_shift($efrow);
				}
			} 
			if (!$ex_id) {
				tw_db_query('INSERT INTO ' . TABLE_PRODUCTS_EXTRA_FIELDS . ' (products_extra_fields_name, products_extra_fields_order) ' .
				'VALUES (\'' . tw_db_input(/*htmlspecialchars(*/
				$v /*)*/
				) . '\', ' . $i . ')');
				$ex_id = tw_db_insert_id();
			}
			$ex_ids[$i] = $ex_id; 
		}
	}
	global $pola_wlasne;
	$pola_wlasne = $ex_ids;
	tw_db_query('UPDATE tw_ustawienia SET TW_PW_EXTRA_FIELDS_IDS=\'' . implode(';', $ex_ids) . '\' WHERE tw_ust_id=1');
}

function aktualizuj_pola_wlasne(& $pola, $osc_id) {
	global $pola_wlasne;
	$osc_id = (int) $osc_id;
	$nazwy = array (
		'wlasne1',
		'wlasne2',
		'wlasne3',
		'wlasne4',
		'wlasne5',
		'wlasne6',
		'wlasne7',
		'wlasne8'
	);
	foreach ($nazwy as $i => $k) {
		if (array_key_exists($k, $pola) && isset ($pola_wlasne[$i]) && $pola_wlasne[$i]) {
			if (isset($pola[$k]) && trim($pola[$k]) != '') {
				$pola[$k] = tw_substr($pola[$k], 0, LIMIT_EXTRA_FIELDS_VALUE);
				// dodanie b±d¼ aktualizacja
				$rs = tw_db_query('SELECT COUNT(*) cnt FROM ' . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS .
				' WHERE products_id=' . $osc_id . ' AND products_extra_fields_id=' . $pola_wlasne[$i]);
				$row = tw_db_fetch_array($rs);
				if ($row['cnt']) {
					// aktualizacja
					tw_db_query('UPDATE ' . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS .
					' SET products_extra_fields_value=\'' . tw_db_input(/*htmlspecialchars(*/
					$pola[$k] /*)*/
					) . '\' WHERE products_id=' . $osc_id . ' AND products_extra_fields_id=' . $pola_wlasne[$i]);
				} else {
					// dodawanie
					tw_db_query('INSERT INTO ' . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . ' (products_id, products_extra_fields_id, products_extra_fields_value) ' .
					'VALUES (' . $osc_id . ', ' . $pola_wlasne[$i] . ', \'' . tw_db_input(/*htmlspecialchars(*/
					$pola[$k] /*)*/
					) . '\')');
				}
				tw_db_free_result($rs);
			} else {
				//usuwanie
				tw_db_query('DELETE FROM ' . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS .
				' WHERE products_id=' . $osc_id . ' AND products_extra_fields_id=' . $pola_wlasne[$i]);
			}
		}
	}
}

function pola_producenta_do_manufacturers_id($sub_id, $prod_nazwa, $prod_www) {
	$sub_id = (int) $sub_id;
	$prod_nazwa = tw_substr($prod_nazwa, 0, LIMIT_MANUFACTURERS_NAME);
	$prod_www = tw_substr($prod_www, 0, LIMIT_MANUFACTURERS_URL);
	$mid = null;
	$rs = tw_db_query('SELECT osc_manufacturers_id tp_id, ' .
	TABLE_MANUFACTURERS . '.manufacturers_id tm_id, ' .
	TABLE_MANUFACTURERS_INFO . '.manufacturers_id tmi_id ' .
	'FROM tw_producent RIGHT JOIN ' . TABLE_MANUFACTURERS . ' ON ' . TABLE_MANUFACTURERS . '.manufacturers_id = osc_manufacturers_id ' .
	'LEFT JOIN ' . TABLE_MANUFACTURERS_INFO . ' ON (' . TABLE_MANUFACTURERS_INFO . '.manufacturers_id = ' . TABLE_MANUFACTURERS . '.manufacturers_id AND languages_id = ' . TW_LANGUAGE_ID . ') ' .
	'WHERE sub_kh_id=' . $sub_id . " OR (sub_kh_id IS NULL AND manufacturers_name LIKE '" . tw_db_input($prod_nazwa) . "')");
	$row = tw_db_fetch_array($rs);
	if ($row) {
		$tp_id = $row['tp_id'];
		$tm_id = $row['tm_id'];
		$tmi_id = $row['tmi_id'];
	} else {
		$tp_id = $tm_id = $tmi_id = null;
	}
	tw_db_free_result($rs);

	tw_db_perform(TABLE_MANUFACTURERS, array (
		'manufacturers_name' => $prod_nazwa
	), $tm_id ? 'update' : 'insert', $tm_id ? ('manufacturers_id=' . $tm_id) : '');
	if (!$tm_id)
		$tm_id = tw_db_insert_id();

	tw_db_perform(TABLE_MANUFACTURERS_INFO, array (
		'manufacturers_id' => $tm_id,
		'languages_id' => TW_LANGUAGE_ID,
		'manufacturers_url' => $prod_www
	), $tmi_id ? 'update' : 'insert', $tmi_id ? ('manufacturers_id = ' . $tmi_id . ' AND languages_id=' . TW_LANGUAGE_ID) : '');
	if (!$tmi_id)
		$tmi_id = tw_db_insert_id();

	tw_db_query('DELETE FROM tw_producent WHERE sub_kh_id = '. (int) $sub_id);
	tw_db_perform('tw_producent', array (
		'sub_kh_id' => $sub_id,
		'osc_manufacturers_id' => $tm_id,
		'nazwa_pliku' => null,
		'nazwa_pliku_temp' => null
	), $tp_id ? 'update' : 'insert', $tp_id ? ('sub_kh_id=' . $sub_id) : '');

	return $tm_id;
}

function przetworz_zmiane_stanu(& $zmiana) {
	if (isset ($zmiana->pola['stan']) && isset ($zmiana->osc_id)) {
		tw_db_query('UPDATE ' . TABLE_PRODUCTS . ' SET products_quantity = ' . (int) $zmiana->pola['stan'] .
		' WHERE products_id = ' . (int) $zmiana->osc_id);
		tw_potwierdz_zmiane($zmiana);
	} else {
		tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
	}
}

function przetworz_zmiane_towaru(& $zmiana) {
	switch ($zmiana->typ_zmiany) {
		case TW_TYPZMIANY_DODAWANIE :
			$map = pobierz_mapowanie_towaru($zmiana->sub_id);
			if ($map) {
				$zmiana->osc_id = $map['osc_id'];
				tw_potwierdz_zmiane($zmiana);
			} else {
				przelicz_ceny_w_polach_towaru($zmiana->pola);
				$sql_data_array = pola_towaru_do_sql_products($zmiana->pola, true);
				if ($sql_data_array) {
					$sql_data_array['products_date_added'] = 'now()';
					$sql_data_array['products_quantity'] = '0';
					if (!tw_db_perform(TABLE_PRODUCTS, $sql_data_array)) {
						tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
						return;
					}
					$osc_id = tw_db_insert_id();
					zapisz_mapowanie_towaru($zmiana->sub_id, $osc_id);

					$sql_data_array = pola_towaru_do_sql_products_description($zmiana->pola);
					if ($sql_data_array) {
						tw_db_query("DELETE FROM " . TABLE_PRODUCTS_DESCRIPTION . " WHERE products_id=$osc_id AND language_id=" . TW_LANGUAGE_ID);
						$sql_data_array['products_id'] = $osc_id;
						$sql_data_array['language_id'] = TW_LANGUAGE_ID;
						if (!tw_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array)) {
							usun_towar($osc_id);
							tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
							return;
						}
					}

					if (isset ($zmiana->pola['kategorie'])) {
						//						$cid = tw_grupa_do_categories_id($zmiana->pola['grupa']);
						//						tw_db_query("INSERT INTO " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) " .
						//						"VALUES ($osc_id, $cid)");
						skojarz_produkt_z_kategoriami($osc_id, $zmiana->pola['kategorie']);
					}

					if (isset ($zmiana->pola['promocja'])) {
						tw_ustaw_cene_promocyjna($osc_id, $zmiana->pola['promocja'], isset ($zmiana->pola['promocja_koniec']) ? $zmiana->pola['promocja_koniec'] : null);
					}

					if (TW_JEST_EXTRAFIELDS && defined('TW_PW_EXTRA_FIELDS_IDS')) {
						aktualizuj_pola_wlasne($zmiana->pola, $osc_id);
					}

					$zmiana->osc_id = $osc_id;
					tw_potwierdz_zmiane($zmiana);
				}
			}
			break;
		case TW_TYPZMIANY_AKTUALIZACJA :

			if ($zmiana->osc_id) {
				$rs = tw_db_query('SELECT products_id FROM ' . TABLE_PRODUCTS . ' WHERE products_id = ' . (int) $zmiana->osc_id);
				$row = tw_db_fetch_array($rs);
				if (!$row) {
					tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_TOWAR_USUNIETO);
					return;
				}
				tw_db_free_result($rs);

				przelicz_ceny_w_polach_towaru($zmiana->pola);

				$sql_data_array = pola_towaru_do_sql_products($zmiana->pola);
				if ($sql_data_array) {
					if (!tw_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', 'products_id=' . (int) $zmiana->osc_id)) {
						tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
						return;
					}
				}

				$jest_opis = false;
				$stary_opis = '';
				$rs = tw_db_query('SELECT products_description FROM ' . TABLE_PRODUCTS_DESCRIPTION . ' WHERE ' .
				'language_id = ' . TW_LANGUAGE_ID . ' AND products_id = ' . $zmiana->osc_id);
				if ($row = tw_db_fetch_array($rs)) {
					$stary_opis = $row['products_description'];
					$jest_opis = true;
				}

				tw_db_free_result($rs);
				$sql_data_array = pola_towaru_do_sql_products_description($zmiana->pola, $stary_opis);

				if (!$jest_opis) {
					if (!isset ($sql_data_array['products_name'])) {
						tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
						return;
					}
					$sql_data_array['products_id'] = (int) $zmiana->osc_id;
					$sql_data_array['language_id'] = TW_LANGUAGE_ID;
				}

				if ($sql_data_array) {
					if (!tw_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, $jest_opis ? 'update' : 'insert', $jest_opis ? ('products_id=' . (int) $zmiana->osc_id . ' AND language_id=' . TW_LANGUAGE_ID) : '')) {
						tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
						return;
					}
				}

				if (isset ($zmiana->pola['kategorie'])) {
					skojarz_produkt_z_kategoriami($zmiana->osc_id, $zmiana->pola['kategorie']);
					// wybranie kategorii, do których aktualnie nale¿y produkt
					//$rs = tw_db_query('SELECT categories_id, COUNT(products_id) cnt ' .
					//'  	FROM ' . TABLE_PRODUCTS_TO_CATEGORIES . ' ' .
					//'	WHERE categories_id IN ' .
					//'		(SELECT categories_id FROM ' . TABLE_PRODUCTS_TO_CATEGORIES . ' WHERE products_id = ' . $zmiana->osc_id . ') ' .
					//'	GROUP BY categories_id');

					// #63481
					//					$rs = tw_db_query('SELECT categories_id, COUNT(products_id) cnt, SUM(products_id=' . (int) $zmiana->osc_id . ') cond ' .
					//					'FROM ' . TABLE_PRODUCTS_TO_CATEGORIES . ' ' .
					//					'GROUP BY categories_id ' .
					//					'HAVING cond > 0');
					//					// usuniêcie produktu z kategorii, w których jest
					//					tw_db_query('DELETE FROM ' . TABLE_PRODUCTS_TO_CATEGORIES . ' WHERE products_id = ' . (int) $zmiana->osc_id);
					//					// usuniêcie pustych kategorii
					//					while ($row = tw_db_fetch_array($rs)) {
					//						if ($row['cnt'] == 1) {
					//							tw_db_query('DELETE FROM ' . TABLE_CATEGORIES . ' WHERE categories_id=' . $row['categories_id']);
					//							tw_db_query('DELETE FROM ' . TABLE_CATEGORIES_DESCRIPTION . ' WHERE categories_id=' . $row['categories_id']);
					//						}
					//					}
					//					tw_db_free_result($rs);
					//					// dodanie produktu do nowej kategorii
					//					$cid = tw_grupa_do_categories_id($zmiana->pola['grupa']);
					//					tw_db_query("INSERT INTO " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) " .
					//					"VALUES ({$zmiana->osc_id}, $cid)");
				}

				if (isset ($zmiana->pola['promocja'])) {
					tw_ustaw_cene_promocyjna($zmiana->osc_id, $zmiana->pola['promocja'], isset ($zmiana->pola['promocja_koniec']) ? $zmiana->pola['promocja_koniec'] : null);
				}

				if (TW_JEST_EXTRAFIELDS && defined('TW_PW_EXTRA_FIELDS_IDS')) {
					aktualizuj_pola_wlasne($zmiana->pola, $zmiana->osc_id);
				}

				tw_potwierdz_zmiane($zmiana);
			}
			break;
		case TW_TYPZMIANY_USUNIECIE :
			usun_towar($zmiana->osc_id);
			tw_potwierdz_zmiane($zmiana);
			break;
	}
}

function skojarz_produkt_z_kategoriami($products_id, & $kategorie) {
	tw_db_query('DELETE FROM ' . TABLE_PRODUCTS_TO_CATEGORIES . ' WHERE products_id = ' . (int) $products_id);
	foreach ($kategorie as $entry) {
		$rs = tw_db_query('SELECT COUNT(*) cnt FROM ' . TABLE_CATEGORIES . ' WHERE categories_id = ' . (int) $entry->v->osc_id);
		$row = tw_db_fetch_array($rs);
		tw_db_free_result($rs);
		if (!$row['cnt']) {
			$potw = new potwierdzenie('kategoria', TW_TYPZMIANY_USUNIECIE, (int) $entry->v->osc_id);
			tw_zapisz_potwierdzenie($potw);
		} else {
			tw_db_query('INSERT INTO ' . TABLE_PRODUCTS_TO_CATEGORIES . ' (products_id, categories_id) ' .
			'VALUES (' . (int) $products_id . ', ' . (int) $entry->v->osc_id . ')');
		}
	}
}

function przelicz_ceny_w_polach_towaru(& $pola) {
	$waluta = isset ($pola['waluta']) ? $pola['waluta'] : '';
	$kurs_w_pln = isset ($pola['kurs']) ? $pola['kurs'] : 0;
	if (isset ($pola['cena'])) {
		$pola['cena'] = tw_przelicz_cene((double) $pola['cena'], $waluta, $kurs_w_pln);
	}
	if (isset ($pola['promocja']) && $pola['promocja']) {
		$pola['promocja'] = tw_przelicz_cene((double) $pola['promocja'], $waluta, $kurs_w_pln);
	}
}

function pola_towaru_do_sql_products(& $pola, $ustaw_domyslne = false) {
	$sql_data_array = array ();
	if (isset ($pola['symbol'])) {
		$sql_data_array['products_model'] = tw_substr($pola['symbol'], 0, LIMIT_PRODUCTS_MODEL);
	}
	if (isset ($pola['cena'])) {
		$sql_data_array['products_price'] = (double) $pola['cena'];
	}
	if (isset ($pola['widoczne'])) {
		$sql_data_array['products_status'] = $pola['widoczne'] ? 1 : 0;
	}
	if (isset ($pola['masa'])) {
		$sql_data_array['products_weight'] = (double) $pola['masa'];
	} else
		if ($ustaw_domyslne)
			$sql_data_array['products_weight'] = 0;
	if (isset ($pola['vat'])) {
		$sql_data_array['products_tax_class_id'] = tw_vat_do_tax_class_id($pola['vat']);
	}
	if (isset ($pola['prod_ref'])) {
		if (!$pola['prod_ref'])
			$sql_data_array['manufacturers_id'] = 0;
		else {
			$pref = $pola['prod_ref'];
			$sql_data_array['manufacturers_id'] = pola_producenta_do_manufacturers_id($pref->sub_id, $pola['prod_nazwa'], $pola['prod_www']);
		}
	}

	return $sql_data_array;
}

function pola_towaru_do_sql_products_description(& $pola, $stary_opis = '') {
	$sql_data_array = array ();
	if (isset ($pola['nazwa'])) {
		$sql_data_array['products_name'] = tw_substr($pola['nazwa'], 0, LIMIT_PRODUCTS_NAME);
	}
	if (isset ($pola['www'])) {
		$sql_data_array['products_url'] = tw_substr($pola['www'], 0, LIMIT_PRODUCTS_URL);
	}

	if (isset ($pola['opis']) || isset ($pola['char']) || isset ($pola['uwagi'])) {
		$opis = isset ($pola['opis']) ? $pola['opis'] : null;
		$char = isset ($pola['char']) ? $pola['char'] : null;
		$uwagi = isset ($pola['uwagi']) ? $pola['uwagi'] : null;
		$sql_data_array['products_description'] = tw_formatuj_opis($stary_opis, $opis, $char, $uwagi);
	}

	return $sql_data_array;
}

function wygeneruj_nazwe_pliku_zdjecia($sub_zd_id, $products_id, $miniatura, $typ = 'jpg') {
	$rs = tw_db_query('SELECT products_model FROM ' . TABLE_PRODUCTS . ' WHERE products_id=' . $products_id);
	$row = tw_db_fetch_array($rs);
	tw_db_free_result($rs);
	$nazwa = trim(@ereg_replace('[^a-zA-Z0-9]', '_', $row['products_model']));
	$nazwa = uniqid($nazwa . '_' . $sub_zd_id . ($miniatura ? '_min_' : '_'));
	$nazwa = strlen($nazwa) > LIMIT_PRODUCTS_IMAGE ? substr($nazwa, -LIMIT_PRODUCTS_IMAGE + strlen(TW_KATALOG_ZDJEC . '/.' . $typ)) : $nazwa;
	$nazwa = (TW_KATALOG_ZDJEC ? TW_KATALOG_ZDJEC . '/' : '') . $nazwa . '.' . $typ;
	return $nazwa;
}

function przetworz_zmiane_zdjecia(& $zmiana) {
	if (!isset ($zmiana->sub_id) || !isset ($zmiana->pola['towar']) || !is_a($zmiana->pola['towar'], 'pole_referencyjne') || !isset ($zmiana->pola['towar']->osc_id)) {
		// brak wymaganych pól
		tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
		return;
	}
	
	$aktualizuj_zdjecia_towaru = true;
	$sub_zd_id = (int) $zmiana->sub_id;
	$products_id = (int) $zmiana->pola['towar']->osc_id;

	// sprawdzenie, czy products_id zgadza siê z ewentualnym zapisem w bazie
	$rs = tw_db_query('SELECT products_id FROM tw_zdjecie WHERE sub_zd_id=' . $sub_zd_id);
	$row = tw_db_fetch_array($rs);
	if ($row && $products_id != $row['products_id']) {
		tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
		return;
	}

	// sprawdzenie, czy produkt istnieje
	$rs = tw_db_query('SELECT COUNT(*) cnt FROM ' . TABLE_PRODUCTS . ' WHERE products_id=' . $products_id);
	$row = tw_db_fetch_array($rs);
	if (!$row['cnt']) {
		tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
		return;
	}

	switch ($zmiana->typ_zmiany) {
		case TW_TYPZMIANY_DODAWANIE_JESLI_NIE_ISTNIEJE :
			if (!isset ($zmiana->pola['wartosc']) || !is_a($zmiana->pola['wartosc'], 'pole_binarne') || !isset ($zmiana->pola['wartosc']->dlugosc_calkowita) /*|| !isset($zmiana->pola['hash_oryginalu'])*/
				) { // brak wymaganych pól
				tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
				return;
			}
			// sprawdzenie formatu zdjêcia
			if (isset ($zmiana->pola['typ']))
				$typ = $zmiana->pola['typ'];
			else
				$typ = 'jpg';

			// czy to jest miniatura?
			$miniatura = isset ($zmiana->pola['miniatura']) && $zmiana->pola['miniatura'];

			// inicjalizacja b±d¼ pobranie danych o zdjêciu z tw_zdjecie
			$glowne = 0;
			$nazwa_pliku = null;
			$nazwa_pliku_temp = null;
			$nazwa_pliku_miniatury = null;
			$nazwa_pliku_miniatury_temp = null;
			$rs = tw_db_query('SELECT glowne, nazwa_pliku, nazwa_pliku_temp, nazwa_pliku_miniatury, nazwa_pliku_miniatury_temp FROM tw_zdjecie WHERE sub_zd_id=' . $sub_zd_id);
			if ($row = tw_db_fetch_array($rs)) {
				$glowne = $row['glowne'];
				$nazwa_pliku = $row['nazwa_pliku'];
				$nazwa_pliku_temp = $row['nazwa_pliku_temp'];
				$nazwa_pliku_miniatury = $row['nazwa_pliku_miniatury'];
				$nazwa_pliku_miniatury_temp = $row['nazwa_pliku_miniatury_temp'];
			} else {
				tw_db_query("INSERT INTO tw_zdjecie (sub_zd_id, products_id) VALUES ($sub_zd_id, $products_id)");
			}

			$glowne = isset ($zmiana->pola['glowne']) && $zmiana->pola['glowne'];

			$pbin = & $zmiana->pola['wartosc'];

			// plik jest w jednym kawa³ku
			if (!$pbin->dlugosc_czesci) {
				$nowa_nazwa_pliku = wygeneruj_nazwe_pliku_zdjecia($sub_zd_id, $products_id, $miniatura, $typ);
				$fp = @ fopen(DIR_FS_CATALOG_IMAGES . $nowa_nazwa_pliku, 'wb');
				if ($fp) {
					if (@ fwrite($fp, $pbin->wartosc) == $pbin->dlugosc_calkowita) {
						if ($miniatura) {
							if ($nazwa_pliku_miniatury)
								@ unlink(DIR_FS_CATALOG_IMAGES .
								$nazwa_pliku_miniatury);
							$nazwa_pliku_miniatury = $nowa_nazwa_pliku;
							tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_OK_MINIATURA);
						} else {
							if ($nazwa_pliku)
								@ unlink(DIR_FS_CATALOG_IMAGES .
								$nazwa_pliku);
							$nazwa_pliku = $nowa_nazwa_pliku;
							tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_OK_ZDJECIE);
						}
					} else {
						@ fclose($fp);
						@ unlink(DIR_FS_CATALOG_IMAGES . $nowa_nazwa_pliku);
						tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
						return;
					}
					@ fclose($fp);
				} else {
					tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
					return;
				}
			}
			// jedna z wielu czê¶ci jednego pliku
			else {

				if (!isset ($pbin->offset) || !isset ($pbin->dlugosc_czesci)) {
					tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
					return;
				}

				if ($miniatura && $nazwa_pliku_miniatury_temp)
					$nazwa_pliku_czesc = $nazwa_pliku_miniatury_temp;
				else
					if (!$miniatura && $nazwa_pliku_temp)
						$nazwa_pliku_czesc = $nazwa_pliku_temp;
					else
						$nazwa_pliku_czesc = wygeneruj_nazwe_pliku_zdjecia($sub_zd_id, $products_id, $miniatura, $typ);

				$fp = @ fopen(DIR_FS_CATALOG_IMAGES . $nazwa_pliku_czesc, 'ab');
				if ($fp) {

					// gdy nieprawid³owy offset
					if (filesize(DIR_FS_CATALOG_IMAGES . $nazwa_pliku_czesc) != $pbin->offset) {
						@ fclose($fp);
						@ unlink(DIR_FS_CATALOG_IMAGE . $nazwa_pliku_czesc);
						tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
						return;
					}

					if (@ fwrite($fp, $pbin->wartosc) == $pbin->dlugosc_czesci) {
						if ($pbin->offset + $pbin->dlugosc_czesci == $pbin->dlugosc_calkowita) {
							// to by³a ostatnia czê¶æ
							if ($miniatura) {
								if ($nazwa_pliku_miniatury)
									@ unlink(DIR_FS_CATALOG_IMAGES .
									$nazwa_pliku_miniatury);
								$nazwa_pliku_miniatury = $nazwa_pliku_czesc;
								$nazwa_pliku_miniatury_temp = null;
								tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_OK_MINIATURA);
							} else {
								if ($nazwa_pliku)
									@ unlink(DIR_FS_CATALOG_IMAGES .
									$nazwa_pliku);
								$nazwa_pliku = $nazwa_pliku_czesc;
								$nazwa_pliku_temp = null;
								tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_OK_ZDJECIE);
							}
						} else {
							if ($miniatura) {
								$nazwa_pliku_miniatury_temp = $nazwa_pliku_czesc;
							} else {
								$nazwa_pliku_temp = $nazwa_pliku_czesc;
							}
						}
					} else {
						@ fclose($fp);
						@ unlink(DIR_FS_CATALOG_IMAGES . $nazwa_pliku_czesc);
						tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
						return;
					}

					@ fclose($fp);
				} else {
					tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
					return;
				}
			}

			// w razie powodzenia, aktualizacja tw_zdjecie
			tw_db_query('UPDATE tw_zdjecie SET ' .
			' glowne = ' . (int) $glowne . ', ' .
			' nazwa_pliku = ' . ($nazwa_pliku ? "'$nazwa_pliku'" : 'NULL') . ', ' .
			' nazwa_pliku_temp = ' . ($nazwa_pliku_temp ? "'$nazwa_pliku_temp'" : 'NULL') . ', ' .
			' nazwa_pliku_miniatury = ' . ($nazwa_pliku_miniatury ? "'$nazwa_pliku_miniatury'" : 'NULL') . ', ' .
			' nazwa_pliku_miniatury_temp = ' . ($nazwa_pliku_miniatury_temp ? "'$nazwa_pliku_miniatury_temp'" : 'NULL') .
			//', ' .'hash_oryginalu = \'' . tw_db_input($zmiana->pola['hash_oryginalu']) . '\' ' .
			' WHERE sub_zd_id=' . $sub_zd_id);
			break;
		case TW_TYPZMIANY_AKTUALIZACJA :
			if (isset ($zmiana->pola['nazwa_pliku'])) {
				$aktualizuj_zdjecia_towaru = false;
				$rs = tw_db_query("SELECT COUNT(*) cnt FROM tw_zdjecie WHERE sub_zd_id = $sub_zd_id");
				$row = tw_db_fetch_array($rs);
				tw_db_free_result($rs);
				tw_db_perform('tw_zdjecie', array (
					'sub_zd_id' => $sub_zd_id,
					'products_id' => $products_id,
					'nazwa_pliku' => $zmiana->pola['nazwa_pliku']/*,
					'hash_oryginalu' => $zmiana->pola['hash_oryginalu']*/
				), $row['cnt'] ? 'update' : 'insert', $row['cnt'] ? " WHERE sub_zd_id = $sub_zd_id " : '');
				tw_potwierdz_zmiane($zmiana);
			} else if (isset ($zmiana->pola['glowne'])) {
				$glowne = (int) $zmiana->pola['glowne'];
				tw_db_query('UPDATE tw_zdjecie SET glowne=' . $glowne . ' WHERE sub_zd_id= ' . $sub_zd_id);
				tw_potwierdz_zmiane($zmiana);
			}
			break;
		case TW_TYPZMIANY_USUNIECIE :
			usun_zdjecie($sub_zd_id);
			tw_potwierdz_zmiane($zmiana);
			break;
	}
	if ($aktualizuj_zdjecia_towaru) {
		aktualizuj_zdjecia_towaru($products_id, $sub_zd_id);
	}
}

function zapisz_plik_graficzny(& $pole, & $nazwa_pliku, & $nazwa_pliku_temp, $pozadana_nazwa_pliku, $typ = 'jpg') {

	if (!$typ) {
		$typ = 'jpg';
	}

	if (!$pole->dlugosc_calkowita) {
		return false;
	}

	$stara_nazwa = $nazwa_pliku;
	$stara_nazwa_temp = $nazwa_pliku_temp;

	$unikalna_nazwa = trim(@ereg_replace('[^a-zA-Z0-9]', '_', $pozadana_nazwa_pliku));
	$unikalna_nazwa = uniqid($unikalna_nazwa);
	$unikalna_nazwa = strlen($unikalna_nazwa) > 64 ? substr($unikalna_nazwa, -64 + strlen(TW_KATALOG_ZDJEC . '/.' . $typ)) : $unikalna_nazwa;
	$unikalna_nazwa = (TW_KATALOG_ZDJEC ? TW_KATALOG_ZDJEC . '/' : '') . $unikalna_nazwa . '.' . $typ;

	if (!$pole->dlugosc_czesci) {
		$fp = fopen(DIR_FS_CATALOG_IMAGES . $unikalna_nazwa, 'wb');
		if ($fp) {
			if (fwrite($fp, $pole->wartosc) == $pole->dlugosc_calkowita) {
				if ($stara_nazwa) {
					unlink(DIR_FS_CATALOG_IMAGES . $stara_nazwa);
				}
				$nazwa_pliku = $unikalna_nazwa;
			} else {
				fclose($fp);
				unlink(DIR_FS_CATALOG_IMAGES . $unikalna_nazwa);
				return false;
			}
			fclose($fp);
		} else {
			return false;
		}
	} else {
		if (!isset ($pole->offset)) // mo¿e byæ 0
			return false;
		if ($stara_nazwa_temp)
			$nazwa_pliku_temp = $stara_nazwa_temp;
		else
			$nazwa_pliku_temp = $unikalna_nazwa;
		$fp = fopen(DIR_FS_CATALOG_IMAGES . $nazwa_pliku_temp, 'ab');
		if ($fp) {
			if (filesize(DIR_FS_CATALOG_IMAGES . $nazwa_pliku_temp) != $pole->offset) {
				fclose($fp);
				unlink(DIR_FS_CATALOG_IMAGES . $nazwa_pliku_temp);
				return false;
			}
			if (fwrite($fp, $pole->wartosc) == $pole->dlugosc_czesci) {
				if ($pole->offset + $pole->dlugosc_czesci == $pole->dlugosc_calkowita) {
					if ($stara_nazwa) {
						unlink($stara_nazwa);
					}
					$nazwa_pliku = $nazwa_pliku_temp;
					$nazwa_pliku_temp = null;
				}
			} else {
				fclose($fp);
				unlink(DIR_FS_CATALOG_IMAGES . $nazwa_pliku_temp);
				return false;
			}
			fclose($fp);
		} else {
			return false;
		}
	}
	return true;
}

function przetworz_zmiane_grafiki_kategorii(& $zmiana) {
	if (!isset ($zmiana->osc_id)) {
		tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
		return;
	}

	$categories_id = (int) $zmiana->osc_id;
	$rs = tw_db_query('SELECT nazwa_pliku, nazwa_pliku_temp, osc_categories_id FROM ' . TABLE_CATEGORIES .
	' LEFT JOIN tw_kategoria ON categories_id = osc_categories_id WHERE categories_id = ' . $categories_id);
	$row = tw_db_fetch_array($rs);
	tw_db_free_result($rs);
	if (!$row) {
		tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
		$pkat = new potwierdzenie('kategoria', TW_TYPZMIANY_USUNIECIE, $categories_id);
		return;
	} else
		if (!$row['osc_categories_id']) {
			tw_db_query("INSERT INTO tw_kategoria (sub_okt_Id, osc_categories_id) VALUES ({$zmiana->sub_id}, {$zmiana->osc_id})");
		}
	$nazwa_pliku = $row['nazwa_pliku'];
	$nazwa_pliku_temp = $row['nazwa_pliku_temp'];

	if (isset ($zmiana->pola['wartosc'])) {
		if (zapisz_plik_graficzny($zmiana->pola['wartosc'], $nazwa_pliku, $nazwa_pliku_temp, $zmiana->pola['nazwa'], $zmiana->pola['typ'])) {
			tw_db_query('UPDATE ' . TABLE_CATEGORIES . ' SET categories_image = \'' . $nazwa_pliku . '\' WHERE categories_id = ' . $categories_id);
			tw_potwierdz_zmiane($zmiana);
		} else {
			tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
		}
	} else {
		if ($nazwa_pliku) {
			unlink(DIR_FS_CATALOG_IMAGES . $nazwa_pliku);
		}
		$nazwa_pliku = null;
		if ($nazwa_pliku_temp) {
			unlink(DIR_FS_CATALOG_IMAGES . $nazwa_pliku_temp);
		}
		$nazwa_pliku_temp = null;
		tw_db_query('UPDATE '.TABLE_CATEGORIES.' SET categories_image = NULL WHERE categories_id = '.(int)$zmiana->osc_id);
		tw_potwierdz_zmiane($zmiana);
	}

	tw_db_query('UPDATE tw_kategoria SET nazwa_pliku = ' . ($nazwa_pliku ? "'$nazwa_pliku'" : 'NULL') .
	', nazwa_pliku_temp = ' . ($nazwa_pliku_temp ? "'$nazwa_pliku_temp'" : 'NULL') .
	', hash_oryginalu = ' . (isset ($zmiana->pola['hash_oryginalu']) ? "'" . tw_db_input($zmiana->pola['hash_oryginalu']) . "'" : 'NULL') .
	' WHERE osc_categories_id = ' . $categories_id);
}

function przetworz_zmiane_grafiki(& $zmiana) {
	if (!isset ($zmiana->sub_id)) {
		tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
		return;
	}
	$sub_kh_id = (int) $zmiana->sub_id;
	$typ = isset ($zmiana->pola['typ']) ? $zmiana->pola['typ'] : 'jpg';

	switch ($zmiana->typ_zmiany) {
		case TW_TYPZMIANY_USUNIECIE :
			$rs = tw_db_query('SELECT nazwa_pliku, nazwa_pliku_temp, osc_manufacturers_id FROM tw_producent WHERE sub_kh_id=' . $sub_kh_id);
			$row = tw_db_fetch_array($rs);
			if ($row) {
				@ unlink(DIR_FS_CATALOG_IMAGES . $row['nazwa_pliku']);
				@ unlink(DIR_FS_CATALOG_IMAGES . $row['nazwa_pliku_temp']);
				tw_db_query('UPDATE ' . TABLE_MANUFACTURERS . ' SET manufacturers_image = NULL WHERE manufacturers_id=' . $row['osc_manufacturers_id']);
			}
			tw_db_query('UPDATE tw_producent SET nazwa_pliku = NULL, nazwa_pliku_temp = NULL, hash_oryginalu = NULL WHERE sub_kh_id=' . $sub_kh_id);

			tw_potwierdz_zmiane($zmiana);
			tw_db_free_result($rs);
			break;
		case TW_TYPZMIANY_DODAWANIE_JESLI_NIE_ISTNIEJE :
			$rs = tw_db_query('SELECT nazwa_pliku, nazwa_pliku_temp, manufacturers_name, manufacturers_id FROM tw_producent INNER JOIN ' . TABLE_MANUFACTURERS . ' ON osc_manufacturers_id = manufacturers_id WHERE sub_kh_id=' . $sub_kh_id);
			$row = tw_db_fetch_array($rs);
			if (!$row)
				return;
			$stara_nazwa = $row['nazwa_pliku'];
			$stara_nazwa_temp = $row['nazwa_pliku_temp'];
			$mid = $row['manufacturers_id'];
			$nazwa = trim(@ereg_replace('[^a-zA-Z0-9]', '_', $row['manufacturers_name']));
			$nazwa = uniqid($nazwa . '_' . $sub_kh_id . '_');
			$nazwa = strlen($nazwa) > 64 ? substr($nazwa, -64 + strlen(TW_KATALOG_ZDJEC . '/' . '.' . $typ)) : $nazwa;
			$nazwa = (TW_KATALOG_ZDJEC ? TW_KATALOG_ZDJEC . '/' : '') . $nazwa . '.' . $typ;

			$pbin = & $zmiana->pola['wartosc'];

			if (!$pbin->dlugosc_czesci) {
				$fp = @ fopen(DIR_FS_CATALOG_IMAGES . $nazwa, 'wb');
				if ($fp) {
					if (@ fwrite($fp, $pbin->wartosc) == $pbin->dlugosc_calkowita) {
						if ($stara_nazwa)
							@ unlink(DIR_FS_CATALOG_IMAGES .
							$stara_nazwa);
						$nowa_nazwa = $nazwa;
						tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_OK);
					} else {
						@ fclose($fp);
						@ unlink(DIR_FS_CATALOG_IMAGES . $nazwa);
						tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
						return;
					}
					@ fclose($fp);
				} else {
					tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
					return;
				}
			} else {

				if (!isset ($pbin->offset) || !isset ($pbin->dlugosc_czesci)) {
					tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
					return;
				}

				if ($stara_nazwa_temp)
					$nazwa_pliku_czesc = $stara_nazwa_temp;
				else
					$nazwa_pliku_czesc = $nazwa;

				$fp = @ fopen(DIR_FS_CATALOG_IMAGES . $nazwa_pliku_czesc, 'ab');
				if ($fp) {
					if (filesize(DIR_FS_CATALOG_IMAGES . $nazwa_pliku_czesc) != $pbin->offset) {
						@ fclose($fp);
						@ unlink(DIR_FS_CATALOG_IMAGE . $nazwa_pliku_czesc);
						tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
						return;
					}

					if (@ fwrite($fp, $pbin->wartosc) == $pbin->dlugosc_czesci) {
						if ($pbin->offset + $pbin->dlugosc_czesci == $pbin->dlugosc_calkowita) {
							$nowa_nazwa = $nazwa_pliku_czesc;
							$nowa_nazwa_temp = null;
							tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_OK);
						} else {
							$nowa_nazwa_temp = $nazwa_pliku_czesc;
						}
					} else {
						@ fclose($fp);
						@ unlink(DIR_FS_CATALOG_IMAGES . $nazwa_pliku_czesc);
						tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
						return;
					}

					@ fclose($fp);
				} else {
					tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
					return;
				}
			}

			tw_db_query("UPDATE tw_producent " .
			"SET nazwa_pliku = " . (isset ($nowa_nazwa) ? "'$nowa_nazwa'," : 'NULL,') .
			"nazwa_pliku_temp = " . (isset ($nowa_nazwa_temp) ? "'$nowa_nazwa_temp' " : 'NULL ') . ', ' .
			"hash_oryginalu = '" . tw_db_input($zmiana->pola['hash_oryginalu']) . "' " .
			" WHERE sub_kh_id=$sub_kh_id");

			if (isset ($nowa_nazwa)) {
				tw_db_query('UPDATE ' . TABLE_MANUFACTURERS . ' SET manufacturers_image =\'' . $nowa_nazwa . '\' WHERE manufacturers_id = ' . $mid);
			}
			break;
	}

}

// przetwarza stany zamowien
function tw_przetworz_zmiane_zamowienia($zmiana) {
	switch ($zmiana->typ_zmiany) {
		case TW_TYPZMIANY_AKTUALIZACJA :

			$stan = ($zmiana->pola["stan"] == 0) ? 'dostarczono' : 'zrealizowano';

			switch ($res = ustaw_status_zamowienia($zmiana->osc_id, $stan)) {
				case 0 :
					tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_OK);
					break;
				case 1 :
					tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BRAK_ZAMOWIENIA);
					break;
				case 2 :
					tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BRAK_MAPOWANIA_STANU);
					break;
				default :
					tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
					break;
			}

			break;
	}
}

function przetworz_zmiane_kategorii(& $zmiana) {
	global $zmiany_kategorii_dodawanie, $zmiany_kategorii_aktualizacja;
	switch ($zmiana->typ_zmiany) {
		case TW_TYPZMIANY_DODAWANIE :
			// sprawdzenie czy zmiana jest poprawna
			if (!isset ($zmiana->sub_id) || !isset ($zmiana->pola['nazwa']) || !isset ($zmiana->pola['nadrzedna']) || !is_a($zmiana->pola['nadrzedna'], 'pole_referencyjne') || !isset ($zmiana->pola['pozycja'])) {
				tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
				return;
			}
			// sprawdzenie, czy kategoria jest ju¿ dodana
			$rs = tw_db_query('SELECT osc_categories_id FROM tw_kategoria ' .
			'INNER JOIN ' . TABLE_CATEGORIES . ' ON osc_categories_id = ' . TABLE_CATEGORIES . '.categories_id ' .
				//'INNER JOIN '.TABLE_CATEGORIES_DESCRIPTION.' ON '.TABLE_CATEGORIES.'.categories_id = '.TABLE_CATEGORIES_DESCRIPTION.'.categories_id '.
	'WHERE sub_okt_Id = ' . (int) $zmiana->sub_id);
			//.' AND language_id = '.(int)TW_LANGUAGE_ID);
			$row = tw_db_fetch_array($rs);
			if ($row) {
				$zmiana->osc_id = $row['osc_categories_id'];
				$zmiany_kategorii_aktualizacja[$zmiana->osc_id] = $zmiana;
			} else {
				$zmiany_kategorii_dodawanie[$zmiana->sub_id] = $zmiana;
			}
			tw_db_free_result($rs);
			break;
		case TW_TYPZMIANY_AKTUALIZACJA :
			// sprawdzenie czy zmiana typu aktualizacja jest poprawna
			if (!isset ($zmiana->osc_id) || !isset ($zmiana->pola['nazwa']) && !isset ($zmiana->pola['pozycja']) && !isset ($zmiana->pola['nadrzedna']) || isset ($zmiana->pola['nadrzedna']) && !is_a($zmiana->pola['nadrzedna'], 'pole_referencyjne')) {
				tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
				return;
			}
			$rs = tw_db_query('SELECT COUNT(*) cnt FROM ' . TABLE_CATEGORIES . ' ' .
				//'INNER JOIN '.TABLE_CATEGORIES_DESCRIPTION.' ON '.TABLE_CATEGORIES.'.categories_id = '.TABLE_CATEGORIES_DESCRIPTION.'.categories_id '.
	'WHERE ' . TABLE_CATEGORIES . '.categories_id = ' . (int) $zmiana->osc_id);
			//.' AND language_id = '.(int)TW_LANGUAGE_ID);
			$row = tw_db_fetch_array($rs);
			tw_db_free_result($rs);
			if (!$row['cnt']) {
				$zmiana->typ_zmiany = TW_TYPZMIANY_USUNIECIE;
				tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_OK);
				return;
			}
			$zmiany_kategorii_aktualizacja[$zmiana->osc_id] = $zmiana;
			break;
		case TW_TYPZMIANY_USUNIECIE :
			if (!isset ($zmiana->osc_id)) {
				tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_BLAD);
			} else {
				$rs = tw_db_query('SELECT nazwa_pliku, nazwa_pliku_temp FROM tw_kategoria WHERE osc_categories_id = ' . (int) $zmiana->osc_id);
				$row = tw_db_fetch_array($rs);
				tw_db_free_result($rs);
				if ($row) {
					if ($row['nazwa_pliku']) {
						unlink($row['nazwa_pliku']);
					}
					if ($row['nazwa_pliku_temp']) {
						unlink($row['nazwa_pliku_temp']);
					}
				}
				tw_db_query('DELETE FROM ' . TABLE_CATEGORIES_DESCRIPTION . ' WHERE categories_id = ' . (int) $zmiana->osc_id);
				tw_db_query('DELETE FROM ' . TABLE_PRODUCTS_TO_CATEGORIES . ' WHERE categories_id = ' . (int) $zmiana->osc_id);
				tw_db_query('UPDATE ' . TABLE_CATEGORIES . ' SET parent_id = 0 WHERE parent_id = ' . (int) $zmiana->osc_id);
				tw_db_query('DELETE FROM ' . TABLE_CATEGORIES . ' WHERE categories_id = ' . (int) $zmiana->osc_id);
				tw_db_query('DELETE FROM tw_kategoria WHERE osc_categories_id = ' . (int) $zmiana->osc_id);
				tw_potwierdz_zmiane($zmiana, TW_STATUSPOTWIERDZENIA_OK);
			}
			break;
	}
}

function dodaj_kategorie(& $zmiana) {
	global $zmiany_kategorii_dodawanie;
	if ($zmiana->pola['nadrzedna']->sub_id && isset ($zmiany_kategorii_dodawanie[$zmiana->pola['nadrzedna']->sub_id])) {
		dodaj_kategorie($zmiany_kategorii_dodawanie[$zmiana->pola['nadrzedna']->sub_id]);
	}
	przetworz_zmiane_kategorii_wewn($zmiana);
}

function przetworz_zmiane_kategorii_wewn(& $zmiana) {
	global $zmiany_kategorii_dodawanie, $zmiany_kategorii_przetworzone;

	if (isset ($zmiana->osc_id) && isset ($zmiany_kategorii_przetworzone[$zmiana->osc_id])) {
		return;
	}

	$db_action = $zmiana->osc_id ? 'update' : 'insert';
	$db_parameters = $zmiana->osc_id ? ('categories_id = ' . (int) $zmiana->osc_id) : '';

	$categories_parent_id = null;

	// kategoria nadrzêdna identyfikowana jest idem subiektowym
	if (isset ($zmiana->pola['nadrzedna']) && $zmiana->pola['nadrzedna']->sub_id && !isset ($zmiana->pola['nadrzedna']->osc_id)) {

		if (isset ($zmiany_kategorii_dodawanie[$zmiana->pola['nadrzedna']->sub_id]) && $zmiany_kategorii_dodawanie[$zmiana->pola['nadrzedna']->sub_id]->osc_id) {
			$categories_parent_id = $zmiany_kategorii_dodawanie[$zmiana->pola['nadrzedna']->sub_id]->osc_id;
		} /*else {
																	$rs = tw_db_query('SELECT osc_categories_id FROM tw_kategoria WHERE sub_okt_Id = ' . (int) $zmiana->pola['nadrzedna']->sub_id);
																	$row = tw_db_fetch_array($rs);
																	tw_db_free_result($rs);
																	if ($row) {
																		$categories_parent_id = $row['osc_categories_id'];
																	}
																}*/
	}

	if (!isset ($categories_parent_id) && isset ($zmiana->pola['nadrzedna']) && $zmiana->pola['nadrzedna']->osc_id) {
		$categories_parent_id = $zmiana->pola['nadrzedna']->osc_id;
	}

	if (isset ($categories_parent_id)) {
		$rs = tw_db_query('SELECT COUNT(*) cnt FROM ' . TABLE_CATEGORIES . ' WHERE categories_id = ' . (int) $categories_parent_id);
		$row = tw_db_fetch_array($rs);
		tw_db_free_result($rs);
		if (!$row['cnt']) {
			$potw = new potwierdzenie('kategoria', 'usun', $categories_parent_id);
			tw_zapisz_potwierdzenie($potw);
			$categories_parent_id = 0;
		}
	}

	$table_categories_data = array ();
	if (isset ($categories_parent_id)) {
		$table_categories_data['parent_id'] = $categories_parent_id;
	} else
		if ($db_action == 'insert' || isset ($zmiana->pola['nadrzedna'])) {
			$table_categories_data['parent_id'] = 0;
		}

	if (isset ($zmiana->pola['pozycja'])) {
		$table_categories_data['sort_order'] = (int) $zmiana->pola['pozycja'];
	}
	if ($db_action == 'insert') {
		$table_categories_data['date_added'] = 'now()';
	}
	$table_categories_data['last_modified'] = 'now()';

	tw_db_perform(TABLE_CATEGORIES, $table_categories_data, $db_action, $db_parameters);

	if ($db_action == 'insert') {
		$zmiana->osc_id = tw_db_insert_id();
		tw_db_query('INSERT INTO tw_kategoria (sub_okt_Id, osc_categories_id) VALUES (' . (int) $zmiana->sub_id . ', ' . (int) $zmiana->osc_id . ')');
	}

	if (isset ($zmiana->pola['nazwa'])) {
		// dodawanie/aktualizacja w TABLE_CATEGORIES_DESCRIPTION;
		$rs = tw_db_query('SELECT COUNT(*) cnt FROM ' . TABLE_CATEGORIES . ' INNER JOIN ' . TABLE_CATEGORIES_DESCRIPTION . ' ' .
		'ON ' . TABLE_CATEGORIES . '.categories_id = ' . TABLE_CATEGORIES_DESCRIPTION . '.categories_id ' .
		'WHERE ' . TABLE_CATEGORIES . '.categories_id = ' . (int) $zmiana->osc_id . ' AND language_id = ' . (int) TW_LANGUAGE_ID);
		$row = tw_db_fetch_array($rs);
		tw_db_free_result($rs);
		$db_action = $row['cnt'] ? 'update' : 'insert';
		$db_parameters = $row['cnt'] ? ('categories_id = ' . (int) $zmiana->osc_id . ' AND language_id = ' . (int) TW_LANGUAGE_ID) : '';
		$table_categories_description_data = array (
			'categories_name' => tw_substr($zmiana->pola['nazwa'],
			0,
			LIMIT_CATEGORIES_NAME
		));
		if ($db_action == 'insert') {
			$table_categories_description_data['categories_id'] = (int) $zmiana->osc_id;
			$table_categories_description_data['language_id'] = (int) TW_LANGUAGE_ID;
		}
		tw_db_perform(TABLE_CATEGORIES_DESCRIPTION, $table_categories_description_data, $db_action, $db_parameters);
	}

	tw_potwierdz_zmiane($zmiana);
	$zmiany_kategorii_przetworzone[$zmiana->osc_id] = $zmiana;
}

function ep0_callback(& $zmiana) {
	switch ($zmiana->typ_obiektu) {
		case 'towar' :
			przetworz_zmiane_towaru($zmiana);
			break;
		case 'stan' :
			przetworz_zmiane_stanu($zmiana);
			break;
		case 'polawlasne' :
			if (TW_JEST_EXTRAFIELDS && defined('TW_PW_EXTRA_FIELDS_IDS')) {
				aktualizuj_slownik_pol_wlasnych($zmiana->pola);
			}
			break;
		case 'zdjecie' :
			przetworz_zmiane_zdjecia($zmiana);
			break;
		case 'grafika' :
			przetworz_zmiane_grafiki($zmiana);
			break;
		case 'zamowienie' :
			tw_przetworz_zmiane_zamowienia($zmiana);
			break;
		case 'kategoria' :
			przetworz_zmiane_kategorii($zmiana);
			break;
		case 'kategoria-grafika' :
			przetworz_zmiane_grafiki_kategorii($zmiana);
			break;
		default :
			break;
	}
}

$pola_wlasne = null;
if (defined('TW_PW_EXTRA_FIELDS_IDS')) {
	$pola_wlasne = explode(';', TW_PW_EXTRA_FIELDS_IDS);
}

tw_ustaw_parametry_pln();

// indeksowana identyfikatorem z GT
$zmiany_kategorii_dodawanie = array ();
// indeksowana identyfikatorem z osC
$zmiany_kategorii_aktualizacja = array ();
// indeksowana identyfikatorem z osC
$zmiany_kategorii_przetworzone = array ();

$ds = new deserializer_zmian('ep0_callback');
$ds->deserializuj($HTTP_RAW_POST_DATA);
$ds->free();

reset($zmiany_kategorii_dodawanie);
while (list ($sub_id,) = each($zmiany_kategorii_dodawanie)) {
	dodaj_kategorie($zmiany_kategorii_dodawanie[$sub_id]);
}
reset($zmiany_kategorii_aktualizacja);
while (list ($osc_id,) = each($zmiany_kategorii_aktualizacja)) {
	przetworz_zmiane_kategorii_wewn($zmiany_kategorii_aktualizacja[$osc_id]);
}
?>