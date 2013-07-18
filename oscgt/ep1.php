<?php

require 'epall.php';

function tw_przelicz_rabat($c_netto_bez_rabatu, $c_netto) {
	return ($c_netto_bez_rabatu - $c_netto) / $c_netto_bez_rabatu * 100.0;
}

function tw_serializuj_klientow() {
	$xml = '';

	$klienci = tw_db_query("SELECT " .
	"z.id_klienta AS id, " .
	"z.typ_zmiany AS typ_zmiany, " .
	"c.customers_firstname AS imie, c.customers_lastname AS nazwisko, " .
	"DATE_FORMAT(c.customers_dob,'%Y%m%d') AS data_ur, " .	
	"c.customers_email_address AS email, " .
	"c.customers_telephone AS telefon, " .
	"c.customers_fax AS fax, " .
	"c.customers_newsletter AS spam, " .
	"a.entry_company AS firma, " .
    TW_KOLUMNA_NIP_DLA_ZAMOWIEN_Z_KLIENTEM . " AS nip, " .
	TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_Z_KLIENTEM . " AS pesel, " .
	"NULL AS pw1, " .
	"NULL AS pw2, " .
	"NULL AS pw3, " .
	"NULL AS pw4, " .
	"NULL AS pw5, " .
	"NULL AS pw6, " .
	"NULL AS pw7, " .
	"NULL AS pw8, " .
	"a.entry_street_address AS adres, " .
	"a.entry_postcode AS kod_poczt, " .
	"a.entry_city AS miasto, " .
	"a.entry_state AS wojewodztwo, " .
	"k.countries_name AS panstwo, " .
	"k.countries_iso_code_2 AS panstwo_kod " .
	"FROM tw_zmiany_klienci z " .
	"JOIN " . TABLE_CUSTOMERS . " c ON c.customers_id = z.id_klienta " .
	"JOIN " . TABLE_ADDRESS_BOOK . " a ON c.customers_default_address_id = a.address_book_id " .
	"LEFT JOIN " . TABLE_COUNTRIES . " k ON a.entry_country_id = k.countries_id " .
	"UNION " .
	"SELECT " .
	"z.id_klienta AS id, " .
	"z.typ_zmiany AS typ_zmiany, " .
//	"o.billing_name AS nazwa, " .
	"LTRIM(RTRIM(SUBSTRING(o.billing_name, 1, LENGTH(o.billing_name) - LOCATE(' ', REVERSE(o.billing_name))))) AS imie, " .
	"LTRIM(RTRIM(SUBSTRING(o.billing_name, LENGTH(o.billing_name) - LOCATE(' ', REVERSE(o.billing_name)) + 1))) AS nazwisko, " .
	"null AS data_ur, " .	
	"o.customers_email_address AS email, " .	
	"o.customers_telephone AS telefon, " .	
	"null AS fax, " .
	"null AS spam, " .	
	"o.customers_company AS firma, " .	
	TW_KOLUMNA_NIP_DLA_ZAMOWIEN_BEZ_KLIENTA . " AS nip, " .
	TW_KOLUMNA_PESEL_DLA_ZAMOWIEN_BEZ_KLIENTA . " AS pesel, " .
	"NULL AS pw1, " .
	"NULL AS pw2, " .
	"NULL AS pw3, " .
	"NULL AS pw4, " .
	"NULL AS pw5, " .
	"NULL AS pw6, " .
	"NULL AS pw7, " .
	"NULL AS pw8, " .
	"o.customers_street_address AS adres, " .	
	"o.customers_postcode AS kod_poczt, " .	
	"o.customers_city AS miasto, " .	
	"o.customers_state AS wojewodztwo, " .	
	"o.customers_country AS panstwo, " .	
	"k.countries_iso_code_2 AS panstwo_kod " .
	"FROM tw_zmiany_klienci z " .
	"LEFT JOIN " . TABLE_CUSTOMERS . " c ON c.customers_id = z.id_klienta " .
	"JOIN " . TABLE_ORDERS . " o ON z.id_klienta = o.customers_id " .
	"LEFT JOIN " . TABLE_COUNTRIES . " k ON o.customers_country = k.countries_name " .
	// "JOIN (SELECT * FROM " . TABLE_ORDERS . " GROUP BY customers_id) o ON z.id_klienta = o.customers_id " .
	// "LEFT JOIN (SELECT * FROM " . TABLE_COUNTRIES . " GROUP BY countries_name) k ON o.customers_country = k.countries_name " .
	"WHERE c.customers_id IS NULL " .
	"GROUP BY z.id_klienta, k.countries_name");
	
	while ($klient = mysql_fetch_array($klienci)) {
		$zmiana = new zmiana('klient', $klient['typ_zmiany'], $klient['id']);

		//if ($klient['nazwa'] !== null) $zmiana->pola['nazwa'] = $klient['nazwa'];
		if ($klient['imie'] !== null) $zmiana->pola['imie'] = $klient['imie'];
		if ($klient['nazwisko'] !== null) $zmiana->pola['nazwisko'] = $klient['nazwisko'];
		if ($klient['data_ur'] !== null) $zmiana->pola['data_ur'] = $klient['data_ur'];
		if ($klient['email'] !== null) $zmiana->pola['email'] = $klient['email'];
		if ($klient['telefon'] !== null) $zmiana->pola['telefon'] = $klient['telefon'];
		if ($klient['fax'] !== null) $zmiana->pola['fax'] = $klient['fax'];
		if ($klient['spam'] !== null) $zmiana->pola['spam'] = (bool)$klient['spam']; 
		if ($klient['firma'] !== null) $zmiana->pola['firma'] = $klient['firma'];
		if ($klient['nip'] !== null) $zmiana->pola['nip'] = (string)$klient['nip'];
		if ($klient['pesel'] !== null) $zmiana->pola['pesel'] = (string)$klient['pesel'];
		if ($klient['pw1'] !== null) $zmiana->pola['pw1'] = $klient['pw1'];
		if ($klient['pw2'] !== null) $zmiana->pola['pw2'] = $klient['pw2'];
		if ($klient['pw3'] !== null) $zmiana->pola['pw3'] = $klient['pw3'];
		if ($klient['pw4'] !== null) $zmiana->pola['pw4'] = $klient['pw4'];
		if ($klient['pw5'] !== null) $zmiana->pola['pw5'] = $klient['pw5'];
		if ($klient['pw6'] !== null) $zmiana->pola['pw6'] = $klient['pw6'];
		if ($klient['pw7'] !== null) $zmiana->pola['pw7'] = $klient['pw7'];
		if ($klient['pw8'] !== null) $zmiana->pola['pw8'] = $klient['pw8'];
		if ($klient['adres'] !== null) $zmiana->pola['adres'] = $klient['adres'];
		if ($klient['miasto'] !== null) $zmiana->pola['miasto'] = $klient['miasto'];
		if ($klient['kod_poczt'] !== null) $zmiana->pola['kod_poczt'] = $klient['kod_poczt'];
		if ($klient['panstwo'] !== null) $zmiana->pola['panstwo'] = $klient['panstwo'];
		if ($klient['panstwo_kod'] !== null) $zmiana->pola['panstwo_kod'] = $klient['panstwo_kod'];
		if ($klient['wojewodztwo'] !== null) $zmiana->pola['wojewodztwo'] = $klient['wojewodztwo'];

		$xml .= tw_serializuj_zmiane($zmiana);
	}

	// Usuwanie z thw_zmiany_klienci jednorazowych, ktorzy nie maja zamowien (nie ma skad wziac danych)
	$idki_do_usuniecia_arr = array();
	$idki_do_usuniecia = tw_db_query("SELECT z.id_klienta AS id " .
		"FROM tw_zmiany_klienci z " .
		"LEFT JOIN " . TABLE_CUSTOMERS . " c ON c.customers_id = z.id_klienta " .
		// "LEFT JOIN (SELECT * FROM " . TABLE_ORDERS . " GROUP BY customers_id) o ON z.id_klienta = o.customers_id " .
		"LEFT JOIN " . TABLE_ORDERS . " o ON z.id_klienta = o.customers_id " .
		"WHERE c.customers_id IS NULL AND o.orders_id IS NULL " .
		"GROUP BY z.id_klienta");	
	while ($id_do_usuniecia = mysql_fetch_array($idki_do_usuniecia)) {
		$idki_do_usuniecia_arr[] = $id_do_usuniecia["id"];
	}	
	if (count($idki_do_usuniecia_arr) > 0)
		tw_db_query("DELETE FROM tw_zmiany_klienci WHERE id_klienta IN (" . implode(',', $idki_do_usuniecia_arr) . ")");
	
	return $xml;
}

function tw_serializuj_zamowienia() {
	$xml = '';
	
	$zamowienia = tw_db_query(
		"SELECT " .
		"z.typ_zmiany AS typ_zmiany, " .
		"z.id_zamowienia AS id, " .
		"o.customers_id AS klient_id, " .		
		"DATE_FORMAT(o.date_purchased,'%Y%m%d%H%i%s') AS data, " .		
		"o.delivery_name AS dost_nazwa, " .
		"o.delivery_company AS dost_firma, " .
		"o.delivery_street_address AS dost_adres, " .
		"o.delivery_city AS dost_miasto, " .
		"o.delivery_postcode AS dost_kod_poczt, " .
		"o.delivery_state AS dost_wojewodztwo, " .
		"o.delivery_country AS dost_panstwo, " .
		"o.billing_name AS zapl_nazwa, " .
		"o.billing_company AS zapl_firma, " .
		"o.billing_street_address AS zapl_adres, " .
		"o.billing_city AS zapl_miasto, " .
		"o.billing_postcode AS zapl_kod_poczt, " .
		"o.billing_state AS zapl_wojewodztwo, " .
		"o.billing_country AS zapl_panstwo, " .
		"w.title AS waluta_nazwa, " .	
		"o.payment_method AS zapl_typ, " .
		"o.currency AS waluta_symbol, " .
		"o.currency_value AS waluta_kurs , " .				
		"t2.value AS wysylka_cena, " .
		"t2.title AS wysylka_nazwa, " .
		// "h1.comments AS komentarz, " .
		"t1.value AS suma_zamowienia " .
		"FROM tw_zmiany_zamowienia z " .
		"JOIN " . TABLE_ORDERS . " o ON z.id_zamowienia = o.orders_id " .
		"JOIN " . TABLE_ORDERS_TOTAL . " t1 ON z.id_zamowienia = t1.orders_id AND t1.class = 'ot_total' " .
		"LEFT JOIN " . TABLE_ORDERS_TOTAL . " t2 ON z.id_zamowienia = t2.orders_id AND t2.class = 'ot_shipping' " .		
		// "LEFT JOIN (SELECT * FROM " . TABLE_CURRENCIES . " GROUP BY code) w ON o.currency = w.code" );		
		"LEFT JOIN " . TABLE_CURRENCIES . " w ON o.currency = w.code " .
		// "LEFT JOIN " . TABLE_ORDERS_STATUS_HISTORY . " h1 ON h1.orders_id = o.orders_id" .
		// "LEFT JOIN " . TABLE_ORDERS_STATUS_HISTORY . " h2 ON h2.orders_id = o.orders_id" .
		"GROUP BY z.id_zamowienia, w.code" );

	while ($zamowienie = mysql_fetch_array($zamowienia)) {
		$zmiana = new zmiana('zamowienie', $zamowienie['typ_zmiany'], $zamowienie['id']);				
			
		if ($zamowienie['waluta_kurs'] !== null) $waluta_kurs = (double)$zamowienie['waluta_kurs'];		
		if ($zamowienie['klient_id'] !== null) $zmiana->pola['klient'] = new pole_referencyjne('klient', $zamowienie['klient_id']);
		if ($zamowienie['data'] !== null) $zmiana->pola['data'] = $zamowienie['data'];
		if ($zamowienie['dost_nazwa'] !== null) $zmiana->pola['dost_nazwa'] = $zamowienie['dost_nazwa'];
		if ($zamowienie['dost_firma'] !== null) $zmiana->pola['dost_firma'] = $zamowienie['dost_firma'];
		if ($zamowienie['dost_adres'] !== null) $zmiana->pola['dost_adres'] = $zamowienie['dost_adres'];
		if ($zamowienie['dost_miasto'] !== null) $zmiana->pola['dost_miasto'] = $zamowienie['dost_miasto'];
		if ($zamowienie['dost_kod_poczt'] !== null) $zmiana->pola['dost_kod_poczt'] = $zamowienie['dost_kod_poczt'];
		if ($zamowienie['dost_wojewodztwo'] !== null) $zmiana->pola['dost_wojewodztwo'] = $zamowienie['dost_wojewodztwo'];
		if ($zamowienie['dost_panstwo'] !== null) $zmiana->pola['dost_panstwo'] = $zamowienie['dost_panstwo'];		
		if ($zamowienie['zapl_nazwa'] !== null) $zmiana->pola['zapl_nazwa'] = $zamowienie['zapl_nazwa'];
		if ($zamowienie['zapl_firma'] !== null) $zmiana->pola['zapl_firma'] = $zamowienie['zapl_firma'];
		if ($zamowienie['zapl_adres'] !== null) $zmiana->pola['zapl_adres'] = $zamowienie['zapl_adres'];
		if ($zamowienie['zapl_miasto'] !== null) $zmiana->pola['zapl_miasto'] = $zamowienie['zapl_miasto'];
		if ($zamowienie['zapl_kod_poczt'] !== null) $zmiana->pola['zapl_kod_poczt'] = $zamowienie['zapl_kod_poczt'];
		if ($zamowienie['zapl_wojewodztwo'] !== null) $zmiana->pola['zapl_wojewodztwo'] = $zamowienie['zapl_wojewodztwo'];
		if ($zamowienie['zapl_panstwo'] !== null) $zmiana->pola['zapl_panstwo'] = $zamowienie['zapl_panstwo'];
		if ($zamowienie['zapl_typ'] !== null) $zmiana->pola['zapl_typ'] = $zamowienie['zapl_typ'];
		if ($zamowienie['waluta_symbol'] !== null) $zmiana->pola['waluta_symbol'] = $zamowienie['waluta_symbol'];		
		if ($zamowienie['waluta_nazwa'] !== null) $zmiana->pola['waluta_nazwa'] = $zamowienie['waluta_nazwa'];
		if ($zamowienie['suma_zamowienia'] !== null) $zmiana->pola['suma'] = (double)$zamowienie['suma_zamowienia'] * $waluta_kurs;
		if ($zamowienie['wysylka_nazwa'] !== null) $zmiana->pola['wysylka_nazwa'] = $zamowienie['wysylka_nazwa']; else $zmiana->pola['wysylka_nazwa'] = "Wysy&#x142;ka nieznana";		
		
		// KOMENTARZ DO ZAMÓWIENIA
		$komentarze = tw_db_query(
			"SELECT comments AS komentarz " .
			"FROM " . TABLE_ORDERS_STATUS_HISTORY . " " .
			"WHERE orders_id = '" . $zamowienie['id'] . "' ORDER BY orders_status_history_id LIMIT 1");
			
		if ($komentarz = mysql_fetch_array($komentarze))
			if (!empty($komentarz['komentarz']))
				$zmiana->pola['komentarz'] = $komentarz['komentarz'];
				
		// CENA WYSYLKI - MOZE BYC DANA, ALBO MUSI ZOSTAC WYLICZONA NA PODSTAWIE ROZNICY W SUMIE ZAMOWIENIA
		if ($zamowienie['wysylka_cena'] !== null) $zmiana->pola['wysylka_cena'] = (double)($zamowienie['wysylka_cena'] * $waluta_kurs);
		else
		{
			// Wyliczanie ceny wysy³ki na podstawie ró¿nicy w sumie zamówienia, a
			// suma podsumy i dodatkowych uslug			
			$suma_pozostalych = mysql_fetch_array(tw_db_query(
				"SELECT SUM(value) AS suma FROM " . TABLE_ORDERS_TOTAL . " " .
				"WHERE orders_id = " . $zamowienie['id'] . " " .
				"AND class<>'ot_total' AND class<>'ot_tax'"));
			$zmiana->pola['wysylka_cena'] = (double)(($zamowienie['suma_zamowienia'] -
				$suma_pozostalych['suma']) * $waluta_kurs);		
		}

		$pozycje_zamowienia_sql =
			"SELECT " .
			"o.products_id AS towar_id, " .
			"o.products_quantity AS ilosc, " .
			"o.final_price AS c_netto, " .
			"o.products_tax AS podatek, " .			
			"t.tax_description AS podatek_nazwa, " .			
			"o.products_name AS nazwa, " .
			"p.products_price AS c_netto_bez_rabatu, " .
			"o.products_model AS model " .						
			"FROM " . TABLE_ORDERS_PRODUCTS . " o " .
			"LEFT JOIN " . TABLE_PRODUCTS . " p ON p.products_id = o.products_id " .			
			"LEFT JOIN " . TABLE_TAX_RATES . " t ON o.products_tax = t.tax_rate " .
			"LEFT JOIN " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " opa ON o.orders_products_id = opa.orders_products_id " .
			"WHERE o.orders_id = " . $zamowienie['id'] . " " .
			"GROUP BY o.products_id, o.products_price, o.final_price, t.tax_rate, opa.orders_products_attributes_id ";

		// dodawanie towarow do zamowienia
		$towary = tw_db_query($pozycje_zamowienia_sql);
		
		$pozycje_zamowienia = array();
		
		while ($towar = mysql_fetch_array($towary)) {
			$pozycja_zamowienia = array();
			
			if ($towar['ilosc'] !== null) $pozycja_zamowienia['ilosc'] = (int)$towar['ilosc'];
			if ($towar['model'] !== null) $pozycja_zamowienia['model'] = $towar['model'];
			if ($towar['nazwa'] !== null) $pozycja_zamowienia['nazwa'] = $towar['nazwa'];
			if ($towar['podatek'] !== null) $pozycja_zamowienia['podatek'] = (double)$towar['podatek'];			
			if ($towar['podatek_nazwa'] !== null) $pozycja_zamowienia['podatek_nazwa'] = $towar['podatek_nazwa'];
			if ($towar['c_netto'] !== null) $pozycja_zamowienia['c_netto_za_1'] = (double)($towar['c_netto'] * $waluta_kurs);			
			
			if ($towar['c_netto_bez_rabatu'] !== null && $towar['c_netto'] !== null)
				if ($towar['c_netto_bez_rabatu'] != $towar['c_netto'] && $towar['c_netto_bez_rabatu'] > 0)
					// przeliczanie rabatu				
					$pozycja_zamowienia['rabat_procent'] = (double)
						tw_przelicz_rabat($towar['c_netto_bez_rabatu'], $towar['c_netto']);			
			
			// dodawanie towaru do pozycji zamowienia
			$pozycje_zamowienia[] = new pozycja_mapy(
				new pole_referencyjne('towar', $towar['towar_id']), $pozycja_zamowienia);
		}
		
		$zmiana->pola['pozycje_zamowienia'] = $pozycje_zamowienia;
		
		// Dodawanie innych uslug (np. doplata za przelew pocztowy, ozdobne opakowanie)
		
		$uslugi = tw_db_query(
			"SELECT " .
			"title AS usluga_nazwa, " .
			"value AS usluga_cena, " .
			"class AS usluga_klasa " .
			"FROM " . TABLE_ORDERS_TOTAL . " " .
			"WHERE orders_id = " . $zamowienie['id'] . " AND class NOT IN ('ot_total', 'ot_tax', 'ot_subtotal', 'ot_shipping')");

		$inne_uslugi = array();
		
		while ($usluga = mysql_fetch_array($uslugi)) {
			$pozycja_uslugi = array();
			
			if ($usluga['usluga_nazwa'] !== null) $pozycja_uslugi['usluga_nazwa'] = $usluga['usluga_nazwa'];
			if ($usluga['usluga_klasa'] !== null) $pozycja_uslugi['usluga_klasa'] = $usluga['usluga_klasa'];
			if ($usluga['usluga_cena'] !== null) $pozycja_uslugi['usluga_cena'] = (double)($usluga['usluga_cena'] * $waluta_kurs);
		
			// Dodawanie uslugi do pozycji zamowienia
			$inne_uslugi[] = $pozycja_uslugi;
		}

		if (count($inne_uslugi) > 0)
			$zmiana->pola['inne_uslugi'] = $inne_uslugi;

		/*$xml .=*/ echo tw_serializuj_zmiane($zmiana);	flush();
	}
	
	/*return $xml;*/
}

tw_db_connect();

// czyszczenie tabeli tymczasowej
tw_db_query("DELETE FROM tw_temp_dodane_id");

// wykrywamy dodane
tw_db_query("INSERT INTO tw_temp_dodane_id(id) SELECT o.orders_id AS id FROM " .
	TABLE_ORDERS . " o LEFT OUTER JOIN tw_synchronizowane_zamowienia t ".
	"ON o.orders_id = t.id_zamowienia WHERE t.id_zamowienia IS NULL");

// dodajemy klientow, ktorzy zlozyli zamowienia jeszcze nie sa w tabeli zmian do wyslania
tw_db_query(
	"INSERT INTO tw_zmiany_klienci(id_klienta, typ_zmiany) " .
	"SELECT DISTINCT o.customers_id AS id, " . TW_TYPZMIANY_DODAWANIE_JESLI_NIE_ISTNIEJE . " " .
	"FROM " . TABLE_ORDERS . " o " .
	"LEFT OUTER JOIN tw_zmiany_klienci t ON t.id_klienta = o.customers_id " .
	"JOIN tw_temp_dodane_id tmp ON tmp.id = o.orders_id " . 
	"WHERE t.id_klienta IS NULL");

// dodajemy zamowienia do tablicy zmian (uwaga jak juz istnieje w tablicy zmian) 
tw_db_query(
	"INSERT INTO tw_zmiany_zamowienia(id_zamowienia, typ_zmiany) " .
	"SELECT id, " .	TW_TYPZMIANY_DODAWANIE . " " .
	"FROM tw_temp_dodane_id tmp " .
	"LEFT OUTER JOIN tw_zmiany_zamowienia z ON z.id_zamowienia = tmp.id WHERE z.id_zamowienia IS NULL");
	
	//"WHERE id NOT IN " .
	//"(SELECT id_zamowienia FROM " .
	//"tw_zmiany_zamowienia)");

// uaktualniamy tabele z dodanymi zamowieniami
tw_db_query("INSERT INTO tw_synchronizowane_zamowienia(id_zamowienia)" .
	" SELECT id FROM tw_temp_dodane_id");

// czyszczenie tabeli tymczasowej
tw_db_query("DELETE FROM tw_temp_dodane_id");

// wypisywanie zmian
//header('Content-Type: application/xml');

// tworzenie elementu root
echo "<zmiany>";

echo tw_serializuj_klientow();
echo '<!-- koniec klientow -->';
flush();

/*echo*/
// przy budowaniu xml-a ze wszystkimi zamówieniami w pamiêci by³ timeout, poniewa¿
// budowanie go trwa³o wiêcej ni¿ 10 sekund
// teraz w samym tw_serializuj_zamowienia pojedyncza zmiana wysy³ana jest
// zaraz po zbudowaniu 
tw_serializuj_zamowienia();

// zamkniecie elementu root
echo "</zmiany>";

?>