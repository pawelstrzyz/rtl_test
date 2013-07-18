<?php
/*
  $Id: \templates\standard\content\newsdesk_index.tpl.php; 10.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_NEWSDESK_INDEX);


if ($category_depth == 'nested') {
 $category_query = tep_db_query("select cd.categories_name, c.categories_image from " . TABLE_NEWSDESK_CATEGORIES . " c, " .  newsdesk_categories_description . " cd where c.categories_id = '" . $current_category_id . "' and cd.categories_id = '" . $current_category_id . "' and cd.language_id = '" . $languages_id . "'");

 $category = tep_db_fetch_array($category_query);
 ?>

 <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
   <td>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
     <tr>
      <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
     </tr>
     <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>
      <tr>
       <td>
        <!-- Wolfen added code BOF -->
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
         <tr>
          <?php
          $info_box_contents = array();
          if (MAX_MANUFACTURERS_LIST < 2) {
           $cat_choose = array(array('id' => '', 'text' => NEWS_BOX_CATEGORIES_CHOOSE));
          } else {
           $cat_choose = '';
          }
          // Below lines changed by Wolfen
          $categories_array = newsdesk_get_categories($cat_choose);
          for ($i=0; $i<sizeof($categories_array); $i++) {
           $path = "";
           $parent_categories = array();
           $categories_array[$i]['id'] = ($path == "") ? $categories_array[$i]['id'] : ($path . "_" . $categories_array[$i]['id']);
          }

          echo '<td align="right" class="main">' . tep_draw_form('newsPath', FILENAME_NEWSDESK_INDEX, 'get') . '&nbsp;';
          echo ' '.NEWS_BOX_CATEGORIES_CHOOSE.' '.newsdesk_show_draw_pull_down_menu('newsPath', $categories_array,'', 'onchange="this.form.submit();" size="' . ((sizeof($categories_array) < MAX_MANUFACTURERS_LIST) ? sizeof($categories_array) : MAX_MANUFACTURERS_LIST) . '" style="width:' . BOX_WIDTH . '"');
          echo '</form></td>' . "\n";
          ?>
         </tr>
        </table>
       </td>
      </tr>
      
	  <tr>
       <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
     </table>
     <?php
     if (($category['categories_image'] == 'NULL') or ($category['categories_image'] == '')) {
     } else {
     ?>
     <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
       <td class="accountCategory" align="center" width="50%">
        <?php echo '<b>' .$category['categories_name']. '</b>'; ?>
       </td>
       <td class="main" align="right" width="50%">
        <?php
        echo tep_image(DIR_WS_IMAGES . $category['categories_image'], $category['categories_name'], HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);
        ?>
       </td>
      </tr>
     </table>
     <?php
     }
     ?>
     <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
       <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
     </table>

     <table width="100%" cellspacing="0" cellpadding="1" class="infoBox" border="0">
      <tr>
       <td>
        <table width="100%" cellspacing="0" cellpadding="0" class="infoBoxContents" border="0">
         <tr>
          <td class="pageHeading">
           <?php // '' . TABLE_HEADING_NEWSDESK_SUBCAT . ''; ?>
          </td>
         </tr>
         <tr>
          <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
         </tr>
         <tr>
          <?php
          if ($newsPath && ereg('_', $newsPath)) {
           // check to see if there are deeper categories within the current category
           $category_links = array_reverse($newsPath_array);
           $size = sizeof($category_links);
           for($i=0; $i<$size; $i++) {
            $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image,  c.parent_id from "
              . TABLE_NEWSDESK_CATEGORIES . " c, " . TABLE_NEWSDESK_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . $category_links[$i]
              . "' and c.categories_id = cd.categories_id and cd.language_id = '" . $languages_id . "' order by sort_order, cd.categories_name");
            if (tep_db_num_rows($categories_query) < 1) {
             // do nothing, go through the loop
            } else {
             break; // we've found the deepest category the customer is in
            }
           }
          } else {
           $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from "
            . TABLE_NEWSDESK_CATEGORIES . " c, " . TABLE_NEWSDESK_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '"
            . $current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . $languages_id
            . "' order by sort_order, cd.categories_name");
          }
            
          echo '<td><table border="0" width="100%" cellspacing="0" cellpadding="5"><tr>';
            
          $rows = 0;
          while ($categories = tep_db_fetch_array($categories_query)) {
           $rows++;
           $newsPath_new = newsdesk_get_path($categories['categories_id']);
           $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';
             
           if (($categories['categories_image'] == 'NULL') || $categories['categories_image'] == '') {
            echo '<td></td>';
           } else {
            echo '<td align="center" width="100">' . tep_image(DIR_WS_IMAGES . $categories['categories_image'], $categories['categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '</td>';
           }

           echo '
           <td align="left" class="main" valign="middle">&nbsp;&nbsp;
            <a class="headerNavigation" href="' . tep_href_link(FILENAME_NEWSDESK_INDEX, $newsPath_new, 'NONSSL') . '"><b>' .  $print_echo
            . '' . $categories['categories_name'] . '</b></a></td>' . "\n";

             if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows !=  tep_db_num_rows($categories_query))) {
           echo '</tr>' . "\n";
           echo '<tr>' . "\n";
           }
          }

          echo '</tr></table></td>'
          ?>
        </tr>
       </table>
      </td>
     </tr>
    </table>
   </td>
  </tr>
 </table>
   <?php

} elseif ($category_depth == 'products') {

 // create column list
 $define_list = array(
 'NEWSDESK_IMAGE' => NEWSDESK_IMAGE,
 'NEWSDESK_IMAGE_TWO' => NEWSDESK_IMAGE_TWO,
 'NEWSDESK_IMAGE_THREE' => NEWSDESK_IMAGE_THREE,
 'NEWSDESK_ARTICLE_URL' => NEWSDESK_ARTICLE_URL,
 'NEWSDESK_ARTICLE_URL_NAME' => NEWSDESK_ARTICLE_URL_NAME,
 'NEWSDESK_ARTICLE_DESCRIPTION' => NEWSDESK_ARTICLE_DESCRIPTION,
 'NEWSDESK_ARTICLE_SHORTTEXT' => NEWSDESK_ARTICLE_SHORTTEXT,
 'NEWSDESK_ARTICLE_NAME' => NEWSDESK_ARTICLE_NAME,
 'NEWSDESK_DATE_AVAILABLE' => NEWSDESK_DATE_AVAILABLE,
 'NEWSDESK_STATUS' => NEWSDESK_STATUS,
  );

 asort($define_list);

 $column_list = array();
 reset($define_list);
 while (list($column, $value) = each($define_list)) {
  if ($value) $column_list[] = $column;
 }

 $select_column_list = '';

 $size = sizeof($column_list);
 for ($col=0; $col<$size; $col++) {
  if ( ($column_list[$col] == 'NEWSDESK_ARTICLE_NAME') || ($column_list[$col] == 'NEWSDESK_ARTICLE_SHORTTEXT') ) {
   continue;
  }

  if ($select_column_list != '') {
   $select_column_list .= ', ';
  }

  switch ($column_list[$col]) {
   case 'NEWSDESK_IMAGE': $select_column_list .= 'p.newsdesk_image';
     break;
   case 'NEWSDESK_IMAGE_TWO': $select_column_list .= 'p.newsdesk_image_two';
     break;
   case 'NEWSDESK_IMAGE_THREE': $select_column_list .= 'p.newsdesk_image_three';
     break;
   case 'NEWSDESK_ARTICLE_URL': $select_column_list .= 'pd.newsdesk_article_url';
     break;
   case 'NEWSDESK_ARTICLE_URL_NAME': $select_column_list .= 'pd.newsdesk_article_url_name';
     break;
   case 'NEWSDESK_ARTICLE_DESCRIPTION': $select_column_list .= 'pd.newsdesk_article_description';
     break;
   case 'NEWSDESK_ARTICLE_SHORTTEXT': $select_column_list .= 'pd.newsdesk_article_shorttext';
     break;
   case 'NEWSDESK_ARTICLE_NAME': $select_column_list .= 'pd.newsdesk_article_name';
     break;
   case 'NEWSDESK_DATE_AVAILABLE': $select_column_list .= 'p.newsdesk_date_added';
     break;
   case 'NEWSDESK_STATUS': $select_column_list .= 'p.newsdesk_status';
     break;
   }
  }

  if ($select_column_list != '') {
   $select_column_list .= ', ';
  }

  // show the products of a specified manufacturer
  if ($HTTP_GET_VARS['manufacturers_id']) {
   if ($HTTP_GET_VARS['filter_id']) {
   } else {
   // We show them all
   $listing_sql = "select " . $select_column_list . "  p.newsdesk_id, p.newsdesk_status, p.newsdesk_date_added, pd.newsdesk_article_name, pd.newsdesk_article_shorttext, pd.newsdesk_article_description, pd.newsdesk_article_url, pd.newsdesk_article_url_name, p.newsdesk_image, p.newsdesk_image_two, p.newsdesk_image_three, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, NULL) as final_price from (" . TABLE_NEWSDESK . " p, " . TABLE_NEWSDESK_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m) left join " . TABLE_SPECIALS . " s on p.newsdesk_id = s.products_id where p.newsdesk_status = '1' and pd.newsdesk_id = p.newsdesk_id and pd.language_id = '" . $languages_id . "' and m.manufacturers_id = '" . $HTTP_GET_VARS['manufacturers_id'] . "'";
   }

   // We build the categories-dropdown
   $filterlist_sql = "select distinct c.categories_id as id, cd.categories_name as name from " . TABLE_NEWSDESK . " p, " . TABLE_NEWSDESK_TO_CATEGORIES . " p2c, " . TABLE_NEWSDESK_CATEGORIES . " c, " . TABLE_NEWSDESK_CATEGORIES_DESCRIPTION . " cd where p.newsdesk_status = '1' and p.newsdesk_id = p2c.newsdesk_id and p2c.categories_id = c.categories_id and p2c.categories_id = cd.categories_id and cd.language_id = '" . $languages_id . "' order by cd.categories_name";

  } else {
  
   // show the products in a given categorie
   if ($HTTP_GET_VARS['filter_id']) {
    // We are asked to show only specific catgeory
    $listing_sql = "select " . $select_column_list . " p.newsdesk_id, p.newsdesk_status, p.newsdesk_date_added, pd.newsdesk_article_name, pd.newsdesk_article_shorttext,  pd.newsdesk_article_description, pd.newsdesk_article_url, pd.newsdesk_article_url_name, p.newsdesk_image, p.newsdesk_image_two, p.newsdesk_image_three, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, NULL) as final_price from (" . TABLE_NEWSDESK . " p, " . TABLE_NEWSDESK_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m, " . TABLE_NEWSDESK_TO_CATEGORIES . " p2c) left join " . TABLE_SPECIALS . " s on p.newsdesk_id = s.products_id where p.newsdesk_status = '1' and m.manufacturers_id = '" . $HTTP_GET_VARS['filter_id'] . "' and p.newsdesk_id = p2c.newsdesk_id and pd.newsdesk_id = p2c.newsdesk_id and pd.language_id = '" . $languages_id . "' and p2c.categories_id = '" . $current_category_id . "'";

   } else {
    // We show them all
    $listing_sql = "select " . $select_column_list . " p.newsdesk_id, p.newsdesk_status, p.newsdesk_date_added, pd.newsdesk_article_name, pd.newsdesk_article_shorttext, pd.newsdesk_article_description, pd.newsdesk_article_url, pd.newsdesk_article_url_name, p.newsdesk_image, p.newsdesk_image_two, p.newsdesk_image_three, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, NULL) as final_price from ((". TABLE_NEWSDESK_DESCRIPTION . " pd, " . TABLE_NEWSDESK . " p) left join " . TABLE_MANUFACTURERS . " m on p.newsdesk_id = m.manufacturers_id, " . TABLE_NEWSDESK_TO_CATEGORIES . " p2c) left join " . TABLE_SPECIALS . " s on p.newsdesk_id = s.products_id where p.newsdesk_status = '1' and p.newsdesk_id = p2c.newsdesk_id and pd.newsdesk_id = p2c.newsdesk_id and pd.language_id = '" . $languages_id ."' and p2c.categories_id = '" . $current_category_id . "'";
   }

   // We build the manufacturers Dropdown
   $filterlist_sql= "select distinct m.manufacturers_id as id, m.manufacturers_name as name from " . TABLE_NEWSDESK . " p, " . TABLE_NEWSDESK_TO_CATEGORIES . " p2c, " . TABLE_MANUFACTURERS . " m where p.newsdesk_status = '1' and p.newsdesk_id = m.manufacturers_id and p.newsdesk_id = p2c.newsdesk_id and p2c.categories_id = '" . $current_category_id . "' order by m.manufacturers_name";
  }
  $category_query = tep_db_query("select cd.categories_name, c.categories_image from " . TABLE_NEWSDESK_CATEGORIES . " c, " .  newsdesk_categories_description . " cd where c.categories_id = '" . $current_category_id . "' and cd.categories_id = '" . $current_category_id . "' and cd.language_id = '" . $languages_id . "'"
  );

  $category = tep_db_fetch_array($category_query);

  $cl_size = sizeof($column_list);
  if ( (!$HTTP_GET_VARS['sort']) || (!ereg('[1-8][ad]', $HTTP_GET_VARS['sort'])) || (substr($HTTP_GET_VARS['sort'],0,1) > $cl_size) ) {
   for ($col=0; $col<$cl_size; $col++) {
    if ($column_list[$col] == 'NEWSDESK_DATE_AVAILABLE') {
     $HTTP_GET_VARS['sort'] = $col+1 . 'd';
     $listing_sql .= " order by p.newsdesk_date_added desc";
     break;
    }
   }
  } else {
   $sort_col = substr($HTTP_GET_VARS['sort'], 0 , 1);
   $sort_order = substr($HTTP_GET_VARS['sort'], 1);
   $listing_sql .= ' order by ';
   switch ($column_list[$sort_col-1]) {
    case 'NEWSDESK_IMAGE': $listing_sql .= "p.newsdesk_image " . ($sort_order == 'd' ? "desc" : "") . ", p.newsdesk_date_added";
      break;
    case 'NEWSDESK_IMAGE_TWO': $listing_sql .= "p.newsdesk_image_two " . ($sort_order == 'd' ? "desc" : "") . ", p.newsdesk_date_added";
      break;
    case 'NEWSDESK_IMAGE_THREE': $listing_sql .= "p.newsdesk_image_three " . ($sort_order == 'd' ? "desc" : "") . ", p.newsdesk_date_added";
      break;
    case 'NEWSDESK_ARTICLE_URL': $listing_sql .= "pd.newsdesk_article_url " . ($sort_order == 'd' ? "desc" : "") . ", p.newsdesk_date_added";
      break;
    case 'NEWSDESK_ARTICLE_URL_NAME': $listing_sql .= "pd.newsdesk_article_url_name " . ($sort_order == 'd' ? "desc" : "") . ", p.newsdesk_date_added";
      break;
    case 'NEWSDESK_ARTICLE_DESCRIPTION': $listing_sql .= "pd.newsdesk_article_description " . ($sort_order == 'd' ? "desc" : "") . ", p.newsdesk_date_added";
      break;
    case 'NEWSDESK_ARTICLE_SHORTTEXT': $listing_sql .= "pd.newsdesk_article_shorttext " . ($sort_order == 'd' ? "desc" : "") . ", p.newsdesk_date_added";
      break;
    case 'NEWSDESK_ARTICLE_NAME': $listing_sql .= "pd.newsdesk_article_name " . ($sort_order == 'd' ? "desc" : "") . ", p.newsdesk_date_added";
      break;
    case 'NEWSDESK_DATE_AVAILABLE': $listing_sql .= "p.newsdesk_date_added " . ($sort_order == 'd' ? "desc" : "") . ", p.newsdesk_date_added";
      break;
    case 'NEWSDESK_STATUS': $listing_sql .= "p.newsdesk_status " . ($sort_order == 'd' ? "desc" : "") . ", p.newsdesk_date_added";
      break;
    }
   }
   ?>

    <table border="0" width="100%" cellspacing="0" cellpadding="0">
     
     <!-- Naglowek BOF -->
     <tr>
      <td>
       <?php
       $info_box_contents = array();
       $info_box_contents[] = array('text' => sprintf(HEADING_TITLE));
       new contentBoxHeading($info_box_contents);
       ?>
      </td>
     </tr>
     <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
     </tr>
     <!-- Naglowek EOF -->
     
	 <tr>
      <td>
       <!-- Wolfen added code BOF -->
       <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
         <?php
         $info_box_contents = array();
         if (MAX_MANUFACTURERS_LIST < 2) {
          $cat_choose = array(array('id' => '', 'text' => NEWS_BOX_CATEGORIES_CHOOSE));
         } else {
          $cat_choose = '';
         }
         // Below lines changed by Wolfen
         $categories_array = newsdesk_get_categories($cat_choose);
         for ($i=0; $i<sizeof($categories_array); $i++) {
          $path = "";
          $parent_categories = array();
          $categories_array[$i]['id'] = ($path == "") ? $categories_array[$i]['id'] : ($path . "_" . $categories_array[$i]['id']);
         }

         echo '<td align="right" class="main">' . tep_draw_form('newsPath', FILENAME_NEWSDESK_INDEX, 'get') . '&nbsp;';
         echo ' '.NEWS_BOX_CATEGORIES_CHOOSE.' '.newsdesk_show_draw_pull_down_menu('newsPath', $categories_array,'', 'onchange="this.form.submit();" size="' . ((sizeof($categories_array) < MAX_MANUFACTURERS_LIST) ? sizeof($categories_array) : MAX_MANUFACTURERS_LIST) . '" style="width:' . BOX_WIDTH . '"');
         echo '</form></td>' . "\n";
         ?>
        </tr>
       </table>
       <!-- Wolfen added code EOF -->
      </td>
     </tr>
     
	 <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
     </tr>
     <tr>
      <td>
       <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
         <td class="accountCategory" align="left" width="50%">
          <?php echo '<b>' .$category['categories_name']. '</b>'; ?>
         </td>
         <td class="main" align="right" width="50%">
          <?php
          // Get the right image for the top-right
          $image = DIR_WS_TEMPLATES . 'images/misc/table_background_list.gif';
          if ($HTTP_GET_VARS['newsdesk_id']) {
           $image = tep_db_query("select newsdesk_image from " . TABLE_NEWSDESK . " where newsdesk_id = '" . $HTTP_GET_VARS['newsdesk_id'] . "'");
           $image = tep_db_fetch_array($image);
           $image = $image['newsdesk_image'];

           $image_two = tep_db_query("select newsdesk_image_two from " . TABLE_NEWSDESK . " where newsdesk_id = '" . $HTTP_GET_VARS['newsdesk_id'] . "'");
           $image_two = tep_db_fetch_array($image_two);
           $image_two = $image['newsdesk_image_two'];

           $image_three = tep_db_query("select newsdesk_image_three from " . TABLE_NEWSDESK . " where newsdesk_id = '" . $HTTP_GET_VARS['newsdesk_id'] . "'");
           $image_three = tep_db_fetch_array($image_three);
           $image_three = $image['newsdesk_image_three'];

          } elseif ($current_category_id) {
           $image = tep_db_query("select categories_image from " . TABLE_NEWSDESK_CATEGORIES . " where categories_id = '" . $current_category_id . "'");
           $image = tep_db_fetch_array($image);
           $image = $image['categories_image'];
          }
          ?>

          <?php
          if ($category['categories_image'] == 'null' || $category['categories_image'] == '' ) {
           echo '';
          } else {
           echo tep_image(DIR_WS_IMAGES . $image, HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);
           echo tep_image(DIR_WS_IMAGES . $image_two, HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);
           echo tep_image(DIR_WS_IMAGES . $image_three, HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);
          }
          ?>
          &nbsp;</td>
        </tr>
       </table>
      </td>
     </tr>
     
	 <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
     </tr>

     <?php
     $listing_numrows_sql = $listing_sql;
     $listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_NEWSDESK_SEARCH_RESULTS, 'p.newsdesk_id');
     $listing_numrows = tep_db_query($listing_numrows_sql);
     $listing_numrows = tep_db_num_rows($listing_numrows);
     if ($listing_numrows > 0 && (NEWSDESK_PREV_NEXT_BAR_LOCATION == '1' || NEWSDESK_PREV_NEXT_BAR_LOCATION == '3')) {
      ?>
      <tr>
       <td>
        <table border="0" width="100%" cellspacing="0" cellpadding="2">
         <tr>
          <td class="smallText">&nbsp;<?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES); ?>&nbsp;</td>
          <td align="right" class="smallText">&nbsp;<?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_NEWSDESK_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>&nbsp;</td>
         </tr>
        </table>
       </td>
      </tr>
      <tr>
       <td ><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3') ?></td>
      </tr>
     <?php
     }
     ?>
     
	 <tr>
      <td>
       <table width="100%" cellspacing="1" cellpadding="0" class="infoBox" border="0">
        <tr class="infoBoxContents">
         <td>
          <table width="100%" cellspacing="0" cellpadding="0" border="0">
           <tr>
            <td><?php include($modules_folder . FILENAME_NEWSDESK_LISTING); ?></td>
           </tr>
          </table>
         </td>
        </tr>
       </table>
      </td>
     </tr>
     
	 <tr>
      <td ><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3') ?></td>
     </tr>
     <?php
     if ($listing_numrows > 0 && (NEWSDESK_PREV_NEXT_BAR_LOCATION == '1' || NEWSDESK_PREV_NEXT_BAR_LOCATION == '3')) {
     ?>
     <tr>
      <td>
       <table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
         <td class="smallText">&nbsp;<?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES); ?>&nbsp;</td>
         <td align="right" class="smallText">&nbsp;<?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_NEWSDESK_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>&nbsp;</td>
        </tr>
       </table>
      </td>
     </tr>
     <?php
     }
     ?>
    </table>
<?php
}
?>