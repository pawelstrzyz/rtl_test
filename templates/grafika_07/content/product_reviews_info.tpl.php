<?php
/*
  $Id: \templates\standard\content\product_reviews_info.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
	<tr>  
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="22" height="40"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo HEADING_TITLE; ?></td>
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_right.gif" border="0" alt="" width="16" height="40"></td>	
	</tr>
 </table></td>
      </tr>	  
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <!-- Naglowek EOF -->

 <tr>
  <td>
   <table border="0"  width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td  valign="top"><b><?php echo $products_name; ?></b></td>
	      <td align="right" valign="MIDDLE"><span class="Cena"><?php echo (($review['products_price'] > 0) ? $products_price : ''); ?></span></td>
       </tr>
      </table>
     </td>
	  </tr>
   </table>
  </td>
 </tr>

 <tr>
  <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
 </tr>

 <tr>
  <td>
   <table border=0" width="100%" cellspacing="0" cellpadding="2">
    <tr>
     <td class="main"><?php echo '<b>' . sprintf(TEXT_REVIEW_BY, tep_output_string_protected($review['customers_name'])) . '</b>'; ?></td>
     <td class="smallText" align="right"><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, tep_date_long($review['date_added'])); ?></td>
    </tr>
   </table>
  </td>
 </tr>
 
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td valign="top" class="main"><?php echo tep_break_string(nl2br(tep_output_string_protected($review['reviews_text'])), 60, '-<br>') . '<br><br><i>' . sprintf(TEXT_REVIEW_RATING, tep_image(DIR_WS_TEMPLATES . 'images/misc/stars_' . $review['reviews_rating'] . '.gif', sprintf(TEXT_OF_5_STARS, $review['reviews_rating'])), sprintf(TEXT_OF_5_STARS, $review['reviews_rating'])) . '</i>'; ?></td>
        <td width="10" align="right">
		 <TABLE border="0" width="<?php echo SMALL_IMAGE_WIDTH + 20; ?>" cellspacing="0" cellpadding="2">
		  <TR>
		   <td width="<?php echo SMALL_IMAGE_WIDTH + 20; ?>" align="right" valign="top">
		    <table border="0" cellspacing="0" cellpadding="3">
		     <tr>
		      <td align="center" class="smallText">
			   <?php
			   if (tep_not_null($review['products_image'])) {
			   ?>
			   <script language="javascript" type="text/javascript"><!--
			   document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'pID=' . $review['products_id']) . '\\\')">' . tep_image(DIR_WS_IMAGES . $review['products_image'], addslashes($review['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"') . '<br>' . TEXT_CLICK_TO_ENLARGE . '</a>'; ?>');
			   //--></script>
			   <noscript>
			   <?php echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $review['products_image']) . '" target="_blank">' . tep_image(DIR_WS_IMAGES . $review['products_image'], $review['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"') . '<br>' . TEXT_CLICK_TO_ENLARGE . '</a>'; ?>
			   </noscript>
			   <?php
			   }
			   echo '</td></tr><tr><td align="center" class=main" valign="middle">';
//			   echo '<a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now') . '">' . (($review['products_price'] > 0) ?   tep_image_button('button_in_cart.gif', IMAGE_BUTTON_IN_CART) : '') . '</a>'; 
// Begin Buy Now button mod
 echo '<form name="buy_now" method="post" action="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now', 'NONSSL') . '"><input type="hidden" name="products_id" value="' . $review['products_id'] . '">' . tep_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART) . ' </form>';
// End Buy Now button mod
			   ?>
		      </td>
		     </tr>
		    </table>
		   </td>
		  </TR>
		 </TABLE>
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
        <td class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params(array('reviews_id'))) . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
        <td class="main" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params(array('reviews_id'))) . '">' . tep_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a>'; ?></td>
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