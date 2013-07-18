<?php
/*
  $Id: \templates\standard\content\newsdesk_reviews_article.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
 <tr>
  <td>
   <?php
   $info_box_contents = array();
   $info_box_contents[] = array('text' => sprintf(HEADING_TITLE, $product_info_values['newsdesk_article_name']));
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
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td class="tableHeading"><?php echo TABLE_HEADING_NUMBER; ?></td>
        <td class="tableHeading"><?php echo TABLE_HEADING_AUTHOR; ?></td>
        <td align="center" class="tableHeading"><?php echo TABLE_HEADING_RATING; ?></td>
        <td align="center" class="tableHeading"><?php echo TABLE_HEADING_READ; ?></td>
        <td align="right" class="tableHeading"><?php echo TABLE_HEADING_DATE_ADDED; ?></td>
       </tr>
       <tr>
        <td colspan="5"><?php echo tep_draw_separator(); ?></td>
       </tr>

       <?php
       $reviews = tep_db_query("select reviews_rating, reviews_id, customers_name, date_added, last_modified, reviews_read from " . TABLE_NEWSDESK_REVIEWS . " where newsdesk_id = '" . $HTTP_GET_VARS['newsdesk_id'] . "' order by reviews_id DESC");

       if (tep_db_num_rows($reviews)) {
        $row = 0;
        while ($reviews_values = tep_db_fetch_array($reviews)) {
         $row++;
         if (strlen($row) < 2) {
          $row = '0' . $row;
         }
         $date_added = tep_date_short($reviews_values['date_added']);
         if (($row / 2) == floor($row / 2)) {
          echo '<tr class="productReviews-even">' . "\n";
         } else {
          echo '<tr class="productReviews-odd">' . "\n";
         }
         echo ' <td class="smallText">' . $row . '.</td>' . "\n";
         echo ' <td class="smallText"><a href="' . tep_href_link(FILENAME_NEWSDESK_REVIEWS_INFO, $get_params . '&reviews_id=' . $reviews_values['reviews_id'], 'NONSSL') . '">' . $reviews_values['customers_name'] . '</a></td>' . "\n";
         echo ' <td align="center" class="smallText">' . tep_image(DIR_WS_TEMPLATES . 'images/misc/stars_' . $reviews_values['reviews_rating'] . '.gif', sprintf(TEXT_OF_5_STARS, $reviews_values['reviews_rating'])) . '</td>' . "\n";
         echo ' <td align="center" class="smallText">' . $reviews_values['reviews_read'] . '</td>' . "\n";
         echo ' <td align="right" class="smallText">' . $date_added . '</td>' . "\n";
         echo ' </tr>' . "\n";
        }
       } else {
       ?>
       <tr class="productReviews-odd">
        <td colspan="5" class="smallText"><?php echo TEXT_NO_REVIEWS; ?></td>
       </tr>
       <?php
       }
       ?>
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
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td align="left" class="main">
        <?php
        echo '<a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, $get_params_back, 'NONSSL') . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>';
        ?>
        </td>
        <td align="right" class="main">
        <?php 
        echo '<a href="' . tep_href_link(FILENAME_NEWSDESK_REVIEWS_WRITE, $get_params, 'NONSSL') . '">' . tep_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a>';
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
 <!-- Przyciski EOF -->

</table>