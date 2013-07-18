<?php
require_once 'epall.php';

// odbieranie potwierdzeñ

function ep2_callback(& $potw) {
	switch ($potw->typ_obiektu) {
		case 'zamowienie' :
			if ($potw->typ_zmiany == TW_TYPZMIANY_DODAWANIE) {
				switch ($potw->status) {
					case TW_STATUSPOTWIERDZENIA_ZAMOWIENIE_ISTNIEJE :
						// usuwanie zmiany
						tw_db_query("DELETE FROM tw_zmiany_zamowienia" .
						" WHERE typ_zmiany = " . $potw->typ_zmiany . " AND id_zamowienia = " . $potw->osc_id);

						break;

					case TW_STATUSPOTWIERDZENIA_OK :
						// usuwanie zmiany
						tw_db_query("DELETE FROM tw_zmiany_zamowienia" .
						" WHERE typ_zmiany = " . $potw->typ_zmiany . " AND id_zamowienia = " . $potw->osc_id);

						ustaw_status_zamowienia($potw->osc_id, 'dostarczono');
						break;

					case TW_STATUSPOTWIERDZENIA_OK_ZREALIZOWANO :
						// usun zmiane, ustaw stan zamowienia na zrealizowane						
						tw_db_query("DELETE FROM tw_zmiany_zamowienia" .
						" WHERE typ_zmiany = " . $potw->typ_zmiany . " AND id_zamowienia = " . $potw->osc_id);

						ustaw_status_zamowienia($potw->osc_id, 'zrealizowano');
						break;
					case TW_STATUSPOTWIERDZENIA_BLAD :
					case TW_STATUSPOTWIERDZENIA_BRAK_KURSU :
						// nic nie rob
						break;
				}
			}
			break;
		case 'klient' :
			if ($potw->typ_zmiany == TW_TYPZMIANY_DODAWANIE_JESLI_NIE_ISTNIEJE) {
				switch ($potw->status) {
					case TW_STATUSPOTWIERDZENIA_OK :
						tw_db_query("DELETE FROM tw_zmiany_klienci" .
						" WHERE typ_zmiany = " . $potw->typ_zmiany . " AND id_klienta = " . $potw->osc_id);
						break;
					case TW_STATUSPOTWIERDZENIA_BLAD :
						// nic nie rob
						break;
				}
			}
			break;

		case 'producent' :
			if ($potw->typ_zmiany == TW_TYPZMIANY_DODAWANIE_JESLI_NIE_ISTNIEJE && $potw->status == TW_STATUSPOTWIERDZENIA_OK && $potw->sub_id && $potw->osc_id) {
				$rs = tw_db_query('SELECT COUNT(*) cnt FROM tw_producent WHERE sub_kh_id = ' . (int) $potw->sub_id);
				$row = tw_db_fetch_array($rs);
				$jest = (bool) $row['cnt'];
				tw_db_free_result($rs);

				$nazwa_pliku = null;
				$hash_oryginalu = null;
				$rs = tw_db_query('SELECT manufacturers_image FROM ' . TABLE_MANUFACTURERS . ' WHERE manufacturers_id = ' . (int) $potw->osc_id);
				$row = tw_db_fetch_array($rs);
				tw_db_free_result($rs);
				if ($row && $row['manufacturers_image']) {
					$nazwa_pliku = $row['manufacturers_image'];
					$hash_oryginalu = @ md5_file(DIR_FS_CATALOG_IMAGES . $nazwa_pliku);
				}
				tw_db_perform('tw_producent', array (
					'sub_kh_id' => $potw->sub_id,
					'osc_manufacturers_id' => $potw->osc_id,
					'nazwa_pliku' => $nazwa_pliku,
					'hash_oryginalu' => $hash_oryginalu
				), $jest ? 'update' : 'insert', $jest ? 'sub_kh_id = ' . (int) $potw->sub_id : '');
			}
			break;

		case 'kategoria' :
			if ($potw->typ_zmiany == TW_TYPZMIANY_DODAWANIE_JESLI_NIE_ISTNIEJE && $potw->status == TW_STATUSPOTWIERDZENIA_OK && $potw->sub_id && $potw->osc_id) {
				$rs = tw_db_query('SELECT COUNT(*) cnt FROM tw_kategoria WHERE sub_okt_id = ' . (int) $potw->sub_id);
				$row = tw_db_fetch_array($rs);
				$jest = (bool) $row['cnt'];
				tw_db_free_result($rs);

				$nazwa_pliku = null;
				$hash_oryginalu = null;
				$rs = tw_db_query('SELECT categories_image FROM ' . TABLE_CATEGORIES . ' WHERE categories_id = ' . (int) $potw->osc_id);
				$row = tw_db_fetch_array($rs);
				tw_db_free_result($rs);
				if ($row && $row['categories_image']) {
					$nazwa_pliku = $row['categories_image'];
					$hash_oryginalu = @ md5_file(DIR_FS_CATALOG_IMAGES . $nazwa_pliku);
				}
				tw_db_perform('tw_kategoria', array (
					'sub_okt_id' => $potw->sub_id,
					'osc_categories_id' => $potw->osc_id,
					'nazwa_pliku' => $nazwa_pliku,
					'hash_oryginalu' => $hash_oryginalu
				), $jest ? 'update' : 'insert', $jest ? 'sub_okt_id = ' . (int) $potw->sub_id : '');
			}
			break;

		case 'towar' :
			if ($potw->typ_zmiany == TW_TYPZMIANY_DODAWANIE_JESLI_NIE_ISTNIEJE && $potw->status == TW_STATUSPOTWIERDZENIA_OK && $potw->sub_id && $potw->osc_id) {
				$rs = tw_db_query('SELECT COUNT(*) cnt FROM tw_towar WHERE sub_id = ' . (int) $potw->sub_id);
				$row = tw_db_fetch_array($rs);
				tw_db_free_result($rs);

				tw_db_perform('tw_towar', array (
					'sub_id' => $potw->sub_id,
					'osc_id' => $potw->osc_id
				), $row['cnt'] ? 'update' : 'insert', $row['cnt'] ? 'sub_id = ' . (int) $potw->sub_id : '');
			}
			break;
	}
}

$ds = new deserializer_potwierdzen('ep2_callback');
$ds->deserializuj($HTTP_RAW_POST_DATA);
$ds->free();

// wysy³anie potwierdzeñ
$rs = tw_db_query('SELECT potwierdzenie_id, typ_obiektu, typ_zmiany, sub_id, osc_id, status FROM tw_potwierdzenia ORDER BY potwierdzenie_id');

$wych = array ();
while ($row = tw_db_fetch_array($rs)) {
	$potw = new potwierdzenie($row['typ_obiektu'], $row['typ_zmiany'], $row['osc_id'], $row['sub_id'], $row['status']);
	$xml = tw_serializuj_potwierdzenie($potw);
	if (!isset ($wych[$xml]))
		$wych[$xml] = array (
			$row['potwierdzenie_id']
		);
	else
		$wych[$xml][] = $row['potwierdzenie_id'];
}

echo '<potwierdzenia>';
foreach ($wych as $k => $v) {
	echo $k;
	tw_db_query('DELETE FROM tw_potwierdzenia WHERE potwierdzenie_id IN (' . implode(',', $v) . ')');
}
echo '</potwierdzenia>';
?>