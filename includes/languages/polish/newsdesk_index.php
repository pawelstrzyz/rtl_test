<?php
define('NEWS_TEXT_FIELD_REQUIRED', 'Wprowadź tekst');
define('NEWS_BOX_CATEGORIES_CHOOSE', 'Wybierz kategorię');
if ( ($category_depth == 'products') ) {
define('HEADING_TITLE', 'Aktualności');
define('TABLE_HEADING_IMAGE', 'Obrazek');
define('TABLE_HEADING_ARTICLE_NAME', 'Tytuł');
define('TABLE_HEADING_ARTICLE_SHORTTEXT', 'Wstęp');
define('TABLE_HEADING_ARTICLE_DESCRIPTION', 'Treść');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_DATE_AVAILABLE', 'Data');
define('TABLE_HEADING_ARTRICLE_URL', 'Zewnętrzny link');
define('TABLE_HEADING_ARTRICLE_URL_NAME', 'Adres');
define('TEXT_NO_ARTICLES', 'Aktualnie brak artykułów w wybranej kategorii.');
define('TEXT_NUMBER_OF_ARTICLES', 'Ilość artykułów: ');
define('TEXT_SHOW', '<b>wyświetlono :</b>');
} elseif ($category_depth == 'top') {
define('HEADING_TITLE', 'Aktualności');
} elseif ($category_depth == 'nested') {
define('HEADING_TITLE', 'Aktualności - kategorie');
} else {
define('HEADING_TITLE', 'Aktualności');
}
?>