<?
/*
  $Id: attributeManager.php,v 1.0 21/02/06 Sam West$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  
  English translation to AJAX-AttributeManager-V2.7
  
  by Shimon Doodkin
  http://help.me.pro.googlepages.com
  helpmepro1@gmail.com
*/

//attributeManagerPrompts.inc.php

define('AM_AJAX_YES', 'Tak');
define('AM_AJAX_NO', 'Nie');
define('AM_AJAX_UPDATE', 'Zmień');
define('AM_AJAX_CANCEL', 'Anuluj');
define('AM_AJAX_OK', 'OK');

define('AM_AJAX_SORT', 'Sortowanie:');
define('AM_AJAX_TRACK_STOCK', 'Kontrolować stany ?');
define('AM_AJAX_TRACK_STOCK_IMGALT', 'Kontrolować stany tego atrybutu ?');

define('AM_AJAX_ENTER_NEW_OPTION_NAME', 'Wprowadź nazwę');
define('AM_AJAX_ENTER_NEW_OPTION_VALUE_NAME', 'Wprowadź nową nazwę atrybutu');
define('AM_AJAX_ENTER_NEW_OPTION_VALUE_NAME_TO_ADD_TO', 'Wprowadź nową wartość dla atrybutu %s');

define('AM_AJAX_PROMPT_REMOVE_OPTION_AND_ALL_VALUES', 'Czy napewno chcesz usunąć atrybut %s i wszystkie wartości przyporządkowane do tego produktu ?');
define('AM_AJAX_PROMPT_REMOVE_OPTION', 'Czy napewno chcesz usunąć atrybut %s z tego produktu ?');
define('AM_AJAX_PROMPT_STOCK_COMBINATION', 'Czy napewno chcesz usunąć stany przyporządkowane do tego produktu ?');

define('AM_AJAX_PROMPT_LOAD_TEMPLATE', 'Czy chcesz załadować szablon %s ? <br />Operacja ta nadpisze przypisane dotychczas do tego produktu atrybuty.');
define('AM_AJAX_NEW_TEMPLATE_NAME_HEADER', 'Wprowadź nową nazwę szablonu. Lub ...');
define('AM_AJAX_NEW_NAME', 'Nowa nazwa:');
define('AM_AJAX_CHOOSE_EXISTING_TEMPLATE_TO_OVERWRITE', ' ...<br /> ... wybierz obecną i zmień nazwę');
define('AM_AJAX_CHOOSE_EXISTING_TEMPLATE_TITLE', 'Istniejący:'); 
define('AM_AJAX_RENAME_TEMPLATE_ENTER_NEW_NAME', 'Wprowadź nową nazwę szablonu %s ');
define('AM_AJAX_PROMPT_DELETE_TEMPLATE', 'Czy napewno chcesz usunąć szablon %s ?<br>Operacja ta jest nieodwracalna !');

//attributeManager.php

define('AM_AJAX_ADDS_ATTRIBUTE_TO_OPTION', 'Dodaj wybraną wartość do atrybutu %s');
define('AM_AJAX_ADDS_NEW_VALUE_TO_OPTION', 'Dodaj nową wartość do atrybutu %s');
define('AM_AJAX_PRODUCT_REMOVES_OPTION_AND_ITS_VALUES', 'Usuń atrybut %1$s i %2$d wartości przyporządkowane do tego produktu');
define('AM_AJAX_CHANGES', 'Zmiany'); 
define('AM_AJAX_LOADS_SELECTED_TEMPLATE', 'Wczytaj wybrany szablon');
define('AM_AJAX_SAVES_ATTRIBUTES_AS_A_NEW_TEMPLATE', 'Zapisz aktualne atrybuty jako nowy szablon');
define('AM_AJAX_RENAMES_THE_SELECTED_TEMPLATE', 'Zmień nazwę szablonu');
define('AM_AJAX_DELETES_THE_SELECTED_TEMPLATE', 'Skasuj wybrany szablon');
define('AM_AJAX_NAME', 'Nazwa');
define('AM_AJAX_ACTION', 'Akcja');
define('AM_AJAX_PRODUCT_REMOVES_VALUE_FROM_OPTION', 'Usuń wartość %1$s atrybutu %2$s, z tego produktu');
define('AM_AJAX_MOVES_VALUE_UP', 'Przenies w górę');
define('AM_AJAX_MOVES_VALUE_DOWN', 'Przenieś w dół');
define('AM_AJAX_ADDS_NEW_OPTION', 'Dodaj nowy atrybut do listy');
define('AM_AJAX_OPTION', 'Atrybut:');
define('AM_AJAX_VALUE', 'Wartość:');
define('AM_AJAX_PREFIX', 'Prefix:');
define('AM_AJAX_PRICE', 'Cena:');
define('AM_AJAX_SORT', 'Sortowanie:');
define('AM_AJAX_ADDS_NEW_OPTION_VALUE', 'Dodaj nową wartość do listy');
define('AM_AJAX_ADDS_ATTRIBUTE_TO_PRODUCT', 'dodaj atrybut do aktualnego produktu');
define('AM_AJAX_QUANTITY', 'Ilość');
define('AM_AJAX_PRODUCT_REMOVE_ATTRIBUTE_COMBINATION_AND_STOCK', 'Removes this attribute combination and stock from this product');
define('AM_AJAX_UPDATE_OR_INSERT_ATTRIBUTE_COMBINATIONBY_QUANTITY', 'Update or Insert the attribute combination with the given quantity');

//attributeManager.class.php
define('AM_AJAX_TEMPLATES', '-- Szablony --');
?>
