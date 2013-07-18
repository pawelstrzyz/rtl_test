<?php
define('TABLE_HEADING_NEW_PRODUCTS', 'Nowości %s');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Oczekiwane produkty');
define('TABLE_HEADING_DATE_EXPECTED', 'Data');
define('TEXT_NO_PRODUCTS', 'Brak produktów w tej kategorii.');
define('NAVBAR_TITLE_1', 'Biuletyny');
define('NAVBAR_TITLE', 'Biuletyn - rejestracja');
define('HEADING_TITLE', 'Subskrypcja biuletynu');
define('TEXT_INFORMATION', '<b>Dziękujemy za subskrypcję naszego biuletynu.</b><br><br>E-mail potwierdzający został wysłany na podany podczas rejestracji adres.');
define('TOP_BAR_TITLE', 'Biuletyn' . STORE_NAME );
define('TOP_BAR_SUCCESS', 'Właśnie zostałeś(aś) subskrybentem naszego biuletynu.<BR><BR><B>Na adres e-mail podany podczas rejestracji została wysłana wiadomość w celu <B>potwierdzenia rejestracji</B> i sprawdzenia poprawności adresu. <BR><BR>Wiadomość ta zawiera również instrukcje dotyczące rezygnacji z subskrypcji.');
define('TOP_BAR_EXPLAIN', '');
define('TOP_BAR_EXPLAIN1', '');
define('EMAIL_WELCOME_SUBJECT', 'Biuletyn ' . STORE_NAME . '!');

define('EMAIL_WELCOME1', 'Witamy w biuletynie ' . STORE_NAME . '! You will now receive on a monthly basis our newsletter.' . "\n" . '* If you would like to contribute or write an article for one of our newsletters, do not hesitate to contact us.' . "\n\n" . 'For help with any of our online services, please email our Customer Service Center : ' . HTTP_SERVER . DIR_WS_CATALOG . 'customer_service.php' . "\n\n" . 'We are happy to have you as a member of our community. Privacy is important to us; therefore, we will not sell, rent, or give away your name or address to anyone. At any point, you can select the link at the bottom of every email to unsubscribe, or to receive less or more information.' . "\n\n" . 'Thanks again for registering, and please visit ' . STORE_NAME . ' soon! If you have any questions or comments, feel free to contact us.' . '"\n\n"');

define('EMAIL_WELCOME', '*** Witamy w biuletnie ' . STORE_NAME . ' ***' . "\n\n" . 'Otrzymales ten e-mail poniewaz Ty lub ktos nieupowazniony podal ten adres w formularzu rejestracyjnym biuletynu ' . STORE_NAME . "\n\n" . 'Uwaga: Jezeli ktos inny podal ten adres w Twoim imieniu i nie chcesz subskrybowac naszego biuletynu mozesz kliknac w link na dole strony, w celu rezygnacji z otrzymywania naszego biuletynu.');
define('CLOSING_BLOCK1', '');
define('CLOSING_BLOCK2', '');
define('CLOSING_BLOCK3', '');
define('UNSUBSCRIBE', "\n\n" . 'W celu rezygnacji z subskrypcji kliknij tutaj :' ."\n". HTTP_SERVER . DIR_WS_CATALOG . 'newsletters_unsubscribe.php?action=view&email=');
define('TEXT_ORIGIN_LOGIN', '<font color="#FF0000"><small><b>NOTE:</b></font></small>Registering to receive our newsletter is a different process than registering when placing an order. To receive our newsletters, you only need to enter your name, email and country. (however you will not be able to place orders or track shipments until you fully register.)</font>');
define('TEXT_ORIGIN_LOGIN1', '<font color="#FF0000"><small><b>NOTE2:</b></font></small>' . STORE_NAME . ' respects very strongly your privacy. We will never resell the information entered or use it in a way which was not originally explained : read our privacy page for all details.</font>');
define('EMAIL_GREET_MR', 'Dear Mr. ');
define('EMAIL_GREET_MS', 'Dear Ms. ');
define('EMAIL_GREET_NONE', 'Dear ');

define('TEXT_EMAIL', 'E Mail');
define('TEXT_EMAIL_FORMAT', 'Format biuletynu');
define('TEXT_GENDER', 'Płeć');
define('TEXT_FIRST_NAME', 'Imię');
define('TEXT_LAST_NAME', 'Nazwisko');
define('TEXT_ZIP_INFO', '');
define('TEXT_ZIP_CODE', 'Kod pocztowy');
define('TEXT_ORIGIN_EXPLAIN_BOTTOM', '');
define('TEXT_ORIGIN_EXPLAIN_TOP', 'Jeśli chcą Państwo być informowani o działalności naszej firmy, nowych usługach, produktach oraz promocjach, prosimy o wypełnienie poniższego formularza.<br>Państwa adres e-mail będzie przechowywany w bezpieczny sposób i nie będzie udostępniany osobom trzecim.<br>W każdej chwili będą mogli Państwo zrezygnować z otrzymywania naszego biuletynu.<br>Wypełniając poniższy formularz otrzymają Państwo e-mail z prośbą o potwierdzenie subskrypcji.');
define('TEXT_EMAIL_HTML', 'HTML');
define('TEXT_EMAIL_TXT', 'Text');
define('TEXT_GENDER_MR', 'Pan');
define('TEXT_GENDER_MRS', 'Pani');

define('TEXT_INFORMATION_ERROR', '<b>Błędne dane rejestracyjne.</b><br><br>Prosimy o ponowne wprowadzenie poprawnych danych.');
?>