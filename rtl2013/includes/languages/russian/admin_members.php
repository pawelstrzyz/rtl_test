<?php
if ($HTTP_GET_VARS['gID']) {
  define('HEADING_TITLE', 'Konta Administratorów');
} elseif ($HTTP_GET_VARS['gPath']) {
  define('HEADING_TITLE', 'Definiowanie grup');
} else {
  define('HEADING_TITLE', 'Konta Administratorów');
}
define('TEXT_COUNT_GROUPS', 'Groups: ');
define('TABLE_HEADING_NAME', 'Nazwa');
define('TABLE_HEADING_EMAIL', 'Adres Email');
define('TABLE_HEADING_PASSWORD', 'Hasło');
define('TABLE_HEADING_CONFIRM', 'Potwierdź hasło');
define('TABLE_HEADING_GROUPS', 'Grupa');
define('TABLE_HEADING_CREATED', 'Konto utworzone');
define('TABLE_HEADING_MODIFIED', 'Konto zmodyfikowane');
define('TABLE_HEADING_LOGDATE', 'Ostatni dostęp');
define('TABLE_HEADING_LOGNUM', 'Ilość logowań');
define('TABLE_HEADING_LOG_NUM', 'Log Number');
define('TABLE_HEADING_ACTION', 'Akcja');
define('TABLE_HEADING_GROUPS_NAME', 'Nazwa grupy');
define('TABLE_HEADING_GROUPS_DEFINE', 'Wybór modułów i funkcji');
define('TABLE_HEADING_GROUPS_GROUP', 'Poziom');
define('TABLE_HEADING_GROUPS_CATEGORIES', 'Kategorie uprawnień');
define('TEXT_INFO_HEADING_DEFAULT', 'Konta użytkowników ');
define('TEXT_INFO_HEADING_DELETE', 'Usuwanie uprawnień ');
define('TEXT_INFO_HEADING_EDIT', 'Edycja kategorii / ');
define('TEXT_INFO_HEADING_NEW', 'Nowy użytkownik ');
define('TEXT_INFO_HEADING_EDIT_GROUP','Grupa użytkowników');
define('TEXT_INFO_DEFAULT_INTRO', 'Grupa użytkowników');
define('TEXT_INFO_DELETE_INTRO', 'Usunąć <nobr><b>%s</b></nobr> z <nobr>grupy użytkowników ?</nobr>');
define('TEXT_INFO_DELETE_INTRO_NOT', 'Nie można usunąć użytkownika <nobr>%s użytkownika !</nobr>');
define('TEXT_INFO_EDIT_INTRO', 'Ustaw poziom uprawnień: ');
define('TEXT_INFO_EDIT_GROUP_INTRO', 'Wpisz nazwę grupy użytkowników: ');
define('TEXT_INFO_FULLNAME', 'Nazwa: ');
define('TEXT_INFO_FIRSTNAME', 'Imię: ');
define('TEXT_INFO_LASTNAME', 'Nazwisko: ');
define('TEXT_INFO_EMAIL', 'Adres Email: ');
define('TEXT_INFO_PASSWORD', 'Hasło: ');
define('TEXT_INFO_CONFIRM', 'Potwierdź hasło: ');
define('TEXT_INFO_CREATED', 'Konto utworzono: ');
define('TEXT_INFO_MODIFIED', 'Konto modyfikowano: ');
define('TEXT_INFO_LOGDATE', 'Ostatni dostęp: ');
define('TEXT_INFO_LOGNUM', 'Ilość logowań: ');
define('TEXT_INFO_GROUP', 'Grupa uprawnień: ');
define('TEXT_INFO_ERROR', '<font color="red">Taki adres email jest już używany! Spróbuj wpisać inny.</font>');
define('JS_ALERT_FIRSTNAME', '- Wymagane: Imię \n');
define('JS_ALERT_LASTNAME', '- Wymagane: Nazwisko \n');
define('JS_ALERT_EMAIL', '- Wymagane: Adres Email \n');
define('JS_ALERT_EMAIL_FORMAT', '- Błędny format adresu e-mail ! \n');
define('JS_ALERT_EMAIL_USED', '- Taki adres e-mail jest już używany ! \n');
define('JS_ALERT_LEVEL', '- Wymagane: Grupa użytkowników \n');
define('ADMIN_EMAIL_SUBJECT', 'Nowy użytkownik');
define('ADMIN_EMAIL_TEXT', 'Witaj %s,' . "\n\n" . 'Twoje dane został zmienione przez Administratora. Podczas pierwszego logowania proszę zmienić hasło dostępu!' . "\n\n" . 'Strona : %s' . "\n" . 'Nazwa użytkownika: %s' . "\n" . 'Hasło: %s' . "\n\n" . 'Dziękujemy ' . "\n" . '%s' . "\n\n" . 'Ta wiadomość została wygenerowana automatycznie. Prosimy na nią nie odpowiadać !');
define('ADMIN_EMAIL_EDIT_TEXT', 'Hi %s,' . "\n\n" . 'Twoje hasło do panelu administracyjnego zostało zmienione.' . "\n\n" . 'Strona : %s' . "\n" . 'Nazwa użytkownika : %s' . "\n" . 'Hasło : %s' . "\n\n" . 'Dziękujemy !' . "\n" . '%s' . "\n\n" . 'Ta wiadomość została wygenerowana automatycznie. Prosimy na nią nie odpowiadać !');
define('ADMIN_EMAIL_EDIT_SUBJECT', 'Zmiana profilu Administratora');
define('TEXT_INFO_HEADING_DEFAULT_GROUPS', 'Grupy użytkowników ');
define('TEXT_INFO_HEADING_DELETE_GROUPS', 'Usuwanie grup ');
define('TEXT_INFO_DEFAULT_GROUPS_INTRO', '<b>UWAGA:</b><li><b>edytuj:</b> zmiana nazwy grupy</li><li><b>usuń:</b> usunięcie grupy</li><li><b>uprawnienia:</b> uprawnienia dla grupy użytkowników</li>');
define('TEXT_INFO_DELETE_GROUPS_INTRO', 'Ta opcja usunie również wszystkich członków tej grupy. Czy napewno chcesz skasować grupę <nobr><b>%s</b> ?</nobr>');
define('TEXT_INFO_DELETE_GROUPS_INTRO_NOT', 'Nie można usunąć uprawnień dla tego użytkownika!');
define('TEXT_INFO_GROUPS_INTRO', 'Wprowadź unikalną nazwę. Kliknij dalej, aby potwierdzić.');
define('TEXT_INFO_HEADING_GROUPS', 'Nowa grupa użytkowników');
define('TEXT_INFO_GROUPS_NAME', ' <b>Nazwa grupy:</b><br>Wprowadź unikalną nazwę grupy. Następnie kliknij Dalej, aby kontunuować<br>');
define('TEXT_INFO_GROUPS_NAME_FALSE', '<font color="red"><b>BŁĄD:</b> Nazwa grupy musi mieć minimum 5 znaków</font>');
define('TEXT_INFO_GROUPS_NAME_USED', '<font color="red"><b>BŁĄD:</b> Grupa o tej nazwie już istnieje!</font>');
define('TEXT_INFO_GROUPS_LEVEL', 'Poziom uprawnień: ');
define('TEXT_INFO_GROUPS_BOXES', '<b>Uprawnienia do modułów:</b><br>Nadaj uprawnienia do modułów.');
define('TEXT_INFO_GROUPS_BOXES_INCLUDE', 'Uprawnienia: ');
define('TEXT_INFO_HEADING_DEFINE', 'Definiowanie uprawnień dla grupy');
if ($HTTP_GET_VARS['gPath'] == 1) {
  define('TEXT_INFO_DEFINE_INTRO', '<b>%s :</b><br>Nie można zmienić uprawnień dla tej grupy.<br><br>');
} else {
  define('TEXT_INFO_DEFINE_INTRO', '<b>%s :</b><br>Nadaj lub odbierz uprawnienia dla tej grupy zaznczając odpowiednie moduły i funkcje. Następnie kliknij <b>zachowaj</b>, aby zapamiętać zmiany.<br><br>');
}
?>