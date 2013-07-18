<?php
/* $Id: ProductsInCategory.php v1.0 2007/02/16
	an object to store the products within each category once queried by the box dm_categories.php
	to avoid it being queried multiple times
	
osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2007 osCommerce

Released under the GNU General Public License
*/

  class ProductsInCategory {
	var $pic_data = array();

	function ProductsInCategory() {
	  global $languages_id;
	  $products_query = tep_db_query("select p2c.categories_id, p.products_id, p.products_status, pd.products_name as product, pd.products_id as product_id from " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c USING(products_id) LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd USING(products_id) where pd.language_id = '" . (int)$languages_id . "' AND p.products_status='1' order by p2c.categories_id, pd.products_name");      
      while ($product_info = tep_db_fetch_array($products_query)) {
        $this->addProductsInCategory($product_info['categories_id'], $product_info);
      } // end while ($product_info = tep_db_fetch_array($products_query))
    } // end function ProductsInCategory
        
    function addProductsInCategory ($categories_id, $product_info) {
	  // BOF Product Name limiter v1
	  $products_name_length_set = 16; // change to the maximum menu product name length before trucating ************
	  $temp_product_name = str_replace(' ','^', $product_info['product']);
	  if (strlen($temp_product_name) > $products_name_length_set) {
	    $temp_product_name = substr($temp_product_name,0,$products_name_length_set-2);
		if (substr($temp_product_name, strlen($temp_product_name)-1,1) == '^') {
		  $temp_product_name = substr($temp_product_name, 0, strlen($temp_product_name)-1);
		}
		$temp_product_name .= "...";
		$product_name_limiter = str_replace('^', ' ', $temp_product_name);
	  } else {
   	    $product_name_limiter = $product_info['product'];
	  }
	  // EOF Product Name limiter v1
      $this->pic_data[$categories_id][] = array('products_id' => $product_info['products_id'], 
                                                  // 'products_name' => $product_info['product'], // Product Name limiter v1
                                                  'products_name' => $product_name_limiter, // Product Name limiter v1
                                                  // we already know the category but might be handy to have it here too
                                                  'products_category' => $categories_id,
												  'products_full_name' => $product_info['product']); // Product Name limiter v1
    } // end function addProductsInCategory ($categories_id, $product_info)

    function getProductsInCategory($categories_id) {
      if (isset($this->pic_data[$categories_id])){
        foreach ($this->pic_data[$categories_id] as $key => $_product_data) {
          $product_data[] = $_product_data;
        } // end foreach
        return $product_data;
      } else {
        return false;
      }
    } // end function getProductsInCategory($categories_id)
  } // end Class ProductsInCategory
?>