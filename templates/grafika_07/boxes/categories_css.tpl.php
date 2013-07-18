<tr>
 <td>
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr> 
    <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/box/corner_left.gif" border="0" alt="" width="22" height="40"></td>
    <td height="40" class="infoBoxHeading_Box" width="100%"><?php echo $boxHeading; ?></td>
    <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/box/corner_right.gif" border="0" alt="" width="16" height="40"></td>	
		</tr>
  </table>
 </td>
</tr>
  </table>
 </td>
</tr>
<tr>
 <td>
  <table border="0" width="100%" cellspacing="0" cellpadding="1" class="infoBox_Box">
   <tr>
    <td>
	 <table border="0" width="100%" cellspacing="0" cellpadding="3" class="infoBoxContents">
      <tr>
       <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <?php
// Preorder tree traversal
  function preorder($cid, $level, $foo, $cpath)
  {
    global $categories_string, $HTTP_GET_VARS;

// Display link
    if ($cid != 0) {
      for ($i=0; $i<$level; $i++)
        $categories_string .=  '  ';
      $categories_string .= '<a href="' . tep_href_link(FILENAME_DEFAULT, 'cPath
=' . $cpath . $cid) . '">';

// 1.6 Are we on the "path" to selected category?
      $bold = strstr($HTTP_GET_VARS['cPath'], $cpath . $cid . '_') ||  $HTTP_GET_VARS['cPath'] == $cpath . $cid;
// 1.6 If yes, use <b>
      if ($bold)
        $categories_string .=  '<b>';
      $categories_string .=  $foo[$cid]['name'];
      if ($bold)
        $categories_string .=  '</b>';
      $categories_string .=  '</a>';
// 1.4 SHOW_COUNTS is 'true' or 'false', not true or false
      if (SHOW_COUNTS == 'true') {
        $products_in_category = tep_count_products_in_category($cid);
        if ($products_in_category > 0) {
          $categories_string .= ' (' . $products_in_category . ')';
        }
      }
      $categories_string .= '<br>';
    }

// Function used for post November 2002 snapshots
  function tep_show_category($counter) {
    global $foo, $categories_string, $id;

    for ($a=0; $a<$foo[$counter]['level']; $a++) {
      $categories_string .= "  ";
    }
    }
  }

?>
<!-- show_subcategories //-->
          <tr>
            <td class="infoBox_left">

<?php

//////////
// Get categories list
//////////
// 1.2 Test for presence of status field for compatibility with older versions
$status = tep_db_num_rows(tep_db_query('describe ' .  TABLE_CATEGORIES . ' status'));


  $query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_image
            from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            where c.categories_id = cd.categories_id";
// 1.3 Can't have 'where' in an if statement!
  if ($status >0)
    $query.= " and c.status = '1'";
    $query.= " and cd.language_id='" . $languages_id ."'
            order by sort_order, cd.categories_name";

  $categories_query = tep_db_query($query);


// Initiate tree traverse
  $categories_string = '';
  preorder(0, 0, $foo, '');

//////////
// Display box contents
//////////
  $info_box_contents = array();
  $row = 0;
  $col = 0;
  while ($categories = tep_db_fetch_array($categories_query)) {
   if ($categories['parent_id'] == 0)
   {
            $temp_cPath_array = $cPath_array;  //Johan's solution - kill the array but save it for the rest of the site
         unset($cPath_array);

            $cPath_new = tep_get_path($categories['categories_id']);

         $text_subcategories = '';
     $subcategories_query = tep_db_query($query);
     while ($subcategories = tep_db_fetch_array($subcategories_query))
         {

                if ($subcategories['parent_id'] == $categories['categories_id'])
                {

                                        $cPath_new_sub = "cPath="  . $categories['categories_id'] . "_" . $subcategories['categories_id'];

                    $text_subcategories .= '' . '<a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new_sub, 'NONSSL') . '" class="menusubcateg">' . '&nbsp;&nbsp;&nbsp;' . tep_image(DIR_WS_TEMPLATES . 'images/misc/pointer_blue_light.gif', '') . $subcategories['categories_name'] . '</a>' . " ";
                } // if
     } // While Interno
    $info_box_contents[$row] = array('align' => 'left',
                                           'params' => 'class="smallText" width="100%" valign="top"',
                                           'text' => '' . '<a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new, 'NONSSL') . '" class="menucateg"><b>' . '&nbsp;' . tep_image(DIR_WS_TEMPLATES . 'images/misc/pointer_blue.gif', '') . $categories['categories_name'] . '</b></a>' . $text_subcategories);
    $col ++;
    if ($col > 0)
        {
                $col = 0;
                $row ++;
    }
    $cPath_array = $temp_cPath_array; //Re-enable the array for the rest of the code
   }
  }
//  new noborderBox($info_box_contents, true);


  $boxContent = '';
  $boxContent .= new noborderBox2($info_box_contents, true);;


?>
<!-- show_subcategories_eof //-->

       </td></tr>
      <tr>
       <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
 </td>
</tr>
<tr>
 <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
</tr>