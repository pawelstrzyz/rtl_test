<?php
define('TEXT_MAIN', 'Dies ist eine Standardinstallation von eSklep-Os. Alle hier gezeigten Produkte sind fiktiv zu verstehen. <b>Eine hier getätigte Bestellung wird NICHT ausgeführt werden, Sie erhalten keine Lieferung oder Rechnung.</b>');
define('TABLE_HEADING_NEW_PRODUCTS', 'NEUE PRODUKTE UND HIGHLIGHTS');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Wann ist was verfügbar');
define('TABLE_HEADING_DATE_EXPECTED', 'Datum');
define('TABLE_HEADING_FEATURED_PRODUCTS', 'Neue Produkte und Highlight`s');
define('TABLE_HEADING_FEATURED_PRODUCTS_CATEGORY', 'Neue Produkte und Hightlight`s in %s');
define('CAT_HEADING_TITLE', 'Kategorien');
define('BOTH_HEADING_TITLE', 'Unser Angebot');
if ( ($category_depth == 'products') || ($category_depth == 'both') || (isset($_GET['manufacturers_id'])) ) {
  define('HEADING_TITLE', 'Unser Angebot');
  define('TABLE_HEADING_IMAGE', '');
  define('TABLE_HEADING_MODEL', 'Artikel-Nr.');
  define('TABLE_HEADING_PRODUCTS', 'Produkte');
  define('TABLE_HEADING_MANUFACTURER', 'Hersteller');
  define('TABLE_HEADING_QUANTITY', 'Anzahl');
  define('TABLE_HEADING_PRICE', 'Preis');
  define('TABLE_HEADING_WEIGHT', 'Gewicht');
  define('TABLE_HEADING_BUY_NOW', 'Bestellen');
  define('TEXT_NO_PRODUCTS', 'Es gibt keine Produkte in dieser Kategorie.');
  define('TEXT_NO_PRODUCTS2', 'Es gibt kein Produkt, das von diesem Hersteller stammt.');
  define('TEXT_NUMBER_OF_PRODUCTS', 'Artikel: ');
  define('TEXT_SHOW', '<b>Darstellen:</b>');
  define('TEXT_BUY', '1 x \'');
  define('TEXT_NOW', '\' bestellen!');
  define('TEXT_ALL_CATEGORIES', 'Alle Kategorien');
  define('TEXT_ALL_MANUFACTURERS', 'Alle Hersteller');
} elseif ($category_depth == 'top') {
  define('HEADING_TITLE', 'Unser Angebot');
} elseif ($category_depth == 'nested') {
  define('HEADING_TITLE', 'Kategorien');
}
//MAXIMUM quantity code
  define('TABLE_HEADING_MAXORDER', 'MAXIMUM order q.ty');
//End MAXIMUM quantity code
?>