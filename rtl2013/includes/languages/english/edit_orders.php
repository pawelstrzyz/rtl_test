<?php
define('HEADING_TITLE', 'Edytor zamówień');
define('HEADING_TITLE_NUMBER', 'Nr.');
define('HEADING_TITLE_DATE', 'z');
define('HEADING_SUBTITLE', 'Po edycji potrzebnych danych wcisnij przycisk "Aktualizuj".');
define('HEADING_TITLE_SEARCH', 'Nr zamówienia:');
define('HEADING_TITLE_STATUS', 'Status:');
define('ADDING_TITLE', 'Dodaj produkt do zamówienia');

define('HINT_UPDATE_TO_CC', 'Uwaga: Ustawienie płatności kartą kredytową spowoduje wyświetlenie dodatkowych pól.');
define('HINT_DELETE_POSITION', 'Uwaga: Aby usunąć produkt z zamówienia ustaw ilość na "0".');
define('HINT_TOTALS', 'Możesz udzielić niestandardowej zniżki wpisując w wolne pole ujemną wartość udzielonej zniżki (np. -50.00). Pola z wpisaną wartością 0 będą usunięte podczas aktualizacji. (z wyjątkiem kosztów dostawy).');
define('HINT_PRESS_UPDATE', 'Zapisz zmiany.');

define('HINT_UPDATE_TO_CC2', ' Pozostałe pola zostaną wyświetlone automatycznie.');
define('HINT_PRODUCTS_PRICES', 'Cena i waga są wyliczane automatycznie. Jeżeli chcesz usunąć produkt, zaznacz pole i wciśnij przycisk aktualizuj. Pole waga nie podlega edycji.');
define('HINT_SHIPPING_ADDRESS', 'UWAGA: zmiana adresu dostawy może spowodować zmianę strefy podatkowej.');
define('HINT_TOTALS', 'Feel free to give discounts by adding negative values. Any field with a value of 0 is deleted when updating the order (exception: shipping).  Weight, subtotal, tax total, and total fields are not editable. On-the-fly calculations are estimates; small rounding differences are possible after updating.');
define('HINT_PRESS_UPDATE', 'Przycisk "Aktualizuj" zachowa wykonane zmiany.');
define('HINT_BASE_PRICE', 'Cena (podstawowa) - nie uwzględnia dodatkowych opcji');
define('HINT_PRICE_EXCL', 'Cena netto - Cena uwzględniająca dodatkowe opjce.');
define('HINT_PRICE_INCL', 'Cena vrutto - Cena uwzględniająca dodatkowe opjce.');
define('HINT_TOTAL_EXCL', 'Wartość netto - cena jednostkowa razy ilość produktów');
define('HINT_TOTAL_INCL', 'Wartość brutto - cena jednostkowa razy ilość produktów');

define('TABLE_HEADING_COMMENTS', 'Komentarz');
define('TABLE_HEADING_CUSTOMERS', 'Klienci');
define('TABLE_HEADING_ORDER_TOTAL', 'Suma zamówienia');
define('TABLE_HEADING_DATE_PURCHASED', 'Data zamówienia');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Akcja');
define('TABLE_HEADING_QUANTITY', 'Ilość');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Nr katalogowy');
define('TABLE_HEADING_PRODUCTS_WEIGHT', 'Waga');
define('TABLE_HEADING_PRODUCTS', 'Produkt');
define('TABLE_HEADING_TAX', 'Vat %');
define('TABLE_HEADING_BASE_PRICE', 'Cena (podstawowa)');
define('TABLE_HEADING_TOTAL', 'Razem');
define('TABLE_HEADING_UNIT_PRICE', 'Cena netto');
define('TABLE_HEADING_UNIT_PRICE_TAXED', 'Cena brutto');
define('TABLE_HEADING_TOTAL_PRICE', 'Wartość netto');
define('TABLE_HEADING_TOTAL_PRICE_TAXED', 'Wartość brutto');
define('TABLE_HEADING_TOTAL_MODULE', 'Elementy zamówienia');
define('TABLE_HEADING_TOTAL_AMOUNT', 'Suma netto');
define('TABLE_HEADING_TOTAL_WEIGHT', 'Waga całkowita: ');
define('TABLE_HEADING_PRODUCTS_STOCK', 'Stan');

define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Czy klient jest poinformowany');
define('TABLE_HEADING_DATE_ADDED', 'Data zmiany');
define('ENTRY_CUSTOMER', 'Dane klienta');
define('ENTRY_CUSTOMER_NAME', 'Nazwa');
define('ENTRY_CITY_STATE', 'Miejscowość, Województwo:');
define('ENTRY_CUSTOMER_COMPANY', 'Nazwa firmy');
define('ENTRY_CUSTOMER_ADDRESS', 'Adres klienta');
define('ENTRY_ADDRESS', 'Adres');
define('ENTRY_CUSTOMER_SUBURB', 'Płeć');
define('ENTRY_CUSTOMER_CITY', 'Miasto');
define('ENTRY_CUSTOMER_STATE', 'Województwo');
define('ENTRY_CUSTOMER_POSTCODE', 'Kod pocztowy');
define('ENTRY_CUSTOMER_COUNTRY', 'Kraj');
define('ENTRY_CUSTOMER_PHONE', 'Telefon');
define('ENTRY_CUSTOMER_EMAIL', 'E-Mail');
define('ENTRY_SOLD_TO', 'Kupujący:');
define('ENTRY_DELIVERY_TO', 'Miejsce dostawy:');
define('ENTRY_SHIP_TO', 'Adres dostawy:');
define('ENTRY_SHIPPING_ADDRESS', 'Adres dostawy');
define('ENTRY_BILLING_ADDRESS', 'Adres płatnika');
define('ENTRY_PAYMENT_METHOD', 'Sposób płatności:');
define('ENTRY_CREDIT_CARD_TYPE', 'Rodzaj karty:');
define('ENTRY_CREDIT_CARD_OWNER', 'Właściciel karty:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Numer karty:');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Data ważności karty:');
define('ENTRY_SUB_TOTAL', 'Podsuma:');
define('ENTRY_TAX', 'Vat:');
define('ENTRY_SHIPPING', 'Dostawa:');
define('ENTRY_TOTAL', 'Razem:');
define('ENTRY_DATE_PURCHASED', 'Data zamówienia:');
define('ENTRY_STATUS', 'Status zamówienia:');
define('ENTRY_DATE_LAST_UPDATED', 'Ostatnia modyfikacja:');
define('ENTRY_NOTIFY_CUSTOMER', 'Powiadomienie klienta:');
define('ENTRY_NOTIFY_COMMENTS', 'Wyślij komentarz:');
define('ENTRY_PRINTABLE', 'Wydruk zamówienia');
define('TEXT_INFO_HEADING_DELETE_ORDER', 'Kasuj zamówienie');
define('TABLE_HEADING_DELETE', 'Usunąć?');
define('TABLE_HEADING_SHIPPING_TAX', 'VAT za przesyłkę: ');

define('TEXT_INFO_DELETE_INTRO', 'Czy napewno usunąć zamówienie ?');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Aktualizowanie stanów');
define('TEXT_DATE_ORDER_CREATED', 'Utworzone:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Ostatnia modyfikacja:');
define('TEXT_DATE_ORDER_ADDNEW', 'Dodaj nowy produkt');
define('TEXT_INFO_PAYMENT_METHOD', 'Sposób płatności:');
define('TEXT_ALL_ORDERS', 'Wszystkie zamówienia');
define('TEXT_NO_ORDER_HISTORY', 'Nie znaleziono zamówienia');
define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Status Twojego zamówienia został zmieniony');
define('EMAIL_TEXT_ORDER_NUMBER', 'Numer zamówienia:');
define('EMAIL_TEXT_INVOICE_URL', 'Szczegóły zamówienia:');
define('EMAIL_TEXT_DATE_ORDERED', 'Data zamówienia:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Został zmieniony stan Twojego zamówienia.' . "\n\n" . 'Nowy status: %s' . "\n\n");
define('EMAIL_TEXT_STATUS_UPDATE2', 'Zespół obsługi sklepu internetowego' . "\n" . STORE_NAME . "\n\n" . 
'Jeżeli masz jakiekolwiek pytania odpowiedz na ten email.' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Komentarz do zamówienia:' . "\n\n%s\n\n");
define('ERROR_ORDER_DOES_NOT_EXIST', 'Błąd: Brak zamówienia.');
define('SUCCESS_ORDER_UPDATED', 'Ukończono: Zamówienie zostało zmienione.');
define('WARNING_ORDER_NOT_UPDATED', 'Uwaga: żadne zmiany nie zostały wprowadzone.');
define('ADDPRODUCT_TEXT_CATEGORY_CONFIRM', 'OK');
define('ADDPRODUCT_TEXT_SELECT_PRODUCT', 'Wybierz produkt');
define('ADDPRODUCT_TEXT_PRODUCT_CONFIRM', 'OK');
define('ADDPRODUCT_TEXT_SELECT_OPTIONS', 'Wybierz opcję');
define('ADDPRODUCT_TEXT_OPTIONS_CONFIRM', 'OK');
define('ADDPRODUCT_TEXT_OPTIONS_NOTEXIST', 'Produkt nie posiada opcji...');
define('ADDPRODUCT_TEXT_CONFIRM_QUANTITY', 'Ilość sztuk');
define('ADDPRODUCT_TEXT_CONFIRM_ADDNOW', 'Dodaj');
define('ADDPRODUCT_TEXT_STEP', 'Krok');
define('ADDPRODUCT_TEXT_STEP1', ' « Wybierz kategorię. ');
define('ADDPRODUCT_TEXT_STEP2', ' « Wybierz produkt. ');
define('ADDPRODUCT_TEXT_STEP3', ' « Wybierz opcję. ');
define('MENUE_TITLE_CUSTOMER', '1. Dane klienta');
define('MENUE_TITLE_PAYMENT', '2. Sposób płatności');
define('MENUE_TITLE_ORDER', '3. Zamówione towary');
define('MENUE_TITLE_TOTAL', '4. Rabaty i dostawa');
define('MENUE_TITLE_STATUS', '5. Status i powiadomienia');
define('MENUE_TITLE_UPDATE', '6. Zmiana danych');

//add-on for downloads
define('ENTRY_DOWNLOAD_COUNT', 'Download #');
define('ENTRY_DOWNLOAD_FILENAME', 'Nazwa pliku');
define('ENTRY_DOWNLOAD_MAXDAYS', 'Data wygaśnięcia');
define('ENTRY_DOWNLOAD_MAXCOUNT', 'Ilość pobrań');

define('TEXT_SHIPPING_SAME_AS_BILLING', 'Adres dostawy jak adres zamawiającego');
define('TEXT_BILLING_SAME_AS_CUSTOMER', 'Adres płatnika jak adres zamawiającego');

// pull down default text
define('PLEASE_SELECT', 'Wybierz');
define('TYPE_BELOW', 'Type Below');
?>