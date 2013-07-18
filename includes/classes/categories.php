<?php
/*
 $Id: categories.php 1 2007-12-20 23:52:06Z  $

 osCommerce, Open Source E-Commerce Solutions
 http://www.oscommerce.com

 Copyright (c) 2004 osCommerce

 Released under the GNU General Public License

 mod eSklep-Os http://www.esklep-os.com
*/

define('DIR_WS_EXT', DIR_WS_CATALOG . 'ext/');

if(!class_exists('cache')) {
  include('cache.class.php');
}

 class osC_Categories {

   var $root_category_id    = 0,
       $max_level           = 0,
       $data,
       $parent_start_string = "\n\t[",
       $parent_end_string   = "\t],\n",
       $child_start_string  = "\n\t\t[",
       $child_end_string    = "],\n";

   function osC_Categories($load_from_database = true) {
     global $languages_id;

    $cache = new cache(false);
    if ( !$cache->is_cached('osC_Categories',$is_cached, $is_expired) ){
         $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by c.parent_id, c.sort_order, cd.categories_name");
         $this->data = array();
         while ($categories = tep_db_fetch_array($categories_query)) {
           $this->data[$categories['parent_id']][$categories['categories_id']] = array('name' => $categories['categories_name'], 'count' => 0);
         }
      $cache->save_cache('osC_Categories', serialize($this->data), 1, 0, '30/d');
    } else {
      $this->data = $cache->get_cache('osC_Categories', 'UNSERIALIZE');
    }

   }

   function buildBranch($parent_id, $level = 0) {
     global $request_type;
     if (isset($this->data[$parent_id])) {

       foreach ($this->data[$parent_id] as $category_id => $category) {

         $category_link = $category_id;

         if (isset($this->data[$category_id])) {
           $result .= $this->parent_start_string;
         } else {
           $result .= $this->child_start_string;
         }

         $icon = "null";

         $title = "'" . addslashes($category['name']) . "'";

         $url = "'" . tep_href_link(FILENAME_DEFAULT, 'cPath=' . $category_link,$request_type) . "'";

         $target = "''";

         $description = "''";

         $result .= "$icon, $title, $url, $target, $description";

         if (isset($this->data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level+1))) {
           $result .= ",".$this->buildBranch($category_id, $level+1);
         }

         if (isset($this->data[$category_id])) {
           $result .= $this->parent_end_string;
         } else {
           $result .= $this->child_end_string;
         }

       }

     }

     return $result;
   }

   function jsCookMenuTree() {

    $categories = $this->buildBranch($this->root_category_id);

    return "[\n" .
           "    $categories\n".
           "];\n";
  }

   function buildTree() {
    return '//<![CDATA['."\n". 'var categories =' . "\n" . $this->jsCookMenuTree() . '//]]>'."\n";
   }

   function displayMenu() {
    global $request_type;

    $str = '<script language="javascript" src="' . (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_EXT . 'jscookmenu/JSCookMenu.js"></script>'.
           '<link rel="stylesheet" href="' . (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_EXT . 'jscookmenu/ThemePanel/theme.css" type="text/css">'.
           '<script language="javascript" src="' . (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_EXT . 'jscookmenu/ThemePanel/theme.js"></script>'.
            '<script language="javascript" src="' . tep_href_link(FILENAME_DEFAULT,'page=javascript_categories',$request_type,false) . '"></script>'.
           '<div id="categoriesID"></div>'.
           '<script language="javascript">'.
           '  cmDraw("categoriesID", categories, "vbr", cmThemePanel, "ThemePanel")'.
           '</script>';


    return "\n" . $str . "\n" . '<noscript>'."\n". osC_Categories::noScriptTree() . "\n" . '</noscript>' . "\n";
   }

  function noScriptTree() {
    global $languages_id, $tree, $categories_string, $cPath_array, $cPath;

  $categories_string = '';
  $tree = array();

  $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
  while ($categories = tep_db_fetch_array($categories_query))  {
    $tree[$categories['categories_id']] = array('name' => $categories['categories_name'],
                                                'parent' => $categories['parent_id'],
                                                'level' => 0,
                                                'path' => $categories['categories_id'],
                                                'next_id' => false);

    if (isset($parent_id)) {
      $tree[$parent_id]['next_id'] = $categories['categories_id'];
    }

    $parent_id = $categories['categories_id'];

    if (!isset($first_element)) {
      $first_element = $categories['categories_id'];
    }
  }

  //------------------------
  if (tep_not_null($cPath)) {
    $new_path = '';
    reset($cPath_array);
    while (list($key, $value) = each($cPath_array)) {
      unset($parent_id);
      unset($first_id);
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$value . "' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
      if (tep_db_num_rows($categories_query)) {
        $new_path .= $value;
        while ($row = tep_db_fetch_array($categories_query)) {
          $tree[$row['categories_id']] = array('name' => $row['categories_name'],
                                               'parent' => $row['parent_id'],
                                               'level' => $key+1,
                                               'path' => $new_path . '_' . $row['categories_id'],
                                               'next_id' => false);

          if (isset($parent_id)) {
            $tree[$parent_id]['next_id'] = $row['categories_id'];
          }

          $parent_id = $row['categories_id'];

          if (!isset($first_id)) {
            $first_id = $row['categories_id'];
          }

          $last_id = $row['categories_id'];
        }
        $tree[$last_id]['next_id'] = $tree[$value]['next_id'];
        $tree[$value]['next_id'] = $first_id;
        $new_path .= '_';
      } else {
        break;
      }
    }
  }
    osC_Categories::tep_show_category($first_element);
    return $categories_string;
  }
 function tep_show_category($counter) {
    global $tree, $categories_string, $cPath_array;

    for ($i=0; $i<$tree[$counter]['level']; $i++) {
      $categories_string .= "&nbsp;&nbsp;";
    }

    $categories_string .= '<a href="';

    if ($tree[$counter]['parent'] == 0) {
      $cPath_new = 'cPath=' . $counter;
    } else {
      $cPath_new = 'cPath=' . $tree[$counter]['path'];
    }

    $categories_string .= tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">';

    if (isset($cPath_array) && in_array($counter, $cPath_array)) {
      $categories_string .= '<b>';
    }

// display category name
    $categories_string .= $tree[$counter]['name'];

    if (isset($cPath_array) && in_array($counter, $cPath_array)) {
      $categories_string .= '</b>';
    }

    if (tep_has_category_subcategories($counter)) {
      $categories_string .= '-&gt;';
    }

    $categories_string .= '</a>';

    if (SHOW_COUNTS == 'true') {
      $products_in_category = tep_count_products_in_category($counter);
      if ($products_in_category > 0) {
        $categories_string .= '&nbsp;(' . $products_in_category . ')';
      }
    }

    $categories_string .= '<br>';

    if ($tree[$counter]['next_id'] != false) {
      osC_Categories::tep_show_category($tree[$counter]['next_id']);
    }
  }

 }
?>