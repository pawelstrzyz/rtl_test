<?php
/*
  $Id: \templates\standard\content\index_nested.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td>

            <!-- Naglowek BOF -->
            <?php 
            if (ALLOW_HEADER_TAGS_CONTROLLER=='true') { 
                // Header Tag Controller BOF
                $info_box_contents = array();
                if (tep_not_null($category['categories_htc_title_tag'])) {
                    $info_box_contents[] = array('text' => sprintf($category['categories_htc_title_tag']));   // jezeli wypelnione jest pole tytul kategori w HTC
                } else {
                    $info_box_contents[] = array('text' => sprintf($category['categories_name']));
                }
                new contentBoxHeading($info_box_contents);
            } else { 
                $info_box_contents = array();
                $info_box_contents[] = array('text' => sprintf($category['categories_name']));
                new contentBoxHeading($info_box_contents);
                // Header Tag Controller EOF
            } 
            ?>
            <!-- Naglowek BOF -->
        </td>
    </tr>

    <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
    </tr>

   <!-- Opis kategorii BOF -->
   <?php 
    if (tep_not_null($category['categories_htc_description'])) {
    ?>
    <tr>
        <td>
            <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
                <tr class="infoBoxContents">
                    <td>
                        <table border="0" width="100%" cellspacing="0" cellpadding="3">
                            <tr>
                                <?php
                                if ($category['categories_image'] != '') {
                                    $szerokosc = SMALL_IMAGE_WIDTH + 16;
                                    $wysokosc = SMALL_IMAGE_HEIGHT + 16;
                                    echo '<td align="center" valign="top" width="'.$szerokosc.'">';
									if (isset($category['categories_image'])) {
                                    echo '<div style="border: 0px; width: '.$szerokosc.'px; height: '.$wysokosc.'px; padding: 0px 0px;"><table border="0" cellpadding="0" cellspacing="0" width="'.$szerokosc.'" height="'.$wysokosc.'"><tr>
                                    <td class="t1"></td>
                                    <td class="t2"></td>
                                    <td class="t3"></td>
                                    </tr><tr>
                                    <td class="t4"></td>
                                    <td class="t5" align="center" valign="middle" >';
                                    echo tep_image(DIR_WS_IMAGES.$category['categories_image'], $category['categories_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
                                    echo '</td><td class="t6"></td>
                                    </tr><tr>
                                    <td class="t7"></td>
                                    <td class="t8"></td>
                                    <td class="t9"></td>
                                    </tr></table></div>';
									}
                                    echo '</td>';
                                }
                                ?>
                                <td class="main" valign="top" align="left"><?php echo $category['categories_htc_description']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>
    </tr>
    <?php
    }
    ?>
    <!-- Opis kategorii EOF -->

    <!-- Naglowek BOF -->
    <tr>
     <td>
      <?php
       $info_box_contents = array();
       $info_box_contents[] = array('text' => sprintf(CAT_HEADING_TITLE));
       new contentBoxHeading($info_box_contents);
      ?>
     </td>
    </tr>
    <tr>
     <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
    </tr>
    <!-- Naglowek EOF -->
    <tr>
        <td class="main">
            <table border="0" width="100%" cellspacing="0" cellpadding="1" align="center">

                <tr>
                        <?php
                        $szerokosc = SUBCATEGORY_IMAGE_WIDTH + 6;
                        $wysokosc = SUBCATEGORY_IMAGE_HEIGHT + 7;
						$ilosc_col = MAX_DISPLAY_CATEGORIES_PER_ROW;
                        $szer_tab = 100/$ilosc_col ;
                        $ilosc_col = $ilosc_col - 1;
                        $info_box_contents = array();
                        if (isset($cPath) && strpos('_', $cPath)) {
                            // check to see if there are deeper categories within the current category
                            $category_links = array_reverse($cPath_array);
                            for($i=0, $n=sizeof($category_links); $i<$n; $i++) {
                                $categories_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_status = '1' and c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");
                                $categories = tep_db_fetch_array($categories_query);
                                if ($categories['total'] < 1) {
                                    // do nothing, go through the loop
                                } else {
                                    $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, pcategories.parent_id as grand_parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES . " AS pcategories, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_status = '1' and c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and pcategories.categories_id = '" . (int)$category_links[$i] . "' order by c.sort_order, cd.categories_name");
                                   break; // we've found the deepest category the customer is in
                                }
                            }
                        } else {
                            $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, pcategories.parent_id as grand_parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES . " AS pcategories, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_status = '1' and c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and pcategories.categories_id = '" . (int)$current_category_id . "' order by c.sort_order, cd.categories_name");
                        }

                             ########## START CODE ##########
                             $number_of_categories = tep_db_num_rows($categories_query);
                             //New Optimisation Mod to reduce products_name query to just 1
                             while ($categories = tep_db_fetch_array($categories_query)) {
                                 $list_of_categories[] = (int)$categories['categories_id'];
                                 $categories_info[] = array (
                                                   'categories_id'           => (int)$categories['categories_id'],
                                                   'categories_image'        => $categories['categories_image'],
                                                   'categories_name'         => $categories['categories_name'],
                                                   'parent_id'               => $categories['parent_id']);
                             }
                             tep_db_free_result($categories_query); // Housekeeping
                             if (sizeof($list_of_categories) > 0 ) {
                                $select_list_of_categories = implode(",", $list_of_categories);
                                $multiple_categories = tep_get_multiple_paths($select_list_of_categories);
                             }
                             $rows = 0;
                             $counted = count($categories_info);
                             for($i=0; $i<$counted; $i++) {
                                $rows++;
                                $cPath_new = $multiple_categories[$categories_info[$i]['categories_id']];
                                $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';
								echo '
								<td align="center" class="smallText" width="' . $width . '" valign="top">
                                 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="TableFrame">
                                  <tr>
                                   <td align="center" valign="middle">
                                    <table border="0" cellspacing="0" cellpadding="0">
									 <tr><td>'.tep_draw_separator('pixel_trans.gif', '100%', '5').'</td></tr>
                                     <tr>
                                      <td align="center" valign="top">'.
								       (isset($categories_info[$i]['categories_image']) ? '
                                       <div style="background-color: #FFFFFF; border: 0px; width: '.$szerokosc.'px; height: '.$wysokosc.'px; padding: 0px 0px;">
                                       <table border="0" cellpadding="0" cellspacing="0"><tr>
                                        <td class="t1"></td>
                                        <td class="t2"></td>
                                        <td class="t3"></td>
                                        </tr><tr>
                                        <td class="t4"></td>
                                        <td class="t5" align="center" valign="middle" height="'.SUBCATEGORY_IMAGE_HEIGHT.'px" width="'.SUBCATEGORY_IMAGE_WIDTH.'px">
 									    <a href="' . tep_href_link(FILENAME_DEFAULT, $multiple_categories[$categories_info[$i]['categories_id']]) . '">' . tep_image(DIR_WS_IMAGES . $categories_info[$i]['categories_image'], $categories_info[$i]['categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '</a>
                                        </td><td class="t6"></td>
                                        </tr><tr>
                                        <td class="t7"></td>
                                        <td class="t8"></td>
                                        <td class="t9"></td>
                                       </tr></table></div>' : '').'
                                      </td>
									 </tr>
									 <tr><td>'.tep_draw_separator('pixel_trans.gif', '100%', '5').'</td></tr>
									 <tr>
									  <td  align="center" valign="middle"><a class="ProductTile" href="' . tep_href_link(FILENAME_DEFAULT, $multiple_categories[$categories_info[$i]['categories_id']]) . '">' . $categories_info[$i]['categories_name'] . '</a></td>
									 </tr>
									 <tr><td>'.tep_draw_separator('pixel_trans.gif', '100%', '5').'</td></tr>
								    </table>
								   </td>
								  </tr>
								 </table>
								</td>' . "\n";
                                if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows != $number_of_categories)) {
                                echo '</tr>' . "\n";
                                echo '<tr>' . "\n";
                                }
                             }
                             //End Optimisation Mod
                             // needed for the new products module shown below
                             $new_products_category_id = $current_category_id;
                             ########## END CODE ##########
						
						
						
                        ?>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
    </tr>
    <!-- Naglowek BOF -->
    <tr>
     <td>
      <?php
       $info_box_contents = array();
       $info_box_contents[] = array('text' => sprintf(BOTH_HEADING_TITLE));
       new contentBoxHeading($info_box_contents);
      ?>
     </td>
    </tr>
    <tr>
     <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
    </tr>
    <!-- Naglowek EOF -->
    <tr>
     <td><?php include($modules_folder . FILENAME_PRODUCT_LISTING); ?></td>
    </tr>
    <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
    </tr>

    <?php if (SHOW_DEFAULTSPECIALS_CATEGORY=='true' && SPECIAL_PRICES_HIDE=='false') { ?>
    <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
    </tr>
    <tr>
        <td><?php include($modules_folder . FILENAME_SPECIALS_DEFAULT); ?></td>
    </tr>
    <?php } ?>

    <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
    </tr>
    <tr>
        <td><?php include($modules_folder . FILENAME_NEW_PRODUCTS); ?></td>
    </tr>
    <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
    </tr>
    <?php
    if (FEATURED_PRODUCTS_DISPLAY=='true') {
    ?>
        <tr>
            <td><?php include($modules_folder . FILENAME_FEATURED); ?></td>
        </tr>
    <?php
    }
    ?>
</table>