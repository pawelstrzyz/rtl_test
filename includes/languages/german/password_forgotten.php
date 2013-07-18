<?php
define('NAVBAR_TITLE_1', 'Anmelden');
define('NAVBAR_TITLE_2', 'Passwort vergessen');
define('HEADING_TITLE', 'Wie war noch mal mein Passwort?');
define('TEXT_MAIN', 'Sollten Sie Ihr Passwort nicht mehr wissen, geben Sie bitte unten Ihre Email-Adresse ein um umgehend ein neues Passwort per Email zu erhalten.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'Fehler: Die eingegebene Email-Adresse ist nicht registriert. Bitte versuchen Sie es noch einmal.');
define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Ihr neues Passwort.');
define('EMAIL_PASSWORD_REMINDER_BODY', 'Über die Adresse ' . $_SERVER['REMOTE_ADDR'] . ' haben wir eine Anfrage zur Passworterneuerung erhalten.' . "\n\n" . 'Ihr neues Passwort für \'' . STORE_NAME . '\' lautet ab sofort:' . "\n\n" . '   %s' . "\n\n");
define('SUCCESS_PASSWORD_SENT', 'Success: Ein neues Passwort wurde per Email verschickt.');
?>