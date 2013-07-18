<?php
/*
  $Id: \includes\boxes\newsdesk_latest.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

// set application wide parameters
// this query set is for NewsDesk
$configuration_query = tep_db_query("select configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_NEWSDESK_CONFIGURATION . "");
while ($configuration = tep_db_fetch_array($configuration_query)) {
	define($configuration['cfgKey'], $configuration['cfgValue']);
}

$boxHeading = 'SPECJALNIE DLA CIEBIE ...';
$corner_left = 'rounded';
$corner_right = 'rounded';
$box_base_name = 'newsdesk_latest'; // for easy unique box template setup (added BTSv1.2)

$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

if ( DISPLAY_LATEST_NEWS_BOX ) {

 $configuration_query = tep_db_query("select configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_NEWSDESK_CONFIGURATION . "");
 while ($configuration = tep_db_fetch_array($configuration_query)) {
	define($configuration['cfgKey'], $configuration['cfgValue']);
 }


 $latest_news_var_query = tep_db_query(
 'select p.newsdesk_id, pd.language_id, pd.newsdesk_article_name, pd.newsdesk_article_description, pd.newsdesk_article_shorttext, pd.newsdesk_article_url, pd.newsdesk_article_url_name,  p.newsdesk_image, p.newsdesk_date_added, p.newsdesk_last_modified, p.newsdesk_date_available, p.newsdesk_status  from ' . TABLE_NEWSDESK . ' p, ' . TABLE_NEWSDESK_DESCRIPTION . ' pd WHERE pd.newsdesk_id = p.newsdesk_id and pd.language_id = "' . $languages_id . '" and newsdesk_status = 1 ORDER BY RAND() LIMIT 1');

 if (!tep_db_num_rows($latest_news_var_query)) { // there is no news
  //	echo '<!-- ' . TEXT_NO_NEWSDESK_NEWS . ' -->';
 } else {

  $boxContent = '<table border="0" width="90%" cellspacing="0" cellpadding="1" align="center">';
  while ($latest_news = tep_db_fetch_array($latest_news_var_query))  {
   $boxContent .= '<tr><td class="boxContents" width="100%" align="left">' . $latest_news['newsdesk_article_shorttext'] . '</td></tr>';
   $boxContent .= '<tr><td class="boxContents" width="100%" height="5"></td></tr>';
   $boxContent .= '<tr><td class="boxContents" width="100%" align="right"><a class="boxLink" href="'.tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdesk_id=' . $latest_news['newsdesk_id']) . '">'.STAR_READ_MORE.'</a></td></tr>';
  }
  $boxContent .= '</table>';
  include (bts_select('boxes', $box_base_name)); // BTS 1.5

 }

} else {
}
?>
