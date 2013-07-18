<?php
/*
  $Id: \templates\standard\content\products_new.tpl.php; 24.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
	<tr>  
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="22" height="40"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php  echo HEADING_TITLE; ?></td>
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_right.gif" border="0" alt="" width="16" height="40"></td>	
	</tr>
 </table></td>
      </tr>	  
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <!-- Naglowek EOF -->
 <tr>
  <td align="center" class="smallText"><?php $firstletter_nav=
        '<a href="' . tep_href_link("allprods.php",  'fl=A', 'NONSSL') . '"> A |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=B', 'NONSSL') . '"> B |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=C', 'NONSSL') . '"> C |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=D', 'NONSSL') . '"> D |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=E', 'NONSSL') . '"> E |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=F', 'NONSSL') . '"> F |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=G', 'NONSSL') . '"> G |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=H', 'NONSSL') . '"> H |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=I', 'NONSSL') . '"> I |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=J', 'NONSSL') . '"> J |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=K', 'NONSSL') . '"> K |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=L', 'NONSSL') . '"> L |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=M', 'NONSSL') . '"> M |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=N', 'NONSSL') . '"> N |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=O', 'NONSSL') . '"> O |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=P', 'NONSSL') . '"> P |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=Q', 'NONSSL') . '"> Q |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=R', 'NONSSL') . '"> R |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=S', 'NONSSL') . '"> S |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=T', 'NONSSL') . '"> T |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=U', 'NONSSL') . '"> U |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=V', 'NONSSL') . '"> V |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=W', 'NONSSL') . '"> W |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=X', 'NONSSL') . '"> X |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=Y', 'NONSSL') . '"> Y |</A>' .
        '<a href="' . tep_href_link("allprods.php",  'fl=Z', 'NONSSL') . '"> Z</A>&nbsp;&nbsp;'   .
        '<a href="' . tep_href_link("allprods.php",  '',     'NONSSL') . '"> FULL</A>';
        
        echo $firstletter_nav; ?>
  </td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
 </tr>
 <tr>
  <td>
   <?php
   // create column list
   $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                      'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                      'PRODUCT_LIST_DESCRIPTION' => PRODUCT_LIST_DESCRIPTION,
                      'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
 						          'PRODUCT_LIST_RETAIL_PRICE' => PRODUCT_LIST_RETAIL_PRICE, //EZier new field mods by Noel
                      'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
						          'PRODUCT_LIST_SAVE' => PRODUCT_LIST_SAVE, //EZier new field mod by Noel
                      'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                      'PRODUCT_LIST_MAXORDER' => PRODUCT_LIST_MAXORDER,
                      'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                      'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                      'PRODUCT_LIST_PRODUCTS_AVAILABILITY' => PRODUCT_LIST_PRODUCTS_AVAILABILITY,
                      'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);
   asort($define_list);

   $column_list = array();
   reset($define_list);
   while (list($column, $value) = each($define_list)) {
    if ($value) $column_list[] = $column;
   }

   $select_column_list = '';

   for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
      switch ($column_list[$i]) {
        case 'PRODUCT_LIST_MODEL':
          $select_column_list .= 'p.products_model, ';
          break;
        case 'PRODUCT_LIST_NAME':
          $select_column_list .= 'pd.products_name, ';
          break;
          case 'PRODUCT_LIST_DESCRIPTION':
 	        $select_column_list .= 'pd.products_description, ';
          break;
        case 'PRODUCT_LIST_QUANTITY':
          $select_column_list .= 'p.products_quantity, ';
          break;
        case 'PRODUCT_LIST_MAXORDER':
          $select_column_list .= 'p.products_maxorder, ';
          break;
        case 'PRODUCT_LIST_IMAGE':
          $select_column_list .= 'p.products_image, ';
          break;
        case 'PRODUCT_LIST_WEIGHT':
          $select_column_list .= 'p.products_weight, ';
          break;
        case 'PRODUCT_LIST_PRODUCTS_AVAILABILITY':
          $select_column_list .= 'p.products_availability_id, ';
          break;
      }
    }

   // listing all products
   $listing_sql = "select " . $select_column_list . " m.manufacturers_name, p.products_id, p.manufacturers_id, p.products_quantity, p.products_retail_price, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from (((" . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p) left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c) left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id) left join " . TABLE_CATEGORIES . " c on c.categories_id = p2c.categories_id where c.categories_status = '1' and $where and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' ORDER BY pd.products_name";

   include($modules_folder . 'product_listing.php');

  ?>
  </td>
 </tr>
</table>