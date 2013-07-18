<?php
/*
  $Id: create_customer_pdf,v 1.1 2007/07/25 clefty (osc forum id chris23)

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
  
*/

define('TABLE_HEADING_PRODUCTS_MODEL', 'Produkt-Nr.');
define('TABLE_HEADING_PRODUCTS', 'Produkt');
define('TABLE_HEADING_TAX', 'MwSt.');
define('TABLE_HEADING_TOTAL', 'Summe');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Preis (exkl.)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Preis (inkl.)');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Summe (exkl.)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Summe (inkl.)');

define('ENTRY_SOLD_TO', 'Rechnungsanschrift:');
define('ENTRY_SHIP_TO', 'Lieferanschrift:');
define('ENTRY_PAYMENT_METHOD', 'Zahlungsweise:');
define('ENTRY_SUB_TOTAL', 'Zwischensumme:');
define('ENTRY_TAX', 'MwSt.:');
define('ENTRY_SHIPPING', 'Versandkosten:');
define('ENTRY_TOTAL', 'Gesamtsumme:');

define('PRINT_INVOICE_HEADING', 'Druckbare Bestellung');

define('PRINT_INVOICE_TITLE', 'Druckbare Bestellung #: ');
define('PRINT_INVOICE_ORDERNR', 'Druckbare Bestellung #: ');
define('PRINT_INVOICE_DATE', 'Data zamówienia: ');

define ('PDF_META_TITLE','Druckbare Bestellung');
define ('PDF_META_SUBJECT','Druckbare Bestellung #: ');

define ('PDF_INV_QTY_CELL','Qty.');
define ('PDF_INV_WEB','WWW: ');
define ('PDF_INV_EMAIL','E-mail: ');  
?>