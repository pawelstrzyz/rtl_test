<?php
/*

  mod eSklep-Os http://www.esklep-os.com

*/

require('includes/application_top.php');
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEWSDESK_REVIEWS_INFO);

// lets retrieve all $HTTP_GET_VARS keys and values..
$get_params = tep_get_all_get_params(array('reviews_id'));
$get_params = substr($get_params, 0, -1); //remove trailing &

if ($HTTP_GET_VARS['newsdesk_id']) {
	$model_query = tep_db_query("select newsdesk_article_name from " . TABLE_NEWSDESK_DESCRIPTION . " where newsdesk_id = '" . $HTTP_GET_VARS['newsdesk_id'] . "'");

	$model = tep_db_fetch_array($model_query);
	$breadcrumb->add($model['newsdesk_article_name'], tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdeskPath=' . $newsPath . '&newsdesk_id=' . $HTTP_GET_VARS['newsdesk_id']));

}

  $content = CONTENT_NEWSDESK_REVIEWS_INFO;

  include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');

?>