<?php
?>
<script Language="JavaScript1.1"  type="text/javascript">
  charset = '<?php echo CHARSET; ?>';
  tytul = '<?php echo str_replace('\'','',$products_name); ?>';
	model = '<?php echo $product_info[products_model]; ?>';
	ilosc = '<?php echo $product_info[products_quantity]; ?>';

	<?php
	$opis = str_replace("\r", ' ', $product_info[products_description]);
  $opis = str_replace("\n", '<br />', $opis);
	$opis = strip_tags($opis);

	?>
	opis = '<?php echo $opis; ?>';

	<?php
		$extra_fields_query = tep_db_query("
		SELECT pef.products_extra_fields_status as status, pef.products_extra_fields_name as name, ptf.products_extra_fields_value as value
		FROM ". TABLE_PRODUCTS_EXTRA_FIELDS ." pef
		LEFT JOIN  ". TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS ." ptf
		ON ptf.products_extra_fields_id=pef.products_extra_fields_id
		WHERE ptf.products_id=" . (int)$HTTP_GET_VARS['products_id']." and ptf.products_extra_fields_value<>'' and (pef.languages_id='0' or pef.languages_id='".$languages_id."')
		ORDER BY products_extra_fields_order");
	?>

  pictures = new Array(5);
  pictures_big = new Array(5);
  <?php
  if (tep_not_null($product_info['products_image'])) {
   $i = 0;
   $j = 0;
   $img_mid = tep_obrazek(DIR_WS_IMAGES . $product_info[products_image], DISPLAY_IMAGE_WIDTH, DISPLAY_IMAGE_HEIGHT);
   echo "pictures[$j]=\"$img_mid\"\n";
   if (IMAGE_WATERMARK == 'true') {
     echo "pictures_big[$i]=\"image.php?main=$img_path$product_info[products_image]&watermark=watermark.png\"\n";
   } else {
     echo "pictures_big[$i]=\"$img_path$product_info[products_image]\"\n";
   }
   $j++;
   $i++;
  }
  $images_product = tep_db_query("SELECT additional_images_id, products_id, images_description, medium_images, popup_images FROM " . TABLE_ADDITIONAL_IMAGES . " WHERE products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'");
  if (!tep_db_num_rows($images_product)) {
  } else {
    while ($new_products = tep_db_fetch_array($images_product)) {
      $img_mid = tep_obrazek(DIR_WS_IMAGES . $new_products[popup_images], DISPLAY_IMAGE_WIDTH, DISPLAY_IMAGE_HEIGHT);
      echo "pictures[$j]=\"$img_mid\"\n";
      if (IMAGE_WATERMARK == 'true') {
        echo "pictures_big[$i]=\"image.php?main=$img_path$new_products[popup_images]&watermark=watermark.png\"\n";
      } else {
        echo "pictures_big[$i]=\"$img_path$new_products[popup_images]\"\n";
      }
      $j++;
      $i++;
    }
  }
  ?>

  nn4=(document.layers)?1:0;
  ie=(document.all)?1:0;
  screen_w=screen.availWidth-20;
  screen_h=screen.availHeight-40;

  var current_picture=0;

  function LoadMidPicture(picture_index) {     
   current_picture=picture_index;      
   document.big_photo.src = pictures[picture_index];
   return;
  }

  function ShowBigPicture(picture_index) {
  //if (ie)
     {
       NewWindow=window.open('', '','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no');
       NewWindow.document.open();

       NewWindow.document.writeln("<html><head>");
       NewWindow.document.writeln("<head>");
       NewWindow.document.writeln("<meta http-equiv=\"Content-Type\" content=\"text/html; charset="+charset+"\">");
       NewWindow.document.writeln("<link rel=\"stylesheet\" type=\"text/css\" href=\"stylesheet.css\">");

       NewWindow.document.writeln("<script language=\"javascript\"><!--");
       NewWindow.document.writeln("var i=0;");
       NewWindow.document.writeln("function resize() {");
       NewWindow.document.writeln("if (navigator.appName == 'Netscape') i=40;");
       NewWindow.document.writeln("if (navigator.appName == 'Konqueror') i=-500;");
       NewWindow.document.writeln("self.focus();");
			 NewWindow.document.writeln("if (document.images[0]) window.resizeTo(document.images[0].width +304, document.images[0].height+145-i);");
       NewWindow.document.writeln("}");
       NewWindow.document.writeln("//--><\/script>");

       NewWindow.document.writeln("<body onload=resize();>");
       NewWindow.document.writeln("<title>"+tytul+"</title>");
       NewWindow.document.writeln("<table width=100% height=100% border=0 cellpadding=0 cellspacing=0>");
			 NewWindow.document.writeln("<tr><td>");

			 NewWindow.document.writeln("<table bgcolor=\"#ffffff\" width=100% height=100% border=0 cellpadding=3 cellspacing=3>");
       NewWindow.document.writeln("<tr><td valign=center align=center  bgcolor=\"#000000\">\n<a href=\"javascript:window.close();\"><img src=\""+pictures_big[picture_index]+"\" border=\"0\"></a></td></tr></table>");

			 NewWindow.document.writeln("</td><td valign=\"top\">");
       NewWindow.document.writeln("<table width=100% border=0 cellpadding=5 cellspacing=1>");
       NewWindow.document.writeln("<tr><td class=\"extraFields\" align=\"center\"><b>"+tytul+"</b></td></tr>");
       NewWindow.document.writeln("<tr><td class=\"extraFields\" align=\"center\">praca nr : "+model+"</td></tr>");
			 NewWindow.document.writeln("</table><br>");
			 
       NewWindow.document.writeln("<table width=100% border=0 cellpadding=5 cellspacing=1>");
       NewWindow.document.writeln("<tr><td class=\"extraFields\" align=\"center\">dostępnych [ szt. ]:</td><td class=\"extraFields\" align=\"center\">"+ilosc+"</td></tr>");

<?php
			while ($extra_fields = tep_db_fetch_array($extra_fields_query)) {
			if (! $extra_fields['status'])  // show only enabled extra field
				continue;
				?>
				field = '<?php echo "<tr><td class=\"extraFields\" align=\"right\">".$extra_fields[name]."</td><td class=\"extraFields\" align=\"center\">".$extra_fields[value]."</td></tr>"; ?>'
			 NewWindow.document.writeln(""+field+"");
				<?php
		} 

?>
			 NewWindow.document.writeln("</table><br>");

       NewWindow.document.writeln("<table width=100% border=0 cellpadding=5 cellspacing=1>");
       NewWindow.document.writeln("<tr><td class=\"extraFields\" align=\"left\">"+opis+"</td></tr>");
			 NewWindow.document.writeln("</table><br>");

			 NewWindow.document.writeln("</td></tr></table>");
       NewWindow.document.writeln("</body>\n</HTML>\n");
       NewWindow.document.close(); 
       NewWindow.focus();     
     } 
     return;
  }

</script> 

<?php
?>