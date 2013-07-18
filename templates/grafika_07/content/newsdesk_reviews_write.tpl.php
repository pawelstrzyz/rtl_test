<?php
/*
  $Id: \templates\standard\content\newsdesk_reviews_write.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<script type="text/javascript" language="javascript"><!--
function checkForm() {
var error = 0;
var error_message = "<?php echo JS_ERROR; ?>";
var review = document.newsdesk_reviews_write.review.value;

if (review.length < <?php echo REVIEW_TEXT_MIN_LENGTH; ?>) {
	error_message = error_message + "<?php echo JS_REVIEW_TEXT; ?>";
	error = 1;
}

if ((document.newsdesk_reviews_write.rating[0].checked) || (document.newsdesk_reviews_write.rating[1].checked) || (document.newsdesk_reviews_write.rating[2].checked) || (document.newsdesk_reviews_write.rating[3].checked) || (document.newsdesk_reviews_write.rating[4].checked)) {
} else {
	error_message = error_message + "<?php echo JS_REVIEW_RATING; ?>";
	error = 1;
}

if (error == 1) {
	alert(error_message);
	return false;
} else {
	return true;
}
}
//--></script>

<?php echo tep_draw_form('newsdesk_reviews_write', tep_href_link(FILENAME_NEWSDESK_REVIEWS_WRITE, 'action=process&newsdesk_id=' . $HTTP_GET_VARS['newsdesk_id']), 'post', 'onSubmit="return checkForm();"'); ?>

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
		<td width="100%" valign="top">
         <table border="0" width="100%" cellspacing="3" cellpadding="3">
	      <tr>
		   <td class="main" valign="top">
            <table border="0" cellspacing="0" cellpadding="0">
	         <tr>
		      <td class="main" width="50%">
			   <b><?php echo SUB_TITLE_PRODUCT; ?></b>
			   <?php echo $product_info_values['newsdesk_article_name']; ?>
		      </td>
	         </tr>
	         <tr>
		      <td class="main">
		       <b><?php echo SUB_TITLE_FROM; ?></b>
               <?php echo $customer_values['customers_firstname'] . ' ' . $customer_values['customers_lastname'];?>
		      </td>
	         </tr>
	         <tr>
		      <td class="main">
		       <b><?php echo SUB_TITLE_RATING; ?></b>
               <?php echo TEXT_BAD; ?>
               <input type="radio" name="rating" value="1">
               <input type="radio" name="rating" value="2">
               <input type="radio" name="rating" value="3">
               <input type="radio" name="rating" value="4">
               <input type="radio" name="rating" value="5">
               <?php echo TEXT_GOOD; ?>
     		  </td>
	         </tr>
            </table>
		   </td>
		   <td class="main" valign="top">
            <?php echo $insert_image; ?>
		   </td>
	      </tr>
         </table>

         <table border="0" width="100%" cellspacing="3" cellpadding="3">
	      <tr>
		   <td class="main"><b><?php echo SUB_TITLE_REVIEW; ?></b></td>
	      </tr>
	      <tr>
		   <td><?php echo tep_draw_textarea_field('review', 'soft', 60, 15);?></td>
	      </tr>
	      <tr>
		   <td class="smallText"><?php echo TEXT_NO_HTML; ?></td>
	      </tr>
         </table>
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
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
		   <td class="main">
            <?php
		    echo '<a href="' . tep_href_link(FILENAME_NEWSDESK_REVIEWS_ARTICLE, $get_params, 'NONSSL') . '">' . tep_image_button('button_reviews_list.gif', IMAGE_BUTTON_BACK) . '</a>';
            ?>
		   </td>
		   <td align="right" class="main">
		   <?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?>
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
<input type="hidden" name="get_params" value="<?php echo $get_params; ?>">
</form>