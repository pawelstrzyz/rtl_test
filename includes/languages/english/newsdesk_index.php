<?php
define('NEWS_TEXT_FIELD_REQUIRED', 'Please enter the required text');
define('NEWS_BOX_CATEGORIES_CHOOSE', 'Choose a category');
if ( ($category_depth == 'products') ) {
define('HEADING_TITLE', 'News Articles');
define('TABLE_HEADING_IMAGE', 'Image');
define('TABLE_HEADING_ARTICLE_NAME', 'Headline');
define('TABLE_HEADING_ARTICLE_SHORTTEXT', 'Summary');
define('TABLE_HEADING_ARTICLE_DESCRIPTION', 'Content');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_DATE_AVAILABLE', 'Date');
define('TABLE_HEADING_ARTRICLE_URL', 'URL to outside resource');
define('TABLE_HEADING_ARTRICLE_URL_NAME', 'URL Name');
define('TEXT_NO_ARTICLES', 'There are no news articles in this category.');
define('TEXT_NUMBER_OF_ARTICLES', 'Number of Articles: ');
define('TEXT_SHOW', '<b>Show:</b>');
} elseif ($category_depth == 'top') {
define('HEADING_TITLE', 'What\'s New Here?');
} elseif ($category_depth == 'nested') {
define('HEADING_TITLE', 'News Article Categories');
} else {
define('HEADING_TITLE', 'News Article');
}
?>