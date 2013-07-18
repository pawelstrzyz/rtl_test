<?php
define('TEXT_MAIN', 'To jest prezentacja sklepu internetowego, <b>żaden z zamówionych produktów nie będzie dostarczony czy zafakturowany</b>. Wszystkie informacje jakie widzisz w opisach produktów są fikcyjne.<br>PRAWDZIWY SKLEP W PRZYGOTOWANIU !');
define('TABLE_HEADING_NEW_PRODUCTS', '%s - Nowe produkty');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Wkrótce w naszej ofercie ...');
define('TABLE_HEADING_DATE_EXPECTED', 'Data dostępności');
define('TABLE_HEADING_FEATURED_PRODUCTS', 'Polecane produkty');
define('TABLE_HEADING_FEATURED_PRODUCTS_CATEGORY', 'Polecane produkty w kategorii %s');
define('CAT_HEADING_TITLE', 'Podkategorie');
define('BOTH_HEADING_TITLE', 'Znalezione produkty');
if ( ($category_depth == 'products') || ($category_depth == 'both') || (isset($_GET['manufacturers_id'])) ) {
  define('HEADING_TITLE', 'Znalezione produkty');
  define('TABLE_HEADING_IMAGE', 'Foto');
  define('TABLE_HEADING_MODEL', 'Model');
  define('TABLE_HEADING_PRODUCTS', 'Nazwa');
  define('TABLE_HEADING_MANUFACTURER', 'Producent');
  define('TABLE_HEADING_QUANTITY', 'Ilość');
  define('TABLE_HEADING_PRICE', 'Cena');
  define('TABLE_HEADING_WEIGHT', 'Waga');
  define('TABLE_HEADING_BUY_NOW', 'Do koszyka');
  define('TEXT_NO_PRODUCTS', 'Brak produktów w tej kategorii.');
  define('TEXT_NO_PRODUCTS2', 'Brak produktów tego producenta.');
  define('TEXT_NUMBER_OF_PRODUCTS', 'Ilość produktów: ');
  define('TEXT_SHOW', '<b>Pokaż:</b>');
  define('TEXT_BUY', 'Kup 1 \'');
  define('TEXT_NOW', '\' teraz');
  define('TEXT_ALL_CATEGORIES', 'Wszystkie kategorie');
  define('TEXT_ALL_MANUFACTURERS', 'Wszyscy producenci');
} elseif ($category_depth == 'top') {
  define('HEADING_TITLE', '<h1>Meble z Rattanu - Sklep internetowy. Zapraszamy!</h1>');
} elseif ($category_depth == 'nested') {
  define('HEADING_TITLE', 'Kategorie');
}
//MAXIMUM quantity code
  define('TABLE_HEADING_MAXORDER', 'MAX ilość');
//End MAXIMUM quantity code
?>