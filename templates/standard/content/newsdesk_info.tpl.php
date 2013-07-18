<?php
/*
  $Id: \templates\standard\content\newsdesk_info.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
	<tr>  
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo TEXT_NEWSDESK_HEADING; ?></td>
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
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td>
         <?php
         $product_info = tep_db_query("select p.newsdesk_id, pd.newsdesk_article_name, pd.newsdesk_article_description, pd.newsdesk_article_shorttext, p.newsdesk_image, p.newsdesk_image_two, p.newsdesk_image_three, pd.newsdesk_article_url, pd.newsdesk_article_url_name, pd.newsdesk_article_viewed, p.newsdesk_date_added, p.newsdesk_date_available from " . TABLE_NEWSDESK . " p, " . TABLE_NEWSDESK_DESCRIPTION . " pd where p.newsdesk_id = '" . $HTTP_GET_VARS['newsdesk_id'] . "' and pd.newsdesk_id = '" . $HTTP_GET_VARS['newsdesk_id'] . "' and pd.language_id = '" . $languages_id . "'");

         if (!tep_db_num_rows($product_info)) { // product not found in database
         ?>
         <table border="0" width="100%" cellspacing="3" cellpadding="3">
          <tr>
           <td class="main"><br><?php echo TEXT_NEWS_NOT_FOUND; ?></td>
          </tr>
         </table>

         <?php
         } else {
          tep_db_query("update " . TABLE_NEWSDESK_DESCRIPTION . " set newsdesk_article_viewed = newsdesk_article_viewed+1 where newsdesk_id = '" . $HTTP_GET_VARS['newsdesk_id'] . "' and language_id = '" . $languages_id . "'");
          $product_info_values = tep_db_fetch_array($product_info);

          if ($product_info_values['newsdesk_image'] != '') {
           if (($product_info['newsdesk_image'] != 'Array') or ($product_info['newsdesk_image'] != '')) {
            $insert_image = '<table border="0" cellspacing="0" cellpadding="0"><tr><td>'. tep_image(DIR_WS_IMAGES . $product_info_values['newsdesk_image'], $product_info_values['newsdesk_article_name'], '', '', 'hspace="5" vspace="5"'). '</td></tr></table>';
           }
          }

          if ($product_info_values['newsdesk_image_two'] != '') {
           if (($product_info['newsdesk_image_two'] != 'Array') or ($product_info['newsdesk_image_two'] != '')) {
            $insert_image_two = '<table border="0" cellspacing="0" cellpadding="0"><tr><td>'. tep_image(DIR_WS_IMAGES . $product_info_values['newsdesk_image_two'], $product_info_values['newsdesk_article_name'], '', '', 'hspace="5" vspace="5"'). '</td></tr></table>';
           }
          }

          if ($product_info_values['newsdesk_image_three'] != '') {
           if (($product_info['newsdesk_image_three'] != 'Array') or ($product_info['newsdesk_image_three'] != '')) {
            $insert_image_three = '<table border="0" cellspacing="0" cellpadding="0"><tr><td>'. tep_image(DIR_WS_IMAGES . $product_info_values['newsdesk_image_three'], $product_info_values['newsdesk_article_name'], '', '', 'hspace="5" vspace="5"'). '</td></tr></table>';
           }
          }
          ?>

          <!-- News Tytul i data BOF -->
          <table border="0" width="100%" cellspacing="0" cellpadding="3">
           <tr class="">
            <td class="main"><b><?php echo $product_info_values['newsdesk_article_name']; ?></b></td>
            <td class="main" align="right">&nbsp;
             <?php echo sprintf(TEXT_NEWSDESK_DATE, tep_date_long($product_info_values['newsdesk_date_added']));; ?>
            </td>
           </tr>
          </table>
          <!-- News Tytul i data EOF -->

          <!-- News zawartosc BOF -->
          <table border="0" width="100%" cellspacing="3" cellpadding="3">
           <tr>
            <td width="100%" class="main" valign="top">
             <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
               <td class="main"><?php echo TEXT_NEWSDESK_SUMMARY; ?></td>
              </tr>
              <tr>
               <td class=""><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
              </tr>
             </table>
             <?php echo stripslashes($product_info_values['newsdesk_article_shorttext']); ?>
             <br><br>

             <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
               <td class="main"><?php echo TEXT_NEWSDESK_CONTENT; ?></td>
              </tr>
              <tr>
               <td class=""><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
              </tr>
             </table>
             <?php 
			       echo stripslashes($product_info_values['newsdesk_article_description']); 
			
			       if ($product_info_values['newsdesk_article_url']) { 
			       ?>
             <br><br>

             <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
               <td class="main"><?php echo TEXT_NEWSDESK_LINK_HEADING; ?></td>
              </tr>
              <tr>
               <td class=""><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
              </tr>
              <tr>
               <td class="main">
                <?php $newslink = ($product_info_values['newsdesk_article_url_name']); ?>
                <?php echo sprintf(TEXT_NEWSDESK_LINK . '<a href="%s" target="_blank"><u>' . $newslink . '</u></a>.', tep_href_link(FILENAME_REDIRECT, 'action=url&goto=' . urlencode($product_info_values['newsdesk_article_url']), 'NONSSL', true, false)); ?>
               </td>
              </tr>
             </table>
             <?php
			       } 

			       $reviews = tep_db_query("select count(*) as count from " . TABLE_NEWSDESK_REVIEWS . " where approved='1' and newsdesk_id = '" . $HTTP_GET_VARS['newsdesk_id'] . "'");
             $reviews_values = tep_db_fetch_array($reviews);
             ?>
             <br><br>

             <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
               <td class="main"><?php echo TEXT_NEWSDESK_REVIEWS_HEADING; ?></td>
              </tr>
              <tr>
               <td class=""><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
              </tr>
              <tr>
               <td class="main"><?php echo TEXT_NEWSDESK_VIEWED . $product_info_values['newsdesk_article_viewed'] ?></td>
              </tr>
              <?php
              if ( DISPLAY_NEWSDESK_REVIEWS ) {
              ?>
              <tr>
               <td class="main"><?php echo TEXT_NEWSDESK_REVIEWS . ' ' . $reviews_values['count']; ?></td>
              </tr>
              <?php
              }
              ?>
             </table>
            </td>
            <td width="" class="main" valign="top" align="center">
            <?php
            echo $insert_image;
            echo $insert_image_two;
            echo $insert_image_three;
            ?>
            </td>
           </tr>
           <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
           </tr>
           <tr>
            <td>
             <?php
             if ( DISPLAY_NEWSDESK_REVIEWS ) {
              if ($reviews_values['count'] > 0) {
               require FILENAME_NEWSDESK_ARTICLE_REQUIRE;
              }
             }
             ?>
            </td>
           </tr>
          </table>
         <?php 
         } 
         ?>
         </td>
        </tr>
       </table>
      </td>
     </tr>
    </table>
   </td>
  </tr>

 <!-- Przyciski BOF -->
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td align="left">
         <?php 
         if ( DISPLAY_NEWSDESK_REVIEWS ) {
	      echo '<a href="' . tep_href_link(FILENAME_NEWSDESK_REVIEWS_WRITE, $get_params, 'NONSSL') . '">' . tep_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a>';
         }
         ?>
		</td>

		 <?php
         // BOF Wolfen added code for button case
         if ($get_backpath_back = $get_backpath) {
          echo '<td align="right" class="main"><a href="' . tep_href_link(FILENAME_NEWSDESK_INDEX, $get_backpath) . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>' . tep_draw_separator('pixel_trans.gif', '10', '1') . '<a href="' . tep_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a></td>';
         } else {
          echo '<td align="right" class="main"><a href="' . tep_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a></td>';
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