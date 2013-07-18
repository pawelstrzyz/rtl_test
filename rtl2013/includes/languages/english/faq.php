<?php
	if ( $action == 'new_faq' ){
		  define('HEADING_TITLE', 'FAQ - Nowy temat');
	} elseif ( $action == 'edit_faq' ){
		  define('HEADING_TITLE', 'FAQ - Edycja tematu');
	} elseif ( $action == 'preview_faq' ){
		  define('HEADING_TITLE', 'FAQ - Podgląd');
	} else {
		  define('HEADING_TITLE', 'Zarządzanie modułem FAQ (często zadawane pytania)');
	}
  define('TABLE_HEADING_FAQ_ID', 'ID');
  define('TABLE_HEADING_FAQ_QUESTION', 'Pytanie');
  define('TABLE_HEADING_FAQ_STATUS', 'Status');
  define('TABLE_HEADING_FAQ_LAST_MODIFIED', 'Ostatnia modyfikacja');



  define('TEXT_HEADING_DELETE_INTRO', 'Kasowanie wpisu #%s?');
  define('TEXT_HEADING_DELETE_FAQ', '');


  define('TITLE_ADD_QUESTION', 'Nowe pytanie:');
  define('TITLE_ADD_ANSWER', 'Nowa odpowiedź:');
  define('TITLE_STATUS', 'Status:');
  define('TITLE_SORT', 'Kolejność wyświetlania:');

  define('TEXT_ON', 'Włączone');
  define('TEXT_OFF', 'Wyłączone');
  define('TEXT_QUESTION', 'Pytanie:');
  define('TEXT_ANSWER', 'Odpowiedź:');
  define('TEXT_LAST_UPDATED', 'ostatnia modyfikacja - ');

?>