<?php
require_once 'epall.php';
$narzut_pamieci = 0;
if (function_exists('memory_get_usage')) {
	$narzut_pamieci = memory_get_usage();
}

$katalog_zdjec = TW_KATALOG_ZDJEC;

// odbieranie parametrów

function el_start($xp, $elname, $atts) {
	if ($elname == 'param' && isset ($atts['n']) && isset ($atts['v'])) {
		switch ($atts['n']) {
			case 'TW_LANGUAGE_ID' :
				$rs = tw_db_query('SELECT COUNT(*) c FROM ' . TABLE_LANGUAGES . ' WHERE languages_id = ' . (int) $atts['v']);
				$row = tw_db_fetch_array($rs);
				if ($row['c'] > 0)
					tw_db_query('UPDATE tw_ustawienia SET TW_LANGUAGE_ID = ' .
					(int) $atts['v']);
				break;
			case 'TW_GEOZONE_ID' :
				$rs = tw_db_query('SELECT COUNT(*) c FROM ' . TABLE_GEO_ZONES . ' WHERE geo_zone_id = ' . (int) $atts['v']);
				$row = tw_db_fetch_array($rs);
				if ($row['c'] > 0) {
					tw_db_query('UPDATE tw_ustawienia SET TW_GEOZONE_ID = ' .
					(int) $atts['v']);
				} else {
					tw_db_query('UPDATE tw_ustawienia SET TW_GEOZONE_ID = NULL');
				}

				break;
				/*case 'TW_KODOWANIE_TRANSPORT' :
					tw_db_query('UPDATE tw_ustawienia SET TW_KODOWANIE_TRANSPORT = \'' . tw_db_input($atts['v']) . '\'');
					break;*/
			case 'TW_DEKLARUJ_KODOWANIE_W_BD' :
				tw_db_query('UPDATE tw_ustawienia SET TW_DEKLARUJ_KODOWANIE_W_BD = ' . ($atts['v'] ? '1' : '0'));
				break;
			case 'TW_KOLUMNA_NIP_DLA_ZAMOWIEN_Z_KLIENTEM' :
			case 'TW_KOLUMNA_NIP_DLA_ZAMOWIEN_BEZ_KLIENTA' :
			case 'TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_Z_KLIENTEM' :
			case 'TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_BEZ_KLIENTA' :
			    tw_db_query('UPDATE tw_ustawienia SET ' . $atts['n'] . " = '" . mysql_real_escape_string($atts['v']) . "'");
			    break;
			case 'TW_KATALOG_ZDJEC' :
				global $katalog_zdjec;
				$katalog_zdjec = @ereg_replace('[^a-zA-Z0-9]', '_', substr($atts['v'], 0, 20));
				tw_db_query('UPDATE tw_ustawienia SET TW_KATALOG_ZDJEC = \'' . tw_db_input($katalog_zdjec) . '\'');
				if (!@ is_dir(DIR_FS_CATALOG_IMAGES . $katalog_zdjec)) {
					@ mkdir(DIR_FS_CATALOG_IMAGES . $katalog_zdjec);
				}

				break;
		}
	}
}

function el_end($xp, $elname) {
}

$xp = xml_parser_create('');
xml_parser_set_option($xp, XML_OPTION_CASE_FOLDING, false);
xml_set_element_handler($xp, 'el_start', 'el_end');
xml_parse($xp, $HTTP_RAW_POST_DATA);
xml_parser_free($xp);

// wysy³anie parametrów
ob_start();

// pomocnicza funkcja wysy³aj±ca pojedynczy parametr
function wyslij_parametr($nazwa, $wartosc) {
	echo '<param n="' . htmlspecialchars($nazwa) . '">';
	echo htmlspecialchars($wartosc);
	echo '</param>';
}

// funkcja z manuala php do konwersji warto¶ci z php.ini na liczby
function return_bytes($val) {
	$val = trim($val);
	$last = strtolower($val {
		strlen($val) - 1 });
	switch ($last) {
		// The 'G' modifier is available since PHP 5.1.0
		case 'g' :
			$val *= 1024;
		case 'm' :
			$val *= 1024;
		case 'k' :
			$val *= 1024;
	}
	return $val;
}

// wysy³anie danych
echo '<tw-config>';

// parametry konfiguracyjne
echo '<parameters>';

// parametry z tw_ustawienia
$rs = tw_db_query('SELECT TW_GEOZONE_ID, TW_LANGUAGE_ID, TW_KATALOG_ZDJEC, TW_DEKLARUJ_KODOWANIE_W_BD, TW_KOLUMNA_NIP_DLA_ZAMOWIEN_Z_KLIENTEM, TW_KOLUMNA_NIP_DLA_ZAMOWIEN_BEZ_KLIENTA, TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_Z_KLIENTEM, TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_BEZ_KLIENTA FROM tw_ustawienia');
$row = tw_db_fetch_array($rs);
foreach ($row as $k => $v) {
	wyslij_parametr($k, $v);
}

// parametry wykrywane w czasie dzia³ania wszystkich skryptów
wyslij_parametr('TW_JEST_ULTRAPICS', (int) tw_wykryj_ultrapics());
wyslij_parametr('TW_JEST_EXTRAFIELDS', (int) tw_wykryj_extrafields());
wyslij_parametr('TW_SA_ZDJECIA23', (int) tw_wykryj_zdjecia23());

$memory_limit = ini_get('memory_limit');

wyslij_parametr('TW_NARZUT_EPALL', $narzut_pamieci);
wyslij_parametr('POST_MAX_SIZE', return_bytes(ini_get('post_max_size')));
wyslij_parametr('MEMORY_LIMIT', $memory_limit ? return_bytes($memory_limit) : -1);

// sprawdzenie, czy mo¿na zapisywaæ do ustawionego katalogu ze zdjêciami
wyslij_parametr('DIR_FS_CATALOG_IMAGES', DIR_FS_CATALOG_IMAGES);
$nazwa_pliku = DIR_FS_CATALOG_IMAGES . $katalog_zdjec . '/' . uniqid('twtest');
$writable = @ touch($nazwa_pliku);
@ unlink($nazwa_pliku);
wyslij_parametr('TW_KATALOG_ZDJEC_JEST_ZAPISYWALNY', (int) $writable);

wyslij_parametr('HTTP_SERVER', HTTP_SERVER);
wyslij_parametr('DIR_WS_HTTP_CATALOG', DIR_WS_HTTP_CATALOG);
wyslij_parametr('DIR_WS_IMAGES', DIR_WS_IMAGES);

// kodowanie w bazie danych
$wersja_mysql = mysql_get_server_info();
wyslij_parametr('WERSJA_MYSQL_SERWER', $wersja_mysql);
wyslij_parametr('WERSJA_MYSQL_KLIENT', mysql_get_client_info());
wyslij_parametr('WERSJA_PHP', phpversion());
$kodowanie_bd = null;
if (substr($wersja_mysql, 0, 1) >= '5' || substr($wersja_mysql, 0, 3) == '4.1') {
	$rs = tw_db_query("SHOW VARIABLES LIKE 'character_set_database'");
	if ($row = tw_db_fetch_array($rs)) {
		$kodowanie_bd = array_pop($row);
	}
} else {
	$rs = tw_db_query("SHOW VARIABLES LIKE 'character_set'");
	if ($row = tw_db_fetch_array($rs)) {
		$kodowanie_bd = array_pop($row);
	}
}
	
if ($kodowanie_bd) {
	wyslij_parametr('KODOWANIE_BD', $kodowanie_bd);
}

echo '</parameters>';
echo '</tw-config>';

// zakoñczenie wysy³ania
ob_end_flush();
?>