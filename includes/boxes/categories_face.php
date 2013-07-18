<?php
  echo "<SCRIPT LANGUAGE=\"JavaScript\" SRC=\"includes/javascript/facemenu/facemenu.js\"></SCRIPT>\n";
  echo "<LINK REL=\"stylesheet\" HREF=\"includes/javascript/facemenu/facemenu.css\" TYPE=\"text/css\">\n";
  
  $boxHeading = BOX_HEADING_CATEGORIES;
  $corner_left = 'rounded';
  $corner_right = 'square';
  $box_base_name = 'categories'; // for easy unique box template setup (added BTSv1.2)

  $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)
 
	function tep_show_category_jk($counter) {
	
    global $tree, $categories_string, $id, $cPath_array, $cat_name, $parent_child;
	
	if (isset($cPath_array) && in_array($counter, $cPath_array)) {
      $categories_string .= '';
    }
	
	$categories_string .= '<li><a href="';	
	
    if ($tree[$counter]['parent'] == 0) {
     $cPath_new = 'cPath=' . $counter;
    } else {
     $cPath_new = 'cPath=' . $tree[$counter]['path'];
    }

    $categories_string .= tep_href_link(FILENAME_DEFAULT, $cPath_new);
    $categories_string .= '">';

    // display category name
	if ($tree[$counter]['parent'] == 0) {
		$categories_string .= $tree[$counter]['name'];
	   } else {
	    $categories_string .= '&raquo; ' . $tree[$counter]['name'];
	}

	$categories_string .= '</a>';
	
    if (SHOW_COUNTS == 'true') {
      $products_in_category = tep_count_products_in_category($counter);
      if ($products_in_category > 0) {
        $categories_string .= '<span class="smalltext">&nbsp;(' . $products_in_category . ')</span>';
      }
    }
		
	$categories_string .= '</li>';	
	
	if (isset($cPath_array) && in_array($counter, $cPath_array)) {
      $categories_string .= '';
    }
	
	  //changed by thomas ruess to implement table structure
	  if ($tree[$counter]['next_id'] != false) {
      tep_show_category_jk($tree[$counter]['next_id']);
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
    // BOF tep_show_category_jk optimization
	  $list_of_categories_ids[] = (int)$categories['categories_id'];
    // EOF tep_show_category_jk optimization
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
// BOF tep_show_category_jk optimization
 		      $list_of_categories_ids[] = (int)$row['categories_id'];
// EOF tep_show_category_jk optimization
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
// BOF tep_show_category_jk optimization
  // one extra query to determine whether these categories have subcategories
  // there are no more levels than three, and we are at level 2 here, so no need to go deeper
  if (sizeof($list_of_categories_ids) > 0 ) {
  $select_list_of_cat_ids = implode(",", $list_of_categories_ids);
  $parent_child_query = tep_db_query("select categories_id, parent_id from " . TABLE_CATEGORIES . " FORCE INDEX(parent_id) where parent_id in (" . $select_list_of_cat_ids . ") ");
  while ($_parent_child = tep_db_fetch_array($parent_child_query)) {
	 $parent_child[] = $_parent_child;
  }
 }
// EOF tep_show_category_jk optimization
  tep_show_category_jk($first_element);

  $boxContent = '';
  $boxContent .= '<ul id="fancyMenu">' . $categories_string . '</ul>';

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
