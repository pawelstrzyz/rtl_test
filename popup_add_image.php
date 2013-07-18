<?php
/*
  $Id: popup_add_image.php 1 2007-12-20 23:52:06Z  $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
 
  AUTHOR: Zaenal Muttaqin <zaenal@paramartha.org>  
  Released under the GNU General Public License  

  mod eSklep-Os http://www.esklep-os.com
*/

  require('includes/application_top.php');

  $navigation->remove_current_page();

  $products_query = tep_db_query("SELECT images_description, popup_images FROM " . TABLE_ADDITIONAL_IMAGES . " WHERE additional_images_id = '" . (int)$HTTP_GET_VARS['imagesID'] . "'");
  $products_values = tep_db_fetch_array($products_query);
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<title><?php echo $products_values['images_description']; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<script language="javascript"><!--
var i=0;
function resize() {
  if (navigator.appName == 'Netscape') i=40;
  if (document.images[0]) window.resizeTo(document.images[0].width +30, document.images[0].height+60-i);
  self.focus();
}
//--></script>
</head>
<body onload="resize();">
<?php echo tep_image(DIR_WS_IMAGES . $products_values['popup_images'], $products_values['images_description'], POPUP_IMAGE_WIDTH, POPUP_IMAGE_HEIGHT); ?>
</body>
</html>
<?php require('includes/application_bottom.php'); ?>
