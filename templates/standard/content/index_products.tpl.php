<?php
/*
  $Id: \templates\standard\content\index_products.tpl.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

if (isset($HTTP_GET_VARS['manufacturers_id'])) 
 $db_query = tep_db_query("select manufacturers_htc_title_tag as htc_title, manufacturers_htc_description as htc_description from " . TABLE_MANUFACTURERS_INFO . " where languages_id = '" . (int)$languages_id . "' and manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'");
else 
 $db_query = tep_db_query("select categories_name, categories_htc_title_tag as htc_title, categories_htc_description as htc_description from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$current_category_id . "' and language_id = '" . (int)$languages_id . "'");

 $htc = tep_db_fetch_array($db_query);
 ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
 <?php
 if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
 ?>
 
 	<tr>  
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo HEADING_TITLE; ?></td>
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_left.gif" border="0" alt="" width="30" height="35"></td>	
	</tr> 
 </table></td>
      </tr>	  
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <tr>
  <td>
   <?php
   $info_box_contents = array();
   if (tep_not_null($htc['htc_title'])) {
      $info_box_contents[] = array('text' => sprintf($htc['htc_title']));   // jezeli wypelnione jest pole tytul kategori w HTC
   } else {
     if (isset($HTTP_GET_VARS['manufacturers_id'])) {
       $info_box_contents[] = array('text' => sprintf(HEADING_TITLE));    // jezeli nie jest wypelnione pole tytul kategori w HTC
     } else {
       $info_box_contents[] = array('text' => sprintf($htc['categories_name']));
     }
   }
   new contentBoxHeading($info_box_contents);
   ?>
  </td>
 </tr>
 
 <?php 
 } else { 
 ?>
 
 <tr>
  <td>
   <?php
   $info_box_contents = array();
//   $info_box_contents[] = array('text' => sprintf(HEADING_TITLE));
   if (isset($HTTP_GET_VARS['manufacturers_id'])) {
     $info_box_contents[] = array('text' => sprintf(HEADING_TITLE));    // jezeli nie jest wypelnione pole tytul kategori w HTC
   } else {
     $info_box_contents[] = array('text' => sprintf($htc['categories_name']));
   }
   new contentBoxHeading($info_box_contents);
   ?>
  </td>
 </tr>
 <?php 
 } 
 ?>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>
 </tr>

 <?php if (tep_not_null($htc['htc_description'])) { ?> 
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="3">
       <tr>
        <?php
        $image = tep_db_query("select categories_image from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$current_category_id . "'");
        $image = tep_db_fetch_array($image);
        $image = $image['categories_image'];
        if ($image['categories_image'] != '') {
            $szerokosc = SMALL_IMAGE_WIDTH + 16;
            $wysokosc = SMALL_IMAGE_HEIGHT + 16;
            echo '<td align="center" valign="top" width="'.$szerokosc.'">';
			if (isset($image['categories_image'])) {
            echo '<div style="border: 0px; width: '.$szerokosc.'px; height: '.$wysokosc.'px; padding: 0px 0px;"><table border="0" cellpadding="0" cellspacing="0" width="'.$szerokosc.'" height="'.$wysokosc.'"><tr>
            <td class="t1"></td>
            <td class="t2"></td>
            <td class="t3"></td>
            </tr><tr>
            <td class="t4"></td>
            <td class="t5" align="center" valign="middle" >';
            echo tep_image(DIR_WS_IMAGES.$image, $image, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
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
        <td class="main" valign="top" align="left"><?php echo $htc['htc_description']; ?></td>
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

 // optional Product List Filter
 if (PRODUCT_LIST_FILTER > 0) {
  if (isset($HTTP_GET_VARS['manufacturers_id'])) {
   $filterlist_sql = "select distinct c.categories_id as id, cd.categories_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p2c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "' order by cd.categories_name";
  } else {
   $filterlist_sql= "select distinct m.manufacturers_id as id, m.manufacturers_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_MANUFACTURERS . " m where p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' order by m.manufacturers_name";
  }
  $filterlist_query = tep_db_query($filterlist_sql);
  if (tep_db_num_rows($filterlist_query) > 1) {
   echo '            <tr><td align="right" class="main">' . tep_draw_form('filter', FILENAME_DEFAULT, 'get') . TEXT_SHOW . '&nbsp;';
   if (isset($HTTP_GET_VARS['manufacturers_id'])) {
    echo tep_draw_hidden_field('manufacturers_id', $HTTP_GET_VARS['manufacturers_id']);
    $options = array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES));
   } else {
    echo tep_draw_hidden_field('cPath', $cPath);
    $options = array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS));
   }
   echo tep_draw_hidden_field('sort', $HTTP_GET_VARS['sort']);
   while ($filterlist = tep_db_fetch_array($filterlist_query)) {
    $options[] = array('id' => $filterlist['id'], 'text' => $filterlist['name']);
   }
   echo tep_draw_pull_down_menu('filter_id', $options, (isset($HTTP_GET_VARS['filter_id']) ? $HTTP_GET_VARS['filter_id'] : ''), 'onchange="this.form.submit()"');
   echo tep_hide_session_id() . '</form></td></tr>' . "\n";
  }
 }
?>

 <tr>
  <td><?php include($modules_folder . FILENAME_PRODUCT_LISTING); ?></td>
 </tr>
</table>