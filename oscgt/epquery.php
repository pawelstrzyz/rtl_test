<?php
require_once 'epall.php';

if (!defined('DIR_FS_CATALOG_MODULES')) {
	$p = @ realpath(DIR_FS_CATALOG . '/' . DIR_WS_MODULES) . '/';
	if (!$p)
		$p = DIR_FS_CATALOG . DIR_WS_MODULES;
	define('DIR_FS_CATALOG_MODULES', $p);
}
if (!defined('DIR_FS_CATALOG_LANGUAGES')) {
	$p = @ realpath(DIR_FS_CATALOG . '/' . DIR_WS_LANGUAGES) . '/';
	if (!$p)
		$p = DIR_FS_CATALOG . DIR_WS_LANGUAGES;
	define('DIR_FS_CATALOG_LANGUAGES', $p);
}

function el_start($xp, $name, $attr) {
	if ($name = 'query' && isset ($attr['n'])) {
		echo "<query n='{$attr['n']}'>";
		switch ($attr['n']) {
			case 'jezyki' :
				query_languages();
				break;
			case 'strefy-podatkowe' :
				query_geozones();
				break;
			case 'moduly-platnosci' :
				query_payment();
				break;
			case 'kategorie' :
				query_categories($attr);
				break;
			case 'produkty' :
				query_products($attr);
				break;
			case 'kolumny-tabeli-orders' :
			    query_columns(TABLE_ORDERS);
			    break;
			case 'kolumny-tabeli-customers' :
			    query_columns(TABLE_CUSTOMERS);
			    break;
			case 'kolumny-tabeli-address-book' :
			    query_columns(TABLE_ADDRESS_BOOK);
			    break;
		}
		echo "</query>";
	}
}

function el_end($xp, $name) {
}

function query_products($attr) {
	global $pln_value;

	$waluta = tw_db_input(tw_substr(strtoupper($attr['waluta']), 0, 3));
	$waluta_wartosc = null;
	$rs = tw_db_query('SELECT value FROM ' . TABLE_CURRENCIES . " WHERE UPPER(code) = '$waluta'");
	$row = tw_db_fetch_array($rs);
	tw_db_free_result($rs);
	if ($row) {
		$waluta_wartosc = $row['value'];
	} else {
		$waluta = 'PLN';
		$waluta_wartosc = $pln_value;
	}

	echo tw_serializuj_pole($waluta, 'waluta');

	$ef_columns = array ();
	$ef_column_clause = '';
	$ef_join_clause = '';
	if (TW_JEST_EXTRAFIELDS) {
		if (TW_PW_EXTRA_FIELDS_IDS) {
			$ef_ids = explode(';', TW_PW_EXTRA_FIELDS_IDS);
		} else {
			$ef_ids = array ();
			for ($i = 1; $i <= 8; $i++) {
				$atname = 'pw' . $i;
				if (isset($attr[$atname])) {
					$efrs = tw_db_query('SELECT products_extra_fields_id FROM ' . TABLE_PRODUCTS_EXTRA_FIELDS .
					' WHERE products_extra_fields_name = \'' . tw_db_input($attr[$atname]) . '\'');
					if ($efrs) {
						$efrow = tw_db_fetch_array($efrs);
						tw_db_free_result($efrs);
						if ($efrow) {
							$ef_ids[] = array_shift($efrow);
						} else {
							break;
						}						
					} 
				} else {
					break;
				}
			}
		}
		foreach ($ef_ids as $ef_no => $ef_id) {
			$table_alias = 'ppef' . ($ef_no +1);
			$column_alias = 'pw' . ($ef_no +1);
			$ef_columns[] = $column_alias;
			$ef_column_clause .= ", $table_alias.products_extra_fields_value $column_alias ";
			$ef_join_clause .= ' LEFT JOIN ' . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " $table_alias ON (p.products_id = $table_alias.products_id AND $table_alias.products_extra_fields_id = $ef_id) ";
		}
	}

	$sql = 'SELECT ' .
	'  p.products_id, p.products_model, p.products_price, p.products_weight, p.products_status, p.products_image, ' .
	 (TW_JEST_ULTRAPICS ? 'p.products_image_xl_1, p.products_image_xl_2, p.products_image_xl_3, p.products_image_xl_4, p.products_image_xl_5, p.products_image_xl_6, ' : '') .
	 (TW_SA_ZDJECIA23 ? 'pi.image, ' : '') .
	'  tr.tax_rate, ' .
	'  pd.products_name, pd.products_description, pd.products_url, ' .
	'  m.manufacturers_id, twp.sub_kh_id, twp.nazwa_pliku, twp.hash_oryginalu, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url, ' .
	'  p2c.categories_id, ' .
	'  z0.sub_zd_id sub_zd_id_0 ' .
	 (TW_JEST_ULTRAPICS ? '  , z1.sub_zd_id sub_zd_id_1 ' .
	'  , z2.sub_zd_id sub_zd_id_2 ' .
	'  , z3.sub_zd_id sub_zd_id_3 ' .
	'  , z4.sub_zd_id sub_zd_id_4 ' .
	'  , z5.sub_zd_id sub_zd_id_5 ' .
	'  , z6.sub_zd_id sub_zd_id_6 ' : '') .
	 (TW_SA_ZDJECIA23 ? ', zpi.sub_zd_id ' : '') .
	$ef_column_clause .
	'FROM ' . TABLE_PRODUCTS . ' p ' .
	'  LEFT JOIN ' . TABLE_TAX_CLASS . ' tc ON tc.tax_class_id = p.products_tax_class_id ' .
	'  LEFT JOIN ' . TABLE_TAX_RATES . ' tr ON tr.tax_class_id = tc.tax_class_id AND tr.tax_zone_id = ' . (defined('TW_GEOZONE_ID') ? (int) TW_GEOZONE_ID : 0) . ' ' .
	'  LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ON pd.products_id = p.products_id AND pd.language_id = ' . (int) TW_LANGUAGE_ID . ' ' .
	'  LEFT JOIN ' . TABLE_MANUFACTURERS . ' m ON m.manufacturers_id = p.manufacturers_id ' .
	'  LEFT JOIN ' . TABLE_MANUFACTURERS_INFO . ' mi ON mi.manufacturers_id = m.manufacturers_id AND mi.languages_id = ' . (int) TW_LANGUAGE_ID . ' ' .
	'  LEFT JOIN tw_producent twp ON twp.osc_manufacturers_id = m.manufacturers_id ' .
	'  LEFT JOIN ' . TABLE_PRODUCTS_TO_CATEGORIES . ' p2c ON p2c.products_id = p.products_id ' .
	'  LEFT JOIN tw_zdjecie z0 ON p.products_image = z0.nazwa_pliku ' .
	 (TW_JEST_ULTRAPICS ? '  LEFT JOIN tw_zdjecie z1 ON p.products_image_xl_1 = z1.nazwa_pliku ' .
	'  LEFT JOIN tw_zdjecie z2 ON p.products_image_xl_2 = z2.nazwa_pliku ' .
	'  LEFT JOIN tw_zdjecie z3 ON p.products_image_xl_3 = z3.nazwa_pliku ' .
	'  LEFT JOIN tw_zdjecie z4 ON p.products_image_xl_4 = z4.nazwa_pliku ' .
	'  LEFT JOIN tw_zdjecie z5 ON p.products_image_xl_5 = z5.nazwa_pliku ' .
	'  LEFT JOIN tw_zdjecie z6 ON p.products_image_xl_6 = z6.nazwa_pliku ' : '') .
	 (TW_SA_ZDJECIA23 ? (' LEFT JOIN ' . TABLE_PRODUCTS_IMAGES . ' pi ON p.products_id = pi.products_id LEFT JOIN tw_zdjecie zpi ON pi.image = zpi.nazwa_pliku ') : '') .
	$ef_join_clause .
	'ORDER BY products_id';
	
	$rs = tw_db_query($sql);
	$towar = array ();
	$row = array ();
	while ($row = tw_db_fetch_array($rs)) {
		if ($towar && $towar['products_id'] != $row['products_id']) {
			echo tw_serializuj_pole($towar);
			flush();
			$towar = array ();
		}

		if (!$towar) {
			$towar['products_id'] = (int) $row['products_id'];
			$towar['products_model'] = (string) substr($row['products_model'], 0, 20);
			$towar['products_price'] = (double) $row['products_price'] * $waluta_wartosc;
			$towar['products_weight'] = (double) $row['products_weight'];
			$towar['products_name'] = (string) substr($row['products_name'], 0, 50);
			$towar['products_description'] = (string) $row['products_description'];
			$towar['products_url'] = (string) $row['products_url'];
			$towar['products_status'] = (bool) $row['products_status'];
			$towar['tax_rate'] = (double) $row['tax_rate'];
			$towar['manufacturers_id'] = (int) $row['manufacturers_id'];
			$towar['sub_kh_id'] = (int) $row['sub_kh_id'];
			$towar['manufacturers_name'] = (string) $row['manufacturers_name'];
			$towar['manufacturers_url'] = (string) $row['manufacturers_url'];
			$towar['manufacturers_image'] = (string) $row['manufacturers_image'];
			$towar['hash_oryginalu'] = $row['nazwa_pliku'] == $row['manufacturers_image'] ? (string) $row['hash_oryginalu'] : '';
			$towar['products_to_categories'] = array ();
			$towar['products_images'] = array ();
		}

		if ($row['categories_id']) {
			$towar['products_to_categories'][] = new pole_referencyjne('kategoria', (int) $row['categories_id']);
		}

		if ($row['products_image']) {
			$towar['products_images'][0] = array (
				'sciezka' => (string) $row['products_image'],
				'sub_zd_id' => (int) $row['sub_zd_id_0']
			);
		}

		if (TW_JEST_ULTRAPICS) {
			for ($i = 1; $i <= 6; $i++) {
				if ($row["products_image_xl_$i"]) {
					$towar['products_images'][$i] = array (
						'sciezka' => (string) $row["products_image_xl_$i"],
						'sub_zd_id' => (int) $row["sub_zd_id_$i"]
					);
				}
			}
		}
		
		if (TW_SA_ZDJECIA23) {
			if ($row['image'] && $row['image'] != $row['products_image']) {
				$towar['products_images'][] = array (
					'sciezka' => (string) $row['image'],
					'sub_zd_id' => (int) $row['sub_zd_id']
				);
			}
		}

		foreach ($ef_columns as $ef_column) {
			$towar[$ef_column] = (string) substr($row[$ef_column], 0, 50);
		}
	}
	tw_db_free_result($rs);
	if ($towar) {
		echo tw_serializuj_pole($towar);
		flush();
		$towar = array ();
	}
}

function query_payment() {
	$payment_modules = array ();
	$module_directory = DIR_FS_CATALOG_MODULES . 'payment/';
	$file_extension = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '.'));
	$directory_array = array ();
	if ($dir = @ dir($module_directory)) {
		while ($file = $dir->read()) {
			if (!is_dir($module_directory . $file)) {
				if (substr($file, strrpos($file, '.')) == $file_extension) {
					$directory_array[] = $file;
				}
			}
		}
		sort($directory_array);
		$dir->close();
	}
	$lang_dir = null;
	$rs = tw_db_query('SELECT directory FROM ' . TABLE_LANGUAGES . ' INNER JOIN tw_ustawienia ON languages_id = TW_LANGUAGE_ID');
	$row = tw_db_fetch_array($rs);
	if ($row) {
		$lang_dir = $row['directory'];
	}
	tw_db_free_result($row);
	foreach ($directory_array as $file) {
		$pmod_filename = DIR_FS_CATALOG_LANGUAGES . $lang_dir . '/modules/payment/' . $file;
		echo "\r\n<!-- DEBUG: szukanie nazwy modulu platnosci w pliku " . htmlspecialchars($pmod_filename) . " -->\r\n";
		$pmod_lines = @ file($pmod_filename);
		if ($pmod_lines)
			foreach ($pmod_lines as $line) {
				if (strpos($line, "_TEXT_TITLE'") !== false || strpos($line, "_CATALOG_TITLE'") !== false) {
					$constants_przed = array_keys(get_defined_constants());
					echo "\r\n<!-- DEBUG: Ewaluacja linii:\r\n" . htmlspecialchars($line) . " -->";
					eval ($line);
					$constants_po = array_keys(get_defined_constants());
					$constants_nowe = array_diff($constants_po, $constants_przed);
					if ($constants_nowe) {
						$pbin = new pole_binarne();
						$pbin->wartosc = constant(array_shift($constants_nowe));
						$pbin->dlugosc_calkowita = strlen($pbin->wartosc);
						$payment_modules[$file] = $pbin;
						break;
					}
				}
			}
	}
	echo tw_serializuj_pole($payment_modules);
}

function query_geozones() {
	$rs = tw_db_query('SELECT geo_zone_id, CAST(geo_zone_name AS BINARY) name_bin FROM ' . TABLE_GEO_ZONES);
	$geozones = array ();
	while ($row = tw_db_fetch_array($rs)) {
		$pref = new pole_referencyjne('strefa-podatkowa', $row['geo_zone_id']);
		$pbin = new pole_binarne();
		$pbin->wartosc = $row['name_bin'];
		$pbin->dlugosc_calkowita = strlen($row['name_bin']);
		$pmap = new pozycja_mapy($pref, $pbin);
		$geozones[] = $pmap;
	}
	tw_db_free_result($rs);
	echo tw_serializuj_pole($geozones);
}

function query_languages() {
	$languages = array ();
	static $encodings = array (
		'iso-8859-2',
		'iso-8859-1',
		'utf-8',
		'windows-1250',
		'us-ascii',
		'ibm852',
		'x-mac-ce',
		'ibm037',
		'ibm437',
		'ibm500',
		'asmo-708',
		'dos-720',
		'ibm737',
		'ibm775',
		'ibm850',
		'ibm855',
		'ibm857',
		'ibm00858',
		'ibm860',
		'ibm861',
		'dos-862',
		'ibm863',
		'ibm864',
		'ibm865',
		'cp866',
		'ibm869',
		'ibm870',
		'windows-874',
		'cp875',
		'shift_jis',
		'gb2312',
		'ks_c_5601-1987',
		'big5',
		'ibm1026',
		'ibm01047',
		'ibm01140',
		'ibm01141',
		'ibm01142',
		'ibm01143',
		'ibm01144',
		'ibm01145',
		'ibm01146',
		'ibm01147',
		'ibm01148',
		'ibm01149',
		'utf-16',
		'unicodefffe',
		'windows-1251',
		'windows-1252',
		'windows-1253',
		'windows-1254',
		'windows-1255',
		'windows-1256',
		'windows-1257',
		'windows-1258',
		'johab',
		'macintosh',
		'x-mac-japanese',
		'x-mac-chinesetrad',
		'x-mac-korean',
		'x-mac-arabic',
		'x-mac-hebrew',
		'x-mac-greek',
		'x-mac-cyrillic',
		'x-mac-chinesesimp',
		'x-mac-romanian',
		'x-mac-ukrainian',
		'x-mac-thai',
		'x-mac-icelandic',
		'x-mac-turkish',
		'x-mac-croatian',
		'utf-32',
		'utf-32be',
		'x-chinese-cns',
		'x-cp20001',
		'x-chinese-eten',
		'x-cp20003',
		'x-cp20004',
		'x-cp20005',
		'x-ia5',
		'x-ia5-german',
		'x-ia5-swedish',
		'x-ia5-norwegian',
		'x-cp20261',
		'x-cp20269',
		'ibm273',
		'ibm277',
		'ibm278',
		'ibm280',
		'ibm284',
		'ibm285',
		'ibm290',
		'ibm297',
		'ibm420',
		'ibm423',
		'ibm424',
		'x-ebcdic-koreanextended',
		'ibm-thai',
		'koi8-r',
		'ibm871',
		'ibm880',
		'ibm905',
		'ibm00924',
		'euc-jp',
		'x-cp20936',
		'x-cp20949',
		'cp1025',
		'koi8-u',
		'iso-8859-3',
		'iso-8859-4',
		'iso-8859-5',
		'iso-8859-6',
		'iso-8859-7',
		'iso-8859-8',
		'iso-8859-9',
		'iso-8859-13',
		'iso-8859-15',
		'x-europa',
		'iso-8859-8-i',
		'iso-2022-jp',
		'csiso2022jp',
		'iso-2022-jp',
		'iso-2022-kr',
		'x-cp50227',
		'euc-jp',
		'euc-cn',
		'euc-kr',
		'hz-gb-2312',
		'gb18030',
		'x-iscii-de',
		'x-iscii-be',
		'x-iscii-ta',
		'x-iscii-te',
		'x-iscii-as',
		'x-iscii-or',
		'x-iscii-ka',
		'x-iscii-ma',
		'x-iscii-gu',
		'x-iscii-pa',
		'utf-7'
	);
	$rs = tw_db_query('SELECT languages_id, CAST(name AS binary) name_bin, code, directory FROM ' . TABLE_LANGUAGES);
	while ($row = tw_db_fetch_array($rs)) {
		$lang_ref = new pole_referencyjne('jezyk', $row['languages_id']);
		$lang_name_bin = new pole_binarne();
		$lang_name_bin->wartosc = $row['name_bin'];
		$lang_name_bin->dlugosc_calkowita = strlen($row['name_bin']);
		$lang_params = array (
			'nazwa' => $lang_name_bin
		);
		$lang_params['kod'] = $row['code'];
		$langfilename = DIR_FS_CATALOG_LANGUAGES . $row['directory'] . '.php';
		echo "<!-- DEBUG: szukanie deklaracji kodowania w pliku " . htmlspecialchars($langfilename) . " -->";
		$langfilelines = @ file($langfilename, true);
		if ($langfilelines)
			foreach ($langfilelines as $line) {
				$linetolower = strtolower($line);
				if (strpos($linetolower, "define") !== false && strpos($line, "CHARSET") !== false) {
					echo "<!-- DEBUG: Szukanie w linii: " . htmlspecialchars($line) . " -->";
					foreach ($encodings as $encname) {
						if (strpos($linetolower, $encname) !== false) {
							$lang_params['kodowanie'] = $encname;
							break;
						}
					}
				}
			}

		$languages[] = new pozycja_mapy($lang_ref, $lang_params);
	}
	echo tw_serializuj_pole($languages);
}

function query_categories($attr) {
	$idy = null;

	if (isset ($attr['idy']) && $idy = explode(',', $attr['idy'])) {
		foreach ($idy as $idx => $id) {
			$id = (int) $id;
			if ($id)
				$idy[$idx] = $id;
			else
				unset ($idy[$idx]);
		}
	}

	$temp = array ();
	$rs = tw_db_query('SELECT ' . TABLE_CATEGORIES . '.categories_id, categories_image, ' .
	'parent_id, sort_order, categories_name, hash_oryginalu, nazwa_pliku FROM ' . TABLE_CATEGORIES . ' INNER JOIN ' .
	TABLE_CATEGORIES_DESCRIPTION . ' ON ' . TABLE_CATEGORIES . '.categories_id = ' .
	TABLE_CATEGORIES_DESCRIPTION . '.categories_id ' .
	'LEFT JOIN tw_kategoria ON tw_kategoria.osc_categories_id = ' . TABLE_CATEGORIES . '.categories_id WHERE language_id = ' . (int) TW_LANGUAGE_ID .
	 ($idy ? ' AND ' . TABLE_CATEGORIES . '.categories_id IN (' . implode(',', $idy) . ')' : ''));
	while ($row = tw_db_fetch_array($rs)) {
		$temp[$row['categories_id']] = $row;
	}
	tw_db_free_result($rs);

	$broken = array ();
	do {
		$parents = array ();
		foreach ($temp as $id => $row) {
			if ($row['parent_id'] && !in_array($row['parent_id'], $broken) && !isset ($temp[$row['parent_id']])) {
				if (!isset ($parents[$row['parent_id']])) {
					$parents[$row['parent_id']] = array ();
				}
				if (!in_array($id, $parents[$row['parent_id']])) {
					$parents[$row['parent_id']][] = $id;
				}
			}
		}
		if ($parents) {
			foreach ($parents as $id => $childrenids) {
				$rs = tw_db_query('SELECT ' . TABLE_CATEGORIES . '.categories_id, categories_image, ' .
				'parent_id, sort_order, categories_name FROM ' . TABLE_CATEGORIES . ' INNER JOIN ' .
				TABLE_CATEGORIES_DESCRIPTION . ' ON ' . TABLE_CATEGORIES . '.categories_id = ' .
				TABLE_CATEGORIES_DESCRIPTION . '.categories_id WHERE language_id = ' . TW_LANGUAGE_ID .
				' AND ' . TABLE_CATEGORIES . '.categories_id = ' . $id);
				if ($row = tw_db_fetch_array($rs)) {
					$temp[$id] = $row;
				} else {
					//foreach ($childrenids as $childid) {
					//	$temp[$childid]['parent_id'] = 0;
					//}
					$broken[] = $id;
				}
				tw_db_free_result($rs);
			}
		}
	} while ($parents);

	$wynik = array ();
	foreach ($temp as $id => $row) {
		$pref = new pole_referencyjne('kategoria', $id);
		unset ($row['categories_id']);
		$row['categories_image'] = (string) $row['categories_image'];
		$row['parent_id'] = (int) $row['parent_id'];
		$row['sort_order'] = (int) $row['sort_order'];
		$row['categories_name'] = (string) $row['categories_name'];
		$row['hash_oryginalu'] = $row['categories_image'] == $row['nazwa_pliku'] ? (string) $row['hash_oryginalu'] : '';
		unset ($row['nazwa_pliku']);
		$pmap = new pozycja_mapy($pref, $row);
		$wynik[] = $pmap;
	}

	echo tw_serializuj_pole($wynik);
}

function query_columns($table_name) {
  $wynik = array();
  $rs = tw_db_query("DESCRIBE `" . mysql_real_escape_string($table_name) . "`");
  $i = 0;
  while ($row = tw_db_fetch_array($rs)) {
    $wynik[] = new pozycja_mapy($i++, (string)$row['Field']);
  }
  echo tw_serializuj_pole($wynik);
}

tw_ustaw_parametry_pln();

$xp = xml_parser_create('');
xml_parser_set_option($xp, XML_OPTION_CASE_FOLDING, false);
if ((int) substr(phpversion(), 0, 1) >= 5) {
	xml_parser_set_option($xp, XML_OPTION_TARGET_ENCODING, 'UTF-8');
}
xml_set_element_handler($xp, 'el_start', 'el_end');

echo '<queries>';
xml_parse($xp, $HTTP_RAW_POST_DATA);
echo '</queries>';
xml_parser_free($xp);
?>