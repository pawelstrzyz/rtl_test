<?php
/*
  $Id: \templates\standard\content\product_reviews_write.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('product_reviews_write', tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'action=process&products_id=' . $HTTP_GET_VARS['products_id']), 'post', 'onSubmit="return checkForm();"'); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
	<tr>  
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="22" height="40"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo HEADING_PRODUCT_REVIEWS; ?></td>
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_right.gif" border="0" alt="" width="16" height="40"></td>	
	</tr> 
 </table></td>
      </tr>	  
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <!-- Naglowek BOF -->

 <tr>
  <td>
   <table width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
      <table width="100%" cellspacing="0" cellpadding="0">
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>
       
	   <?php
       if ($messageStack->size('review') > 0) {
       ?>
       <tr>
        <td><?php echo $messageStack->output('review'); ?></td>
       </tr>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>
       <?php
       }
       ?>
  
	   <tr>
        <td>
         <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
           <td valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
             <tr>
              <td class="main"><?php echo '<b>' . SUB_TITLE_FROM . '</b> ' . tep_output_string_protected($customer['customers_firstname'] . ' ' . $customer['customers_lastname']); ?></td>
             </tr>
             <tr>
              <td class="main"><b><?php echo SUB_TITLE_REVIEW; ?></b></td>
             </tr>
             <tr>
              <td align="left" width="100%" valign="top">
               <table border="0" cellspacing="0" cellpadding="0" align="left" width="100%">
                <tr>
                 <td align="left" class="ProductInfoTile">
                  <?php echo $products_name; ?>
                 </td>
                </tr>
                <tr>
                 <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>
                </tr>
                <tr>
                 <td class="smallText"><b><?php echo (($product_info['products_price'] > 0) ? ITEM_PRICE :''); ?></b>&nbsp;<span class="PriceRetailProduct"><?php echo (($product_info['products_price'] > 0) ? $products_price : ''); ?></span></td>
                </tr>
               </table>
              </td>
             </tr>
             <tr>
              <td class="main"><?php echo tep_draw_textarea_field('review', 'soft', 48, 8); ?></td>
             </tr>
             <tr>
              <td class="smallText" align="left"><?php echo TEXT_NO_HTML; ?></td>
             </tr>
             <tr>
              <td class="main"><?php echo '<b>' . SUB_TITLE_RATING . '</b> ' . TEXT_BAD . ' ' . tep_draw_radio_field('rating', '1') . ' ' . tep_draw_radio_field('rating', '2') . ' ' . tep_draw_radio_field('rating', '3') . ' ' . tep_draw_radio_field('rating', '4') . ' ' . tep_draw_radio_field('rating', '5') . ' ' . TEXT_GOOD; ?></td>
             </tr>
             </tr>
             <tr>
              <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
             </tr>
            </table>
           </td>
           <td width="<?php echo SMALL_IMAGE_WIDTH + 20; ?>" align="right" valign="top">
            <table border="0" cellspacing="0" cellpadding="3">
             <tr>
              <td align="center" class="smallText">
               <?php
               if (tep_not_null($product_info['products_image'])) {
               ?>
               <script language="javascript" type="text/javascript"><!--
               document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'pID=' . $product_info['products_id']) . '\\\')">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"') . '<br>' . TEXT_CLICK_TO_ENLARGE . '</a>'; ?>');
               //--></script>
               <noscript>
               <?php echo '<a class="boxLink" href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image']) . '" target="_blank">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], $product_info['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"') . '<br>' . TEXT_CLICK_TO_ENLARGE . '</a>'; ?>
               </noscript>
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
      </table>
     </td>
    </tr>
   </table>
  </td>
 </tr>


 <!-- // BOF Anti Robot Registration v2.2-->
 <?php
 if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'product_reviews_write') &&  ACCOUNT_REVIEWS_VALIDATION == 'true') {
 ?>
 <tr>
  <td class="main"><b><?php echo CATEGORY_ANTIROBOTREG; ?></b></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
      <table align="left" border="0" cellspacing="2" cellpadding="2" width="100%">
       <?php
     if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'product_reviews_write') &&  ACCOUNT_REVIEWS_VALIDATION == 'true') {
      if ($is_read_only == false || (strstr($PHP_SELF,'account_edit')) ) {
        $sql = "DELETE FROM " . TABLE_ANTI_ROBOT_REGISTRATION . " WHERE timestamp < '" . (time() - 3600) . "' OR session_id = '" . tep_session_id() . "'";
        if( !$result = tep_db_query($sql) ) { die('Could not delete validation key'); }
        $reg_key = gen_reg_key();
        $sql = "INSERT INTO ". TABLE_ANTI_ROBOT_REGISTRATION . " VALUES ('" . tep_session_id() . "', '" . $reg_key . "', '" . time() . "')";
        if( !$result = tep_db_query($sql) ) { die('Could not check registration information'); }
         ?>
         <tr>
          <td class="main">
           <table align="center" border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr>
             <td class="main" width="100%" NOWRAP><span class="main"><?php echo ENTRY_ANTIROBOTREG; ?></span></td>
             <td class="main" width="200" align="left">
              <?php
          $check_anti_robotreg_query = tep_db_query("select session_id, reg_key, timestamp from anti_robotreg where session_id = '" . tep_session_id() . "'");
          $new_guery_anti_robotreg = tep_db_fetch_array($check_anti_robotreg_query);
          $validation_images = '<img src="validation_png.php?rsid=' . $new_guery_anti_robotreg['session_id'] . '">';
          if ($entry_antirobotreg_error == true) {
?>
<span>
<?php
            echo $validation_images . ' <br>&nbsp;';
            echo tep_draw_input_field('antirobotreg') . '';
          } else {
?>
<span>
<?php
            echo $validation_images . ' <br>&nbsp;';
            echo tep_draw_input_field('antirobotreg', $account['entry_antirobotreg']) . '&nbsp;' . ENTRY_ANTIROBOTREG_TEXT;
              }
              ?>
             </td>
            </tr>
           </table>
          </td>
         </tr>
         <?php
         }
         ?>
        <?php
        }
        ?>
       </table>
      </td>
    </tr>
   </table>
  </td>
 </tr>
 <?php
 }
 ?>
 <!-- // EOF Anti Robot Registration v2.2-->

 <!-- Przyciski BOF -->
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
 </tr>
 <tr>
  <td colspan="2">
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params(array('reviews_id', 'action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
        <td class="main" align="right"><?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
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