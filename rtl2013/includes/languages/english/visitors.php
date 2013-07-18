<?php
define('TOP_BAR_TITLE', 'Statystyki sklepu');
define('NAVBAR_TITLE', 'Statystyki sklepu');
define('HEADING_TITLE', 'Statystyki sklepu');
define('CHART_BOX_TITLE', 'Wykresy');
define('HEADING_TITLE_SEARCH', 'Szukaj:');
define('TABLE_HEADING_NUMBER', 'Id.');
define('TABLE_HEADING_DATE', 'Wejście');
define('TABLE_HEADING_LAST', 'Ostatnie<br>wejście');
define('TABLE_HEADING_TRACE_DATE', 'Data');
define('TABLE_HEADING_TRACE_TIME', 'Czas');
define('TABLE_HEADING_ONLINE', 'Czas online H:M:S');
define('TABLE_HEADING_COUNTER', 'Stron<br>wyświetlonych');
define('TABLE_HEADING_CUSTOMER', 'Klient');
define('TABLE_HEADING_IP', 'Adres<br>IP');
define('TABLE_HEADING_BLANGUAGE', 'Język<br>przeglądarki');
define('TABLE_HEADING_LANGUAGE', 'Wybrany<br>język');
define('TABLE_HEADING_REFERER', 'Odnośnik');
define('TABLE_HEADING_URI', 'Strona wejścia');
define('TABLE_HEADING_KEYWORD_NAME', 'Słowa');
define('TABLE_HEADING_KEYWORD_NUMBER', 'Ile razy użyte');
define('TABLE_HEADING_FOOTER_COUNT', 'Razem wyświetleń:');
define('STATISTICS_TYPE_REPORT_A', 'Wizyt');
define('STATISTICS_TYPE_REPORT_B', 'Wyświetleń');
define('STATISTICS_TYPE_REPORT_C', 'Inne');
define('STATISTICS_HEADING_HOURS', 'Godziny');
define('STATISTICS_HEADING_DAYS', 'Dni');
define('STATISTICS_HEADING_OTHER_DATE', 'Inne - data / Czas');
define('STATISTICS_HEADING_OTHER_VALUE', 'Inne');
define('STATISTICS_HEADING_X', 'Wykresy - X');
define('STATISTICS_HEADING_Y', 'Wykresy - Y');
define('STATISTICS_TYPE_REPORT_1', 'Ostatnie 24 godziny');
define('STATISTICS_TYPE_REPORT_2', 'Pokaż dni w tym miesiącu');
define('STATISTICS_TYPE_REPORT_3', 'Pokaż miesiące w tym roku');
define('STATISTICS_TYPE_REPORT_4', 'Suma wizyt ten rok');
define('STATISTICS_TYPE_REPORT_5', 'Godzinowo');
define('STATISTICS_TYPE_REPORT_6', 'Tygodniowo');
define('STATISTICS_TYPE_REPORT_7', 'Średnia wszystkie IP - dni');
define('STATISTICS_TYPE_REPORT_8', 'Suma wydług języka przeglądarki');
define('STATISTICS_TYPE_REPORT_9', 'Suma według czasu online');
define('STATISTICS_TYPE_REPORT_10', 'Szukane słowa ostatnie ' . KEYWORD_DURATION . ' dni');
define('STATISTICS_TYPE_REPORT_11', 'Suma według IP kraju');
define('STATISTICS_TYPE_REPORT_12', 'Suma według języka przeglądarki');
define('STATISTICS_TYPE_REPORT_13', 'Suma według IP kraju');
define('STATISTICS_TYPE_REPORT_20', 'Wczoraj godzinowo');
define('STATISTICS_TYPE_REPORT_21', 'Ostatni tydzień');
define('STATISTICS_TYPE_REPORT_22', 'Dni ostatnie dwa miesiące');
define('STATISTICS_TYPE_REPORT_23', 'Ostatnie 24 godziny');
define('STATISTICS_TYPE_REPORT_24', 'Dni ten miesiąc');
define('STATISTICS_TYPE_REPORT_25', 'Miesiące ten rok');
define('STATISTICS_TYPE_REPORT_26', 'Suma ten rok');
define('STATISTICS_TYPE_REPORT_27', 'Suma według godzin');
define('STATISTICS_TYPE_REPORT_28', 'Dni miesiąca ten rok');
define('STATISTICS_TYPE_REPORT_29', 'Wczoraj godzinowo');
define('STATISTICS_TYPE_REPORT_30', 'Dni ostatni tydzień');
define('STATISTICS_TYPE_REPORT_31', 'Dni ostatnie dwa miesiące');
define('STATISTICS_TYPE_REPORT_32', 'Trend ten rok');
define('STATISTICS_TYPE_REPORT_33', 'Trend ten rok');
define('STATISTICS_TYPE_REPORT_34', 'Suma minut online');
define('STATISTICS_TYPE_REPORT_35', 'Dni w tygodniu');
define('STATISTICS_TYPE_REPORT_36', 'Dni w tygodniu');
define('STATISTICS_TYPE_REPORT_37', 'Kwartały ten rok');
define('STATISTICS_TYPE_REPORT_38', 'Kwartały ten rok');
define('STATISTICS_TYPE_REPORT_39', 'Suma tygodnie ten rok');
define('STATISTICS_TYPE_REPORT_40', 'Suma tygodnie ten rok');
define('STATISTICS_TYPE_REPORT_41', 'Srednia godzinowo');
define('STATISTICS_TYPE_REPORT_42', 'Według miesięcy ten rok');
define('STATISTICS_TYPE_REPORT_43', 'Dni ostatni miesiąc');
define('STATISTICS_TYPE_REPORT_44', 'Wydług dni ostatni miesiąc');
define('STATISTICS_TYPE_REPORT_45', 'Według miesięcy ten rok');
define('HEADING_TYPE_DAILY', 'Miesiąc');
define('HEADING_TYPE_MONTHLY', 'Rok');
define('HEADING_TYPE_YEARLY', 'Wszystkie lata');
define('TITLE_TYPE', 'Wybór:');
define('TITLE_YEAR', 'Rok:');
define('TITLE_MONTH', 'Miesiąc:');
define('TOTAL_HITS', 'Razem:');
define('BUTTON_REFRESH', 'odśwież tabelę');
define('RANGE_TO', 'do:');
define('RANGE_FROM', 'od:');
// How many Countries shall I show in the Country Chart excluding Robots and Others?
// Default number is set to 19 in the main program, change it here if you wish.
define('NO_COUNTRIES_FOR_CHART', '19');
$GEOIP_COUNTRY_NAMES = array(
"Unknown/LAN", "Asia/Pacific Region", "Europe", "Andorra", "United Arab Emirates",
"Afghanistan", "Antigua and Barbuda", "Anguilla", "Albania", "Armenia",
"Netherlands Antilles", "Angola", "Antarctica", "Argentina", "American Samoa",
"Austria", "Australia", "Aruba", "Azerbaijan", "Bosnia and Herzegovina",
"Barbados", "Bangladesh", "Belgium", "Burkina Faso", "Bulgaria", "Bahrain",
"Burundi", "Benin", "Bermuda", "Brunei Darussalam", "Bolivia", "Brazil",
"Bahamas", "Bhutan", "Bouvet Island", "Botswana", "Belarus", "Belize",
"Canada", "Cocos (Keeling) Islands", "Congo, The Democratic Republic of the",
"Central African Republic", "Congo", "Switzerland", "Cote D'Ivoire", "Cook
Islands", "Chile", "Cameroon", "China", "Colombia", "Costa Rica", "Cuba", "Cape
Verde", "Christmas Island", "Cyprus", "Czech Republic", "Germany", "Djibouti",
"Denmark", "Dominica", "Dominican Republic", "Algeria", "Ecuador", "Estonia",
"Egypt", "Western Sahara", "Eritrea", "Spain", "Ethiopia", "Finland", "Fiji",
"Falkland Islands (Malvinas)", "Micronesia, Federated States of", "Faroe
Islands", "France", "France, Metropolitan", "Gabon", "United Kingdom",
"Grenada", "Georgia", "French Guiana", "Ghana", "Gibraltar", "Greenland",
"Gambia", "Guinea", "Guadeloupe", "Equatorial Guinea", "Greece", "South Georgia
and the South Sandwich Islands", "Guatemala", "Guam", "Guinea-Bissau",
"Guyana", "Hong Kong", "Heard Island and McDonald Islands", "Honduras",
"Croatia", "Haiti", "Hungary", "Indonesia", "Ireland", "Israel", "India",
"British Indian Ocean Territory", "Iraq", "Iran, Islamic Republic of",
"Iceland", "Italy", "Jamaica", "Jordan", "Japan", "Kenya", "Kyrgyzstan",
"Cambodia", "Kiribati", "Comoros", "Saint Kitts and Nevis", "Korea, Democratic
People's Republic of", "Korea, Republic of", "Kuwait", "Cayman Islands",
"Kazakstan", "Lao People's Democratic Republic", "Lebanon", "Saint Lucia",
"Liechtenstein", "Sri Lanka", "Liberia", "Lesotho", "Lithuania", "Luxembourg",
"Latvia", "Libyan Arab Jamahiriya", "Morocco", "Monaco", "Moldova, Republic
of", "Madagascar", "Marshall Islands", "Macedonia, the Former Yugoslav Republic
of", "Mali", "Myanmar", "Mongolia", "Macau", "Northern Mariana Islands",
"Martinique", "Mauritania", "Montserrat", "Malta", "Mauritius", "Maldives",
"Malawi", "Mexico", "Malaysia", "Mozambique", "Namibia", "New Caledonia",
"Niger", "Norfolk Island", "Nigeria", "Nicaragua", "Netherlands", "Norway",
"Nepal", "Nauru", "Niue", "New Zealand", "Oman", "Panama", "Peru", "French
Polynesia", "Papua New Guinea", "Philippines", "Pakistan", "Poland", "Saint
Pierre and Miquelon", "Pitcairn", "Puerto Rico", "Palestinian Territory,
Occupied", "Portugal", "Palau", "Paraguay", "Qatar", "Reunion", "Romania",
"Russian Federation", "Rwanda", "Saudi Arabia", "Solomon Islands",
"Seychelles", "Sudan", "Sweden", "Singapore", "Saint Helena", "Slovenia",
"Svalbard and Jan Mayen", "Slovakia", "Sierra Leone", "San Marino", "Senegal",
"Somalia", "Suriname", "Sao Tome and Principe", "El Salvador", "Syrian Arab
Republic", "Swaziland", "Turks and Caicos Islands", "Chad", "French Southern
Territories", "Togo", "Thailand", "Tajikistan", "Tokelau", "Turkmenistan",
"Tunisia", "Tonga", "East Timor", "Turkey", "Trinidad and Tobago", "Tuvalu",
"Taiwan", "Tanzania, United Republic of", "Ukraine",
"Uganda", "United States Minor Outlying Islands", "United States", "Uruguay",
"Uzbekistan", "Holy See (Vatican City State)", "Saint Vincent and the
Grenadines", "Venezuela", "Virgin Islands, British", "Virgin Islands, U.S.",
"Vietnam", "Vanuatu", "Wallis and Futuna", "Samoa", "Yemen", "Mayotte",
"Yugoslavia", "South Africa", "Zambia", "Zaire", "Zimbabwe"
);
define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', 'Error: Graphs directory does not exist. Please create a \'graphs\' directory inside \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE', 'Error: Graphs directory is not writeable.');
define('SORT_UP', 'Sortuj A-Z');
define('SORT_DOWN', 'Sortuj Z-A');
define('TOP', 'Powrót');
define('DISPLAY_HITS', 'wyświetlenia');
define('CHART_TITLE', 'Statystyka - ' . DISPLAY_HITS);
define('TABLE_HEADING_TABLE', DISPLAY_HITS);
define('CHART_X', TABLE_HEADING_NUMBER);
define('CHART_Y', 'Actual');
define('TEXT_HEADING_DELETE', 'Usuwanie opcje');
define('TEXT_FOOTER_DELETE', 'Wybierz opcję aby potwierdzić na następnej stronie');
define('TEXT_HEADING_EMPTY', 'Usuń wszystko');
define('TEXT_HEADING_ROBOTS', 'Usuń wyszukiwarki');
define('TEXT_HEADING_GUESTS', 'Usuń gości');
define('TEXT_HEADING_DATE', 'Usuń według daty');
define('TEXT_HEADING_BY_ID', 'Usuń według ID');
define('TEXT_EDIT_EMPTY', 'Potwierdź aby usuną wszystko:');
define('TEXT_EDIT_ROBOTS', 'Potwierdź aby usuną wejścia robotów:');
define('TEXT_EDIT_GUESTS', 'Potwierdź aby usuną wejścia gości:');
define('TEXT_EDIT_DATE', 'Potwierdź aby usuną wejścia wybrane według daty:');
define('TEXT_EDIT_BY_ID', 'Potwierdź aby usuną wejścia według ID:');
define('TITLE_DAY', 'Przedwczoraj');
define('TITLE_MONTH', 'Poprzedni miesiąc');
define('TITLE_YEAR', 'Poprzedni rok');
define('IMAGE_DELETE_BY_ID', 'Usuń według ID');
define('IMAGE_DELETE_DATE', 'Usuń według daty');
define('IMAGE_DELETE_ROBOTS', 'Usuń roboty');
define('IMAGE_DELETE_GUESTS', 'Usuń gości');
define('ROBOT_SWITCH_LIMITED', 'Kliknij na czerwone aby wykluczyć roboty');
define('ROBOT_SWITCH_FULL', 'Kliknij na zielone aby pokazać roboty');
define('VISITOR_ICON_FULL_ACTIVE', 'Roboty wyświetlane');
define('VISITOR_ICON_LIMITED', 'Kliknij na czerwone aby wykluczyć roboty');
define('VISITOR_ICON_FULL', 'Kliknij na zielone aby pokazać roboty');
define('VISITOR_ICON_LIMITED_ACTIVE', 'Roboty nie wyświetlane');
define('GUEST', 'Gość');
define('BUTTON_REFRESH_CHART', 'Odśwież wykres');
define('BUTTON_REFRESH_TEXT', '<font class="smalltext" color="#FF0000">Tutaj kliknij aby odświeżyć wykres</font>');
define('ERROR_NO_DATA', 'Nic nie będzie usunięte!');
define('POPUP_CLOSE', 'Dodaj więcej lub <a href="Javascript:close()">[Zamkninij okienko]</a>');
define('BOX_TITLE_TRACE', 'Przeglądane strony');
define('TABLE_ROOT', 'Strona główna');
define('TABLE_DIRECT', 'Bezpośrednio');
define('TABLE_HEADING_HOST', 'Host');
?>