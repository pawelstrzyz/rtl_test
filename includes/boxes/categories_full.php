<!-- Kategorie -->
<?php
/*
  $Id: categories_full.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License

 mod eSklep-Os http://www.esklep-os.com
*/
// ---- CATEGORIES 2 LEVELS OPEN

$boxHeading = BOX_HEADING_CATEGORIES;
$corner_left = 'rounded';
$corner_right = 'square';
$box_base_name = 'categories'; // for easy unique box template setup (added BTSv1.2)

$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

function tep_show_category($counter) {
 global $tree, $categories_string, $cPath_array;

 if(!$tree[$counter]['level']){
  $categories_string .= $categories_string ? '<tr><td height=10 colspan=2></td></tr>' : '';
  $categories_string .= '<tr><td width=6 align="right">' .tep_image(DIR_WS_TEMPLATES . 'images/infobox/menu.gif'). '</td><td width="155" "CategoryBox"><a class="CateginfoBoxLink"  href="';
  if ($tree[$counter]['parent'] == 0) {
   $cPath_new = 'cPath=' . $counter;
  } else {
   $cPath_new = 'cPath=' . $tree[$counter]['path'];
  }
  $categories_string .= tep_href_link('index.php', $cPath_new) . '">';
  // display categry name
  $categories_string .= $tree[$counter]['name'];
  $categories_string .= '</a></td></tr>';
 } else {  // SUBCATEGORY
  $categories_string .= '<tr><td colspan=2>&nbsp;&nbsp;&nbsp;&nbsp; ';
  for($i=0;$i<$tree[$counter]['le vel'];$i++)
   $categories_string .= '&nbsp;&nbsp;&nbsp;';
   // zamieniony wers poniżej            $categories_string .= '<a class=infoBoxContents style="font-weight:normal;" href="';
   $categories_string .= '<a class="ml3" style="font-weight:normal;" href="';   
   if ($tree[$counter]['parent'] == 0) {
    $cPath_new = 'cPath=' . $counter;
   } else {
    $cPath_new = 'cPath=' . $tree[$counter]['path'];
   }
   $categories_string .= tep_href_link('index.php', $cPath_new) . '">';
   // display category name
   $categories_string .= $tree[$counter]['name'];
   $categories_string .= '</a></td></tr>';
  }

  if ($tree[$counter]['next_id'] != false) {
   tep_show_category($tree[$counter]['next_id']);
  }  
 }

 define(TABLE_CATEGORIES, "categories");
 define(TABLE_CATEGORIES_DESCRIPTION, "categories_description");

 $categories_string = '';
 $tree = array();

  $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' and c.categories_status = '1' order by sort_order, cd.categories_name");

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

 $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' and c.categories_status = '1' order by sort_order, cd.categories_name");
 while ($categories = tep_db_fetch_array($categories_query))  {
  $cPath_array2 = Array();    
  $new_path = '';
  $cPath_array2[] = $categories['categories_id'];
  while (list($key, $value) = each($cPath_array2)) {
   unset($parent_id);
   unset($first_id);
   $categories_query2 = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$value . "' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
   if (tep_db_num_rows($categories_query2)) {
    $new_path .= $value;
    while ($row = tep_db_fetch_array($categories_query2)) {
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

 //------------------------

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
<!-- Kategorie END-->