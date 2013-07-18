<?php
/*
  $Id: popup_image.php,v 1.18a 2004/07/06 12:52:23$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);

  $navigation->remove_current_page();

  $products_query = tep_db_query("select pd.products_name, pd.products_description, p.products_image, p.products_price, p.manufacturers_id from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['pID'] . "' and pd.language_id = '" . (int)$languages_id . "'");
  $products = tep_db_fetch_array($products_query);

  $product_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['pID'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
  $product_check = tep_db_fetch_array($product_check_query);

                if (isset($HTTP_GET_VARS['pID'])) {
    $manufacturer_query = tep_db_query("select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on (m.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$languages_id . "'), " . TABLE_PRODUCTS . " p  where p.products_id = '" . (int)$HTTP_GET_VARS['pID'] . "' and p.manufacturers_id = m.manufacturers_id");
    if (tep_db_num_rows($manufacturer_query)) {
      $manufacturer = tep_db_fetch_array($manufacturer_query);
                                        }}

  if ($product_check['total'] < 1) {
  } else {
    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['pID'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);

    tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$HTTP_GET_VARS['pID'] . "' and language_id = '" . (int)$languages_id . "'");

    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
      $products_price = '<s>' . $currencies->display_price($product_info['products_id'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($product_info['products_id'], $new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
    } else {
      $products_price = $currencies->display_price($product_info['products_id'], $product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
    }

    if (tep_not_null($product_info['products_model'])) {
      $products_name = $product_info['products_name'] . '<br><span class="smallText">[' . $product_info['products_model'] . ']</span>';
	  $products_description = $product_info['products_description'];
    } else {
      $products_name = $product_info['products_name'];
	  $products_description = $product_info['products_description'];
    }}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $products['products_name']; ?></title>
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
        imgHeight = document.images[0].height+150-i;
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
	     <tr>
           <td class="pageHeading" align="center" colspan="2"><?php echo $products['products_name']; ?></td>
         </tr>
         <tr align="center">
           <td colspan="2"><?php echo tep_image(DIR_WS_IMAGES . $products['products_image'], $products['products_name']); ?></td>
         </tr>
         <tr>
           <td class="pageHeading" align="center" colspan="2"><?php echo $products_price; ?></td>
         </tr>
       </table>
     </td>
  </tr>
</table>
</center>
</body>
</html>
<?php require('includes/application_bottom.php'); ?>