<?php
/*
  $Id: categories.php,v 1.23 2002/11/12 14:09:30 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License

 mod eSklep-Os http://www.esklep-os.com
*/
  $boxHeading = BOX_HEADING_CATEGORIES;
  $corner_left = 'rounded';
  $corner_right = 'square';
  $box_base_name = 'categories'; // for easy unique box template setup (added BTSv1.2)

  $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)
 
	function tep_show_category($counter) {
	
    global $tree, $categories_string, $id, $cPath_array, $cat_name, $parent_child;

    if ($tree[$counter]['parent'] == 0) {
      if (file_exists(DIR_WS_TEMPLATES . 'images/infobox/menu.gif')) {
		    $categories_string .= '<tr><td align="center">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="CategoryBox">';
	    } else {
		    $categories_string .= '<tr><td class="CategoryBox">';
	    }
     $cPath_new = 'cPath=' . $counter;
    } else {
      if (file_exists(DIR_WS_TEMPLATES . 'images/infobox/menu.gif')) {
		    $categories_string .= '<tr><td align="right" class="main"></td><td class="CategoryBox"><span class="boxLink">&raquo;&nbsp;</span>';
	    } else {
		    $categories_string .= '<tr><td class="CategoryBox">';
	    }
     $cPath_new = 'cPath=' . $tree[$counter]['path'];
    }

    $categories_string .= '<a class="CateginfoBoxLink" href="';

    $categories_string .= tep_href_link(FILENAME_DEFAULT, $cPath_new);
    $categories_string .= '">';

    if (isset($cPath_array) && in_array($counter, $cPath_array)) {
      $categories_string .= '<b>';
    }

    // display category name
    $categories_string .= $tree[$counter]['name'];

    if (isset($cPath_array) && in_array($counter, $cPath_array)) {
      $categories_string .= '</b>';
    }

    $categories_string .= '</a>';

    if (SHOW_COUNTS == 'true') {
      $products_in_category = tep_count_products_in_category($counter);
      if ($products_in_category > 0) {
        $categories_string .= '<span class="smalltext">&nbsp;(' . $products_in_category . ')</span>';
      }
    }
    
	  //changed by thomas ruess to implement table structure
    //$categories_string .= '<br>';
	  if ($tree[$counter]['next_id'] != false) {
		  $categories_string .= '</td></tr>';
		    if (file_exists(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif')) {
			    $categories_string .= '<TR><TD colspan="2" align="center">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</TD></TR>';
		    }
      tep_show_category($tree[$counter]['next_id']);
  	}

  }
  ?>
  <!-- categories //-->
  <?php
  if (file_exists(DIR_WS_TEMPLATES . '/images/buttons/' .$language . 'categoryheading.gif')) {
  } else {
   //   new CategoriesBoxHeading($info_box_contents, true, true);
  }

  $categories_string = '';
  $tree = array();

//  $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
  $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' and c.categories_status = '1' order by sort_order, cd.categories_name");

  while ($categories = tep_db_fetch_array($categories_query))  {
    // BOF tep_show_category optimization
	  $list_of_categories_ids[] = (int)$categories['categories_id'];
    // EOF tep_show_category optimization
    $tree[$categories['categories_id']] = array(
                                        'name' => $categories['categories_name'],
                                        'parent' => $categories['parent_id'],
                                        'level' => 0,
                                        'path' => $categories['categories_id'],
                                        'next_id' => false
                                       );

    if (isset($prev_id)) {
      $tree[$prev_id]['next_id'] = $categories['categories_id'];
    }

    $prev_id = $categories['categories_id'];

    if (!isset($first_element)) {
      $first_element = $categories['categories_id'];
    }
  }

  //------------------------
  if (tep_not_null($cPath)) {
    $new_path = '';
    $id = split('_', $cPath);
    reset($cPath_array);
    while (list($key, $value) = each($cPath_array)) {
      unset($prev_id);
      unset($first_id);
//      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$value . "' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$value . "' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' and c.categories_status = '1' order by sort_order, cd.categories_name");
      $category_check = tep_db_num_rows($categories_query);
      if ($category_check > 0) {
        $new_path .= $value;
        while ($row = tep_db_fetch_array($categories_query)) {
// BOF tep_show_category optimization
 		      $list_of_categories_ids[] = (int)$row['categories_id'];
// EOF tep_show_category optimization
          $tree[$row['categories_id']] = array(
                                              'name' => $row['categories_name'],
                                              'parent' => $row['parent_id'],
                                              'level' => $key+1,
                                              'path' => $new_path . '_' . $row['categories_id'],
                                              'next_id' => false
                                             );

          if (isset($prev_id)) {
            $tree[$prev_id]['next_id'] = $row['categories_id'];
          }

          $prev_id = $row['categories_id'];

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
// BOF tep_show_category optimization
  // one extra query to determine whether these categories have subcategories
  // there are no more levels than three, and we are at level 2 here, so no need to go deeper
  if (sizeof($list_of_categories_ids) > 0 ) {
  $select_list_of_cat_ids = implode(",", $list_of_categories_ids);
  $parent_child_query = tep_db_query("select categories_id, parent_id from " . TABLE_CATEGORIES . " FORCE INDEX(parent_id) where parent_id in (" . $select_list_of_cat_ids . ") ");
  while ($_parent_child = tep_db_fetch_array($parent_child_query)) {
	 $parent_child[] = $_parent_child;
  }
 }
// EOF tep_show_category optimization
  tep_show_category($first_element);

  $boxContent = '';
  $boxContent .= $categories_string;

// bof BTSv1.2
  if(file_exists(DIR_WS_BOX_TEMPLATES . $box_base_name . '.tpl.php')) {
  // if exists, load unique box template for this box from templates/boxes/
      require(DIR_WS_BOX_TEMPLATES . $box_base_name . '.tpl.php');
  }
  else {
  // load default box template: templates/boxes/box.tpl.php
      require(DIR_WS_BOX_TEMPLATES . TEMPLATENAME_BOX);
  }
// eof BTSv1.2

?>
 <!-- categories_eof //-->