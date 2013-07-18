<?php
/*
  $Id: categories_subtab.php 1 2007-12-20 23:52:06Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2004 osCommerce

  Released under the GNU General Public License


* This file displays a row with links to sub-categories of the selected category.
* Use this file together with categories_tab.php. 
*/
$boxHeading = BOX_HEADING_CATEGORIES;
$corner_left = 'rounded';
$corner_right = 'square';
$box_base_name = 'categories'; // for easy unique box template setup (added BTSv1.2)

$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)


function show_subcategories($counter) {
	global $fooa, $subcategories_string, $id, $HTTP_GET_VARS;
	$cPath_new = 'cPath=' . $fooa[$counter]['path'];

    if ($fooa[$counter]['path'] != 0) {
       if (file_exists(DIR_WS_TEMPLATES . 'images/infobox/menu.gif')) {
	    $subcategories_string .= '<tr><td align="center" width="12">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif') . '</td><td class="CategoryBox">';
	   } else {
		$subcategories_string .= '<tr><td class="CategoryBox">';
	   }

	   $subcategories_string .= '<a class="CateginfoBoxLink" href="';
	   $subcategories_string .= tep_href_link(FILENAME_DEFAULT, $cPath_new);
	   $subcategories_string .= '">';

       if (isset($id) && in_array($counter, $id)) {
         $subcategories_string .= '<b>';
       }

	   // display category name
	   $subcategories_string .= $fooa[$counter]['name'];
	
       if (isset($id) && in_array($counter, $id)) {
         $subcategories_string .= '</b>';
       }

	   $subcategories_string .= '</a></td></TR>';
    }
	
	if ($fooa[$counter]['next_id']) {
    if ($fooa[$counter]['path'] != 0) {

//	  $subcategories_string .= '</td></tr>';
	  if (file_exists(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif')) {
	    $subcategories_string .= '<TR><TD colspan="2" align="center">' . tep_image(DIR_WS_TEMPLATES . 'images/infobox/category_line.gif') . '</TD></TR>';
	  }
	}
	  show_subcategories($fooa[$counter]['next_id']);
	}
}
?>

<!-- subcategories //-->
<?php
	if ($cPath) {
		$subcategories_string = '';
		$new_path = '';
		$id = split('_', $cPath);
		reset($id);
		while (list($key, $value) = each($id)) {
			unset($prev_id);
			unset($first_id);
			$subcategories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . $value . "' and c.categories_id = cd.categories_id and cd.language_id='" . $languages_id ."' order by sort_order, cd.categories_name");
			$subcategory_check = tep_db_num_rows($subcategories_query);
			if ($subcategory_check > 0) {
				$new_path .= $value;
				while ($row = tep_db_fetch_array($subcategories_query)) {
					$fooa[$row['categories_id']] = array(
						'name' => $row['categories_name'],
						'parent' => $row['parent_id'],
						'level' => $key+1,
						'path' => $new_path . '_' . $row['categories_id'],
						'next_id' => false
					);
					if (isset($prev_id)) {
						$fooa[$prev_id]['next_id'] = $row['categories_id'];
					}
	
					$prev_id = $row['categories_id'];
					
					if (!isset($first_id)) {
						$first_id = $row['categories_id'];
					}
	
					$last_id = $row['categories_id'];
				}
				$fooa[$last_id]['next_id'] = $fooa[$value]['next_id'];
				$fooa[$value]['next_id'] = $first_id;
				$new_path .= '_';
			} else {
				break;
			}
		}
	}

	if ($id[0] != ''){
		show_subcategories($id[0]); 
  $boxContent = '';
  $boxContent .= $subcategories_string;

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
	}

?>
          
<!-- subcategories_eof //-->
