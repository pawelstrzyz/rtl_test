<?php
/* $Id: newsdeskincategory.php v1.0 2007/03/21

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Released under the GNU General Public License

 mod eSklep-Os http://www.esklep-os.com
*/

class NewsdeskInCategory {
	var $pic_data = array();

	function NewsdeskInCategory() {
		global $languages_id;
		
		$newsdesk_query = tep_db_query("select p2c.categories_id, p.newsdesk_id, p.newsdesk_status, pd.newsdesk_article_name as newsdesk, pd.newsdesk_id as newsdesk_id from " . TABLE_NEWSDESK . " p LEFT JOIN " . TABLE_NEWSDESK_TO_CATEGORIES . " p2c USING(newsdesk_id) LEFT JOIN " . TABLE_NEWSDESK_DESCRIPTION . " pd USING(newsdesk_id) where pd.language_id = '" . (int)$languages_id . "' AND p.newsdesk_status='1' order by p2c.categories_id, pd.newsdesk_article_name");
            
    while ($newsdesk_info = tep_db_fetch_array($newsdesk_query)) {
       $this->addNewsdeskInCategory($newsdesk_info['categories_id'], $newsdesk_info);
    } // end while ($newsdesk_info = tep_db_fetch_array($newsdesk_query))
  } // end function NewsdeskInCategory
        
  function addNewsdeskInCategory ($categories_id, $newsdesk_info) {
        $this->pic_data[$categories_id][] = array('newsdesk_id' => $newsdesk_info['newsdesk_id'],
                                                  'newsdesk_article_name' => $newsdesk_info['newsdesk'],
                                                  // we already know the category but might be handy to have it here too
                                                  'newsdesk_category' => $categories_id);
  } // end function addNewsdeskInCategory ($categories_id, $newsdesk_info)

  function getNewsdeskInCategory($categories_id) {
    if (isset($this->pic_data[$categories_id])){
       foreach ($this->pic_data[$categories_id] as $key => $_newsdesk_data) {
          $newsdesk_data[] = $_newsdesk_data;
       } // end foreach
       return $newsdesk_data;
    }else{
       return false;
    }
  } // end function getNewsdeskInCategory($categories_id)
} // end Class NewsdeskInCategory
?>