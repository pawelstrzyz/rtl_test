<?php

/*$Id: polish.php 172 2008-03-21 22:47:23Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Publikowane na zasadach licencji GNU General Public License

  Tłumaczenie: Rafał Mróz ramroz@optimus.pl
  http://www.portalik.com
  
  modyfikacje "odkalkowujące" : devein@acmosis.eu.org
  
  ADAPTACJA TŁUMACZENIA DO WERSJI osCommerce 2.2 Milestone 2 : Mariusz Gawdziński mg@dwm.pl
  http://www.dwm.pl
  
*/

// zobacz w katalogu $PATH_LOCALE/locale dostępne lokalizacje..
// w RedHacie powinno być 'pl_PL'
// we FreeBSD sprawdź 'pl_PL.ISO_8859-2'
// w Windows spróbuj 'pl', lub 'Polski'
@setlocale(LC_TIME, 'pl_PL.UTF-8');

define('DATE_FORMAT_SHORT', '%d-%m-%Y');  // this is used for strftime() // zmienione na PN
define('DATE_FORMAT_LONG', '%d %B %Y'); // this is used for strftime()  //  zmienione na PN
define('DATE_FORMAT', 'd-m-Y'); // this is used for date()  // zmienione na PN
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Zwraca sformatowaną datę jako raw format
// $date powinna mieć format dd/mm/yyyy
// format raw date ma postać YYYYMMDD, lub DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'PLN');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="LTR" lang="pl"');

// charset for web pages and emails
define('CHARSET', 'utf-8');

// page title
define('TITLE', 'eSklep-Os');

// header text in includes/header.php
define('HEADER_TITLE_CREATE_ACCOUNT', 'Utwórz konto');
define('HEADER_TITLE_MY_ACCOUNT', 'Moje konto');
define('HEADER_TITLE_CART_CONTENTS', 'Koszyk');
define('HEADER_TITLE_CHECKOUT', 'Zamówienie');
define('HEADER_TITLE_TOP', 'Strona główna');
define('HEADER_TITLE_CATALOG', 'Katalog');
define('HEADER_TITLE_LOGOFF', 'Wyloguj');
define('HEADER_TITLE_LOGIN', 'Zaloguj');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'wywołań od');

// text for gender
define('MALE', 'Mężczyzna');
define('FEMALE', 'Kobieta');
define('MALE_ADDRESS', 'Pan');
define('FEMALE_ADDRESS', 'Pani');

// text for date of birth example
define('DOB_FORMAT_STRING', 'dd-mm-yyyy');

// categories box text in includes/boxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Kategorie');

// manufacturers box text in includes/boxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Producenci');

// whats_new box text in includes/boxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'Nowości');

// quick_find box text in includes/boxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Wyszukiwanie');
define('BOX_SEARCH_TEXT', 'Szukany produkt');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Zaawansowane');

// specials box text in includes/boxes/specials.php
define('BOX_HEADING_SPECIALS', 'Promocje');

// reviews box text in includes/boxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Recenzje');
define('BOX_REVIEWS_WRITE_REVIEW', 'Napisz recenzję tego produktu!');
define('BOX_REVIEWS_NO_REVIEWS', 'Obecnie nie ma recenzji o produktach');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s z 5 gwiazdek!');

// shopping_cart box text in includes/boxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Koszyk');
define('BOX_SHOPPING_CART_EMPTY', '... jest pusty');

// order_history box text in includes/boxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Historia');

// best_sellers box text in includes/boxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Bestsellery');
define('BOX_HEADING_BESTSELLERS_IN', 'Bestsellery kategorii<br>&nbsp;&nbsp;');

// notifications box text in includes/boxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Powiadomienia');
define('BOX_NOTIFICATIONS_NOTIFY', 'Informuj mnie o aktualizacjach <b>%s</b>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Nie informuj mnie o aktualizacjach <b>%s</b>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Producent');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', 'Strona %s');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Inne produkty');

// languages box text in includes/boxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Język');

// currencies box text in includes/boxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Waluty');

// information box text in includes/boxes/information.php
define('BOX_HEADING_INFORMATION', 'Informacje');
define('BOX_INFORMATION_PRIVACY', 'Bezpieczeństwo');
define('BOX_INFORMATION_CONDITIONS', 'Korzystanie z serwisu');
define('BOX_INFORMATION_SHIPPING', 'Wysyłka i zwroty');
define('BOX_INFORMATION_CONTACT', 'Kontakt');

// tell a friend box text in includes/boxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Powiadom znajomego');
define('BOX_TELL_A_FRIEND_TEXT', 'Powiedz o tym produkcie swoim znajomym');

// checkout procedure text
define('CHECKOUT_BAR_DELIVERY', 'Informacje o dostawie');
define('CHECKOUT_BAR_PAYMENT', 'Informacje o płatności');
define('CHECKOUT_BAR_CONFIRMATION', 'Potwierdzenie');
define('CHECKOUT_BAR_FINISHED', 'Koniec!');

// pull down default text
define('PULL_DOWN_DEFAULT', '-- Wybierz --');
define('TYPE_BELOW', 'Wprowadż poniżej');

// javascript messages
define('JS_ERROR', 'Wystąpiły błędy w trakcie przetwarzania formularza!\n\n');

define('JS_REVIEW_TEXT', '* Recenzja musi składać się z przynajmniej ' . REVIEW_TEXT_MIN_LENGTH . ' znaków.\n');
define('JS_REVIEW_RATING', '* Musisz ocenić produkt który recenzujesz.\n');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* * Wybierz metodę płatności dla twojego zamówienia.\n');

define('JS_ERROR_SUBMITTED', 'Ten formularz został już wysłany. Kliknij OK i poczekaj na zakończenie procesu.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Wybierz metodę płatnośći dla Twojego zamówienia.');

define('CATEGORY_COMPANY', 'Dane Firmy');
define('CATEGORY_PERSONAL', 'Dane Osobowe');
define('CATEGORY_ADDRESS', 'Dane Teleadresowe');
define('CATEGORY_CONTACT', 'Dane Kontaktowe');
define('CATEGORY_OPTIONS', 'Opcje');
define('CATEGORY_PASSWORD', 'Twoje hasło');

define('ENTRY_COMPANY', 'Nazwa firmy:');
define('ENTRY_COMPANY_ERROR', 'Nazwa firmy musi się składać z minimum ' . ENTRY_COMPANY_MIN_LENGTH . ' znaków');
define('ENTRY_COMPANY_TEXT', '');

define('ENTRY_GENDER', 'Płeć:');
define('ENTRY_GENDER_ERROR', 'Proszę wybrać płeć.');
define('ENTRY_GENDER_TEXT', '');
define('ENTRY_FIRST_NAME', 'Imię:');
define('ENTRY_FIRST_NAME_ERROR', 'Pole Imię musi się składać z minimum ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' znaków');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Nazwisko:');
define('ENTRY_LAST_NAME_ERROR', 'Pole Nazwisko musi się składać z minimum ' . ENTRY_LAST_NAME_MIN_LENGTH . ' znaków');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Data urodzenia:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Data urodzenia musi być w formiacie: DD/MM/YYYY (np. 21/12/1972)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '');
define('ENTRY_EMAIL_ADDRESS', 'E-mail:');
define('ENTRY_EMAIL_ADDRESS_CONFIRM', 'Potwierdź adres e-mail:');
define('ENTRY_EMAIL_ADDRESS_CONFIRM_NOT_MATCHING', 'Wprowadzone adresy e-mail muszą być takie same');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Twój adres e-mail musi się składać z minimum ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' znaków');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Twój adres e-mail ma niepoprawny format!');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Taki adres e-mail już istnieje w naszym sklepie!');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Ulica:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Pole Ulica musi się składać z minimum ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' znaków');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Dzielnica:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Kod pocztowy:');
define('ENTRY_POST_CODE_ERROR', 'Pole Kod pocztowy musi się składać z minimum ' . ENTRY_POSTCODE_MIN_LENGTH . ' znaków');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Miasto:');
define('ENTRY_CITY_ERROR', 'Pole Miasto musi się składać z minimum ' . ENTRY_CITY_MIN_LENGTH . ' znaków');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Województwo:');
define('ENTRY_STATE_ERROR', 'Pole Województwo musi się składać z minimum ' . ENTRY_STATE_MIN_LENGTH . ' znaków');
define('ENTRY_STATE_ERROR_SELECT', 'Proszę wybrać województwo z menu');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Kraj:');
define('ENTRY_COUNTRY_ERROR', 'Proszę wybrać kraj z menu');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Telefon:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Pole Telefon musi się składać z minimum ' . ENTRY_TELEPHONE_MIN_LENGTH . ' znaków');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Faks:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Biuletyn:');
define('ENTRY_NEWSLETTER_OPIS', '(Ustawienie można zmienić poźniej)');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Zapisany');
define('ENTRY_NEWSLETTER_NO', 'Wypisany');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Hasło:');
define('ENTRY_PASSWORD_ERROR', 'Pole Hasło musi się składać z minimum ' . ENTRY_PASSWORD_MIN_LENGTH . ' znaków');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'The Password Confirmation must match your Password.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', 'Potwierdzenie hasła:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Obecne hasło:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Twoje hasło musi się składać z minimum ' . ENTRY_PASSWORD_MIN_LENGTH . ' znaków');
define('ENTRY_PASSWORD_NEW', 'Nowe hasło:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Twoje nowe hasło musi się składać z minimum ' . ENTRY_PASSWORD_MIN_LENGTH . ' znaków');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Potwierdzenie hasła musi być identyczne z nowym hasłem.');
define('PASSWORD_HIDDEN', '--NIEWIDOCZNE--');

// BOC added for Account Agreement
define('ENTRY_AGREEMENT', 'Oświadczam, że zapoznałem się regulaminem i akceptuję jego warunki.'); 
//Modify your account agreement here
define('ENTRY_AGREEMENT_ERROR', 'Przed zakończeniem rejestracji musisz zapoznać się z regulaminem sklepu.');
define('ENTRY_AGREEMENT_TEXT', '*');
define('TEXT_ACCOUNT_AGREEMENT','Oświadczenie');
// EOC added for Account Agreement
define('FORM_REQUIRED_INFORMATION', '* Wymagane informacje');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Stron:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Wyświetlanie od <b>%d</b> do <b>%d</b> (z <b>%d</b> pozycji)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Wyświetlanie od <b>%d</b> do <b>%d</b> (z <b>%d</b> pozycji)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Wyświetlanie od <b>%d</b> do <b>%d</b> (z <b>%d</b> pozycji)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Wyświetlanie od <b>%d</b> do <b>%d</b> (z <b>%d</b> pozycji)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Wyświetlanie od <b>%d</b> do <b>%d</b> (z <b>%d</b> pozycji)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'Pierwsza strona');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Poprzednia strona');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Następna strona');
define('PREVNEXT_TITLE_LAST_PAGE', 'Ostatnia strona');
define('PREVNEXT_TITLE_PAGE_NO', 'Strona %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Poprzednie strony (%d)');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Następne strony (%d)');
define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;PIERWSZA');
define('PREVNEXT_BUTTON_PREV', '[&lt;&lt; Poprzednia]');
define('PREVNEXT_BUTTON_NEXT', '[Następna &gt;&gt;]');
define('PREVNEXT_BUTTON_LAST', 'OSTATNIA&gt;&gt;');

define('IMAGE_BUTTON_ADD_ADDRESS', 'Dodaj adres');
define('IMAGE_BUTTON_ADDRESS_BOOK', 'Książka adresowa');
define('IMAGE_BUTTON_BACK', 'Powrót');
define('IMAGE_BUTTON_BUY_NOW', 'Kup teraz!');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Zmień adres');
define('IMAGE_BUTTON_CHECKOUT', 'Zamów!');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Potwierdź zamówienie');
define('IMAGE_BUTTON_CONTINUE', 'Dalej');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Kontynuuj zakupy');
define('IMAGE_BUTTON_DELETE', 'Usuń');
define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Edytuj konto');
define('IMAGE_BUTTON_HISTORY', 'Historia zamówień');
define('IMAGE_BUTTON_LOGIN', 'Zaloguj');
define('IMAGE_BUTTON_IN_CART', 'Do koszyka');
define('IMAGE_BUTTON_NOTIFICATIONS', 'Powiadomienia');
define('IMAGE_BUTTON_QUICK_FIND', 'Szybkie wyszukiwanie');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Usuń informowanie o produktach');
define('IMAGE_BUTTON_REVIEWS', 'Pokaż recenzje tego produktu');
define('IMAGE_BUTTON_SEARCH', 'Szukaj');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Opcje wysyłki');
define('IMAGE_BUTTON_TELL_A_FRIEND', 'Poleć znajomemu');
define('IMAGE_BUTTON_UPDATE', 'Aktualizuj');
define('IMAGE_BUTTON_UPDATE_CART', 'Aktualizuj koszyk');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Napisz recenzję');

define('SMALL_IMAGE_BUTTON_DELETE', 'Usuń');
define('SMALL_IMAGE_BUTTON_EDIT', 'Edytuj');
define('SMALL_IMAGE_BUTTON_VIEW', 'Przeglądaj');

define('ICON_ARROW_RIGHT', 'więcej');
define('ICON_CART', 'Do koszyka');
define('ICON_ERROR', 'Błąd');
define('ICON_SUCCESS', 'Powiodło się');
define('ICON_WARNING', 'Uwaga ');

define('TEXT_GREETING_PERSONAL', 'Witaj ponownie <span class="greetUser">%s!</span> Czy chcesz zobaczyć, które z <a href="%s"><u>nowych prac</u></a> s± dostępne w sprzedaży?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Jeżeli %s to nie ty, proszę <a href="%s"><u>zaloguj się</u></a> na swoje konto.</small>');
define('TEXT_GREETING_GUEST', '<span class="greetUser">Witaj!</span> &nbsp; &nbsp;<a href="%s"><u>Z a l o g u j &nbsp; s i ę</u></a> ! &nbsp; Nie masz jeszcze konta? &nbsp; <a href="%s"><u>Z a r e j e s t r u j &nbsp; s i ę</u></a> !');

define('TEXT_SORT_PRODUCTS', 'Sortuj produkty ');
define('TEXT_DESCENDINGLY', 'malejąco');
define('TEXT_ASCENDINGLY', 'rosnąco');
define('TEXT_BY', ' wg ');

define('TEXT_REVIEW_BY', 'od %s');
define('TEXT_REVIEW_WORD_COUNT', '%s słów');
define('TEXT_REVIEW_RATING', 'Ocena: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Data dodania: %s');
define('TEXT_NO_REVIEWS', 'Dla tego produktu nie napisano jeszcze recenzji!');

define('TEXT_NO_NEW_PRODUCTS', 'Nie ma nowych produktów.');

define('TEXT_UNKNOWN_TAX_RATE', 'Nieznana stawka podatku');

define('TEXT_REQUIRED', '<span class="errorText">wymagane</span>');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>BŁĄD TEP:</small> Nie można wysłać wiadomości przez wskazany serwer SMTP. Sprawdź konfigurację pliku php.ini i jeżeli jest to konieczne, popraw wpis dot. serwera SMTP.</b></font>');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Ostrzeżenie: Istnieje katalog instalacyjny w lokalizacji: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install. Usuń ten katalog ze względów bezpieczeństwa.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Ostrzeżenie: Istnieje możliwość zapisu pliku konfiguracyjnego w lokalizacji: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. Istnieje ryzyko zagrożenia pracy systemu - zmień uprawnienia dla tego pliku.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Ostrzeżenie: Katalog dla sesji nie istnieje: ' . tep_session_save_path() . '. Sesje nie będą działać dopóki nie zostanie utworzony katalog.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Ostrzeżenie: Nie ma możliwości zapisu do katalogu sesji: ' . tep_session_save_path() . '. Sesje nie będą działać dopóki nie zostaną ustawione właściwe uprawnienia dla tego katalogu.');
define('WARNING_SESSION_AUTO_START', 'Ostrzeżenie: Parametr session.auto_start jest aktywny - zablokuj go zmieniając konfigurację pliku php.ini i zrestartuj serwer www.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Ostrzeżenie: Katalog dla produktów możliwych do ściągnięcia (plików, programów itp.) nie istnieje: ' . DIR_FS_DOWNLOAD . '. Produkty które można ściągać nie będą działały dopóki ten katalog nie zostanie utworzony.');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Data ważności karty kredytowej jest błędna.<br>Proszę sprawdzić datę na karcie i spróbować ponownie.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Wprowadzony numer karty kredytowej jest błędny.<br>Prosze sprawdzić numer na karcie i spróbować ponownie.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Pierwsze cztery cyfry z numeru karty kredytowej to: %s<br>Nawet jeżeli ten numer jest poprawny to niestety nie akceptujemy tego typu kart kredytowej.<br>Jeżeli numer jest błędny proszę go poprawić i spróbowac ponownie');

define('FOOTER_TEXT_BODY', 'Powered by 2008 <a class="menuLink3" href="http://www.esklep-os.com" target="_blank">eSklep-Os</a>');

define('ITEMS_IN_CART', 'ilość produktów');
define('NEW_PRODUCTS', 'Nowości');
define('TABLE_HEADING_PRICE', 'Cena');
define('HEADING_PRODUCT_INFO','Informacje o produkcie');
define('ITEM_PRICE','Cena produktu:');
define('HEADING_PRODUCT_REVIEWS','Opinie o produkcie');
define('HEADING_CHOOS_LANG','Wybierz');
define('PRODUCT_INFO_DESCRIPTION','Opis produktu');

//Star product Start
define('STAR_TITLE', 'Nasz Hit'); // star product
define('STAR_READ_MORE', ' ... więcej'); // ... read more.
//Star product End

// Begin EZier new fields
define('TABLE_HEADING_RETAIL_PRICE', 'Cena sugerowana');
define('TABLE_HEADING_SAVE', 'Oszczędzasz'); 
define('TEXT_PRODUCTS_RETAIL_PRICE_INFO', 'Cena katalogowa: ');
define('TEXT_PRODUCTS_PRICE_INFO', 'Nasza cena: ');
define('TEXT_PRODUCTS_PRICE_INFO_REGULAR', '<br>Cena: ');
define('TEXT_PRODUCTS_SAVE_INFO', 'Oszczędzasz: ');
define('TEXT_PRODUCTS_RETAIL_PRICE', 'Cena katalogowa: ');
define('TEXT_PRODUCTS_PRICE_SPECIAL_INFO', '<font color="#C00000">Cena promocyjna: ');
define('TEXT_PRODUCTS_PRICE_SPECIAL_CUST', '<font color="#C00000">Cena z upustem: ');
// EZier new fields end

define('WHATS_NEW_ALL','Zobacz wszystkie');

//themes
define('BOX_HEADING_THEMES', 'Zmień wygląd');

// START: Extra Infopages Manager
define('BOX_HEADING_PAGES', 'Informacje');
// END: Extra Infopages Manager

//BEGIN allprods modification  
define('BOX_INFORMATION_ALLPRODS', 'Katalog produktów');
//END allprods modification

define('ENTRY_NIP_NULL_ERROR', 'Jeżeli podałeś nazwę firmy, to musisz również podać NIP'); 
define('ENTRY_NIP_ERROR', 'Wprowadzono błędny NIP');
define('ENTRY_NIP', 'Numer NIP:');
define('ENTRY_NIP_TEXT', '');

define('IMAGE_BUTTON_PRINT_ORDER', 'Wydruk zamówienia');

//TotalB2B start
define('PRICES_LOGGED_IN_TEXT','Ceny dostępne po zalogowaniu');
//TotalB2B end

//Kontakt Start
define('BOX_HEADING_KONTAKT','Kontakt');
//Kontakt End

// previous next product
define('PREV_NEXT_PRODUCT', 'Produkt');
define('PREV_NEXT_FROM', 'z');
define('PREV_NEXT_IN_CATEGORY', 'w kategorii');

// box text in includes/boxes/advsearch.php
define('BOX_HEADING_ADVSEARCH', 'Szukaj');
define('BOX_ADVSEARCH_KW', '&nbsp;Wyraz(y)');
define('BOX_ADVSEARCH_PRICERANGE', '&nbsp;Cena');
define('BOX_ADVSEARCH_PRICESEP', ' do ');
define('BOX_ADVSEARCH_CAT', '&nbsp;Kategoria');
define('BOX_ADVSEARCH_ALLCAT', 'Dowolna');

//Related Products
define('TABLE_HEADING_RELATED_PRODUCTS', 'Podobne produkty');
define('TEXT_PRICE', 'Cena');

// newsdesk box text in includes/boxes/newsdesk.php
define('TABLE_HEADING_NEWSDESK', 'Aktualności');
define('TEXT_NO_NEWSDESK_NEWS', 'Niestety - brak aktualności');
define('TEXT_NEWSDESK_READMORE', 'czytaj więcej');
define('TEXT_NEWSDESK_VIEWED', 'Przeglądano: ');

define('BOX_HEADING_NEWSDESK_CATEGORIES', 'Kategorie');
define('BOX_HEADING_NEWSDESK_LATEST', 'Aktualności');

define('TEXT_DISPLAY_NUMBER_OF_ARTICLES', 'Wyświetlono <b>%d</b> do <b>%d</b> (z <b>%d</b> aktualności)');
define('TABLE_HEADING_NEWSDESK_SUBCAT', 'Aktualności - Podkategorie');
//END -- newsdesk

//START - GiftWrap
define('TEXT_ENTER_GIFTWRAP_INFORMATION', 'Wybierz opcję pakowania przesyłki');
//END - GiftWrap
//START - Additional Images
define('TEXT_ADDITIONAL_IMAGES', 'Dodatkowe zdjęcia');
//END - Additional Images

//Who's online BOX
define('BOX_HEADING_WHOS_ONLINE', 'Kto jest online');
define('BOX_WHOS_ONLINE_THEREIS', 'Obecnie w sklepie jest');
define('BOX_WHOS_ONLINE_THEREARE', 'Obecnie w sklepie jest');
define('BOX_WHOS_ONLINE_GUEST', 'Gość');
define('BOX_WHOS_ONLINE_GUESTS', 'Gości');
define('BOX_WHOS_ONLINE_AND', 'i');
define('BOX_WHOS_ONLINE_MEMBER', 'Klient');
define('BOX_WHOS_ONLINE_MEMBERS', 'Klienci');
// +Country-State Selector
define ('DEFAULT_COUNTRY', '170');
// -Country-State Selector

// ################# Contribution Newsletter v050 ##############

// subscribers box text in includes/boxes/subscribers.php
define('BOX_HEADING_SUBSCRIBERS', 'Biuletyn');
define('BOX_TEXT_SUBSCRIBE', 'Subskrybcja');
define('BOX_TEXT_UNSUBSCRIBE', 'Rezygnacja');
define('TEXT_EMAIL_HTML','HTML');
define('TEXT_EMAIL_TXT','TXT');
define('TEXT_EMAIL','E-mail:');
define('TEXT_EMAIL_FORMAT','Format');
define('TEXT_EMAIL','Courriel');

define('TEXT_NAME', 'Nazwa:');
// Unsubscribe
define('UNSUBSCRIBE_TEXT','Rezygnacja : ');
define('TEXT_BOX1','Zarejestrowani klienci mogą zarządzać swoimi subskrypcjami: ');
define('TEXT_BOX2','Twoje konto: ');
// ################# Contribution Newsletter v050 ##############

// Sorter for product_info.php
define('PRODUCTS_OPTIONS_SORT_BY_PRICE','0'); // 1= sort by products_options_sort_order + name; 0= sort by products_options_sort_order + price

// Categories Image and Name on product_info.php
define('SHOW_CATEGORIES','0'); // 0= off  1=on

define('TABLE_HEADING_MANUFACTURER', 'Producent');

define('BOX_INFORMATION_SITEMAP', 'Mapa Sklepu');

define('TEMPORARY_NO_PRICE', 'Chwilowy brak ceny');
define('PRODUCT_SOLD', 'Towar sprzedany');

//kgt - discount coupons
define('ENTRY_DISCOUNT_COUPON_ERROR', 'Wprowadzono błędny kod kuponu rabatowego.');
define('ENTRY_DISCOUNT_COUPON_AVAILABLE_ERROR', 'Wprowadzony kod kuponu rabatowego jest błędny.');
define('ENTRY_DISCOUNT_COUPON_USE_ERROR', 'Wprowadzony numer bonu rabatowego został już wykorzystany %s raz(y). Nie możesz używać tego samego kodu więcej niż %s raz(y).');
define('ENTRY_DISCOUNT_COUPON_MIN_PRICE_ERROR', 'Minimalne zamówienie, przy którym mozna skorzystać z kuponu rabatowego wynosi : %s');
define('ENTRY_DISCOUNT_COUPON', 'Wprowadź kod rabatowy:');
define('ENTRY_DISCOUNT_COUPON_FREE_SHIPPING_ERROR', 'Kwota zamówienia nie uprawnia do darmowej przesyłki.');
define('ENTRY_DISCOUNT_COUPON_MIN_QUANTITY_ERROR', 'Minimalna ilość zakupionych towarów uprawniająca do skorzystania z kuponu rabatowego wynosi : %s');
define('ENTRY_DISCOUNT_COUPON_EXCLUSION_ERROR', 'Niektóre z przedmiotów, które masz w koszyku nie są objęte promocją z kuponu rabatowego.' );
define('ENTRY_DISCOUNT_COUPON_SHIPPING_CALC_ERROR', 'Koszt przesyłki został zmieniony.');
//end kgt - discount coupons

define('SHOPPING_CART_QUANTITY', 'szt.');
define('BOX_HEADING_ADVERTISE', 'Reklama');

define('TABLE_HEADING_IMAGE', 'Foto');
define('TABLE_HEADING_MODEL', 'Model');
define('TABLE_HEADING_PRODUCTS', 'Nazwa');
define('TABLE_HEADING_MANUFACTURER', 'Producent');
define('TABLE_HEADING_QUANTITY', 'Produkty');
define('TABLE_HEADING_PRICE', 'Cena');
define('TABLE_HEADING_WEIGHT', 'Waga');
define('TABLE_HEADING_BUY_NOW', 'Koszyk');
define('TEXT_NO_PRODUCTS', 'Brak produktów');
define('TABLE_HEADING_PRODUCTS_AVAILABILITY', 'Dostępność');
define('TEXT_BUY', 'Kup 1 \'');
define('TEXT_NOW', '\' teraz');

define('BOX_SHOPPING_CART_QUANTITY', 'Ilość produktów');
define('BOX_SHOPPING_CART_TOTAL', 'Suma');

define('BOX_HEADING_PLATNOSCI', 'Płatności Online');

// Modlu promocji Polecony-Nagrodzony
define('BOX_HEADING_POLECONY', 'Poleć nasz sklep');
define('BOX_CONTENT_POLECONY', 'Podoba Ci się nasza oferta ? Poinformuj swoich znajomych o naszym sklepie jednym kliknięciem i skorzystaj z naszej promocji');
define('BOX_DESC_POLECONY', 'Polecony - Nagrodzony');
define('BOX_LINK_POLECONY', 'Poleć nasz sklep !');

define('TITLE_PROMOCJA_POLECONY', 'Promocja Polecony-Nagrodzony');
define('ENTRY_EMIAL_POLECAJACY', 'Adres e-mail osoby polecającej:');
define('ENTRY_POLECAJACY_ORDERS_ERROR', 'Osoba polecająca, której adres e-mail podano nie zrealizowała jeszcze w naszym sklepie żadnego zamówienia');

define('RECENTLY_VIEWED_BOX_HEADING','Ostatnio oglądane');   // box heading

define('TEXT_KOMUNIKAT','Komunikat');
define('TEXT_ZAMKNIJ','Zamknij'); 
define('TEXT_UWAGA','UWAGA'); 

// nowe
define('POLA_OBOWIAZKOWE','Pola znaczone * są obowiązkowe do wypełnienia');
define('CATEGORY_OSOBA','Wybór osobowości prawnej');
define('OSOBA_TEXT','Proszę wybrać rodzaj osobowości prawnej nowego użytkownika:');
define('FORM_OSOBA_FIZYCZNA','Osoba fizyczna'); 
define('FORM_OSOBA_PRAWNA',"Firma");
define('ZGODA_DANE_OSOBOWE','Wyrażam zgodę na przetwarzanie moich danych osobowych w celu przedstawiania mi ofert 
		sklepu internetowego ' . STORE_NAME . ', w formie przysyłania Biuletynu na podany 
		przeze mnie adres e-mail, zgodnie z ustawą z dnia 29 sierpnia 1997r. o ochronie danych osobowych (
		tekst.jedn.Dz.U.02.101.926 z póżn.zm).');
define('PRZETWARZANIE_DANYCH','Wyrażam zgodę na przetwarzanie moich danych osobowych w celu realizacji zamówienia 
		przez firmę ' . STORE_OWNER . ' zgodnie z ustawą z dnia 29 sierpnia 1997r. o 
		ochronie danych osobowych (tekst.jedn.Dz.U.02.101.926 z póżn.zm). Oświadczam, że zostałem poinformowany, 
		iż podanie moich danych osobowych ma charakter dobrowolny oraz, że przysługuje mi prawo do wglądu, korekty, 
		usunięcia oraz kontroli swoich danych osobowych. Zlecenie usunięcia danych osobowych może odbyć się poprzez 
		wysłanie zlecenia w formie pisemnej na adres: ' . STORE_NAME_ADDRESS . ', lub droga elektroniczną na adres 
		e-mail: ' . STORE_OWNER_EMAIL_ADDRESS . '.');
define('TABLE_HEADING_DOKUMENT_SPRZEDAZY','Dokument sprzedaży');
define('TEXT_SELECT_DOKUMENT_SPRZEDAZY','Wybierz dokument sprzedaży.');
define('TEXT_PARAGON','Paragon');
define('TEXT_FAKTURA','Faktura VAT');
define('FAKTURA_NIP','(Brak numeru NIP w danych klienta. Brak możliwosci wystawienia faktury.)');

//definicje zwiazane z wyswietlaniem netto/brutto
define('TEXT_NETTO',' (netto)');
define('TEXT_BRUTTO',' (brutto)');

//pozycje menu
define('HEADER_TITLE_HOME','Start');
define('HEADER_TITLE_SPECIALS','Promocje');
define('HEADER_TITLE_SEARCH','Szukaj');
define('HEADER_TITLE_NEWS','Nowości');
define('HEADER_TITLE_CONTACTS','Kontakt');

define('HEADING_NEWSDESK_STICKY' , 'Ważne informacje');

?>