<?php
/*
  $Id: \includes\modules\newsdesk_listing.php; 10.07.2006

  mod eSklep-Os http://www.esklep-os.com
  
  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
 <tr>
  <td class="main">

   <?php
   $list_box_contents = array();
   $list_box_contents[] = array('params' => 'class="productListing-heading"');
   $cur_row = sizeof($list_box_contents) - 1;

   for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
    switch ($column_list[$col]) {
	case 'NEWSDESK_STATUS':
		$lc_text = TABLE_HEADING_STATUS;
		$lc_align = 'left';
		break;
	case 'NEWSDESK_DATE_AVAILABLE':
		$lc_text = TABLE_HEADING_DATE_AVAILABLE;
		$lc_align = 'left';
		break;
	case 'NEWSDESK_ARTICLE_NAME':
		$lc_text = TABLE_HEADING_ARTICLE_NAME;
		$lc_align = 'left';
		break;
	case 'NEWSDESK_ARTICLE_SHORTTEXT':
		$lc_text = TABLE_HEADING_ARTICLE_SHORTTEXT;
		$lc_align = 'left';
		break;
	case 'NEWSDESK_ARTICLE_DESCRIPTION':
		$lc_text = TABLE_HEADING_ARTICLE_DESCRIPTION;
		$lc_align = 'left';
		break;
	case 'NEWSDESK_ARTICLE_URL':
		$lc_text = TABLE_HEADING_ARTRICLE_URL;
		$lc_align = 'left';
		break;
	case 'NEWSDESK_ARTICLE_URL_NAME':
		$lc_text = TABLE_HEADING_ARTRICLE_URL_NAME;
		$lc_align = 'left';
		break;
	case 'NEWSDESK_IMAGE':
		$lc_text = TABLE_HEADING_IMAGE;
		$lc_align = 'left';
		break;
	case 'NEWSDESK_IMAGE_TWO':
		$lc_text = TABLE_HEADING_IMAGE;
		$lc_align = 'left';
		break;
	case 'NEWSDESK_IMAGE_THREE':
		$lc_text = TABLE_HEADING_IMAGE;
		$lc_align = 'left';
		break;
    }

    if ($column_list[$col] != 'NEWSDESK_ARTICLE_URL' && $column_list[$col] != 'NEWSDESK_ARTICLE_URL_NAME' && $column_list[$col] != 'NEWSDESK_IMAGE' && $column_list[$col] != 'NEWSDESK_IMAGE_TWO' && $column_list[$col] != 'NEWSDESK_IMAGE_THREE') // turn off links
	 $lc_text = tep_create_sort_heading($HTTP_GET_VARS['sort'], $col+1, $lc_text);
	 $list_box_contents[$cur_row][] = array(
		'align' => $lc_align,
		'params' => 'class="productListing-heading" height="25"',
		'text'  => "&nbsp;" . $lc_text . "&nbsp;"
		);
    }
	$cur_row = $cur_row + 1;
	 $list_box_contents[$cur_row][] = array(
		'text'  => ""
		);

    if ($listing_numrows > 0) {
	 $number_of_products = '0';
	 $listing_query = tep_db_query($listing_split->sql_query);
	 while ($listing_values = tep_db_fetch_array($listing_query)) {

        if ( ($number_of_products/2) == floor($number_of_products/2) ) {
			$list_box_contents[] = array('params' => 'class="productListing-even"');
		} else {
			$list_box_contents[] = array('params' => 'class="productListing-odd"');
		}

		$cur_row = sizeof($list_box_contents) - 1;
		$cl_size = sizeof($column_list);
		for ($col=0; $col<$cl_size; $col++) {
			$lc_align = '';
			switch ($column_list[$col]) {
		  case 'NEWSDESK_STATUS':
			$lc_text = '<a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, ($newsPath ? 'newsPath=' . $newsPath . '&' : '') 
			. 'newsdesk_id=' . $listing_values['newsdesk_id']) . '">' . $listing_values['newsdesk_status'] . '</a>&nbsp;';
				break;
		  case 'NEWSDESK_DATE_AVAILABLE':
			$lc_text = '' . $listing_values['newsdesk_date_added'] . '&nbsp;';
			break;
		  case 'NEWSDESK_ARTICLE_NAME':
			$lc_text = '<a class="boxLink" href="' . tep_href_link(FILENAME_NEWSDESK_INFO, ($newsPath ? 'newsPath=' . $newsPath . '&' : '')
			. 'newsdesk_id=' . $listing_values['newsdesk_id']) . '"><b>' . $listing_values['newsdesk_article_name'] . '</b></a>&nbsp;';
			break;
		  case 'NEWSDESK_ARTICLE_SHORTTEXT':
			$lc_text = '' . strip_tags($listing_values['newsdesk_article_shorttext']) . '&nbsp;';
			break;
		  case 'NEWSDESK_ARTICLE_DESCRIPTION':
			$lc_text = '<a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, ($newsPath ? 'newsPath=' . $newsPath . '&' : '') 
			. 'newsdesk_id=' . $listing_values['newsdesk_id']) . '">' . $listing_values['newsdesk_article_description'] . '</a>&nbsp;';
			break;
		  case 'NEWSDESK_ARTICLE_URL':
			$lc_text = '<a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, ($newsPath ? 'newsPath=' . $newsPath . '&' : '') 
			. 'newsdesk_id=' . $listing_values['newsdesk_id']) . '">' . $listing_values['newsdesk_article_url'] . '</a>&nbsp;';
			break;
	  	  case 'NEWSDESK_ARTICLE_URL_NAME':
			$lc_text = '<a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, ($newsPath ? 'newsPath=' . $newsPath . '&' : '') 
			. 'newsdesk_id=' . $listing_values['newsdesk_id']) . '">' . $listing_values['newsdesk_article_url_name'] . '</a>&nbsp;';
			break;
		  case 'NEWSDESK_IMAGE':
           if (($listing_values['newsdesk_image'] != '') && ($listing_values['newsdesk_image'] != 'Array')) {
			$lc_align = 'center';
			$lc_text = '<a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, ($newsPath ? 'newsPath=' . $newsPath . '&' : '') 
			. 'newsdesk_id=' . $listing_values['newsdesk_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing_values['newsdesk_image'], 
			$listing_values['newsdesk_article_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>&nbsp;';
           } else {
			$lc_align = 'center';
			$lc_text = '&nbsp;';
           }
			break;
		  case 'NEWSDESK_IMAGE_TWO':
           if (($listing_values['newsdesk_image_two'] != '') && ($listing_values['newsdesk_image_two'] != 'Array')) {
			$lc_align = 'center';
			$lc_text = '<a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, ($newsPath ? 'newsPath=' . $newsPath . '&' : '') 
			. 'newsdesk_id=' . $listing_values['newsdesk_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing_values['newsdesk_image_two'], 
			$listing_values['newsdesk_article_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>&nbsp;';
           } else {
			$lc_align = 'center';
			$lc_text = '&nbsp;';
           }
			break;
		  case 'NEWSDESK_IMAGE_THREE':
           if (($listing_values['newsdesk_image_three'] != '') && ($listing_values['newsdesk_image_three'] != 'Array')) {
			$lc_align = 'center';
			$lc_text = '<a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, ($newsPath ? 'newsPath=' . $newsPath . '&' : '') 
			. 'newsdesk_id=' . $listing_values['newsdesk_id']) . '">' . tep_image(DIR_WS_IMAGES . $listing_values['newsdesk_image_three'], 
			$listing_values['newsdesk_article_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>&nbsp;';
           } else {
			$lc_align = 'center';
			$lc_text = '&nbsp;';
           }
			break;
  		  }

		  $list_box_contents[$cur_row][] = array(
				'align' => $lc_align,
				'params' => 'class="productListing-data" valign="top" style="border-bottom: 1px solid #E7E7E7;"',
				'text'  => $lc_text . '<br>&nbsp;'
				);

		}
		$number_of_products++;
	 }
	 new tableBox($list_box_contents, true);

	} else {
	 echo '&nbsp;' . TEXT_NO_ARTICLES . '&nbsp;';
    }
?>
  </td>
 </tr>
</table>
