<?php
/*
  $Id: \templates\standard\content\ask_a_question.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>


<!-- body_text //-->
 <table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>  
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo HEADING_TITLE; ?></td>
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_left.gif" border="0" alt="" width="30" height="35"></td>	
	</tr> 
 </table></td>
      </tr>	  
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>

      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_INFORMATION; ?> [<?php echo strftime(DATE_FORMAT_LONG).' '.$czas; ?>]</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<tr>
<td>
<table>
<b>
<tr>
<td class="main" align="center" width="35%"><b><?php echo TEXT_KAT; ?></b></td>
<td class="main" align="center" width="45%"><b><?php echo TEXT_NAZ; ?></b></td>
<td class="main" align="center" width="10%"><b><?php echo TEXT_CEN; ?></b></td>
<td class="main" align="center" width="10%"><b><?php echo TEXT_ZNI; ?></b></td>
</tr>
</b>
<?php


$result=mysql_query("SELECT p.products_id, cd.categories_name, pd.products_name, p.products_price, p.products_tax_class_id
FROM products p, products_description pd, categories_description cd , products_to_categories ptc
WHERE p.products_id = ptc.products_id
AND ptc.categories_id = cd.categories_id
AND p.products_id = pd.products_id
AND products_status='1'
AND pd.language_id= '$languages_id'
AND cd.language_id='$languages_id'
ORDER BY cd.categories_name, pd.products_name");

while($row = mysql_fetch_array($result)){
$kategoria = $row["categories_name"];
$nazwa = $row["products_name"];
$idd=$row["products_id"];
$cena1 = $row["products_price"];
$products_tax_class_id = $row["products_tax_class_id"];


 $zapytanie="select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and p.products_id = '$idd' and p.products_id = s.products_id and pd.products_id = s.products_id and pd.language_id = '$languages_id' and s.status = '1'";

$wykonaj = mysql_query($zapytanie);
while($wiersz = mysql_fetch_array($wykonaj)){ 
$specials_new_products_price = $wiersz["specials_new_products_price"];
$expires_date = $wiersz["expires_date"];
$products_tax_class_id = $wiersz["products_tax_class_id"];
}
if ($products_tax_class_id != ''){
$zapytanie="select * from ".TABLE_TAX_RATES." where tax_class_id = '$products_tax_class_id'";
$wykonaj = mysql_query($zapytanie);
while($wiersz = mysql_fetch_array($wykonaj)){ 
$tax_rate = $wiersz["tax_rate"];

if ($tax_rate !=''){
$tax_rate = 1 + ($tax_rate/100);
$specials_new_products_price = $specials_new_products_price * $tax_rate;
$cena = $cena1 * $tax_rate;
}
else
	{
$cena = $cena1;
}
}
}
echo "<tr class=\"smallText\">";
echo "<td class=\"smallText\" valign=\"top\">" . $kategoria . "</td>\n";
echo "<td class=\"smallText\" valign=\"top\"><a href=" . tep_href_link(FILENAME_PRODUCT_INFO . '?products_id=' . $idd, '', 'NONSSL') . ">" . $nazwa . "</a></td>\n";
printf("<td class=\"smallText\" align=\"right\" valign=\"top\"> %.2f </td>\n", round($cena,2));
if ($specials_new_products_price == 0){
$specials_new_products_price = '';
echo "<td class=\"smallText\" valign=\"top\">&nbsp;</td>";
}
else{
printf("<td class=\"smallText\" align=\"right\" valign=\"top\"><font color=red> %.2f </font></td>\n", round($specials_new_products_price,2));
}
echo "</tr>";      
$specials_new_products_price='';
}

?>
</table>

</tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>

      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>