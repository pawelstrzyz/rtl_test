<?php
if ($HTTP_GET_VARS['gID']) {
  define('HEADING_TITLE', 'Uprawnienia');
} elseif ($HTTP_GET_VARS['gPath']) {
  define('HEADING_TITLE', 'Definiowanie uprawnień');
} else {
  define('HEADING_TITLE', 'Konta Administratorów');
}
define('TEXT_COUNT_GROUPS', 'Admin(s): ');
define('TABLE_HEADING_NAME', 'Nazwa');
define('TABLE_HEADING_EMAIL', 'Adres Email');
define('TABLE_HEADING_PASSWORD', 'Hasło');
define('TABLE_HEADING_CONFIRM', 'Potwierdź hasło');
define('TABLE_HEADING_GROUPS', 'Grupa uprawnień');
define('TABLE_HEADING_CREATED', 'Konto utworzono');
define('TABLE_HEADING_MODIFIED', 'Konto modyfikowano');
define('TABLE_HEADING_LOGDATE', 'Ostatni dostęp');
define('TABLE_HEADING_LOGNUM', 'Ilość logowań');
define('TABLE_HEADING_LOG_NUM', 'Ilość logowań');
define('TABLE_HEADING_ACTION', 'Akcja');
define('TABLE_HEADING_GROUPS_NAME', 'Nazwa konta');
define('TABLE_HEADING_GROUPS_DEFINE', 'Uprawnienia do modułów i funkcji');
define('TABLE_HEADING_GROUPS_GROUP', 'Poziom');
define('TABLE_HEADING_GROUPS_CATEGORIES', 'Kategoria uprawnień');
define('TEXT_INFO_HEADING_DEFAULT', 'Konto Administratora ');
define('TEXT_INFO_HEADING_DELETE', 'Usuń uprawnienia ');
define('TEXT_INFO_HEADING_EDIT', 'Edycja kategorii / ');
define('TEXT_INFO_HEADING_NEW', 'Nowy Administrator ');
define('TEXT_INFO_DEFAULT_INTRO', 'Grupa użytkowników');
define('TEXT_INFO_DELETE_INTRO', 'Usunąć <nobr><b>%s</b></nobr> z <nobr>grupy użytkowników ?</nobr>');
define('TEXT_INFO_DELETE_INTRO_NOT', 'Nie można usunąć użytkownika <nobr>%s użytkownika !</nobr>');
define('TEXT_INFO_EDIT_INTRO', 'Ustaw poziom uprawnień: ');
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
define('ADMIN_EMAIL_SUBJECT', 'Nowy Administrator');
define('ADMIN_EMAIL_TEXT', 'Witaj %s,' . "\n\n" . 'Otrzymałeś uprawnienia do administrowania sklepem. Podczas pierwszego logowania proszę zmienić hasło dostępu!' . "\n\n" . 'Strona : %s' . "\n" . 'Nazwa użytkownika: %s' . "\n" . 'Hasło: %s' . "\n\n" . 'Dziękujemy ' . "\n" . '%s' . "\n\n" . 'Ta wiadomość została wygenerowana automatycznie. Prosimy na nią nie odpowiadać !');
define('ADMIN_EMAIL_TEXT_EDIT', 'Hi %s,' . "\n\n" . 'Twoje hasło do panelu administracyjnego zostało zmienione.' . "\n\n" . 'Strona : %s' . "\n" . 'Nazwa użytkownika : %s' . "\n" . 'Hasło : %s' . "\n\n" . 'Dziękujemy !' . "\n" . '%s' . "\n\n" . 'Ta wiadomość została wygenerowana automatycznie. Prosimy na nią nie odpowiadać !');
define('TEXT_INFO_HEADING_DEFAULT_GROUPS', 'Grupa uprawnień ');
define('TEXT_INFO_HEADING_DELETE_GROUPS', 'Usunięcie grupy ');
define('TEXT_INFO_DEFAULT_GROUPS_INTRO', '<b>UWAGA:</b><li><b>uprawnienia:</b> uprawnienia dla  użytkownika</li>');
define('TEXT_INFO_DELETE_GROUPS_INTRO', 'It\'s also will delete member of this group. Are you sure want to delete <nobr><b>%s</b> group?</nobr>');
define('TEXT_INFO_DELETE_GROUPS_INTRO_NOT', 'Nie można usunąć uprawnień dla tego użytkownika!');
define('TEXT_INFO_GROUPS_INTRO', 'Wprowadź unikalną nazwę. Kliknij dalej, aby potwierdzić.');
define('TEXT_INFO_HEADING_GROUPS', 'Nowy użytkownik');
define('TEXT_INFO_GROUPS_NAME', ' <b>Nazwa grupy:</b><br>Wprowadź unikalną nazwę. Kliknij dalej, aby potwierdzić.<br>');
define('TEXT_INFO_GROUPS_NAME_FALSE', '<font color="red"><b>BŁĄD:</b> Nazwa grupy musi mieć więcej niż 5 znaków!</font>');
define('TEXT_INFO_GROUPS_NAME_USED', '<font color="red"><b>BŁĄD:</b> Taka nazwa jest już używana!</font>');
define('TEXT_INFO_GROUPS_LEVEL', 'Poziom uprawnień: ');
define('TEXT_INFO_GROUPS_BOXES', '<b>Uprawnienia do modułów:</b><br>Nadaj uprawnienia do modułów.');
define('TEXT_INFO_GROUPS_BOXES_INCLUDE', 'Uprawnienia: ');
define('TEXT_INFO_HEADING_DEFINE', 'Uprawnienia administracyjne');
if ($HTTP_GET_VARS['gPath'] == 1) {
  define('TEXT_INFO_DEFINE_INTRO', '<b>%s :</b><br>Nie można zmienić uprawnień dla członka tej grupy<br><br>');
} else {
  define('TEXT_INFO_DEFINE_INTRO', '<b>%s :</b><br>Zmień uprawnienia do modułów i plików zaznaczając odpowiednie opcje. <br>Następnie możesz określić dodatkowe restrykcje korzystając z linku <b>dodaj uprawnienia</b>.<br>Kliknij <b>zachowaj</b>, aby zapamiętać zmiany.<br><br>');
}
//Mett
define('TEXT_ADD_ACCESS_VALUE', 'dodaj uprawnienia');
define('TEXT_EDIT_ACCESS_VALUE', 'edytuj uprawnienia');
define('TEXT_DELETE_ACCESS_VALUE', 'Usuń uprawnienia (reset)');
define('TEXT_SELECT_VALUE', 'Wybierz rodzaj uprawnień');
define('TEXT_INFO_PAGE', 'Page to edit:');
define('TEXT_INFO_NO_RESTRICTIONS', 'Pełny dostęp');
define('TEXT_INFO_PARTIAL_ACCESS', 'Częściowy dostęp');
define('TEXT_INFO_READ_ONLY', 'Tylko do odczytu');
define('TEXT_INFO_FORBIDDEN', 'Brak uprawnień');
define('TEXT_INFO_RESET', 'Usuń uprawnienia');
// end Mett
?>