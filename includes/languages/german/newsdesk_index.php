<?php
define('NEWS_TEXT_FIELD_REQUIRED', 'Setzen Sie Text Ein');
define('NEWS_BOX_CATEGORIES_CHOOSE', 'Setzen Sie Kategorie Ein');
if ( ($category_depth == 'products') ) {
define('HEADING_TITLE', 'Nachrichten Artikel');
define('TABLE_HEADING_IMAGE', 'Bild');
define('TABLE_HEADING_ARTICLE_NAME', 'Schlagzeile');
define('TABLE_HEADING_ARTICLE_SHORTTEXT', 'Zusammenfassung');
define('TABLE_HEADING_ARTICLE_DESCRIPTION', 'Inhalt');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_DATE_AVAILABLE', 'Datum');
define('TABLE_HEADING_ARTRICLE_URL', 'URL zum äußeren Hilfsmittel');
define('TABLE_HEADING_ARTRICLE_URL_NAME', 'URL Name');
define('TEXT_NO_ARTICLES', 'Es gibt keine Nachrichten Artikel in dieser Kategorie.');
define('TEXT_NUMBER_OF_ARTICLES', 'Zahl der Artikel: ');
define('TEXT_SHOW', '<b>Zeigen:</b>');
} elseif ($category_depth == 'top') {
define('HEADING_TITLE', 'Was hier neu ist?');
} elseif ($category_depth == 'nested') {
define('HEADING_TITLE', 'Nachrichten Artikel Kategorien');
}
?>