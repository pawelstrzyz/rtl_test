<?php
//quick_attributes_popup.php text
define('HEADING_TITLE_ATTRIBUTES_POPUP', 'Bieżace cechy');
define('TEXT_NO_CURRENT_ATTRIBUTES', 'BRAK CECH DLA PRODUKTU  ...');
define('TEXT_CURRENT_ATTRIBUTES', 'BIEŻĄCE CECHY:');
define('TEXT_MODEL', 'Model: ');
define('TEXT_CURRENT_ID', 'Bieżący ID# ');
define('TEXT_CLOSE_WINDOW', 'Zamknij okno');

//quick_products_popup.php text

define('HEADING_TITLE_PRODUCTS_POPUP', 'Lista produktów');
define('TEXT_QUICK_PRODUCT_LOCATOR', 'Wyszukiwanie ID produktów');
define('TEXT_ALL_CATEGORIES', 'Wszystkie kategorie: ');
define('TEXT_CLICK_TO', 'Kliknij aby: ');
define('TEXT_SHOW_ATTRIBUTES', 'wyświetlić cechy');

//categories.php text 

define('TEXT_ACTIVE_ATTRIBUTES','Dostępne cechy');
define('TEXT_PREFIX','Prefix');
define('TEXT_PRICE','Cena');
define('TEXT_SORT_ORDER','Kolejność');
//KIKOLEPPARD add

// Turn things off
define('I_AM_OFF',true);

// WebMakers.com Added: Attribute Copy Option
define('TEXT_COPY_ATTRIBUTES_ONLY','Kopiowanie cech produktu ...');
define('TEXT_COPY_ATTRIBUTES','Czy skopiować cechy produktu do duplikatu ?');
define('TEXT_COPY_ATTRIBUTES_YES','Tak');
define('TEXT_COPY_ATTRIBUTES_NO','Nie');

//KIKOLEPPARD add
define('TEXT_COPY_ATTRIBUTES_TO_CATEGORY','Kopiowanie cech produktu dla całej kategorii ...');
define('TEXT_COPY_ATTRIBUTES_FROM_PRODUCT_ID','Kopiowanie cech dla całej kategorii<br>Wprowadź ID produktu z którego mają  być kopiowane cechy');
define('TEXT_COPY_ATTRIBUTES_FROM','Kopiowanie cech produktu #');
define('TEXT_COPY_ATTRIBUTES_TO','Kopiuj cechy do #');
define('TEXT_COPY_ATTRIBUTES_IN_CATEGORY_ID','Kopiowanie cech do wszystkich produktów w kategorii ID');
define('TEXT_CATEGORY_NAME','Kategoria : ');
define('TEXT_DELETE_ATTRIBUTES_AND_DOWNLOADS','Usunięcie wszystkich cech w produkcie docelowym przed skopiowaniem');
define('TEXT_OTHERWISE','Jeżeli nie usunięto cech w produkcie docelowym to : ');
define('TEXT_DUPLICATE_ATTRIBUTES_SKIPPED','Pomiń zduplikowane cechy ');
define('TEXT_DUPLICATE_ATTRIBUTES_OVERWRITTEN','Nadpisz zduplikowane cechy ');
define('TEXT_COPY_ATTRIBUTES_WITH_DOWNLOADS','Kopiowanie cech');
define('TEXT_COPY_ATTRIBUTES','Kopiuj cechy');
define('TEXT_COPY_ATTRIBUTES_TO_ANOTHER_PRODUCT','Kopiuj cechy do innego produktu');
define('TEXT_ALL_PRODUCTS_CATEGORY','WSZYSTKICH produktów w kategorii : ');
define('TEXT_SELECT_CATEGORY_COPY_ATTRIBUTES','Wybierz kategorię, aby skopiować cechy prfoduktów');
define('TEXT_PRODUCTS_ATTRIBUTES_COPIER','Kopiowanie cech produktu:');
define('TEXT_SELECT_PRODUCT_DISPLAY_ATTRIBUTES','Wybierz produkt');
define('TEXT_SELECT_PRODUCT_DISPLAY','Wybierz produkt do wyświetlenia');

//for pop-up windows
define('TEXT_PRODUCT_ID_LOOK_UP','[ ID# Przeglądanie produktów ]');
define('TEXT_QIUCK_LIST_ATTRIBUTES','Lista cech produktu ID# ');

//for webmarkers_added_functions.php
define('TEXT_NO_COPY',' ... Nie wykonano kopiowania');
define('TEXT_WARNING_CANNOT_COPY','UWAGA: Nie można wykonać kopiowania z produktu ID #');
define('TEXT_WARNING_NO_ATTRIBUTES','UWAGA: Brak cech produktu ID #');
define('TEXT_WARNING_THERE_IS_NO','UWAGA: Brak produktu ID #');
define('TEXT_TO_PRODUCT_ID',' do produktu ID # ');
define('TEXT_FOR',' dla: ');
//KIKOLEPPARD add

// WebMakers.com Added: Attributes Copy from Existing Product to Existing Product
define('PRODUCT_NAMES_HELPER','<FONT COLOR="FF0000"><a href="' . 'quick_products_popup.php' . '" onclick="NewWindow(this.href,\'name\',\'700\',\'500\',\'yes\');return false;">' . TEXT_PRODUCT_ID_LOOK_UP . '</a>');
define('ATTRIBUTES_NAMES_HELPER','<FONT COLOR="FF0000"><a href="' . 'quick_attributes_popup.php?look_it_up=' . $pID . '&my_languages_id=' . $languages_id . '" onclick="NewWindow2(this.href,\'name2\',\'700\',\'400\',\'yes\');return false;">[ ' . TEXT_QIUCK_LIST_ATTRIBUTES . $pID . ' ]</a>');
?>