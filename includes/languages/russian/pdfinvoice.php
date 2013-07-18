<?php
/*
  $Id: create_customer_pdf,v 1.1 2007/07/25 clefty (osc forum id chris23)

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
  
*/

define('TABLE_HEADING_PRODUCTS_MODEL', 'Model');
define('TABLE_HEADING_PRODUCTS', 'Produkty');
define('TABLE_HEADING_TAX', 'VAT');
define('TABLE_HEADING_TOTAL', 'Razem');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Cena netto');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Cena brutto');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Wartość netto');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Wartość brutto');

define('ENTRY_SOLD_TO', 'Zamawiający:');
define('ENTRY_SHIP_TO', 'Miejsce dostawy:');
define('ENTRY_PAYMENT_METHOD', 'Sposób płatności:');
define('ENTRY_SUB_TOTAL', 'Wartość produktów:');
define('ENTRY_TAX', 'Podatek VAT:');
define('ENTRY_SHIPPING', 'Przesyłka:');
define('ENTRY_TOTAL', 'Wartość zamówienia:');

define('PRINT_INVOICE_HEADING', 'Zamówienie');

define('PRINT_INVOICE_TITLE', 'Numer zamówienia: ');
define('PRINT_INVOICE_ORDERNR', 'Numer zamówienia: ');
define('PRINT_INVOICE_DATE', 'Data zamówienia: ');

define ('PDF_META_TITLE','Zamówienie');
define ('PDF_META_SUBJECT','Wydruk zamówiena nr: ');

define ('PDF_INV_QTY_CELL','Ilość');
define ('PDF_INV_WEB','WWW: ');
define ('PDF_INV_EMAIL','E-mail: ');  
?>