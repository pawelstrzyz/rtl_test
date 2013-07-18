<?php
/*
  $Id: options_images_popup.php,v 1.18 2003/08/21

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

require('includes/application_top.php');

$navigation->remove_current_page();

$options_query = tep_db_query("select pov.products_options_values_name, pov.products_options_values_thumbnail from " . TABLE_PRODUCTS_OPTIONS_VALUES . " as pov where pov.products_options_values_id = '" . (int)$HTTP_GET_VARS['oID'] . "' and pov.language_id = '" . (int)$languages_id . "'");
$options = tep_db_fetch_array($options_query);
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo $options['products_options_values_name']; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<script language="javascript"><!--
var i=0;
function parentSubmit()
{
  opener.document.forms.cart_quantity.submit();
  this.close();
}
//--></script>

<script language="javascript" type="text/javascript"><!--
var i=0;
function resize() {
        if (window.navigator.userAgent.indexOf('MSIE 6.0') != -1 && window.navigator.userAgent.indexOf('SV1') != -1) {
		               i=23; //IE 6.x on Windows XP SP2
        } else if (window.navigator.userAgent.indexOf('MSIE 6.0') != -1) {
		               i=50; //IE 6.x somewhere else
	  } else if (window.navigator.userAgent.indexOf('MSIE 7.0') != -1) {
		               i=0;  //IE 7.x
        } else if (window.navigator.userAgent.indexOf('Firefox') != -1 && window.navigator.userAgent.indexOf("Windows") != -1) {
		               i=38; //Firefox on Windows
        } else if (window.navigator.userAgent.indexOf('Mozilla') != -1 && window.navigator.userAgent.indexOf("Windows") != -1 && window.navigator.userAgent.indexOf("MSIE") == -1) {
		               i=45; //Mozilla on Windows, but not IE7
	  } else if (window.opera && document.childNodes) {
		               i=50; //Opera 7+
        } else if (navigator.vendor == 'KDE' && window.navigator.userAgent.indexOf("Konqueror") != -1) {
                           i=-4; //Konqueror- this works ok with small images but not so great with large ones
				         //if you tweak it make sure i remains negative
        } else {
		               i=70; //All other browsers
        }

	if (document.images[0]) {
        imgHeight = document.images[0].height+170-i;
        imgWidth = document.images[0].width+90;
        var height = screen.height;
        var width = screen.width;
        var leftpos = width / 2 - imgWidth / 2;
        var toppos = height / 2 - imgHeight / 2;
        // window.moveTo(leftpos, toppos);
        window.resizeTo(imgWidth, imgHeight);
       }

}
//--></script>

<link rel="stylesheet" type="text/css" href="<?php echo (bts_select('stylesheet','stylesheet.css')); // BTSv1.5 ?>">
</head>
<body onload="resize();" onBlur="window.close();" onmousedown="window.close();"><center>
<table cellpadding="0" cellspacing="15" border="0">
  <tr>
     <td>
	   <table align="center" border="0" cellspacing="0" cellpadding="5">
         <tr align="center">
           <td colspan="2"><?php echo $options['products_options_values_name']; ?></td>
         </tr>
         <tr align="center">
           <td colspan="2"><?php echo tep_image(DIR_WS_IMAGES . '' . $options['products_options_values_thumbnail'], $options['products_options_values_name']); ?></td>
         </tr>
       </table>
     </td>
  </tr>
</table>
</center>
</body>
</html>
<?php require('includes/application_bottom.php'); ?>