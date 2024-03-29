<?php
/*
  $Id: english.php 172 2008-03-21 22:47:23Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

*/

// look in your $PATH_LOCALE/locale directory for available locales
// or type locale -a on the server.
// Examples:
// on RedHat try 'en_US'
// on FreeBSD try 'en_US.ISO_8859-1'
// on Windows try 'en', or 'English'
@setlocale(LC_TIME, 'en_US.ISO_8859-1');

define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'GBP');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="LTR" lang="en"');

// charset for web pages and emails
define('CHARSET', 'utf-8');

// page title
define('TITLE', 'eSklep-Os');

// header text in includes/header.php
define('HEADER_TITLE_CREATE_ACCOUNT', 'Create an Account');
define('HEADER_TITLE_MY_ACCOUNT', 'My Account');
define('HEADER_TITLE_CART_CONTENTS', 'Cart Contents');
define('HEADER_TITLE_CHECKOUT', 'Checkout');
define('HEADER_TITLE_TOP', 'Top');
define('HEADER_TITLE_CATALOG', 'Catalog');
define('HEADER_TITLE_LOGOFF', 'Log Off');
define('HEADER_TITLE_LOGIN', 'Log In');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'requests since');

// text for gender
define('MALE', 'Male');
define('FEMALE', 'Female');
define('MALE_ADDRESS', 'Mr.');
define('FEMALE_ADDRESS', 'Ms.');

// text for date of birth example
define('DOB_FORMAT_STRING', 'mm/dd/yyyy');

// categories box text in includes/boxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Categories');

// manufacturers box text in includes/boxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Manufacturers');

// whats_new box text in includes/boxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'What\'s New?');

// quick_find box text in includes/boxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Quick Find');
define('BOX_SEARCH_TEXT', 'Use keywords to find the product you are looking for.');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Advanced Search');

// specials box text in includes/boxes/specials.php
define('BOX_HEADING_SPECIALS', 'Specials');

// reviews box text in includes/boxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Reviews');
define('BOX_REVIEWS_WRITE_REVIEW', 'Write a review on this product!');
define('BOX_REVIEWS_NO_REVIEWS', 'There are currently no product reviews');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s of 5 Stars!');

// shopping_cart box text in includes/boxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Shopping Cart');
define('BOX_SHOPPING_CART_EMPTY', '0 items');

// order_history box text in includes/boxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Order History');

// best_sellers box text in includes/boxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Bestseller');
define('BOX_HEADING_BESTSELLERS_IN', 'Bestseller in<br>&nbsp;&nbsp;');

// notifications box text in includes/boxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Notifications');
define('BOX_NOTIFICATIONS_NOTIFY', 'Notify me of updates to <b>%s</b>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Do not notify me of updates to <b>%s</b>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Manufacturer Info');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Other products');

// languages box text in includes/boxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Language');

// currencies box text in includes/boxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Currencies');

// information box text in includes/boxes/information.php
define('BOX_HEADING_INFORMATION', 'Information');
define('BOX_INFORMATION_PRIVACY', 'Privacy Notice');
define('BOX_INFORMATION_CONDITIONS', 'Conditions of Use');
define('BOX_INFORMATION_SHIPPING', 'Shipping & Returns');
define('BOX_INFORMATION_CONTACT', 'Contact Us');

// tell a friend box text in includes/boxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Tell A Friend');
define('BOX_TELL_A_FRIEND_TEXT', 'Tell someone you know about this product.');

// checkout procedure text
define('CHECKOUT_BAR_DELIVERY', 'Delivery Information');
define('CHECKOUT_BAR_PAYMENT', 'Payment Information');
define('CHECKOUT_BAR_CONFIRMATION', 'Confirmation');
define('CHECKOUT_BAR_FINISHED', 'Finished!');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Please Select');
define('TYPE_BELOW', 'Type Below');

// javascript messages
define('JS_ERROR', 'Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n');

define('JS_REVIEW_TEXT', '* The \'Review Text\' must have at least ' . REVIEW_TEXT_MIN_LENGTH . ' characters.\n');
define('JS_REVIEW_RATING', '* You must rate the product for your review.\n');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Please select a payment method for your order.\n');

define('JS_ERROR_SUBMITTED', 'This form has already been submitted. Please press Ok and wait for this process to be completed.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Please select a payment method for your order.');

define('CATEGORY_COMPANY', 'Company Details');
define('CATEGORY_PERSONAL', 'Your Personal Details');
define('CATEGORY_ADDRESS', 'Your Address');
define('CATEGORY_CONTACT', 'Your Contact Information');
define('CATEGORY_OPTIONS', 'Options');
define('CATEGORY_PASSWORD', 'Your Password');

define('ENTRY_COMPANY', 'Company Name:');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');

define('ENTRY_NIP', 'Numer NIP:');
define('ENTRY_NIP_ERROR', '');
define('ENTRY_NIP_TEXT', '');

define('ENTRY_GENDER', 'Gender:');
define('ENTRY_GENDER_ERROR', 'Please select your Gender.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'First Name:');
define('ENTRY_FIRST_NAME_ERROR', 'Your First Name must contain a minimum of ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' characters.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Last Name:');
define('ENTRY_LAST_NAME_ERROR', 'Your Last Name must contain a minimum of ' . ENTRY_LAST_NAME_MIN_LENGTH . ' characters.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Date of Birth:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Date of Birth error');
define('ENTRY_EMAIL_ADDRESS', 'Email:');
define('ENTRY_EMAIL_ADDRESS_CONFIRM', 'Confirm Email:');
define('ENTRY_EMAIL_ADDRESS_CONFIRM_NOT_MATCHING', 'The Confirmation Email must match your Email Address.');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Your E-Mail Address must contain a minimum of ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' characters.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Your E-Mail Address does not appear to be valid - please make any necessary corrections.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Your E-Mail Address already exists in our records - please log in with the e-mail address or create an account with a different address.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Street Address:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Your Street Address must contain a minimum of ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' characters.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Suburb:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Post Code:');
define('ENTRY_POST_CODE_ERROR', 'Your Post Code must contain a minimum of ' . ENTRY_POSTCODE_MIN_LENGTH . ' characters.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'City:');
define('ENTRY_CITY_ERROR', 'Your City must contain a minimum of ' . ENTRY_CITY_MIN_LENGTH . ' characters.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'State/Province:');
define('ENTRY_STATE_ERROR', 'Your State must contain a minimum of ' . ENTRY_STATE_MIN_LENGTH . ' characters.');
define('ENTRY_STATE_ERROR_SELECT', 'Please select a state from the States pull down menu.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Country:');
define('ENTRY_COUNTRY_ERROR', 'You must select a country from the Countries pull down menu.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Telephone Number:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Your Telephone Number must contain a minimum of ' . ENTRY_TELEPHONE_MIN_LENGTH . ' characters.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Fax Number:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Newsletter:');
define('ENTRY_NEWSLETTER_OPIS', '(A notice of departure is at any time possible)');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Subscribed');
define('ENTRY_NEWSLETTER_NO', 'Unsubscribed');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Password:');
define('ENTRY_PASSWORD_ERROR', 'Your Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'The Password Confirmation must match your Password.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', 'Password Confirmation:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Current Password:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Your Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW', 'New Password:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Your new Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'The Password Confirmation must match your new Password.');
define('PASSWORD_HIDDEN', '--HIDDEN--');
// BOC added for Account Agreement
define('ENTRY_AGREEMENT', ' By clicking this box you are agreeing that you have read and agree to all terms and conditions of this website.'); 
//Modify your account agreement here
define('ENTRY_AGREEMENT_ERROR', 'You must check the account agreement box to set up an accout.');
define('ENTRY_AGREEMENT_TEXT', '*');
define('TEXT_ACCOUNT_AGREEMENT','Account Agreement');
// EOC added for Account Agreement

define('FORM_REQUIRED_INFORMATION', '* Required information');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Result Pages:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> products)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> orders)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> reviews)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> new products)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> specials)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'First Page');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Previous Page');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Next Page');
define('PREVNEXT_TITLE_LAST_PAGE', 'Last Page');
define('PREVNEXT_TITLE_PAGE_NO', 'Page %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Previous Set of %d Pages');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Next Set of %d Pages');
define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;FIRST');
define('PREVNEXT_BUTTON_PREV', '[&lt;&lt;&nbsp;Prev]');
define('PREVNEXT_BUTTON_NEXT', '[Next&nbsp;&gt;&gt;]');
define('PREVNEXT_BUTTON_LAST', 'LAST&gt;&gt;');

define('IMAGE_BUTTON_ADD_ADDRESS', 'Add Address');
define('IMAGE_BUTTON_ADDRESS_BOOK', 'Address Book');
define('IMAGE_BUTTON_BACK', 'Back');
define('IMAGE_BUTTON_BUY_NOW', 'Buy Now');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Change Address');
define('IMAGE_BUTTON_CHECKOUT', 'Checkout');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Confirm Order');
define('IMAGE_BUTTON_CONTINUE', 'Continue');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Continue Shopping');
define('IMAGE_BUTTON_DELETE', 'Delete');
define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Edit Account');
define('IMAGE_BUTTON_HISTORY', 'Order History');
define('IMAGE_BUTTON_LOGIN', 'Sign In');
define('IMAGE_BUTTON_IN_CART', 'Add to Cart');
define('IMAGE_BUTTON_NOTIFICATIONS', 'Notifications');
define('IMAGE_BUTTON_QUICK_FIND', 'Quick Find');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Remove Notifications');
define('IMAGE_BUTTON_REVIEWS', 'Reviews');
define('IMAGE_BUTTON_SEARCH', 'Search');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Shipping Options');
define('IMAGE_BUTTON_TELL_A_FRIEND', 'Tell a Friend');
define('IMAGE_BUTTON_UPDATE', 'Update');
define('IMAGE_BUTTON_UPDATE_CART', 'Update Cart');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Write Review');

define('SMALL_IMAGE_BUTTON_DELETE', 'Delete');
define('SMALL_IMAGE_BUTTON_EDIT', 'Edit');
define('SMALL_IMAGE_BUTTON_VIEW', 'View');

define('ICON_ARROW_RIGHT', 'more');
define('ICON_CART', 'In Cart');
define('ICON_ERROR', 'Error');
define('ICON_SUCCESS', 'Success');
define('ICON_WARNING', 'Warning');

define('TEXT_GREETING_PERSONAL', 'Welcome back <span class="greetUser">%s!</span> Would you like to see which <a href="%s"><u>new products</u></a> are available to purchase?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>If you are not %s, please <a href="%s"><u>log yourself in</u></a> with your account information.</small>');
define('TEXT_GREETING_GUEST', 'Welcome <span class="greetUser">Guest!</span> Would you like to <a href="%s"><u>log yourself in</u></a>? Or would you prefer to <a href="%s"><u>create an account</u></a>?');

define('TEXT_SORT_PRODUCTS', 'Sort products ');
define('TEXT_DESCENDINGLY', 'descendingly');
define('TEXT_ASCENDINGLY', 'ascendingly');
define('TEXT_BY', ' by ');

define('TEXT_REVIEW_BY', 'by %s');
define('TEXT_REVIEW_WORD_COUNT', '%s words');
define('TEXT_REVIEW_RATING', 'Rating: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Date Added: %s');
define('TEXT_NO_REVIEWS', 'There are currently no product reviews.');

define('TEXT_NO_NEW_PRODUCTS', 'There are currently no products.');

define('TEXT_UNKNOWN_TAX_RATE', 'Unknown tax rate');

define('TEXT_REQUIRED', '<span class="errorText">Required</span>');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>TEP ERROR:</small> Cannot send the email through the specified SMTP server. Please check your php.ini setting and correct the SMTP server if necessary.</b></font>');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warning: Installation directory exists at: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install. Please remove this directory for security reasons.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warning: I am able to write to the configuration file: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. This is a potential security risk - please set the right user permissions on this file.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warning: The sessions directory does not exist: ' . tep_session_save_path() . '. Sessions will not work until this directory is created.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the sessions directory: ' . tep_session_save_path() . '. Sessions will not work until the right user permissions are set.');
define('WARNING_SESSION_AUTO_START', 'Warning: session.auto_start is enabled - please disable this php feature in php.ini and restart the web server.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warning: The downloadable products directory does not exist: ' . DIR_FS_DOWNLOAD . '. Downloadable products will not work until this directory is valid.');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'The expiry date entered for the credit card is invalid.<br>Please check the date and try again.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'The credit card number entered is invalid.<br>Please check the number and try again.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'The first four digits of the number entered are: %s<br>If that number is correct, we do not accept that type of credit card.<br>If it is wrong, please try again.');

/*
  Poniższa informacja o prawie autorskim może być
  modyfikowana lub usunięta jedynie gdy wygląd serwisu
  został zmieniony i różni się od domyślnego zastrzeżonego
  prawem wyglądu osCommerce.

  Więcej informacji znajdziesz w FAQ na stronie wsparcia
  osCommerce:

        http://www.oscommerce.com/about/copyright

  Pozostaw ten komentarz nienaruszony wraz z następującą
  informacją o prawach autorskich.
*/

define('FOOTER_TEXT_BODY', 'Powered by <a href="http://www.eSklep-os.com" target="_blank">eSklep-Os</a>');
define('NAVBAR_TITLE', 'Reviews');
define('ITEMS_IN_CART', 'now in your cart');
define('NEW_PRODUCTS', 'New Products');
define('TABLE_HEADING_PRICE', 'Price');
define('HEADING_PRODUCT_INFO','Product Info');
define('ITEM_PRICE','Item price:');
define('HEADING_PRODUCT_REVIEWS','Reviews');
define('HEADING_CHOOS_LANG','Choose');
define('PRODUCT_INFO_DESCRIPTION','Description');

//Star product Start
define('STAR_TITLE', 'Star Product'); // star product
define('STAR_READ_MORE', ' ... read more.'); // ... read more.
//Star product End

// Begin EZier new fields
define('TABLE_HEADING_RETAIL_PRICE', 'Retail');
define('TABLE_HEADING_SAVE', 'Savings'); 
define('TEXT_PRODUCTS_RETAIL_PRICE_INFO', 'Retail Price: ');
define('TEXT_PRODUCTS_PRICE_INFO', 'Your Price: ');
define('TEXT_PRODUCTS_PRICE_INFO_REGULAR', 'Regular Price: ');
define('TEXT_PRODUCTS_SAVE_INFO', '<font color=red>You Save: ');
define('TEXT_PRODUCTS_RETAIL_PRICE', 'Products Retail Price: ');
define('TEXT_PRODUCTS_PRICE_SPECIAL_INFO', '<font color=red>Special Price: ');
define('TEXT_PRODUCTS_PRICE_SPECIAL_CUST', '<font color=red>Your Discounted Price: ');
// EZier new fields end

define('WHATS_NEW_ALL','View all');

//themes
define('BOX_HEADING_THEMES', 'Themes');

// START: Extra Infopages Manager
define('BOX_HEADING_PAGES', 'Information');
// END: Extra Infopages Manager

//BEGIN allprods modification  
define('BOX_INFORMATION_ALLPRODS', 'View all products');
//END allprods modification

define('ENTRY_NIP_NULL_ERROR', 'Jezeli podales nazwe firmy, to musisz rowniez podac NIP'); 
define('ENTRY_NIP_ERROR', 'Wprowadzono bledny NIP');
define('ENTRY_NIP', 'Numer NIP:');
define('ENTRY_NIP_TEXT', '');

define('IMAGE_BUTTON_PRINT_ORDER', 'Order printable');

//TotalB2B start
define('PRICES_LOGGED_IN_TEXT','Must be logged in for prices');
//TotalB2B end

//Kontakt Start
define('BOX_HEADING_KONTAKT','Contact');
//Kontakt End

//Linki Start
define('BOX_HEADING_LINKI','Links');
//Linki End


// previous next product
define('PREV_NEXT_PRODUCT', 'Product');
define('PREV_NEXT_FROM', 'of');
define('PREV_NEXT_IN_CATEGORY', 'in category');

// box text in includes/boxes/advsearch.php
define('BOX_HEADING_ADVSEARCH', 'Search');
define('BOX_ADVSEARCH_KW', 'Keyword(s):');
define('BOX_ADVSEARCH_PRICERANGE', 'Price Range:');
define('BOX_ADVSEARCH_PRICESEP', ' to ');
define('BOX_ADVSEARCH_CAT', 'Category:');
define('BOX_ADVSEARCH_ALLCAT', 'Any');

//Related Products
define('TABLE_HEADING_RELATED_PRODUCTS', 'Related Products');
define('TEXT_PRICE', 'Price');

// newsdesk box text in includes/boxes/newsdesk.php
define('TABLE_HEADING_NEWSDESK', 'News and Information');
define('TEXT_NO_NEWSDESK_NEWS', 'Sorry but there is no News');
define('TEXT_NEWSDESK_READMORE', 'Read More');
define('TEXT_NEWSDESK_VIEWED', 'Viewed:');

define('BOX_HEADING_NEWSDESK_CATEGORIES', 'News Categories');
define('BOX_HEADING_NEWSDESK_LATEST', 'Latest News');

define('TEXT_DISPLAY_NUMBER_OF_ARTICLES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> articles)');
define('TABLE_HEADING_NEWSDESK_SUBCAT', 'News - Subcategories');
//END -- newsdesk

//START - GiftWrap
define('TEXT_ENTER_GIFTWRAP_INFORMATION', 'Select Packing Option');
//END - GiftWrap

//START - Additional Images
define('TEXT_ADDITIONAL_IMAGES', 'Additional Images');
//END - Additional Images

// Who's online
define('BOX_HEADING_WHOS_ONLINE', 'Who\'s online?');
define('BOX_WHOS_ONLINE_THEREIS', 'There currently is');
define('BOX_WHOS_ONLINE_THEREARE', 'There currently are');
define('BOX_WHOS_ONLINE_GUEST', 'guest');
define('BOX_WHOS_ONLINE_GUESTS', 'guests');
define('BOX_WHOS_ONLINE_AND', 'and');
define('BOX_WHOS_ONLINE_MEMBER', 'member');
define('BOX_WHOS_ONLINE_MEMBERS', 'members');

// +Country-State Selector
define ('DEFAULT_COUNTRY', '223');
// -Country-State Selector

//recently viewed box
define('BOX_HEADING_RECENTLY_VIEWED','Recently Viewed');
define('NO_RECENTLY_VIEWED','Not viewed any products');

// ################# Contribution Newsletter v050 ##############

// subscribers box text in includes/boxes/subscribers.php
define('BOX_HEADING_SUBSCRIBERS', 'Newsletter');
define('BOX_TEXT_SUBSCRIBE', 'Subscribe');
define('BOX_TEXT_UNSUBSCRIBE', 'Unsubscribe');
define('TEXT_EMAIL_HTML','HTML');
define('TEXT_EMAIL_TXT','TXT');
define('TEXT_EMAIL','E-Mail Address:');
define('TEXT_EMAIL_FORMAT','Format');
define('TEXT_EMAIL','Courriel');

define('TEXT_NAME', 'Your Name:');
// Unsubscribe
define('UNSUBSCRIBE_TEXT','Unsubscribe : ');
define('TEXT_BOX1','Registered customers go to: ');
define('TEXT_BOX2','Your Account: ');
// ################# Contribution Newsletter v050 ##############

// Sorter for product_info.php
define('PRODUCTS_OPTIONS_SORT_BY_PRICE','0'); // 1= sort by products_options_sort_order + name; 0= sort by products_options_sort_order + price

// Categories Image and Name on product_info.php
define('SHOW_CATEGORIES','0'); // 0= off  1=on
define('TABLE_HEADING_MANUFACTURER', 'Manufacturer');

define('BOX_INFORMATION_SITEMAP', 'Site Map');

define('TEMPORARY_NO_PRICE', 'No Price');
define('PRODUCT_SOLD', 'Sold');

define('TABLE_HEADING_IMAGE', '');
define('TABLE_HEADING_MODEL', 'Model');
define('TABLE_HEADING_PRODUCTS', 'Product Name');
define('TABLE_HEADING_MANUFACTURER', 'Manufacturer');
define('TABLE_HEADING_QUANTITY', 'Quantity');
define('TABLE_HEADING_PRICE', 'Price');
define('TABLE_HEADING_WEIGHT', 'Weight');
define('TABLE_HEADING_BUY_NOW', 'Buy Now');
define('TEXT_NO_PRODUCTS', 'There are no products.');
define('TABLE_HEADING_PRODUCTS_AVAILABILITY', 'Availability');

define('TEXT_BUY', 'Buy 1 \'');
define('TEXT_NOW', '\' now');

define('BOX_HEADING_ADVERTISE', 'Advertise');

//kgt - discount coupons
define('ENTRY_DISCOUNT_COUPON_ERROR', 'The coupon code you have entered is not valid.');
define('ENTRY_DISCOUNT_COUPON_AVAILABLE_ERROR', 'The coupon code you have entered is no longer valid.');
define('ENTRY_DISCOUNT_COUPON_USE_ERROR', 'Our records show that you have used this coupon %s time(s).  You may not use this code more than %s time(s).');
define('ENTRY_DISCOUNT_COUPON_MIN_PRICE_ERROR', 'The minimum order total for this coupon is %s');
define('ENTRY_DISCOUNT_COUPON_MIN_QUANTITY_ERROR', 'The minimum number of products required for this coupon is %s');
define('ENTRY_DISCOUNT_COUPON_EXCLUSION_ERROR', 'Some or all of the products in your cart are excluded.' );
define('ENTRY_DISCOUNT_COUPON', 'Coupon Code:');
define('ENTRY_DISCOUNT_COUPON_FREE_SHIPPING_ERROR', 'Your order total is now below the free shipping minimum.');
define('ENTRY_DISCOUNT_COUPON_SHIPPING_CALC_ERROR', 'Your calculated shipping charges have changed.');
//end kgt - discount coupons

define('BOX_SHOPPING_CART_QUANTITY', 'Products quantity');
define('BOX_SHOPPING_CART_TOTAL', 'Total');

define('BOX_HEADING_PLATNOSCI', 'Payment Online');

define('RECENTLY_VIEWED_BOX_HEADING','Recently Viewed');   // box heading

define('TEXT_KOMUNIKAT','Information');   // box heading
define('TEXT_ZAMKNIJ','Close'); 
define('TEXT_UWAGA','WARNING'); 

// nowe
define('POLA_OBOWIAZKOWE','Of Pol marked * are required for filling up');
define('CATEGORY_OSOBA','Trade-off personalities businesses');
define('OSOBA_TEXT','Please, choose kind of personality of legal new user');
define('FORM_OSOBA_FIZYCZNA','Physical person'); 
define('FORM_OSOBA_PRAWNA',"Company");
define('ZGODA_DANE_OSOBOWE','');
define('PRZETWARZANIE_DANYCH','');
define('TABLE_HEADING_DOKUMENT_SPRZEDAZY','Document of sale');
define('TEXT_SELECT_DOKUMENT_SPRZEDAZY','Selects voucher vend.');
define('TEXT_PARAGON','');
define('TEXT_FAKTURA','');
define('FAKTURA_NIP','(Paragon badge NIP on in question shopper.)');

//definicje zwiazane z wyswietlaniem netto/brutto
define('TEXT_NETTO',' (excl. TAX)');
define('TEXT_BRUTTO',' (incl. TAX)');

//pozycje menu
define('HEADER_TITLE_HOME','Home');
define('HEADER_TITLE_SPECIALS','Specials');
define('HEADER_TITLE_SEARCH','Search');
define('HEADER_TITLE_NEWS','News');
define('HEADER_TITLE_CONTACTS','Contacts');

define('HEADING_NEWSDESK_STICKY' , 'Important Informations');

?>