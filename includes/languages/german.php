<?php
/*
  $Id: german.php 172 2008-03-21 22:47:23Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

*/

// look in your $PATH_LOCALE/locale directory for available locales
// or type locale -a on the server.
// Examples:
// on RedHat try 'de_DE'
// on FreeBSD try 'de_DE.ISO_8859-1'
// on Windows try 'de' or 'German'
@setlocale(LC_TIME, 'de_DE.ISO_8859-1');

define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'EUR');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="LTR" lang="de"');

// charset for web pages and emails
define('CHARSET', 'utf-8');

// page title
define('TITLE', 'eSklep-Os');

// header text in includes/header.php
define('HEADER_TITLE_CREATE_ACCOUNT', 'Neues Konto');
define('HEADER_TITLE_MY_ACCOUNT', 'Ihr Konto');
define('HEADER_TITLE_CART_CONTENTS', 'Warenkorb');
define('HEADER_TITLE_CHECKOUT', 'Kasse');
define('HEADER_TITLE_TOP', 'Startseite');
define('HEADER_TITLE_CATALOG', 'Katalog');
define('HEADER_TITLE_LOGOFF', 'Abmelden');
define('HEADER_TITLE_LOGIN', 'Anmelden');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'Zugriffe seit');

// text for gender
define('MALE', 'Herr');
define('FEMALE', 'Frau');
define('MALE_ADDRESS', 'Herr');
define('FEMALE_ADDRESS', 'Frau');

// text for date of birth example
define('DOB_FORMAT_STRING', 'tt.mm.jjjj');

// categories box text in includes/boxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Kategorien');

// manufacturers box text in includes/boxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Hersteller');

// whats_new box text in includes/boxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'Neue Produkte');

// quick_find box text in includes/boxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Schnellsuche');
define('BOX_SEARCH_TEXT', 'Verwenden Sie Stichworte, um ein Produkt zu finden.');
define('BOX_SEARCH_ADVANCED_SEARCH', 'erweiterte Suche');

// specials box text in includes/boxes/specials.php
define('BOX_HEADING_SPECIALS', 'Angebote');

// reviews box text in includes/boxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Bewertungen');
define('BOX_REVIEWS_WRITE_REVIEW', 'Bewerten Sie dieses Produkt!');
define('BOX_REVIEWS_NO_REVIEWS', 'Es liegen noch keine Bewertungen vor');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s von 5 Sternen!');

// shopping_cart box text in includes/boxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Warenkorb');
define('BOX_SHOPPING_CART_EMPTY', '0 Produkte');

// order_history box text in includes/boxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Bestellübersicht');

// best_sellers box text in includes/boxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Bestseller');
define('BOX_HEADING_BESTSELLERS_IN', 'Bestseller<br>&nbsp;&nbsp;');

// notifications box text in includes/boxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Benachrichtigungen');
define('BOX_NOTIFICATIONS_NOTIFY', 'Benachrichtigen Sie mich über Aktuelles zu diesem Artikel <b>%s</b>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Benachrichtigen Sie mich nicht mehr zu diesem Artikel <b>%s</b>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Hersteller Info');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Mehr Produkte');

// languages box test in includes/boxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Sprachen');

// currencies box text in includes/boxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Währungen');

// information box text in includes/boxes/information.php
define('BOX_HEADING_INFORMATION', 'Informationen');
define('BOX_INFORMATION_PRIVACY', 'Privatsphäre und Datenschutz');
define('BOX_INFORMATION_CONDITIONS', 'Unsere AGB\'s');
define('BOX_INFORMATION_SHIPPING', 'Liefer - und Versandkosten');
define('BOX_INFORMATION_CONTACT', 'Kontakt');

// tell a friend box text in includes/boxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Weiterempfehlen');
define('BOX_TELL_A_FRIEND_TEXT', 'Empfehlen Sie diesen Artikel einfach per Email weiter.');

// checkout procedure text
define('CHECKOUT_BAR_DELIVERY', 'Versandinformationen');
define('CHECKOUT_BAR_PAYMENT', 'Zahlungsweise');
define('CHECKOUT_BAR_CONFIRMATION', 'Bestätigung');
define('CHECKOUT_BAR_FINISHED', 'Fertig!');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Bitte wählen');
define('TYPE_BELOW', 'bitte unten eingeben');

// javascript messages
define('JS_ERROR', 'Notwendige Angaben fehlen!\nBitte richtig ausf¨llen.\n\n');

define('JS_REVIEW_TEXT', '* Der Text muss mindestens aus ' . REVIEW_TEXT_MIN_LENGTH . ' Buchstaben bestehen.\n');
define('JS_REVIEW_RATING', '* Geben Sie Ihre Bewertung ein.\n');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Bitte wählen Sie eine Zahlungsweise für Ihre Bestellung.\n');

define('JS_ERROR_SUBMITTED', 'Diese Seite wurde bereits bestätigt. Betätigen Sie bitte OK und warten bis der Prozess durchgeführt wurde.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Bitte wählen Sie eine Zahlungsweise für Ihre Bestellung.');

define('CATEGORY_COMPANY', 'Firmendaten');
define('CATEGORY_PERSONAL', 'Angaben zu Ihrer Person');
define('CATEGORY_ADDRESS', 'Ihre Adresse');
define('CATEGORY_CONTACT', 'Ihre Kontaktinformationen');
define('CATEGORY_OPTIONS', 'Optionen');
define('CATEGORY_PASSWORD', 'Ihr Passwort');

define('ENTRY_COMPANY', 'Firmenname:');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');

define('ENTRY_NIP', 'Steuer-/ Ust.-Id. Nummer:');
define('ENTRY_NIP_ERROR', '');
define('ENTRY_NIP_TEXT', '');

define('ENTRY_GENDER', 'Anrede:');
define('ENTRY_GENDER_ERROR', 'Bitte das Geschlecht angeben.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Vorname:');
define('ENTRY_FIRST_NAME_ERROR', 'Der Vorname sollte mindestens ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Zeichen enthalten.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Nachname:');
define('ENTRY_LAST_NAME_ERROR', 'Der Nachname sollte mindestens ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Zeichen enthalten.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Geburtsdatum:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Bitte geben Sie Ihr Geburtsdatum in folgendem Format ein: TT.MM.JJJJ (z.B. 21.05.1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (z.B. 21.05.1970)');
define('ENTRY_EMAIL_ADDRESS', 'Email-Adresse:');
define('ENTRY_EMAIL_ADDRESS_CONFIRM', 'Bestätigen Sie Email:');
define('ENTRY_EMAIL_ADDRESS_CONFIRM_NOT_MATCHING', 'Das Bestätigung email muß Ihr email address zusammenbringen.');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Die Email Adresse sollte mindestens ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Zeichen enthalten.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Die Email Adresse scheint nicht gültig zu sein - bitte korrigieren.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Die Email Adresse ist bereits gespeichert - bitte melden Sie sich mit dieser Adresse an oder eröffnen Sie ein neues Konto mit einer anderen Adresse.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Strasse/Nr.:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Die Strassenadresse sollte mindestens ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Zeichen enthalten.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Stadtteil:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Postleitzahl:');
define('ENTRY_POST_CODE_ERROR', 'Die Postleitzahl sollte mindestens ' . ENTRY_POSTCODE_MIN_LENGTH . ' Zeichen enthalten.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Ort:');
define('ENTRY_CITY_ERROR', 'Die Stadt sollte mindestens ' . ENTRY_CITY_MIN_LENGTH . ' Zeichen enthalten.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Bundesland:');
define('ENTRY_STATE_ERROR', 'Das Bundesland sollte mindestens ' . ENTRY_STATE_MIN_LENGTH . ' Zeichen enthalten.');
define('ENTRY_STATE_ERROR_SELECT', 'Bitte wählen Sie ein Bundesland aus der Liste.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Land:');
define('ENTRY_COUNTRY_ERROR', 'Bitte wählen Sie ein Land aus der Liste.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Telefonnummer:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Die Telefonnummer sollte mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Zeichen enthalten.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Telefaxnummer:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Newsletter:');
define('ENTRY_NEWSLETTER_OPIS', '(Eine Abmeldung ist jederzeit möglich.)');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'abonniert');
define('ENTRY_NEWSLETTER_NO', 'nicht abonniert');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Passwort:');
define('ENTRY_PASSWORD_ERROR', 'Das Passwort sollte mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen enthalten.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Beide eingegebenen Passwörter müssen identisch sein.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', 'Bestätigung:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Current Password:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Das Passwort sollte mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen enthalten.');
define('ENTRY_PASSWORD_NEW', 'New Password:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Das neue Passwort sollte mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen enthalten.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Die Passwort-Bestätigung muss mit Ihrem neuen Passwort übereinstimmen.');
define('PASSWORD_HIDDEN', '--VERSTECKT--');

// BOC added for Account Agreement
define('ENTRY_AGREEMENT', ' Ich akzeptiere die Allgemeinen Geschäfts- und Lieferbedingungen.'); 
//Modify your account agreement here
define('ENTRY_AGREEMENT_ERROR', 'Sie müssen den Kontovereinbarung Kasten überprüfen, um ein accout aufzustellen.');
define('ENTRY_AGREEMENT_TEXT', '*');
define('TEXT_ACCOUNT_AGREEMENT','Zustimmung der AGB’s und Lieferbedingungen');
// EOC added for Account Agreement

define('FORM_REQUIRED_INFORMATION', '* Notwendige Eingabe');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Seiten:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'angezeigte Produkte: <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'angezeigte Bestellungen: <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'angezeigte Meinungen: <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'angezeigte neue Produkte: <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'angezeigte Angebote <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'erste Seite');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'vorherige Seite');
define('PREVNEXT_TITLE_NEXT_PAGE', 'nächste Seite');
define('PREVNEXT_TITLE_LAST_PAGE', 'letzte Seite');
define('PREVNEXT_TITLE_PAGE_NO', 'Seite %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Vorhergehende %d Seiten');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Nächste %d Seiten');
define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;ERSTE');
define('PREVNEXT_BUTTON_PREV', '[&lt;&lt;&nbsp;vorherige]');
define('PREVNEXT_BUTTON_NEXT', '[nächste&nbsp;&gt;&gt;]');
define('PREVNEXT_BUTTON_LAST', 'LETZTE&gt;&gt;');

define('IMAGE_BUTTON_ADD_ADDRESS', 'Neue Adresse');
define('IMAGE_BUTTON_ADDRESS_BOOK', 'Adressbuch');
define('IMAGE_BUTTON_BACK', 'Zurück');
define('IMAGE_BUTTON_BUY_NOW', 'Buy Now');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Adresse ändern');
define('IMAGE_BUTTON_CHECKOUT', 'Kasse');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Bestellung bestätigen');
define('IMAGE_BUTTON_CONTINUE', 'Weiter');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Einkauf fortsetzen');
define('IMAGE_BUTTON_DELETE', 'Löschen');
define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Daten ändern');
define('IMAGE_BUTTON_HISTORY', 'Bestellübersicht');
define('IMAGE_BUTTON_LOGIN', 'Anmelden');
define('IMAGE_BUTTON_IN_CART', 'In den Warenkorb');
define('IMAGE_BUTTON_NOTIFICATIONS', 'Benachrichtigungen');
define('IMAGE_BUTTON_QUICK_FIND', 'Schnellsuche');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Benachrichtigungen löschen');
define('IMAGE_BUTTON_REVIEWS', 'Bewertungen');
define('IMAGE_BUTTON_SEARCH', 'Suchen');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Versandoptionen');
define('IMAGE_BUTTON_TELL_A_FRIEND', 'Weiterempfehlen');
define('IMAGE_BUTTON_UPDATE', 'Aktualisieren');
define('IMAGE_BUTTON_UPDATE_CART', 'Warenkorb aktualisieren');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Bewertung schreiben');

define('SMALL_IMAGE_BUTTON_DELETE', 'Delete');
define('SMALL_IMAGE_BUTTON_EDIT', 'Edit');
define('SMALL_IMAGE_BUTTON_VIEW', 'View');

define('ICON_ARROW_RIGHT', 'Zeige mehr');
define('ICON_CART', 'In den Warenkorb');
define('ICON_ERROR', 'Fehler');
define('ICON_SUCCESS', 'Success');
define('ICON_WARNING', '');

define('TEXT_GREETING_PERSONAL', 'Schön das Sie wieder da sind <span class="greetUser">%s!</span> Möchten Sie die <a href="%s"><u>neue Produkte</u></a> ansehen?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Wenn Sie nicht %s sind, melden Sie sich bitte <a href="%s"><u>hier</u></a> mit Ihrem Kundenkonto an.</small>');
define('TEXT_GREETING_GUEST', 'Herzlich Willkommen <span class="greetUser">Gast!</span> Möchten Sie sich <a href="%s"><u>anmelden</u></a>? Oder wollen Sie ein <a href="%s"><u>Kundenkonto</u></a> eröffnen?');

define('TEXT_SORT_PRODUCTS', 'Sortierung der Artikel ist ');
define('TEXT_DESCENDINGLY', 'absteigend');
define('TEXT_ASCENDINGLY', 'aufsteigend');
define('TEXT_BY', ' nach ');

define('TEXT_REVIEW_BY', 'von %s');
define('TEXT_REVIEW_WORD_COUNT', '%s Worte');
define('TEXT_REVIEW_RATING', 'Bewertung: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Datum hinzugefügt: %s');
define('TEXT_NO_REVIEWS', 'Es liegen noch keine Bewertungen vor.');

define('TEXT_NO_NEW_PRODUCTS', 'Zur Zeit gibt es keine neuen Produkte.');

define('TEXT_UNKNOWN_TAX_RATE', 'Unbekannter Steuersatz');

define('TEXT_REQUIRED', '<span class="errorText">erforderlich</span>');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>Fehler:</small> Die Email kann nicht über den angegebenen SMTP-Server verschickt werden. Bitte kontrollieren Sie die Einstellungen in der php.ini Datei und führen Sie notwendige Korrekturen durch!</b></font>');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warnung: Das Installationverzeichnis ist noch vorhanden auf: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install. Bitte löschen Sie das Verzeichnis aus Gründen der Sicherheit!');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warnung: osC kann in die Konfigurationsdatei schreiben: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. Das stellt ein mögliches Sicherheitsrisiko dar - bitte korrigieren Sie die Benutzerberechtigungen zu dieser Datei!');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warnung: Das Verzeichnis für die Sessions existiert nicht: ' . tep_session_save_path() . '. Die Sessions werden nicht funktionieren bis das Verzeichnis erstellt wurde!');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warnung: osC kann nicht in das Sessions Verzeichnis schreiben: ' . tep_session_save_path() . '. Die Sessions werden nicht funktionieren bis die richtigen Benutzerberechtigungen gesetzt wurden!');
define('WARNING_SESSION_AUTO_START', 'Warnung: session.auto_start ist enabled - Bitte disablen Sie dieses PHP Feature in der php.ini und starten Sie den WEB-Server neu!');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warnung: Das Verzeichnis für den Artikel Download existiert nicht: ' . DIR_FS_DOWNLOAD . '. Diese Funktion wird nicht funktionieren bis das Verzeichnis erstellt wurde!');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Das "Gültig bis" Datum ist ungültig.<br>Bitte korrigieren Sie Ihre Angaben.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Die "KreditkarteNummer", die Sie angegeben haben, ist ungültig.<br>Bitte korrigieren Sie Ihre Angaben.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Die ersten 4 Ziffern Ihrer Kreditkarte sind: %s<br>Wenn diese Angaben stimmen, wird dieser Kartentyp leider nicht akzeptiert.<br>Bitte korrigieren Sie Ihre Angaben gegebenfalls.');

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
define('FOOTER_TEXT_BODY', 'Powered by <a href="http://www.esklep-os.com" target="_blank">eSklep-Os</a>');
define('NAVBAR_TITLE', 'Konto erstellen');
define('ITEMS_IN_CART', 'Warenkorb');
define('NEW_PRODUCTS', 'Neue Produkte');
define('TABLE_HEADING_PRICE', 'Preis');
define('HEADING_PRODUCT_INFO','Produkte');
define('ITEM_PRICE','Produkt-Preis:');
define('HEADING_PRODUCT_REVIEWS','Meinungen');
define('HEADING_CHOOS_LANG','Bitte wählen');
define('PRODUCT_INFO_DESCRIPTION','Beschreibung');

//Star product Start
define('STAR_TITLE', 'Star Produkt'); // star product
define('STAR_READ_MORE', ' ... mehr Info.'); // ... read more.
//Star product End

// Begin EZier new fields
define('TABLE_HEADING_RETAIL_PRICE', 'Einzelverkauf');
define('TABLE_HEADING_SAVE', 'Sparungen'); 
define('TEXT_PRODUCTS_RETAIL_PRICE_INFO', 'Listenpreis: ');
define('TEXT_PRODUCTS_PRICE_INFO', 'Unser Preis: ');
define('TEXT_PRODUCTS_PRICE_INFO_REGULAR', 'Einzelverkauf: ');
define('TEXT_PRODUCTS_SAVE_INFO', '<font color=red>Sie sparen: ');
define('TEXT_PRODUCTS_RETAIL_PRICE', 'Einzelhandelspreis:');
define('TEXT_PRODUCTS_PRICE_SPECIAL_INFO', '<font color=red>Sonderpreis: ');
define('TEXT_PRODUCTS_PRICE_SPECIAL_CUST', '<font color=red>Händlerpreis: ');
// End EZier new fields

define('WHATS_NEW_ALL','Ales');

//themes
define('BOX_HEADING_THEMES', 'Themen');

// START: Extra Infopages Manager
define('BOX_HEADING_PAGES', 'Information');
// END: Extra Infopages Manager

//BEGIN allprods modification  
define('BOX_INFORMATION_ALLPRODS', 'Alle Produkte');
//END allprods modification

define('ENTRY_NIP_NULL_ERROR', 'Sie müssen NIP schreiben'); 
define('ENTRY_NIP_ERROR', 'Falsche NIP');
define('ENTRY_NIP', 'NIP:');
define('ENTRY_NIP_TEXT', '');

define('IMAGE_BUTTON_PRINT_ORDER', 'Auftrag bedruckbar');

//TotalB2B start
define('PRICES_LOGGED_IN_TEXT','Mußß für Preise innen geloggt werden');
//TotalB2B end

//Kontakt Start
define('BOX_HEADING_KONTAKT','Kontakt');
//Kontakt End

//Linki Start
define('BOX_HEADING_LINKI','Verbindungen');
//Linki End
 
// previous next product
define('PREV_NEXT_PRODUCT', 'Produkte');
define('PREV_NEXT_FROM', '/');
define('PREV_NEXT_IN_CATEGORY', 'in der Kategorie');

// box text in includes/boxes/advsearch.php
define('BOX_HEADING_ADVSEARCH', 'Suche');
define('BOX_ADVSEARCH_KW', 'Schlüsselwort:');
define('BOX_ADVSEARCH_PRICERANGE', 'Preis:');
define('BOX_ADVSEARCH_PRICESEP', ' von ...bis ');
define('BOX_ADVSEARCH_CAT', 'Kategorie:');
define('BOX_ADVSEARCH_ALLCAT', 'Bitte wählen');

// newsdesk box text in includes/boxes/newsdesk.php
define('TABLE_HEADING_NEWSDESK', 'Nachrichten und Informationen');
define('TEXT_NO_NEWSDESK_NEWS', 'Traurig aber es gibt keine Nachrichten');
define('TEXT_NEWSDESK_READMORE', 'Lesen Sie Mehr');
define('TEXT_NEWSDESK_VIEWED', 'Angesehen:');

define('BOX_HEADING_NEWSDESK_CATEGORIES', 'Nachrichten Kategorien');
define('BOX_HEADING_NEWSDESK_LATEST', 'Neueste Nachrichten');

define('TEXT_DISPLAY_NUMBER_OF_ARTICLES', 'Anzeigen <b>%d</b> zu <b>%d</b> (von <b>%d</b> Artikel)');
define('TABLE_HEADING_NEWSDESK_SUBCAT', 'Nachrichten - Unterkategorien');
//END -- newsdesk

//START - GiftWrap
define('TEXT_ENTER_GIFTWRAP_INFORMATION', 'Wählen Sie Verpackung Wahl Vor');
//END - GiftWrap

//START - Additional Images
define('TEXT_ADDITIONAL_IMAGES', 'Zusätzliche Bilder');
//END - Additional Images

// Wer ist online
define('BOX_HEADING_WHOS_ONLINE', 'Wer ist online?');
define('BOX_WHOS_ONLINE_THEREIS', 'Zur Zeit ist');
define('BOX_WHOS_ONLINE_THEREARE', 'Zur Zeit sind');
define('BOX_WHOS_ONLINE_GUEST', 'Gast');
define('BOX_WHOS_ONLINE_GUESTS', 'Gäste');
define('BOX_WHOS_ONLINE_AND', 'und');
define('BOX_WHOS_ONLINE_MEMBER', 'Mitglied');
define('BOX_WHOS_ONLINE_MEMBERS', 'Mitglieder');

// +Country-State Selector
define ('DEFAULT_COUNTRY', '170');
// -Country-State Selector

//recently viewed box
define('BOX_HEADING_RECENTLY_VIEWED','Vor kurzem Angesehen');
define('NO_RECENTLY_VIEWED','Nicht angesehen irgendwelchen Produkten');

// ################# Contribution Newsletter v050 ##############

// subscribers box text in includes/boxes/subscribers.php
define('BOX_HEADING_SUBSCRIBERS', 'Newsletter');
define('BOX_TEXT_SUBSCRIBE', 'Unterzeichnen Sie');
define('BOX_TEXT_UNSUBSCRIBE', 'Entfernen Sie');
define('TEXT_EMAIL_HTML','HTML');
define('TEXT_EMAIL_TXT','TXT');
define('TEXT_EMAIL','Email Adresse:');
define('TEXT_EMAIL_FORMAT','Format');
define('TEXT_EMAIL','Courriel');

define('TEXT_NAME', 'Ihr Name:');
// Unsubscribe
define('UNSUBSCRIBE_TEXT','Entfernen Sie : ');
define('TEXT_BOX1','Eingetragene Kunden gehen zu: ');
define('TEXT_BOX2','Ihr Konto: ');
// ################# Contribution Newsletter v050 ##############

// Sorter for product_info.php
define('PRODUCTS_OPTIONS_SORT_BY_PRICE','1'); // 1= sort by products_options_sort_order + name; 0= sort by products_options_sort_order + price

// Categories Image and Name on product_info.php
define('SHOW_CATEGORIES','0'); // 0= off  1=on
define('TABLE_HEADING_MANUFACTURER', 'Hersteller');

define('BOX_INFORMATION_SITEMAP', 'Sitemap');

define('TEMPORARY_NO_PRICE', 'Kein Preis');
define('PRODUCT_SOLD', 'Verkauft');

//kgt - discount coupons
define('ENTRY_DISCOUNT_COUPON_ERROR', 'Der eigegebene Gutscheincode ist ungültiig.');
define('ENTRY_DISCOUNT_COUPON_AVAILABLE_ERROR', 'Der eingegebene Gutscheincode ist leider bereits verfallen.');
define('ENTRY_DISCOUNT_COUPON_USE_ERROR', 'Sie haben diesen Gutschein bereits %s mal eingelöst.  Sie dürfen; den Gutschein maximal %s mal einlösen.');
define('ENTRY_DISCOUNT_COUPON_MIN_PRICE_ERROR', 'Der Mindestbestellwert für diesen Coupon beträgt %s');
define('ENTRY_DISCOUNT_COUPON', 'Gutschein Code:');
define('ENTRY_DISCOUNT_COUPON_FREE_SHIPPING_ERROR', 'Der Gesamtbetrag unterschreitet nun den Mindestbetrag für kostenfreie Lieferung.');
define('ENTRY_DISCOUNT_COUPON_MIN_QUANTITY_ERROR', 'Die Mindestzahl der Produkte, die für diesen Kupon erfordert werden, ist %s');
define('ENTRY_DISCOUNT_COUPON_EXCLUSION_ERROR', 'Einige oder alle Produkte in Ihrer Karre werden ausgeschlossen.' );
define('ENTRY_DISCOUNT_COUPON_SHIPPING_CALC_ERROR', 'Ihre errechneten Verschiffenaufladungen haben geändert.');
//end kgt - discount coupons

define('SHOPPING_CART_QUANTITY', '');

define('BOX_HEADING_ADVERTISE', 'Werbung');


define('TABLE_HEADING_IMAGE', '');
define('TABLE_HEADING_MODEL', 'Artikel-Nr.');
define('TABLE_HEADING_PRODUCTS', 'Produkte');
define('TABLE_HEADING_MANUFACTURER', 'Hersteller');
define('TABLE_HEADING_QUANTITY', 'Anzahl');
define('TABLE_HEADING_PRICE', 'Preis');
define('TABLE_HEADING_WEIGHT', 'Gewicht');
define('TABLE_HEADING_BUY_NOW', 'Bestellen');
define('TEXT_NO_PRODUCTS', 'Es gibt keine Produkte.');
define('TABLE_HEADING_PRODUCTS_AVAILABILITY', 'Verwendbarkeit');

define('TEXT_BUY', '1 x \'');
define('TEXT_NOW', '\' bestellen!');

define('BOX_SHOPPING_CART_QUANTITY', 'Produktquantität');
define('BOX_SHOPPING_CART_TOTAL', 'Gesamtmenge');

define('BOX_HEADING_PLATNOSCI', 'Zahlung Online');

define('RECENTLY_VIEWED_BOX_HEADING','Vor kurzem angesehen');   // box heading

define('TEXT_KOMUNIKAT','Informationen');   // box heading
define('TEXT_ZAMKNIJ','Ende'); 
define('TEXT_UWAGA','ACHTUNG'); 

// nowe
define('POLA_OBOWIAZKOWE','Gekennzeichnet * nicht löschen Aufgaben bis Fülle');
define('CATEGORY_OSOBA','Wahl von der Rechtspersönlichkeit');
define('OSOBA_TEXT','Wählen Sie die Art des zugelassenen Wesens des neuen Benutzers bitte:');
define('FORM_OSOBA_FIZYCZNA','Körperliche Person'); 
define('FORM_OSOBA_PRAWNA',"Korporation");
define('ZGODA_DANE_OSOBOWE','');
define('PRZETWARZANIE_DANYCH','');
define('TABLE_HEADING_DOKUMENT_SPRZEDAZY','Dokument des Verkaufes');
define('TEXT_SELECT_DOKUMENT_SPRZEDAZY','Wählt Zeuge vend vor.');
define('TEXT_PARAGON','');
define('TEXT_FAKTURA','');
define('FAKTURA_NIP','(Defektabzeichen KLEMMSTELLE an im Frage Käufer.)');

//definicje zwiazane z wyswietlaniem netto/brutto
define('TEXT_NETTO',' Preis (exkl.)');
define('TEXT_BRUTTO',' Preis (inkl.)');

//pozycje menu
define('HEADER_TITLE_HOME','Anfang');
define('HEADER_TITLE_SPECIALS','Specials');
define('HEADER_TITLE_SEARCH','Suche');
define('HEADER_TITLE_NEWS','Nachrichten');
define('HEADER_TITLE_CONTACTS','Kontakte');

define('HEADING_NEWSDESK_STICKY' , 'Wichtige Informationen');
?>