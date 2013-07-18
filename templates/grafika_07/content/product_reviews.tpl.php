<table border="0" width="100%" cellspacing="0" cellpadding="0">
 <tbody>

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
 <!-- Naglowek EOF -->

 <tr>
  <td>
   <table width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
      <table width="100%" cellspacing="0" cellpadding="0">
       <tr>
         <td>
          <table width="100%" border="0" cellspacing="0" cellpadding="2">

           <tr>
            <td align="center" valign="middle" class="ProductInfoTile">
             <?php echo $products_name; ?>
            </td>

 			<?php
			$szerokosc = SMALL_IMAGE_WIDTH+20;
			?>
            <td align="right" valign="middle">
             <!-- zdjecie -->
             <table border="0" cellspacing="0" cellpadding="2" width="<?php echo $szerokosc; ?>">
              <tr>
               <td align="center" class="smallText">
                <?php
                if (tep_not_null($product_info['products_image'])) {
                ?>
                <script language="javascript" type="text/javascript"><!--
                document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'pID=' . $product_info['products_id']) . '\\\')">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"') . '<br>' . TEXT_CLICK_TO_ENLARGE . '</a>'; ?>');
                //--></script>
                <noscript>
                 <?php echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image']) . '" target="_blank">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], $product_info['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"') . '<br>' . TEXT_CLICK_TO_ENLARGE . '</a>'; ?>
                </noscript>
                <?php
                }
                ?>
               </td>
              </tr>
             </table>
              <!-- koniec zdjecia -->
            </td>

		   </tr>

           <tr>
            <!-- opis start -->
            <td align="left" valign="top" colspan="4">
             <table border="0" cellspacing="0" cellpadding="2" align="left" width="100%">
              <tr>
               <td><span class="smallText"><?php echo (($product_info['products_price'] > 0) ? ITEM_PRICE :'');  ?></span>&nbsp;<span class="PriceRetailProduct"><B><?php echo (($product_info['products_price'] > 0) ? $products_price : ''); ?></B></span></td>
              </tr>
              <tr>
               <td class="tableBottomBorder"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
              </tr>
              <tr>
               <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>
              </tr>
              <tr>
               <td class="main"><?php echo stripslashes($product_info['products_description']); ?></td>
              </tr>
             </table>
            </td>
            <!-- koniec opisu -->
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

  <tr>
   <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
  </tr>

  <tr>
   <td>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
     <tr>
      <td class="main"><b><?php echo HEADING_PRODUCT_REVIEWS; ?></b></td>
     </tr>
    </table>
   </td>
  </tr>
  
  <tr>
   <td>
    <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
     <tr class="infoBoxContents">
      <td>
       <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
         <td valign="top">

		  <!-- opinie -->
          <table border="0" width="100%" cellspacing="0" cellpadding="2">
           <tbody>
            <?php
            $reviews_query_raw = "select r.reviews_id, left(rd.reviews_text, 100) as reviews_text, r.reviews_rating, r.date_added, r.customers_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.products_id = '" . (int)$product_info['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' order by r.reviews_id desc";
            $reviews_split = new splitPageResults($reviews_query_raw, MAX_DISPLAY_NEW_REVIEWS);

            if ($reviews_split->number_of_rows > 0) {
             if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) {
             ?>
              <tr>
               <td>
                <table border="0" width="100%" cellspacing="0" cellpadding="2">
                 <tbody>
                  <tr>
                   <td class="smallText"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
                   <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></td>
                  </tr>
                 </tbody>
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
                 <tbody>
                  <tr>
                   <td class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $product_info['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '"><u><b>' . sprintf(TEXT_REVIEW_BY, tep_output_string_protected($reviews['customers_name'])) . '</b></u></a>'; ?></td>
                   <td class="smallText" align="right"><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, tep_date_long($reviews['date_added'])); ?></td>
                  </tr>
                 </tbody>
                </table>
               </td>
              </tr>
              <tr>
               <td>
                <table border="0" width="100%" cellspacing="1" cellpadding="2">
                 <tbody>
                  <tr class="infoBoxContents">
                   <td>
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                     <tbody>
                      <tr>
                       <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                       <td valign="top" class="main"><?php echo tep_break_string(tep_output_string_protected($reviews['reviews_text']), 60, '-<br>') . ((strlen($reviews['reviews_text']) >= 100) ? '..' : '') . '<br><br><i>' . sprintf(TEXT_REVIEW_RATING, tep_image(DIR_WS_TEMPLATES . 'images/misc/stars_' . $reviews['reviews_rating'] . '.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])), sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])) . '</i>'; ?></td>
                       <td width="10" align="right"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
                     </tbody>
                    </table>
                   </td>
                  </tr>
                 </tbody>
                </table>
               </td>
              </tr>
              <tr>
               <td class="tableBottomBorder"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
              </tr>
              <?php
             }
            } else {
             ?>
             <tr>
              <td><?php new infoBox(array(array('text' => TEXT_NO_REVIEWS))); ?></td>
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
                <tbody>
                 <tr>
                  <td class="smallText"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
                  <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></td>
                 </tr>
                </tbody>
               </table>
              </td>
             </tr>
             <?php
            }
            ?>
            </tbody>
           </table>
          </td>
         </tr>
        </tbody>
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
        <tbody>
         <tr>
          <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
          <td class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params()) . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
          <td class="main" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params()) . '">' . tep_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a>'; ?></td>
          <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
         </tr>
        </tbody>
       </table>
      </td>
     </tr>
    </table>
   </td>
  </tr>
 <!-- Przyciski EOF -->
  <tr><td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td></tr>

 </tbody>
</table>
