<?php
/*
  $Id: column_left.php 185 2008-03-26 20:47:00Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

$column_query = tep_db_query('select configuration_column as cfgcol, configuration_title as cfgtitle, configuration_value as cfgvalue from ' . TABLE_THEME_CONFIGURATION . ' order by location');

while ($column = tep_db_fetch_array($column_query)) {
	$column['cfgtitle'] = str_replace(' ', '_', $column['cfgtitle']);
  $column['cfgtitle'] = str_replace("'", '', $column['cfgtitle']);

	if ( ($column[cfgvalue] == 'yes') && ($column[cfgcol] == 'left')) {
		if ( file_exists(DIR_WS_TEMPLATES . 'local_boxes/' . $column['cfgtitle'] . '.php') ) {

			if ((USE_CACHE == 'true') && empty($SID) && ($column['cfgtitle'] == 'categories') ) {
					 echo tep_cache_categories_box();
			} else if ((USE_CACHE == 'true') && empty($SID) && ($column['cfgtitle'] == 'best_sellers') ) {
					 echo tep_cache_best_sellers_box();
			} else if ((USE_CACHE == 'true') && empty($SID) && ($column['cfgtitle'] == 'manufacturers') ) {
					 echo tep_cache_manufacturers_box();
			} else if ((USE_CACHE == 'true') && empty($SID) && ($column['cfgtitle'] == 'manufacturers_std') ) {
					 echo tep_cache_manufacturers_std_box();
			} else {
						require(DIR_WS_TEMPLATES . 'local_boxes/' . $column['cfgtitle'] . '.php');
			}
		} else {
			if ( file_exists(DIR_WS_BOXES . $column['cfgtitle'] . '.php') ) {

				if ((USE_CACHE == 'true') && empty($SID) && ($column['cfgtitle'] == 'categories') ) {
						 echo tep_cache_categories_box();
				} else if ((USE_CACHE == 'true') && empty($SID) && ($column['cfgtitle'] == 'best_sellers') ) {
						 echo tep_cache_best_sellers_box();
				} else if ((USE_CACHE == 'true') && empty($SID) && ($column['cfgtitle'] == 'manufacturers') ) {
						 echo tep_cache_manufacturers_box();
				} else if ((USE_CACHE == 'true') && empty($SID) && ($column['cfgtitle'] == 'manufacturers_std') ) {
						 echo tep_cache_manufacturers_std_box();
				} else {
							require(DIR_WS_BOXES . $column['cfgtitle'] . '.php');
				}
			}
		} 
	}
}
?>