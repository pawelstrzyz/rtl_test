<?php
define('TW_TYPZMIANY_DODAWANIE', 0);
define('TW_TYPZMIANY_AKTUALIZACJA', 1);
define('TW_TYPZMIANY_USUNIECIE', 2);
define('TW_TYPZMIANY_DODAWANIE_JESLI_NIE_ISTNIEJE', 3);

define('TW_STATUSPOTWIERDZENIA_OK', 0);
define('TW_STATUSPOTWIERDZENIA_BLAD', 1);
define('TW_STATUSPOTWIERDZENIA_OK_ZREALIZOWANO', 2);
define('TW_STATUSPOTWIERDZENIA_BRAK_ZAMOWIENIA', 3);
define('TW_STATUSPOTWIERDZENIA_BRAK_MAPOWANIA_STANU', 4);
define('TW_STATUSPOTWIERDZENIA_OK_ZDJECIE', 5);
define('TW_STATUSPOTWIERDZENIA_OK_MINIATURA', 6);
define('TW_STATUSPOTWIERDZENIA_TOWAR_USUNIETO', 7);
define('TW_STATUSPOTWIERDZENIA_ZAMOWIENIE_ISTNIEJE', 8);
define('TW_STATUSPOTWIERDZENIA_BRAK_KURSU', 9);

function tw_ustaw_parametry_pln() {
	$rs = tw_db_query('SELECT currencies_id, value FROM ' . TABLE_CURRENCIES . ' WHERE UPPER(code) = \'PLN\'');
	$row = tw_db_fetch_array($rs);
	if ($row) {
		$GLOBALS['pln_id'] = (int) $row['currencies_id'];
		$GLOBALS['pln_value'] = (double) $row['value'];
	} else {
		$GLOBALS['pln_id'] = null;
		$GLOBALS['pln_value'] = 1;
	}
}

// przelicza cenê w podanej walucie na warto¶æ do wpisania do
// tabeli products
function tw_przelicz_cene($cena, $waluta = 'PLN', $kurs_w_pln = 1) {
	global $pln_value;
	$waluta = tw_db_input(strtoupper($waluta));
	if ($waluta == 'PLN') {
		return $cena / $pln_value;
	} else {
		// czy waluta istnieje?
		$rs = tw_db_query('SELECT value FROM ' . TABLE_CURRENCIES . " WHERE UPPER(code) = '$waluta'");
		$row = tw_db_fetch_array($rs);
		if ($row) {
			return $cena / $row['value'];
		} else {
			return $cena * $kurs_w_pln / $pln_value;
		}
	}
}

// $nowy_status - 'dostarczono' albo 'zrealizowano'
function ustaw_status_zamowienia($osc_orders_id, $stan) {

	// sprawdz czy zamowienie istnieje - potwierdzenie
	$wynik = mysql_query("SELECT orders_status FROM " . TABLE_ORDERS . " WHERE orders_id = " . $osc_orders_id);
	if ($wiersz = mysql_fetch_array($wynik)) {
		$aktualny_status = $wiersz["orders_status"];
	} else
		return 1; // zamowienie nie istnieje		

	// pobieranie uistawienia
	if ($stan == 'zrealizowano')
		$stala = "TW_STAN_ZREALIZOWANO_ID";
	else
		$stala = "TW_STAN_DOSTARCZONO_ID";

	$wynik = tw_db_query("SELECT " . $stala . " FROM tw_ustawienia WHERE tw_ust_id = 1");
	$wiersz = tw_db_fetch_array($wynik);
	$nowy_status = $wiersz[$stala];

	if (tw_policz(TABLE_ORDERS_STATUS, 'orders_status_id = ' . $nowy_status) == 0)
		// stan nie istnieje
		{
		$wynik = tw_db_query("SELECT MAX(orders_status_id) AS ile FROM " . TABLE_ORDERS_STATUS);
		$wiersz = tw_db_fetch_array($wynik);
		$nowy_status = (is_null($wiersz["ile"]) ? 1 : $wiersz["ile"] + 1);

		$nazwa = ($stan == 'zrealizowano' ? 'Zamówienie zrealizowane' : 'Zamówienie przyjête');

		tw_db_query("INSERT INTO " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) " .
		"VALUES (" . $nowy_status . ", " . TW_LANGUAGE_ID . ", '" . $nazwa . "')");

		tw_db_query("UPDATE tw_ustawienia SET " . $stala . " = " . $nowy_status . " WHERE tw_ust_id = 1");
	}

	// sprawdz czy mapowanie stanu istnieje - potwierdzenie
	// sprawdz  stary stan, jesli inny to dodaj do orders_status_history
	tw_db_query("UPDATE " . TABLE_ORDERS . " SET orders_status = " . $nowy_status . " WHERE orders_id = " . $osc_orders_id);
	if ($aktualny_status != $nowy_status)
		mysql_query("INSERT INTO " . TABLE_ORDERS_STATUS_HISTORY .
		"(orders_id, orders_status_id, date_added, customer_notified, comments) VALUES " .
		"(" . $osc_orders_id . ", " . $nowy_status . ", now(), 0, NULL)");

	return 0; // wszytsko ok	
}

function tw_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
	global $$link;

	if (USE_PCONNECT == 'true') {
		$$link = mysql_pconnect($server, $username, $password);
	} else {
		$$link = mysql_connect($server, $username, $password);
	}

	if ($$link)
		mysql_select_db($database);

	return $$link;
}

function tw_db_close($link = 'db_link') {
	global $$link;

	return mysql_close($$link);
}

function tw_db_error($query, $errno, $error) {
	die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br><br>' . $query . '<br><br><small><font color="#ff0000">[TEP STOP]</font></small><br><br></b></font>');
}

function tw_db_query($query, $link = 'db_link') {
	global $$link;
	$result = mysql_query($query, $$link) or tw_db_error($query, mysql_errno(), mysql_error());
	return $result;
}

function tw_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
	reset($data);
	if ($action == 'insert') {
		$query = 'insert into ' . $table . ' (';
		while (list ($columns,) = each($data)) {
			$query .= $columns . ', ';
		}
		$query = substr($query, 0, -2) . ') values (';
		reset($data);
		while (list (, $value) = each($data)) {
			switch ((string) $value) {
				case 'now()' :
					$query .= 'now(), ';
					break;
				case 'null' :
					$query .= 'null, ';
					break;
				default :
					$query .= '\'' . tw_db_input($value) . '\', ';
					break;
			}
		}
		$query = substr($query, 0, -2) . ')';
	}
	elseif ($action == 'update') {
		$query = 'update ' . $table . ' set ';
		while (list ($columns, $value) = each($data)) {
			switch ((string) $value) {
				case 'now()' :
					$query .= $columns . ' = now(), ';
					break;
				case 'null' :
					$query .= $columns .= ' = null, ';
					break;
				default :
					$query .= $columns . ' = \'' . tw_db_input($value) . '\', ';
					break;
			}
		}
		$query = substr($query, 0, -2) . ' where ' . $parameters;
	}

	return tw_db_query($query, $link);
}

function tw_db_fetch_array($db_query) {
	return mysql_fetch_array($db_query, MYSQL_ASSOC);
}

function tw_db_result($result, $row, $field = '') {
	return mysql_result($result, $row, $field);
}

function tw_db_num_rows($db_query) {
	return mysql_num_rows($db_query);
}

function tw_db_data_seek($db_query, $row_number) {
	return mysql_data_seek($db_query, $row_number);
}

function tw_db_insert_id() {
	return mysql_insert_id();
}

function tw_db_free_result($db_query) {
	return @ mysql_free_result($db_query);
}

function tw_db_fetch_fields($db_query) {
	return mysql_fetch_field($db_query);
}

function tw_db_output($string) {
	return htmlspecialchars($string);
}

function tw_db_input($string, $link = 'db_link') {
	global $$link;

	if (function_exists('mysql_real_escape_string')) {
		return mysql_real_escape_string($string, $$link);
	}
	elseif (function_exists('mysql_escape_string')) {
		return mysql_escape_string($string);
	}

	return addslashes($string);
}

function tw_db_prepare_input($string) {
	if (is_string($string)) {
		return trim(stripslashes($string));
	}
	elseif (is_array($string)) {
		reset($string);
		while (list ($key, $value) = each($string)) {
			$string[$key] = tw_db_prepare_input($value);
		}
		return $string;
	} else {
		return $string;
	}
}

// nowe funkcje do bazy danych
function tw_db_affected_rows() {
	return mysql_affected_rows();
}

function tw_db_ustaw_kodowanie($webname) {
	static $webname_do_mysql = array (
		'us-ascii' => 'ascii',
		'utf-8' => 'utf8',
		'iso-8859-1' => 'latin1',
		'iso-8859-2' => 'latin2',
		'windows-1250' => 'cp1250',
		'ibm850' => 'cp850',
		'koi8-r' => 'koi8r',
		'koi8-u' => 'koi8u',
		'euc-jp' => 'ujis',
		'shift_jis' => 'sjis',
		'euc-kr' => 'euckr',
		'gb2312' => 'gb2312',
		'iso-8859-7' => 'greek',
		'iso-8859-9' => 'latin5',
		'cp866' => 'cp866',
		'x-mac-ce' => 'macce',
		'macintosh' => 'macroman',
		'ibm852' => 'cp852',
		'iso-8859-13' => 'latin7',
		'windows-1251' => 'cp1251',
		'windows-1256' => 'cp1256',
		'windows-1257' => 'cp1257',
		'big5' => 'big5'
	);
	static $ustawione_kodowanie = null;
	$webname = trim(strtolower($webname));
	if ($webname != $ustawione_kodowanie && isset ($webname_do_mysql[$webname])) {
		$wersja = mysql_get_server_info();
		if (substr($wersja, 0, 1) >= '5' || substr($wersja, 0, 3) == '4.1') {
			tw_db_query("SET NAMES {$webname_do_mysql[$webname]}");
			$ustawione_kodowanie = $webname;
		}
	}
	return $ustawione_kodowanie;
}

function tw_serializuj_pole($wartosc, $nazwa = null) {
	$ret = null;
	if (is_int($wartosc))
		$ret = "<int" . ($nazwa ? " n='$nazwa'" : '') . ">$wartosc</int>";
	else
		if (is_bool($wartosc))
			$ret = "<bl" . ($nazwa ? " n='$nazwa'" : '') . ">" . ($wartosc ? 1 : 0) . "</bl>";
		else
			if (is_float($wartosc))
				$ret = "<dp" . ($nazwa ? " n='$nazwa'" : '') . ">$wartosc</dp>";
			else
				if (is_string($wartosc))
					$ret = "<tx" . ($nazwa ? " n='$nazwa'" : '') . ">" . htmlspecialchars($wartosc) . "</tx>";
				else
					if (is_array($wartosc)) {
						$ret = "<map" . ($nazwa ? " n='$nazwa'" : '') . ">";
						foreach ($wartosc as $k => $v) {
							if (is_a($v, 'pozycja_mapy')) {
								$ret .= "<pair><key>" . tw_serializuj_pole($v->k) . "</key>";
								$ret .= "<val>" . tw_serializuj_pole($v->v) . "</val></pair>";
							} else {
								$ret .= "<pair><key>" . tw_serializuj_pole($k) . "</key>";
								$ret .= "<val>" . tw_serializuj_pole($v) . "</val></pair>";
							}
						}
						$ret .= "</map>";
					} else
						if (is_a($wartosc, 'pole_referencyjne')) {
							$ret = "<ref" . ($nazwa ? " n='$nazwa' " : ' ');
							$ret .= "to='" . $wartosc->typ_obiektu . "' ";
							if (!is_null($wartosc->osc_id))
								$ret .= "osc='" . (int) $wartosc->osc_id . "' ";
							if (!is_null($wartosc->sub_id))
								$ret .= "sub='" . (int) $wartosc->sub_id . "' ";
							$ret .= " />";
						} else
							if (is_a($wartosc, 'pole_binarne')) {
								$ret = "<b64 " . ($nazwa ? " n='$nazwa'" : '') . " dl='" . (int) $wartosc->dlugosc_calkowita . "' ";
								if ($wartosc->offset)
									$ret .= " off='" . (int) $wartosc->offset . "' ";
								if ($wartosc->dlugosc_czesci)
									$ret .= " dlcz='" . (int) $wartosc->dlugosc_czesci . "' ";
								$ret .= ">";
								$ret .= base64_encode($wartosc->wartosc);
								$ret .= "</b64>";
							}
	return $ret;
}

function tw_serializuj_zmiane($zmiana) {
	$ret = null;
	if (is_a($zmiana, 'zmiana')) {
		$ret = "<zmiana ";
		$ret .= " to='{$zmiana->typ_obiektu}' ";
		$ret .= " typ='{$zmiana->typ_zmiany}' ";
		if (!is_null($zmiana->sub_id))
			$ret .= " sub='" . (int) $zmiana->sub_id . "' ";
		if (!is_null($zmiana->osc_id))
			$ret .= " osc='" . (int) $zmiana->osc_id . "' ";
		$ret .= "><pola>";
		foreach ($zmiana->pola as $nazwa => $wartosc) {
			$ret .= tw_serializuj_pole($wartosc, $nazwa);
		}
		$ret .= "</pola></zmiana>";
	}
	return $ret;
}

function tw_serializuj_potwierdzenie($potw) {
	$ret = "<p to='{$potw->typ_obiektu}' typ='{$potw->typ_zmiany}' stat='{$potw->status}'";
	if (!is_null($potw->osc_id))
		$ret .= " osc='" . (int) $potw->osc_id . "'";
	if (!is_null($potw->sub_id))
		$ret .= " sub='" . (int) $potw->sub_id . "'";
	$ret .= '/>';

	return $ret;
}

class deserializer_potwierdzen {
	var $callback;
	var $xp;

	function deserializer_potwierdzen($callback) {
		$this->xp = xml_parser_create('');
		$this->callback = $callback;
		xml_parser_set_option($this->xp, XML_OPTION_CASE_FOLDING, FALSE);
		xml_set_object($this->xp, $this);
		xml_set_element_handler($this->xp, 'el_start', 'el_end');
	}

	function el_start($xp, $name, $atts) {
		if ($name = 'p') {
			$potw = new potwierdzenie(isset ($atts['to']) ? $atts['to'] : null, isset ($atts['typ']) ? $atts['typ'] : null, isset ($atts['osc']) ? $atts['osc'] : null, isset ($atts['sub']) ? $atts['sub'] : null, isset ($atts['stat']) ? $atts['stat'] : null);
			eval ($this->callback . '($potw);');
		}
	}

	function el_end($xp, $name) {
	}

	function free() {
		xml_parser_free($this->xp);
	}

	function deserializuj($string) {
		xml_parse($this->xp, $string);
		if ($err = xml_get_error_code($this->xp)) {
			echo "B³±d XML przy deserializacji potwierdzeñ: ", xml_error_string($err);
			echo " - linia " . xml_get_current_line_number($this->xp);
			echo ", kolumna " . xml_get_current_column_number($this->xp), "\r\n";
		}
	}
}

function tw_przekoduj_tekst($tekst, $webname_z, $webname_do) {
	if (function_exists('iconv')) {
		return iconv($webname_z, $webname_do, $tekst);
	} else
		if (function_exists('mb_convert_encoding')) {
			return mb_convert_encoding($tekst, $webname_do, $webname_z);
		} else
			die("Nie mo¿na przekodowaæ tekstu z $webname_z do $webname_do");
}

class deserializer_zmian {

	var $callback;
	var $xp;

	var $zmiana;
	var $stos;
	var $nazwa_pola;
	var $last_key;
	var $setkey;
	var $setval;

	var $nazwa_pr_el;
	var $temp_ref;
	var $temp_bin;
	var $temp_pair;

	function deserializer_zmian($callback, $kodowanie = '') {

		$this->xp = xml_parser_create($kodowanie);
		$this->callback = $callback;
		$this->stos = array ();
		xml_parser_set_option($this->xp, XML_OPTION_CASE_FOLDING, FALSE);
		if ((int) substr(phpversion(), 0, 1) >= 5) {
			xml_parser_set_option($this->xp, XML_OPTION_TARGET_ENCODING, 'UTF-8');
		}
		xml_set_object($this->xp, $this);
		xml_set_element_handler($this->xp, 'el_start', 'el_end');
		xml_set_character_data_handler($this->xp, 'cdata');
	}

	function free() {
		xml_parser_free($this->xp);
	}

	function cdata($xp, $cdata) {
		//		echo 'w cdata, ', $cdata, "\r\n";
		if ($this->temp_bin) {
			$this->temp_bin->wartosc .= trim($cdata);
		} else
			if ($this->nazwa_pr_el) {
				$wart = null;
				switch ($this->nazwa_pr_el) {
					case 'tx' :
						if (xml_parser_get_option($xp, XML_OPTION_TARGET_ENCODING) == 'UTF-8' && defined('TW_KODOWANIE_TRANSPORT') && strtolower(TW_KODOWANIE_TRANSPORT) != 'utf-8' && (!TW_DEKLARUJ_KODOWANIE_W_BD || tw_db_ustaw_kodowanie('utf-8') != 'utf-8')) {
							$wart = tw_przekoduj_tekst($cdata, 'utf-8', TW_KODOWANIE_TRANSPORT);
						} else
							$wart = $cdata;
						break;
					case 'int' :
						$wart = (int) $cdata;
						break;
					case 'dp' :
						$wart = (float) $cdata;
						break;
					case 'bl' :
						$wart = (bool) (int) $cdata;
						break;
				}

				if (!$this->stos) {
					if ($this->nazwa_pola) {
						if (!isset ($this->zmiana->pola[$this->nazwa_pola])) {
							$this->zmiana->pola[$this->nazwa_pola] = $wart;
						} else {
							$this->zmiana->pola[$this->nazwa_pola] .= $wart;
						}
					}
				} else {
					$lmap = count($this->stos) - 1;
					$lpair = count($this->stos[$lmap]) - 1;
					if ($this->setkey) {
						$this->stos[$lmap][$lpair]->k .= $wart;
					} else
						if ($this->setval) {
							$this->stos[$lmap][$lpair]->v .= $wart;
						}
				}
			}
	}

	function el_start($xp, $name, $atts) {
		//		echo 'w el_start, ', $name, ": ";
		//		print_r($atts);
		//		echo "\r\n";
		switch ($name) {
			case 'zmiana' :
				$this->zmiana = new zmiana($atts['to'], $atts['typ']);
				if (isset ($atts['osc']))
					$this->zmiana->osc_id = (int) $atts['osc'];
				if (isset ($atts['sub']))
					$this->zmiana->sub_id = (int) $atts['sub'];
				break;
			case 'b64' :
				if (!$this->stos) {
					$this->nazwa_pola = $atts['n'];
				}
				$this->temp_bin = new pole_binarne;
				$this->temp_bin->dlugosc_calkowita = $atts['dl'];
				$this->temp_bin->dlugosc_czesci = isset ($atts['dlcz']) ? $atts['dlcz'] : null;
				$this->temp_bin->offset = isset ($atts['off']) ? $atts['off'] : null;
				break;
			case 'tx' :
			case 'int' :
			case 'dp' :
			case 'bl' :
				$this->nazwa_pr_el = $name;
				if (!$this->stos) {
					$this->nazwa_pola = $atts['n'];
					$this->zmiana->pola[$this->nazwa_pola] = '';
				}
				break;
			case 'map' :
				if (!$this->stos)
					$this->nazwa_pola = $atts['n'];
				$this->stos[] = array ();
				break;
			case 'key' :
				$this->setkey = true;
				break;
			case 'val' :
				$this->setval = true;
				break;
			case 'pair' :
				$this->stos[count($this->stos) - 1][] = new pozycja_mapy();
				break;
			case 'ref' :
				if (!$this->stos)
					$this->nazwa_pola = $atts['n'];
				$this->temp_ref = new pole_referencyjne();
				$this->temp_ref->typ_obiektu = $atts['to'];
				$this->temp_ref->sub_id = isset ($atts['sub']) ? $atts['sub'] : null;
				$this->temp_ref->osc_id = isset ($atts['osc']) ? $atts['osc'] : null;
				break;
		}
	}

	function el_end($xp, $name) {
		switch ($name) {
			case 'zmiana' :
				eval ($this->callback . '($this->zmiana);');
				break;
			case 'b64' :
				$this->temp_bin->wartosc = base64_decode($this->temp_bin->wartosc);
				if (!$this->stos) {
					$this->zmiana->pola[$this->nazwa_pola] = $this->temp_bin;
				} else {
					$lmap = count($this->stos) - 1;
					$lpair = count($this->stos[$lmap]) - 1;
					if ($this->setkey) {
						$this->stos[$lmap][$lpair]->k = $this->temp_bin;
					} else
						if ($this->setval) {
							$this->stos[$lmap][$lpair]->v = $this->temp_bin;
						}
				}
				$this->temp_bin = null;
				break;
			case 'tx' :
			case 'int' :
			case 'dp' :
			case 'bl' :
				$this->nazwa_pr_el = null;
				if (!$this->stos)
					$this->nazwa_pola = null;

				break;
			case 'map' :
				$map = array_pop($this->stos);
				if ($this->stos) {
					$lmap = count($this->stos) - 1;
					$lpair = count($this->stos[$lmap]) - 1;
					$this->stos[$lmap][$lpair]->v = $map;
				} else {
					$this->zmiana->pola[$this->nazwa_pola] = $map;
				}
				break;
			case 'key' :
				$this->setkey = false;
				break;
			case 'val' :
				$this->setval = false;
				break;
			case 'pair';
				break;
			case 'ref' :
				if (!$this->stos) {
					$this->zmiana->pola[$this->nazwa_pola] = $this->temp_ref;
					$this->nazwa_pola = null;
				} else {
					$lmap = count($this->stos) - 1;
					$lpair = count($this->stos[$lmap]) - 1;
					if ($this->setkey) {
						$this->stos[$lmap][$lpair]->k = $this->temp_ref;
					} else
						if ($this->setval) {
							$this->stos[$lmap][$lpair]->v = $this->temp_ref;
						}
				}
				$this->temp_ref = null;
				break;
		}
	}

	function deserializuj($string) {
		xml_parse($this->xp, $string);
		if ($err = xml_get_error_code($this->xp)) {
			echo "B³±d XML przy deserializacji zmian: ", xml_error_string($err);
			echo " - linia " . xml_get_current_line_number($this->xp);
			echo ", kolumna " . xml_get_current_column_number($this->xp), "\r\n";
		}
	}
}

function tw_policz($tabela, $warunek = null) {
	$query = "SELECT COUNT(*) AS ile FROM " . $tabela;
	if (!is_null($warunek)) {
		$query .= " WHERE " . $warunek;
	}

	if ($wynik = mysql_query($query)) {
		$wiersz = mysql_fetch_array($wynik);
		return $wiersz["ile"];
	}

	return null;
}

class zmiana {

	var $typ_obiektu;
	var $osc_id;
	var $sub_id;
	var $pola;
	var $typ_zmiany;

	function zmiana($typ_obiektu, $typ_zmiany, $osc_id = NULL, $sub_id = NULL, $pola = array ()) {
		$this->typ_obiektu = $typ_obiektu;
		$this->typ_zmiany = $typ_zmiany;
		$this->osc_id = $osc_id;
		$this->pola = $pola;
		$this->sub_id = $sub_id;
	}

}

class pole_referencyjne {
	var $typ_obiektu;
	var $osc_id;
	var $sub_id;

	function pole_referencyjne($typ_obiektu = null, $osc_id = null, $sub_id = null) {
		$this->typ_obiektu = $typ_obiektu;
		$this->osc_id = $osc_id;
		$this->sub_id = $sub_id;
	}
}

class pole_binarne {
	var $wartosc;
	var $dlugosc_calkowita;
	var $offset;
	var $dlugosc_czesci;
}

class pozycja_mapy {
	var $k;
	var $v;

	function pozycja_mapy($k = null, $v = null) {
		$this->k = & $k;
		$this->v = & $v;
	}
}

class potwierdzenie {
	var $typ_obiektu;
	var $typ_zmiany;
	var $sub_id;
	var $osc_id;
	var $status;

	function potwierdzenie($typ_obiektu, $typ_zmiany, $osc_id = null, $sub_id = null, $status = TW_STATUSPOTWIERDZENIA_OK) {
		$this->typ_obiektu = $typ_obiektu;
		$this->typ_zmiany = $typ_zmiany;
		$this->sub_id = $sub_id;
		$this->osc_id = $osc_id;
		$this->status = $status;
	}
}

function tw_potwierdz_zmiane(& $zmiana, $status = TW_STATUSPOTWIERDZENIA_OK) {
	$potw = new potwierdzenie($zmiana->typ_obiektu, $zmiana->typ_zmiany, $zmiana->osc_id, $zmiana->sub_id, $status);
	tw_zapisz_potwierdzenie($potw);
}

function tw_zapisz_potwierdzenie(& $potw) {
	tw_db_query("INSERT INTO tw_potwierdzenia (typ_obiektu, typ_zmiany, sub_id, osc_id, status) " .
	"VALUES ('" . $potw->typ_obiektu . "', " . (int) $potw->typ_zmiany . ", " .
	 (is_null($potw->sub_id) ? 'NULL' : (int) $potw->sub_id) . ", " .
	 (is_null($potw->osc_id) ? 'NULL' : (int) $potw->osc_id) . ", " .
	(int) $potw->status . ")");
}

/*
 * Funkcje pomocnicze.
 */

function tw_vat_do_tax_class_id($vat) {
	$vat = round($vat, 2);
	$rs = tw_db_query('SELECT tax_class_id FROM ' . TABLE_TAX_RATES . ' WHERE tax_rate = ' . $vat .
	' AND tax_zone_id = ' . (defined('TW_GEOZONE_ID') ? TW_GEOZONE_ID : '0'));
	$row = tw_db_fetch_array($rs);
	tw_db_free_result($rs);
	if ($row) {
		return $row['tax_class_id'];
	} else {
		$nazwa_strefy = '';
		if (defined('TW_GEOZONE_ID')) {
			$rs = tw_db_query('SELECT geo_zone_name FROM ' . TABLE_GEO_ZONES . ' WHERE geo_zone_id = ' . TW_GEOZONE_ID);
			$row = tw_db_fetch_array($rs);
			tw_db_free_result($rs);
			if ($row) {
				$nazwa_strefy = '(' . tw_db_input($row['geo_zone_name']) . ')';
			}
		}
		tw_db_query('INSERT INTO ' . TABLE_TAX_CLASS . ' (tax_class_title, tax_class_description, last_modified, date_added) ' .
		"VALUES('VAT $vat%', 'VAT $vat%', NOW(), NOW())");
		$tcid = tw_db_insert_id();
		tw_db_query('INSERT INTO ' . TABLE_TAX_RATES . ' (tax_zone_id, tax_class_id, tax_rate, tax_description, last_modified, date_added) ' .
		"VALUES(" . (defined('TW_GEOZONE_ID') ? TW_GEOZONE_ID : '0') . ", $tcid, $vat, 'VAT $vat%', NOW(), NOW())");
		return $tcid;
	}
}

function tw_grupa_do_categories_id($grupa) {
	$grupa = tw_db_input(/*htmlspecialchars(*/
	tw_substr($grupa, 0, LIMIT_CATEGORIES_NAME) /*)*/
	);
	$rs = tw_db_query('SELECT ' . TABLE_CATEGORIES . '.categories_id FROM ' .
	TABLE_CATEGORIES . ' INNER JOIN ' . TABLE_CATEGORIES_DESCRIPTION . ' ON ' . TABLE_CATEGORIES . '.categories_id = ' . TABLE_CATEGORIES_DESCRIPTION . '.categories_id WHERE ' .
	"categories_name = '" . $grupa . '\' AND language_id = ' . TW_LANGUAGE_ID);
	$row = tw_db_fetch_array($rs);
	tw_db_free_result($rs);
	if ($row) {
		return $row['categories_id'];
	} else {
		tw_db_query("INSERT INTO " . TABLE_CATEGORIES . " (date_added) VALUES (NOW())");
		$cid = tw_db_insert_id();
		tw_db_query('INSERT INTO ' . TABLE_CATEGORIES_DESCRIPTION . ' (categories_id, language_id, categories_name) VALUES(' .
		$cid . ', ' . TW_LANGUAGE_ID . ",'" . $grupa . "')");
		return $cid;
	}
}

function tw_ustaw_cene_promocyjna($prod_id, $prom = false, $data_zakonczenia_ts = null) {
	if ($prom) {
		// ustawianie

		$data_zakonczenia_sql = $data_zakonczenia_ts ? (' FROM_UNIXTIME(' . (int) $data_zakonczenia_ts . ') ') : ' NULL ';
		//		echo $data_zakonczenia_sql;

		$rs = tw_db_query('SELECT specials_id FROM tw_towar WHERE osc_id = ' . (int) $prod_id);
		if ($row = tw_db_fetch_array($rs)) {
			$sp_id = $row['specials_id'];
			if ($sp_id) {
				// aktualizacja i aktywacja
				tw_db_query('UPDATE ' . TABLE_SPECIALS . ' SET specials_new_products_price = ' . (double) $prom .
				', specials_last_modified = NOW(), date_status_change = NOW(), status = 1, expires_date = ' . $data_zakonczenia_sql . ' WHERE specials_id = ' . $sp_id);
			} else {
				// dodanie i aktywacja
				tw_db_query('INSERT INTO ' . TABLE_SPECIALS . ' (products_id, specials_new_products_price, specials_date_added, ' .
				'specials_last_modified, date_status_change, status, expires_date) VALUES(' .
				(int) $prod_id . ', ' . (double) $prom . ', NOW(), NOW(), NOW(), 1, ' . $data_zakonczenia_sql . ')');
				$sp_id = tw_db_insert_id();
				tw_db_query('UPDATE tw_towar SET specials_id = ' . (int) $sp_id . ' WHERE osc_id = ' . (int) $prod_id);
			}
		}
		tw_db_free_result($rs);
	} else {
		// usuniêcie promocji
		$rs = tw_db_query('SELECT specials_id FROM tw_towar WHERE osc_id = ' . (int) $prod_id);
		if ($row = tw_db_fetch_array($rs)) {
			$sp_id = $row['specials_id'];
			if ($sp_id) {
				tw_db_query('UPDATE tw_towar SET specials_id = NULL WHERE osc_id = ' . (int) $prod_id);
				tw_db_query('DELETE FROM specials WHERE specials_id = ' . (int) $sp_id);
			}
		}
		tw_db_free_result($rs);
	}
}

function tw_formatuj_opis($in, $opis, $char, $uwagi) {
	$out = '';

	$ostart = tw_strpos($in, '<!-- TW_OPIS_START -->');
	$oend = tw_strpos($in, '<!-- TW_OPIS_END -->');
	$cstart = tw_strpos($in, '<!-- TW_CHAR_START -->');
	$cend = tw_strpos($in, '<!-- TW_CHAR_END -->');
	$ustart = tw_strpos($in, '<!-- TW_UWAGI_START -->');
	$uend = tw_strpos($in, '<!-- TW_UWAGI_END -->');

	if ($ostart < $oend && !isset ($opis)) {
		// skopiowanie istniej±cego opisu
		$out .= tw_substr($in, $ostart, $oend - $ostart);
		$out .= '<!-- TW_OPIS_END -->';
	} else {
		$out .= "<!-- TW_OPIS_START --><div class='" . TW_OPIS_CSSCLASS . "'>$opis</div><!-- TW_OPIS_END -->";
	}

	if ($cstart < $cend && !isset ($char)) {
		// skopiowanie istniej±cej charakterystyki
		$out .= tw_substr($in, $cstart, $cend - $cstart);
		$out .= '<!-- TW_CHAR_END -->';
	} else {
		$out .= "<!-- TW_CHAR_START --><div class='" . TW_CHAR_CSSCLASS . "'>$char</div><!-- TW_CHAR_END -->";
	}

	if ($ustart < $uend && !isset ($uwagi)) {
		$out .= tw_substr($in, $ustart, $uend - $ustart);
		$out .= '<!-- TW_UWAGI_END -->';
	} else {
		$out .= "<!-- TW_UWAGI_START --><div class='" . TW_UWAGI_CSSCLASS . "'>$uwagi</div><!-- TW_UWAGI_END -->";
	}

	$out = tw_substr($out, 0, 65535);

	return $out;
}

function tw_wczytaj_ustawienia() {

	$rs = tw_db_query('SELECT ' .
	'TW_LANGUAGE_ID, TW_GEOZONE_ID, ' .
	'TW_KATALOG_ZDJEC, TW_DEKLARUJ_KODOWANIE_W_BD, ' .
	'TW_PW_EXTRA_FIELDS_IDS, TW_OPIS_CSSCLASS, ' .
	'TW_CHAR_CSSCLASS, TW_UWAGI_CSSCLASS, ' .
	'TW_STAN_DOSTARCZONO_ID, ' .
	'TW_STAN_ZREALIZOWANO_ID, ' .
	'TW_KOLUMNA_NIP_DLA_ZAMOWIEN_Z_KLIENTEM, ' .
	'TW_KOLUMNA_NIP_DLA_ZAMOWIEN_BEZ_KLIENTA, ' .
	'TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_Z_KLIENTEM, ' .
	'TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_BEZ_KLIENTA ' .
	'FROM tw_ustawienia WHERE tw_ust_id=1');
	if ($row = tw_db_fetch_array($rs)) {
		foreach ($row as $nazwa => $wartosc) {
			if ($wartosc !== null)
				define($nazwa, $wartosc);
		}
		tw_wykryj_limity();
	} else
		die('Niezainicjalizowane ustawienia');
}

function tw_wykryj_limity() {
	// d³ugo¶æ nazwy kategorii
	$rs = tw_db_query('SHOW COLUMNS FROM ' . TABLE_CATEGORIES_DESCRIPTION . " LIKE 'categories_name'");
	$row = tw_db_fetch_array($rs);
	$groups = array ();
	if (@eregi('(var)?char\(([[:digit:]]+)\)', $row['Type'], $groups) && isset ($groups[2])) {
		define('LIMIT_CATEGORIES_NAME', (int) $groups[2]);
	} else {
		define('LIMIT_CATEGORIES_NAME', 32);
	}
	tw_db_free_result($rs);

	// d³ugo¶æ nazwy pola w³asnego
	if (tw_wykryj_extrafields()) {
		$rs = tw_db_query('SHOW COLUMNS FROM ' . TABLE_PRODUCTS_EXTRA_FIELDS . " LIKE 'products_extra_fields_name'");
		$row = tw_db_fetch_array($rs);
		$groups = array ();
		if (@eregi('(var)?char\(([[:digit:]]+)\)', $row['Type'], $groups) && isset ($groups[2])) {
			define('LIMIT_EXTRA_FIELDS_NAME', (int) $groups[2]);
		} else {
			define('LIMIT_EXTRA_FIELDS_NAME', 64);
		}
		tw_db_free_result($rs);
	}

	// d³ugo¶æ warto¶ci pola w³asnego
	if (tw_wykryj_extrafields()) {
		$rs = tw_db_query('SHOW COLUMNS FROM ' . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " LIKE 'products_extra_fields_value'");
		$row = tw_db_fetch_array($rs);
		$groups = array ();
		if (@eregi('(var)?char\(([[:digit:]]+)\)', $row['Type'], $groups) && isset ($groups[2])) {
			define('LIMIT_EXTRA_FIELDS_VALUE', (int) $groups[2]);
		} else {
			define('LIMIT_EXTRA_FIELDS_VALUE', 64);
		}
		tw_db_free_result($rs);
	}

	// d³ugo¶æ nazwy producenta
	$rs = tw_db_query('SHOW COLUMNS FROM ' . TABLE_MANUFACTURERS . " LIKE 'manufacturers_name'");
	$row = tw_db_fetch_array($rs);
	$groups = array ();
	if (@eregi('(var)?char\(([[:digit:]]+)\)', $row['Type'], $groups) && isset ($groups[2])) {
		define('LIMIT_MANUFACTURERS_NAME', (int) $groups[2]);
	} else {
		define('LIMIT_MANUFACTURERS_NAME', 32);
	}
	tw_db_free_result($rs);

	// d³ugo¶æ WWW producenta
	$rs = tw_db_query('SHOW COLUMNS FROM ' . TABLE_MANUFACTURERS_INFO . " LIKE 'manufacturers_url'");
	$row = tw_db_fetch_array($rs);
	$groups = array ();
	if (@eregi('(var)?char\(([[:digit:]]+)\)', $row['Type'], $groups) && isset ($groups[2])) {
		define('LIMIT_MANUFACTURERS_URL', (int) $groups[2]);
	} else {
		define('LIMIT_MANUFACTURERS_URL', 255);
	}
	tw_db_free_result($rs);

	// model produktu
	$rs = tw_db_query('SHOW COLUMNS FROM ' . TABLE_PRODUCTS . " LIKE 'products_model'");
	$row = tw_db_fetch_array($rs);
	$groups = array ();
	if (@eregi('(var)?char\(([[:digit:]]+)\)', $row['Type'], $groups) && isset ($groups[2])) {
		define('LIMIT_PRODUCTS_MODEL', (int) $groups[2]);
	} else {
		define('LIMIT_PRODUCTS_MODEL', 12);
	}
	tw_db_free_result($rs);

	// nazwa produktu
	$rs = tw_db_query('SHOW COLUMNS FROM ' . TABLE_PRODUCTS_DESCRIPTION . " LIKE 'products_name'");
	$row = tw_db_fetch_array($rs);
	$groups = array ();
	if (@eregi('(var)?char\(([[:digit:]]+)\)', $row['Type'], $groups) && isset ($groups[2])) {
		define('LIMIT_PRODUCTS_NAME', (int) $groups[2]);
	} else {
		define('LIMIT_PRODUCTS_NAME', 64);
	}
	tw_db_free_result($rs);

	// WWW produktu
	$rs = tw_db_query('SHOW COLUMNS FROM ' . TABLE_PRODUCTS_DESCRIPTION . " LIKE 'products_url'");
	$row = tw_db_fetch_array($rs);
	$groups = array ();
	if (@eregi('(var)?char\(([[:digit:]]+)\)', $row['Type'], $groups) && isset ($groups[2])) {
		define('LIMIT_PRODUCTS_URL', (int) $groups[2]);
	} else {
		define('LIMIT_PRODUCTS_URL', 64);
	}
	tw_db_free_result($rs);

	// nazwa pliku obrazka produktu
	$rs = tw_db_query('SHOW COLUMNS FROM ' . TABLE_PRODUCTS . " LIKE 'products_image'");
	$row = tw_db_fetch_array($rs);
	$groups = array ();
	if (@eregi('(var)?char\(([[:digit:]]+)\)', $row['Type'], $groups) && isset ($groups[2]) && $groups[2] <= 255) {
		define('LIMIT_PRODUCTS_IMAGE', (int) $groups[2]);
	} else {
		define('LIMIT_PRODUCTS_IMAGE', 64);
	}
	tw_db_free_result($rs);
}

function tw_sprawdz_licznik($wartosc) {
	tw_db_query("UPDATE tw_autentykacja SET licznik = $wartosc WHERE licznik < $wartosc AND tw_aut_id=1");
	if (tw_db_affected_rows())
		return true;
	else {
		$rs = tw_db_query('SELECT licznik FROM tw_autentykacja WHERE tw_aut_id = 1');
		$row = tw_db_fetch_array($rs);
		tw_db_free_result($rs);
		return $row['licznik'] - $wartosc;
	}
}

function tw_wykryj_extrafields() {
	return defined('TABLE_PRODUCTS_EXTRA_FIELDS');
}

function tw_wykryj_ultrapics() {
	$kolumny = array (
		'products_image_med' => null,
		'products_image_lrg' => null,
		'products_image_xl_1' => null,
		'products_image_xl_2' => null,
		'products_image_xl_3' => null,
		'products_image_xl_4' => null,
		'products_image_xl_5' => null,
		'products_image_xl_6' => null,
		'products_image_sm_1' => null,
		'products_image_sm_2' => null,
		'products_image_sm_3' => null,
		'products_image_sm_4' => null,
		'products_image_sm_5' => null,
		'products_image_sm_6' => null
	);

	$rs = tw_db_query('DESCRIBE ' . TABLE_PRODUCTS);
	if (tw_db_num_rows($rs)) {
		while ($row = tw_db_fetch_array($rs)) {
			unset ($kolumny[$row['Field']]);
			//print_r($kolumny);
		}
		if (count($kolumny) == 0)
			return true;
	}

	return false;
}

function tw_wykryj_zdjecia23() {
	return defined('TABLE_PRODUCTS_IMAGES');
}

function tw_pobierz_sekret() {
	$rs = tw_db_query('SELECT blowfish_secret FROM tw_autentykacja');
	$row = tw_db_fetch_array($rs);
	$secret = $row['blowfish_secret'];
	$secret .= str_repeat(' ', 32 - strlen($secret));
	return $secret;
}

/**
 * PEAR, the PHP Extension and Application Repository
 *
 * PEAR class and PEAR_Error class
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   pear
 * @package    PEAR
 * @author     Sterling Hughes <sterling@php.net>
 * @author     Stig Bakken <ssb@php.net>
 * @author     Tomas V.V.Cox <cox@idecnet.com>
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id: PEAR.php,v 1.98 2006/01/23 05:38:05 cellog Exp $
 * @link       http://pear.php.net/package/PEAR
 * @since      File available since Release 0.1
 */

/**#@+
 * ERROR constants
 */
define('PEAR_ERROR_RETURN', 1);
define('PEAR_ERROR_PRINT', 2);
define('PEAR_ERROR_TRIGGER', 4);
define('PEAR_ERROR_DIE', 8);
define('PEAR_ERROR_CALLBACK', 16);
/**
 * WARNING: obsolete
 * @deprecated
 */
define('PEAR_ERROR_EXCEPTION', 32);
/**#@-*/
define('PEAR_ZE2', (function_exists('version_compare') && version_compare(zend_version(), "2-dev", "ge")));

if (substr(PHP_OS, 0, 3) == 'WIN') {
	define('OS_WINDOWS', true);
	define('OS_UNIX', false);
	define('PEAR_OS', 'Windows');
} else {
	define('OS_WINDOWS', false);
	define('OS_UNIX', true);
	define('PEAR_OS', 'Unix'); // blatant assumption
}

// instant backwards compatibility
if (!defined('PATH_SEPARATOR')) {
	if (OS_WINDOWS) {
		define('PATH_SEPARATOR', ';');
	} else {
		define('PATH_SEPARATOR', ':');
	}
}

$GLOBALS['_PEAR_default_error_mode'] = PEAR_ERROR_RETURN;
$GLOBALS['_PEAR_default_error_options'] = E_USER_NOTICE;
$GLOBALS['_PEAR_destructor_object_list'] = array ();
$GLOBALS['_PEAR_shutdown_funcs'] = array ();
$GLOBALS['_PEAR_error_handler_stack'] = array ();

@ ini_set('track_errors', true);

/**
 * Base class for other PEAR classes.  Provides rudimentary
 * emulation of destructors.
 *
 * If you want a destructor in your class, inherit PEAR and make a
 * destructor method called _yourclassname (same name as the
 * constructor, but with a "_" prefix).  Also, in your constructor you
 * have to call the PEAR constructor: $this->PEAR();.
 * The destructor method will be called without parameters.  Note that
 * at in some SAPI implementations (such as Apache), any output during
 * the request shutdown (in which destructors are called) seems to be
 * discarded.  If you need to get any debug information from your
 * destructor, use error_log(), syslog() or something similar.
 *
 * IMPORTANT! To use the emulated destructors you need to create the
 * objects by reference: $obj =& new PEAR_child;
 *
 * @category   pear
 * @package    PEAR
 * @author     Stig Bakken <ssb@php.net>
 * @author     Tomas V.V. Cox <cox@idecnet.com>
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.4.10
 * @link       http://pear.php.net/package/PEAR
 * @see        PEAR_Error
 * @since      Class available since PHP 4.0.2
 * @link        http://pear.php.net/manual/en/core.pear.php#core.pear.pear
 */
class PEAR {
	// {{{ properties

	/**
	 * Whether to enable internal debug messages.
	 *
	 * @var     bool
	 * @access  private
	 */
	var $_debug = false;

	/**
	 * Default error mode for this object.
	 *
	 * @var     int
	 * @access  private
	 */
	var $_default_error_mode = null;

	/**
	 * Default error options used for this object when error mode
	 * is PEAR_ERROR_TRIGGER.
	 *
	 * @var     int
	 * @access  private
	 */
	var $_default_error_options = null;

	/**
	 * Default error handler (callback) for this object, if error mode is
	 * PEAR_ERROR_CALLBACK.
	 *
	 * @var     string
	 * @access  private
	 */
	var $_default_error_handler = '';

	/**
	 * Which class to use for error objects.
	 *
	 * @var     string
	 * @access  private
	 */
	var $_error_class = 'PEAR_Error';

	/**
	 * An array of expected errors.
	 *
	 * @var     array
	 * @access  private
	 */
	var $_expected_errors = array ();

	// }}}

	// {{{ constructor

	/**
	 * Constructor.  Registers this object in
	 * $_PEAR_destructor_object_list for destructor emulation if a
	 * destructor object exists.
	 *
	 * @param string $error_class  (optional) which class to use for
	 *        error objects, defaults to PEAR_Error.
	 * @access public
	 * @return void
	 */
	function PEAR($error_class = null) {
		$classname = strtolower(get_class($this));
		if ($this->_debug) {
			print "PEAR constructor called, class=$classname\n";
		}
		if ($error_class !== null) {
			$this->_error_class = $error_class;
		}
		while ($classname && strcasecmp($classname, "pear")) {
			$destructor = "_$classname";
			if (method_exists($this, $destructor)) {
				global $_PEAR_destructor_object_list;
				$_PEAR_destructor_object_list[] = & $this;
				if (!isset ($GLOBALS['_PEAR_SHUTDOWN_REGISTERED'])) {
					register_shutdown_function("_PEAR_call_destructors");
					$GLOBALS['_PEAR_SHUTDOWN_REGISTERED'] = true;
				}
				break;
			} else {
				$classname = get_parent_class($classname);
			}
		}
	}

	// }}}
	// {{{ destructor

	/**
	 * Destructor (the emulated type of...).  Does nothing right now,
	 * but is included for forward compatibility, so subclass
	 * destructors should always call it.
	 *
	 * See the note in the class desciption about output from
	 * destructors.
	 *
	 * @access public
	 * @return void
	 */
	function _PEAR() {
		if ($this->_debug) {
			printf("PEAR destructor called, class=%s\n", strtolower(get_class($this)));
		}
	}

	// }}}
	// {{{ getStaticProperty()

	/**
	* If you have a class that's mostly/entirely static, and you need static
	* properties, you can use this method to simulate them. Eg. in your method(s)
	* do this: $myVar = &PEAR::getStaticProperty('myclass', 'myVar');
	* You MUST use a reference, or they will not persist!
	*
	* @access public
	* @param  string $class  The calling classname, to prevent clashes
	* @param  string $var    The variable to retrieve.
	* @return mixed   A reference to the variable. If not set it will be
	*                 auto initialised to NULL.
	*/
	function & getStaticProperty($class, $var) {
		static $properties;
		return $properties[$class][$var];
	}

	// }}}
	// {{{ registerShutdownFunc()

	/**
	* Use this function to register a shutdown method for static
	* classes.
	*
	* @access public
	* @param  mixed $func  The function name (or array of class/method) to call
	* @param  mixed $args  The arguments to pass to the function
	* @return void
	*/
	function registerShutdownFunc($func, $args = array ()) {
		// if we are called statically, there is a potential
		// that no shutdown func is registered.  Bug #6445
		if (!isset ($GLOBALS['_PEAR_SHUTDOWN_REGISTERED'])) {
			register_shutdown_function("_PEAR_call_destructors");
			$GLOBALS['_PEAR_SHUTDOWN_REGISTERED'] = true;
		}
		$GLOBALS['_PEAR_shutdown_funcs'][] = array (
			$func,
			$args
		);
	}

	// }}}
	// {{{ isError()

	/**
	 * Tell whether a value is a PEAR error.
	 *
	 * @param   mixed $data   the value to test
	 * @param   int   $code   if $data is an error object, return true
	 *                        only if $code is a string and
	 *                        $obj->getMessage() == $code or
	 *                        $code is an integer and $obj->getCode() == $code
	 * @access  public
	 * @return  bool    true if parameter is an error
	 */
	function isError($data, $code = null) {
		if (is_a($data, 'PEAR_Error')) {
			if (is_null($code)) {
				return true;
			}
			elseif (is_string($code)) {
				return $data->getMessage() == $code;
			} else {
				return $data->getCode() == $code;
			}
		}
		return false;
	}

	// }}}
	// {{{ setErrorHandling()

	/**
	 * Sets how errors generated by this object should be handled.
	 * Can be invoked both in objects and statically.  If called
	 * statically, setErrorHandling sets the default behaviour for all
	 * PEAR objects.  If called in an object, setErrorHandling sets
	 * the default behaviour for that object.
	 *
	 * @param int $mode
	 *        One of PEAR_ERROR_RETURN, PEAR_ERROR_PRINT,
	 *        PEAR_ERROR_TRIGGER, PEAR_ERROR_DIE,
	 *        PEAR_ERROR_CALLBACK or PEAR_ERROR_EXCEPTION.
	 *
	 * @param mixed $options
	 *        When $mode is PEAR_ERROR_TRIGGER, this is the error level (one
	 *        of E_USER_NOTICE, E_USER_WARNING or E_USER_ERROR).
	 *
	 *        When $mode is PEAR_ERROR_CALLBACK, this parameter is expected
	 *        to be the callback function or method.  A callback
	 *        function is a string with the name of the function, a
	 *        callback method is an array of two elements: the element
	 *        at index 0 is the object, and the element at index 1 is
	 *        the name of the method to call in the object.
	 *
	 *        When $mode is PEAR_ERROR_PRINT or PEAR_ERROR_DIE, this is
	 *        a printf format string used when printing the error
	 *        message.
	 *
	 * @access public
	 * @return void
	 * @see PEAR_ERROR_RETURN
	 * @see PEAR_ERROR_PRINT
	 * @see PEAR_ERROR_TRIGGER
	 * @see PEAR_ERROR_DIE
	 * @see PEAR_ERROR_CALLBACK
	 * @see PEAR_ERROR_EXCEPTION
	 *
	 * @since PHP 4.0.5
	 */

	function setErrorHandling($mode = null, $options = null) {
		if (isset ($this) && is_a($this, 'PEAR')) {
			$setmode = & $this->_default_error_mode;
			$setoptions = & $this->_default_error_options;
		} else {
			$setmode = & $GLOBALS['_PEAR_default_error_mode'];
			$setoptions = & $GLOBALS['_PEAR_default_error_options'];
		}

		switch ($mode) {
			case PEAR_ERROR_EXCEPTION :
			case PEAR_ERROR_RETURN :
			case PEAR_ERROR_PRINT :
			case PEAR_ERROR_TRIGGER :
			case PEAR_ERROR_DIE :
			case null :
				$setmode = $mode;
				$setoptions = $options;
				break;

			case PEAR_ERROR_CALLBACK :
				$setmode = $mode;
				// class/object method callback
				if (is_callable($options)) {
					$setoptions = $options;
				} else {
					trigger_error("invalid error callback", E_USER_WARNING);
				}
				break;

			default :
				trigger_error("invalid error mode", E_USER_WARNING);
				break;
		}
	}

	// }}}
	// {{{ expectError()

	/**
	 * This method is used to tell which errors you expect to get.
	 * Expected errors are always returned with error mode
	 * PEAR_ERROR_RETURN.  Expected error codes are stored in a stack,
	 * and this method pushes a new element onto it.  The list of
	 * expected errors are in effect until they are popped off the
	 * stack with the popExpect() method.
	 *
	 * Note that this method can not be called statically
	 *
	 * @param mixed $code a single error code or an array of error codes to expect
	 *
	 * @return int     the new depth of the "expected errors" stack
	 * @access public
	 */
	function expectError($code = '*') {
		if (is_array($code)) {
			array_push($this->_expected_errors, $code);
		} else {
			array_push($this->_expected_errors, array (
				$code
			));
		}
		return sizeof($this->_expected_errors);
	}

	// }}}
	// {{{ popExpect()

	/**
	 * This method pops one element off the expected error codes
	 * stack.
	 *
	 * @return array   the list of error codes that were popped
	 */
	function popExpect() {
		return array_pop($this->_expected_errors);
	}

	// }}}
	// {{{ _checkDelExpect()

	/**
	 * This method checks unsets an error code if available
	 *
	 * @param mixed error code
	 * @return bool true if the error code was unset, false otherwise
	 * @access private
	 * @since PHP 4.3.0
	 */
	function _checkDelExpect($error_code) {
		$deleted = false;

		foreach ($this->_expected_errors AS $key => $error_array) {
			if (in_array($error_code, $error_array)) {
				unset ($this->_expected_errors[$key][array_search($error_code, $error_array)]);
				$deleted = true;
			}

			// clean up empty arrays
			if (0 == count($this->_expected_errors[$key])) {
				unset ($this->_expected_errors[$key]);
			}
		}
		return $deleted;
	}

	// }}}
	// {{{ delExpect()

	/**
	 * This method deletes all occurences of the specified element from
	 * the expected error codes stack.
	 *
	 * @param  mixed $error_code error code that should be deleted
	 * @return mixed list of error codes that were deleted or error
	 * @access public
	 * @since PHP 4.3.0
	 */
	function delExpect($error_code) {
		$deleted = false;

		if ((is_array($error_code) && (0 != count($error_code)))) {
			// $error_code is a non-empty array here;
			// we walk through it trying to unset all
			// values
			foreach ($error_code as $key => $error) {
				if ($this->_checkDelExpect($error)) {
					$deleted = true;
				} else {
					$deleted = false;
				}
			}
			return $deleted ? true : PEAR :: raiseError("The expected error you submitted does not exist"); // IMPROVE ME
		}
		elseif (!empty ($error_code)) {
			// $error_code comes alone, trying to unset it
			if ($this->_checkDelExpect($error_code)) {
				return true;
			} else {
				return PEAR :: raiseError("The expected error you submitted does not exist"); // IMPROVE ME
			}
		} else {
			// $error_code is empty
			return PEAR :: raiseError("The expected error you submitted is empty"); // IMPROVE ME
		}
	}

	// }}}
	// {{{ raiseError()

	/**
	 * This method is a wrapper that returns an instance of the
	 * configured error class with this object's default error
	 * handling applied.  If the $mode and $options parameters are not
	 * specified, the object's defaults are used.
	 *
	 * @param mixed $message a text error message or a PEAR error object
	 *
	 * @param int $code      a numeric error code (it is up to your class
	 *                  to define these if you want to use codes)
	 *
	 * @param int $mode      One of PEAR_ERROR_RETURN, PEAR_ERROR_PRINT,
	 *                  PEAR_ERROR_TRIGGER, PEAR_ERROR_DIE,
	 *                  PEAR_ERROR_CALLBACK, PEAR_ERROR_EXCEPTION.
	 *
	 * @param mixed $options If $mode is PEAR_ERROR_TRIGGER, this parameter
	 *                  specifies the PHP-internal error level (one of
	 *                  E_USER_NOTICE, E_USER_WARNING or E_USER_ERROR).
	 *                  If $mode is PEAR_ERROR_CALLBACK, this
	 *                  parameter specifies the callback function or
	 *                  method.  In other error modes this parameter
	 *                  is ignored.
	 *
	 * @param string $userinfo If you need to pass along for example debug
	 *                  information, this parameter is meant for that.
	 *
	 * @param string $error_class The returned error object will be
	 *                  instantiated from this class, if specified.
	 *
	 * @param bool $skipmsg If true, raiseError will only pass error codes,
	 *                  the error message parameter will be dropped.
	 *
	 * @access public
	 * @return object   a PEAR error object
	 * @see PEAR::setErrorHandling
	 * @since PHP 4.0.5
	 */
	function & raiseError($message = null, $code = null, $mode = null, $options = null, $userinfo = null, $error_class = null, $skipmsg = false) {
		// The error is yet a PEAR error object
		if (is_object($message)) {
			$code = $message->getCode();
			$userinfo = $message->getUserInfo();
			$error_class = $message->getType();
			$message->error_message_prefix = '';
			$message = $message->getMessage();
		}

		if (isset ($this) && isset ($this->_expected_errors) && sizeof($this->_expected_errors) > 0 && sizeof($exp = end($this->_expected_errors))) {
			if ($exp[0] == "*" || (is_int(reset($exp)) && in_array($code, $exp)) || (is_string(reset($exp)) && in_array($message, $exp))) {
				$mode = PEAR_ERROR_RETURN;
			}
		}
		// No mode given, try global ones
		if ($mode === null) {
			// Class error handler
			if (isset ($this) && isset ($this->_default_error_mode)) {
				$mode = $this->_default_error_mode;
				$options = $this->_default_error_options;
				// Global error handler
			}
			elseif (isset ($GLOBALS['_PEAR_default_error_mode'])) {
				$mode = $GLOBALS['_PEAR_default_error_mode'];
				$options = $GLOBALS['_PEAR_default_error_options'];
			}
		}

		if ($error_class !== null) {
			$ec = $error_class;
		}
		elseif (isset ($this) && isset ($this->_error_class)) {
			$ec = $this->_error_class;
		} else {
			$ec = 'PEAR_Error';
		}
		if ($skipmsg) {
			$a = new $ec ($code, $mode, $options, $userinfo);
			return $a;
		} else {
			$a = new $ec ($message, $code, $mode, $options, $userinfo);
			return $a;
		}
	}

	// }}}
	// {{{ throwError()

	/**
	 * Simpler form of raiseError with fewer options.  In most cases
	 * message, code and userinfo are enough.
	 *
	 * @param string $message
	 *
	 */
	function & throwError($message = null, $code = null, $userinfo = null) {
		if (isset ($this) && is_a($this, 'PEAR')) {
			$a = & $this->raiseError($message, $code, null, null, $userinfo);
			return $a;
		} else {
			$a = & PEAR :: raiseError($message, $code, null, null, $userinfo);
			return $a;
		}
	}

	// }}}
	function staticPushErrorHandling($mode, $options = null) {
		$stack = & $GLOBALS['_PEAR_error_handler_stack'];
		$def_mode = & $GLOBALS['_PEAR_default_error_mode'];
		$def_options = & $GLOBALS['_PEAR_default_error_options'];
		$stack[] = array (
			$def_mode,
			$def_options
		);
		switch ($mode) {
			case PEAR_ERROR_EXCEPTION :
			case PEAR_ERROR_RETURN :
			case PEAR_ERROR_PRINT :
			case PEAR_ERROR_TRIGGER :
			case PEAR_ERROR_DIE :
			case null :
				$def_mode = $mode;
				$def_options = $options;
				break;

			case PEAR_ERROR_CALLBACK :
				$def_mode = $mode;
				// class/object method callback
				if (is_callable($options)) {
					$def_options = $options;
				} else {
					trigger_error("invalid error callback", E_USER_WARNING);
				}
				break;

			default :
				trigger_error("invalid error mode", E_USER_WARNING);
				break;
		}
		$stack[] = array (
			$mode,
			$options
		);
		return true;
	}

	function staticPopErrorHandling() {
		$stack = & $GLOBALS['_PEAR_error_handler_stack'];
		$setmode = & $GLOBALS['_PEAR_default_error_mode'];
		$setoptions = & $GLOBALS['_PEAR_default_error_options'];
		array_pop($stack);
		list ($mode, $options) = $stack[sizeof($stack) - 1];
		array_pop($stack);
		switch ($mode) {
			case PEAR_ERROR_EXCEPTION :
			case PEAR_ERROR_RETURN :
			case PEAR_ERROR_PRINT :
			case PEAR_ERROR_TRIGGER :
			case PEAR_ERROR_DIE :
			case null :
				$setmode = $mode;
				$setoptions = $options;
				break;

			case PEAR_ERROR_CALLBACK :
				$setmode = $mode;
				// class/object method callback
				if (is_callable($options)) {
					$setoptions = $options;
				} else {
					trigger_error("invalid error callback", E_USER_WARNING);
				}
				break;

			default :
				trigger_error("invalid error mode", E_USER_WARNING);
				break;
		}
		return true;
	}

	// {{{ pushErrorHandling()

	/**
	 * Push a new error handler on top of the error handler options stack. With this
	 * you can easily override the actual error handler for some code and restore
	 * it later with popErrorHandling.
	 *
	 * @param mixed $mode (same as setErrorHandling)
	 * @param mixed $options (same as setErrorHandling)
	 *
	 * @return bool Always true
	 *
	 * @see PEAR::setErrorHandling
	 */
	function pushErrorHandling($mode, $options = null) {
		$stack = & $GLOBALS['_PEAR_error_handler_stack'];
		if (isset ($this) && is_a($this, 'PEAR')) {
			$def_mode = & $this->_default_error_mode;
			$def_options = & $this->_default_error_options;
		} else {
			$def_mode = & $GLOBALS['_PEAR_default_error_mode'];
			$def_options = & $GLOBALS['_PEAR_default_error_options'];
		}
		$stack[] = array (
			$def_mode,
			$def_options
		);

		if (isset ($this) && is_a($this, 'PEAR')) {
			$this->setErrorHandling($mode, $options);
		} else {
			PEAR :: setErrorHandling($mode, $options);
		}
		$stack[] = array (
			$mode,
			$options
		);
		return true;
	}

	// }}}
	// {{{ popErrorHandling()

	/**
	* Pop the last error handler used
	*
	* @return bool Always true
	*
	* @see PEAR::pushErrorHandling
	*/
	function popErrorHandling() {
		$stack = & $GLOBALS['_PEAR_error_handler_stack'];
		array_pop($stack);
		list ($mode, $options) = $stack[sizeof($stack) - 1];
		array_pop($stack);
		if (isset ($this) && is_a($this, 'PEAR')) {
			$this->setErrorHandling($mode, $options);
		} else {
			PEAR :: setErrorHandling($mode, $options);
		}
		return true;
	}

	// }}}
	// {{{ loadExtension()

	/**
	* OS independant PHP extension load. Remember to take care
	* on the correct extension name for case sensitive OSes.
	*
	* @param string $ext The extension name
	* @return bool Success or not on the dl() call
	*/
	function loadExtension($ext) {
		if (!extension_loaded($ext)) {
			// if either returns true dl() will produce a FATAL error, stop that
			if ((ini_get('enable_dl') != 1) || (ini_get('safe_mode') == 1)) {
				return false;
			}
			if (OS_WINDOWS) {
				$suffix = '.dll';
			}
			elseif (PHP_OS == 'HP-UX') {
				$suffix = '.sl';
			}
			elseif (PHP_OS == 'AIX') {
				$suffix = '.a';
			}
			elseif (PHP_OS == 'OSX') {
				$suffix = '.bundle';
			} else {
				$suffix = '.so';
			}
			return @ dl('php_' . $ext . $suffix) || @ dl($ext . $suffix);
		}
		return true;
	}

	// }}}
}

// {{{ _PEAR_call_destructors()

function _PEAR_call_destructors() {
	global $_PEAR_destructor_object_list;
	if (is_array($_PEAR_destructor_object_list) && sizeof($_PEAR_destructor_object_list)) {
		reset($_PEAR_destructor_object_list);
		if (@ PEAR :: getStaticProperty('PEAR', 'destructlifo')) {
			$_PEAR_destructor_object_list = array_reverse($_PEAR_destructor_object_list);
		}
		while (list ($k, $objref) = each($_PEAR_destructor_object_list)) {
			$classname = get_class($objref);
			while ($classname) {
				$destructor = "_$classname";
				if (method_exists($objref, $destructor)) {
					$objref-> $destructor ();
					break;
				} else {
					$classname = get_parent_class($classname);
				}
			}
		}
		// Empty the object list to ensure that destructors are
		// not called more than once.
		$_PEAR_destructor_object_list = array ();
	}

	// Now call the shutdown functions
	if (is_array($GLOBALS['_PEAR_shutdown_funcs']) AND !empty ($GLOBALS['_PEAR_shutdown_funcs'])) {
		foreach ($GLOBALS['_PEAR_shutdown_funcs'] as $value) {
			call_user_func_array($value[0], $value[1]);
		}
	}
}

// }}}
/**
 * Standard PEAR error class for PHP 4
 *
 * This class is supserseded by {@link PEAR_Exception} in PHP 5
 *
 * @category   pear
 * @package    PEAR
 * @author     Stig Bakken <ssb@php.net>
 * @author     Tomas V.V. Cox <cox@idecnet.com>
 * @author     Gregory Beaver <cellog@php.net>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.4.10
 * @link       http://pear.php.net/manual/en/core.pear.pear-error.php
 * @see        PEAR::raiseError(), PEAR::throwError()
 * @since      Class available since PHP 4.0.2
 */
class PEAR_Error {
	// {{{ properties

	var $error_message_prefix = '';
	var $mode = PEAR_ERROR_RETURN;
	var $level = E_USER_NOTICE;
	var $code = -1;
	var $message = '';
	var $userinfo = '';
	var $backtrace = null;

	// }}}
	// {{{ constructor

	/**
	 * PEAR_Error constructor
	 *
	 * @param string $message  message
	 *
	 * @param int $code     (optional) error code
	 *
	 * @param int $mode     (optional) error mode, one of: PEAR_ERROR_RETURN,
	 * PEAR_ERROR_PRINT, PEAR_ERROR_DIE, PEAR_ERROR_TRIGGER,
	 * PEAR_ERROR_CALLBACK or PEAR_ERROR_EXCEPTION
	 *
	 * @param mixed $options   (optional) error level, _OR_ in the case of
	 * PEAR_ERROR_CALLBACK, the callback function or object/method
	 * tuple.
	 *
	 * @param string $userinfo (optional) additional user/debug info
	 *
	 * @access public
	 *
	 */
	function PEAR_Error($message = 'unknown error', $code = null, $mode = null, $options = null, $userinfo = null) {
		if ($mode === null) {
			$mode = PEAR_ERROR_RETURN;
		}
		$this->message = $message;
		$this->code = $code;
		$this->mode = $mode;
		$this->userinfo = $userinfo;
		if (function_exists("debug_backtrace")) {
			if (@ !PEAR :: getStaticProperty('PEAR_Error', 'skiptrace')) {
				$this->backtrace = debug_backtrace();
			}
		}
		if ($mode & PEAR_ERROR_CALLBACK) {
			$this->level = E_USER_NOTICE;
			$this->callback = $options;
		} else {
			if ($options === null) {
				$options = E_USER_NOTICE;
			}
			$this->level = $options;
			$this->callback = null;
		}
		if ($this->mode & PEAR_ERROR_PRINT) {
			if (is_null($options) || is_int($options)) {
				$format = "%s";
			} else {
				$format = $options;
			}
			printf($format, $this->getMessage());
		}
		if ($this->mode & PEAR_ERROR_TRIGGER) {
			trigger_error($this->getMessage(), $this->level);
		}
		if ($this->mode & PEAR_ERROR_DIE) {
			$msg = $this->getMessage();
			if (is_null($options) || is_int($options)) {
				$format = "%s";
				if (substr($msg, -1) != "\n") {
					$msg .= "\n";
				}
			} else {
				$format = $options;
			}
			die(sprintf($format, $msg));
		}
		if ($this->mode & PEAR_ERROR_CALLBACK) {
			if (is_callable($this->callback)) {
				call_user_func($this->callback, $this);
			}
		}
		if ($this->mode & PEAR_ERROR_EXCEPTION) {
			trigger_error("PEAR_ERROR_EXCEPTION is obsolete, use class PEAR_Exception for exceptions", E_USER_WARNING);
			eval ('$e = new Exception($this->message, $this->code);throw($e);');
		}
	}

	// }}}
	// {{{ getMode()

	/**
	 * Get the error mode from an error object.
	 *
	 * @return int error mode
	 * @access public
	 */
	function getMode() {
		return $this->mode;
	}

	// }}}
	// {{{ getCallback()

	/**
	 * Get the callback function/method from an error object.
	 *
	 * @return mixed callback function or object/method array
	 * @access public
	 */
	function getCallback() {
		return $this->callback;
	}

	// }}}
	// {{{ getMessage()

	/**
	 * Get the error message from an error object.
	 *
	 * @return  string  full error message
	 * @access public
	 */
	function getMessage() {
		return ($this->error_message_prefix . $this->message);
	}

	// }}}
	// {{{ getCode()

	/**
	 * Get error code from an error object
	 *
	 * @return int error code
	 * @access public
	 */
	function getCode() {
		return $this->code;
	}

	// }}}
	// {{{ getType()

	/**
	 * Get the name of this error/exception.
	 *
	 * @return string error/exception name (type)
	 * @access public
	 */
	function getType() {
		return get_class($this);
	}

	// }}}
	// {{{ getUserInfo()

	/**
	 * Get additional user-supplied information.
	 *
	 * @return string user-supplied information
	 * @access public
	 */
	function getUserInfo() {
		return $this->userinfo;
	}

	// }}}
	// {{{ getDebugInfo()

	/**
	 * Get additional debug information supplied by the application.
	 *
	 * @return string debug information
	 * @access public
	 */
	function getDebugInfo() {
		return $this->getUserInfo();
	}

	// }}}
	// {{{ getBacktrace()

	/**
	 * Get the call backtrace from where the error was generated.
	 * Supported with PHP 4.3.0 or newer.
	 *
	 * @param int $frame (optional) what frame to fetch
	 * @return array Backtrace, or NULL if not available.
	 * @access public
	 */
	function getBacktrace($frame = null) {
		if (defined('PEAR_IGNORE_BACKTRACE')) {
			return null;
		}
		if ($frame === null) {
			return $this->backtrace;
		}
		return $this->backtrace[$frame];
	}

	// }}}
	// {{{ addUserInfo()

	function addUserInfo($info) {
		if (empty ($this->userinfo)) {
			$this->userinfo = $info;
		} else {
			$this->userinfo .= " ** $info";
		}
	}

	// }}}
	// {{{ toString()

	/**
	 * Make a string representation of this object.
	 *
	 * @return string a string with an object summary
	 * @access public
	 */
	function toString() {
		$modes = array ();
		$levels = array (
			E_USER_NOTICE => 'notice',
			E_USER_WARNING => 'warning',
			E_USER_ERROR => 'error'
		);
		if ($this->mode & PEAR_ERROR_CALLBACK) {
			if (is_array($this->callback)) {
				$callback = (is_object($this->callback[0]) ? strtolower(get_class($this->callback[0])) : $this->callback[0]) . '::' .
				$this->callback[1];
			} else {
				$callback = $this->callback;
			}
			return sprintf('[%s: message="%s" code=%d mode=callback ' .
			'callback=%s prefix="%s" info="%s"]', strtolower(get_class($this)), $this->message, $this->code, $callback, $this->error_message_prefix, $this->userinfo);
		}
		if ($this->mode & PEAR_ERROR_PRINT) {
			$modes[] = 'print';
		}
		if ($this->mode & PEAR_ERROR_TRIGGER) {
			$modes[] = 'trigger';
		}
		if ($this->mode & PEAR_ERROR_DIE) {
			$modes[] = 'die';
		}
		if ($this->mode & PEAR_ERROR_RETURN) {
			$modes[] = 'return';
		}
		return sprintf('[%s: message="%s" code=%d mode=%s level=%s ' .
		'prefix="%s" info="%s"]', strtolower(get_class($this)), $this->message, $this->code, implode("|", $modes), $levels[$this->level], $this->error_message_prefix, $this->userinfo);
	}

	// }}}
}

/**
 * Crypt_Blowfish allows for encryption and decryption on the fly using
 * the Blowfish algorithm. Crypt_Blowfish does not require the MCrypt
 * PHP extension, but uses it if available, otherwise it uses only PHP.
 * Crypt_Blowfish supports encryption/decryption with or without a secret key.
 *
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Encryption
 * @package    Crypt_Blowfish
 * @author     Matthew Fonda <mfonda@php.net>
 * @copyright  2005 Matthew Fonda
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id: Blowfish.php,v 1.85 2006/05/29 17:16:43 jausions Exp $
 * @link       http://pear.php.net/package/Crypt_Blowfish
 */

define('CRYPT_BLOWFISH_AUTO', 1);

define('CRYPT_BLOWFISH_MCRYPT', 2);

define('CRYPT_BLOWFISH_PHP', 3);

class Crypt_Blowfish {
	var $_crypt = null;

	var $_iv = null;

	var $_block_size = 8;

	var $_iv_size = 8;

	var $_key_size = 56;

	var $_keyHash = null;

	function Crypt_Blowfish($key) {
		$this->_crypt = & Crypt_Blowfish :: factory('ecb', $key);
		if (!@PEAR :: isError($this->_crypt)) {
			$this->_crypt->setKey($key);
		}
	}

	function & factory($mode = 'ecb', $key = null, $iv = null, $engine = CRYPT_BLOWFISH_AUTO) {
		switch ($engine) {
			case CRYPT_BLOWFISH_AUTO :
				if (!defined('CRYPT_BLOWFISH_NOMCRYPT') && extension_loaded('mcrypt')) {
					$engine = CRYPT_BLOWFISH_MCRYPT;
				} else {
					$engine = CRYPT_BLOWFISH_PHP;
				}
				break;
			case CRYPT_BLOWFISH_MCRYPT :
				if (!PEAR :: loadExtension('mcrypt')) {
					return PEAR :: raiseError('MCrypt extension is not available.');
				}
				break;
		}

		switch ($engine) {
			case CRYPT_BLOWFISH_PHP :
				$mode = strtoupper($mode);
				$class = 'Crypt_Blowfish_' . $mode;
				//include_once 'Crypt/Blowfish/' . $mode . '.php';
				$crypt = new $class (null);
				break;

			case CRYPT_BLOWFISH_MCRYPT :
				//include_once 'Crypt/Blowfish/MCrypt.php';
				$crypt = new Crypt_Blowfish_MCrypt(null, $mode);
				break;
		}

		if (!is_null($key) || !is_null($iv)) {
			$result = $crypt->setKey($key, $iv);
			if (@PEAR :: isError($result)) {
				return $result;
			}
		}

		return $crypt;
	}

	function getBlockSize() {
		return $this->_block_size;
	}

	function getIVSize() {
		return $this->_iv_size;
	}

	function getMaxKeySize() {
		return $this->_key_size;
	}

	function isReady() {
		return true;
	}

	function init() {
		return $this->_crypt->init();
	}

	function encrypt($plainText) {
		return $this->_crypt->encrypt($plainText);
	}

	function decrypt($cipherText) {
		return $this->_crypt->decrypt($cipherText);
	}

	function setKey($key) {
		return $this->_crypt->setKey($key);
	}
}

class Crypt_Blowfish_DefaultKey {
	var $P = array (
		0 => 608135816,
		1 => -2052912941,
		2 => 320440878,
		3 => 57701188,
		4 => -1542899678,
		5 => 698298832,
		6 => 137296536,
		7 => -330404727,
		8 => 1160258022,
		9 => 953160567,
		10 => -1101764913,
		11 => 887688300,
		12 => -1062458953,
		13 => -914599715,
		14 => 1065670069,
		15 => -1253635817,
		16 => -1843997223,
		17 => -1988494565,
		
	);
	var $S = array (
		0 => array (
			0 => -785314906,
			1 => -1730169428,
			2 => 805139163,
			3 => -803545161,
			4 => -1193168915,
			5 => 1780907670,
			6 => -1166241723,
			7 => -248741991,
			8 => 614570311,
			9 => -1282315017,
			10 => 134345442,
			11 => -2054226922,
			12 => 1667834072,
			13 => 1901547113,
			14 => -1537671517,
			15 => -191677058,
			16 => 227898511,
			17 => 1921955416,
			18 => 1904987480,
			19 => -2112533778,
			20 => 2069144605,
			21 => -1034266187,
			22 => -1674521287,
			23 => 720527379,
			24 => -976113629,
			25 => 677414384,
			26 => -901678824,
			27 => -1193592593,
			28 => -1904616272,
			29 => 1614419982,
			30 => 1822297739,
			31 => -1340175810,
			32 => -686458943,
			33 => -1120842969,
			34 => 2024746970,
			35 => 1432378464,
			36 => -430627341,
			37 => -1437226092,
			38 => 1464375394,
			39 => 1676153920,
			40 => 1439316330,
			41 => 715854006,
			42 => -1261675468,
			43 => 289532110,
			44 => -1588296017,
			45 => 2087905683,
			46 => -1276242927,
			47 => 1668267050,
			48 => 732546397,
			49 => 1947742710,
			50 => -832815594,
			51 => -1685613794,
			52 => -1344882125,
			53 => 1814351708,
			54 => 2050118529,
			55 => 680887927,
			56 => 999245976,
			57 => 1800124847,
			58 => -994056165,
			59 => 1713906067,
			60 => 1641548236,
			61 => -81679983,
			62 => 1216130144,
			63 => 1575780402,
			64 => -276538019,
			65 => -377129551,
			66 => -601480446,
			67 => -345695352,
			68 => 596196993,
			69 => -745100091,
			70 => 258830323,
			71 => -2081144263,
			72 => 772490370,
			73 => -1534844924,
			74 => 1774776394,
			75 => -1642095778,
			76 => 566650946,
			77 => -152474470,
			78 => 1728879713,
			79 => -1412200208,
			80 => 1783734482,
			81 => -665571480,
			82 => -1777359064,
			83 => -1420741725,
			84 => 1861159788,
			85 => 326777828,
			86 => -1170476976,
			87 => 2130389656,
			88 => -1578015459,
			89 => 967770486,
			90 => 1724537150,
			91 => -2109534584,
			92 => -1930525159,
			93 => 1164943284,
			94 => 2105845187,
			95 => 998989502,
			96 => -529566248,
			97 => -2050940813,
			98 => 1075463327,
			99 => 1455516326,
			100 => 1322494562,
			101 => 910128902,
			102 => 469688178,
			103 => 1117454909,
			104 => 936433444,
			105 => -804646328,
			106 => -619713837,
			107 => 1240580251,
			108 => 122909385,
			109 => -2137449605,
			110 => 634681816,
			111 => -152510729,
			112 => -469872614,
			113 => -1233564613,
			114 => -1754472259,
			115 => 79693498,
			116 => -1045868618,
			117 => 1084186820,
			118 => 1583128258,
			119 => 426386531,
			120 => 1761308591,
			121 => 1047286709,
			122 => 322548459,
			123 => 995290223,
			124 => 1845252383,
			125 => -1691314900,
			126 => -863943356,
			127 => -1352745719,
			128 => -1092366332,
			129 => -567063811,
			130 => 1712269319,
			131 => 422464435,
			132 => -1060394921,
			133 => 1170764815,
			134 => -771006663,
			135 => -1177289765,
			136 => 1434042557,
			137 => 442511882,
			138 => -694091578,
			139 => 1076654713,
			140 => 1738483198,
			141 => -81812532,
			142 => -1901729288,
			143 => -617471240,
			144 => 1014306527,
			145 => -43947243,
			146 => 793779912,
			147 => -1392160085,
			148 => 842905082,
			149 => -48003232,
			150 => 1395751752,
			151 => 1040244610,
			152 => -1638115397,
			153 => -898659168,
			154 => 445077038,
			155 => -552113701,
			156 => -717051658,
			157 => 679411651,
			158 => -1402522938,
			159 => -1940957837,
			160 => 1767581616,
			161 => -1144366904,
			162 => -503340195,
			163 => -1192226400,
			164 => 284835224,
			165 => -48135240,
			166 => 1258075500,
			167 => 768725851,
			168 => -1705778055,
			169 => -1225243291,
			170 => -762426948,
			171 => 1274779536,
			172 => -505548070,
			173 => -1530167757,
			174 => 1660621633,
			175 => -823867672,
			176 => -283063590,
			177 => 913787905,
			178 => -797008130,
			179 => 737222580,
			180 => -1780753843,
			181 => -1366257256,
			182 => -357724559,
			183 => 1804850592,
			184 => -795946544,
			185 => -1345903136,
			186 => -1908647121,
			187 => -1904896841,
			188 => -1879645445,
			189 => -233690268,
			190 => -2004305902,
			191 => -1878134756,
			192 => 1336762016,
			193 => 1754252060,
			194 => -774901359,
			195 => -1280786003,
			196 => 791618072,
			197 => -1106372745,
			198 => -361419266,
			199 => -1962795103,
			200 => -442446833,
			201 => -1250986776,
			202 => 413987798,
			203 => -829824359,
			204 => -1264037920,
			205 => -49028937,
			206 => 2093235073,
			207 => -760370983,
			208 => 375366246,
			209 => -2137688315,
			210 => -1815317740,
			211 => 555357303,
			212 => -424861595,
			213 => 2008414854,
			214 => -950779147,
			215 => -73583153,
			216 => -338841844,
			217 => 2067696032,
			218 => -700376109,
			219 => -1373733303,
			220 => 2428461,
			221 => 544322398,
			222 => 577241275,
			223 => 1471733935,
			224 => 610547355,
			225 => -267798242,
			226 => 1432588573,
			227 => 1507829418,
			228 => 2025931657,
			229 => -648391809,
			230 => 545086370,
			231 => 48609733,
			232 => -2094660746,
			233 => 1653985193,
			234 => 298326376,
			235 => 1316178497,
			236 => -1287180854,
			237 => 2064951626,
			238 => 458293330,
			239 => -1705826027,
			240 => -703637697,
			241 => -1130641692,
			242 => 727753846,
			243 => -2115603456,
			244 => 146436021,
			245 => 1461446943,
			246 => -224990101,
			247 => 705550613,
			248 => -1235000031,
			249 => -407242314,
			250 => -13368018,
			251 => -981117340,
			252 => 1404054877,
			253 => -1449160799,
			254 => 146425753,
			255 => 1854211946,
			
		),
		1 => array (
			0 => 1266315497,
			1 => -1246549692,
			2 => -613086930,
			3 => -1004984797,
			4 => -1385257296,
			5 => 1235738493,
			6 => -1662099272,
			7 => -1880247706,
			8 => -324367247,
			9 => 1771706367,
			10 => 1449415276,
			11 => -1028546847,
			12 => 422970021,
			13 => 1963543593,
			14 => -1604775104,
			15 => -468174274,
			16 => 1062508698,
			17 => 1531092325,
			18 => 1804592342,
			19 => -1711849514,
			20 => -1580033017,
			21 => -269995787,
			22 => 1294809318,
			23 => -265986623,
			24 => 1289560198,
			25 => -2072974554,
			26 => 1669523910,
			27 => 35572830,
			28 => 157838143,
			29 => 1052438473,
			30 => 1016535060,
			31 => 1802137761,
			32 => 1753167236,
			33 => 1386275462,
			34 => -1214491899,
			35 => -1437595849,
			36 => 1040679964,
			37 => 2145300060,
			38 => -1904392980,
			39 => 1461121720,
			40 => -1338320329,
			41 => -263189491,
			42 => -266592508,
			43 => 33600511,
			44 => -1374882534,
			45 => 1018524850,
			46 => 629373528,
			47 => -603381315,
			48 => -779021319,
			49 => 2091462646,
			50 => -1808644237,
			51 => 586499841,
			52 => 988145025,
			53 => 935516892,
			54 => -927631820,
			55 => -1695294041,
			56 => -1455136442,
			57 => 265290510,
			58 => -322386114,
			59 => -1535828415,
			60 => -499593831,
			61 => 1005194799,
			62 => 847297441,
			63 => 406762289,
			64 => 1314163512,
			65 => 1332590856,
			66 => 1866599683,
			67 => -167115585,
			68 => 750260880,
			69 => 613907577,
			70 => 1450815602,
			71 => -1129346641,
			72 => -560302305,
			73 => -644675568,
			74 => -1282691566,
			75 => -590397650,
			76 => 1427272223,
			77 => 778793252,
			78 => 1343938022,
			79 => -1618686585,
			80 => 2052605720,
			81 => 1946737175,
			82 => -1130390852,
			83 => -380928628,
			84 => -327488454,
			85 => -612033030,
			86 => 1661551462,
			87 => -1000029230,
			88 => -283371449,
			89 => 840292616,
			90 => -582796489,
			91 => 616741398,
			92 => 312560963,
			93 => 711312465,
			94 => 1351876610,
			95 => 322626781,
			96 => 1910503582,
			97 => 271666773,
			98 => -2119403562,
			99 => 1594956187,
			100 => 70604529,
			101 => -677132437,
			102 => 1007753275,
			103 => 1495573769,
			104 => -225450259,
			105 => -1745748998,
			106 => -1631928532,
			107 => 504708206,
			108 => -2031925904,
			109 => -353800271,
			110 => -2045878774,
			111 => 1514023603,
			112 => 1998579484,
			113 => 1312622330,
			114 => 694541497,
			115 => -1712906993,
			116 => -2143385130,
			117 => 1382467621,
			118 => 776784248,
			119 => -1676627094,
			120 => -971698502,
			121 => -1797068168,
			122 => -1510196141,
			123 => 503983604,
			124 => -218673497,
			125 => 907881277,
			126 => 423175695,
			127 => 432175456,
			128 => 1378068232,
			129 => -149744970,
			130 => -340918674,
			131 => -356311194,
			132 => -474200683,
			133 => -1501837181,
			134 => -1317062703,
			135 => 26017576,
			136 => -1020076561,
			137 => -1100195163,
			138 => 1700274565,
			139 => 1756076034,
			140 => -288447217,
			141 => -617638597,
			142 => 720338349,
			143 => 1533947780,
			144 => 354530856,
			145 => 688349552,
			146 => -321042571,
			147 => 1637815568,
			148 => 332179504,
			149 => -345916010,
			150 => 53804574,
			151 => -1442618417,
			152 => -1250730864,
			153 => 1282449977,
			154 => -711025141,
			155 => -877994476,
			156 => -288586052,
			157 => 1617046695,
			158 => -1666491221,
			159 => -1292663698,
			160 => 1686838959,
			161 => 431878346,
			162 => -1608291911,
			163 => 1700445008,
			164 => 1080580658,
			165 => 1009431731,
			166 => 832498133,
			167 => -1071531785,
			168 => -1688990951,
			169 => -2023776103,
			170 => -1778935426,
			171 => 1648197032,
			172 => -130578278,
			173 => -1746719369,
			174 => 300782431,
			175 => 375919233,
			176 => 238389289,
			177 => -941219882,
			178 => -1763778655,
			179 => 2019080857,
			180 => 1475708069,
			181 => 455242339,
			182 => -1685863425,
			183 => 448939670,
			184 => -843904277,
			185 => 1395535956,
			186 => -1881585436,
			187 => 1841049896,
			188 => 1491858159,
			189 => 885456874,
			190 => -30872223,
			191 => -293847949,
			192 => 1565136089,
			193 => -396052509,
			194 => 1108368660,
			195 => 540939232,
			196 => 1173283510,
			197 => -1549095958,
			198 => -613658859,
			199 => -87339056,
			200 => -951913406,
			201 => -278217803,
			202 => 1699691293,
			203 => 1103962373,
			204 => -669091426,
			205 => -2038084153,
			206 => -464828566,
			207 => 1031889488,
			208 => -815619598,
			209 => 1535977030,
			210 => -58162272,
			211 => -1043876189,
			212 => 2132092099,
			213 => 1774941330,
			214 => 1199868427,
			215 => 1452454533,
			216 => 157007616,
			217 => -1390851939,
			218 => 342012276,
			219 => 595725824,
			220 => 1480756522,
			221 => 206960106,
			222 => 497939518,
			223 => 591360097,
			224 => 863170706,
			225 => -1919713727,
			226 => -698356495,
			227 => 1814182875,
			228 => 2094937945,
			229 => -873565088,
			230 => 1082520231,
			231 => -831049106,
			232 => -1509457788,
			233 => 435703966,
			234 => -386934699,
			235 => 1641649973,
			236 => -1452693590,
			237 => -989067582,
			238 => 1510255612,
			239 => -2146710820,
			240 => -1639679442,
			241 => -1018874748,
			242 => -36346107,
			243 => 236887753,
			244 => -613164077,
			245 => 274041037,
			246 => 1734335097,
			247 => -479771840,
			248 => -976997275,
			249 => 1899903192,
			250 => 1026095262,
			251 => -244449504,
			252 => 356393447,
			253 => -1884275382,
			254 => -421290197,
			255 => -612127241,
			
		),
		2 => array (
			0 => -381855128,
			1 => -1803468553,
			2 => -162781668,
			3 => -1805047500,
			4 => 1091903735,
			5 => 1979897079,
			6 => -1124832466,
			7 => -727580568,
			8 => -737663887,
			9 => 857797738,
			10 => 1136121015,
			11 => 1342202287,
			12 => 507115054,
			13 => -1759230650,
			14 => 337727348,
			15 => -1081374656,
			16 => 1301675037,
			17 => -1766485585,
			18 => 1895095763,
			19 => 1721773893,
			20 => -1078195732,
			21 => 62756741,
			22 => 2142006736,
			23 => 835421444,
			24 => -1762973773,
			25 => 1442658625,
			26 => -635090970,
			27 => -1412822374,
			28 => 676362277,
			29 => 1392781812,
			30 => 170690266,
			31 => -373920261,
			32 => 1759253602,
			33 => -683120384,
			34 => 1745797284,
			35 => 664899054,
			36 => 1329594018,
			37 => -393761396,
			38 => -1249058810,
			39 => 2062866102,
			40 => -1429332356,
			41 => -751345684,
			42 => -830954599,
			43 => 1080764994,
			44 => 553557557,
			45 => -638351943,
			46 => -298199125,
			47 => 991055499,
			48 => 499776247,
			49 => 1265440854,
			50 => 648242737,
			51 => -354183246,
			52 => 980351604,
			53 => -581221582,
			54 => 1749149687,
			55 => -898096901,
			56 => -83167922,
			57 => -654396521,
			58 => 1161844396,
			59 => -1169648345,
			60 => 1431517754,
			61 => 545492359,
			62 => -26498633,
			63 => -795437749,
			64 => 1437099964,
			65 => -1592419752,
			66 => -861329053,
			67 => -1713251533,
			68 => -1507177898,
			69 => 1060185593,
			70 => 1593081372,
			71 => -1876348548,
			72 => -34019326,
			73 => 69676912,
			74 => -2135222948,
			75 => 86519011,
			76 => -1782508216,
			77 => -456757982,
			78 => 1220612927,
			79 => -955283748,
			80 => 133810670,
			81 => 1090789135,
			82 => 1078426020,
			83 => 1569222167,
			84 => 845107691,
			85 => -711212847,
			86 => -222510705,
			87 => 1091646820,
			88 => 628848692,
			89 => 1613405280,
			90 => -537335645,
			91 => 526609435,
			92 => 236106946,
			93 => 48312990,
			94 => -1352249391,
			95 => -892239595,
			96 => 1797494240,
			97 => 859738849,
			98 => 992217954,
			99 => -289490654,
			100 => -2051890674,
			101 => -424014439,
			102 => -562951028,
			103 => 765654824,
			104 => -804095931,
			105 => -1783130883,
			106 => 1685915746,
			107 => -405998096,
			108 => 1414112111,
			109 => -2021832454,
			110 => -1013056217,
			111 => -214004450,
			112 => 172450625,
			113 => -1724973196,
			114 => 980381355,
			115 => -185008841,
			116 => -1475158944,
			117 => -1578377736,
			118 => -1726226100,
			119 => -613520627,
			120 => -964995824,
			121 => 1835478071,
			122 => 660984891,
			123 => -590288892,
			124 => -248967737,
			125 => -872349789,
			126 => -1254551662,
			127 => 1762651403,
			128 => 1719377915,
			129 => -824476260,
			130 => -1601057013,
			131 => -652910941,
			132 => -1156370552,
			133 => 1364962596,
			134 => 2073328063,
			135 => 1983633131,
			136 => 926494387,
			137 => -871278215,
			138 => -2144935273,
			139 => -198299347,
			140 => 1749200295,
			141 => -966120645,
			142 => 309677260,
			143 => 2016342300,
			144 => 1779581495,
			145 => -1215147545,
			146 => 111262694,
			147 => 1274766160,
			148 => 443224088,
			149 => 298511866,
			150 => 1025883608,
			151 => -488520759,
			152 => 1145181785,
			153 => 168956806,
			154 => -653464466,
			155 => -710153686,
			156 => 1689216846,
			157 => -628709281,
			158 => -1094719096,
			159 => 1692713982,
			160 => -1648590761,
			161 => -252198778,
			162 => 1618508792,
			163 => 1610833997,
			164 => -771914938,
			165 => -164094032,
			166 => 2001055236,
			167 => -684262196,
			168 => -2092799181,
			169 => -266425487,
			170 => -1333771897,
			171 => 1006657119,
			172 => 2006996926,
			173 => -1108824540,
			174 => 1430667929,
			175 => -1084739999,
			176 => 1314452623,
			177 => -220332638,
			178 => -193663176,
			179 => -2021016126,
			180 => 1399257539,
			181 => -927756684,
			182 => -1267338667,
			183 => 1190975929,
			184 => 2062231137,
			185 => -1960976508,
			186 => -2073424263,
			187 => -1856006686,
			188 => 1181637006,
			189 => 548689776,
			190 => -1932175983,
			191 => -922558900,
			192 => -1190417183,
			193 => -1149106736,
			194 => 296247880,
			195 => 1970579870,
			196 => -1216407114,
			197 => -525738999,
			198 => 1714227617,
			199 => -1003338189,
			200 => -396747006,
			201 => 166772364,
			202 => 1251581989,
			203 => 493813264,
			204 => 448347421,
			205 => 195405023,
			206 => -1584991729,
			207 => 677966185,
			208 => -591930749,
			209 => 1463355134,
			210 => -1578971493,
			211 => 1338867538,
			212 => 1343315457,
			213 => -1492745222,
			214 => -1610435132,
			215 => 233230375,
			216 => -1694987225,
			217 => 2000651841,
			218 => -1017099258,
			219 => 1638401717,
			220 => -266896856,
			221 => -1057650976,
			222 => 6314154,
			223 => 819756386,
			224 => 300326615,
			225 => 590932579,
			226 => 1405279636,
			227 => -1027467724,
			228 => -1144263082,
			229 => -1866680610,
			230 => -335774303,
			231 => -833020554,
			232 => 1862657033,
			233 => 1266418056,
			234 => 963775037,
			235 => 2089974820,
			236 => -2031914401,
			237 => 1917689273,
			238 => 448879540,
			239 => -744572676,
			240 => -313240200,
			241 => 150775221,
			242 => -667058989,
			243 => 1303187396,
			244 => 508620638,
			245 => -1318983944,
			246 => -1568336679,
			247 => 1817252668,
			248 => 1876281319,
			249 => 1457606340,
			250 => 908771278,
			251 => -574175177,
			252 => -677760460,
			253 => -1838972398,
			254 => 1729034894,
			255 => 1080033504,
			
		),
		3 => array (
			0 => 976866871,
			1 => -738527793,
			2 => -1413318857,
			3 => 1522871579,
			4 => 1555064734,
			5 => 1336096578,
			6 => -746444992,
			7 => -1715692610,
			8 => -720269667,
			9 => -1089506539,
			10 => -701686658,
			11 => -956251013,
			12 => -1215554709,
			13 => 564236357,
			14 => -1301368386,
			15 => 1781952180,
			16 => 1464380207,
			17 => -1131123079,
			18 => -962365742,
			19 => 1699332808,
			20 => 1393555694,
			21 => 1183702653,
			22 => -713881059,
			23 => 1288719814,
			24 => 691649499,
			25 => -1447410096,
			26 => -1399511320,
			27 => -1101077756,
			28 => -1577396752,
			29 => 1781354906,
			30 => 1676643554,
			31 => -1702433246,
			32 => -1064713544,
			33 => 1126444790,
			34 => -1524759638,
			35 => -1661808476,
			36 => -2084544070,
			37 => -1679201715,
			38 => -1880812208,
			39 => -1167828010,
			40 => 673620729,
			41 => -1489356063,
			42 => 1269405062,
			43 => -279616791,
			44 => -953159725,
			45 => -145557542,
			46 => 1057255273,
			47 => 2012875353,
			48 => -2132498155,
			49 => -2018474495,
			50 => -1693849939,
			51 => 993977747,
			52 => -376373926,
			53 => -1640704105,
			54 => 753973209,
			55 => 36408145,
			56 => -1764381638,
			57 => 25011837,
			58 => -774947114,
			59 => 2088578344,
			60 => 530523599,
			61 => -1376601957,
			62 => 1524020338,
			63 => 1518925132,
			64 => -534139791,
			65 => -535190042,
			66 => 1202760957,
			67 => -309069157,
			68 => -388774771,
			69 => 674977740,
			70 => -120232407,
			71 => 2031300136,
			72 => 2019492241,
			73 => -311074731,
			74 => -141160892,
			75 => -472686964,
			76 => 352677332,
			77 => -1997247046,
			78 => 60907813,
			79 => 90501309,
			80 => -1007968747,
			81 => 1016092578,
			82 => -1759044884,
			83 => -1455814870,
			84 => 457141659,
			85 => 509813237,
			86 => -174299397,
			87 => 652014361,
			88 => 1966332200,
			89 => -1319764491,
			90 => 55981186,
			91 => -1967506245,
			92 => 676427537,
			93 => -1039476232,
			94 => -1412673177,
			95 => -861040033,
			96 => 1307055953,
			97 => 942726286,
			98 => 933058658,
			99 => -1826555503,
			100 => -361066302,
			101 => -79791154,
			102 => 1361170020,
			103 => 2001714738,
			104 => -1464409218,
			105 => -1020707514,
			106 => 1222529897,
			107 => 1679025792,
			108 => -1565652976,
			109 => -580013532,
			110 => 1770335741,
			111 => 151462246,
			112 => -1281735158,
			113 => 1682292957,
			114 => 1483529935,
			115 => 471910574,
			116 => 1539241949,
			117 => 458788160,
			118 => -858652289,
			119 => 1807016891,
			120 => -576558466,
			121 => 978976581,
			122 => 1043663428,
			123 => -1129001515,
			124 => 1927990952,
			125 => -94075717,
			126 => -1922690386,
			127 => -1086558393,
			128 => -761535389,
			129 => 1412390302,
			130 => -1362987237,
			131 => -162634896,
			132 => 1947078029,
			133 => -413461673,
			134 => -126740879,
			135 => -1353482915,
			136 => 1077988104,
			137 => 1320477388,
			138 => 886195818,
			139 => 18198404,
			140 => -508558296,
			141 => -1785185763,
			142 => 112762804,
			143 => -831610808,
			144 => 1866414978,
			145 => 891333506,
			146 => 18488651,
			147 => 661792760,
			148 => 1628790961,
			149 => -409780260,
			150 => -1153795797,
			151 => 876946877,
			152 => -1601685023,
			153 => 1372485963,
			154 => 791857591,
			155 => -1608533303,
			156 => -534984578,
			157 => -1127755274,
			158 => -822013501,
			159 => -1578587449,
			160 => 445679433,
			161 => -732971622,
			162 => -790962485,
			163 => -720709064,
			164 => 54117162,
			165 => -963561881,
			166 => -1913048708,
			167 => -525259953,
			168 => -140617289,
			169 => 1140177722,
			170 => -220915201,
			171 => 668550556,
			172 => -1080614356,
			173 => 367459370,
			174 => 261225585,
			175 => -1684794075,
			176 => -85617823,
			177 => -826893077,
			178 => -1029151655,
			179 => 314222801,
			180 => -1228863650,
			181 => -486184436,
			182 => 282218597,
			183 => -888953790,
			184 => -521376242,
			185 => 379116347,
			186 => 1285071038,
			187 => 846784868,
			188 => -1625320142,
			189 => -523005217,
			190 => -744475605,
			191 => -1989021154,
			192 => 453669953,
			193 => 1268987020,
			194 => -977374944,
			195 => -1015663912,
			196 => -550133875,
			197 => -1684459730,
			198 => -435458233,
			199 => 266596637,
			200 => -447948204,
			201 => 517658769,
			202 => -832407089,
			203 => -851542417,
			204 => 370717030,
			205 => -47440635,
			206 => -2070949179,
			207 => -151313767,
			208 => -182193321,
			209 => -1506642397,
			210 => -1817692879,
			211 => 1456262402,
			212 => -1393524382,
			213 => 1517677493,
			214 => 1846949527,
			215 => -1999473716,
			216 => -560569710,
			217 => -2118563376,
			218 => 1280348187,
			219 => 1908823572,
			220 => -423180355,
			221 => 846861322,
			222 => 1172426758,
			223 => -1007518822,
			224 => -911584259,
			225 => 1655181056,
			226 => -1155153950,
			227 => 901632758,
			228 => 1897031941,
			229 => -1308360158,
			230 => -1228157060,
			231 => -847864789,
			232 => 1393639104,
			233 => 373351379,
			234 => 950779232,
			235 => 625454576,
			236 => -1170726756,
			237 => -146354570,
			238 => 2007998917,
			239 => 544563296,
			240 => -2050228658,
			241 => -1964470824,
			242 => 2058025392,
			243 => 1291430526,
			244 => 424198748,
			245 => 50039436,
			246 => 29584100,
			247 => -689184263,
			248 => -1865090967,
			249 => -1503863136,
			250 => 1057563949,
			251 => -1039604065,
			252 => -1219600078,
			253 => -831004069,
			254 => 1469046755,
			255 => 985887462,
			
		),
		
	);
}

class Crypt_Blowfish_PHP extends Crypt_Blowfish {

	var $_P = array ();

	var $_S = array ();

	var $_iv_required = false;

	function __construct($key = null, $iv = null) {
		$this->_iv = $iv . ((strlen($iv) < $this->_iv_size) ? str_repeat(chr(0), $this->_iv_size - strlen($iv)) : '');
		if (!is_null($key)) {
			$this->setKey($key, $this->_iv);
		}
	}

	function _init() {
		//require_once 'Crypt/Blowfish/DefaultKey.php';
		$defaults = new Crypt_Blowfish_DefaultKey();
		$this->_P = $defaults->P;
		$this->_S = $defaults->S;
	}

	function _binxor($l, $r) {
		while ($l > 2147483647) {
			$l -= 4294967296;
		}
		while ($l < -2147483648) {
			$l += 4294967296;
		}
		$l = (int) $l;

		while ($r > 2147483647) {
			$r = $r -4294967296;
		}
		while ($r < -2147483648) {
			$r += 4294967296;
		}
		$r = (int) $r;

		return $l ^ $r;
	}

	function _encipher(& $Xl, & $Xr) {
		for ($i = 0; $i < 16; $i++) {
			$temp = $this->_binxor($Xl, $this->_P[$i]);

			$Xl = $this->_binxor($this->_binxor($this->_S[0][($temp >> 24) & 255] + $this->_S[1][($temp >> 16) & 255], $this->_S[2][($temp >> 8) & 255]) + $this->_S[3][$temp & 255], $Xr);

			$Xr = $temp;
		}
		$Xr = $this->_binxor($Xl, $this->_P[16]);
		$Xl = $this->_binxor($temp, $this->_P[17]);
	}

	function _decipher(& $Xl, & $Xr) {
		for ($i = 17; $i > 1; $i--) {
			$temp = $this->_binxor($Xl, $this->_P[$i]);
			$Xl = $this->_binxor($this->_binxor(($this->_S[0][($temp >> 24) & 255] + $this->_S[1][($temp >> 16) & 255]), $this->_S[2][($temp >> 8) & 255]) + $this->_S[3][$temp & 255], $Xr);
			$Xr = $temp;
		}
		$Xr = $this->_binxor($Xl, $this->_P[1]);
		$Xl = $this->_binxor($temp, $this->_P[0]);
	}

	/**
	 * Sets the secret key
	 * The key must be non-zero, and less than or equal to
	 * 56 characters (bytes) in length.
	 *
	 * If you are making use of the PHP mcrypt extension, you must call this
	 * method before each encrypt() and decrypt() call.
	 *
	 * @param string $key
	 * @param string $iv 8-char initialization vector (required for CBC mode)
	 * @return boolean|PEAR_Error  Returns TRUE on success, PEAR_Error on failure
	 * @access public
	 * @todo Fix the caching of the key
	 */
	function setKey($key, $iv = null) {

		if (!is_string($key)) {
			return PEAR :: raiseError('Key must be a string', 2);
		}

		$len = strlen($key);

		if ($len > $this->_key_size || $len == 0) {
			return PEAR :: raiseError('Key must be less than ' . $this->_key_size . ' characters (bytes) and non-zero. Supplied key length: ' . $len, 3);
		}

		if ($this->_iv_required) {
			if (strlen($iv) != $this->_iv_size) {
				return PEAR :: raiseError('IV must be ' . $this->_iv_size . '-character (byte) long. Supplied IV length: ' . strlen($iv), 7);
			}
			$this->_iv = $iv;
		}

		// If same key passed, no need to re-initialize internal arrays.
		// @todo This needs to be worked out better...
		if ($this->_keyHash == md5($key)) {
			return true;
		}

		$this->_init();

		$k = 0;
		$data = 0;
		$datal = 0;
		$datar = 0;

		for ($i = 0; $i < 18; $i++) {
			$data = 0;
			for ($j = 4; $j > 0; $j--) {
				$data = $data << 8 | ord($key {
					$k });
				$k = ($k +1) % $len;
			}
			$this->_P[$i] = $this->_binxor($this->_P[$i], $data);
		}

		for ($i = 0; $i <= 16; $i += 2) {
			$this->_encipher($datal, $datar);
			$this->_P[$i] = $datal;
			$this->_P[$i +1] = $datar;
		}
		for ($i = 0; $i < 256; $i += 2) {
			$this->_encipher($datal, $datar);
			$this->_S[0][$i] = $datal;
			$this->_S[0][$i +1] = $datar;
		}
		for ($i = 0; $i < 256; $i += 2) {
			$this->_encipher($datal, $datar);
			$this->_S[1][$i] = $datal;
			$this->_S[1][$i +1] = $datar;
		}
		for ($i = 0; $i < 256; $i += 2) {
			$this->_encipher($datal, $datar);
			$this->_S[2][$i] = $datal;
			$this->_S[2][$i +1] = $datar;
		}
		for ($i = 0; $i < 256; $i += 2) {
			$this->_encipher($datal, $datar);
			$this->_S[3][$i] = $datal;
			$this->_S[3][$i +1] = $datar;
		}

		$this->_keyHash = md5($key);
		return true;
	}
}

class Crypt_Blowfish_ECB extends Crypt_Blowfish_PHP {
  /*
	function Crypt_Blowfish_ECB($key = null, $iv = null) {
		$this->__construct($key, $iv);
	}
	*/

	function __construct($key = null, $iv = null) {
		$this->_iv_required = false;
		parent :: __construct($key, $iv);
	}

	function encrypt($plainText) {
		if (!is_string($plainText)) {
			return PEAR :: raiseError('Input must be a string', 0);
		}
		elseif (empty ($this->_P)) {
			return PEAR :: raiseError('The key is not initialized.', 8);
		}

		$cipherText = '';
		$len = strlen($plainText);
		$plainText .= str_repeat(chr(0), (8 - ($len % 8)) % 8);

		for ($i = 0; $i < $len; $i += 8) {
			list (, $Xl, $Xr) = unpack('N2', substr($plainText, $i, 8));
			$this->_encipher($Xl, $Xr);
			$cipherText .= pack('N2', $Xl, $Xr);
		}

		return $cipherText;
	}

	function decrypt($cipherText) {
		if (!is_string($cipherText)) {
			return PEAR :: raiseError('Cipher text must be a string', 1);
		}
		if (empty ($this->_P)) {
			return PEAR :: raiseError('The key is not initialized.', 8);
		}

		$plainText = '';
		$len = strlen($cipherText);
		$cipherText .= str_repeat(chr(0), (8 - ($len % 8)) % 8);

		for ($i = 0; $i < $len; $i += 8) {
			list (, $Xl, $Xr) = unpack('N2', substr($cipherText, $i, 8));
			$this->_decipher($Xl, $Xr);
			$plainText .= pack('N2', $Xl, $Xr);
		}

		return $plainText;
	}
}

function tw_substr($string, $start, $length = null) {
	if (defined('TW_KODOWANIE_TRANSPORT') && TW_KODOWANIE_TRANSPORT == 'utf-8' && function_exists('mb_substr')) {
		$substring = mb_substr($string, $start, $length, 'utf-8');
	} else {
		$substring = substr($string, $start, $length);
	}
	$ampersandidx = strrpos($substring, '&');
	if ($ampersandidx !== false) {
		$semicolonidx = strrpos($substring, ';');
		if ($semicolonidx === false || $semicolonidx < $ampersandidx) {
			$substring = substr($substring, 0, $ampersandidx);
		}
	}
	return $substring;
}

function tw_strpos($haystack, $needle, $offset = null) {
	if (defined('TW_KODOWANIE_TRANSPORT') && TW_KODOWANIE_TRANSPORT == 'utf-8' && function_exists('mb_strpos')) {
		return mb_strpos($haystack, $needle, $offset, 'utf-8');
	} else {
		return strpos($haystack, $needle, $offset);
	}
}

// w oscGT szyfrujemy wiadomo¶æ o d³ugo¶ci a¿ 56 znaków, st±d nie jest 
// potrzebne korzystanie z rozszerzenia mcrypt
define('CRYPT_BLOWFISH_NOMCRYPT', true);
?>