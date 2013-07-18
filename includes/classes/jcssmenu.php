<?php
/*
 $Id: jcssmenu.php 1 2007-12-20 23:52:06Z  $

 devosc, developing open source code
 http://www.devosc.com

 Copyright (c) 2005 devosc

 Portions Copyright (c) 2004 osCommerce

 Released under the GNU General Public License

 mod eSklep-Os http://www.esklep-os.com
*/
  if(class_exists('cache') === false) {

    include('cache.class.php');

  }

  class osC_JCSSMenu
  {
    var $root_category_id                    = 0,
        $max_level                           = 0,
        $data,
        $parent_start_string                 = '',
        $parent_end_string                   = '',
        $parent_group_start_string           = '<ul>',
        $parent_group_end_string             = '</ul>',
        $child_start_string                  = '<li>',
        $child_end_string                    = '</li>',
        $breadcrumb_separator                = '_',
        $breadcrumb_usage                    = true,
        $show_category_product_count,
        $category_product_count_start_string = '&nbsp;(',
        $category_product_count_end_string   = ')';

    function osC_JCSSMenu()
    {
      global $languages_id;

      $this->show_category_product_count = (SHOW_COUNTS == 'true') ? true : false;

      $cache = new cache($languages_id,false);

      $is_cached = false;

      $is_expired = false;

      if (USE_CACHE == 'true')

        $cache->is_cached('osC_JCSSMenu',$is_cached,$is_expired);

      if (USE_CACHE == 'false' || (USE_CACHE == 'true' && $is_cached == false || $is_expired == true)) {

         $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by c.parent_id, c.sort_order, cd.categories_name");

         $this->data = array();

         while($categories = tep_db_fetch_array($categories_query))

           $this->data[$categories['parent_id']][$categories['categories_id']] = array('name' => $categories['categories_name'], 'count' => 0);

        if ($this->show_category_product_count === true)

            $this->calculateCategoryProductCount();

        if (USE_CACHE == 'true')

          $cache->save_cache('osC_JCSSMenu', $this->data, 'ARRAY', 1, 0, '30/d');

      } else {

        $this->data = $cache->get_cache('osC_JCSSMenu', 'ARRAY');

      }
    }

    function buildBranch($parent_id, $level = 0)
    {
      global $request_type;

      $result = $this->parent_group_start_string;

      if (isset($this->data[$parent_id])) {

        foreach ($this->data[$parent_id] as $category_id => $category) {

          if (isset($this->data[$category_id]) === true)

            $result .= $this->parent_start_string;

          $result .= $this->child_start_string;

          $result .= "<a".((in_array($category_id,$this->cpath_array)) ? ' class="selected" ': ' ')."href=\"".tep_href_link(FILENAME_DEFAULT, 'cPath=' . (($this->breadcrumb_usage == true) ? $this->buildBreadcrumb($category_id) : $category_id),$request_type)."\">".
                     "<span class=\"icon\">";

          $_count = ($this->show_category_product_count === true && $category['count'] > 0) ? $this->category_product_count_start_string . $category['count'] . $this->category_product_count_end_string : '';

          $_text = "<span class=\"text\">{$category['name']}{$_count}</span>";

          if (isset($this->data[$category_id]) && $level > 0)

            $result .= "<span class=\"submenu\">{$_text}</span>";

          else

            $result .= "<span>{$_text}</span>";

          $result .= "</span></a>";

          if (isset($this->data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level+1)))

            $result .= $this->buildBranch($category_id, $level+1);

          $result .= $this->child_end_string;

          if (isset($this->data[$category_id]) === true)

            $result .= $this->parent_end_string;

        }

      }

      $result .= $this->parent_group_end_string;

      return $result;
    }

    function jcssMenu($cPath)
    {
      $jcssMenu = new osC_JCSSMenu();

      $jcssMenu->setCategoryPath($cPath);

      return "\n".$jcssMenu->buildBranch($jcssMenu->root_category_id)."\n";
    }

    function display($cPath)
    {
      global $request_type;

      return "\n".
             '<script type="text/javascript" src="includes/javascript/jcssmenu/jcssmenu.js"></script>'. "\n" .
             '<style type="text/css"> @import url(\'includes/javascript/jcssmenu/jcssmenu.css\');</style>'. "\n" .
             '<div id="jcssMenu" class="jcssMenu">'. osC_JCSSMenu::jcssMenu($cPath).'</div>'. "\n" .
             '<script type="text/javascript" defer="defer">'. "\n" .
             '<!--' . "\n" .
             '  jcssMenu(\'jcssMenu\');' . "\n" .
             '//-->' . "\n" .
             '</script>'."\n";
    }

    function setCategoryPath($cPath)
    {
      $this->follow_cpath = true;
      $this->cpath_array = explode($this->breadcrumb_separator,$cPath);
    }

    function buildBreadcrumb($category_id, $level = 0)
    {
      $breadcrumb = '';

      foreach($this->data as $parent => $categories)

        foreach($categories as $id => $info)

          if ($id == $category_id) {

            if ($level < 1)

              $breadcrumb = $id;

            else

              $breadcrumb = $id . $this->breadcrumb_separator . $breadcrumb;

            if ($parent != $this->root_category_id)

              $breadcrumb = $this->buildBreadcrumb($parent, $level+1) . $breadcrumb;

          }

      return $breadcrumb;
    }

    function calculateCategoryProductCount()
    {
      foreach ($this->data as $parent => $categories)

        foreach ($categories as $id => $info) {

          $this->data[$parent][$id]['count'] = $this->countCategoryProducts($id);

          $parent_category = $parent;

          while ($parent_category != $this->root_category_id)

            foreach ($this->data as $parent_parent => $parent_categories)

              foreach ($parent_categories as $parent_category_id => $parent_category_info)

                if ($parent_category_id == $parent_category) {

                  $this->data[$parent_parent][$parent_category_id]['count'] += $this->data[$parent][$id]['count'];

                  $parent_category = $parent_parent;

                  break 2;

                }

          }
    }

    function countCategoryProducts($category_id)
    {
      $_Qcategories = tep_db_query('select count(*) as total from ' . TABLE_PRODUCTS . ' p left join ' . TABLE_PRODUCTS_TO_CATEGORIES . ' p2c using (products_id) where p2c.categories_id = ' . (int)$category_id . ' and p.products_status = 1');

      $_count = 0;

      if (tep_db_num_rows($_Qcategories)) {

        $_results = tep_db_fetch_array($_Qcategories);

        $_count = $_results['total'];

      }

      tep_db_free_result($_Qcategories);

      return $_count;
    }
  }//end class
?>