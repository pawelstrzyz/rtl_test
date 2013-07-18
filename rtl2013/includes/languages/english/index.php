<?php
define('HEADING_TITLE', 'Wybierz..');
define('BOX_TITLE_ORDERS', 'Zamówienia');
define('BOX_TITLE_STATISTICS', 'Statystyki');
define('BOX_ENTRY_SUPPORT_SITE', 'Pomoc');
define('BOX_ENTRY_SUPPORT_FORUMS', 'Forum dyskusyjne');
define('BOX_ENTRY_MAILING_LISTS', 'Lista dyskusyjna');
define('BOX_ENTRY_BUG_REPORTS', 'Zgłaszanie błędów');
define('BOX_ENTRY_FAQ', 'Często zadawane pytania (FAQ)');
define('BOX_ENTRY_LIVE_DISCUSSIONS', 'Dyskusje (czat)');
define('BOX_ENTRY_CVS_REPOSITORY', 'Repozytorium CVS');
define('BOX_ENTRY_INFORMATION_PORTAL', 'Portal informacyjny');
define('BOX_ENTRY_CUSTOMERS', 'Klientów:');
define('BOX_ENTRY_PRODUCTS', 'Ilość produktów:');
define('BOX_ENTRY_REVIEWS', 'Ilość recenzji:');
define('BOX_CONNECTION_PROTECTED', 'Transmisja jest chroniona przez połączenie SSL na serwerze %s.');
define('BOX_CONNECTION_UNPROTECTED', 'Transmisja <font color="#ff0000">nie jest</font> chroniona połączeniem SSL.');
define('BOX_CONNECTION_UNKNOWN', 'nieznane');
define('CATALOG_CONTENTS', 'Zawartość');
define('REPORTS_PRODUCTS', 'Produkty');
define('REPORTS_ORDERS', 'Zamówienia');
define('TOOLS_BACKUP', 'Archiwizacja');
define('TOOLS_BANNERS', 'Banery');
define('TOOLS_FILES', 'Pliki');

// Store box
$storename="<a class='adminLink' href='".tep_href_link(FILENAME_CONFIGURATION,"gID=1&cID=1&action=edit")."'>Nazwa sklepu</a>";
define('BLOCK_CONTENT_STORE_INFO_STORE_NAME',$storename);
$storestatus="<a class='adminLink' href='".tep_href_link(FILENAME_CONFIGURATION,"gID=0&cID=3210")."'>Status sklepu</a>";
define('BLOCK_CONTENT_STORE_INFO_STORE_STATUS',$storestatus);
$storeemail="<a class='adminLink' href='".tep_href_link(FILENAME_CONFIGURATION,"gID=1&cID=4")."'>Adres email</a>";
define('BLOCK_CONTENT_STORE_INFO_STORE_EMAIL',$storeemail); 
$primarylang="<a class='adminLink' href='".tep_href_link(FILENAME_LANGUAGES)."'>Domyślny język</a>";
define('BLOCK_CONTENT_STORE_INFO_STORE_LANGUAGE',$primarylang); 
$primarycurr="<a class='adminLink' href='".tep_href_link(FILENAME_CURRENCIES)."'>Domyślna waluta</a>";
define('BLOCK_CONTENT_STORE_INFO_STORE_CURRENCY',$primarycurr);
define('BLOCK_CONTENT_STORE_INFO_STORE_TAX_RATE','Tax Rate');
define('BLOCK_CONTENT_STORE_INFO_STORE_TAX_ZONE','Tax Zone');
define('BLOCK_CONTENT_STORE_INFO_STORE_BACKUPS','Kopia bazy'); 

// Products
define('BLOCK_TITLE_PRODUCTS','Produkty');
define('BLOCK_CONTENT_PRODUCTS_CATEGORIES','Ilość kategorii');
define('BLOCK_CONTENT_PRODUCTS_TOTAL_PRODUCTS','Ilość produktów');
define('BLOCK_CONTENT_PRODUCTS_ACTIVE','Aktywne produkty');
define('BLOCK_CONTENT_PRODUCTS_NOSTOCK','Poniżej stanu magazynowego');
define('BLOCK_HELP_PRODUCTS','<ul><li><strong>Total Number of Products</strong><br>This is total count of products in database irrespective of categories and status.</li><li><strong>Active Products</strong><br>This is total count of live products which are online for sales. This record didcuscts products deactiveated by store admin and out of stocks.</li><li><strong>Out Of Stock<br></strong>This is total count of products, which are not in stock.</li></ul>');

// Store tips
define('BLOCK_HELP_STORE_INFO','<ul><li><strong>Store Info</strong><br>Store info which you have in database.<br> You can visit Configuration >> My Store to edit / modify the same.</li></ul>');
define('BLOCK_HELP_STORE_STATUS','<ul><li><font color=#009900><strong>Otwarty</strong></font><br>Sklep dostępny dla klientów</li><li><font color=#FF0000><strong>Zamknięty</strong></font><br>Sklep wyłączony w celach administracyjnych</li></ul>');
define('BLOCK_HELP_STORE_BACKUP','Wykonaj kopię teraz!');

?>