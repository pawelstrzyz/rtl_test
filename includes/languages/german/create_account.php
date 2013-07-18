<?php
define('NAVBAR_TITLE', 'Konto erstellen');
define('HEADING_TITLE', 'Informationen zu Ihrem Kundenkonto');
define('TEXT_ORIGIN_LOGIN', '<font color="#FF0000"><small><b>ACHTUNG:</b></font></small> Wenn Sie bereits ein Konto besitzen, so melden Sie sich bitte <a href="%s"><u><b>hier</b></u></a> an.');
define('EMAIL_SUBJECT', 'Willkommen zu ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Sehr geehrter Herr ' . stripslashes($HTTP_POST_VARS['lastname']) . ',' . "\n\n");
define('EMAIL_GREET_MS', 'Sehr geehrte Frau ' . stripslashes($HTTP_POST_VARS['lastname']) . ',' . "\n\n");
define('EMAIL_GREET_NONE', 'Sehr geehrte ' . stripslashes($HTTP_POST_VARS['firstname']) . ',' . "\n\n");
define('EMAIL_WELCOME', 'willkommen zu <b>' . STORE_NAME . '</b>.' . "\n\n");
define('EMAIL_USERNAME', 'Ihr username ist: <b>' . stripslashes($HTTP_POST_VARS['email_address']) . '</b>' . "\n\n");
define('EMAIL_PASSWORD', 'Ihr Kennwort ist:' . stripslashes($HTTP_POST_VARS['password']) . "\n\n");
define('ENTRY_EMAIL_WARNING', '<font color=FF0000">Aus Sicherheitsgründen wird Ihnen ein automatisch generiertes Passwort an Ihre E-Mail Adresse geschickt. Dieses benötigen Sie, um sich später in Ihren Kundenaccount einzuloggen.</font>');
define('EMAIL_TEXT', 'Sie können jetzt unseren <b>Online-Service</b> nutzen. Der Service bietet unter anderem:' . "\n\n" . '<li><b>Kundenwarenkorb</b> - Jeder Artikel bleibt registriert bis Sie zur Kasse gehen, oder die Produkte aus dem Warenkorb entfernen.' . "\n" . '<li><b>Adressbuch</b> - Wir können jetzt die Produkte zu der von Ihnen ausgesuchten Adresse senden. Der perfekte Weg ein Geburtstagsgeschenk zu versenden.' . "\n" . '<li><b>Vorherige Bestellungen</b> - Sie können jederzeit Ihre vorherigen Bestellungen überprüfen.' . "\n" . '<li><b>Meinungen über Produkte</b> - Teilen Sie Ihre Meinung zu unseren Produkten mit anderen Kunden.' . "\n\n");
define('EMAIL_CONTACT', 'Falls Sie Fragen zu unserem Kunden-Service haben, wenden Sie sich bitte an den Vertrieb: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>Achtung:</b> Diese Email-Adresse wurde uns von einem Kunden bekannt gegeben. Falls Sie sich nicht angemeldet haben, senden Sie bitte eine Email an ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");

//TotalB2B start
define('EMAIL_VALIDATE_SUBJECT', 'Neuer Kunde an '. STORE_NAME);
define('EMAIL_VALIDATE', 'Ein neuer Kunde registrierte an '. STORE_NAME);
define('EMAIL_VALIDATE_PROFILE', 'Um Kunden zu sehen zu profilieren klicken Sie hier:');
define('EMAIL_VALIDATE_ACTIVATE', 'Um Kunden zu aktivieren klicken Sie hier:');
//TotalB2B end
?>