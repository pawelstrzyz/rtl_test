<table border="0" width="100%" cellspacing="0" cellpadding="0" class="templateinfoBox">
	<tr>  
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo sprintf(TABLE_HEADING_UPCOMING_PRODUCTS); ?></td>
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_left.gif" border="0" alt="" width="30" height="35"></td>	
    </tr>
<table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <tr>
  <td>
 <tr>
  <td class="main" align="center">
   <table border="0" width="100%" cellspacing="0" cellpadding="1">
   <tr>

<?php
$tab_wys = SMALL_IMAGE_HEIGHT+10;
$tab_szer = SMALL_IMAGE_WIDTH+10;

$szerokosc = SMALL_IMAGE_WIDTH + 6;
$wysokosc = SMALL_IMAGE_HEIGHT + 7;

$row = 0;
$col = 1;
$info_box_contents = array();


while ($expected = tep_db_fetch_array($expected_query)) {

    echo '
    <td width="'.$szer_tab.'%" align="center" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="TableFrame">
       <tr>
        <td>
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
             <td align="center" valign="top" height="35">
              <a class="ProductTile" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $expected['products_id']) . '">' . osc_trunc_string($expected['products_name'], 50, 1) . '</a>
             </td>
            </tr>
            <tr>
             <td align="center" valign="middle">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
               <td align="center" valign="top">'.
	            (isset($expected['products_image']) ? '
                <div style="border: 0px; width: '.$szerokosc.'px; height: '.$wysokosc.'px; padding: 0px 0px;"><table border="0" cellpadding="0" cellspacing="0"><tr>
                <td class="t1"></td>
                <td class="t2"></td>
                <td class="t3"></td>
                </tr><tr>
                <td class="t4"></td>
                <td class="t5" align="center" valign="middle" height="'.SMALL_IMAGE_HEIGHT.'"  width="'.SMALL_IMAGE_WIDTH.'">
                 <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $expected['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $expected['products_image'], $expected['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>
                </td><td class="t6"></td>
                 </tr><tr>
                 <td class="t7"></td>
                 <td class="t8"></td>
                 <td class="t9"></td>
                 </tr></table></div>' : '').'
                </td></tr><tr><td>'.tep_draw_separator('pixel_trans.gif', '100%', '5').'</td></tr><tr>
                <td  align="center" valign="middle"><span class="smallText">'. TABLE_HEADING_DATE_EXPECTED . ':<br><b>' . tep_date_short($expected['date_expected']) .'</b></span></td>
               </tr>
              </table>
             </td>
            </tr>
            <tr>
             <td align="center">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
                <td align="center" width="100%" height="28" class="Button"><a class="ProductDescripion" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $expected["products_id"]) . '">'.tep_image_button('small_view.gif').'</a></td>
               </tr>
            </table>
             </td>
            </tr>
         </table>
        </td>
       </tr>
      </table>
    </td>';

    $col ++;
    if ($col > $ilosc_col) {
		$span= 0;
        $col = 1;
        $row ++;
		    $span = ($ilosc_col * 2) - 1;
        if ($row < $max_wiersz) {
          echo '
          </tr>
          <tr>
           <td colspan="'.$span.'" width="100%" height="5"></td>
          </tr>
          <tr>';
        } else {
          echo '
          '
          ;
        }
	  } else {
		echo '
        <td width="5" height="100%">'.tep_draw_separator('pixel_trans.gif', '5', '1').'</td>';
    }
}
?>
   </tr>
   </table>
  </td>
 </tr>
</table>