<?php
define('NAVBAR_TITLE', 'Załóż konto');
define('HEADING_TITLE', 'Informacje o moim koncie');
define('TEXT_ORIGIN_LOGIN', '<font color="#FF0000"><small><b>UWAGA:</b></font></small> Jeżeli masz już konto w naszym sklepie, zaloguj się na <a href="%s"><u>tej stronie</u></a>.');
define('EMAIL_SUBJECT', 'Witamy w sklepie ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Szanowny Panie. %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Szanowna Pani. %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Witaj %s' . "\n\n");
define('EMAIL_WELCOME', 'Witamy w sklepie <b>' . STORE_NAME . '</b>.' . "\n\n");
define('EMAIL_USERNAME', 'Nazwa do logowania : <b>' . stripslashes($HTTP_POST_VARS['email_address']) . '</b>' . "\n\n");
define('EMAIL_PASSWORD', 'Hasło : ');
define('ENTRY_EMAIL_WARNING', '<font color=FF0000">Hasło zostanie wysłane na adres podany w formularzu rejestracyjnym. Prosimy o zmianę hasła podczas pierwszego zalogowania !</font>');
define('EMAIL_TEXT', 'Dzięki rejestracji masz możliwość skorzystania z <b>wielu usług</b> jakie oferujemy naszym użytkownikom. Niektóre z nich to:' . "\n\n" . '<li><b>Trwały Koszyk</b> - Każdy produkt dodany do koszyka pozostaje w nim do momentu zamówienia lub usunięcia.' . "\n" . '<li><b>Książka Adresowa</b> - Teraz możemy dostarczyć produkty które zamówisz pod wskazany przez ciebie adres! Jest to znakomita okazja do zrobienia komuś prezentu z okzaji urodzin czy imienin ...' . "\n" . '<li><b>Historia Zamówień</b> - Zobacz historię zamówień które u nas składałeś.' . "\n" . '<li><b>Opiniowanie Produktów</b> - Podziel się swoimi opiniami o produktach z innymi klientami.' . "\n\n");
define('EMAIL_CONTACT', 'W celu uzyskania pomocy skontaktuj się droga elektroniczną z właścicielem sklepu: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>UWAGA:</b> Ten adres email otrzymaliśmy od jednego z naszych klientów podczas jego rejestracji. Jeżeli to nie Ty zakładałeś to konto wyślij wiadomość na adres ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
//TotalB2B start
define('EMAIL_VALIDATE_SUBJECT', 'Nowy klient w '. STORE_NAME);
define('EMAIL_VALIDATE', 'Nowy klient zarejestrowany w '. STORE_NAME);
define('EMAIL_VALIDATE_PROFILE', 'Aby zobaczyć profil klienta kliknij tutaj :');
define('EMAIL_VALIDATE_ACTIVATE', 'Aby aktywować klienta kliknij tutaj :');
//TotalB2B end
?>