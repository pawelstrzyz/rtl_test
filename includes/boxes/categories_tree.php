<?php
/*
  $Id: \includes\boxes\categories_tree.php; 23.06.2006

  mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>
<!-- categories //-->
<tr>
 <td>
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
   <tr>
	  <td class="infoBoxHeading" height="35" width="30"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
	  <td width="100%" class="infoBoxHeading" height="35"><?php echo $boxHeading; ?></td>
	  <td class="infoBoxHeading"  height="35" width="30" ><img src="templates/standard/images/infobox/corner_left.gif" border="0" alt="" width="30" height="35"></td>
   </tr>
  </table>
 </td>
</tr>
<tr>
 <td>
  <table border="0" width="100%" cellspacing="0" cellpadding="1" class="infoBox_Box">
   <tr>
   <td>
<?php


    $number_top_levels = 0;
    $categories_string='';
    $number_top_levels = build_menus(0,'','',0);

function build_menus($currentParID,$menustr,$catstr, $indent) {
    global $categories_string, $id, $languages_id;
    $tmpCount;

    $tmpCount = 0;
    $haschildren = 0; //default

    $categories_query_catmenu = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . $currentParID . "' and c.categories_id = cd.categories_id and cd.language_id='" . $languages_id ."' order by sort_order, cd.categories_name");
    $numberOfRows = tep_db_num_rows($categories_query_catmenu);
    $currentRow = 0;
    while ($categories = tep_db_fetch_array($categories_query_catmenu))  {
        $currentRow ++;
        $catName = $categories['categories_name'];
        $tmpCount += 1;
        $haschildren = tep_has_category_subcategories($categories['categories_id']);

        if (SHOW_COUNTS == 'true') {
            $products_in_category = tep_count_products_in_category($categories['categories_id']);
            if ($products_in_category > 0) {
                $catName .= ' (' . $products_in_category . ')';
            }
        }

        if($catstr != ''){
            $cPath_new = 'cPath=' . $catstr . '_' . $categories['categories_id'];
        } else {
            $indent = 0;
            $cPath_new = 'cPath=' . $categories['categories_id'];
        }

        if($menustr != ''){
            $menu_tmp = $menustr . '_' . $tmpCount;
        } else {
            $menu_tmp = $tmpCount;
        }

        $indentStr="";
        for($i=0; $i<$indent; $i++) {
            $indentStr .= "   ";
        }

        $categories_string .=  $indentStr . "[null, '" . $catName ."','" . tep_href_link(FILENAME_DEFAULT, $cPath_new) . "','_self','". $tmpString ."'";
        if ($haschildren) {
            $indent += 1;
            $categories_string .= ",\n";
            if($menustr != ''){
                $menu_tmp = $menustr . '_' . $tmpCount;
            } else {
                $menu_tmp = $tmpCount;
            }
            if($catstr != ''){
                $cat_tmp = $catstr . '_' . $categories['categories_id'];
            } else {
                $cat_tmp = $categories['categories_id'];
            }
            $NumChildren = build_menus($categories['categories_id'], $menu_tmp, $cat_tmp, $indent);
            if ($currentRow < $numberOfRows) {
                $categories_string .= $indentStr . "],\n";
            } else {
                $categories_string .= $indentStr . "]\n";
            }
        } else {
            if ($currentRow < $numberOfRows) {
                $categories_string .= "],\n";
            } else {
                $categories_string .= "]\n";
            }
            $NumChildren = 0;
        }
    }
    return $tmpCount;
}

    $currentCPath = $HTTP_GET_VARS['cPath'];
    if (! isset($currentCPath)) {
        if (isset($HTTP_GET_VARS['products_id'])) {
            $cPathQuery = tep_db_query("select c.categories_id, c.parent_id  from " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p2c.products_id = '" . $HTTP_GET_VARS['products_id'] . "' and c.categories_id = p2c.categories_id");
            if ($cp = tep_db_fetch_array($cPathQuery))  {
                $currentCPath = $cp['parent_id'] . "_" . $cp['categories_id'];
            }
        }
    }

    echo "<SCRIPT LANGUAGE=\"JavaScript\" SRC=\"includes/javascript/jscooktree/JSCookTree.js\"></SCRIPT>\n";
    echo "<LINK REL=\"stylesheet\" HREF=\"includes/javascript/jscooktree/ThemeXP/theme.css\" TYPE=\"text/css\">\n";
    echo "<SCRIPT LANGUAGE=\"JavaScript\" SRC=\"includes/javascript/jscooktree/ThemeXP/theme.js\"></SCRIPT>\n";

?>
<?php

   $tabletext .= "<div id=\"myID\"></div>\n";
   $tabletext .= "<script type=\"text/javascript\"><!--
        var catTree =
        [\n";
   $tabletext .= $categories_string;
   $tabletext .= "];
     --></script>\n";


    $info_box_contents = array();
    $info_box_contents[] = array('align' => 'left',
                                 'text'  => $tabletext);
    new infoBox($info_box_contents);

    echo "<script type=\"text/javascript\"><!--\n";
    echo "    var treeIndex = ctDraw ('myID', catTree, ctThemeXP1, 'ThemeXP', 2, 0);\n";
    if (isset($currentCPath)) {
        echo "    var treeItem = ctExposeItem (0, '" . tep_href_link(FILENAME_DEFAULT, 'cPath=' . $currentCPath) . "');\n";
        echo "    ctOpenFolder (treeItem);\n";
    }
    echo "--></script>\n";
	

?>

</td>
</tr>
</table>
</td>
</tr>
<tr>
 <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
</tr>

<!-- categories_eof //-->