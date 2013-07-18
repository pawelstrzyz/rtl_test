<?php
/*
  $Id: \includes\boxes\reviews.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

  $boxHeading = BOX_HEADING_REVIEWS;
  $corner_left = 'rounded';
  $corner_right = 'rounded';

  $boxLink = '<a class="boxLink" href="' . tep_href_link(FILENAME_REVIEWS) . '">' .tep_image(DIR_WS_TEMPLATES . 'images/infobox/arrow_right.gif') .'</a>';
  $box_base_name = 'reviews'; // for easy unique box template setup (added BTSv1.2)

  $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

  $random_select = "select r.reviews_id, r.reviews_rating, p.products_id, p.products_image, pd.products_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = r.products_id and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and r.approved = '1'";

  if (isset($HTTP_GET_VARS['products_id'])) {
    $random_select .= " and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'";
  }

  $random_select .= " order by r.reviews_id desc limit " . MAX_RANDOM_SELECT_REVIEWS;
  $random_product = tep_random_select($random_select);

  $boxContent = '<table border="0" cellpadding="2" cellspacing="0" width="100%"><tr><td align="center" class="boxContents">';

  if ($random_product) {

// display random review box
    $review_query = tep_db_query("select substring(reviews_text, 1, 60) as reviews_text from " . TABLE_REVIEWS_DESCRIPTION . " where reviews_id = '" . (int)$random_product['reviews_id'] . "' and languages_id = '" . (int)$languages_id . "'");

    $reviews_text = tep_db_fetch_array($review_query);
    $reviews_text = tep_break_string(tep_output_string_protected($reviews_text['reviews_text']), 15, '-<br>');

    $szerokosc = SMALL_IMAGE_WIDTH+10;
    $wysokosc = SMALL_IMAGE_HEIGHT+10;

  if ($random_product['products_image'] != ''){
		$boxContent .= '<table class="dia" cellpadding="0" cellspacing="0">';
		$boxContent .= '<tr><td width="'.$szerokosc.'" height="'.$wysokosc.'">';

    $boxContent .= '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $random_product['products_id'] . '&reviews_id=' . $random_product['reviews_id']) . '">' . tep_image(DIR_WS_IMAGES . $random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>';

		$boxContent .= '</td></tr></table>';
  }

    $boxContent .= '</td></tr><tr><td>'.tep_draw_separator('pixel_trans.gif', '100%', '5').'</td></tr><tr><td class="smallText" align="center">';
    $boxContent .= '<a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $random_product['products_id'] . '&reviews_id=' . $random_product['reviews_id']) . '">' . $reviews_text . ' ..</a>';
    $boxContent .= '</td></tr><tr><td class="smallText" align="center">';
    $boxContent .= tep_image(DIR_WS_TEMPLATES . 'images/misc/stars_' . $random_product['reviews_rating'] . '.gif' , sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $random_product['reviews_rating'])) . '';

  } elseif (isset($HTTP_GET_VARS['products_id'])) {

// display 'write a review' box
    $boxContent .= '<table border="0" cellspacing="0" cellpadding="2"><tr><td class="boxContents"><a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'products_id=' . $HTTP_GET_VARS['products_id']) . '">' . tep_image(DIR_WS_TEMPLATES . 'images/misc/box_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a></td><td class="boxContents"><a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'products_id=' . $HTTP_GET_VARS['products_id']) . '">' . BOX_REVIEWS_WRITE_REVIEW .'</a></td></tr></table>';

  } else {

// display 'no reviews' box

    $boxContent .= BOX_REVIEWS_NO_REVIEWS;

  }

$boxContent .= '</td></tr></table>';

include (bts_select('boxes', $box_base_name)); // BTS 1.5

$boxLink = '';

?>