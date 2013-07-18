<?php

require_once '../includes/configure.php';
require_once '../includes/database_tables.php';
require_once 'funkcje.php';

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

header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
header('X-Thinkware-Version: 4');

tw_db_connect();

tw_wczytaj_ustawienia();

define('TW_JEST_ULTRAPICS', tw_wykryj_ultrapics());
define('TW_JEST_EXTRAFIELDS', tw_wykryj_extrafields());
define('TW_SA_ZDJECIA23', tw_wykryj_zdjecia23());

if (!defined('DIR_FS_CATALOG_IMAGES')) {
	$p = @ realpath(DIR_FS_CATALOG . '/' . DIR_WS_IMAGES . '/');
	if (!$p)
	{
		$p = DIR_FS_CATALOG . DIR_WS_IMAGES;
	}
	else
	{
		if ($p{strlen($p) - 1} != DIRECTORY_SEPARATOR)
		{
			$p .= DIRECTORY_SEPARATOR;
		}
	}
	define('DIR_FS_CATALOG_IMAGES', $p);
}

$secret = tw_pobierz_sekret();

$stamp_begin_idx = strpos($HTTP_RAW_POST_DATA, '<!-- ');
$stamp_end_idx = strpos($HTTP_RAW_POST_DATA, ' -->');

$groups = array ();
if (@eregi('encoding[[:space:]]*=[[:space:]]*[\'"][[:space:]]*([^[:space:]]+)[[:space:]]*[\'"]', substr($HTTP_RAW_POST_DATA, 0, $stamp_begin_idx), $groups) && $groups[1]) {
	define('TW_KODOWANIE_TRANSPORT', strtolower(trim($groups[1])));
	header('Content-Type: application/xml; charset=' . TW_KODOWANIE_TRANSPORT);
}

if ($stamp_end_idx - $stamp_begin_idx != 61) {
	header('X-Thinkware-Auth: failed');
	die('Nieprawidlowy naglowek uwierzytelniajacy');
}

$stamp_b64 = substr($HTTP_RAW_POST_DATA, $stamp_begin_idx +5, 56);
$stamp_encr = base64_decode($stamp_b64);

$bf = new Crypt_Blowfish($secret);
$stamp = $bf->decrypt($stamp_encr);
unset ($bf);

$hash_zawartosci = hex_string_do_bin_string(md5(substr($HTTP_RAW_POST_DATA, $stamp_end_idx +4)));
$hash_licznik_i_hash_zawartosci = hex_string_do_bin_string(md5(substr($stamp, 0, 4) . $hash_zawartosci));

if ($hash_licznik_i_hash_zawartosci != substr($stamp, 4, 16)) {
	header('X-Thinkware-Auth: failed');
	die('Nieprawidlowy skrot danych');
}

header('X-Thinkware-Auth: OK');
header('X-Thinkware-Nonce: ' . base64_encode(substr($stamp, 20, 20)));

$unp = unpack('Nlicznik', substr($stamp, 0, 4));
$licznik = $unp['licznik'];

if (($roznica = tw_sprawdz_licznik($licznik)) !== true) {
	header('X-Thinkware-Cnt-Adj: ' . $roznica);
	die('Nieprawidlowa wartosc licznika');
}

header('X-Thinkware-Auth: OK');

if (defined('TW_KODOWANIE_TRANSPORT') && TW_DEKLARUJ_KODOWANIE_W_BD) {
	tw_db_ustaw_kodowanie(TW_KODOWANIE_TRANSPORT);
} else
	if ((substr(mysql_get_server_info(), 0, 1) >= '5' || substr(mysql_get_server_info(), 0, 3) == '4.1') /*&& (substr(mysql_get_client_info(), 0, 1) == '5' || substr(mysql_get_client_info(), 0, 3) == '4.1')*/
		) {
		$character_set_client = null;
		$character_set_database = null;
		$rs = tw_db_query("SHOW VARIABLES LIKE 'character_set_client'");
		$row = tw_db_fetch_array($rs);
		if ($row) {
			$character_set_client = array_pop($row);
		}
		tw_db_free_result($rs);
		$rs = tw_db_query("SHOW VARIABLES LIKE 'character_set_database'");
		$row = tw_db_fetch_array($rs);
		if ($row) {
			$character_set_database = array_pop($row);
		}
		tw_db_free_result($rs);
		if ($character_set_database && $character_set_database != $character_set_client) {
			if ($character_set_database == 'ucs2') {
				$character_set_database = 'utf8';
			}
			tw_db_query("SET NAMES $character_set_database");
		}
	}
?>