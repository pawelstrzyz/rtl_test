<?php
// /catalog/includes/languages/english/header_tags.php
// WebMakers.com Added: Header Tags Generator v2.5.2
// Add META TAGS and Modify TITLE
//
// DEFINITIONS FOR /includes/languages/english/header_tags.php

// Define your email address to appear on all pages
define('HEAD_REPLY_TAG_ALL',STORE_OWNER_EMAIL_ADDRESS);

// For all pages not defined or left blank, and for products not defined
// These are included unless you set the toggle switch in each section below to OFF ( '0' )
// The HEAD_TITLE_TAG_ALL is included AFTER the specific one for the page
// The HEAD_DESC_TAG_ALL is included AFTER the specific one for the page
// The HEAD_KEY_TAG_ALL is included AFTER the specific one for the page
define('HEAD_TITLE_TAG_ALL','Shop Name');
define('HEAD_DESC_TAG_ALL','Description');
define('HEAD_KEY_TAG_ALL','Keywords');

// DEFINE TAGS FOR INDIVIDUAL PAGES
// allprods.php
define('HTTA_ALLPRODS_ON','0');
define('HTKA_ALLPRODS_ON','1');
define('HTDA_ALLPRODS_ON','1');
define('HEAD_TITLE_TAG_ALLPRODS','Products Catalog');
define('HEAD_DESC_TAG_ALLPRODS','');
define('HEAD_KEY_TAG_ALLPRODS','');

// index.php
define('HTTA_DEFAULT_ON','1'); // Include HEAD_TITLE_TAG_ALL in Title
define('HTKA_DEFAULT_ON','0'); // Include HEAD_KEY_TAG_ALL in Keywords
define('HTDA_DEFAULT_ON','0'); // Include HEAD_DESC_TAG_ALL in Description
define('HTTA_CAT_DEFAULT_ON', '1'); //Include HEADE_TITLE_DEFAULT in CATEGORY DISPLAY
define('HEAD_TITLE_TAG_DEFAULT', '');
define('HEAD_DESC_TAG_DEFAULT','Description');
define('HEAD_KEY_TAG_DEFAULT','Keywords');

// product_info.php - if left blank in products_description table these values will be used
define('HTTA_PRODUCT_INFO_ON','0');
define('HTKA_PRODUCT_INFO_ON','0');
define('HTDA_PRODUCT_INFO_ON','0');
define('HTTA_CAT_PRODUCT_DEFAULT_ON', '0');
define('HTPA_DEFAULT_ON', '0');
define('HEAD_TITLE_TAG_PRODUCT_INFO','');
define('HEAD_DESC_TAG_PRODUCT_INFO','');
define('HEAD_KEY_TAG_PRODUCT_INFO','');

// products_new.php - whats_new
define('HTTA_WHATS_NEW_ON','1');
define('HTKA_WHATS_NEW_ON','1');
define('HTDA_WHATS_NEW_ON','1');
define('HEAD_TITLE_TAG_WHATS_NEW','New Products');
define('HEAD_DESC_TAG_WHATS_NEW','');
define('HEAD_KEY_TAG_WHATS_NEW','');

// specials.php
// If HEAD_KEY_TAG_SPECIALS is left blank, it will build the keywords from the products_names of all products on special
define('HTTA_SPECIALS_ON','1');
define('HTKA_SPECIALS_ON','1');
define('HTDA_SPECIALS_ON','1');
define('HEAD_TITLE_TAG_SPECIALS','Specials');
define('HEAD_DESC_TAG_SPECIALS','');
define('HEAD_KEY_TAG_SPECIALS','');

// product_reviews_info.php and product_reviews.php - if left blank in products_description table these values will be used
define('HTTA_PRODUCT_REVIEWS_INFO_ON','0');
define('HTKA_PRODUCT_REVIEWS_INFO_ON','1');
define('HTDA_PRODUCT_REVIEWS_INFO_ON','1');
define('HEAD_TITLE_TAG_PRODUCT_REVIEWS_INFO','Reviews');
define('HEAD_DESC_TAG_PRODUCT_REVIEWS_INFO','');
define('HEAD_KEY_TAG_PRODUCT_REVIEWS_INFO','');

// product_reviews_write.php
define('HTTA_PRODUCT_REVIEWS_WRITE_ON','0');
define('HTKA_PRODUCT_REVIEWS_WRITE_ON','1');
define('HTDA_PRODUCT_REVIEWS_WRITE_ON','1');
define('HEAD_TITLE_TAG_PRODUCT_REVIEWS_WRITE','Write Review');
define('HEAD_DESC_TAG_PRODUCT_REVIEWS_WRITE','');
define('HEAD_KEY_TAG_PRODUCT_REVIEWS_WRITE','');
?>