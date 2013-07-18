<?php
define('HEADING_TITLE', 'Kategorie / Produkty');
define('HEADING_TITLE_SEARCH', 'Szukaj:');
define('HEADING_TITLE_GOTO', 'Przejdź do:');
define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Kategoria / Produkt');
define('TABLE_HEADING_CATEGORIES_MODEL', 'Model');
define('TABLE_HEADING_ACTION', 'Działanie');
define('TABLE_HEADING_STATUS', 'Stan');
define('TEXT_NEW_PRODUCT', 'Nowy produkt w kategorii &quot;%s&quot;');
define('TEXT_CATEGORIES', 'Kategorie:');
define('TEXT_SUBCATEGORIES', 'Podkategorie:');
define('TEXT_PRODUCTS', 'Produkty:');
define('TEXT_PRODUCTS_PRICE_INFO', 'Cena brutto (z VAT):');
define('TEXT_PRODUCTS_TAX_CLASS', 'Klasa podatku:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'Średnia ocena:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Ilość w magazynie:');
define('TEXT_DATE_ADDED', 'Data dodania:');
define('TEXT_DATE_AVAILABLE', 'Dostępny od dnia:');
define('TEXT_LAST_MODIFIED', 'Ostatnia zmiana:');
define('TEXT_IMAGE_NONEXISTENT', 'OBRAZEK NIE ISTNIEJE');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Dodaj nową kategorię lub produkt w kategorii <br>&nbsp;<br><b>%s</b>');
define('TEXT_PRODUCT_MORE_INFORMATION', 'Więcej informacji o tym produkcie znajdziesz na jego <a href="http://%s" target="blank"><u>stronie www</u></a>.');
define('TEXT_PRODUCT_DATE_ADDED', 'Data dodania produktu do sklepu %s.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'Ten produkt będzie dostępny od dnia: %s.');
define('TEXT_EDIT_INTRO', 'Wprowadź potrzebne zmiany');
define('TEXT_EDIT_CATEGORIES_ID', 'ID kategorii:');
define('TEXT_EDIT_CATEGORIES_NAME', 'Nazwa kategorii:');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Obrazek kategorii:');
define('TEXT_EDIT_SORT_ORDER', 'Numer do sortowania:');
define('TEXT_INFO_COPY_TO_INTRO', 'Wybierz nową kategorię do której chciałbyś skopiować ten produkt');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Obecna kategoria:');
define('TEXT_INFO_HEADING_NEW_CATEGORY', 'Nowa kategoria');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Edytuj kategorię');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Usuń kategorię');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Przenieś kategorię');
define('TEXT_INFO_HEADING_DELETE_PRODUCT', 'Usuń produkt');
define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Przenieś produkt');
define('TEXT_INFO_HEADING_COPY_TO', 'Skopiuj do');
define('TEXT_DELETE_CATEGORY_INTRO', 'Czy na pewno chces usunąć tą kategorię?');
define('TEXT_DELETE_PRODUCT_INTRO', 'Czy na pewno chcesz całkowicie usunąć ten produkt?');
define('TEXT_DELETE_WARNING_CHILDS', '<b>UWAGA:</b> Istnieje %s (pod-)kategorii wciąż powiązanych z tą kategorią!');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>UWAGA:</b> Istnieje %s produktów wciąż powiązanych z tą kategorią!');
define('TEXT_MOVE_PRODUCTS_INTRO', 'Wybierz kategorię w której produkt <b>%s</b> ma się znajdować');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Wybierz kategorię w której kategoria <b>%s</b> ma się znajdować');
define('TEXT_MOVE', 'Przenieś <b>%s</b> do:');
define('TEXT_NEW_CATEGORY_INTRO', 'Podaj następujące informacje dla nowej kategorii');
define('TEXT_CATEGORIES_NAME', 'Nazwa kategorii:');
define('TEXT_CATEGORIES_IMAGE', 'Obrazek kategorii:');
define('TEXT_SORT_ORDER', 'Numer do sortowania:');
define('TEXT_PRODUCTS_STATUS', 'Stan produktu:');
define('TEXT_PRODUCTS_DATE_AVAILABLE', 'Dostępny od dnia:');
define('TEXT_PRODUCT_AVAILABLE', 'Na składzie');
define('TEXT_PRODUCT_NOT_AVAILABLE', 'Wyprzedany');
define('TEXT_PRODUCTS_MANUFACTURER', 'Producent:');
define('TEXT_PRODUCTS_NAME', 'Nazwa produktu:');
define('TEXT_PRODUCTS_DESCRIPTION', 'Opis:');
define('TEXT_PRODUCTS_SHORT_DESCRIPTION', 'Krótki opis:');
define('TEXT_PRODUCTS_QUANTITY', 'Ilość w magazynie:');
define('TEXT_PRODUCTS_MODEL', 'Numer katalogowy:');
define('TEXT_PRODUCTS_IMAGE', 'Zdjęcie produktu:');
define('TEXT_PRODUCTS_URL', 'Adres URL:');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '<small>(bez http://)</small>');
define('TEXT_PRODUCTS_PRICE_NET', 'Nasza cena Netto:');
define('TEXT_PRODUCTS_PRICE_GROSS', 'Nasza cena Brutto:');
define('TEXT_PRODUCTS_WEIGHT', 'Waga:');
define('EMPTY_CATEGORY', 'Pusta kategoria');
define('TEXT_HOW_TO_COPY', 'Sposób kopiowania:');
define('TEXT_COPY_AS_LINK', 'Powiąż');
define('TEXT_COPY_AS_DUPLICATE', 'Duplikuj produkt');
define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Błąd: Nie mogę powiązać produktów w tej samej kategorii.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Błąd: Brak uprawnień do zapisu w katalogu ze zdjęciami/obrazkami: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Błąd: Katalog na zdjęcia/obrazki nie istnieje: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CANNOT_MOVE_CATEGORY_TO_PARENT', 'Błąd: Kategoria nie może być przeniesiona do własnej podkategorii.');
define('TEXT_PRODUCTS_AVAILABILITY', 'Produkt dostępny:');
// EZier new fields
define('TEXT_PRODUCTS_RETAIL_PRICE', 'Sugerowana cena producenta :');
define('TEXT_PRODUCTS_RETAIL_PRICE_NET', 'Sugerowana cena producenta netto :');
define('TEXT_PRODUCTS_RETAIL_PRICE_GROSS', 'Sugerowana cena producenta brutto :');
define('TEXT_PRODUCTS_RETAIL_PRICE_INFO','Cena producenta netto :');
//EZier new fields end
define('TEXT_IMAGE_DIRECTORY', 'Katalog obrazków:'); // name of subdir field
define('TEXT_IMAGE_PATH_NOTE' , 'images/'); // note under image subdir name
define('TEXT_IMAGE_PATH_CHECKBOX' , 'Utworzyć katalog ?'); // checkbox next to image subdir name
//Attributes Editor
define('TEXT_PRODUCTS_OPTIONS', 'Dostępne opcje');
define('TEXT_PRODUCTS_ATRIBUTES', 'Opcje produktu');
//Attributes Editor
//TotalB2B
define('ENTRY_PRODUCTS_PRICE', 'Cena nr : ');
define('TEXT_PRODUCTS_PRICE_PODST', '<b>Podstawowa cena produktu</b>');
define('TEXT_PRODUCTS_PRICE_EXT', '<b>Dodatkowe ceny produktu</b>');
define('ENTRY_PRODUCTS_PRICE_DISABLED','Nie ustawiona');
//TotalB2B
//Additional Images
define('TEXT_INFO_HEADING_NEW_IMAGES', 'Dodatkowe obrazki');
define('TEXT_NEW_IMAGES_INTRO', 'Dodatkowe obrazki do opisu produktu.');
define('TEXT_DEL_IMAGES_INTRO', 'Zaznacz obrazki, które chcesz usunąć');    
define('TEXT_PRODUCTS_IMAGES_NEW', 'Nowy obrazek');    
define('TEXT_PRODUCTS_IMAGES_NEWPOP', 'Plik obrazka');
define('TEXT_PRODUCTS_IMAGES_DESC', 'Opis obrazka');
define('ERROR_ADDITIONAL_IMAGE_IS_EMPTY', 'Błąd: Nie wybrano obrazka ');
define('ERROR_DEL_IMG_XTRA','Błąd: Nie można usunąć obrazka ');
define('SUCCESS_DEL_IMG_XTRA','Obrazek został usunięty: ');
//SECTION:    REAL MAIN POPUP IMAGE
define('TEXT_PRODUCTS_IMAGE_POP', 'Popup Image:');
//SECTION:    DELETE POPUP IMAGE
//Additional Images
// header_tags_controller text 
define('TEXT_PRODUCT_METTA_INFO', '<b>Informacje Meta w sekcji HEAD</b>');
define('TEXT_PRODUCTS_PAGE_TITLE', 'Tytuł strony produktu:');
define('TEXT_PRODUCTS_HEADER_DESCRIPTION', 'Opis strony produktu:');
define('TEXT_PRODUCTS_KEYWORDS', 'Słowa kluczowe:');
define('HEADER_TAGS_CATEGORY_TITLE', 'Meta Tagi - Kategoria Tytuł:');
define('HEADER_TAGS_CATEGORY_DESCRIPTION', 'Meta Tagi - Kategoria Opis:');
define('HEADER_TAGS_CATEGORY_KEYWORDS', 'Meta Tagi - Kategoria Słowa kluczowe:');
define('CATEGORY_DESCRIPTION', 'Opis kategorii:');
// Begin Mini Images //-->
define('TABLE_HEADING_IMAGE', 'Obrazek');
// End Mini Images //-->
define('TEXT_PRODUCTS_MAXIMUM','Maksymalna ilość jednorazowo zakupionych produktów:'); //MAXIMUM quantity code

define('TEXT_PRODUCTS_DESCRIPTION_BASELINK','Opis alternatywny');

define('TEXT_PRODUCTS_PRICE_NINFO', 'Cena netto (bez VAT):');
define('TEXT_PRODUCTS_PRICE_SINFO', 'Cena promocyjna: (z VAT):');

define('TEXT_PRODUCTS_ADMIN_NOTES', 'Notatki właściciela: <br><i>tutaj można zapisać notatki właściciela dotyczące produktu.<br>Nie będą on widoczne dla klientów sklepu.</i>');

define('TEXT_PRODUCTS_SEO_URL', 'Produkty własny adres URL:');
define('TEXT_EDIT_CATEGORIES_SEO_URL', 'Nazwa kategorii do wyświetlenia:');
define('TEXT_CATEGORIES_SEO_URL', 'Kategorie własny adres URL:');

// BOF Enable - Disable Categories Contribution--------------------------------------
define('TEXT_EDIT_STATUS', 'Status');
// EOF Enable - Disable Categories Contribution--------------------------------------

define('TEXT_PRODUCTS_JM', 'Jednostka miary:');
// start indvship
define('TEXT_PRODUCTS_ZIPCODE', 'Kod Pocztowy');
define('INDIV_SHIPPING_PRICE', 'Koszt wysyłki');
define('EACH_ADDITIONAL_PRICE', 'Koszt dodatkowego produktu');
// stop indivship
?>