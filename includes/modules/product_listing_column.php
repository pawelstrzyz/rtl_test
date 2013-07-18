<?php
/*
  $Id: \includes\modules\products_listing.php; 04.07.2006

  mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

$szerokosc = ALLPROD_IMAGE_WIDTH + 6;
$wysokosc = ALLPROD_IMAGE_HEIGHT + 7;

  $listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');

  if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
  ?>
  <table border="0" width="100%" cellspacing="0" cellpadding="2">
   <tr>
    <td class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
    <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
   </tr>
  </table>
  <?php
  }

// ****************************************************************************  

 if ($listing_split->number_of_rows > 0) {
 
        // Wyswietlanie wszystkich produktow w kolumnach i wierszach
        $query_special_prices_hide_result = SPECIAL_PRICES_HIDE;
        $special_hide = $query_special_prices_hide_result;

        $modules_template = 'product_listing_col';
//        $ilosc_col = MAX_DISPLAY_COLUMN_PRODUCTS_LISTING;
        $ilosc_col = 3;
        $max_display = MAX_DISPLAY_PAGE_LINKS;
        $max_wiersz =  $max_display/$ilosc_col;

        $szer_tab = round(100/$ilosc_col,0) ;

        $listing_query = tep_db_query($listing_split->sql_query); 
  
        ?>

        <!-- new_products //-->
        <table border="0" width="100%" cellspacing="0" cellpadding="0" class="templateinfoBox">
            <tr>
                <td class="main">
                    <table border="0" width="100%" cellspacing="0" cellpadding="1">
                        <?php
                        include (bts_select('modules', $modules_template));
                        ?>
                    </table>
                </td>
            </tr>
        </table>
        <?php
  } else {

    $list_box_contents = array();

    $list_box_contents[0] = array('params' => 'class="productListing-odd"');
    $list_box_contents[0][] = array('params' => 'class="productListing-data"',
                                   'text' => TEXT_NO_PRODUCTS);

    new productListingBox($list_box_contents);
  }

  if ( ($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
  ?>
  <table border="0" width="100%" cellspacing="0" cellpadding="2">
   <tr>
    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '7'); ?></td>
   </tr>
   <?php   if (PRODUCTS_LISTING_DISPLAY_MODE=='true') { ?>
   <tr>
    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
   </tr>
   <?php } ?>
   <tr>
    <td class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
    <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
   </tr>
  </table>
  <?php
  }
  ?>