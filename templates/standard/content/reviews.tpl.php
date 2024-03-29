<?php
/*
  $Id: \templates\standard\content\reviews.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
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
 <!-- Naglowek EOF -->

 <tr>
  <td>
   <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <?php
    $reviews_query_raw = "select r.reviews_id, left(rd.reviews_text, 100) as reviews_text, r.reviews_rating, r.date_added, p.products_id, pd.products_name, p.products_image, r.customers_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = r.products_id and r.reviews_id = rd.reviews_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and rd.languages_id = '" . (int)$languages_id . "' and r.approved = '1' order by r.reviews_id DESC";

    $reviews_split = new splitPageResults($reviews_query_raw, MAX_DISPLAY_NEW_REVIEWS);

    if ($reviews_split->number_of_rows > 0) {
     if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) {
     ?>
     <tr>
      <td>
	   <table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
         <td class="smallText"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
         <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></td>
        </tr>
       </table>
	  </td>
     </tr>
     <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
     </tr>
     <?php
     }
     $reviews_query = tep_db_query($reviews_split->sql_query);
     while ($reviews = tep_db_fetch_array($reviews_query)) {
     ?>
     <tr>
      <td>
	   <table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
         <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
        </tr>
        <tr>
         <td class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $reviews['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '"><u><b>' . $reviews['products_name'] . '</b></u></a> <span class="smallText">' . sprintf(TEXT_REVIEW_BY, tep_output_string_protected($reviews['customers_name'])) . '</span>'; ?></td>
         <td class="smallText" align="right"><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, tep_date_long($reviews['date_added'])); ?></td>
        </tr>
       </table>
	  </td>
     </tr>
     <tr>
      <td>
	   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
        <tr class="infoBoxContents">
         <td>
		  <table border="0" width="100%" cellspacing="0" cellpadding="4">
           <tr>
            <td width="<?php echo SMALL_IMAGE_WIDTH + 10; ?>" align="center" valign="top" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $reviews['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '">' . tep_image(DIR_WS_IMAGES . $reviews['products_image'], $reviews['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>'; ?></td>
            <td valign="top" class="main"><?php echo tep_break_string(tep_output_string_protected($reviews['reviews_text']), 60, '-<br>') . ((strlen($reviews['reviews_text']) >= 100) ? '..' : '') . '<br><br><i>' . sprintf(TEXT_REVIEW_RATING, tep_image(DIR_WS_TEMPLATES . 'images/misc/stars_' . $reviews['reviews_rating'] . '.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])), sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])) . '</i>'; ?></td>
           </tr>
          </table>
		 </td>
        </tr>
       </table>
	  </td>
     </tr>
     <?php
     }
     ?>
     <?php
    } else {
    ?>
     <tr>
      <td>
	   <?php new infoBox(array(array('text' => TEXT_NO_REVIEWS))); ?></td>
      </tr>
      <tr>
       <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
      </tr>
     <?php
     }

     if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
     ?>
     <tr>
      <td>
	   <table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
         <td class="smallText"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
         <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></td>
        </tr>
       </table>
	  </td>
     </tr>
     <?php
     }
     ?>
   </table>
  </td>
 </tr>
</table>