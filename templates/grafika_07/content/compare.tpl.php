<?php
/*
  $Id: \templates\standard\content\compare.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('compare', tep_href_link(FILENAME_COMPARE_CART, tep_get_all_get_params(array('action')) . 'action=update_comp_product')); ?>

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

 <?php
 if ($comp_cart->count_comp_contents() > 0) {
  $szerokosc = SMALL_IMAGE_WIDTH + 16;
  $wysokosc = SMALL_IMAGE_HEIGHT + 16;

 ?>
 <tr>
  <td>
   <?php
    $info_box_contents = array();
    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_REMOVE);

    $info_box_contents[0][] = array('params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_PRODUCTS);

    $info_box_contents[0][] = array('align' => 'right',
                                    'params' => 'class="productListing-heading"',
                                    'text' => TABLE_HEADING_TOTAL);

    $any_out_of_stock = 0;
    $products = $comp_cart->get_comp_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
     if (($i/2) == floor($i/2)) {
      $info_box_contents[] = array('params' => 'class="productListing-even"');
     } else {
      $info_box_contents[] = array('params' => 'class="productListing-odd"');
     }

     $cur_row = sizeof($info_box_contents) - 1;

     $info_box_contents[$cur_row][] = array('align' => 'center',
                                            'params' => 'class="productListing-data" valign="top"',
                                            'text' => tep_draw_checkbox_field('cart_comp_delete[]', $products[$i]['id']) . tep_draw_hidden_field('products_id[]', $products[$i]['id']));

     $products_name = '<table border="0" cellspacing="0" cellpadding="2" width="100%">' .
                                 ' <tr>' .
                                 '  <td class="productListing-data" align="center">'.(isset($products[$i]['image']) ? '<div style="border: 0px; width: '.$szerokosc.'px; height: '.$wysokosc.'px; padding: 0px 0px;"><table border="0" cellpadding="0" cellspacing="0" width="'.$szerokosc.'" height="'.$wysokosc.'"><tr><td class="t1"></td><td class="t2"></td><td class="t3"></td></tr><tr><td class="t4"></td><td class="t5" align="center" valign="middle" ><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">' . tep_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></td><td class="t6"></td></tr><tr><td class="t7"></td><td class="t8"></td><td class="t9"></td></tr></table></div>' : '').'</td>' .
                                 '  <td class="productListing-data" valign="top"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '"><b>' . $products[$i]['name'] . '</b></a><br>'.$products[$i]['description'].'';

     $products_name .= '  </td>' .
                                  '</tr>' .
                                 '</table>';

     $info_box_contents[$cur_row][] = array('params' => 'class="productListing-data"',
                                             'text' => $products_name);


     //TotalB2B start
     $info_box_contents[$cur_row][] = array('align' => 'right',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => '<b>' . $currencies->display_price_nodiscount($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) . '</b>');
    }
    //TotalB2B end

    new productCompareBox($info_box_contents);
  ?>
  </td>
 </tr>
 
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
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
	  <table border="0" cellspacing="0" cellpadding="2" align="left">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main"><?php echo tep_image_submit('button_update_compare.gif', REMOVE_COMPARE_PRODUCT); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 <!-- Przyciski EOF -->

 <?php
 } else {
 ?>
 
 <tr>
  <td align="center" class="main"><?php new infoBox(array(array('text' => TEXT_CART_EMPTY))); ?></td>
 </tr>

 <!-- Przyciski BOF -->
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td align="right" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 <!-- Przyciski BOF -->

 <?php
 }
 ?>
</table>
</form>