<?php
/*
  $Id: categories.php 167 2008-03-14 10:24:13Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

  require('includes/application_top.php');

 //Przystosowanie do register_globals OFF
link_get_variable('cID');
 //Przystosowanie do register_globals OFF

  // include the breadcrumb class and start the breadcrumb trail
  require(DIR_WS_CLASSES . 'breadcrumb.php');
  $breadcrumb = new breadcrumb;

  $breadcrumb->add('Start', tep_href_link(FILENAME_CATEGORIES));

  // add category names to the breadcrumb trail
  if (isset($cPath_array)) {
    for ($i=0, $n=sizeof($cPath_array); $i<$n; $i++) {
      $categories_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$cPath_array[$i] . "' and language_id = '" . (int)$languages_id . "'");
      if (tep_db_num_rows($categories_query) > 0) {
        $categories = tep_db_fetch_array($categories_query);
        $breadcrumb->add($categories['categories_name'], tep_href_link(FILENAME_CATEGORIES, 'cPath=' . implode('_', array_slice($cPath_array, 0, ($i+1)))));
      } else {
        break;
      }
	}
  }

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');

// Ultimate SEO URLs v2.1
// If the action will affect the cache entries
//    if ( eregi("(insert|update|setflag)", $action) ) include_once('includes/reset_seo_cache.php');

// Ultimate SEO URLs BEGIN
// If the action will affect the cache entries
    if (eregi("(insert|update|setflag)", $action))
        include_once ('includes/reset_seo_cache.php');
// Ultimate SEO URLs END

  if (tep_not_null($action)) {
    switch ($action) {
      case 'setflag':
        if ( ($HTTP_GET_VARS['flag'] == '0') || ($HTTP_GET_VARS['flag'] == '1') ) {
          if (isset($HTTP_GET_VARS['pID'])) {
            tep_set_product_status($HTTP_GET_VARS['pID'], $HTTP_GET_VARS['flag']);
          }

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $HTTP_GET_VARS['cPath'] . '&pID=' . $HTTP_GET_VARS['pID']));
        break;
// ####################### Added Categories Enable / Disable ###############
      case 'setflag_cat':
        if ( ($HTTP_GET_VARS['flag'] == '0') || ($HTTP_GET_VARS['flag'] == '1') ) {
          if (isset($HTTP_GET_VARS['cID'])) {
            tep_set_categories_status($HTTP_GET_VARS['cID'], $HTTP_GET_VARS['flag']);
          }

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
        }
	      tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $HTTP_GET_VARS['cPath'] . '&cID=' . $HTTP_GET_VARS['cID']));
	      break;
// ####################### End Categories Enable / Disable ###############
      case 'insert_category':
      case 'update_category':
        if (isset($HTTP_POST_VARS['categories_id'])) $categories_id = tep_db_prepare_input($HTTP_POST_VARS['categories_id']);
        if ($categories_id == '') {
           $categories_id = tep_db_prepare_input($HTTP_GET_VARS['cID']);
         }
        $sort_order = tep_db_prepare_input($HTTP_POST_VARS['sort_order']);

// ####################### Added Categories Enable / Disable ###############
        $categories_status = tep_db_prepare_input($HTTP_POST_VARS['categories_status']);
        $sql_data_array = array('sort_order' => (int)$sort_order, 'categories_status' => $categories_status);
// ####################### End Added Categories Enable / Disable ###############

        if ($action == 'insert_category') {
          $insert_sql_data = array('parent_id' => $current_category_id,
                                   'date_added' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          tep_db_perform(TABLE_CATEGORIES, $sql_data_array);

          $categories_id = tep_db_insert_id();
        } elseif ($action == 'update_category') {
          $update_sql_data = array('last_modified' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $update_sql_data);

          tep_db_perform(TABLE_CATEGORIES, $sql_data_array, 'update', "categories_id = '" . (int)$categories_id . "'");
        }

        $languages = tep_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $categories_name_array = $HTTP_POST_VARS['categories_name'];
          $categories_seo_url_array = $HTTP_POST_VARS['categories_seo_url'];
          //HTC BOC
          if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
           $categories_htc_title_array = $HTTP_POST_VARS['categories_htc_title_tag'];
           $categories_htc_desc_array = $HTTP_POST_VARS['categories_htc_desc_tag'];
           $categories_htc_keywords_array = $HTTP_POST_VARS['categories_htc_keywords_tag'];
          }
          $categories_htc_description_array = $HTTP_POST_VARS['categories_htc_description'];
          //HTC EOC

          $language_id = $languages[$i]['id'];

      //HTC BOC
            if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
             $sql_data_array = array('categories_name' => tep_db_prepare_input($categories_name_array[$language_id]),
             'categories_seo_url' => tep_db_prepare_input($categories_seo_url_array[$language_id]),
             'categories_htc_title_tag' => (tep_not_null($categories_htc_title_array[$language_id]) ? tep_db_prepare_input($categories_htc_title_array[$language_id]) :  tep_db_prepare_input($categories_name_array[$language_id])),
             'categories_htc_desc_tag' => (tep_not_null($categories_htc_desc_array[$language_id]) ? tep_db_prepare_input($categories_htc_desc_array[$language_id]) :  tep_db_prepare_input($categories_name_array[$language_id])),
             'categories_htc_keywords_tag' => (tep_not_null($categories_htc_keywords_array[$language_id]) ? tep_db_prepare_input($categories_htc_keywords_array[$language_id]) :  tep_db_prepare_input($categories_name_array[$language_id])),
             'categories_htc_description' => tep_db_prepare_input($categories_htc_description_array[$language_id]));
            } else {
             $sql_data_array = array('categories_name' => tep_db_prepare_input($categories_name_array[$language_id]),
             'categories_seo_url' => tep_db_prepare_input($categories_seo_url_array[$language_id]),
             'categories_htc_description' => tep_db_prepare_input($categories_htc_description_array[$language_id]));
            }
      //HTC EOC 

          if ($action == 'insert_category') {
            $insert_sql_data = array('categories_id' => $categories_id,
                                     'language_id' => $languages[$i]['id']);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array);
          } elseif ($action == 'update_category') {
            tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', "categories_id = '" . (int)$categories_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          }
          //BOF is categorie name given, when no insert it
          if ($action == 'update_category'){
          #check db
          $check_cat_name = tep_db_query("select * from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$categories_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          $num_cat_name = tep_db_num_rows($check_cat_name);
          #when no entry is found, insert new categorie name in correct language
          if(!$num_cat_name){
            $insert_sql_data = array('categories_id' => $categories_id,
                                     'language_id' => $languages[$i]['id']);
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
          #perform db entry          
          tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array);
           }
          }
          //EOF

        }

//        if ($categories_image = new upload('categories_image', DIR_FS_CATALOG_IMAGES)) {
         $categories_image = $HTTP_POST_VARS['categories_image'];
         tep_db_query("update " . TABLE_CATEGORIES . " set categories_image = '" . $categories_image . "' where categories_id = '" . (int)$categories_id . "'");

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }

          //osC_Categories - clear cache
          tep_db_query("DELETE FROM cache WHERE  cache_name = 'osC_Categories'");

          tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories_id));
//      }
        break;
      case 'delete_category_confirm':
        if (isset($HTTP_POST_VARS['categories_id'])) {
          $categories_id = tep_db_prepare_input($HTTP_POST_VARS['categories_id']);

//          $categories = tep_get_category_tree($categories_id, '', '0', '', true);
          $categories = tep_get_subcategory_tree($categories_id, '', '0', '', true);

          $products = array();
          $products_delete = array();

          for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
            $product_ids_query = tep_db_query("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . (int)$categories[$i]['id'] . "'");

            while ($product_ids = tep_db_fetch_array($product_ids_query)) {
              $products[$product_ids['products_id']]['categories'][] = $categories[$i]['id'];
            }
          }

          reset($products);
          while (list($key, $value) = each($products)) {
            $category_ids = '';

            for ($i=0, $n=sizeof($value['categories']); $i<$n; $i++) {
              $category_ids .= "'" . (int)$value['categories'][$i] . "', ";
            }
            $category_ids = substr($category_ids, 0, -2);

            $check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$key . "' and categories_id not in (" . $category_ids . ")");
            $check = tep_db_fetch_array($check_query);
            if ($check['total'] < '1') {
              $products_delete[$key] = $key;
            }
          }

// removing categories can be a lengthy process
          tep_set_time_limit(0);
          for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
            tep_remove_category($categories[$i]['id']);
          }

          reset($products_delete);
          while (list($key) = each($products_delete)) {
            tep_remove_product($key);
          }
        }

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

        //osC_Categories - clear cache
        tep_db_query("DELETE FROM cache WHERE  cache_name = 'osC_Categories'");

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
        break;
      case 'delete_product_confirm':
        if (isset($HTTP_POST_VARS['products_id']) && isset($HTTP_POST_VARS['product_categories']) && is_array($HTTP_POST_VARS['product_categories'])) {
          $product_id = tep_db_prepare_input($HTTP_POST_VARS['products_id']);
          $product_categories = $HTTP_POST_VARS['product_categories'];

          for ($i=0, $n=sizeof($product_categories); $i<$n; $i++) {
 
//START Additional Images
            $delimg_query = tep_db_query("select popup_images from " . TABLE_ADDITIONAL_IMAGES . " where products_id = '" . (int)$product_id . "'");
            while ($delimg = tep_db_fetch_array($delimg_query)){
                if (tep_not_null($delimg['popup_images']) && file_exists(DIR_FS_CATALOG_IMAGES.$delimg['popup_images']) )
                  if (!unlink (DIR_FS_CATALOG_IMAGES.$delimg['popup_images']))
                     $messageStack->add_session(ERROR_DEL_IMG_XTRA.$delimg['popup_images'], 'error');
                  else
                     $messageStack->add_session(SUCCESS_DEL_IMG_XTRA.$delimg['popup_images'], 'success');
            }
            tep_db_query("delete from " . TABLE_ADDITIONAL_IMAGES . " where products_id = '" . (int)$product_id . "'");
//END Additional Images
            
            tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "' and categories_id = '" . (int)$product_categories[$i] . "'");
          }

          $product_categories_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "'");
          $product_categories = tep_db_fetch_array($product_categories_query);

          if ($product_categories['total'] == '0') {
            tep_remove_product($product_id);
          }
        }

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
        break;
      case 'move_category_confirm':
        if (isset($HTTP_POST_VARS['categories_id']) && ($HTTP_POST_VARS['categories_id'] != $HTTP_POST_VARS['move_to_category_id'])) {
          $categories_id = tep_db_prepare_input($HTTP_POST_VARS['categories_id']);
          $new_parent_id = tep_db_prepare_input($HTTP_POST_VARS['move_to_category_id']);

          $path = explode('_', tep_get_generated_category_path_ids($new_parent_id));

          if (in_array($categories_id, $path)) {
            $messageStack->add_session(ERROR_CANNOT_MOVE_CATEGORY_TO_PARENT, 'error');

            tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories_id));
          } else {
            tep_db_query("update " . TABLE_CATEGORIES . " set parent_id = '" . (int)$new_parent_id . "', last_modified = now() where categories_id = '" . (int)$categories_id . "'");

            if (USE_CACHE == 'true') {
              tep_reset_cache_block('categories');
              tep_reset_cache_block('also_purchased');
            }

            tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $new_parent_id . '&cID=' . $categories_id));
          }
        }

        break;
      case 'move_product_confirm':
        $products_id = tep_db_prepare_input($HTTP_POST_VARS['products_id']);
        $new_parent_id = tep_db_prepare_input($HTTP_POST_VARS['move_to_category_id']);

        $duplicate_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$products_id . "' and categories_id = '" . (int)$new_parent_id . "'");
        $duplicate_check = tep_db_fetch_array($duplicate_check_query);
        if ($duplicate_check['total'] < 1) tep_db_query("update " . TABLE_PRODUCTS_TO_CATEGORIES . " set categories_id = '" . (int)$new_parent_id . "' where products_id = '" . (int)$products_id . "' and categories_id = '" . (int)$current_category_id . "'");

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $new_parent_id . '&pID=' . $products_id));
        break;
///////////////////////////////////////////////////////////////////////////////////////
// BOF: WebMakers.com Added: Copy Attributes Existing Product to another Existing Product
      case 'create_copy_product_attributes':
  // $products_id_to= $copy_to_products_id;
  // $products_id_from = $pID;
        tep_copy_products_attributes($pID,$copy_to_products_id);
        break;
// EOF: WebMakers.com Added: Copy Attributes Existing Product to another Existing Product
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
// WebMakers.com Added: Copy Attributes Existing Product to All Existing Products in a Category
      case 'create_copy_product_attributes_categories':
  // $products_id_to= $categories_products_copying['products_id'];
  // $products_id_from = $make_copy_from_products_id;
  //  echo 'Copy from products_id# ' . $make_copy_from_products_id . ' Copy to all products in category: ' . $cID . '<br>';
        $categories_products_copying_query= tep_db_query("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id='" . $cID . "'");
        while ( $categories_products_copying=tep_db_fetch_array($categories_products_copying_query) ) {
          // process all products in category
          tep_copy_products_attributes($make_copy_from_products_id,$categories_products_copying['products_id']);
        }
        break;
// EOF: WebMakers.com Added: Copy Attributes Existing Product to All Existing Products in a Category
///////////////////////////////////////////////////////////////////////////////////////
      case 'insert_product':
      case 'update_product':
        if (isset($HTTP_POST_VARS['edit_x']) || isset($HTTP_POST_VARS['edit_y'])) {
          $action = 'new_product';
        } else {
          if (isset($HTTP_GET_VARS['pID'])) $products_id = tep_db_prepare_input($HTTP_GET_VARS['pID']);
          $products_date_available = tep_db_prepare_input($HTTP_POST_VARS['products_date_available']);

          $products_date_available = (date('Y-m-d') < $products_date_available) ? $products_date_available : 'null';

          $sql_data_array = array('products_quantity' => (int)tep_db_prepare_input($HTTP_POST_VARS['products_quantity']),
                                  'products_model' => tep_db_prepare_input($HTTP_POST_VARS['products_model']),
                                  'products_price' => tep_db_prepare_input($HTTP_POST_VARS['products_price']),
                                  'products_retail_price' => tep_db_prepare_input($HTTP_POST_VARS['products_retail_price']),
                                  'products_date_available' => $products_date_available,
                                  'products_weight' => (float)tep_db_prepare_input($HTTP_POST_VARS['products_weight']),
                                  'products_status' => tep_db_prepare_input($HTTP_POST_VARS['products_status']),
                                  'products_tax_class_id' => tep_db_prepare_input($HTTP_POST_VARS['products_tax_class_id']),
                                  'products_maxorder' => tep_db_prepare_input($HTTP_POST_VARS['products_maxorder']),
                                  'manufacturers_id' => (int)tep_db_prepare_input($HTTP_POST_VARS['manufacturers_id']),
                                  'products_availability_id' => tep_db_prepare_input($HTTP_POST_VARS['products_availability_id']),
                                  'products_jm_id' => tep_db_prepare_input($HTTP_POST_VARS['products_jm_id']),
                                  'products_adminnotes' => tep_db_prepare_input($HTTP_POST_VARS['products_adminnotes']));

         //TotalB2B start
         $prices_num = tep_xppp_getpricesnum();
         for ($i=2; $i<=$prices_num; $i++) {
            if (tep_db_prepare_input($HTTP_POST_VARS['checkbox_products_price_' . $i]) != "true")
               $sql_data_array['products_price_' . $i] = 'null';
            else
               $sql_data_array['products_price_' . $i] = tep_db_prepare_input($HTTP_POST_VARS['products_price_' . $i]);
         }
         //TotalB2B end

          if (isset($HTTP_POST_VARS['products_image']) && tep_not_null($HTTP_POST_VARS['products_image']) && ($HTTP_POST_VARS['products_image'] != 'none')) {
            $sql_data_array['products_image'] = tep_db_prepare_input($HTTP_POST_VARS['products_image']);
          }

//START Additional Images
          if (isset($HTTP_POST_VARS['products_image_pop']) && tep_not_null($HTTP_POST_VARS['products_image_pop']) && ($HTTP_POST_VARS['products_image_pop'] != 'none')) {
            $sql_data_array['products_image_pop'] = tep_db_prepare_input($HTTP_POST_VARS['products_image_pop']);
          }
//END Additional Images

          if ($action == 'insert_product') {
            $insert_sql_data = array('products_date_added' => 'now()');

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            tep_db_perform(TABLE_PRODUCTS, $sql_data_array);
            $products_id = tep_db_insert_id();

            tep_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . (int)$products_id . "', '" . (int)$current_category_id . "')");
          } elseif ($action == 'update_product') {
            $update_sql_data = array('products_last_modified' => 'now()');

            $sql_data_array = array_merge($sql_data_array, $update_sql_data);

            tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "'");
          }

/** osc@kangaroopartners.com - AJAX Attribute Manager  **/ 
require_once('attributeManager/includes/attributeManagerUpdateAtomic.inc.php'); 
/** osc@kangaroopartners.com - AJAX Attribute Manager  end **/

          $languages = tep_get_languages();
          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
            $language_id = $languages[$i]['id'];

           //HTC BOC
            if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
                $sql_data_array = array('products_name' => tep_db_prepare_input($HTTP_POST_VARS['products_name'][$language_id]),
                                    'products_description' => tep_db_prepare_input($HTTP_POST_VARS['products_description'][$language_id]),
                                    'products_short_description' => tep_db_prepare_input($HTTP_POST_VARS['products_short_description'][$language_id]),
                                    'products_url' => tep_db_prepare_input($HTTP_POST_VARS['products_url'][$language_id]),
                                    'products_seo_url' => tep_db_prepare_input($HTTP_POST_VARS['products_seo_url'][$language_id]),
                                    'products_head_title_tag' => ((tep_not_null($HTTP_POST_VARS['products_head_title_tag'][$language_id])) ? tep_db_prepare_input($HTTP_POST_VARS['products_head_title_tag'][$language_id]) : tep_db_prepare_input($HTTP_POST_VARS['products_name'][$language_id])),
                                    'products_head_desc_tag' => ((tep_not_null($HTTP_POST_VARS['products_head_desc_tag'][$language_id])) ? tep_db_prepare_input($HTTP_POST_VARS['products_head_desc_tag'][$language_id]) : tep_db_prepare_input($HTTP_POST_VARS['products_name'][$language_id])),
                                    'products_head_keywords_tag' => ((tep_not_null($HTTP_POST_VARS['products_head_keywords_tag'][$language_id])) ? tep_db_prepare_input($HTTP_POST_VARS['products_head_keywords_tag'][$language_id]) : tep_db_prepare_input($HTTP_POST_VARS['products_name'][$language_id])));                                     
            } else {
                $sql_data_array = array('products_name' => tep_db_prepare_input($HTTP_POST_VARS['products_name'][$language_id]),
                                    'products_description' => tep_db_prepare_input($HTTP_POST_VARS['products_description'][$language_id]),
                                    'products_short_description' => tep_db_prepare_input($HTTP_POST_VARS['products_short_description'][$language_id]),
                                    'products_seo_url' => tep_db_prepare_input($HTTP_POST_VARS['products_seo_url'][$language_id]),
                                    'products_url' => tep_db_prepare_input($HTTP_POST_VARS['products_url'][$language_id]));
            }
           //HTC EOC

            if ($action == 'insert_product') {
              $insert_sql_data = array('products_id' => $products_id,
                                       'language_id' => $language_id);

              $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

              tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);
            } elseif ($action == 'update_product') {
              tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "' and language_id = '" . (int)$language_id . "'");
            }
          //BOF is categorie name given, when no insert it
          if ($action == 'update_product'){
          #check db
          $check_pd = tep_db_query("select * from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$products_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          $num_pd = tep_db_num_rows($check_pd);
          #when no entry is found, insert new products description in correct language
          if(!$num_pd){
              $insert_sql_data = array('products_id' => $products_id,
                                       'language_id' => $language_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
          #perform db entry          
          tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);
           }
          }
          //EOF
          }

          // START: Extra Fields Contribution
          $extra_fields_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " WHERE products_id = " . (int)$products_id);
          while ($products_extra_fields = tep_db_fetch_array($extra_fields_query)) {
            $extra_product_entry[$products_extra_fields['products_extra_fields_id']] = $products_extra_fields['products_extra_fields_value'];
          }

          if ($HTTP_POST_VARS['extra_field']) { // Check to see if there are any need to update extra fields.
            foreach ($HTTP_POST_VARS['extra_field'] as $key=>$val) {
              if (isset($extra_product_entry[$key])) { // an entry exists
                if ($val == '') tep_db_query("DELETE FROM " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " where products_id = " . (int)$products_id . " AND  products_extra_fields_id = " . $key);
                else tep_db_query("UPDATE " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " SET products_extra_fields_value = '" . tep_db_prepare_input($val) . "' WHERE products_id = " . (int)$products_id . " AND  products_extra_fields_id = " . $key);
              }
              else { // an entry does not exist
                if ($val != '') tep_db_query("INSERT INTO " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " (products_id, products_extra_fields_id, products_extra_fields_value) VALUES ('" . (int)$products_id . "', '" . $key . "', '" . tep_db_prepare_input($val) . "')");
              }
            }
          } // Check to see if there are any need to update extra fields.
          // END: Extra Fields Contribution
/////////////////////////////////////////////////////////////////////
// BOF: WebMakers.com Added: Update Product Attributes and Sort Order
// Update the changes to the attributes if any changes were made   mod eSklep-Os http://www.esklep-os.com
/*          // Update Product Attributes
          $rows = 0;
          $options_query = tep_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . $languages_id . "' order by products_options_name");
          while ($options = tep_db_fetch_array($options_query)) {
            $values_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov, " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " p2p where pov.products_options_values_id = p2p.products_options_values_id and p2p.products_options_id = '" . $options['products_options_id'] . "' and pov.language_id = '" . $languages_id . "' order by pov.products_options_values_name");
            while ($values = tep_db_fetch_array($values_query)) {
              $rows ++;
// original              $attributes_query = tep_db_query("select products_attributes_id, options_values_price, price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $products_id . "' and options_id = '" . $options['products_options_id'] . "' and options_values_id = '" . $values['products_options_values_id'] . "'");
              $attributes_query = tep_db_query("select products_attributes_id, options_values_price, price_prefix, products_options_sort_order from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $products_id . "' and options_id = '" . $options['products_options_id'] . "' and options_values_id = '" . $values['products_options_values_id'] . "'");
              if (tep_db_num_rows($attributes_query) > 0) {
                $attributes = tep_db_fetch_array($attributes_query);
                if ($HTTP_POST_VARS['option'][$rows]) {
                  if ( ($HTTP_POST_VARS['prefix'][$rows] <> $attributes['price_prefix']) || ($HTTP_POST_VARS['price'][$rows] <> $attributes['options_values_price']) || ($HTTP_POST_VARS['products_options_sort_order'][$rows] <> $attributes['products_options_sort_order']) ) { 
                    if (!isset($HTTP_POST_VARS['products_options_sort_order'][$rows]) || (isset($HTTP_POST_VARS['products_options_sort_order'][$rows]) && $HTTP_POST_VARS['products_options_sort_order'][$rows] == '' )) {
                        $lookup = tep_db_query("select products_options_values_sort_order from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " WHERE products_options_values_id ='" . $values['products_options_values_id'] . "'");
                        $lookup_res = tep_db_fetch_array($lookup);
                        $att_sort_order = $lookup_res['products_options_values_sort_order'];
                    } else {
                        $att_sort_order = $HTTP_POST_VARS['products_options_sort_order'][$rows];
                    }
                    tep_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES . " set options_values_price = '" . $HTTP_POST_VARS['price'][$rows] . "', price_prefix = '" . $HTTP_POST_VARS['prefix'][$rows] . "', products_options_sort_order = '" . $att_sort_order ."' where products_attributes_id = '" . $attributes['products_attributes_id'] . "'");
                  }
                } else {
                  tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_attributes_id = '" . $attributes['products_attributes_id'] . "'");
                }
              } elseif ($HTTP_POST_VARS['option'][$rows]) {
                    if (!isset($HTTP_POST_VARS['products_options_sort_order'][$rows]) || (isset($HTTP_POST_VARS['products_options_sort_order'][$rows]) && $HTTP_POST_VARS['products_options_sort_order'][$rows] == '' )) {
                        $lookup = tep_db_query("select products_options_values_sort_order from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " WHERE products_options_values_id ='" . $values['products_options_values_id'] . "'");
                        $lookup_res = tep_db_fetch_array($lookup);
                        $att_sort_order = $lookup_res['products_options_values_sort_order'];
                    } else {
                        $att_sort_order = $HTTP_POST_VARS['products_options_sort_order'][$rows];
                    }

                tep_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES . " values ('', '" . $products_id . "', '" . $options['products_options_id'] . "', '" . $values['products_options_values_id'] . "', '" . $HTTP_POST_VARS['price'][$rows] . "', '" . $HTTP_POST_VARS['prefix'][$rows] . "', '" . $att_sort_order . "')");
              }
            }
          }
*/
// EOF: WebMakers.com Added: Update Product Attributes and Sort Order
/////////////////////////////////////////////////////////////////////
// start indvship
          $sql_shipping_array = array('products_ship_zip' => tep_db_prepare_input($_POST['products_ship_zip']),
'products_ship_methods_id' => tep_db_prepare_input($_POST['products_ship_methods_id']),
'products_ship_price' => round(tep_db_prepare_input($_POST['products_ship_price']),4),
'products_ship_price_two' => round(tep_db_prepare_input($_POST['products_ship_price_two']),4));
          $sql_shipping_id_array = array('products_id' => (int)$products_id); 
          $products_ship_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_SHIPPING . " WHERE products_id = " . (int)$products_id);
          if(tep_db_num_rows($products_ship_query) >0) {
            if (($_POST['products_ship_zip'] == '')&&($_POST['products_ship_methods_id'] == '')&&($_POST['products_ship_price'] == '')&&($_POST['products_ship_price_two'] == '')){
              tep_db_query("DELETE FROM " . TABLE_PRODUCTS_SHIPPING . " where products_id = '" . (int)$products_id . "'");
            } else {
              tep_db_perform(TABLE_PRODUCTS_SHIPPING, $sql_shipping_array, 'update', "products_id = '" . (int)$products_id . "'");
            }
          } else {
            if (($_POST['products_ship_zip'] != '')||($_POST['products_ship_methods_id'] != '')||($_POST['products_ship_price'] != '')||($_POST['products_ship_price_two'] != '')){
              $sql_ship_array = array_merge($sql_shipping_array, $sql_shipping_id_array);
              tep_db_perform(TABLE_PRODUCTS_SHIPPING, $sql_ship_array, 'insert');
            }
          }
          // end indvship
          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }

          tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products_id));
        }
        break;
      case 'copy_to_confirm':
        if (isset($HTTP_POST_VARS['products_id']) && isset($HTTP_POST_VARS['categories_id'])) {
          $products_id = tep_db_prepare_input($HTTP_POST_VARS['products_id']);
          $categories_id = tep_db_prepare_input($HTTP_POST_VARS['categories_id']);

          if ($HTTP_POST_VARS['copy_as'] == 'link') {
            if ($categories_id != $current_category_id) {
              $check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$products_id . "' and categories_id = '" . (int)$categories_id . "'");
              $check = tep_db_fetch_array($check_query);
              if ($check['total'] < '1') {
                tep_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . (int)$products_id . "', '" . (int)$categories_id . "')");
              }
            } else {
              $messageStack->add_session(ERROR_CANNOT_LINK_TO_SAME_CATEGORY, 'error');
            }
          } elseif ($HTTP_POST_VARS['copy_as'] == 'duplicate') {

            //TotalB2B start
            $products_price_list = tep_xppp_getpricelist("");
            $product_query = tep_db_query("select products_quantity, products_model, products_image, products_retail_price, ". $products_price_list . ", products_date_available, products_weight, products_tax_class_id, products_maxorder, manufacturers_id, products_availability_id, products_availability_id, products_adminnotes from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'");
            //TotalB2B end
            
            $product = tep_db_fetch_array($product_query);

            $prices_num = tep_xppp_getpricesnum();
            for($i=2; $i<=$prices_num; $i++) {
               if ($product['products_price_' . $i] == NULL) $products_instval .= "NULL, ";
               else $products_instval .= "'" . tep_db_input($product['products_price_' . $i]) . "', ";
            }
            $products_instval .= "'" . tep_db_input($product['products_price']) . "' ";
            tep_db_query("insert into " . TABLE_PRODUCTS . " (products_quantity, products_model,products_image, products_retail_price, products_price, products_date_added, products_date_available, products_weight, products_status, products_tax_class_id, products_maxorder, manufacturers_id, products_availability_id, products_availability_id, products_adminnotes) values ('" . tep_db_input($product['products_quantity']) . "', '" . tep_db_input($product['products_model']) . "', '" . tep_db_input($product['products_image']) . "', '" . tep_db_input($product['products_retail_price']) . "', '" . tep_db_input($product['products_price']) . "',  now(), " . (empty($product['products_date_available']) ? "null" : "'" . tep_db_input($product['products_date_available']) . "'") . ", '" . tep_db_input($product['products_weight']) . "', '0', '" . (int)$product['products_tax_class_id'] . "', '"  . (int)$product['products_maxorder'] . "', '" . (int)$product['manufacturers_id']  . "', '" . $product['products_availability_id'] . "', '" . $product['products_jm_id'] . "', '" . tep_db_input($product['products_adminnotes']) . "')");
            //TotalB2B end   mod eSklep-Os http://www.esklep-os.com
            
            $dup_products_id = tep_db_insert_id();

       //HTC BOC 
            if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
                $description_query = tep_db_query("select language_id, products_name, products_seo_url, products_description, products_short_description, products_head_title_tag, products_head_desc_tag, products_head_keywords_tag, products_url from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$products_id . "'");
                while ($description = tep_db_fetch_array($description_query)) {
                    tep_db_query("insert into " . TABLE_PRODUCTS_DESCRIPTION . " (products_id, language_id, products_name, products_seo_url, products_description, products_short_description, products_head_title_tag, products_head_desc_tag, products_head_keywords_tag, products_url, products_viewed) values ('" . (int)$dup_products_id . "', '" . (int)$description['language_id'] . "', '" . tep_db_input($description['products_name']) . "', '" . tep_db_input($description['products_seo_url']) . "', '" . tep_db_input($description['products_description']) . "', '" . tep_db_input($description['products_short_description']) . "', '" . tep_db_input($description['products_head_title_tag']) . "', '" . tep_db_input($description['products_head_desc_tag']) . "', '" . tep_db_input($description['products_head_keywords_tag']) . "', '" . tep_db_input($description['products_url']) . "', '0')");
                }
				// start indvship
            $shipping_query = tep_db_query("select products_ship_methods_id, products_ship_zip from " . TABLE_PRODUCTS_SHIPPING . " where products_id = '" . (int)$products_id . "'");
            while ($shipping = tep_db_fetch_array($shipping_query)) {
              tep_db_query("insert into " . TABLE_PRODUCTS_SHIPPING . " (products_id, products_ship_methods_id, products_ship_zip) values ('" . (int)$dup_products_id . "', '" . tep_db_input($shipping['products_ship_methods_id']) . "', '" . tep_db_input($shipping['products_ship_zip']) . "')");
            } 
			// end indvship
            } else {
          $description_query = tep_db_query("select language_id, products_name, products_seo_url, products_description, products_short_description, products_url from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$products_id . "'");
          while ($description = tep_db_fetch_array($description_query)) {
           tep_db_query("insert into " . TABLE_PRODUCTS_DESCRIPTION . " (products_id, language_id, products_name, products_seo_url, products_description, products_short_description, products_url, products_viewed) values ('" . (int)$dup_products_id . "', '" . (int)$description['language_id'] . "', '" . tep_db_input($description['products_name']) . "', '" . tep_db_input($description['products_seo_url']) . "', '" . tep_db_input($description['products_description']) . "', '" . tep_db_input($description['products_short_description']) . "', '" . tep_db_input($description['products_url']) . "', '0')");
          }
		  // start indvship
            $shipping_query = tep_db_query("select products_ship_methods_id, products_ship_zip from " . TABLE_PRODUCTS_SHIPPING . " where products_id = '" . (int)$products_id . "'");
            while ($shipping = tep_db_fetch_array($shipping_query)) {
              tep_db_query("insert into " . TABLE_PRODUCTS_SHIPPING . " (products_id, products_ship_methods_id, products_ship_zip) values ('" . (int)$dup_products_id . "', '" . tep_db_input($shipping['products_ship_methods_id']) . "', '" . tep_db_input($shipping['products_ship_zip']) . "')");
            } 
			// end indvship
            }
      //HTC EOC            

            tep_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . (int)$dup_products_id . "', '" . (int)$categories_id . "')");
// BOF: WebMakers.com Added: Attributes Copy on non-linked
            $products_id_from=tep_db_input($products_id);
            $products_id_to= $dup_products_id;
// EOF: Attributes sort/copy
            $products_id = $dup_products_id;
// BOF: Attributes sort/copy

if ( $HTTP_POST_VARS['copy_attributes']=='copy_attributes_yes' and $HTTP_POST_VARS['copy_as'] == 'duplicate' ) {

// WebMakers.com Added: Copy attributes to duplicate product
  // $products_id_to= $copy_to_products_id;
  // $products_id_from = $pID;
            $copy_attributes_delete_first='1';
            $copy_attributes_duplicates_skipped='1';
            $copy_attributes_duplicates_overwrite='0';

            if (DOWNLOAD_ENABLED == 'true') {
              $copy_attributes_include_downloads='1';
              $copy_attributes_include_filename='1';
            } else {
              $copy_attributes_include_downloads='0';
              $copy_attributes_include_filename='0';
            }
            tep_copy_products_attributes($products_id_from,$products_id_to);

}
// EOF: WebMakers.com Added: Attributes Copy on non-linked
          }

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $categories_id . '&pID=' . $products_id));
        break;
      case 'new_product_preview':
     //Standardowe rozwiazanie osc - kopiowanie obrazka przed podladem BOF    mod eSklep-Os http://www.esklep-os.com
     // copy image only if modified
      //        $products_image = new upload('products_image');
      //        $products_image->set_destination(DIR_FS_CATALOG_IMAGES);
      //        if ($products_image->parse() && $products_image->save()) {
      //          $products_image_name = $products_image->filename;
      //        } else {
      //          $products_image_name = (isset($HTTP_POST_VARS['products_previous_image']) ? $HTTP_POST_VARS['products_previous_image'] : '');
      //        }
     //Standardowe rozwiazanie osc - kopiowanie obrazka przed podladem EOF 
       //Moje rozwiazanie - brak kopiowania obrazka BOF
       $products_image_name = $HTTP_POST_VARS['products_image'];
       //Moje rozwiazanie - brak kopiowania obrazka EOF
        break;
 
      case 'add_images': 
        $products_id = $HTTP_GET_VARS['pID']; 

        $add_images_error = true;
        if (!empty($_POST['popup_images'])) {
          $add_images_error = false;
          $sql_data_array = array('products_id' => tep_db_prepare_input($products_id), 
                                  'images_description' => tep_db_prepare_input($HTTP_POST_VARS['images_description']), 
                                  'popup_images' => tep_db_prepare_input($HTTP_POST_VARS['popup_images']));
          $sql_data_array = array_merge($sql_data_array); 
          $messageStack->add_session('Obrazek zostal dopisany', 'success');
       }
        if ($add_images_error == false) {
          tep_db_perform(TABLE_ADDITIONAL_IMAGES, $sql_data_array); 
        } else {
          $messageStack->add_session(ERROR_ADDITIONAL_IMAGE_IS_EMPTY, 'error');
        }
        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products_id)); 
        break;
      case 'del_images':
        $products_id = tep_db_prepare_input($HTTP_GET_VARS['pID']);
        if ( ($HTTP_GET_VARS['pID']) && (is_array($HTTP_POST_VARS['additional_images_id'])) ) {
          $additional_images_id = tep_db_prepare_input($HTTP_POST_VARS['additional_images_id']);
          for ($i=0; $i<sizeof($additional_images_id); $i++) {
            //SECTION DELETE POPUP IMAGES
            $delimg_query = tep_db_query("select popup_images from " . TABLE_ADDITIONAL_IMAGES . " where additional_images_id = '" . tep_db_input($additional_images_id[$i]) . "'");
            $delimg = tep_db_fetch_array($delimg_query);
            if (tep_not_null($delimg['popup_images']) && file_exists(DIR_FS_CATALOG_IMAGES.$delimg['popup_images']) )
//                if (!unlink (DIR_FS_CATALOG_IMAGES.$delimg['popup_images']))
//                   $messageStack->add_session(ERROR_DEL_IMG_XTRA.$delimg['popup_images'], 'error');
//                else
                   $messageStack->add_session(SUCCESS_DEL_IMG_XTRA.$delimg['popup_images'], 'success');
            //END OF SECTION DELETE POPUP IMAGES
            tep_db_query("delete from " . TABLE_ADDITIONAL_IMAGES . " where additional_images_id = '" . tep_db_input($additional_images_id[$i]) . "'");
          }
        }
        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products_id));
        break;
        //END Additional Images

   }
  }

// ********** Image path modification ends here **********


// check if the catalog image directory exists
  if (is_dir(DIR_FS_CATALOG_IMAGES)) {
    if (!is_writeable(DIR_FS_CATALOG_IMAGES)) $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
  }
?>
<?php
/* BOF: Attributes sort/copy (afaik, this doesn't do anything) */
// WebMakers.com Added: Display Order
  switch (true) {
    case (CATEGORIES_SORT_ORDER=="products_name"):
      $order_it_by = "pd.products_name";
      break;
    case (CATEGORIES_SORT_ORDER=="products_name-desc"):
      $order_it_by = "pd.products_name DESC";
      break;
    case (CATEGORIES_SORT_ORDER=="model"):
      $order_it_by = "p.products_model";
      break;
    case (CATEGORIES_SORT_ORDER=="model-desc"):
      $order_it_by = "p.products_model DESC";
      break;
    default:
      $order_it_by = "pd.products_name";
      break;
    }
/* EOF: Attributes sort/copy */
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>

<link rel="stylesheet" type="text/css" href="includes/css/stylesheet.css">

<script language="javascript" src="includes/javascript/general.js"></script>
<script language="JavaScript" type="text/javascript" src="includes/javascript/pick.js"></script>


<!-- osc@kangaroopartners.com - AJAX Attribute Manager  -->
<?php require_once( 'attributeManager/includes/attributeManagerHeader.inc.php' )?>
<!-- osc@kangaroopartners.com - AJAX Attribute Manager  end -->

<?php
/* BOF: Attributes sort/copy */
// WebMakers.com Added: Java Scripts
include(DIR_WS_INCLUDES . 'javascript/' . 'webmakers_added_js.php')
/* EOF: Attributes sort/copy */
?>

<link type="text/css" rel="stylesheet" href="includes/javascript/tabpane/css/luna/tab.css">
<script type="text/javascript" src="includes/javascript/tabpane/js/tabpane.js"></script>

</head>

           <!-- Modyfikacja wyboru obrazkow JacekK BOF-->
           <script language="javascript">
           function SetUrl(link)
           {
           txtBox = document.getElementById('file1');
           txtBox.value=link;
           }

           function fileBrowser() {
           URL = 'includes/javascript/FCKeditor/editor/filemanager/browser_forms/default/browser.html?Type=Image&Connector=connectors/php/connector.php';
           eval("page = window.open(URL, '', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=300');");
           }
           //--></script>

<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="goOnLoad(); " >
<div id="spiffycalendar" class="text"></div>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
    <!-- body_text //-->
         <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
    <?php
//*******************************************************************************************************
     //----- new_category / edit_category (when ALLOW_CATEGORY_DESCRIPTIONS is 'true') -----
  if ($HTTP_GET_VARS['action'] == 'new_category' || $HTTP_GET_VARS['action'] == 'edit_category') {
    if ( ($HTTP_GET_VARS['cID']) && (!$HTTP_POST_VARS) ) {
      if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
		  $categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_heading_title, cd.categories_description, cd.categories_htc_title_tag, cd.categories_htc_desc_tag, cd.categories_htc_keywords_tag, cd.categories_htc_description, c.categories_image, c.parent_id, c.sort_order, c.categories_status, c.date_added, c.last_modified from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $HTTP_GET_VARS['cID'] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . $languages_id . "' order by c.sort_order, cd.categories_name");
      } else {
		  $categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_heading_title, cd.categories_description, cd.categories_htc_description, c.categories_image, c.parent_id, c.sort_order, c.categories_status, c.date_added, c.last_modified from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $HTTP_GET_VARS['cID'] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . $languages_id . "' order by c.sort_order, cd.categories_name");
	  }
	  $category = tep_db_fetch_array($categories_query);
      $cInfo = new objectInfo($category);
    } else {
      $cInfo = new objectInfo(array());
    }

    $languages = tep_get_languages();
    $text_new_or_edit = ($HTTP_GET_VARS['action']=='new_category') ? TEXT_INFO_HEADING_NEW_CATEGORY : TEXT_INFO_HEADING_EDIT_CATEGORY;
    ?>
    <tr>
     <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
    </tr>
    <tr>

   <?php
    $form_action = ($HTTP_GET_VARS['cID']) ? 'update_category' : 'insert_category';
    echo tep_draw_form('categories', FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $HTTP_GET_VARS['cID'] . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"') . tep_draw_hidden_field('categories_id', $cInfo->categories_id);
    ?>
      <td>
    <fieldset>
    <legend class="main"><b><?php echo sprintf($text_new_or_edit, tep_output_generated_category_path($current_category_id)); ?></b></legend>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" summary="category Image and sort order">
     <tr valign="top">
      <td>
       <table width="100%" border="0" cellspacing="0" cellpadding="4" align="center">
        <tr>
         <td class="main" align="left" width="30%"><strong><?php echo 'Wybór obrazka'; ?></strong></td>
         <td class="main" align="left" width="70%">
		 <?php echo tep_draw_input_field('categories_image', $cInfo->categories_image, 'id="file1" size="35" ') . '&nbsp;<button type="button" style="font-size:10px; font-face:Verdana; color:#000000; background-color:#fcfcfe; border-color: #919b9c; border-style: solid; border-width: 1px;" onclick="BrowseServer(\'file1\');">wybierz obrazek</button>'; ?>
         </td>
		</tr>
        <tr>
         <td class="main" align="left" width="30%"><strong><?php echo TEXT_EDIT_SORT_ORDER; ?></strong>
         <td class="main" align="left" width="70%"><?php echo tep_draw_input_field('sort_order', $cInfo->sort_order, 'size="2"'); ?></td>
        </tr>
        <tr>
         <td class="main" align="left" width="30%"><strong><?php echo TEXT_EDIT_STATUS; ?></strong>
         <td class="main" align="left" width="70%">
		 <?php
		   if ($cInfo->categories_status=='1') {
		     echo tep_draw_radio_field('categories_status', '1', 'true'). 'Włączona&nbsp;&nbsp;';
		     echo tep_draw_radio_field('categories_status', '0', ''). 'Wyłączona';
           } elseif ($cInfo->categories_status=='0') {
		     echo tep_draw_radio_field('categories_status', '1', ''). 'Włączona&nbsp;&nbsp;';
		     echo tep_draw_radio_field('categories_status', '0', 'true'). 'Wyłączona';
		   } else {
		     echo tep_draw_radio_field('categories_status', '1', 'true'). 'Włączona&nbsp;&nbsp;';
		     echo tep_draw_radio_field('categories_status', '0', ''). 'Wyłączona';
		   }
	     ?>
		 </td>
        </tr>
       </table>
      </td>
      <td class="main" align="center">
       <?php if ($cInfo->categories_image=='') {
       } else {
        echo tep_image(DIR_WS_CATALOG_IMAGES . $cInfo->categories_image, $cInfo->categories_image, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="0" vspace="5"');
       } ?>

      </td>
      
     </tr>
    </table>
    </fieldset>

    <?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>

    <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
     <tr>
      <td colspan="2" class="main" valign="top" width="100%">
       <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td class="main" valign="top"><div class="tab-pane" id="tabPane1">
          <div class="tab-pane" id="descriptionTabPane">
           <script type="text/javascript"><!--
           var descriptionTabPane = new WebFXTabPane( document.getElementById( "descriptionTabPane" ) );
           //--></script>

           <?php
           for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
           ?>

           <div class="tab-page" id="tabDescriptionLanguages_<?php echo $languages[$i]['name']; ?>">
           <h2 class="tab"><?php echo tep_image_flag(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?></h2>

            <script type="text/javascript"><!--
             descriptionTabPane.addTabPage( document.getElementById( "tabDescriptionLanguages_<?php echo $languages[$i]['name']; ?>" ) );
            //--></script>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" summary="tab table">
             <tr>
              <td valign="top">
               <table border="0" cellspacing="0" cellpadding="4" summary="Title table">
                <tr valign="top">
				         <td class="main"><strong><?php echo TEXT_EDIT_CATEGORIES_NAME; ?></strong></td>
					       <td class="main"><?php echo tep_draw_input_field('categories_name[' . $languages[$i]['id'] . ']', (($categories_name[$languages[$i]['id']]) ? stripslashes($categories_name[$languages[$i]['id']]) : tep_get_category_name($cInfo->categories_id, $languages[$i]['id']))); ?></td>
				        </tr>
				        <tr valign="top">
				         <td class="main"><strong><?php echo TEXT_EDIT_CATEGORIES_SEO_URL; ?></strong></td>
				         <td class="main"><?php echo tep_draw_input_field('categories_seo_url[' . $languages[$i]['id'] . ']', (($categories_seo_url[$languages[$i]['id']]) ? stripslashes($categories_seo_url[$languages[$i]['id']]) : tep_get_category_seo_url($cInfo->categories_id, $languages[$i]['id']))); ?></td>
                </tr>
                <tr valign="top">
                 <td class="main" width="30%"><strong><?php echo CATEGORY_DESCRIPTION; ?></strong></td>
                 <td width="70%">

                  <?php
                if (HTML_WYSIWYG_DISABLE == 'Disable') {
                 echo tep_draw_textarea_field('categories_htc_description[' . $languages[$i]['id'] . ']', 'soft', '100%', '5', (isset($categories_htc_description[$languages[$i]['id']]) ? stripslashes($categories_htc_description[$languages[$i]['id']]) : tep_get_category_htc_description($cInfo->categories_id, $languages[$i]['id'])));
                } else {
                 echo tep_draw_fckeditor('categories_htc_description[' . $languages[$i]['id'] . ']', '650', '200', (isset($categories_htc_description[$languages[$i]['id']]) ? stripslashes($categories_htc_description[$languages[$i]['id']]) : tep_get_category_htc_description($cInfo->categories_id, $languages[$i]['id'])));
                } ?>
                 </td>

                </tr>
               </table>
               <?php if (ALLOW_HEADER_TAGS_CONTROLLER=='true') { ?>

			   <table width="100%"  border="0" cellspacing="3" cellpadding="0" summary="meta content holder table">
                <tr>
                 <td valign="top"><fieldset>
                  <legend class="main"><?php echo TEXT_PRODUCT_METTA_INFO; ?></legend>
                  <table width="100%"  border="0" cellspacing="3" cellpadding="3">
                   <tr>
                    <td class="main"><strong><?php echo HEADER_TAGS_CATEGORY_TITLE;?></strong></td>
                   </tr>
                   <tr>
                    <td class="main"><?php echo tep_draw_textarea_field('categories_htc_title_tag[' . $languages[$i]['id'] . ']', 'soft', '25', '5', (($categories_htc_title_tag[$languages[$i]['id']]) ? stripslashes($categories_htc_title_tag[$languages[$i]['id']]) : tep_get_category_htc_title($cInfo->categories_id, $languages[$i]['id'])),'style="width: 100%"'); ?></td>
                   </tr>
                  </table>
                  <table width="100%"  border="0" cellspacing="3" cellpadding="3">
                   <tr>
                    <td width="50%" class="main"><strong><?php echo HEADER_TAGS_CATEGORY_DESCRIPTION;?></strong></td>
                    <td width="50%" class="main"><strong><?php echo HEADER_TAGS_CATEGORY_KEYWORDS; ?></strong></td>
                   </tr>
                   <tr>
                    <td class="main"><?php echo tep_draw_textarea_field('categories_htc_desc_tag[' . $languages[$i]['id'] . ']', 'soft', '25', '5', (($categories_htc_desc_tag[$languages[$i]['id']]) ? stripslashes($categories_htc_desc_tag[$languages[$i]['id']]) : tep_get_category_htc_desc($cInfo->categories_id, $languages[$i]['id'])),'style="width: 100%"'); ?></td>
                    <td class="main"><?php echo tep_draw_textarea_field('categories_htc_keywords_tag[' . $languages[$i]['id'] . ']', 'soft', '25', '5', (($categories_htc_keywords_tag[$languages[$i]['id']]) ? stripslashes($categories_htc_keywords_tag[$languages[$i]['id']]) : tep_get_category_htc_keywords($cInfo->categories_id, $languages[$i]['id'])),'style="width: 100%"'); ?></td>
                   </tr>
                  </table>
                  </fieldset>
                 </td>
                </tr>
               </table>
			   <?php } ?>
              </td>
             </tr>
            </table>
            </div>
            <?php
            }
            ?>
          </div>
          <script type="text/javascript">
          //<![CDATA[
          setupAllTabs();
          //]]>
          </script>
          <?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?> </td>
        </tr>
        <tr>
         <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
        </tr>
       </table>
      </td>
     </tr>
     <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
     </tr>
     <tr>
     <td class="main" align="right"><?php echo tep_draw_hidden_field('categories_date_added', (($cInfo->date_added) ? $cInfo->date_added : date('Y-m-d'))) . tep_draw_hidden_field('parent_id', $cInfo->parent_id) . tep_image_submit('button_save.gif', IMAGE_SAVE) . '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $HTTP_GET_VARS['cID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
    </form>

	</tr>
	<?php

  
   } elseif ($action == 'new_product') {
    $parameters = array('products_name' => '',
                       'products_description' => '',
                       'products_short_description' => '',
                       'products_url' => '',
                       'products_seo_url' => '',
                       'products_id' => '',
                       'products_quantity' => '',
                       'products_model' => '',
                       'products_image' => '',
                       'products_price' => '',
                       'products_retail_price' => '',
                       'products_weight' => '',
                       'products_date_added' => '',
                       'products_last_modified' => '',
                       'products_date_available' => '',
                       'products_status' => '',
                       'products_tax_class_id' => '',
                       'products_maxorder' => '',
                       'manufacturers_id' => '' ,
                       'products_availability_id' => '' ,
                       'products_jm_id' => '' ,
                       'products_adminnotes' => '');

    //TotalB2B start
    $prices_num = tep_xppp_getpricesnum();
    for ($i=2; $i<=$prices_num; $i++) {
      $parameters['products_price_' . $i] = '';
    }
    //TotalB2B start
    
    $pInfo = new objectInfo($parameters);

      //HTC BOC
    if (isset ($HTTP_GET_VARS['pID']) && (!$HTTP_POST_VARS) ) {
//      if (isset($HTTP_GET_VARS['pID']) && empty($HTTP_POST_VARS)) {
// start indvship
      $products_shipping_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_SHIPPING . " WHERE products_id=" . (int)$_GET['pID']);
      while ($products_shipping = tep_db_fetch_array($products_shipping_query)) {
        $products_ship_zip = $products_shipping['products_ship_zip'];
        $products_ship_methods_id = $products_shipping['products_ship_methods_id'];
        $products_ship_price = $products_shipping['products_ship_price'];
        $products_ship_price_two = $products_shipping['products_ship_price_two'];
      }
      $shipping=array('products_ship_methods_id' => $products_ship_methods_id,
      'products_ship_zip' => $products_ship_zip,
      'products_ship_price' => $products_ship_price,
      'products_ship_price_two' => $products_ship_price_two);
      $pInfo->objectInfo($shipping);
      // end indvship
      //TotalB2B start
      $products_price_list = tep_xppp_getpricelist("p");
      if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
        $product_query = tep_db_query("select pd.products_name, pd.products_seo_url, pd.products_description, pd.products_short_description, pd.products_head_title_tag, pd.products_head_desc_tag, pd.products_head_keywords_tag, pd.products_url, p.products_id, p.products_quantity, p.products_model, p.products_image, p.products_retail_price, " . $products_price_list . ", p.products_weight, p.products_date_added, p.products_last_modified, date_format(p.products_date_available, '%Y-%m-%d') as products_date_available, p.products_status, p.products_tax_class_id, p.products_maxorder, p.manufacturers_id, p.products_availability_id, p.products_jm_id, p.products_adminnotes from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$HTTP_GET_VARS['pID'] . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'");
      } else {
        $product_query = tep_db_query("select pd.products_name, pd.products_seo_url, pd.products_description, pd.products_short_description, pd.products_url, p.products_id, p.products_quantity, p.products_model, p.products_image, p.products_retail_price, " . $products_price_list . ", p.products_weight, p.products_date_added, p.products_last_modified, date_format(p.products_date_available, '%Y-%m-%d') as products_date_available, p.products_status, p.products_tax_class_id, p.products_maxorder, p.manufacturers_id, p.products_availability_id, p.products_jm_id, p.products_adminnotes from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$HTTP_GET_VARS['pID'] . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'");
      }
      //TotalB2B end
      $product = tep_db_fetch_array($product_query);
      //HTC EOC 
      $pInfo->objectInfo($product);

// START: Extra Fields Contribution   
      $products_extra_fields_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " WHERE products_id=" . (int)$HTTP_GET_VARS['pID']);
      while ($products_extra_fields = tep_db_fetch_array($products_extra_fields_query)) {
        $extra_field[$products_extra_fields['products_extra_fields_id']] = $products_extra_fields['products_extra_fields_value'];
      }
      $extra_field_array=array('extra_field'=>$extra_field);
      $pInfo->objectInfo($extra_field_array);
// END: Extra Fields Contribution   

    } elseif (tep_not_null($HTTP_POST_VARS)) {
      $pInfo->objectInfo($HTTP_POST_VARS);
      $products_name = $HTTP_POST_VARS['products_name'];
      $products_description = $HTTP_POST_VARS['products_description'];
      $products_short_description = $HTTP_POST_VARS['products_short_description'];
      $products_url = $HTTP_POST_VARS['products_url'];
      $products_seo_url = $HTTP_POST_VARS['products_seo_url'];
      $products_adminnotes = $HTTP_POST_VARS['products_adminnotes'];
    }

    $products_availability_array = array(array('id' => '', 'text' => TEXT_NONE));
    $products_availability_query = tep_db_query("select products_availability_id, products_availability_name from " . TABLE_PRODUCTS_AVAILABILITY . " where language_id = '" . (int)$languages_id . "' order by products_availability_name");
    while ($products_availability = tep_db_fetch_array($products_availability_query)) {
      $products_availability_array[] = array('id' => $products_availability['products_availability_id'],
                                     'text' => $products_availability['products_availability_name']);
    }

    $products_jm_array = array(array('id' => '', 'text' => TEXT_NONE));
    $products_jm_query = tep_db_query("select products_jm_id, products_jm_name from " . TABLE_PRODUCTS_JM . " where language_id = '" . (int)$languages_id . "' order by products_jm_name");
    while ($products_jm = tep_db_fetch_array($products_jm_query)) {
      $products_jm_array[] = array('id' => $products_jm['products_jm_id'],
                                     'text' => $products_jm['products_jm_name']);
    }

    $manufacturers_array = array(array('id' => '0', 'text' => TEXT_NONE));
    $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " FORCE INDEX(manufacturers_name) order by manufacturers_name");
    while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
      $manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
                                     'text' => $manufacturers['manufacturers_name']);
    }

    $default_tax_class_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'DEFAULT_PRODUCT_TAX_CLASS'");
    if (($pInfo->products_tax_class_id == '') && ($default_tax_class = tep_db_fetch_array($default_tax_class_query))) 
      $pInfo->products_tax_class_id = $default_tax_class['configuration_value'];

    $tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
    $tax_class_query = tep_db_query("select tax_class_id, tax_class_title from " . TABLE_TAX_CLASS . " order by tax_class_title");
    while ($tax_class = tep_db_fetch_array($tax_class_query)) {
      $tax_class_array[] = array('id' => $tax_class['tax_class_id'],
                                 'text' => $tax_class['tax_class_title']);
    }

    $languages = tep_get_languages();

    if (!isset($pInfo->products_status)) $pInfo->products_status = '1';
    switch ($pInfo->products_status) {
      case '0': $in_status = false; $out_status = true; break;
      case '1':
      default: $in_status = true; $out_status = false;
    }
?>
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript"><!--
  var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "new_product", "products_date_available","btnDate1","<?php echo $pInfo->products_date_available; ?>",scBTNMODE_CUSTOMBLUE);
//--></script>
<script language="javascript"><!--
var tax_rates = new Array();
<?php
    for ($i=0, $n=sizeof($tax_class_array); $i<$n; $i++) {
      if ($tax_class_array[$i]['id'] > 0) {
        echo 'tax_rates["' . $tax_class_array[$i]['id'] . '"] = ' . tep_get_tax_rate_value($tax_class_array[$i]['id']) . ';' . "\n";
      }
    }
?>

function doRound(x, places) {
  return Math.round(x * Math.pow(10, places)) / Math.pow(10, places);
}

function getTaxRate() {
  var selected_value = document.forms["new_product"].products_tax_class_id.selectedIndex;
  var parameterVal = document.forms["new_product"].products_tax_class_id[selected_value].value;

  if ( (parameterVal > 0) && (tax_rates[parameterVal] > 0) ) {
    return tax_rates[parameterVal];
  } else {
    return 0;
  }
}

//TotalB2B start
function updateGross(products_price_t) {
  var taxRate = getTaxRate(products_price_t);
  
  var grossValue = document.forms["new_product"].elements[products_price_t].value;

  if (taxRate > 0) {
    grossValue = grossValue * ((taxRate / 100) + 1);
  }
 
  var products_price_gross_t = products_price_t + "_gross";

  document.forms["new_product"].elements[products_price_gross_t].value = doRound(grossValue, 4);
}

function updateRetailGross() {
  var taxRate = getTaxRate();
  var grossValue = document.forms["new_product"].products_retail_price.value;

  if (taxRate > 0) {
    grossValue = grossValue * ((taxRate / 100) + 1);
  }

  document.forms["new_product"].products_retail_price_gross.value = doRound(grossValue, 4);
}

function updateNet(products_price_t) {
  var taxRate = getTaxRate();
  var products_price_gross_t = products_price_t + "_gross";
  var netValue = document.forms["new_product"].elements[products_price_gross_t].value;

  if (taxRate > 0) {
    netValue = netValue / ((taxRate / 100) + 1);
  }

  document.forms["new_product"].elements[products_price_t].value = doRound(netValue, 4);
}
//TotalB2B end

function updateRetailNet() {
  var taxRate = getTaxRate();
  var netValue = document.forms["new_product"].products_retail_price_gross.value;

  if (taxRate > 0) {
    netValue = netValue / ((taxRate / 100) + 1);
  }

  document.forms["new_product"].products_retail_price.value = doRound(netValue, 4);
}
//--></script>
    <?php echo tep_draw_form('new_product', FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($HTTP_GET_VARS['pID']) ? '&pID=' . $HTTP_GET_VARS['pID'] : '') . '&action=new_product_preview', 'post', 'enctype="multipart/form-data"'); ?>

    <table border="0" width="90%" cellspacing="0" cellpadding="2" align="center">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo sprintf(TEXT_NEW_PRODUCT, tep_output_generated_category_path($current_category_id)); ?></td>
            <td class="pageHeading" align="right"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
      </tr>
      <tr>
        <td>
         <table border="0" cellspacing="0" cellpadding="2" width="100%">
          <!-- Tab Panel BOF -->
          <tr>
           <td colspan="2" width="100%">
            <div class="tab-pane" id="descriptionTabPane">
             <script type="text/javascript"><!--
             var descriptionTabPane = new WebFXTabPane( document.getElementById( "descriptionTabPane" ) );
             //--></script>

             <?php
             for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
             ?>

              <div class="tab-page" id="tabDescriptionLanguages_<?php echo $languages[$i]['name']; ?>">
              <h2 class="tab"><?php echo tep_image_flag(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?></h2>

              <script type="text/javascript"><!--
              descriptionTabPane.addTabPage( document.getElementById( "tabDescriptionLanguages_<?php echo $languages[$i]['name']; ?>" ) );
              //--></script>

              <table border="0" cellspacing="0" cellpadding="5" width="100%">
               <tr>
                <td class="main"><b><?php echo TEXT_PRODUCTS_NAME; ?></b></td>
                <td class="main"><?php echo tep_draw_input_field('products_name[' . $languages[$i]['id'] . ']', (isset($products_name[$languages[$i]['id']]) ? stripslashes($products_name[$languages[$i]['id']]) : tep_get_products_name($pInfo->products_id, $languages[$i]['id'])), 'size=120'); ?></td>
              
               </tr>
               <tr>
                <td class="main"><b><?php echo TEXT_PRODUCTS_DESCRIPTION; ?></b></td>
                <td class="main">
                <?php
                if (HTML_WYSIWYG_DISABLE == 'Disable') {
                 echo tep_draw_textarea_field('products_description[' . $languages[$i]['id'] . ']', 'soft', '100%', '20', (isset($products_description[$languages[$i]['id']]) ? stripslashes($products_description[$languages[$i]['id']]) : tep_get_products_description($pInfo->products_id, $languages[$i]['id']))); 
                } else {
                 echo tep_draw_fckeditor('products_description[' . $languages[$i]['id'] . ']', '740', '300', (isset($products_description[$languages[$i]['id']]) ? stripslashes($products_description[$languages[$i]['id']]) : tep_get_products_description($pInfo->products_id, $languages[$i]['id'])));
                } ?>
                </td>
               </tr>
               <tr>
                <td class="main"><b><?php echo TEXT_PRODUCTS_URL . '</b><br><small>' . TEXT_PRODUCTS_URL_WITHOUT_HTTP . '</small>'; ?></td>
                <td class="main"><?php echo tep_draw_input_field('products_url[' . $languages[$i]['id'] . ']', (isset($products_url[$languages[$i]['id']]) ? stripslashes($products_url[$languages[$i]['id']]) : tep_get_products_url($pInfo->products_id, $languages[$i]['id']))); ?></td>
               </tr>
               <tr>
                <td class="main"><?php echo TEXT_PRODUCTS_SEO_URL; ?></td>
                <td class="main"><?php echo tep_draw_input_field('products_seo_url[' . $languages[$i]['id'] . ']', (isset($products_seo_url[$languages[$i]['id']]) ? $products_seo_url[$languages[$i]['id']] : tep_get_products_seo_url($pInfo->products_id, $languages[$i]['id']))); ?></td>
               </tr>
 
               <!-- HTC BOC //-->
               <?php
                 if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
                ?>
                        <tr>
                 <td colspan="2" class="main"><hr><?php echo TEXT_PRODUCT_METTA_INFO; ?></td>
                </tr>
                <tr>
                  <td class="main" valign="top"><b><?php echo TEXT_PRODUCTS_PAGE_TITLE; ?></b></td>
                  <td class="main" valign="top"><?php echo tep_draw_textarea_field('products_head_title_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '1', (isset($products_head_title_tag[$languages[$i]['id']]) ? $products_head_title_tag[$languages[$i]['id']] : tep_get_products_head_title_tag($pInfo->products_id, $languages[$i]['id']))); ?></td>
                </tr>
                <tr>
                 <td class="main" valign="top"><b><?php echo TEXT_PRODUCTS_HEADER_DESCRIPTION; ?></b></td>
                 <td class="main" valign="top"><?php echo tep_draw_textarea_field('products_head_desc_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '1', (isset($products_head_desc_tag[$languages[$i]['id']]) ? stripslashes($products_head_desc_tag[$languages[$i]['id']]) : tep_get_products_head_desc_tag($pInfo->products_id, $languages[$i]['id']))); ?></td>
                </tr>
                <tr>
                 <td class="main" valign="top"><b><?php echo TEXT_PRODUCTS_KEYWORDS; ?></b></td>
                 <td class="main" valign="top"><?php echo tep_draw_textarea_field('products_head_keywords_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '1', (isset($products_head_keywords_tag[$languages[$i]['id']]) ? stripslashes($products_head_keywords_tag[$languages[$i]['id']]) : tep_get_products_head_keywords_tag($pInfo->products_id, $languages[$i]['id']))); ?></td>
                </tr>
<?php } ?>

<!-- HTC EOC //-->


              

              
              
              </table>
              </div>
             <?php
             }
             ?>
            </div>
           </td>
          </tr>
          <!-- Tab Panel EOF -->
</table></td></tr></tr></table>
    <table border="0" width="90%" cellspacing="0" cellpadding="2" align="center" >
      <tr>
	          <td>
         <table border="0" cellspacing="0" cellpadding="2" width="100%" class="main1">
          <tr>
            <td class="main"><b><?php echo TEXT_PRODUCTS_STATUS; ?></b></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_radio_field('products_status', '1', $in_status) . '&nbsp;' . TEXT_PRODUCT_AVAILABLE . '&nbsp;' . tep_draw_radio_field('products_status', '0', $out_status) . '&nbsp;' . TEXT_PRODUCT_NOT_AVAILABLE; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><b><?php echo TEXT_PRODUCTS_DATE_AVAILABLE; ?></b><br><small>(YYYY-MM-DD)</small></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;'; ?><script language="javascript">dateAvailable.writeControl(); dateAvailable.dateFormat="yyyy-MM-dd";</script></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><b><?php echo TEXT_PRODUCTS_AVAILABILITY; ?></b></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('products_availability_id', $products_availability_array, $pInfo->products_availability_id); ?></td>
          </tr>
          <tr>
            <td class="main"><b><?php echo TEXT_PRODUCTS_MANUFACTURER; ?></b></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $pInfo->manufacturers_id); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><b><?php echo TEXT_PRODUCTS_MODEL; ?></b></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_model', $pInfo->products_model); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><b><?php echo TEXT_PRODUCTS_QUANTITY; ?></b></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_quantity', $pInfo->products_quantity); ?></td>
          </tr>
          <tr>
           <td class="main"><b><?php echo TEXT_PRODUCTS_MAXIMUM; ?></b></td>
           <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_maxorder', $pInfo->products_maxorder); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <!--TotalB2B start-->  
          <tr >
            <td class="main"><b><?php echo TEXT_PRODUCTS_TAX_CLASS; ?></b></td>
            <td class="main"><?php 
              $prices_num = tep_xppp_getpricesnum();
              $gross_update = 'updateGross(\'products_price\');';
              for ($i=2; $i<=$prices_num; $i++)
                  $gross_update .= 'updateGross(\'products_price_'. $i . '\');';
            echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('products_tax_class_id', $tax_class_array, $pInfo->products_tax_class_id, 'onchange="' . $gross_update .'"'); ?></td>
          </tr>


          <tr >
            <td class="main"><b><?php echo TEXT_PRODUCTS_RETAIL_PRICE_NET; ?></b></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_retail_price', $pInfo->products_retail_price, 'onKeyUp="updateRetailGross()"'); ?></td>
          </tr>
          <tr >
            <td class="main"><b><?php echo TEXT_PRODUCTS_RETAIL_PRICE_GROSS; ?></b></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_retail_price_gross', $pInfo->products_retail_price, 'onKeyUp="updateRetailNet()"'); ?></td>
          </tr>

          <tr >
            <td class="main"><b><br><?php echo TEXT_PRODUCTS_PRICE_PODST; ?></b></td>
            <td class="main"></td>
          </tr>

          <tr >
            <td class="main"><b><?php echo TEXT_PRODUCTS_PRICE_NET; ?></b></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_price', $pInfo->products_price, 'onKeyUp="updateGross(\'products_price\')"'); ?></td>
          </tr>
          <tr >
            <td class="main"><b><?php echo TEXT_PRODUCTS_PRICE_GROSS; ?></b></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_price_gross', $pInfo->products_price, 'OnKeyUp="updateNet(\'products_price\')"'); ?></td>
          </tr>
          <?php
              $prices_num = tep_xppp_getpricesnum();

              if ($prices_num > 1) {
               echo '<tr bgcolor="#FFFFFF">';
               echo '<td class="main"><br>' .TEXT_PRODUCTS_PRICE_EXT. '</td>';
               echo '<td class="main"></td>';
               echo '</tr>';
              }
              
              for ($i=2; $i<=$prices_num; $i++) {?>

          <tr >
            <td class="main" colspan="2"><br><?php echo ENTRY_PRODUCTS_PRICE . " " . $i;?>&nbsp;<input type="checkbox" name="<?php echo "checkbox_products_price_" . $i;?>" <?php
                $products_price_X = "products_price_" . $i;
                if ($pInfo->$products_price_X != NULL) echo " checked "; ?> value="true" onClick="if (!<?php echo "products_price_" . $i;?>.disabled) { <?php echo "products_price_" . $i;?>.disabled = true;  <?php echo "products_price_". $i . "_gross";?>.disabled = true; } else { <?php echo "products_price_" . $i;?>.disabled = false;  <?php echo "products_price_". $i . "_gross";?>.disabled = false; } "></td>
          </tr>

          <tr >
            <td class="main"><b><?php echo TEXT_PRODUCTS_PRICE_NET; ?></b></td>
            <td class="main"><?php
                $products_price_X = "products_price_" . $i;
                if ($pInfo->$products_price_X == NULL) {
                  echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_price_' . $i, $pInfo->$products_price_X, 'onKeyUp="updateGross(\'products_price_' . $i .'\')", disabled');
                } else {
                  echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_price_' . $i, $pInfo->$products_price_X, 'onKeyUp="updateGross(\'products_price_' . $i .'\')"');
                } ?></td>
          </tr>
          <tr >
            <td class="main"><b><?php echo TEXT_PRODUCTS_PRICE_GROSS; ?></b></td>
            <td class="main"><?php
                $products_price_X = "products_price_" . $i;
                if ($pInfo->$products_price_X == NULL) {
                  echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_price_'. $i . '_gross', $pInfo->$products_price_X, 'OnKeyUp="updateNet(\'products_price_' . $i .'\')", disabled');
                } else {
                  echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_price_'. $i . '_gross', $pInfo->$products_price_X, 'OnKeyUp="updateNet(\'products_price_' . $i .'\')"');
                } ?>
            </td>
          </tr>

          <?php } ?>
		  <?php // start indvship ?>
					<!-- Zipcode -->
					<tr bgcolor="#ebebff">
						<td class="main"><?php echo TEXT_PRODUCTS_ZIPCODE; ?></td>
						<td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_ship_zip', $pInfo->products_ship_zip); if(tep_not_null($pInfo->products_ship_zip)) echo 'notnull'; else echo 'null'; ?></td>
					</tr>
					<!-- end Zipcode -->
					<!-- Indvship -->
					<tr bgcolor="#ebebff">
						<td class="main"><?php echo INDIV_SHIPPING_PRICE; ?></td>
						<td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_ship_price', $pInfo->products_ship_price); if(tep_not_null($pInfo->products_ship_price)) echo 'notnull'; else echo 'null'; ?></td>
					</tr>
					<tr bgcolor="#ebebff">
						<td class="main"><?php echo EACH_ADDITIONAL_PRICE; ?></td>
						<td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_ship_price_two', $pInfo->products_ship_price_two); if(tep_not_null($pInfo->products_ship_price_two)) echo 'notnull'; else echo 'null'; ?></td>
					</tr>
					<!-- end Indvship -->
					<tr>
						<td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
					</tr>
					<?php // end indvship ?>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
       </tr>


      <tr >
        <td class="main"><b><?php echo TEXT_PRODUCTS_ADMIN_NOTES; ?></b></td>
        <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_textarea_field('products_adminnotes', 'soft', '70', '1', $pInfo->products_adminnotes); ?></td>
      </tr>

          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
       </tr>

<script language="javascript">
updateGross('products_price');
<?php
  $prices_num = tep_xppp_getpricesnum();
  for ($i=2; $i<=$prices_num; $i++) echo 'updateGross(\'products_price_' . $i . '\');';
?>
</script>
          <!--TotalB2B end-->

<script language="javascript"><!--
updateRetailGross();
//--></script>
              <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
           <tr>

          <td class="main"><b><?php echo TEXT_PRODUCTS_IMAGE; ?></b></td>
          <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '10') . '&nbsp;' . tep_draw_input_field('products_image', $pInfo->products_image, ' id="file1" size="60"') . '&nbsp;<button type="button" style="font-size:10px; font-face:Verdana; color:#000000; background-color:#fcfcfe; border-color: #919b9c; border-style: solid; border-width: 1px; " onclick="BrowseServer(\'file1\');"/>Wybierz Obrazek</button><br>' . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_image . tep_draw_hidden_field('products_previous_image', $pInfo->products_image); ?></td>
          </tr>
  
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>

          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><b><?php echo TEXT_PRODUCTS_WEIGHT; ?></b></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_weight', $pInfo->products_weight); ?></td>
          </tr>
          <tr>
            <td class="main"><b><?php echo TEXT_PRODUCTS_JM; ?></b></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('products_jm_id', $products_jm_array, $pInfo->products_jm_id); ?></td>
          </tr>
<?php
// START: Extra Fields Contribution (chapter 1.4)
      // Sort language by ID  
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $languages_array[$languages[$i]['id']]=$languages[$i];
      }
      $extra_fields_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_EXTRA_FIELDS . " ORDER BY products_extra_fields_order");
      while ($extra_fields = tep_db_fetch_array($extra_fields_query)) {
      // Display language icon or blank space
        if ($extra_fields['languages_id']==0) {
          $m=tep_draw_separator('pixel_trans.gif', '24', '15');
        } else $m= tep_image(DIR_WS_CATALOG_LANGUAGES . $languages_array[$extra_fields['languages_id']]['directory'] . '/images/' . $languages_array[$extra_fields['languages_id']]['image'], $languages_array[$extra_fields['languages_id']]['name']);
?>
          <tr>
            <td class="main"><b><?php echo $extra_fields['products_extra_fields_name']; ?>:</b></td>
            <td class="main"><?php echo $m . '&nbsp;' . tep_draw_input_field("extra_field[".$extra_fields['products_extra_fields_id']."]", $pInfo->extra_field[$extra_fields['products_extra_fields_id']]); ?></td>
          </tr>
<?php
}
// END: Extra Fields Contribution
?>






        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right"><?php echo tep_draw_hidden_field('products_date_added', (tep_not_null($pInfo->products_date_added) ? $pInfo->products_date_added : date('Y-m-d'))) . tep_image_submit('button_preview.gif', IMAGE_PREVIEW) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($HTTP_GET_VARS['pID']) ? '&pID=' . $HTTP_GET_VARS['pID'] : '')) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
      </tr>
    </table></form>

<!-- HTC BOC //--> 
<?php
  } elseif ($action == 'new_product_preview') {
    if (tep_not_null($HTTP_POST_VARS)) {
      $pInfo = new objectInfo($HTTP_POST_VARS);
      $products_name = $HTTP_POST_VARS['products_name'];
      $products_description = $HTTP_POST_VARS['products_description'];
      $products_short_description = $HTTP_POST_VARS['products_short_description'];
      $products_head_title_tag = $HTTP_POST_VARS['products_head_title_tag'];
      $products_head_desc_tag = $HTTP_POST_VARS['products_head_desc_tag'];
      $products_head_keywords_tag = $HTTP_POST_VARS['products_head_keywords_tag'];
      $products_url = $HTTP_POST_VARS['products_url'];
      $products_seo_url = $HTTP_POST_VARS['products_seo_url'];
    } else {

      //TotalB2B start
      $products_price_list = tep_xppp_getpricelist("p");
      $product_query = tep_db_query("select p.products_id, pd.language_id, pd.products_name, pd.products_seo_url, pd.products_description, pd.products_short_description, pd.products_head_title_tag, pd.products_head_desc_tag, pd.products_head_keywords_tag, pd.products_url, p.products_quantity, p.products_model, p.products_image, p.products_retail_price, " . $products_price_list . ", p.products_weight, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p.products_maxorder, p.manufacturers_id, p.products_availability_id, p.products_jm_id, p.products_adminnotes from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and p.products_id = '" . (int)$HTTP_GET_VARS['pID'] . "'");
      
      //TotalB2B end
      
      $product = tep_db_fetch_array($product_query);
 // HTC EOC

      $pInfo = new objectInfo($product);
      $products_image_name = $pInfo->products_image;

//START Additional Images
      $products_image_name_pop = $pInfo->products_image_pop;
//END Additional Images

    }

    $form_action = (isset($HTTP_GET_VARS['pID'])) ? 'update_product' : 'insert_product';

    echo tep_draw_form($form_action, FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($HTTP_GET_VARS['pID']) ? '&pID=' . $HTTP_GET_VARS['pID'] : '') . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"');

    $languages = tep_get_languages();
    ?>
    <table border="0" cellspacing="0" cellpadding="2" width="100%">
     <!-- Tab Panel BOF -->
     <tr>
      <td colspan="2" width="100%">
       <div class="tab-pane" id="descriptionTabPane">
        <script type="text/javascript"><!--
        var descriptionTabPane = new WebFXTabPane( document.getElementById( "descriptionTabPane" ) );
        //--></script>

        <?php
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        ?>

         <div class="tab-page" id="tabDescriptionLanguages_<?php echo $languages[$i]['name']; ?>">
         <h2 class="tab"><?php echo tep_image_flag(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?></h2>

         <script type="text/javascript"><!--
         descriptionTabPane.addTabPage( document.getElementById( "tabDescriptionLanguages_<?php echo $languages[$i]['name']; ?>" ) );
         //--></script>
         <?php
         // HTC BOC         
         if (isset($HTTP_GET_VARS['read']) && ($HTTP_GET_VARS['read'] == 'only')) {
          $pInfo->products_name = tep_get_products_name($pInfo->products_id, $languages[$i]['id']);
          $pInfo->products_description = tep_get_products_description($pInfo->products_id, $languages[$i]['id']);
          $pInfo->products_short_description = tep_get_products_short_description($pInfo->products_id, $languages[$i]['id']);
              if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
                $pInfo->products_head_title_tag = tep_db_prepare_input($products_head_title_tag[$languages[$i]['id']]);
            $pInfo->products_head_desc_tag = tep_db_prepare_input($products_head_desc_tag[$languages[$i]['id']]);
            $pInfo->products_head_keywords_tag = tep_db_prepare_input($products_head_keywords_tag[$languages[$i]['id']]);
              }
              $pInfo->products_url = tep_get_products_url($pInfo->products_id, $languages[$i]['id']);
            $pInfo->products_seo_url = tep_get_products_seo_url($pInfo->products_id, $languages[$i]['id']);
         } else {
          $pInfo->products_name = tep_db_prepare_input($products_name[$languages[$i]['id']]);
          $pInfo->products_description = tep_db_prepare_input($products_description[$languages[$i]['id']]);
          $pInfo->products_short_description = tep_db_prepare_input($products_short_description[$languages[$i]['id']]);
              if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
            $pInfo->products_head_title_tag = tep_db_prepare_input($products_head_title_tag[$languages[$i]['id']]);
            $pInfo->products_head_desc_tag = tep_db_prepare_input($products_head_desc_tag[$languages[$i]['id']]);
            $pInfo->products_head_keywords_tag = tep_db_prepare_input($products_head_keywords_tag[$languages[$i]['id']]);
          }
              $pInfo->products_url = tep_db_prepare_input($products_url[$languages[$i]['id']]);
            $pInfo->products_seo_url = tep_db_prepare_input($products_seo_url[$languages[$i]['id']]);
         }
         // HTC EOC
         ?>
         <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
           <td>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
             <tr>
                     <!--TotalB2B start-->
                     <td class="pageHeading" align="right">
                  <?php 
                        if ($pInfo->products_retail_price > 0) {
                         echo ''.TEXT_PRODUCTS_RETAIL_PRICE_NET. ' '.$currencies->format($pInfo->products_retail_price). '<br>';
                      }
                      $prices_num = tep_xppp_getpricesnum();
                      echo ENTRY_PRODUCTS_PRICE . " 1: " . $currencies->format($pInfo->products_price);
                for ($b=2; $b<=$prices_num; $b++) {
                         $products_price_X = "products_price_" . $b;
                         echo "<br>" . ENTRY_PRODUCTS_PRICE . " " . $b. ": ";
                         if (tep_not_null($HTTP_POST_VARS)) {
                            if (tep_db_prepare_input($HTTP_POST_VARS['checkbox_products_price_' . $b]) != "true") echo ENTRY_PRODUCTS_PRICE_DISABLED;                  
                          else echo $currencies->format($pInfo->$products_price_X);
                         } else {
                          if ($product['products_price_' . $b] == NULL) echo ENTRY_PRODUCTS_PRICE_DISABLED;
                          else echo $currencies->format($pInfo->$products_price_X);
                         }
                        }
                      ?>
              </td>
                    <!--TotalB2B end-->
                 </tr>
            </table>
           </td>
          </tr>
          <tr>
           <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
           <td class="main">
            <?php 
            //BOF: Default-image hack
            if ($products_image_name) {
               echo tep_image(DIR_WS_CATALOG_IMAGES . $products_image_name, $pInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="right" hspace="5" vspace="5"');
            } else {
               echo tep_image(DIR_WS_CATALOG_IMAGES . 'default.gif', $pInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="right" hspace="5" vspace="5"');
            }
            //EOF: Default-image hack

            // START: Extra Fields Contribution (chapter 1.5)
            if ($HTTP_GET_VARS['read'] == 'only') {
             $products_extra_fields_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " WHERE products_id=" . (int)$HTTP_GET_VARS['pID']);
             while ($products_extra_fields = tep_db_fetch_array($products_extra_fields_query)) {
              $extra_fields_array[$products_extra_fields['products_extra_fields_id']] = $products_extra_fields['products_extra_fields_value'];
             }
            } else {
             $extra_fields_array = $HTTP_POST_VARS['extra_field'];
            }

            $extra_fields_names_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_EXTRA_FIELDS. " WHERE languages_id='0' or languages_id='".(int)$languages[$i]['id']."' ORDER BY products_extra_fields_order");
            while ($extra_fields_names = tep_db_fetch_array($extra_fields_names_query)) {
             $extra_field_name[$extra_fields_names['products_extra_fields_id']] = $extra_fields_names['products_extra_fields_name'];
                   echo '<B>'.$extra_fields_names['products_extra_fields_name'].':</B>&nbsp;'.stripslashes($extra_fields_array[$extra_fields_names['products_extra_fields_id']]).'<BR>'."\n";
            }         
            // END: Extra Fields Contribution
            echo "<br />" . $pInfo->products_short_description;
            echo "<br />" . $pInfo->products_description;
            ?>
           </td>
          </tr>
          <?php
          if ($pInfo->products_url) {
          ?>
          <tr>
           <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
           <td class="main"><?php echo sprintf(TEXT_PRODUCT_MORE_INFORMATION, $pInfo->products_url); ?></td>
          </tr>
          <?php
          }
          ?>
          <tr>
           <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php
          if ($pInfo->products_date_available > date('Y-m-d')) {
          ?>
          <tr>
           <td align="center" class="smallText"><?php echo sprintf(TEXT_PRODUCT_DATE_AVAILABLE, tep_date_long($pInfo->products_date_available)); ?></td>
          </tr>
          <?php
          } else {
          ?>
          <tr>
           <td align="center" class="smallText"><?php echo sprintf(TEXT_PRODUCT_DATE_ADDED, tep_date_long($pInfo->products_date_added)); ?></td>
          </tr>
          <?php
          }
          ?>
          <tr>
           <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
         </table>
        </div>
       <?php
       }
       ?>
      </div>
     </td>
    </tr>
   </table>
   <!-- Tab Panel EOF -->
   <table cellspacing="0" cellpadding="0" border="0" width="100%">

   <?php
    if (isset($HTTP_GET_VARS['read']) && ($HTTP_GET_VARS['read'] == 'only')) {
     if (isset($HTTP_GET_VARS['origin'])) {
      $pos_params = strpos($HTTP_GET_VARS['origin'], '?', 0);
      if ($pos_params != false) {
       $back_url = substr($HTTP_GET_VARS['origin'], 0, $pos_params);
       $back_url_params = substr($HTTP_GET_VARS['origin'], $pos_params + 1);
      } else {
       $back_url = $HTTP_GET_VARS['origin'];
       $back_url_params = '';
      }
     } else {
      $back_url = FILENAME_CATEGORIES;
      $back_url_params = 'cPath=' . $cPath . '&pID=' . $pInfo->products_id;
     }
     ?>
     <tr>
      <td align="right"><?php echo '<a href="' . tep_href_link($back_url, $back_url_params, 'NONSSL') . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
     </tr>
     <?php
    } else {
     ?>
     <tr>
      <td align="right" class="smallText">
       <?php

    /////////////////////////////////////////////////////////////////////
    // BOF: WebMakers.com Added: Modified to include Attributes Code
    //Re-Post all POST'ed variables 
          reset($HTTP_POST_VARS);
          while (list($key, $value) = each($HTTP_POST_VARS)) {
            if (is_array($value)) {
              while (list($k, $v) = each($value)) {
                echo tep_draw_hidden_field($key . '[' . $k . ']', htmlspecialchars(stripslashes($v)));
              }
            } else {
              echo tep_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
            }
          }
    // EOF: WebMakers.com Added: Modified to include Attributes Code
    /////////////////////////////////////////////////////////////////////

    // START: Extra Fields Contribution
      if ($HTTP_POST_VARS['extra_field']) { // Check to see if there are any need to update extra fields.
        foreach ($HTTP_POST_VARS['extra_field'] as $key=>$val) {
          echo tep_draw_hidden_field('extra_field['.$key.']', stripslashes($val));
        }
      } // Check to see if there are any need to update extra fields.
      // END: Extra Fields Contribution

      //BOF: Default-image hack
      //echo tep_draw_hidden_field('products_image', stripslashes($products_image_name));
      if ($products_image_name) {
         echo tep_draw_hidden_field('products_image', stripslashes($products_image_name));
      } else {
         echo tep_draw_hidden_field('products_image', 'default.gif');
      }
      //EOF: Default-image hack

    //START Additional Images
      echo tep_draw_hidden_field('products_image_pop', stripslashes($products_image_pop_name));
      //END Additional Images

      echo tep_image_submit('button_back.gif', IMAGE_BACK, 'name="edit"') . '&nbsp;&nbsp;';

      if (isset($HTTP_GET_VARS['pID'])) {
        echo tep_image_submit('button_update.gif', IMAGE_UPDATE);
      } else {
        echo tep_image_submit('button_insert.gif', IMAGE_INSERT);
      }
      echo '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($HTTP_GET_VARS['pID']) ? '&pID=' . $HTTP_GET_VARS['pID'] : '')) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>';
?></td>
      </tr>
    </table></form>
<?php
    }
  } else {
//Listado Fabricante 
$manufacturers_array = array(array('id' => '', 'text' => TEXT_NONE));
$manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
$manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
'text' => $manufacturers['manufacturers_name']);
}
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td align="right"><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText" align="right">
                 <?php
                 echo tep_draw_form('search', FILENAME_CATEGORIES, '', 'get');
                 echo HEADING_TITLE_SEARCH . '</td><td>'.tep_draw_separator('pixel_trans.gif', 10, 1).'</td><td class="smallText" align="left">' . tep_draw_input_field('search');
                 echo tep_hide_session_id() . '</form>';
                 ?>
                </td>
              </tr>
              <tr>
                <td class="smallText" align="right">
                  <?php
                  echo tep_draw_form('goto', FILENAME_CATEGORIES, '', 'get');
                  echo HEADING_TITLE_GOTO . '</td><td>'.tep_draw_separator('pixel_trans.gif', 10, 1).'</td><td class="smallText" align="left">' . tep_draw_pull_down_menu('cPath', tep_get_category_tree(), $current_category_id, 'onChange="this.form.submit();"');
                  echo tep_hide_session_id() . '</form>';
                  ?>
                </td>
              </tr>
              <tr>
                <td class="smallText" align="right">
                  <?php
				  //Listado fabricante
                  echo tep_draw_form('goto', FILENAME_CATEGORIES, '', 'get');
				  echo TEXT_PRODUCTS_MANUFACTURER . '</td><td>'.tep_draw_separator('pixel_trans.gif', 10, 1).'</td><td class="smallText" align="left">' . tep_draw_pull_down_menu('mID', $manufacturers_array, $HTTP_GET_VARS['mID'], 'onChange="this.form.submit();"') . '<br>'; 
                  echo tep_hide_session_id() . '</form>';
                  ?>
                </td>
              </tr>
            </table></td>
          </tr>
          <tr>
           <td class="headerNavigation" colspan="3">&nbsp;&nbsp;<?php echo $breadcrumb->trail(' &raquo; '); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2" style="border-color: #424242; border-width: 1px; border-style: solid;">
              <tr class="dataTableHeadingRow">
                <!-- Begin Mini Images //-->
                <td class="dataTableHeadingContent" width="60"><?php echo TABLE_HEADING_IMAGE; ?></td>
                <!-- End Mini Images //-->
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CATEGORIES_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CATEGORIES_MODEL; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $categories_count = 0;
    $rows = 0;
    if (isset($HTTP_GET_VARS['search'])) {
      $search = tep_db_prepare_input($HTTP_GET_VARS['search']);

    // HTC BOC
      if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
        $categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_seo_url, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, cd.categories_htc_title_tag, cd.categories_htc_desc_tag, cd.categories_htc_keywords_tag, cd.categories_htc_description, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.categories_name like '%" . tep_db_input($search) . "%' order by c.sort_order, cd.categories_name");
      } else {
        $categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_seo_url, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, cd.categories_htc_description, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.categories_name like '%" . tep_db_input($search) . "%' order by c.sort_order, cd.categories_name");
      }
    //Listado Fabricante
    } elseif (isset($HTTP_GET_VARS['mID'])) {
      $manufacturer = tep_db_prepare_input($HTTP_GET_VARS['mID']);
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.categories_name like '%" . tep_db_input($manufacturer) . "%' order by c.sort_order, cd.categories_name");
      // ****
    } else {
      if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
        $categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_seo_url, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, cd.categories_htc_title_tag, cd.categories_htc_desc_tag, cd.categories_htc_keywords_tag, cd.categories_htc_description, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by c.sort_order, cd.categories_name");
      } else {
        $categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_seo_url, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, cd.categories_htc_description, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by c.sort_order, cd.categories_name");
      }
    // HTC EOC
    }
    while ($categories = tep_db_fetch_array($categories_query)) {
      $categories_count++;
      $rows++;

// Get parent_id for subcategories if search
//      if (isset($HTTP_GET_VARS['search'])) $cPath= $categories['parent_id'];
      //Listado Fabricantes
      if (isset($HTTP_GET_VARS['search']) or isset($HTTP_GET_VARS['mID'])) $cPath= $categories['parent_id'];

      if ((!isset($HTTP_GET_VARS['cID']) && !isset($HTTP_GET_VARS['pID']) || (isset($HTTP_GET_VARS['cID']) && ($HTTP_GET_VARS['cID'] == $categories['categories_id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
        $category_childs = array('childs_count' => tep_childs_in_category_count($categories['categories_id']));
        $category_products = array('products_count' => tep_products_in_category_count($categories['categories_id']));

        $cInfo_array = array_merge($categories, $category_childs, $category_products);
        $cInfo = new objectInfo($cInfo_array);
      }

      if (isset($cInfo) && is_object($cInfo) && ($categories['categories_id'] == $cInfo->categories_id) ) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_CATEGORIES, tep_get_path($categories['categories_id'], $categories['parent_id'], $categories['grand_parent_id'])) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories['categories_id']) . '\'">' . "\n";
      }
?>
                <!-- Begin Mini Images //-->
                <td class="dataTableContent"><?php echo tep_image(DIR_WS_CATALOG_IMAGES . $categories['categories_image'], $categories['catergories_name'], 30, 30); ?></td>
                <!-- End Mini Images //-->
                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, tep_get_path($categories['categories_id'], $categories['parent_id'], $categories['grand_parent_id'])) . '">' . tep_image(DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . '</a>&nbsp;<b>' . $categories['categories_name'] . '</b>'; ?></td>

                <td class="dataTableContent" align="center">&nbsp;</td>
                <td class="dataTableContent" align="center">
<?php
      if ($categories['categories_status'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag_cat&flag=0&cID=' . $categories['categories_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag_cat&flag=1&cID=' . $categories['categories_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?>
                </td>
<!-- // ################" End Added Categories Disable ############# -->
                <td class="dataTableContent" align="right"><?php if (isset($cInfo) && is_object($cInfo) && ($categories['categories_id'] == $cInfo->categories_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories['categories_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

    $products_count = 0;
    if (isset($HTTP_GET_VARS['search'])) {
      $products_query = tep_db_query("select p.products_id, pd.products_name, pd.products_seo_url, p.products_quantity, products_model, p.products_image, p.products_retail_price, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p.products_maxorder, p.products_adminnotes, p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and ( (pd.products_name like '%" . tep_db_input($search) . "%') or (products_model like '%" . tep_db_input($search) . "%') )");
    //Listado Fabricantes 
    } elseif (isset($HTTP_GET_VARS['mID'])) {
      $products_query = tep_db_query("select m.manufacturers_id, p.manufacturers_id, p.products_id, pd.products_name, p.products_quantity, products_model, p.products_image, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m where p.products_status = '1' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['mID'] . "' order by pd.products_name");
      // ************* 
    } else {
      $products_query = tep_db_query("select p.products_id, pd.products_name, pd.products_seo_url, p.products_quantity, products_model, p.products_image, p.products_retail_price, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p.products_maxorder, p.products_adminnotes from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' order by pd.products_name");
    }
    while ($products = tep_db_fetch_array($products_query)) {
      $products_count++;
      $rows++;

// Get categories_id for product if search
      if (isset($HTTP_GET_VARS['search'])) $cPath = $products['categories_id'];
       // Listado Fabricante
       // Get categories_id for product if manufacturers
       if (isset($HTTP_GET_VARS['mID'])) {
         $category_manufacturer_query = tep_db_query("select p2c.products_id, p2c.categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p2c.products_id = " . $products['products_id'] );
         $category_manufacturer = tep_db_fetch_array($category_manufacturer_query);
         $cPath = $category_manufacturer['categories_id'];
       }
       // ***************** 

      if ( (!isset($HTTP_GET_VARS['pID']) && !isset($HTTP_GET_VARS['cID']) || (isset($HTTP_GET_VARS['pID']) && ($HTTP_GET_VARS['pID'] == $products['products_id']))) && !isset($pInfo) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
// find out the rating average from customer reviews
        $reviews_query = tep_db_query("select (avg(reviews_rating) / 5 * 100) as average_rating from " . TABLE_REVIEWS . " where products_id = '" . (int)$products['products_id'] . "'");
        $reviews = tep_db_fetch_array($reviews_query);
        $pInfo_array = array_merge($products, $reviews);
        $pInfo = new objectInfo($pInfo_array);
      }

      if (isset($pInfo) && is_object($pInfo) && ($products['products_id'] == $pInfo->products_id) ) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products['products_id'] . '&action=new_product_preview&read=only') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products['products_id']) . '\'">' . "\n";
      }
?>
                <!-- Begin Mini Images //-->
                <td class="dataTableContent"><?php echo tep_image(DIR_WS_CATALOG_IMAGES . $products['products_image'], $products['products_name'], 30, 30); ?></td>
                <!-- End Mini Images //-->
                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products['products_id'] . '&action=new_product_preview&read=only') . '">' . tep_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $products['products_name']; ?></td>
                <td class="dataTableContent"><?php echo $products['products_model']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($products['products_status'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=0&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=1&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if (isset($pInfo) && is_object($pInfo) && ($products['products_id'] == $pInfo->products_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

    $cPath_back = '';
    if (sizeof($cPath_array) > 0) {
      for ($i=0, $n=sizeof($cPath_array)-1; $i<$n; $i++) {
        if (empty($cPath_back)) {
          $cPath_back .= $cPath_array[$i];
        } else {
          $cPath_back .= '_' . $cPath_array[$i];
        }
      }
    }

    $cPath_back = (tep_not_null($cPath_back)) ? 'cPath=' . $cPath_back . '&' : '';
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo TEXT_CATEGORIES . '&nbsp;' . $categories_count . '<br>' . TEXT_PRODUCTS . '&nbsp;' . $products_count; ?></td>
                    <td align="right" class="smallText"><?php if (sizeof($cPath_array) > 0) echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, $cPath_back . 'cID=' . $current_category_id) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>&nbsp;'; if (!isset($HTTP_GET_VARS['search'])) echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&action=new_category') . '">' . tep_image_button('button_new_category.gif', IMAGE_NEW_CATEGORY) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&action=new_product') . '">' . tep_image_button('button_new_product.gif', IMAGE_NEW_PRODUCT) . '</a>'; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($action) {
      case 'new_category':
		break;
      case 'edit_category':
        break;
      case 'delete_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CATEGORY . '</b>');

        $contents = array('form' => tep_draw_form('categories', FILENAME_CATEGORIES, 'action=delete_category_confirm&cPath=' . $cPath) . tep_draw_hidden_field('categories_id', $cInfo->categories_id));
        $contents[] = array('text' => TEXT_DELETE_CATEGORY_INTRO);
        $contents[] = array('text' => '<br><b>' . $cInfo->categories_name . '</b>');
        if ($cInfo->childs_count > 0) $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_CHILDS, $cInfo->childs_count));
        if ($cInfo->products_count > 0) $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_PRODUCTS, $cInfo->products_count));
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'move_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_CATEGORY . '</b>');

        $contents = array('form' => tep_draw_form('categories', FILENAME_CATEGORIES, 'action=move_category_confirm&cPath=' . $cPath) . tep_draw_hidden_field('categories_id', $cInfo->categories_id));
        $contents[] = array('text' => sprintf(TEXT_MOVE_CATEGORIES_INTRO, $cInfo->categories_name));
        $contents[] = array('text' => '<br>' . sprintf(TEXT_MOVE, $cInfo->categories_name) . '<br>' . tep_draw_pull_down_menu('move_to_category_id', tep_get_category_tree(), $current_category_id));
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_move.gif', IMAGE_MOVE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'delete_product':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_PRODUCT . '</b>');

        $contents = array('form' => tep_draw_form('products', FILENAME_CATEGORIES, 'action=delete_product_confirm&cPath=' . $cPath) . tep_draw_hidden_field('products_id', $pInfo->products_id));
        $contents[] = array('text' => TEXT_DELETE_PRODUCT_INTRO);
        $contents[] = array('text' => '<br><b>' . $pInfo->products_name . '</b>');

        $product_categories_string = '';
        $product_categories = tep_generate_category_path($pInfo->products_id, 'product');
        for ($i = 0, $n = sizeof($product_categories); $i < $n; $i++) {
          $category_path = '';
          for ($j = 0, $k = sizeof($product_categories[$i]); $j < $k; $j++) {
            $category_path .= $product_categories[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
          }
          $category_path = substr($category_path, 0, -16);
          $product_categories_string .= tep_draw_checkbox_field('product_categories[]', $product_categories[$i][sizeof($product_categories[$i])-1]['id'], true) . '&nbsp;' . $category_path . '<br>';
        }
        $product_categories_string = substr($product_categories_string, 0, -4);

        $contents[] = array('text' => '<br>' . $product_categories_string);
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'move_product':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_PRODUCT . '</b>');

        $contents = array('form' => tep_draw_form('products', FILENAME_CATEGORIES, 'action=move_product_confirm&cPath=' . $cPath) . tep_draw_hidden_field('products_id', $pInfo->products_id));
        $contents[] = array('text' => sprintf(TEXT_MOVE_PRODUCTS_INTRO, $pInfo->products_name));
        $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENT_CATEGORIES . '<br><b>' . tep_output_generated_category_path($pInfo->products_id, 'product') . '</b>');
        $contents[] = array('text' => '<br>' . sprintf(TEXT_MOVE, $pInfo->products_name) . '<br>' . tep_draw_pull_down_menu('move_to_category_id', tep_get_category_tree(), $current_category_id));
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_move.gif', IMAGE_MOVE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'copy_to':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_TO . '</b>');

        $contents = array('form' => tep_draw_form('copy_to', FILENAME_CATEGORIES, 'action=copy_to_confirm&cPath=' . $cPath) . tep_draw_hidden_field('products_id', $pInfo->products_id));
        $contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
        $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENT_CATEGORIES . '<br><b>' . tep_output_generated_category_path($pInfo->products_id, 'product') . '</b>');
        $contents[] = array('text' => '<br>' . TEXT_CATEGORIES . '<br>' . tep_draw_pull_down_menu('categories_id', tep_get_category_tree(), $current_category_id));
        $contents[] = array('text' => '<br>' . TEXT_HOW_TO_COPY . '<br>' . tep_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br>' . tep_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE);
// BOF: Attributes copy
// WebMakers.com Added: Attributes Copy
        $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
        // only ask about attributes if they exist
        if (tep_has_product_attributes($pInfo->products_id)) {
          $contents[] = array('text' => '<br>' . TEXT_COPY_ATTRIBUTES_ONLY );
          $contents[] = array('text' => '<br>' . TEXT_COPY_ATTRIBUTES . '<br>' . tep_draw_radio_field('copy_attributes', 'copy_attributes_yes', true) . ' ' . TEXT_COPY_ATTRIBUTES_YES . '<br>' . tep_draw_radio_field('copy_attributes', 'copy_attributes_no') . ' ' . TEXT_COPY_ATTRIBUTES_NO);
          $contents[] = array('align' => 'center', 'text' => '<br>' . ATTRIBUTES_NAMES_HELPER . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '10'));
          $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
        }
//  WebMakers.com Added: Attributes Copy

        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_copy.gif', IMAGE_COPY) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;

// BOF: Attributes copy to existing product:
// WebMakers.com Added: Copy Attributes Existing Product to another Existing Product
      case 'copy_product_attributes':
        $copy_attributes_delete_first='1';
        $copy_attributes_duplicates_skipped='1';
        $copy_attributes_duplicates_overwrite='0';

        if (DOWNLOAD_ENABLED == 'true') {
          $copy_attributes_include_downloads='1';
          $copy_attributes_include_filename='1';
        } else {
          $copy_attributes_include_downloads='0';
          $copy_attributes_include_filename='0';
        }

        $heading[] = array('text' => '<b>' . TEXT_COPY_ATTRIBUTES_TO_ANOTHER_PRODUCT . '</b>');
        $contents = array('form' => tep_draw_form('products', FILENAME_CATEGORIES, 'action=create_copy_product_attributes&cPath=' . $cPath . '&pID=' . $pInfo->products_id) . tep_draw_hidden_field('products_id', $pInfo->products_id) . tep_draw_hidden_field('products_name', $pInfo->products_name));
        $contents[] = array('text' => '<br>' . TEXT_COPY_ATTRIBUTES_FROM . $pInfo->products_id . '<br><b>' . $pInfo->products_name . '</b>');
        $contents[] = array('text' => TEXT_COPY_ATTRIBUTES_TO . '&nbsp;' . tep_draw_input_field('copy_to_products_id', $copy_to_products_id, 'size="3"'));
        $contents[] = array('text' => '<br>' . TEXT_DELETE_ATTRIBUTES_AND_DOWNLOADS . '&nbsp;' . tep_draw_checkbox_field('copy_attributes_delete_first',$copy_attributes_delete_first, 'size="2"'));
        $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
        $contents[] = array('text' => '<br>' . TEXT_OTHERWISE );
        $contents[] = array('text' =>  TEXT_DUPLICATE_ATTRIBUTES_SKIPPED . '&nbsp;' . tep_draw_checkbox_field('copy_attributes_duplicates_skipped',$copy_attributes_duplicates_skipped, 'size="2"'));
        $contents[] = array('text' => '&nbsp;&nbsp;&nbsp;' . TEXT_DUPLICATE_ATTRIBUTES_OVERWRITTEN . '&nbsp;' . tep_draw_checkbox_field('copy_attributes_duplicates_overwrite',$copy_attributes_duplicates_overwrite, 'size="2"'));
        if (DOWNLOAD_ENABLED == 'true') {
          $contents[] = array('text' => '<br>' . TEXT_COPY_ATTRIBUTES_WITH_DOWNLOADS . '&nbsp;' . tep_draw_checkbox_field('copy_attributes_include_downloads',$copy_attributes_include_downloads, 'size="2"'));
          // Not used at this time - download name copies if download attribute is copied
          // $contents[] = array('text' => '&nbsp;&nbsp;&nbsp;Include Download Filenames&nbsp;' . tep_draw_checkbox_field('copy_attributes_include_filename',$copy_attributes_include_filename, 'size="2"'));
        }
        $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
        $contents[] = array('align' => 'center', 'text' => '<br>' . PRODUCT_NAMES_HELPER);
        if ($pID) {
          $contents[] = array('align' => 'center', 'text' => '<br>' . ATTRIBUTES_NAMES_HELPER);
        } else {
          $contents[] = array('align' => 'center', 'text' => '<br>' . TEXT_SELECT_PRODUCT_DISPLAY );
        }
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_copy.gif', TEXT_COPY_ATTRIBUTES) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
// WebMakers.com Added: Copy Attributes Existing Product to All Products in Category
      case 'copy_product_attributes_categories':
        $copy_attributes_delete_first='1';
        $copy_attributes_duplicates_skipped='1';
        $copy_attributes_duplicates_overwrite='0';

        if (DOWNLOAD_ENABLED == 'true') {
          $copy_attributes_include_downloads='1';
          $copy_attributes_include_filename='1';
        } else {
          $copy_attributes_include_downloads='0';
          $copy_attributes_include_filename='0';
        }
      $heading[] = array('text' => '<b>' . TEXT_COPY_ATTRIBUTES_TO_CATEGORY . '</b>');
        $contents = array('form' => tep_draw_form('products', FILENAME_CATEGORIES, 'action=create_copy_product_attributes_categories&cPath=' . $cPath . '&cID=' . $cID . '&make_copy_from_products_id=' . $copy_from_products_id));
        $contents[] = array('text' => TEXT_COPY_ATTRIBUTES_FROM_PRODUCT_ID . '&nbsp;' . tep_draw_input_field('make_copy_from_products_id', $make_copy_from_products_id, 'size="3"'));
        $contents[] = array('text' => '<br>' . TEXT_COPY_ATTRIBUTES_IN_CATEGORY_ID . '&nbsp;' . $cID . '<br>' . TEXT_CATEGORY_NAME . '<b>' . tep_get_category_name($cID, $languages_id) . '</b>');
        $contents[] = array('text' => '<br>' . TEXT_DELETE_ATTRIBUTES_AND_DOWNLOADS . '&nbsp;' . tep_draw_checkbox_field('copy_attributes_delete_first',$copy_attributes_delete_first, 'size="2"'));
        $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
        $contents[] = array('text' => '<br>' . TEXT_OTHERWISE);
        $contents[] = array('text' => TEXT_DUPLICATE_ATTRIBUTES_SKIPPED . '&nbsp;' . tep_draw_checkbox_field('copy_attributes_duplicates_skipped',$copy_attributes_duplicates_skipped, 'size="2"'));
        $contents[] = array('text' => '&nbsp;&nbsp;&nbsp;' . TEXT_DUPLICATE_ATTRIBUTES_OVERWRITTEN . '&nbsp;' . tep_draw_checkbox_field('copy_attributes_duplicates_overwrite',$copy_attributes_duplicates_overwrite, 'size="2"'));
        if (DOWNLOAD_ENABLED == 'true') {
          $contents[] = array('text' => '<br>' . TEXT_COPY_ATTRIBUTES_WITH_DOWNLOADS . '&nbsp;' . tep_draw_checkbox_field('copy_attributes_include_downloads',$copy_attributes_include_downloads, 'size="2"'));
         // Not used at this time - download name copies if download attribute is copied
          // $contents[] = array('text' => '&nbsp;&nbsp;&nbsp;Include Download Filenames&nbsp;' . tep_draw_checkbox_field('copy_attributes_include_filename',$copy_attributes_include_filename, 'size="2"'));
        }
        $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
        $contents[] = array('align' => 'center', 'text' => '<br>' . PRODUCT_NAMES_HELPER);
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_copy.gif', TEXT_COPY_ATTRIBUTES) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cID) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
// EOF: Attributes copy
 
//START Additional Images
      case 'new_images': 
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_IMAGES . '</b>');   

        $contents = array('form' => tep_draw_form('new_images', FILENAME_CATEGORIES, 'action=add_images&cPath=' . $cPath . '&pID=' . $HTTP_GET_VARS['pID'], 'post', 'enctype="multipart/form-data"')); 
        $contents[] = array('text' => TEXT_NEW_IMAGES_INTRO);      
        $contents[] = array('text' => '<br>' . TEXT_PRODUCTS_IMAGES_DESC . '<br>' . tep_draw_input_field('images_description'));
        $contents[] = array('text' => '<br>' . TEXT_PRODUCTS_IMAGES_NEWPOP . $newpop_resol . '<br>' . tep_draw_input_field('popup_images', '', ' id="file1" size="20"') . '<br><button type="button" onclick="BrowseServer(\'file1\');"/>wybierz obrazek</button>');
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $HTTP_GET_VARS['pID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;

      case 'delete_images':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_IMAGES . '</b>');
        $contents = array('form' => tep_draw_form('delete_images', FILENAME_CATEGORIES, 'action=del_images&cPath=' . $cPath . '&pID=' . $HTTP_GET_VARS['pID'])); 
        $contents[] = array('text' => TEXT_DEL_IMAGES_INTRO);

        $images_product = tep_db_query("SELECT additional_images_id, images_description FROM " . TABLE_ADDITIONAL_IMAGES . " where products_id = '" . $HTTP_GET_VARS['pID'] . "'"); 
        if (!tep_db_num_rows($images_product)) {
          $contents[] = array('align' => 'center', 'text' => '<br><font color="red">Brak dodatkowych obrazkow!</font>');   
          $contents[] = array('align' => 'center', 'text' => '<br><a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $HTTP_GET_VARS['pID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');  
        } else {
					while ($new_images = tep_db_fetch_array($images_product)) {
						$contents[] = array('text' => '&nbsp;' . tep_draw_checkbox_field('additional_images_id[]', $new_images['additional_images_id'], true) . $new_images['images_description']);
          }
					$contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $HTTP_GET_VARS['pID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');  
        }
				break;
      default:
        if ($rows > 0) {
          if (isset($cInfo) && is_object($cInfo)) { // category info box contents
            $category_path_string = '';
            $category_path = tep_generate_category_path($cInfo->categories_id);
            for ($i=(sizeof($category_path[0])-1); $i>0; $i--) {
              $category_path_string .= $category_path[0][$i]['id'] . '_';
            }
            $category_path_string = substr($category_path_string, 0, -1);

						$heading[] = array('text' => '<b>' . $cInfo->categories_name . '</b>');

            $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $category_path_string . '&cID=' . $cInfo->categories_id . '&action=edit_category') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $category_path_string . '&cID=' . $cInfo->categories_id . '&action=delete_category') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $category_path_string . '&cID=' . $cInfo->categories_id . '&action=move_category') . '">' . tep_image_button('button_move.gif', IMAGE_MOVE) . '</a>');
            $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . tep_date_short($cInfo->date_added));
            if (tep_not_null($cInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . tep_date_short($cInfo->last_modified));
            $contents[] = array('text' => '<br>' . tep_info_image($cInfo->categories_image, $cInfo->categories_name, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT) . '<br>' . $cInfo->categories_image);
            $contents[] = array('text' => '<br>' . TEXT_SUBCATEGORIES . ' ' . $cInfo->childs_count . '<br>' . TEXT_PRODUCTS . ' ' . $cInfo->products_count);
//BOF: Attributes copy to all existing products
            if ($cInfo->childs_count==0 and $cInfo->products_count >= 1) {
// WebMakers.com Added: Copy Attributes Existing Product to All Existing Products in Category
              $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
              if ($cID) {
                $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cID . '&action=copy_product_attributes_categories') . '">' . TEXT_COPY_ATTRIBUTES_TO . '<br>' . TEXT_ALL_PRODUCTS_CATEGORY . tep_get_category_name($cID, $languages_id) . '<br>' . tep_image_button('button_copy_to.gif', TEXT_COPY_ATTRIBUTES) . '</a>');
              } else {
                $contents[] = array('align' => 'center', 'text' => '<br>' . TEXT_SELECT_CATEGORY_COPY_ATTRIBUTES );
              }
            }
//EOF: Attributes copy to all existing products
          } elseif (isset($pInfo) && is_object($pInfo)) { // product info box contents
            $heading[] = array('text' => '<b>' . tep_get_products_name($pInfo->products_id, $languages_id) . '</b>');
//++++ QT Pro: Begin Changed code
            $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=new_product') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=delete_product') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=move_product') . '">' . tep_image_button('button_move.gif', IMAGE_MOVE) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=copy_to') . '">' . tep_image_button('button_copy_to.gif', IMAGE_COPY_TO) . '</a><a href="' . tep_href_link("stock.php", 'product_id=' . $pInfo->products_id) . '">' . tep_image_button('button_stock.gif', "Stock") . '</a> <a href="' . tep_href_link(FILENAME_RELATED_PRODUCTS, 'products_id_view=' . $pInfo->products_id) . '" target="_new">' . tep_image_button('button_related_products.gif', IMAGE_RELATED_PRODUCTS) . '</a>');
//++++ QT Pro: End Changed Code

//            $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=new_product') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=delete_product') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=move_product') . '">' . tep_image_button('button_move.gif', IMAGE_MOVE) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=copy_to') . '">' . tep_image_button('button_copy_to.gif', IMAGE_COPY_TO) . '</a>');
            $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . tep_date_short($pInfo->products_date_added));
            if (tep_not_null($pInfo->products_last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . tep_date_short($pInfo->products_last_modified));
            if (date('Y-m-d') < $pInfo->products_date_available) $contents[] = array('text' => TEXT_DATE_AVAILABLE . ' ' . tep_date_short($pInfo->products_date_available));
            $contents[] = array('text' => '<br>' . tep_info_image($pInfo->products_image, $pInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '<br>' . $pInfo->products_image);
//            $contents[] = array('text' => '<br>' . TEXT_PRODUCTS_PRICE_INFO . ' ' . $currencies->format($pInfo->products_price) . '<br>' . TEXT_PRODUCTS_QUANTITY_INFO . ' ' . $pInfo->products_quantity);


            $contents[] = array('text' => '<br>' . TEXT_PRODUCTS_PRICE_NINFO . ' ' . $currencies->format($pInfo->products_price) );
            $get_tax_qry = tep_db_query("SELECT tr.tax_rate FROM " . TABLE_PRODUCTS . " p INNER JOIN " . TABLE_TAX_RATES . " tr ON (p.products_tax_class_id = tr.tax_class_id) WHERE (p.products_id = " . $pInfo->products_id . ")");
            $get_tax_res = tep_db_fetch_array($get_tax_qry);
            $products_price_with_tax = tep_add_tax($pInfo->products_price, $get_tax_res['tax_rate']);
            $get_special_price_qry = tep_db_query("SELECT s.specials_new_products_price, s.`status` FROM ".TABLE_SPECIALS." s WHERE (s.products_id = '".$pInfo->products_id."')");
            $get_special_price_res = tep_db_fetch_array($get_special_price_qry);
            if($get_special_price_res){
             $get_special_price_with_tax = tep_add_tax($get_special_price_res['specials_new_products_price'], $get_tax_res['tax_rate']);
            }
            $contents[] = array('text' => '<br>' . TEXT_PRODUCTS_PRICE_INFO . ' ' . $currencies->format($products_price_with_tax) . '<br>');
            
            if($get_special_price_with_tax >= '0' && $get_special_price_res['status'] =1) {
              $contents[] = array('text' => '<br>' . TEXT_PRODUCTS_PRICE_SINFO . ' ' . $currencies->format($get_special_price_with_tax) );
            }
              $contents[] = array('text' => '<br>' . TEXT_PRODUCTS_QUANTITY_INFO . ' ' . $pInfo->products_quantity . '<br><br>');

            $contents[] = array('text' => '<br>' . TEXT_PRODUCTS_AVERAGE_RATING . ' ' . number_format($pInfo->average_rating, 2) . '%');
              $contents[] = array('text' => '<br><b>' . TEXT_INFO_HEADING_NEW_IMAGES . '</b><hr>');
              $images_product = tep_db_query("SELECT additional_images_id, popup_images, images_description FROM " . TABLE_ADDITIONAL_IMAGES . " where products_id = '" . $pInfo->products_id . "'");
            if (!tep_db_num_rows($images_product)) {
              $contents[] = array('align' => 'center', 'text' => '<font color="red">Brak dodatkowych obrazkow!</font><hr>');
            } else {
              while ($new_images = tep_db_fetch_array($images_product)) {
               $contents[] = array('text' => '&nbsp;' . tep_image(DIR_WS_CATALOG_IMAGES  . $new_images['popup_images'], $new_images['images_description'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="absmiddle"') . '<br><br>&nbsp;<hr>');
              }
            }
            $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=new_images') . '">' . tep_image_button('button_images_add.gif', IMAGE_ADDITIONAL_NEW) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=delete_images') . '">' . tep_image_button('button_images_del.gif', IMAGE_ADDITIONAL_DEL) . '</a>');
// BOF: Attributes copy existing to existing
// WebMakers.com Added: Copy Attributes Existing Product to another Existing Product
            $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
            $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=copy_product_attributes') . '">' . TEXT_PRODUCTS_ATTRIBUTES_COPIER . '<br>' . tep_image_button('button_copy_to.gif', TEXT_COPY_ATTRIBUTES) . '</a>');
            if ($pID) {
              $contents[] = array('align' => 'center', 'text' => '<br>' . ATTRIBUTES_NAMES_HELPER . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '10'));
            } else {
              $contents[] = array('align' => 'center', 'text' => '<br>' . TEXT_SELECT_PRODUCT_DISPLAY_ATTRIBUTES );
            }
//EOF: Attributes copy existing to existing
          }
        } else { // create category/product info
          $heading[] = array('text' => '<b>' . EMPTY_CATEGORY . '</b>');

          $contents[] = array('text' => TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS);
        }
        break;
//END Additional Images 
    
    }

    if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
      echo '            <td width="25%" valign="top">' . "\n";

      $box = new box;
      echo $box->infoBox($heading, $contents);

      echo '            </td>' . "\n";
    }
?>
          </tr>
        </table></td>
      </tr>
    </table>
<?php
  }
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
