<?php
/*
  $Id: \includes\modules\main_categories.php; 25.06.2006

  mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

//------------------------------------------------------------------------------------------------------
// PARAMETERS
//------------------------------------------------------------------------------------------------------

$item_subcategories_options = '';

//------------------------------------------------------------------------------------------------------
// CODE - do not change below here
//------------------------------------------------------------------------------------------------------

// Preorder tree traversal
function preorder($cid, $level, $foo, $cpath) {
 global $categories_string, $HTTP_GET_VARS;

 // Display link
 if ($cid != 0) {
  for ($i=0; $i<$level; $i++)
   $categories_string .=  '&nbsp;&nbsp;';
   $categories_string .= '<a href="' . tep_href_link(FILENAME_DEFAULT, 'cPath=' . $cpath . $cid) . '">';
   // 1.6 Are we on the "path" to selected category?
   $bold = strstr($HTTP_GET_VARS['cPath'], $cpath . $cid . '_') || $HTTP_GET_VARS['cPath'] == $cpath . $cid;
   // 1.6 If yes, use <b>
   if ($bold)
    $categories_string .=  '<b>';
    $categories_string .=  $foo[$cid]['name'];
    if ($bold)
     $categories_string .=  '</b>';
     $categories_string .=  '</a>';
     $categories_string .= '<br>';
    }

    // Traverse category tree
    if (is_array($foo)) {
     foreach ($foo as $key => $value) {
      if ($foo[$key]['parent'] == $cid) {
       preorder($key, $level+1, $foo, ($level != 0 ? $cpath . $cid . '_' : ''));
      }
     }
    }
   }

   ?>
   <!-- main_categories //-->
   <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <!-- Naglowek BOF -->
    <tr>
     <td>
      <?php
      $info_box_contents = array();
      $info_box_contents[] = array('text'  => BOX_HEADING_CATEGORIES);
      new contentBoxHeading($info_box_contents);
      ?>
     </td>
    </tr>
    <!-- Naglowek EOF -->

 <tr>
  <td class="modulesBox" align="center">
   <table border="0" width="100%" cellspacing="0" cellpadding="1" bgcolor="#FFFFFF">
   <tr>
     <td class="main">
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
       <tr>
        <td class="main">

         <?php
         $status = tep_db_num_rows(tep_db_query('describe ' . TABLE_CATEGORIES . ' status'));
  
         $query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_image from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION ." cd  where c.categories_id = cd.categories_id";
         if ($status >0)
          $query.= " and c.status = '1'";
          $query.= " and cd.language_id='" . $languages_id ."' order by sort_order, cd.categories_name";

          $categories_query = tep_db_query($query);
          $categories_string = '';
          preorder(0, 0, $foo, '');

          //////////
          // Display box contents
          //////////

          $ilosc_col = MAX_DISPLAY_CATEGORIES_PER_ROW;
          $ilosc_col = $ilosc_col - 1;
          $info_box_contents = array();
          $row = 0;
          $col = 0;
          $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';     // szerokosc tabeli zalezna od ilosci kolumn
//          $wysokosc = SUBCATEGORY_IMAGE_HEIGHT + 10;                      // wysokosc zalezna od wielkosci ustawionych obrazkow kategorii
          $szerokosc = SUBCATEGORY_IMAGE_WIDTH + 16;
          $wysokosc = SUBCATEGORY_IMAGE_WIDTH + 16;

          while ($categories = tep_db_fetch_array($categories_query)) {
	         if ($categories['parent_id'] == 0) {
            $rows++;
   		      $cPath_new = tep_get_path($categories['categories_id']);
     		    if ($subcategories['parent_id'] == $categories['categories_id']) {
             $cPath_new_sub = "cPath="  . $categories['categories_id']/*"OMITED SO IT DOESNT DISPLAY SUBCATEGORIES" . "_" . $subcategories['categories_id']*/;
             $text_subcategories .= ' <a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new_sub, 'NONSSL') . '">';
             $text_subcategories .= $subcategories['categories_name'] . '</a>' . " ";
            } // if ($subcategories['parent_id'] == $categories['categories_id'])

            $info_box_contents[$row][$col] = array('align' => 'center',
                              'params' => 'class="smallText" width="'.$width.'" valign="top"',
                               'text' => '
		          <table width="100%" cellpadding="0" cellspacing="0" class="TableFrame">
		           <tr>
		            <td align="center"  height="28" class="Button">
		             <a class="ProductDescripion" href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">'. $categories['categories_name'] . '</a>
		            </td>
		           </tr>
		           <tr>
                <td align="center" valign="top" width="100%">'.
				(isset($categories['categories_image']) ? '
           <div style="background-color: #FFFFFF; border: 0px; width: '.$szerokosc.'px; height: '.$wysokosc.'px; padding: 0px 0px;">
           <table border="0" cellpadding="0" cellspacing="0"><tr>
            <td class="t1"></td>
            <td class="t2"></td>
            <td class="t3"></td>
            </tr><tr>
            <td class="t4"></td>
            <td class="t5" align="center" valign="middle" height="'.SMALL_IMAGE_HEIGHT.'px" width="'.SMALL_IMAGE_WIDTH.'px">
	         	     <a class="ProductDescripion" href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . tep_image(DIR_WS_IMAGES . $categories['categories_image'], $categories['categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '</a>
                </td><td class="t6"></td>
                </tr><tr>
                <td class="t7"></td>
                <td class="t8"></td>
                <td class="t9"></td>
                </tr></table></div>' : '').'
				</td>
		           </tr>
	             <tr><td>' .tep_draw_separator('pixel_trans.gif', '100%', '5'). '</td>
               </tr>
		          </table>');
            $col ++;
            if ($col > $ilosc_col) {
             $col = 0;
             $row ++;
            }
           } //if ($categories['parent_id'] == 0)
          } // while ($categories = tep_db_fetch_array($categories_query))
          new contentBox($info_box_contents);
          ?>
	      </td>
       </tr>
      </table>
     </td>
   </tr>
   </table>
  </td>
 </tr>
<tr>
 <td>
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
   <tr>
	  <td height="3"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/infobox/corner_bot_left.gif'); ?></td>
	  <td width="100%" valign="middle" style="background: url(<?php echo DIR_WS_TEMPLATES; ?>images/infobox/bot_bg.gif)"></td>
	  <td height="3"><?php echo tep_image(DIR_WS_TEMPLATES . 'images/infobox/corner_bot_right.gif');?></td>
   </tr>
  </table>
 </td>
</tr>

   </table>
<!-- main_categories_eof //-->