<?php
/*
  $Id: sitemonitor_admin.php,v 1.2 2005/09/24 Jack_mcs
  
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
define('HEADING_SITEMONITOR_CONFIGURE_SETUP', 'Konfiguracja Monitora Systemu');
define('TEXT_SITEMONITOR_CONFGIURE_SETUP', 'Modul ten sluży do ustawienia konfiguracji Monitora Systemu. Konfiguracja umożliwia zdefinowanie wykluczeń katalogów, które nie będą monitorowane oraz opcji logowania i powiadomień o wystepujących niespójnociach.');
define('TEXT_OPTION_ALWAYS_EMAIL', 'Zawsze wysylaj e-mail');
define('TEXT_OPTION_ALWAYS_EMAIL_EXPLAIN', 'Jeżeli ta opcja jest zaznaczona e-mail jest wysylany po każdym uruchomieniu monitora. W przeciwnym razie e-mail jest wysylany tylko w przypadku wystąpienia niespójnoci.');
define('TEXT_OPTION_VERBOSE', 'Szczególy');
define('TEXT_OPTION_VERBOSE_EXPLAIN', 'Zaznaczenie tej opcji powoduje wywietlanie na ekranie informacji w przypadku ręcznego uruchomienia monitora.');
define('TEXT_OPTION_LOGFILE', 'Plik logu');
define('TEXT_OPTION_LOGFILE_EXPLAIN', 'Zaznaczenie opcji powoduje zapisywnie do pliku logu (administracja/tmp/sitemonitor.txt) wszystkich informacji znalezionych podczas pracy monitora.');
define('TEXT_OPTION_LOGFILE_SIZE', 'wielkoć pliku logu');
define('TEXT_OPTION_LOGFILE_SIZE_EXPLAIN', 'Maksymalna wielkoć pliku logu. Jeżeli zostanie osiągnięta podana wielkosć, nazwa pliku zostanie zmieniona i program utworzy nowy plik.');

define('TEXT_OPTION_QUARANTINE', 'Kwarantanna');
define('TEXT_OPTION_QUARANTINE_EXPLAIN', 'Wszystkie nowoznalezione pliki zostaną przeniesione do katalogu kwarantanny. Użycie tej opcji wymaga utworzenia nowego pliku referencyjnego po dokonaniu jakichkolwiek zmian w monitorowanych plikach. W przeciwnym razie zostaną one również przeniesione do kwarantanny.');

define('TEXT_OPTION_TO_EMAIL', 'Do:');
define('TEXT_OPTION_TO_ADDRESS_EXPLAIN', 'Adres e-mail, na który będą wysye wiadomoci z Monitora Systemu.');
define('TEXT_OPTION_FROM_EMAIL', 'Od kogo:');
define('TEXT_OPTION_FROM_ADDRESS_EXPLAIN', 'Adres e-mail podawany w wiadomosci od kogo zostala nadana.');
define('TEXT_OPTION_START_DIR', 'Katalog startowy:');
define('TEXT_OPTION_START_DIR_EXPLAIN', 'Katalog, od którego system będzie monitorowany. Dla osiągnięcia największej efektywnosci należy podać glówny katalog w, w którym najduje się sklep.');
define('TEXT_OPTION_EXCLUDE_LIST', 'Lista wykluczeń:');
define('TEXT_OPTION_EXCLUDE_LIST_EXPLAIN', 'Lista katalogów, które mają nie być monitorowane.<br>Należy wprowadzić listę w formacie "nazwa_katalogu1","nazwa_katalogu2" (nazwy w cudzyslowach oddzielone przecinkiem).');
 
?>
