<?php
/*
  $Id:Batch_print.php, hpdl Exp $
*/
define('TEXT_ORDER_NUMBERS_RANGES', 'Numer zamówienia, można wprowadzić pojedynczy numer #, zakres # - #, lub kilka zamówień #,#,#');
define('HEADING_TITLE', 'Drukowanie naklejek adresowych');
define('TEXT_ORDER_FORMAT','F j, Y');
define('TEXT_CHOOSE_TEMPLATE','Wybór szablonu do drukowania');
define('TEXT_CHOOSE_LABEL','Wybór szablonu etykiet - podane szablony są zgodne z etykietami firmy Avery');
define('TEXT_DATES_ORDERS_EXTRACTRED','Wydruk zamówień, których status został zmieniony w okresie:<br>(<i>data w formacie RRRR-MM-DD</i>)');
define('TEXT_FROM','Od:');
define('TEXT_TO','Do: ');
define('TEXT_PRINTING_LABELS_BILLING_DELIVERY','Na etykietach ma zostać wydrukowany adres płatnika czy adres dostawy ?');
define('TEXT_DELIVERY','Dostawy: ');
define('TEXT_BILLING','Płatnika: ');
define('TEXT_POSITION_START_PRINTING_COL', 'Pozycja początkowa wydruku:<br>(<i>1 rozpoczęcie drukowania w pierwszej kolumnie, 2 rozpoczęcie drukowania w drugiej kolumnie, itd.</i>)');
define('TEXT_POSITION_START_PRINTING_ROW', 'Pozycja początkowa wydruku:<br>(<i>1 rozpoczęcie drukowania w pierwszym wierszu, 2 rozpoczęcie drukowania w drugim wierszu, itd.</i>)');
define('TEXT_INCLUDE_ORDERS_STATUS', 'Drukuj naklejki tylko do zamówień z okreslonym statusem:<br>(<i>jeżeli nie wybrano żadnej opcji zostaną wybrane wszystkie zamówienia</i>)');
define('TEXT_AUTOMACILLLY_CHANGE_ORDER','Automatyczna zmiana statusu zamówień po wykonaniu wydruku:<br>(<i>jeżeli nie wybrano żadnej opcji status zamówień nie zostanie zmieniony.</i>)');
define('TEXT_NOTIFY_CUSTOMER','Powiadamianie klientów<br>(<i>jeżeli opcja jest zaznaczona do klientów zostanie wysłane powiadomienie.</i>)');

define('TEXT_OPIS', 'UWAGA : naklejki są drukowane w nastepujący sposób : najpierw pierwsza kolumna, potem druga kolumna, nastepnie ewentualne kolejne kolumny (zależnie od wybranego formatu etykiet). W celu rozpoczęcia wydruku od początku strony nalezy wybrac kolumnę 1 oraz wiersz 1. Jeżeli wydruk ma zostać rozpoczęty, np. od 5 naklejki w pierwszej kolumnie - należy wybrać kolumnę 1 oraz wiersz 5, itd.');

// Change this to a general comment that you would like
define('BATCH_COMMENTS','Automatyczne powiadomienie');
define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Order Update');
define('EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');
define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');
define('EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Your order has been updated to the following status.' . "\n\n" . 'New status: %s' . "\n\n" . 'Please reply to this email if you have any questions.' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'The comments for your order are' . "\n\n%s\n\n");

// Error and Messages
$error['ERROR_INVALID_INPUT'] = 'Błąd: Nierozpoznana komenda.';
$error['ERROR_BAD_DATE'] =  'Błędna data, sprawdź czy wprowadzono datę w poprawnym formacie (0000-00-00).';
$error['ERROR_BAD_INVOICENUMBERS'] =  'Błędny numer zamówienia, wprowadź poprawne dane. (np. 2577,2580-2585,2588)';
$error['NO_ORDERS'] =  'Brak danych do wydruku, zweryfikuj kryteria wyboru.';
$error['SET_PERMISSIONS'] = 'Nie można zapisac do katalogu!  Ustaw poprawne prawa do zapisu 777';
$error['FAILED_TO_OPEN'] = 'Nie mozna otworzyć pliku do zapisu, sprawdź właściwości pliku';

// Batch Print Misc Vars
define('BATCH_PRINT_INC', DIR_WS_MODULES . 'batch_print/');
define('BATCH_PDF_DIR', 'pdf/temp_pdf/');
// Main File
define('BATCH_PRINT_FILE', 'batch_print.php');
?>