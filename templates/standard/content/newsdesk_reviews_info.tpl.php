<?php
/*
  $Id: \templates\standard\content\newsdesk_reviews_article.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php
 tep_db_query("update " . TABLE_NEWSDESK_REVIEWS . " set reviews_read = reviews_read+1 where reviews_id = '" . $HTTP_GET_VARS['reviews_id'] . "'");
 $reviews = tep_db_query("select rd.reviews_text, r.reviews_rating, r.reviews_id, r.newsdesk_id, r.customers_name, r.date_added, r.last_modified, r.reviews_read from " . TABLE_NEWSDESK_REVIEWS . " r, " . TABLE_NEWSDESK_REVIEWS_DESCRIPTION . " rd where r.reviews_id = '" . $HTTP_GET_VARS['reviews_id'] . "' and r.reviews_id = rd.reviews_id");
 $reviews_values = tep_db_fetch_array($reviews);
 $reviews_text = htmlspecialchars($reviews_values['reviews_text']);
 $reviews_text = tep_break_string($reviews_text, 60, '-<br>');
 $product = tep_db_query("select p.newsdesk_id, pd.newsdesk_article_name, p.newsdesk_image from " . TABLE_NEWSDESK . " p, " . TABLE_NEWSDESK_DESCRIPTION . " pd where p.newsdesk_id = '" . $reviews_values['newsdesk_id'] . "' and pd.newsdesk_id = p.newsdesk_id and pd.language_id = '". $languages_id . "'");
 $product_info_values = tep_db_fetch_array($product);
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
	<tr>  
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo sprintf(HEADING_TITLE, $product_info_values[ newsdesk_article_name ]); ?></td>
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
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td class="main"><b><?php echo SUB_TITLE_PRODUCT; ?></b> <?php echo $product_info_values['newsdesk_article_name']; ?></td>
        <td class="smallText" rowspan="3" align="center">
         <?php echo tep_image(DIR_WS_IMAGES . $product_info_values['newsdesk_image'], $product_info_values['newsdesk_article_name'], '', '', 'align="center" hspace="5" vspace="5"'); ?>
        </td>
       </tr>
       <tr>
        <td class="main"><b><?php echo SUB_TITLE_FROM; ?></b> <?php echo $reviews_values['customers_name']; ?></td>
       </tr>
       <tr>
        <td class="main"><b><?php echo SUB_TITLE_DATE; ?></b> <?php echo tep_date_long($reviews_values['date_added']); ?></td>
       </tr>
       <tr>
        <td class="main"><b><?php echo SUB_TITLE_REVIEW; ?></b></td>
       </tr>
       <tr>
        <td class="main"><?php echo nl2br($reviews_text); ?></td>
       </tr>
       <tr>
        <td class="main">
         <br><b>
         <?php
         echo SUB_TITLE_RATING; ?></b> <?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/stars_' . $reviews_values['reviews_rating'] . '.gif', sprintf(TEXT_OF_5_STARS, $reviews_values['reviews_rating'])); ?> <small>[<?php echo sprintf(TEXT_OF_5_STARS, $reviews_values['reviews_rating']); ?>]</small>
        </td>
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
 
 <!-- Przyciski BOF -->
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td align="left" width="33%">
         <?php
         if ( DISPLAY_NEWSDESK_REVIEWS ) {
          echo '<a href="' . tep_href_link(FILENAME_NEWSDESK_REVIEWS_WRITE, $get_params, 'NONSSL') . '">' . tep_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a>';
         }
         ?>
        </td>
        <td align="center" width="33%">
            <?php
            echo '<a href="' . tep_href_link(FILENAME_NEWSDESK_REVIEWS_ARTICLE, $get_params, 'NONSSL') . '">' . tep_image_button('button_reviews_list.gif', IMAGE_BUTTON_BACK) . '</a>';
            ?>

        </td>
        <td align="right" width="33%">
         <?php
         // BOF Wolfen added code for button case
         if ($get_backpath_back = $get_backpath) {
          echo '<a href="' . tep_href_link(FILENAME_NEWSDESK_INDEX, $get_backpath) . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>' . tep_draw_separator('pixel_trans.gif', '10', '1') . '<a href="' . tep_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>';
         } else {
          echo '<a href="' . tep_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>';
         }
         // EOF Wolfen added code for button case
         ?>
        </td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
  </td>
 </tr>
 <!-- Przyciski BOF -->

</table>