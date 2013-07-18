<?php
/*
  $Id: database_tables.php 167 2008-03-14 10:24:13Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

//Admin begin
  define('TABLE_ADMIN', 'admin');
  define('TABLE_ADMIN_FILES', 'admin_files');
  define('TABLE_ADMIN_GROUPS', 'admin_groups');
  //Mett
  define('TABLE_ADMIN_ACCESS_FILES', 'admin_access_files');
  //end Mett
//Admin end

// define the database table names used in the project
  define('TABLE_ADDRESS_BOOK', 'address_book');
  define('TABLE_ADDRESS_FORMAT', 'address_format');
  define('TABLE_BANNERS', 'banners');
  define('TABLE_BANNERS_HISTORY', 'banners_history');
  define('TABLE_CATEGORIES', 'categories');
  define('TABLE_PRODUCTS_AVAILABILITY', 'products_availability');
  define('TABLE_CATEGORIES_DESCRIPTION', 'categories_description');
  define('TABLE_CONFIGURATION', 'configuration');
  define('TABLE_CONFIGURATION_GROUP', 'configuration_group');
  define('TABLE_COUNTRIES', 'countries');
  define('TABLE_CURRENCIES', 'currencies');
  define('TABLE_CUSTOMERS', 'customers');
  define('TABLE_CUSTOMERS_BASKET', 'customers_basket');
  define('TABLE_CUSTOMERS_BASKET_ATTRIBUTES', 'customers_basket_attributes');
  define('TABLE_CUSTOMERS_INFO', 'customers_info');
  define('TABLE_LANGUAGES', 'languages');
  define('TABLE_MANUFACTURERS', 'manufacturers');
  define('TABLE_MANUFACTURERS_INFO', 'manufacturers_info');
  define('TABLE_NEWSLETTERS', 'newsletters');
  define('TABLE_ORDERS', 'orders');
  define('TABLE_ORDERS_PRODUCTS', 'orders_products');
  define('TABLE_ORDERS_PRODUCTS_ATTRIBUTES', 'orders_products_attributes');
  define('TABLE_ORDERS_PRODUCTS_DOWNLOAD', 'orders_products_download');
  define('TABLE_ORDERS_STATUS', 'orders_status');
  define('TABLE_ORDERS_STATUS_HISTORY', 'orders_status_history');
  define('TABLE_ORDERS_TOTAL', 'orders_total');
  define('TABLE_PRODUCTS', 'products');
  define('TABLE_PRODUCTS_ATTRIBUTES', 'products_attributes');
  define('TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD', 'products_attributes_download');
  define('TABLE_PRODUCTS_DESCRIPTION', 'products_description');
  define('TABLE_PRODUCTS_NOTIFICATIONS', 'products_notifications');
  define('TABLE_PRODUCTS_OPTIONS', 'products_options');
  define('TABLE_PRODUCTS_OPTIONS_VALUES', 'products_options_values');
  define('TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS', 'products_options_values_to_products_options');
  define('TABLE_PRODUCTS_TO_CATEGORIES', 'products_to_categories');
  define('TABLE_REVIEWS', 'reviews');
  define('TABLE_REVIEWS_DESCRIPTION', 'reviews_description');
  define('TABLE_SESSIONS', 'sessions');
  define('TABLE_SPECIALS', 'specials');
  define('TABLE_TAX_CLASS', 'tax_class');
  define('TABLE_TAX_RATES', 'tax_rates');
  define('TABLE_GEO_ZONES', 'geo_zones');
  define('TABLE_ZONES_TO_GEO_ZONES', 'zones_to_geo_zones');
  define('TABLE_WHOS_ONLINE', 'whos_online');
  define('TABLE_ZONES', 'zones');
  //Star Products Start
  define('TABLE_STAR_PRODUCT', 'star_product');
  //Star Products End

  // START: Product Extra Fields
  define('TABLE_PRODUCTS_EXTRA_FIELDS', 'products_extra_fields');
  define('TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS', 'products_to_products_extra_fields');
  // END: Product Extra Fields

  // START: Extra Infopages Manager
  define('TABLE_PAGES', 'pages');
  define('TABLE_PAGES_DESCRIPTION', 'pages_description');
  // END: Extra Infopages Manager

  // START: Visitors Stat
  define('TABLE_VISITORS', 'visitors');
  define('TABLE_VISITORS_TRACE', 'visitors_trace');
  // END: Visitors Stat

  //TotalB2B start
  define('TABLE_CUSTOMERS_GROUPS', 'customers_groups');
  define('TABLE_MANUDISCOUNT', 'manudiscount');
  //TotalB2B end

  //additional images
  define('TABLE_ADDITIONAL_IMAGES', 'additional_images');
  //additional images

  //DANIEL: begin
  define('TABLE_PRODUCTS_OPTIONS_PRODUCTS', 'products_options_products');
  //DANIEL: end

// Begin newsdesk
define('TABLE_NEWSDESK', 'newsdesk');
define('TABLE_NEWSDESK_DESCRIPTION', 'newsdesk_description');
define('TABLE_NEWSDESK_TO_CATEGORIES', 'newsdesk_to_categories');
define('TABLE_NEWSDESK_CATEGORIES', 'newsdesk_categories');
define('TABLE_NEWSDESK_CATEGORIES_DESCRIPTION', 'newsdesk_categories_description');
define('TABLE_NEWSDESK_CONFIGURATION', 'newsdesk_configuration');
define('TABLE_NEWSDESK_CONFIGURATION_GROUP', 'newsdesk_configuration_group');
define('TABLE_NEWSDESK_REVIEWS', 'newsdesk_reviews');
define('TABLE_NEWSDESK_REVIEWS_DESCRIPTION', 'newsdesk_reviews_description');
// End newsdesk

//Featured Products BOF
define('TABLE_FEATURED', 'featured');
//Featured Products EOF

// ################# Contribution Newsletter v050 ##############
define('TABLE_SUBSCRIBERS', 'subscribers');
define('TABLE_SUBSCRIBERS_DEFAULT', 'subscribers_default');		
define('TABLE_SUBSCRIBERS_UPDATE', 'subscribers_update');	
define('TABLE_SUBSCRIBERS_INFOS', 'subscribers_infos');	
define('TABLE_POPUP_HELP', 'popup_help');
// ################# END - Contribution Newsletter v050 ##############

  // ship2pay
  define('TABLE_SHIP2PAY','ship2pay');
 
  // Database Optimization
  define('TABLE_OPTIMIZE_CHECK', 'optimize_check');

//kgt - discount coupons
  define('TABLE_DISCOUNT_COUPONS', 'discount_coupons');
  define('TABLE_DISCOUNT_COUPONS_TO_ORDERS', 'discount_coupons_to_orders');
  define('TABLE_DISCOUNT_COUPONS_TO_CATEGORIES', 'discount_coupons_to_categories');
  define('TABLE_DISCOUNT_COUPONS_TO_PRODUCTS', 'discount_coupons_to_products');
  define('TABLE_DISCOUNT_COUPONS_TO_MANUFACTURERS', 'discount_coupons_to_manufacturers');
  define('TABLE_DISCOUNT_COUPONS_TO_CUSTOMERS', 'discount_coupons_to_customers');
  define('TABLE_DISCOUNT_COUPONS_TO_ZONES', 'discount_coupons_to_zones');
   //end kgt - discount coupons

   //++++ QT Pro: Begin Changed code
  define('TABLE_PRODUCTS_STOCK', 'products_stock');
//++++ QT Pro: End Changed Code

//FAQ 2.0
  define('TABLE_FAQ', 'faq');
  define('TABLE_FAQ_DESCRIPTION', 'faq_description');

// infoBox Admin
define('TABLE_THEME_CONFIGURATION', 'theme_configuration');

define('TABLE_PRODUCTS_JM', 'products_jm');

  define('TABLE_PRODUCTS_SHIPPING', 'products_shipping');
?>