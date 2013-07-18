<?php
/*
  $Id: products_multi.php, v 2.0

  autor: sr, 2003-07-31 / sr@ibis-project.de

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Menedżer Produktów');
define('HEADING_TITLE_SEARCH', 'Szukaj:');
define('HEADING_TITLE_GOTO', 'Przejdź do:');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_CHOOSE', 'Wybór');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Kategorie / Produkty');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Model');
define('TABLE_HEADING_ACTION', 'Akcja');
define('TABLE_HEADING_STATUS', 'Status');

define('DEL_DELETE', 'usuń produkt');
define('DEL_CHOOSE_DELETE_ART', 'Jak usuwać?');
define('DEL_THIS_CAT', 'tylko w tej kategorii');
define('DEL_COMPLETE', 'całkowite usunięcie produktu');

define('TEXT_NEW_PRODUCT', 'Nowy produkt w  &quot;%s&quot;');
define('TEXT_CATEGORIES', 'Kategorie:');
define('TEXT_ATTENTION_DANGER', '<br><br><span class="dataTableContentRedAlert">!!! Uwaga !!! przeczytaj to !!!</span><br><br><span class="dataTableContentRed">To narzędzie wykonuje operacje na tablicy przyporządkowującej produkty do kategorii (w przypadku wybrania opcji całkowitego usunięcia produktu również na tablicach produktów i opisu produktów) - w związku z tym przed wykonywaniem operacji zaleca się wykonanie backupu bazy.<br><br><span class="dataTableContentRedAlert">Pamiętaj:</span><ul><li>Zastanów się zanim wybierzesz opcję <strong>\'całkowitego usunięcia produktu\'</strong>. Funkcja ta usuwa wszystkie zaznaczone produkty ze wszystkich tablic w których są one zapisane.</li><li>Jeżeli wybierzesz opcję <strong>\'usuń produkt w wybranej kategorii\'</strong>, wówczas produkt nie zostanie całkowicie usunięty. Usunięty zostanie tylko link do aktualnie wybranej kategorii.</li><li>Opcja <strong>kopiowanie</strong>, produktów nie powoduje duplikowania produktu w bazie. Tworzy tylko link do nowo wybranej kategorii.</li></ul>');
define('TEXT_MOVE_TO', 'Przenieś do');
define('TEXT_CHOOSE_ALL', 'wybierz wszystko');
define('TEXT_CHOOSE_ALL_REMOVE', 'usuń zaznaczenie');
define('TEXT_SUBCATEGORIES', 'Podkategorie:');
define('TEXT_PRODUCTS', 'Produkty:');
define('TEXT_PRODUCTS_PRICE_INFO', 'Cena:');
define('TEXT_PRODUCTS_TAX_CLASS', 'Podatek:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'Average Rating:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Ilość:');
define('TEXT_DATE_ADDED', 'Data dodania:');
define('TEXT_DATE_AVAILABLE', 'Data dostępności:');
define('TEXT_LAST_MODIFIED', 'Ostatnia modyfikacja:');
define('TEXT_IMAGE_NONEXISTENT', 'IMAGE DOES NOT EXIST');

define('LINK_TO', 'Utwórz link');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Error: Can not link products in the same category.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Error: Catalog images directory is not writeable: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Error: Catalog images directory does not exist: ' . DIR_FS_CATALOG_IMAGES);
?>