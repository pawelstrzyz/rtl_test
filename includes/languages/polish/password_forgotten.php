<?php
define('NAVBAR_TITLE_1', 'Logowanie');
define('NAVBAR_TITLE_2', 'Zapomniane hasło');
define('HEADING_TITLE', 'Zapomniałem hasło!');
define('TEXT_MAIN', 'Jeśli zapomniałeś hasło, wpisz poniżej swój adres e-mail i kliknij na przycisk Dalej. Na podany adres wysłane zostanie nowe wygenerowane przez system hasło.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'BŁĄD: Adres e-mail, który podałeś nie został znaleziony w bazie klientów. Proszę spróbować ponownie.');
define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Nowe hasło');
define('EMAIL_PASSWORD_REMINDER_BODY', 'Prośba o przypomnienie hasła została wysłana z ' . $_SERVER['REMOTE_ADDR'] . '.' . "\n\n" . 'Twoje nowe hasło w \'' . STORE_NAME . '\' to:' . "\n\n" . '   %s' . "\n\n");
define('SUCCESS_PASSWORD_SENT', 'Nowe hasło zostało wysłane na Twój adres email');
?>