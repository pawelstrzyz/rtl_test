<?php
header('Content-Type: text/html; charset=iso-8859-2');
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0'); // HTTP/1.1
header('Pragma: no-cache'); // HTTP/1.0
ini_set('html_errors', false);
ini_set('display_errors', true); // po to, ¿eby widoczne by³y fatal errors
ini_set('output_handler', null);
ini_set('zlib.output_handler', null);

$osc_ddl =<<<KONIEC
DROP TABLE IF EXISTS `tw_temp_dodane_id`;
CREATE TABLE `tw_temp_dodane_id` (
`id` INT NOT NULL,
PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `tw_towar`;
CREATE TABLE `tw_towar` (
`sub_id` INT NOT NULL ,
`osc_id` INT NOT NULL ,
`specials_id` INT NULL,
PRIMARY KEY ( `sub_id` , `osc_id` )
);

DROP TABLE IF EXISTS `tw_zdjecie`;
CREATE TABLE `tw_zdjecie` (
  `sub_zd_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `glowne` tinyint(4) NOT NULL default '0',
  `nazwa_pliku` varchar(255) default NULL,
  `nazwa_pliku_temp` varchar(255) default NULL,
  `nazwa_pliku_miniatury` varchar(255) default NULL,
  `nazwa_pliku_miniatury_temp` varchar(255) default NULL,
  PRIMARY KEY  (`sub_zd_id`)
);

DROP TABLE IF EXISTS tw_producent;
CREATE TABLE tw_producent (
  sub_kh_id int NOT NULL,
  osc_manufacturers_id int NOT NULL,
  `nazwa_pliku` varchar(64) default NULL,
  `nazwa_pliku_temp` varchar(64) default NULL,
  `hash_oryginalu` varchar(32) NULL,
  PRIMARY KEY (sub_kh_id)  
);

DROP TABLE IF EXISTS `tw_potwierdzenia`;
CREATE TABLE `tw_potwierdzenia` (
  `potwierdzenie_id` int(11) NOT NULL auto_increment,
  `typ_obiektu` varchar(64) NOT NULL default '',
  `typ_zmiany` tinyint(4) NOT NULL default '0',
  `sub_id` int(11) default NULL,
  `osc_id` int(11) default NULL,
  `status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`potwierdzenie_id`)
);

DROP TABLE IF EXISTS `tw_autentykacja`;
CREATE TABLE `tw_autentykacja` (
  `tw_aut_id` int(11) NOT NULL default '1',
  `licznik` int(11) NOT NULL default '0',
  `blowfish_secret` binary(32) NULL,
  PRIMARY KEY  (`tw_aut_id`)
);
INSERT INTO `tw_autentykacja` (`tw_aut_id`) VALUES (1);

DROP TABLE IF EXISTS `tw_ustawienia`;
CREATE TABLE `tw_ustawienia` (
  `tw_ust_id` int(11) NOT NULL default '1',
  `wersja` int(11) NOT NULL default '0',
  `TW_LANGUAGE_ID` int(11) default NULL,
  `TW_GEOZONE_ID` int(11) default NULL,
  `TW_KATALOG_ZDJEC` varchar(64) NOT NULL default '',
  `TW_PW_EXTRA_FIELDS_IDS` varchar(64) NOT NULL default '',
  `TW_OPIS_CSSCLASS` varchar(64) NOT NULL default 'opis_z_subiekta',
  `TW_CHAR_CSSCLASS` varchar(64) NOT NULL default 'charakterystyka_z_subiekta',
  `TW_UWAGI_CSSCLASS` varchar(64) NOT NULL default 'uwagi_z_subiekta',
  `TW_KODOWANIE_TRANSPORT` varchar(64) default NULL,
  `TW_STAN_DOSTARCZONO_ID` int(11) NOT NULL default '-1',
  `TW_STAN_ZREALIZOWANO_ID` int(11) NOT NULL default '-1',
  `TW_DEKLARUJ_KODOWANIE_W_BD` TINYINT(1) NOT NULL DEFAULT '1',
  `TW_KOLUMNA_NIP_DLA_ZAMOWIEN_Z_KLIENTEM` varchar(64) NOT NULL default 'NULL',
  `TW_KOLUMNA_NIP_DLA_ZAMOWIEN_BEZ_KLIENTA` varchar(64) NOT NULL default 'NULL',
  `TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_Z_KLIENTEM` varchar(64) NOT NULL default 'NULL',
  `TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_BEZ_KLIENTA` varchar(64) NOT NULL default 'NULL',
  PRIMARY KEY  (`tw_ust_id`)
);
INSERT INTO tw_ustawienia (tw_ust_id) VALUES (1);

DROP TABLE IF EXISTS `tw_synchronizowane_zamowienia`;
CREATE TABLE `tw_synchronizowane_zamowienia` (
  `id_zamowienia` int(11) NOT NULL default '0',
  PRIMARY KEY(`id_zamowienia`)
);

DROP TABLE IF EXISTS `tw_zmiany_klienci`;
CREATE TABLE `tw_zmiany_klienci` (
  `id_klienta` int(11) NOT NULL default '0',
  `typ_zmiany` tinyint(4) NOT NULL default '0'
);

DROP TABLE IF EXISTS `tw_zmiany_zamowienia`;
CREATE TABLE `tw_zmiany_zamowienia` (
  `id_zamowienia` int(11) NOT NULL default '0',
  `typ_zmiany` tinyint(4) NOT NULL default '0',
  PRIMARY KEY(`id_zamowienia`)
);

DROP TABLE IF EXISTS `tw_kategoria`;
CREATE TABLE `tw_kategoria` (
  `sub_okt_Id` INT NOT NULL,
  `osc_categories_id` INT NOT NULL,
  `hash_oryginalu` varchar(32) NULL,
  `nazwa_pliku` VARCHAR(64) NULL DEFAULT NULL,
  `nazwa_pliku_temp` VARCHAR(64) NULL DEFAULT NULL,
  PRIMARY KEY (`sub_okt_Id`, `osc_categories_id`)
);

create index ix_tw_producent_osc_manufacturers_id on tw_producent(osc_manufacturers_id);
create index ix_tw_zdjecie_nazwa_pliku on tw_zdjecie(nazwa_pliku);

KONIEC;

$blowfish_secret = '734f7126f31026740b790fdc90d94d36cc5c4462805e999c40f6a88933bc11fb';

$wersja = '4';

$brakujace_moduly = array ();
$ostrzezenia = array ();
$pliki_tw = array (
	/*
	 */'ep0.php' => '609dd009502108fbb2465a2e1f446042',
'ep1.php' => '0f5ee521a53744c2434b03a1364ce1d2',
'ep2.php' => 'e1d2817d611ea45cbce9e8ec1afd3677',
'epall.php' => '49431079e5641ee5aa2a65892d7324cb',
'epconfig.php' => '64a37c07d9ac206514a25aab9c7ad33d',
'funkcje.php' => '50d920842403553a23326aaa36e6c96a',
'epquery.php' => '189573398a15c900537ef60253c5cf27'/*
	 */
);
$brakujace_pliki_tw = array ();
$nieprawidlowe_pliki_tw = array ();

function pokaz_blad($opis = 'Instalacja nie powiod³a siê.') {
	global $ostrzezenia, $brakujace_moduly;
	header('X-Thinkware-Install: BLAD');
	echo '<html><head><title>Instalacja oscGT</title><style>* {font-family: sans-serif; font-size: x-small;}</style></head><body>';
	echo '<div>';
	echo $opis;
	echo '</div>';
	if ($brakujace_moduly) {
		echo '<div>Silnik PHP na serwerze nie ma w³±czonych wymaganych modu³ów:';
		echo '<table><tr><th>Nazwa</th><th>Przeznaczenie</th></tr>';
		foreach ($brakujace_moduly as $nazwa => $przeznaczenie) {
			echo "<tr><td>$nazwa</td><td>$przeznaczenie</td></tr>";
		}
		echo '</table>';
		echo '</div>';
	}
	if ($ostrzezenia) {
		echo '<div>Silnik PHP wygenerowa³ nastêpuj±ce ostrze¿enia:';
		echo '<ul>';
		foreach ($ostrzezenia as $ostrzezenie) {
			echo "<li>$ostrzezenie</li>";
		}
		echo '</ul>';
		echo '</div>';
	}
	echo '</body></html>';
	ob_end_flush();
	die();
}

function zapisuj_ostrzezenia_php($errno, $errstr, $errfile, $errline, $errcontext) {
	global $norm_funkcja, $ostrzezenia;
	if ($errno == E_WARNING) {
		$ostrzezenia[] = $errstr;
	}
	if ($norm_funkcja) {
		$norm_funkcja ($errno, $errstr, $errfile, $errline, $errcontext);
	}
}
$norm_funkcja = set_error_handler('zapisuj_ostrzezenia_php');

function hex_string_do_bin_string($hex_string = '') {
	$bin_string = '';
	if (@eregi('[^0-9a-f]', $hex_string)) {
		return null;
	}
	if (strlen($hex_string) % 2) {
		$hex_string = "0$hex_string";
	}
	for ($i = 0; $i < strlen($hex_string); $i += 2) {
		$bin_string .= chr(hexdec(substr($hex_string, $i, 2)));
	}
	return $bin_string;
}

function sql_rename_table_bez_praw_alter($from, $to, $drop = false) {

	$sql_quote_show_create = false;
	$rs = tw_db_query('SELECT @@SQL_QUOTE_SHOW_CREATE s');
	$row = tw_db_fetch_array($rs);
	if ($row) {
		$sql_quote_show_create = (bool) $row['s'];
	}
	tw_db_free_result($rs);

	if ($sql_quote_show_create) {
		$from = "`$from`";
	}
	$to = "`$to`";

	$rs = tw_db_query("SHOW CREATE TABLE $from"); // b³±d je¶li tabeli nie ma
	$row = tw_db_fetch_array($rs);
	$ddl = array_pop($row);
	tw_db_free_result($rs);
	$ddl = @eregi_replace("create[[:space:]]*table[[:space:]]*$from", "CREATE TABLE $to", $ddl);

	tw_db_query("DROP TABLE IF EXISTS $to");
	tw_db_query($ddl);
	tw_db_query("INSERT INTO $to SELECT * FROM $from");

	if ($drop) {
		tw_db_query("DROP TABLE $from");
	};

}

function wykonaj_skrypt_sql($skrypt = '') {
	$sql_arr = explode(';', $skrypt);
	foreach ($sql_arr as $sql) {
		$sql = trim($sql);
		if ($sql) {
			tw_db_query($sql);
		}
	}
}

function instaluj() {
	// uruchomienie skryptu instalacyjnego sql
	global $osc_ddl, $blowfish_secret, $wersja;
	wykonaj_skrypt_sql($osc_ddl);

	// ustawienie domy¶lnego mapowania stanów zamówieñ
	$rs = tw_db_query('SELECT orders_status_id FROM ' . TABLE_ORDERS_STATUS . ' WHERE orders_status_id = 2');
	if (tw_db_fetch_array($rs)) {
		tw_db_query('UPDATE tw_ustawienia SET TW_STAN_DOSTARCZONO_ID = 2');
	}
	$rs = tw_db_query('SELECT orders_status_id FROM ' . TABLE_ORDERS_STATUS . ' WHERE orders_status_id = 3');
	if (tw_db_fetch_array($rs)) {
		tw_db_query('UPDATE tw_ustawienia SET TW_STAN_ZREALIZOWANO_ID = 3');
	}

	// ustawienie domy¶lnego jêzyka - polski, je¿eli nie ma to pierwszy
	$language_id = null;
	$rs = tw_db_query('SELECT languages_id FROM ' . TABLE_LANGUAGES . ' WHERE UPPER(code) = \'PL\'');
	$row = tw_db_fetch_array($rs);
	if ($row) {
		$language_id = $row['languages_id'];
	} else {
		$rs = tw_db_query('SELECT languages_id FROM ' . TABLE_LANGUAGES . ' ORDER BY sort_order');
		$row = tw_db_fetch_array($rs);
		if ($row) {
			$language_id = $row['languages_id'];
		}
	}
	if ($language_id) {
		tw_db_query('UPDATE tw_ustawienia SET TW_LANGUAGE_ID = ' . (int) $language_id);
	}

	// ustawienie domy¶lnej strefy podatkowej	
	$geozone_id = null;
	$rs = tw_db_query('SELECT geo_zone_id FROM ' . TABLE_GEO_ZONES . ' WHERE LOWER(geo_zone_name) LIKE \'%polska%\'');
	$row = tw_db_fetch_array($rs);
	if ($row) {
		$geozone_id = $row['geo_zone_id'];
	} else {
		$rs = tw_db_query('SELECT ' . TABLE_GEO_ZONES . '.geo_zone_id FROM ' .
		TABLE_GEO_ZONES . ' INNER JOIN ' . TABLE_ZONES_TO_GEO_ZONES . ' ON ' .
		TABLE_GEO_ZONES . '.geo_zone_id = ' . TABLE_ZONES_TO_GEO_ZONES . '.geo_zone_id INNER JOIN ' . TABLE_COUNTRIES . ' ON ' .
		"zone_country_id = countries_id WHERE LOWER(countries_iso_code_2) = 'pl'");
		$row = tw_db_fetch_array($rs);
		if ($row) {
			$geozone_id = $row['geo_zone_id'];
		} else {
			$rs = tw_db_query('SELECT geo_zone_id FROM ' . TABLE_GEO_ZONES . ' ORDER BY geo_zone_id');
			$row = tw_db_fetch_array($rs);
			if ($row) {
				$geozone_id = $row['geo_zone_id'];
			}
		}

	}
	if ($geozone_id) {
		tw_db_query('UPDATE tw_ustawienia SET TW_GEOZONE_ID=' . (int) $geozone_id);
	}

	// dodanie waluty PLN, je¿eli nie istnieje
	$rs = tw_db_query('SELECT COUNT(*) cnt FROM ' . TABLE_CURRENCIES . ' WHERE UPPER(code) = \'PLN\'');
	$row = tw_db_fetch_array($rs);
	if (!$row['cnt']) {
		tw_db_query('INSERT INTO ' . TABLE_CURRENCIES . ' (title, code, symbol_right, decimal_point, thousands_point, decimal_places, value, last_updated) VALUES ' .
		"('Polski Z&#x142;oty', 'PLN', ' z&#x142;', ',', '.', 2, 1, NOW())");
	}

	// zapisanie sekretu i w³a¶nie zainstalowanej wersji
	tw_db_query("UPDATE tw_autentykacja SET blowfish_secret=0x$blowfish_secret WHERE tw_aut_id=1");
	tw_db_query("UPDATE tw_ustawienia SET wersja=$wersja");
}

function aktualizuj($zainstalowana_wersja) {
	global $wersja;

	// 1.00 -> 1.01

	if ($zainstalowana_wersja < 2) {
		$rs = tw_db_query("SHOW COLUMNS FROM tw_producent LIKE 'hash_oryginalu'");
		if ($rs && !tw_db_fetch_array($rs)) {
			tw_db_query("ALTER TABLE tw_producent ADD hash_oryginalu VARCHAR(32) NULL");
		}
		tw_db_free_result($rs);
	
		$rs = tw_db_query("SHOW COLUMNS FROM tw_ustawienia LIKE 'TW_DEKLARUJ_KODOWANIE_W_BD'");
		if ($rs && !tw_db_fetch_array($rs)) {
			tw_db_query("ALTER TABLE tw_ustawienia ADD `TW_DEKLARUJ_KODOWANIE_W_BD` TINYINT(1) NOT NULL DEFAULT '1'");
		}
		tw_db_free_result($rs);
		
		$rs = tw_db_query("SHOW TABLES LIKE 'tw_kategoria'");
		if ($rs && !tw_db_fetch_array($rs)) {
			tw_db_query("CREATE TABLE `tw_kategoria` (
			  `sub_okt_Id` INT NOT NULL,
			  `osc_categories_id` INT NOT NULL,
			  `hash_oryginalu` varchar(32) NULL,
			  `nazwa_pliku` VARCHAR(64) NULL DEFAULT NULL,
			  `nazwa_pliku_temp` VARCHAR(64) NULL DEFAULT NULL,
			  PRIMARY KEY (`sub_okt_Id`, `osc_categories_id`)
			)");
		}
		tw_db_free_result($rs);
	}
	
	if ($zainstalowana_wersja < 3) {
		tw_db_query('create index ix_tw_producent_osc_manufacturers_id on tw_producent(osc_manufacturers_id);');
		tw_db_query('create index ix_tw_zdjecie_nazwa_pliku on tw_zdjecie(nazwa_pliku);');
	}	

	if ($zainstalowana_wersja < 4) {
		$rs = tw_db_query("SHOW COLUMNS FROM tw_ustawienia LIKE 'TW_KOLUMNA_NIP_DLA_ZAMOWIEN_Z_KLIENTEM'");
		if ($rs && !tw_db_fetch_array($rs)) {
			tw_db_query("ALTER TABLE tw_ustawienia ADD `TW_KOLUMNA_NIP_DLA_ZAMOWIEN_Z_KLIENTEM` varchar(64) NOT NULL default 'NULL'");
		}
		tw_db_free_result($rs);
		
		$rs = tw_db_query("SHOW COLUMNS FROM tw_ustawienia LIKE 'TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_Z_KLIENTEM'");
		if ($rs && !tw_db_fetch_array($rs)) {
			tw_db_query("ALTER TABLE tw_ustawienia ADD `TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_Z_KLIENTEM` varchar(64) NOT NULL default 'NULL'");
		}
		tw_db_free_result($rs);
		
		$rs = tw_db_query("SHOW COLUMNS FROM tw_ustawienia LIKE 'TW_KOLUMNA_NIP_DLA_ZAMOWIEN_BEZ_KLIENTA'");
		if ($rs && !tw_db_fetch_array($rs)) {
			tw_db_query("ALTER TABLE tw_ustawienia ADD `TW_KOLUMNA_NIP_DLA_ZAMOWIEN_BEZ_KLIENTA` varchar(64) NOT NULL default 'NULL'");
		}
		tw_db_free_result($rs);
		
		$rs = tw_db_query("SHOW COLUMNS FROM tw_ustawienia LIKE 'TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_BEZ_KLIENTA'");
		if ($rs && !tw_db_fetch_array($rs)) {
			tw_db_query("ALTER TABLE tw_ustawienia ADD `TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_BEZ_KLIENTA` varchar(64) NOT NULL default 'NULL'");
		}
		tw_db_free_result($rs);
	}
	
	tw_db_query("UPDATE tw_ustawienia SET wersja=$wersja");
}

// pocz±tek w³a¶ciwego skryptu

ob_start();

// sprawdzenie podstawowych parametrów - czy POST,
// czy jest warto¶æ do uwierzytelniania
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset ($_POST['auth'])) {
	pokaz_blad('Nieuwierzytelnione zapytanie.');
}

// oczekiwana przez klienta wersja modu³u serwerowego 
if ($_POST['oczekiwanaWersja'] != $wersja) {
	pokaz_blad('Na serwerze znajduj± siê pliki modu³u oscGT w wersji innej, ni¿ oczekiwana przez kreator instalacji. Prze¶lij na serwer pliki przy pomocy tego kreatora.');
}

// konwersja sekretu do ci±gu binarnego
$blowfish_secret_bin = '';
$blowfish_secret_bin = hex_string_do_bin_string($blowfish_secret);

// uwierzytelnianie - czy $_POST['auth'] to ci±g cyfr szesnastkowych
// bêd±cych skrótem MD5 sekretu
if ($_POST['auth'] != md5($blowfish_secret_bin)) {
	pokaz_blad('Nieuwierzytelnione zapytanie. Czy pliki modu³u oscGT, które znajduj± siê na serwerze, s± z odpowiedniego podmiotu?');
}

// sprawdzenie, czy s± wszystkie pliki thinkware
$base_dir = dirname(__FILE__);
foreach ($pliki_tw as $plik_tw => $md5_oczekiwane) {
	$sciezka = $base_dir . '/' . $plik_tw;
	if (!file_exists($sciezka)) {
		$brakujace_pliki_tw[] = $plik_tw;
	} else {
		$md5_faktyczne = md5(implode('', file($sciezka)));
		if (strtolower($md5_faktyczne) != strtolower($md5_oczekiwane)) {
			$nieprawidlowe_pliki_tw[$plik_tw] = $md5_faktyczne;
		}
	}
}
if ($brakujace_pliki_tw || $nieprawidlowe_pliki_tw) {
	$err = '';
	if ($brakujace_pliki_tw) {
		$err .= 'Na serwerze brakuje nastêpuj±cych plików: <ul><li>';
		$err .= implode($brakujace_pliki_tw, '</li><li>');
		$err .= '</li></ul> ';
	}
	if ($nieprawidlowe_pliki_tw) {
		$err .= 'Nastêpuj±ce pliki s± nieprawid³owe. ' .
		'Je¿eli na serwer zosta³y przes³ane przez FTP, czy na pewno ' .
		'u¿yty zosta³ tryb binarny?';
		$err .= '<table><tr><th>Nazwa pliku</th><th>Oczekiwany skrót MD5</th><th>Faktyczny skrót MD5</th></tr>';
		foreach ($nieprawidlowe_pliki_tw as $plik_tw => $md5_faktyczne) {
			$err .= "<tr><td>$plik_tw</td><td>{$pliki_tw[$plik_tw]}</td><td>$md5_faktyczne</td></tr>";
		}
		$err .= '</table>';
	}

	$err .= "<br/>Katalog na serwerze: " . htmlspecialchars($base_dir);
	pokaz_blad($err);
}

// sprawdzenie, czy s± wszystkie potrzebne pliki osCommerce
$sa_pliki_osc = include ('../includes/configure.php');
$sa_pliki_osc = $sa_pliki_osc && include ('../includes/database_tables.php');
if (!$sa_pliki_osc) {
	pokaz_blad('Nie znaleziono niezbêdnych plików (configure.php i database_tables.php) ' .
	'z instalacji osCommerce. Czy wys³a³e¶ pliki modu³u oscGT ' .
	'do w³a¶ciwego katalogu na serwerze? Pliki oscGT powinny znajdowaæ siê w podkatalogu ' .
	'katalogu g³ównego osCommerce, b±d¼ w podkatalogu katalogu panelu administracyjnego ' .
	'osCommerce.');
}

// je¿eli s± wszystkie pliki, w³±czamy funkcje thinkware
require_once './funkcje.php';

// sprawdzenie wersji php (version_compare() jest od 4.1)
if (!function_exists('version_compare') || version_compare(phpversion(), '5.0.0', '<')) {
	pokaz_blad('oscGT wymaga PHP w wersji 5.0.0.');
}

// sprawdzenie, czy s± potrzebne modu³y php, przed po³±czeniem z baz±
$moduly = get_loaded_extensions();

if (!in_array('mysql', $moduly) || !function_exists('mysql_connect')) {
	$brakujace_moduly['mysql'] = 'Standardowe rozszerzenie MySQL';
}
if (!in_array('xml', $moduly) || !function_exists('xml_parser_create')) {
	$brakujace_moduly['xml'] = 'Standardowe rozszerzenie XML';
}

if ($brakujace_moduly) {
	pokaz_blad();
}

// czy w configure.php jest skonfigurowany serwer
if (!defined('DB_SERVER') || strlen(DB_SERVER) < 1) {
	pokaz_blad('W konfiguracji sklepu nie ma informacji o serwerze bazy danych. ' .
	'Zainstaluj i skonfiguruj osCommerce przed instalacj± modu³u ' .
	'oscGT.');
}

// nawi±zanie po³±czenia z baz± danych
$mysql_login = DB_SERVER_USERNAME;
$mysql_haslo = DB_SERVER_PASSWORD;
if (isset ($_POST['login']) && isset ($_POST['haslo'])) {
	$bf = new Crypt_Blowfish($blowfish_secret_bin);
	$mysql_login = rtrim($bf->decrypt(hex_string_do_bin_string($_POST['login'])), chr(0));
	$mysql_haslo = rtrim($bf->decrypt(hex_string_do_bin_string($_POST['haslo'])), chr(0));
}
if (!@ tw_db_connect(DB_SERVER, $mysql_login, $mysql_haslo)) {
	pokaz_blad('Po³±czenie z baz± danych nie powiod³o siê.');
}

$wersja_mysql = mysql_get_server_info();
if (substr($wersja_mysql, 0, 1) < 4) {
	pokaz_blad("oscGT wymaga MySQL w wersji co najmniej 4.0 (wykryto wersjê $wersja_mysql).");
}

if (version_compare(phpversion(), '5.0.0', '>=') && !in_array('iconv', $moduly) && !in_array('mbstring', $moduly)) {
	$brakujace_moduly['iconv lub mbstring'] = 'jeden z modu³ów do konwersji standardów kodowania ci±gów znaków';
	pokaz_blad();
}

// sprawdzenie, czy jest tabela tw_ustawienia
$rs = tw_db_query('SHOW TABLES');
$jest_tw_ustawienia = false;
while ($row = tw_db_fetch_array($rs)) {
	if ('tw_ustawienia' == array_shift($row)) {
		$jest_tw_ustawienia = true;
		break;
	}
}

// sprawdzenie zainstalowanej wersji
$zainstalowana_wersja = null;
if ($jest_tw_ustawienia) {
	$rs = tw_db_query('SELECT wersja FROM tw_ustawienia');
	$row = tw_db_fetch_array($rs);
	if ($row)
		$zainstalowana_wersja = $row['wersja'];
	tw_db_free_result($rs);
}

// w³a¶ciwa instalacja
if (!$zainstalowana_wersja) {
	instaluj();
	header('X-Thinkware-Install-Version: ' . $wersja);
} else {
	if (tw_pobierz_sekret() == $blowfish_secret_bin) {
		if ($zainstalowana_wersja < $wersja) {
			if (isset ($_POST['update']) && $_POST['update']) {
				aktualizuj($zainstalowana_wersja);
				header('X-Thinkware-Install-Version: ' . $wersja);
			} else {
				pokaz_blad('W bazie sklepu znajduj± siê dane wcze¶niejszej ' .
				'wersji modu³u oscGT. W celu aktualizacji danych ' .
				'zaznacz odpowiedni± opcjê w kreatorze instalacji.');
			}
		} else
			if ($zainstalowana_wersja == $wersja) {
				header('X-Thinkware-Install-Version: ' . $wersja);
			} else {
				pokaz_blad('W bazie sklepu znajduj± siê dane nowszej wersji ' .
				'modu³u oscGT. Instalacja tej wersji modu³u oscGT nie jest ' .
				'mo¿liwa w tej bazie.');
			}
	} else {
		if ($zainstalowana_wersja < $wersja) {
			if (isset ($_POST['update']) && $_POST['update'] && isset ($_POST['reinstall']) && $_POST['reinstall']) {
				instaluj();
				header('X-Thinkware-Install-Version: ' . $wersja);
			} else {
				pokaz_blad('W bazie sklepu znajduj± siê dane wcze¶niejszej ' .
				'wersji modu³u oscGT <strong>z innego podmiotu</strong>. ' .
				'Aby zaktualizowaæ wersjê modu³u i nadpisaæ dane z innego podmiotu ' .
				'zaznacz odpowiednie <strong>opcje</strong> w ' .
				'kreatorze instalacji.');
			}
		} else
			if ($zainstalowana_wersja == $wersja) {
				if (isset ($_POST['reinstall']) && $_POST['reinstall']) {
					instaluj();
					header('X-Thinkware-Install-Version: ' . $wersja);
				} else {
					pokaz_blad('W bazie sklepu znajduj± siê dane modu³u oscGT z ' .
					'innego podmiotu. Aby nadpisaæ dane z innego ' .
					'podmiotu zaznacz odpowiedni± opcjê w kreatorze instalacji.');
				}
			} else {
				pokaz_blad('W bazie sklepu znajduj± siê dane nowszej wersji ' .
				'modu³u oscGT z innego podmiotu. Instalacja tej wersji modu³u oscGT nie jest ' .
				'mo¿liwa w tej bazie.');
			}
	}
}
ob_end_flush();
?>