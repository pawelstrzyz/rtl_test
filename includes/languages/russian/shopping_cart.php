<?php
define('NAVBAR_TITLE', 'Содержимое корзины');
define('HEADING_TITLE', 'Моя корзина');
define('TABLE_HEADING_REMOVE', 'Удалить');
define('TABLE_HEADING_QUANTITY', 'Количество');
define('TABLE_HEADING_MODEL', 'Код товара');
define('TABLE_HEADING_PRODUCTS', 'Товары');
define('TABLE_HEADING_TOTAL', 'Стоимость');
define('TEXT_CART_EMPTY', 'Ваша корзина пуста!');
define('SUB_TITLE_SUB_TOTAL', 'Общая стоимость:');
define('SUB_TITLE_TOTAL', 'Итого:');
define('OUT_OF_STOCK_CANT_CHECKOUT', 'Товары, выделенные ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' имеются на нашем складе в недостаточном для Вашего заказа количестве.<br>Пожалуйста, измените количество продуктов выделенных (' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '), благодарим Вас');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'Товары, выделенные ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' имеются на нашем складе в недостаточном для Вашего заказа количестве.<br>Тем не менее, Вы можете купить их и проверить количество имеющихся в наличии для поэтапной доставки в процессе выполнения Вашего заказа.');
define('TEXT_NOT_AVAILABLEINSTOCK', '<small> (этот продукт не находится в штоке - будет приказано для вас!)</small>');
define('TEXT_ONLY_THIS_AVAILABLEINSTOCK1', '<small> (только ');
define('TEXT_ONLY_THIS_AVAILABLEINSTOCK2', ' части в штоке в настоящее время - остальные будут приказаны для вас!)</small>');
//BOF Minimalne zamowienie
define('TEXT_ORDER_UNDER_MIN_AMOUNT', 'Минимальным количеством заказа %s будет необходимо проверка.');
//EOF Minimalne zamowienie
define('MAXIMUM_ORDER_NOTICE', "Максимальное количество заказа для %s - %d. Ваша тележка была уточнена для того чтобы отразить это.");
define('MAXIMUM_ORDER_DUPLICATE', "Максимальное количество заказа для %s - %d. Вы уже имеете одно в вашей тележке. Если вы хотите по-разному варианты, то вы извлечь их от вашей тележки сперва.");
define('TEXT_ALTERNATIVE_CHECKOUT_METHODS', '- OR -');
?>