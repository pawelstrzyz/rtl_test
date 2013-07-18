<script Language="JavaScript1.1"  type="text/javascript">
  charset = '<?php echo CHARSET; ?>';
  tytul = '<?php echo str_replace('\'','',$products_name); ?>';
  logo =  '<?php echo DIR_WS_IMAGES . STORE_LOGO; ?>';

  szerokosc = new Array(10);
  wysokosc = new Array(10);
  opis = new Array(10);

  pictures = new Array(10);
  pictures_big = new Array(10);
  <?php
  if (tep_not_null($product_info['products_image'])) {
  $opis = 'aaaaa';
   $i = 0;
   $j = 0;
   $img_mid = tep_obrazek(DIR_WS_IMAGES . $product_info[products_image], DISPLAY_IMAGE_WIDTH, DISPLAY_IMAGE_HEIGHT);

   echo "pictures[$j]=\"$img_mid\"\n";
   if (IMAGE_WATERMARK == 'true') {
     echo "pictures_big[$i]=\"image.php?main=$img_path$product_info[products_image]&watermark=watermark.png\"\n";
   } else {
     echo "pictures_big[$i]=\"$img_path$product_info[products_image]\"\n";
   }
   $image_size = getimagesize(DIR_WS_IMAGES . $product_info[products_image]);
   $width = $image_size[0] +40;
   $height = $image_size[1] +40;
   echo "szerokosc[$i] = '".$width."';\n";
   echo "wysokosc[$i] = '".$height."';\n";
   echo "opis[$i] = '".$products_name."';\n";

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
      $image_size = getimagesize(DIR_WS_IMAGES . $new_products[popup_images]);
      $width = $image_size[0] +40;
      $height = $image_size[1] +40;
      echo "szerokosc[$i] = '".$width."';\n";
      echo "wysokosc[$i] = '".$height."';\n";
	  echo "opis[$i] = '".$new_products[images_description]."';\n";
      $j++;
      $i++;
    }
  }
  ?>

  var current_picture=0;

  function LoadMidPicture(picture_index) {     
   current_picture=picture_index;      
   document.big_photo.src = pictures[picture_index];
   return;
  }

  function ShowBigPicture(picture_index) {

    var imageObject = new Image();
    imageObject.src = pictures_big[picture_index];

  win = new Window( { className: 'spread', destroyOnClose: true, recenterAuto:true, minimizable:false, maximizable:true } );
  win.setTitle(tytul);
  win.setSize(szerokosc[picture_index], wysokosc[picture_index]);
  win.getContent().innerHTML= "<table cellpadding='0' cellspacing='0' border='0' align='center' width='100%' height='100%'><tr><td align='center' valign='middle'><img src=\""+pictures_big[picture_index]+"\" border=\"0\"></td></tr><tr><td class=\"main\" align=\"center\">"+opis[picture_index]+"</td></tr></table></div>"
  win.showCenter();
  }

</script>

