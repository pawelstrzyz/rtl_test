<?php
define('NEWS_TEXT_FIELD_REQUIRED', 'Пожалуйста впишите требуемый текст');
define('NEWS_BOX_CATEGORIES_CHOOSE', 'Выберите категорию');
if ( ($category_depth == 'products') ) {
define('HEADING_TITLE', 'Статьи Весточки');
define('TABLE_HEADING_IMAGE', 'Изображение');
define('TABLE_HEADING_ARTICLE_NAME', 'Headline');
define('TABLE_HEADING_ARTICLE_SHORTTEXT', 'Сводка');
define('TABLE_HEADING_ARTICLE_DESCRIPTION', 'Содержание');
define('TABLE_HEADING_STATUS', 'Состояние');
define('TABLE_HEADING_DATE_AVAILABLE', 'Дата');
define('TABLE_HEADING_ARTRICLE_URL', 'URL к внешнему ресурсу');
define('TABLE_HEADING_ARTRICLE_URL_NAME', 'URL Имя');
define('TEXT_NO_ARTICLES', 'Не будут статьей весточки в этой категории.');
define('TEXT_NUMBER_OF_ARTICLES', 'Количество статьей: ');
define('TEXT_SHOW', '<b>Выставка:</b>');
} elseif ($category_depth == 'top') {
define('HEADING_TITLE', 'Ново Здесь?');
} elseif ($category_depth == 'nested') {
define('HEADING_TITLE', 'Категории Статьи Весточки');
}
?>