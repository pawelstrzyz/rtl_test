<?php
/*
  $Id: mails.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Wysyłanie maili do subskrybentów');

define('TEXT_SUBSCRIBER', 'Subskrybent:');
define('TEXT_SUBJECT', 'Temat:');
define('TEXT_FROM', 'Nadawca:');
define('TEXT_MESSAGE', 'Wiadomość:');
define('TEXT_SELECT_SUBSCRIBER', 'Wybierz Subskrybenta');
define('TEXT_ALL_SUBSCRIBERS', 'Wszyscy Subskrybenci');
define('TEXT_NEWSLETTER_SUBSCRIBERS', 'Wszyscy subskrybenci Newslettera');

define('NOTICE_EMAIL_SENT_TO', 'UWAGA: Email wysłano do: %s');

define('ERROR_NO_CUSTOMER_SELECTED', 'BŁˇD: nie wybrano subskrybentów.');
// MaxiDVD Added Line For WYSIWYG HTML Area: BOF
define('TEXT_EMAIL_BUTTON_TEXT', '<p><HR><b><font color="red">The Back Button has been DISABLE while HTML WYSIWG Editor is turned ON,</b></font> WHY? - Because if you click the back button to edit your HTML email, The PHP (php.ini - "Magic Quotes = On") will automatically add "\\\\\\\" backslashes everywhere Double Quotes " appear (HTML uses them in Links, Images and More) and this destorts the HTML and the pictures will dissapear once you submit the email again, If you turn OFF WYSIWYG Editor in Admin the HTML Ability of osCommerce is also turned OFF and the back button will re-appear. A fix for this HTML and PHP issue would be nice if someone knows a solution Iv\'e tried.<br><br><b>If you really need to Preview your emails before sending them, use the Preview Button located on the WYSIWYG Editor.<br><HR>');
define('TEXT_EMAIL_BUTTON_HTML', '<p><HR><b><font color="red">HTML is currently Disabled!</b></font><br><br>If you want to send HTML email, Enable WYSIWYG Editor for Email in: Admin-->Configuration-->WYSIWYG Editor-->Options<br>');
// MaxiDVD Added Line For WYSIWYG HTML Area: EOF
define('TEXT_EMAIL_BUTTON_HTML', '<p><HR><b><font color="red">The editor HTML is not at present validated!!</b></font><br><br>If you want to send a mail to HTML, to Validate the editor HTML: Admin-->Configuration-->Editeur HTML-->Options<br>');
?>