<?php
/*

  mod eSklep-Os http://www.esklep-os.com
*/

require('includes/functions/newsdesk_general.php');
require('includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEWSDESK_INFO);

// set application wide parameters
// this query set is for NewsDesk

$configuration_query = tep_db_query("select configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_NEWSDESK_CONFIGURATION . "");
while ($configuration = tep_db_fetch_array($configuration_query)) {
	define($configuration['cfgKey'], $configuration['cfgValue']);
}

// lets retrieve all $HTTP_GET_VARS keys and values..
$get_params = tep_get_all_get_params();
$get_params_back = tep_get_all_get_params(array('reviews_id')); // for back button
$get_params = substr($get_params, 0, -1); //remove trailing &
if ($get_params_back != '') {
    $get_params_back = substr($get_params_back, 0, -1); //remove trailing &
} else {
    $get_params_back = $get_params;
}

// BOF Wolfen added code to retrieve backpath
$get_backpath = tep_get_all_get_params();
$get_backpath_back = tep_get_all_get_params(array('newdesk_id')); // for back button
$get_backpath = substr($get_backpath, 0, -15); //remove trailing &
if ($get_backpath_back != '') {
    $get_backpath_back = substr($get_backpath_back, 0, -15); //remove trailing &
} else {
    $get_backpath_back = $get_backpath;
}
// EOF Wolfen added code to retrieve backpath

// BOF Added by Wolfen
// calculate category path
if ($HTTP_GET_VARS['newsdeskPath']) {
	$newsPath = $HTTP_GET_VARS['newsdeskPath'];
} elseif ($HTTP_GET_VARS['newsdesk_id'] && !$HTTP_GET_VARS['newsdeskPath']) {
	$newsPath = newsdesk_get_product_path($HTTP_GET_VARS['newsdesk_id']);
} else {
	$newsPath = '';
}

if (strlen($newsPath) > 0) {
	$newsPath_array = newsdesk_parse_category_path($newsPath);
	$newsPath = implode('_', $newsPath_array);
	$current_category_id = $newsPath_array[(sizeof($newsPath_array)-1)];
} else {
	$current_category_id = 0;
}

if (isset($newsPath_array)) {
	$n = sizeof($newsPath_array);
	for ($i = 0; $i < $n; $i++) {
		$categories_query = tep_db_query(
		"select categories_name from " . TABLE_NEWSDESK_CATEGORIES_DESCRIPTION . " where categories_id = '" . $newsPath_array[$i] . "' and language_id='" . $languages_id . "'"
	);
	if (tep_db_num_rows($categories_query) > 0) {
		$categories = tep_db_fetch_array($categories_query);
		$breadcrumb->add($categories['categories_name'], tep_href_link(FILENAME_NEWSDESK_INDEX, 'newsPath=' . implode('_', array_slice($newsPath_array, 0, ($i+1)))));
	} else {
		break;
	}
	}
} 

if ($HTTP_GET_VARS['newsdesk_id']) {
	$model_query = tep_db_query("select newsdesk_article_name from " . TABLE_NEWSDESK_DESCRIPTION . " where newsdesk_id = '" . $HTTP_GET_VARS['newsdesk_id'] . "'");

	$model = tep_db_fetch_array($model_query);
	$breadcrumb->add($model['newsdesk_article_name'], tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdeskPath=' . $newsPath . '&newsdesk_id=' . $HTTP_GET_VARS['newsdesk_id']));

}
// EOF Added by Wolfen


  $content = CONTENT_NEWSDESK_INFO;

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');

?>
