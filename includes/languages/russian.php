<?php
/*
  $Id: russian.php 172 2008-03-21 22:47:23Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

*/

// look in your $PATH_LOCALE/locale directory for available locales
// or type locale -a on the server.
// Examples:
// on RedHat try 'en_US'
// on FreeBSD try 'en_US.ISO_8859-1'
// on Windows try 'en', or 'English'
@setlocale(LC_TIME, 'ru_RU.CP1251');

define('DATE_FORMAT_SHORT', '%d/%m/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd/m/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'EUR');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="LTR" lang="ru"');

// charset for web pages and emails
define('CHARSET', 'utf-8');

// page title
define('TITLE', 'eSklep-Os');

// header text in includes/header.php
define('HEADER_TITLE_CREATE_ACCOUNT', 'Регистрация');
define('HEADER_TITLE_MY_ACCOUNT', 'Мои данные');
define('HEADER_TITLE_CART_CONTENTS', 'Корзина');
define('HEADER_TITLE_CHECKOUT', 'Оформить заказ');
define('HEADER_TITLE_TOP', 'Магазин');
define('HEADER_TITLE_CATALOG', 'Каталог');
define('HEADER_TITLE_LOGOFF', 'Выход');
define('HEADER_TITLE_LOGIN', 'Мои данные');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'просмотренных страниц c');

// text for gender
define('MALE', 'Мужской');
define('FEMALE', 'Женский');
define('MALE_ADDRESS', 'Г-н');
define('FEMALE_ADDRESS', 'Г-жа');

// text for date of birth example
define('DOB_FORMAT_STRING', 'dd/mm/yyyy');

// categories box text in includes/boxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Разделы');

// manufacturers box text in includes/boxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Производители');

// whats_new box text in includes/boxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'Новинки');

// quick_find box text in includes/boxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Быстрый поиск');
define('BOX_SEARCH_TEXT', 'Введите слово для поиска.');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Расширенный поиск');

// specials box text in includes/boxes/specials.php
define('BOX_HEADING_SPECIALS', 'Скидки');

// reviews box text in includes/boxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Отзывы');
define('BOX_REVIEWS_WRITE_REVIEW', 'Напишите Ваше мнение о товаре!');
define('BOX_REVIEWS_NO_REVIEWS', 'К настоящему времени нет ни одного отзыва');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s из 5 звёзд!');

// shopping_cart box text in includes/boxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Корзина');
define('BOX_SHOPPING_CART_EMPTY', 'Корзина пуста');

// order_history box text in includes/boxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'История заказов');

// best_sellers box text in includes/boxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Лидеры продаж');
define('BOX_HEADING_BESTSELLERS_IN', 'Лидеры продаж среди<br>&nbsp;&nbsp;');

// notifications box text in includes/boxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Уведомления');
define('BOX_NOTIFICATIONS_NOTIFY', 'Сообщите мне о новинках и&nbsp;<b>%s</b>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Не сообщайте мне о новинках <b>%s</b>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Производитель');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', 'Сайт %s');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Другие товары');

// languages box text in includes/boxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Языки');

// currencies box text in includes/boxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Валюта');

// information box text in includes/boxes/information.php
define('BOX_HEADING_INFORMATION', 'Информация');
define('BOX_INFORMATION_PRIVACY', 'Безопасность');
define('BOX_INFORMATION_CONDITIONS', 'Условия и гарантии');
define('BOX_INFORMATION_SHIPPING', 'Доставка и возврат');
define('BOX_INFORMATION_CONTACT', 'Свяжитесь с нами');

// tell a friend box text in includes/boxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Расскажите другу');
define('BOX_TELL_A_FRIEND_TEXT', 'Сообщите своим друзьям и близким о нашем магазине');

// checkout procedure text
define('CHECKOUT_BAR_DELIVERY', 'Адрес доставки');
define('CHECKOUT_BAR_PAYMENT', 'Способ оплаты');
define('CHECKOUT_BAR_CONFIRMATION', 'Подтверждение');
define('CHECKOUT_BAR_FINISHED', 'Заказ оформлен!');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Выберите');
define('TYPE_BELOW', 'Выбор ниже');

// javascript messages
define('JS_ERROR', 'Ошибки при заполнении формы!\n\nИсправьте пожалуйста:\n\n');

define('JS_REVIEW_TEXT', '* Поле \'Текст отзыва\' должно содержать не менее ' . REVIEW_TEXT_MIN_LENGTH . ' символов.\n');
define('JS_REVIEW_RATING', '* Оцените, пожалуйста, продукт по пятибальной шкале.\n');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Выберите метод оплаты для Вашего заказа.\n');

define('JS_ERROR_SUBMITTED', 'Эта форма уже заполнена. Нажимайте Ok.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Выберите, пожалуйста, метод оплаты для Вашего заказа.');

define('CATEGORY_COMPANY', 'Организация');
define('CATEGORY_PERSONAL', 'Ваши персональные данные');
define('CATEGORY_ADDRESS', 'Ваш адрес');
define('CATEGORY_CONTACT', 'Контактная информация');
define('CATEGORY_OPTIONS', 'Рассылка');
define('CATEGORY_PASSWORD', 'Ваш пароль');

define('ENTRY_COMPANY', 'Название компании:');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');

define('ENTRY_NIP', 'NIP:');
define('ENTRY_NIP_ERROR', '');
define('ENTRY_NIP_TEXT', '');

define('ENTRY_GENDER', 'Пол:');
define('ENTRY_GENDER_ERROR', 'Вы должны указать свой пол.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Имя:');
define('ENTRY_FIRST_NAME_ERROR', 'Поле Имя должно содержать как минимум ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' символа.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Фамилия:');
define('ENTRY_LAST_NAME_ERROR', 'Поле Фамилия должно содержать как минимум ' . ENTRY_LAST_NAME_MIN_LENGTH . ' символа.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Дата рождения:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Дату рождения необходимо вводить в следующем формате: MM/DD/YYYY (пример 05/21/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (пример 05/21/1970)');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail:');
define('ENTRY_EMAIL_ADDRESS_CONFIRM', 'Подтвердите E-Mail:');
define('ENTRY_EMAIL_ADDRESS_CONFIRM_NOT_MATCHING', 'подтверждения должен сопрягать ваше e-mail.');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Поле E-Mail должно содержать как минимум ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' символов.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Ваш E-Mail адрес указан неправильно, попробуйте ещё раз.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Введённый Вами E-Mail уже зарегистрирован в нашем магазине, попробуйте указать другой E-Mail адрес.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Улица и номер дома:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Поле Улица и номер дома должно содержать как минимум ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' символов.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Район:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Почтовый индекс:');
define('ENTRY_POST_CODE_ERROR', 'Поле Почтовый индекс должно содержать как минимум ' . ENTRY_POSTCODE_MIN_LENGTH . ' символа.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Город:');
define('ENTRY_CITY_ERROR', 'Поле Город должно содержать как минимум ' . ENTRY_CITY_MIN_LENGTH . ' символа.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Область:');
define('ENTRY_STATE_ERROR', 'Поле Область должно содержать как минимум ' . ENTRY_STATE_MIN_LENGTH . ' символа.');
define('ENTRY_STATE_ERROR_SELECT', 'Выберите область.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Страна:');
define('ENTRY_COUNTRY_ERROR', 'Выберите страну.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Телефон:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Поле Телефон должно содержать как минимум ' . ENTRY_TELEPHONE_MIN_LENGTH . ' символа.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Факс:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Новости магазина:');
define('ENTRY_NEWSLETTER_OPIS', '(Извещение отклонения в любое время по возможности');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Подписаться');
define('ENTRY_NEWSLETTER_NO', 'Отказаться от подписки');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Пароль:');
define('ENTRY_PASSWORD_ERROR', 'Ваш пароль должен содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Поле Подтвердите пароль должно совпадать с полем Пароль.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', 'Подтвердите пароль:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Текущий пароль:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Поле Пароль должно содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_NEW', 'Новый пароль:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Ваш Новый пароль должен содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Поля Подтвердите пароль и Новый пароль должны совпадать.');
define('PASSWORD_HIDDEN', '--СКРЫТ--');

// BOC added for Account Agreement
define('ENTRY_AGREEMENT', ' Путем щелкать этой коробкой вы соглашаетесь что вы читали и согласовываете все термины и условия этого места.'); 
//Modify your account agreement here
define('ENTRY_AGREEMENT_ERROR', 'Вы должны проверить коробку согласования учета для того чтобы установить вверх accout.');
define('ENTRY_AGREEMENT_TEXT', '*');
define('TEXT_ACCOUNT_AGREEMENT','Согласование Учета');
// EOC added for Account Agreement

define('FORM_REQUIRED_INFORMATION', '* Обязательно для заполнения');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Страницы:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> позиций)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> заказов)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> отзывов)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> новинок)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> специальных предложений)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'Первая страница');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'предыдущая');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Следующая страница');
define('PREVNEXT_TITLE_LAST_PAGE', 'Последняя страница');
define('PREVNEXT_TITLE_PAGE_NO', 'Страница %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Предыдущие %d страниц');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Следующие %d страниц');
define('PREVNEXT_BUTTON_FIRST', 'ПЕРВАЯ');
define('PREVNEXT_BUTTON_PREV', 'Предыдущая');
define('PREVNEXT_BUTTON_NEXT', 'Следующая');
define('PREVNEXT_BUTTON_LAST', 'ПОСЛЕДНЯЯ');

define('IMAGE_BUTTON_ADD_ADDRESS', 'Добавить адрес');
define('IMAGE_BUTTON_ADDRESS_BOOK', 'Адресная книга');
define('IMAGE_BUTTON_BACK', 'Назад');
define('IMAGE_BUTTON_BUY_NOW', 'Купить сейчас');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Изменить адрес');
define('IMAGE_BUTTON_CHECKOUT', 'Оформить заказ');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Подтвердить Заказ');
define('IMAGE_BUTTON_CONTINUE', 'Продолжить');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Вернуться в магазин');
define('IMAGE_BUTTON_DELETE', 'Удалить');
define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Редактировать учетные данные');
define('IMAGE_BUTTON_HISTORY', 'История заказов');
define('IMAGE_BUTTON_LOGIN', 'Войти');
define('IMAGE_BUTTON_IN_CART', 'Добавить в Корзину');
define('IMAGE_BUTTON_NOTIFICATIONS', 'Уведомления');
define('IMAGE_BUTTON_QUICK_FIND', 'Быстрый поиск');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Удалить уведомления');
define('IMAGE_BUTTON_REVIEWS', 'Отзывы');
define('IMAGE_BUTTON_SEARCH', 'Искать');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Способы доставки');
define('IMAGE_BUTTON_TELL_A_FRIEND', 'Написать другу'); 
define('IMAGE_BUTTON_UPDATE', 'Обновить');
define('IMAGE_BUTTON_UPDATE_CART', 'Пересчитать');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Написать отзыв');

define('SMALL_IMAGE_BUTTON_DELETE', 'Удалить');
define('SMALL_IMAGE_BUTTON_EDIT', 'Изменить');
define('SMALL_IMAGE_BUTTON_VIEW', 'Смотреть');

define('ICON_ARROW_RIGHT', 'Перейти');
define('ICON_CART', 'В корзину');
define('ICON_ERROR', 'Ошибка');
define('ICON_SUCCESS', 'Выполнено');
define('ICON_WARNING', 'Внимание');

//define('TEXT_GREETING_PERSONAL', 'Добро пожаловать <span class="greetUser">%s!</span> Вы хотите посмотреть какие <a href="%s"><u>новые товары</u></a> поступили в наш магазин?');
define('TEXT_GREETING_PERSONAL', '');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Если Вы не %s, пожалуйста <a href="%s"><u>зарегистрируйтесь </u></a> и введите Вашу личную информацию.</small>');
//define('TEXT_GREETING_GUEST', 'Добро пожаловать <span class="greetUser">уважаемый гость</span><br> Если Вы наш постоянный клиент, <a href="%s"><u>введите Ваши персональные данные</u></a> для входа. Если Вы у нас впервые и хотите сделать покупки, Вам необходимо <a href="%s"><u>зарегистрироваться</u></a>.');
define('TEXT_GREETING_GUEST', '');

define('TEXT_SORT_PRODUCTS', 'Сортировка товаров ');
define('TEXT_DESCENDINGLY', 'по убыванию');
define('TEXT_ASCENDINGLY', 'по возрастанию');
define('TEXT_BY', ' по параметру ');

define('TEXT_REVIEW_BY', 'к %s');
define('TEXT_REVIEW_WORD_COUNT', '%s слова');
define('TEXT_REVIEW_RATING', 'Рейтинг: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Дата добавления: %s');
define('TEXT_NO_REVIEWS', 'К настоящему времени нет отзывов, Вы можете стать первым.');

define('TEXT_NO_NEW_PRODUCTS', 'Сегодня нет новых продуктов.');

define('TEXT_UNKNOWN_TAX_RATE', 'Налоговая ставка неизвестна');

define('TEXT_REQUIRED', '<span class="errorText">Обязательно</span>');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>ОШИБКА:</small> Невозможно отправить email через сервер SMTP. Проверьте, пожалуйста, Ваши установки php.ini и если необходимо, скорректируйте сервер SMTP.</b></font>');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Предупреждение: Не удалена директория установки магазина: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install. Пожалуйста, удалите эту директорию для безопасности.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Предупреждение: Файл конфигурации доступен для записи: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. Это - потенциальный риск безопасности - пожалуйста, установите необходимые права доступа к этому файлу.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Предупреждение: директория сессий не существует: ' . tep_session_save_path() . '. Сессии не будут работать пока эта директория не будет создана.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Предупреждение: Нет доступа к каталогу сессий: ' . tep_session_save_path() . '. Сессии не будут работать пока не установлены необходимые права доступа.');
define('WARNING_SESSION_AUTO_START', 'Предупреждение: опция session.auto_start включена - пожалуйста, выключите данную опцию в файле php.ini и перезапустите веб-сервер.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Предупреждение: Директория отсутствует: ' . DIR_FS_DOWNLOAD . '. Создайте директорию.');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Вы указали неверную дату истечения срока действия кредитной карточки.<br>Попробуйте ещё раз.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Вы указали неверный номер кредитной карточки.<br>Попробуйте ещё раз.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Первые цифры Вашей кредитной карточки: %s<br>Если Вы указали номер своей кредитной карточки правильно, сообщаем Вам, что мы не принимаем к оплате данный тип кредитных карточек.<br>Если Вы указали номер кредитной карточки неверно, попробуйте ещё раз.');

/*
  Poniższa informacja o prawie autorskim może być
  modyfikowana lub usunięta jedynie gdy wygląd serwisu
  został zmieniony i różni się od domyślnego zastrzeżonego
  prawem wyglądu osCommerce.

  Więcej informacji znajdziesz w FAQ na stronie wsparcia
  osCommerce:

        http://www.oscommerce.com/about/copyright

  Pozostaw ten komentarz nienaruszony wraz z następującą
  informacją o prawach autorskich.
*/
define('FOOTER_TEXT_BODY', '<b>Разработка ©2008 eSklep-Os </b>');

define('NAVBAR_TITLE', 'Регистрация');
define('ITEMS_IN_CART', 'В корзину');
define('NEW_PRODUCTS', 'Новинки');
define('TABLE_HEADING_PRICE', 'Цена');
define('HEADING_PRODUCT_INFO','Продукт');
define('ITEM_PRICE','Цена:');
define('HEADING_PRODUCT_REVIEWS','Текущие отзывы');
define('HEADING_CHOOS_LANG','Выберите');
define('PRODUCT_INFO_DESCRIPTION','Описание товаров');

//Star product Start
define('STAR_TITLE', 'Продукт Звезды'); // star product
define('STAR_READ_MORE', ' ... прочитайте больше'); // ... read more.
//Star product End

// Begin EZier new fields
define('TABLE_HEADING_RETAIL_PRICE', 'Цена');
define('TABLE_HEADING_SAVE', 'Вы Сохраняете'); 
define('TEXT_PRODUCTS_RETAIL_PRICE_INFO', 'Розничнаяа цена: ');
define('TEXT_PRODUCTS_PRICE_INFO', 'Цена: ');
define('TEXT_PRODUCTS_PRICE_INFO_REGULAR', 'Цена: ');
define('TEXT_PRODUCTS_SAVE_INFO', '<font color=red>Вы Сохраняете: ');
define('TEXT_PRODUCTS_RETAIL_PRICE', 'Розничнаяа цена: ');
define('TEXT_PRODUCTS_PRICE_SPECIAL_INFO', '<font color=red>Резка сниженная цена: ');
define('TEXT_PRODUCTS_PRICE_SPECIAL_CUST', '<font color=red>Резка сниженная цена: ');
// EZier new fields end

define('WHATS_NEW_ALL','Oсмотрите все');

//themes
define('BOX_HEADING_THEMES', 'Темы');

// START: Extra Infopages Manager
define('BOX_HEADING_PAGES', 'Информация');
// END: Extra Infopages Manager

//BEGIN allprods modification  
define('BOX_INFORMATION_ALLPRODS', 'Каталог продуктов');
//END allprods modification
 
define('ENTRY_NIP_NULL_ERROR', 'Вы должны написать NIP'); 
define('ENTRY_NIP_ERROR', 'Неправильный NIP');
define('ENTRY_NIP', 'Numer NIP:');
define('ENTRY_NIP_TEXT', '');

define('IMAGE_BUTTON_PRINT_ORDER', 'Печать заказа');

//TotalB2B start
define('PRICES_LOGGED_IN_TEXT','Быть внесено в журнал внутри для цен');
//TotalB2B end

//Kontakt Start
define('BOX_HEADING_KONTAKT','Контакт');
//Kontakt End

//Linki Start
define('BOX_HEADING_LINKI','Соединения');
//Linki End

// previous next product
define('PREV_NEXT_PRODUCT', 'Продукт');
define('PREV_NEXT_FROM', '/');
define('PREV_NEXT_IN_CATEGORY', 'в категории');

// box text in includes/boxes/advsearch.php
define('BOX_HEADING_ADVSEARCH', 'Поиск');
define('BOX_ADVSEARCH_KW', 'Слово:');
define('BOX_ADVSEARCH_PRICERANGE', 'Диапазона цен:');
define('BOX_ADVSEARCH_PRICESEP', ' к ');
define('BOX_ADVSEARCH_CAT', 'Категория:');
define('BOX_ADVSEARCH_ALLCAT', 'Любые');

// newsdesk box text in includes/boxes/newsdesk.php
define('TABLE_HEADING_NEWSDESK', 'Весточка и информация');
define('TEXT_NO_NEWSDESK_NEWS', 'Огорченно но не будет весточек');
define('TEXT_NEWSDESK_READMORE', 'Прочитайте Больше');
define('TEXT_NEWSDESK_VIEWED', 'Осмотрено:');

define('BOX_HEADING_NEWSDESK_CATEGORIES', 'Категории Весточки');
define('BOX_HEADING_NEWSDESK_LATEST', 'Запоздалаяа новость');

define('TEXT_DISPLAY_NUMBER_OF_ARTICLES', 'Показ <b>%d</b> k <b>%d</b> (<b>%d</b> статьи)');
define('TABLE_HEADING_NEWSDESK_SUBCAT', 'Весточка');
//END -- newsdesk

//START - GiftWrap
define('TEXT_ENTER_GIFTWRAP_INFORMATION', 'Выберите Вариант Упаковки');
//END - GiftWrap

//START - Additional Images
define('TEXT_ADDITIONAL_IMAGES', 'Дополнительные Изображения');
//END - Additional Images

// +Country-State Selector
define ('DEFAULT_COUNTRY', '170');
// -Country-State Selector

//recently viewed box
define('BOX_HEADING_RECENTLY_VIEWED','Недавн Осмотрено');
define('NO_RECENTLY_VIEWED','Осмотренное никакое продуктам');

// ################# Contribution Newsletter v050 ##############

// subscribers box text in includes/boxes/subscribers.php
define('BOX_HEADING_SUBSCRIBERS', 'Информационый бюллетень');
define('BOX_TEXT_SUBSCRIBE', 'Подпишитесь');
define('BOX_TEXT_UNSUBSCRIBE', 'Извлекайте');
define('TEXT_EMAIL_HTML','HTML');
define('TEXT_EMAIL_TXT','TXT');
define('TEXT_EMAIL','Адрес E-Mail:');
define('TEXT_EMAIL_FORMAT','Форма');
define('TEXT_EMAIL','Courriel');

define('TEXT_NAME', 'Ваше Имя:');
// Unsubscribe
define('UNSUBSCRIBE_TEXT','Извлекайте : ');
define('TEXT_BOX1','Зарегистрированные клиенты идут к: ');
define('TEXT_BOX2','Ваш Учет: ');
// ################# Contribution Newsletter v050 ##############

// Sorter for product_info.php
define('PRODUCTS_OPTIONS_SORT_BY_PRICE','1'); // 1= sort by products_options_sort_order + name; 0= sort by products_options_sort_order + price

// Categories Image and Name on product_info.php
define('SHOW_CATEGORIES','0'); // 0= off  1=on
define('TABLE_HEADING_MANUFACTURER', 'Производитель');

define('BOX_INFORMATION_SITEMAP', 'Карта Места');

define('TEMPORARY_NO_PRICE', 'Отсутствие Цены');
define('PRODUCT_SOLD', 'Продано');

//kgt - discount coupons
define('ENTRY_DISCOUNT_COUPON_ERROR', 'Кодий талона, котор вы вписывали не действительно.');
define('ENTRY_DISCOUNT_COUPON_AVAILABLE_ERROR', 'Кодий талона, котор вы вписывали никакие длинние действительными.');
define('ENTRY_DISCOUNT_COUPON_USE_ERROR', 'Наши показатели показывают что вы использовали этот талон %s время.  Вы не можете использовать это Кодего больше чем %s время.');
define('ENTRY_DISCOUNT_COUPON_MIN_PRICE_ERROR', 'Минимальный итог заказа для этого талона %s');
define('ENTRY_DISCOUNT_COUPON', 'Кодий Талона:');
define('ENTRY_DISCOUNT_COUPON_FREE_SHIPPING_ERROR', 'Ваш итог заказа теперь под свободно минимумом перевозкы груза.');
define('ENTRY_DISCOUNT_COUPON_MIN_QUANTITY_ERROR', 'Минимальный число продуктов необходимо для этого талона %s');
define('ENTRY_DISCOUNT_COUPON_EXCLUSION_ERROR', 'Некоторые или весь из продуктов в вашей тележке исключены.' );
define('ENTRY_DISCOUNT_COUPON_SHIPPING_CALC_ERROR', 'Ваши высчитанные расход по перевозке изменяли.');
//end kgt - discount coupons

define('SHOPPING_CART_QUANTITY', 'szt.');
define('BOX_HEADING_ADVERTISE', 'Знамена');

define('TABLE_HEADING_IMAGE', '');
define('TABLE_HEADING_MODEL', 'Код товара');
define('TABLE_HEADING_PRODUCTS', 'Наименование');
define('TABLE_HEADING_MANUFACTURER', 'Производитель');
define('TABLE_HEADING_QUANTITY', 'Количество');
define('TABLE_HEADING_PRICE', 'Цена');
define('TABLE_HEADING_WEIGHT', 'Вес');
define('TABLE_HEADING_BUY_NOW', 'Купить');
define('TABLE_HEADING_PRODUCTS_AVAILABILITY', 'Наличие');

define('TEXT_NO_PRODUCTS', 'Нет ни одного товара в этом разделе.');
define('TEXT_BUY', 'Купить \'');
define('TEXT_NOW', '\' сейчас');

//Who's online BOX
define('BOX_HEADING_WHOS_ONLINE', 'Kto jest online');
define('BOX_WHOS_ONLINE_THEREIS', 'Obecnie w sklepie jest');
define('BOX_WHOS_ONLINE_THEREARE', 'Obecnie w sklepie jest');
define('BOX_WHOS_ONLINE_GUEST', 'Gość');
define('BOX_WHOS_ONLINE_GUESTS', 'Gości');
define('BOX_WHOS_ONLINE_AND', 'i');
define('BOX_WHOS_ONLINE_MEMBER', 'Klient');
define('BOX_WHOS_ONLINE_MEMBERS', 'Klienci');

define('BOX_SHOPPING_CART_QUANTITY', 'Количеств продукции');
define('BOX_SHOPPING_CART_TOTAL', 'Итог');

define('BOX_HEADING_PLATNOSCI', 'Компенсация Online');

define('RECENTLY_VIEWED_BOX_HEADING','Недавн осмотрено');   // box heading

define('TEXT_KOMUNIKAT','Информация');   // box heading
define('TEXT_ZAMKNIJ','Конец'); 
define('TEXT_UWAGA','ПРЕДУПРЕЖДЕНИЕ'); 

// nowe
define('POLA_OBOWIAZKOWE','Pola znaczone * są obowiązkowe do wypełnienia');
define('CATEGORY_OSOBA','Wybór osobowości prawnej');
define('OSOBA_TEXT','Proszę wybrać rodzaj osobowości prawnej nowego użytkownika:');
define('FORM_OSOBA_FIZYCZNA','Osoba fizyczna'); 
define('FORM_OSOBA_PRAWNA',"Firma");
define('ZGODA_DANE_OSOBOWE','');
define('PRZETWARZANIE_DANYCH','');
define('TABLE_HEADING_DOKUMENT_SPRZEDAZY','Dokument sprzedaży');
define('TEXT_SELECT_DOKUMENT_SPRZEDAZY','Wybierz dokument sprzedaży.');
define('TEXT_PARAGON','');
define('TEXT_FAKTURA','');
define('FAKTURA_NIP','(Brak numeru NIP w danych klienta. Brak możliwosci wystawienia faktury.)');

define('TEXT_NETTO',' исклучая ТЯГЛО');
define('TEXT_BRUTTO',' включая ТЯГЛО');

//pozycje menu
define('HEADER_TITLE_HOME','Домашн');
define('HEADER_TITLE_SPECIALS','Супер');
define('HEADER_TITLE_SEARCH','Поиск');
define('HEADER_TITLE_NEWS','Весточка');
define('HEADER_TITLE_CONTACTS','Контакты');

define('HEADING_NEWSDESK_STICKY' , 'Важные информации');
?>