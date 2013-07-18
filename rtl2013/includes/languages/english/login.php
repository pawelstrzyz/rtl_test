<?php
if ($HTTP_GET_VARS['origin'] == FILENAME_CHECKOUT_PAYMENT) {
  define('NAVBAR_TITLE', 'Zamówienie');
  define('HEADING_TITLE', 'Zamówienie online');
  define('TEXT_STEP_BY_STEP', 'Zostaniesz przeprowadzony przez ten proces krok po korku.');
} else {
  define('NAVBAR_TITLE', 'Login');
  define('HEADING_TITLE', 'Witaj, zaloguj się');
  define('TEXT_STEP_BY_STEP', ''); // should be empty
}
define('HEADING_RETURNING_ADMIN', 'Panel logowania:');
define('HEADING_PASSWORD_FORGOTTEN', 'Zapomniałem hasła:');
define('TEXT_RETURNING_ADMIN', 'Staff only!');
define('ENTRY_EMAIL_ADDRESS', 'Adres E-Mail:');
define('ENTRY_PASSWORD', 'Hasło:');
define('ENTRY_FIRSTNAME', 'Imię:');
define('IMAGE_BUTTON_LOGIN', 'Potwierdź');
define('TEXT_PASSWORD_FORGOTTEN', 'Zapomniałeś hasło ?');
define('TEXT_LOGIN_ERROR', '<font color="#ff0000"><b>BŁĄD:</b></font> Zła nazwa lub hasło!');
define('TEXT_FORGOTTEN_ERROR', '<font color="#ff0000"><b>BŁĄD:</b></font> imię i hasło nie pasują!');
define('TEXT_FORGOTTEN_FAIL', 'Wprowadziłeś trzykrotnie niepoprawne hasło. Dla zachowania bezpieczeństwa skontaktuj się z Administratorem w celu otrzymania nowego hasła.<br>&nbsp;<br>&nbsp;');
define('TEXT_FORGOTTEN_SUCCESS', 'Nowe hasło zostało wysłane na wskazany adres e-mail. Sprawdź pocztę i wróć, aby ponownie się zalogować.<br>&nbsp;<br>&nbsp;');
define('ADMIN_EMAIL_SUBJECT', 'Nowe hasło'); 
define('ADMIN_EMAIL_TEXT', 'Hi %s,' . "\n\n" . 'Możesz zalogować się do panelu administrayjnego korzystają z tego hasła. Po zalogowaniu prosze zmienic haslo!' . "\n\n" . 'Strona : %s' . "\n" . 'Uzytkownik: %s' . "\n" . 'Haslo: %s' . "\n\n" . 'Dziekujemy!' . "\n" . '%s' . "\n\n" . 'Jest to automatycznie wygenerowany e-mail, prosze na niego nie odpowiadac!'); 
?>