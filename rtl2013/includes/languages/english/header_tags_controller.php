<?php
define('HEADING_TITLE_CONTROLLER', 'Edytor Meta Tagów');
define('HEADING_TITLE_ENGLISH', 'Edytor Meta Tagów - Edycja stron');
define('HEADING_TITLE_FILL_TAGS', 'Edytor Meta Tagów - wypełnianie pól');
define('TEXT_INFORMATION_ADD_PAGE', '<b>Dodanie nowej strony</b> - Opcja umożliwia zdefiniowanie stron zawierających indywidualne meta tagi. W celu wprowadzenia ustawień dla wybranej strony należy wpisać nazwę pliku, w którym jest ona zdefiniowana z lub bez rozszerzenia .php. Np. Jeżeli indywidualne ustawienia mają dotyczyć strony Kontakt z nami - należy w polu Nazwa strony wpisać contact_us.php i wypełnić pozostałe pola meta.');
define('TEXT_INFORMATION_DELETE_PAGE', '<b>Usunięcie strony</b> - Opcja usuwa indywidualne wpisy meta dla wybranej strony. Po usunięciu - na stronie będą wyświetlane domyślne meta tagi zdefiniowane dla całego serwisu'); 
define('TEXT_INFORMATION_CHECK_PAGES', '<b>Sprawdzenie stron</b> - Opcja sprawdza, które strony w sklepie nie posiadają zdefiniowanych indywidualnych wpisów meta. UWAGA - nie wszystkie strony powinny mieć takie wpisy. Np. strony używające połączeń SSL (Login, Zakładanie konta). W celu przejrzenia stron kliknij Aktualizuj, a następnie przejrzyj rozwijaną listę.'); 
define('TEXT_PAGE_TAGS', 'Edytor Meta Tagów umożliwia zdefiniowanie znaczników meta dla każdej podstrony sklepu osobno. Informacje o tagach dla każdej strony zapisywane są w dwóch plikach : includes/header_tags.php oraz includes/languages/nazwa_jezyka/header_tags.php (gdzie katalog nazwa_jezyka jest katalogiem domyślnego języka serwisu). Opcje zawarte na tej stronie pozwalają na dodawanie, usuwanie oraz sprawdzanie plików zawierających indywidualne definicje meta tagów.');
define('TEXT_ENGLISH_TAGS', 'Głównym celem stosowania Edytora Meta Tagów jest umożliwienie użytkownikowi zdefiniowania dla każdej strony sklepu indywidualnych wpisów meta w celu uzyskania jak najwyższych pozycji w wyszukiwarkach internetowych. Jeżeli strona nie ma zdefiniowanych indywidualnych wpisów meta, stosowane są na niej wpisy domyślne.');
define('TEXT_FILL_TAGS', 'Opcja umożliwia automatyczne wypełnienie pól meta w tablicach kategorii i produktów wartościami domyślnymi.');
// header_tags_controller.php & header_tags_english.php
define('HEADING_TITLE_CONTROLLER_EXPLAIN', '(Pomoc)');
define('HEADING_TITLE_CONTROLLER_TITLE', 'Tytuł:');
define('HEADING_TITLE_CONTROLLER_DESCRIPTION', 'Opis:');
define('HEADING_TITLE_CONTROLLER_KEYWORDS', 'Słowa kluczowe:');
define('HEADING_TITLE_CONTROLLER_PAGENAME', 'Nazwa strony:');
define('HEADING_TITLE_CONTROLLER_PAGENAME_ERROR', 'Strona już została wprowadzona -> ');
define('HEADING_TITLE_CONTROLLER_PAGENAME_INVALID_ERROR', 'Blędna nazwa strony -> ');
define('HEADING_TITLE_CONTROLLER_NO_DELETE_ERROR', 'Usunięcie %s jest niemożliwe');

// header_tags_english.php
define('HEADING_TITLE_CONTROLLER_DEFAULT_TITLE', 'Domyślny tytuł:');
define('HEADING_TITLE_CONTROLLER_DEFAULT_DESCRIPTION', 'Domyślny opis:');
define('HEADING_TITLE_CONTROLLER_DEFAULT_KEYWORDS', 'Domyślne słowa kluczowe:');

// header_tags_fill_tags.php
define('HEADING_TITLE_CONTROLLER_CATEGORIES', 'KATEGORIE');
define('HEADING_TITLE_CONTROLLER_MANUFACTURERS', 'PRODUCENCI');
define('HEADING_TITLE_CONTROLLER_PRODUCTS', 'PRODUKTY');
define('HEADING_TITLE_CONTROLLER_SKIPALL', 'Pomiń wszystkie tagi');
define('HEADING_TITLE_CONTROLLER_FILLONLY', 'Wypełnij tylko puste tagi');
define('HEADING_TITLE_CONTROLLER_FILLALL', 'Wypełnij wszystkie tagi');
define('HEADING_TITLE_CONTROLLER_CLEARALL', 'Wyczyść wszystkie tagi');
define('HEADING_TITLE_CONTROLLER_SWITCHES', 'Opcje:');
define('HEADING_TITLE_CONTROLLER_LANGUAGE', 'Język:');

define('HEADING_TITLE_CONTROLLER_FILL_DESC','Czy wypełnić pola meta zawartością opisu towarów ?');
define('HEADING_TITLE_CONTROLLER_FILL_LIMIT','Ograniczenie do ');
define('HEADING_TITLE_CONTROLLER_FILL_WORDS',' znaków');

define('TEXT_CHARACTERS', 'znaków.');
define('TEXT_FILL_WITH_DESCIPTION', 'Czy wypelniać meta Description opisem produktu ?');
define('TEXT_LANGUAGE', 'Język:');
define('TEXT_LIMIT_TO', 'Ograniczenie do');
define('TEXT_NO', 'Nie');
define('TEXT_YES', 'Tak');

?>