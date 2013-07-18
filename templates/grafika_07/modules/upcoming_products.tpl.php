<table border="0" width="100%" cellspacing="0" cellpadding="0" class="templateinfoBox">
	<tr>  
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="22" height="40"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo sprintf(TABLE_HEADING_UPCOMING_PRODUCTS); ?></td>
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_right.gif" border="0" alt="" width="16" height="40"></td>	
    </tr>
<table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <tr>
  <td>
 <tr>
  <td class="modulesBox" align="center">
   <table border="0" width="100%" cellspacing="0" cellpadding="1">
   <tr>

<?php
$tab_wys = SMALL_IMAGE_HEIGHT+10;
$tab_szer = SMALL_IMAGE_WIDTH+10;

$szerokosc = SMALL_IMAGE_WIDTH + 6;
$wysokosc = SMALL_IMAGE_HEIGHT + 7;

$row = 0;
$col = 0;

  echo '

                      <table cellspacing=0 cellpadding=0>
                       <tr><td></td></tr>
                       <tr><td height=8></td></tr>
                       <tr><td class=bg>
                            <table cellspacing=0 cellpadding=0>
                             <tr>

       ';

while ($expected = tep_db_fetch_array($expected_query)) {

    echo '

                             <td width=235 valign=top>
                                  <table border=0  cellspacing=0 cellpadding=0 width=210 align=center>
                                   <tr><td width=120 valign=top><br><b><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $expected['products_id']) . '">' . osc_trunc_string($expected['products_name'], 50, 1) . '</a></b><br><br><br><span class=ps3>'. TABLE_HEADING_DATE_EXPECTED . ':<br><b>' . tep_date_short($expected['date_expected']) .'</b></span><br><br></td>
                                   <td><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $expected['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $expected['products_image'], $expected['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></td></tr>
                                   <tr><td colspan=2 height=3></td></tr>
                                   <tr><td colspan=2><a class="ProductDescripion" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $expected["products_id"]) . '">'.tep_image_button('small_view.gif').'</a></td></tr>
                                   <tr><td colspan=2 height=6></td></tr>
                                  </table>
                                 </td>


        ';
   
    $col ++;
    if ($col > 1) {
      $col = 0;
      $row ++;
      echo '
                                   
                             </tr>
                             <tr><td colspan=3 align=center><img src=templates/grafika_07/images/m24.gif width=535 height=1></td></tr>
                             <tr>

           ';
    } else echo '<td width=1></td>';
  }


  echo '


                             </tr>                             
                            </table>




       ';
?>
   </tr>
   </table>
  </td>
 </tr>
</table>