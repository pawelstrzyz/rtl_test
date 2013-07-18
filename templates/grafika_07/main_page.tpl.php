<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>

<?php

if (ALLOW_HEADER_TAGS_CONTROLLER=='true') {
    if ( file_exists(DIR_WS_INCLUDES . 'header_tags.php') ) {
        require(DIR_WS_INCLUDES . 'header_tags.php');
    }
} else {
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php require(DIR_WS_INCLUDES . 'meta_tags.php'); ?>
    <title><?php echo META_TAG_TITLE; ?></title>
    <meta name="keywords" content="<?php echo META_TAG_KEYWORDS; ?>">
    <meta name="description" content="<?php echo META_TAG_DESCRIPTION; ?>">
    <?php
}
?>
<meta http-equiv="Content-Style-Type" content="text/css2">
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">

<link rel="stylesheet" type="text/css" href="<?php echo (bts_select('stylesheet','stylesheet.css')); // BTSv1.5 ?>">
<link rel="stylesheet" type="text/css" href="<?php echo (bts_select('stylesheet','print.css')); // BTSv1.5 ?>" media="print">

<script type="text/javascript" src="swfobject.js"></script>

<?php if (bts_select('stylesheets', $PHP_SELF)) { // if a specific stylesheet exists for this page it will be loaded ?>
<link rel="stylesheet" type="text/css" href="<?php echo (bts_select('stylesheets', $PHP_SELF)); // BTSv1.5 ?>">
<?php } ?>


<?php if (isset($javascript) && file_exists(DIR_WS_JAVASCRIPT . basename($javascript))) { require(DIR_WS_JAVASCRIPT . basename($javascript)); } ?>

<script type="text/javascript" language="javascript" src="includes/javascript/general.js"></script>

<script type="text/javascript" language="javascript"><!--
function popupWindow(url) {
window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=650,height=500,screenX=150,screenY=150,top=150,left=150')
}
//--></script>

<script type="text/javascript" language="javascript"><!--
function session_win() {
  window.open("<?php echo tep_href_link(FILENAME_INFO_SHOPPING_CART); ?>","info_shopping_cart","height=460,width=430,toolbar=no,statusbar=no,scrollbars=yes").focus();
}
//--></script>

<script type="text/javascript" src="cookies_accept.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">

<!-- warnings //-->
<?php require(DIR_WS_INCLUDES . 'warnings.php'); ?>

<!-- warning_eof //-->
<?php
// include i.e. template switcher in every template

    if ( CENTER_SHOP_BACKGROUND_ON == 'on' ) {
        ?>
        <table width="100%" cellpadding="<?php echo CENTER_SHOP_PADDING; ?>" cellspacing="0" border="0" >
            <tr>
                <td>
                <?php
    }
    ?><br>
                <table width="<?php echo CENTER_SHOP_WIDTH; ?>" align="center" BGCOLOR="#<?php echo CENTER_SHOP_BACKGROUND_COLOR; ?>" BORDER="<?php echo CENTER_SHOP_BORDER; ?>" CELLSPACING="<?php echo CENTER_SHOP_CELLSPACING; ?>" CELLPADDING="<?php echo CENTER_SHOP_CELLPADDING; ?>" >
                    <!-- header //-->
                    <?php
                    if (DOWN_FOR_MAINTENANCE_WARNING == 'true') {
                    ?>
                    <tr>
                        <td>
                            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="main" valign="middle" align="center" width="100%" bgcolor="red">
                                        <font color="white"><b><?php echo DOWN_FOR_MAINTENANCE_MESSAGE; ?></b></font>
                                    </td>
                                </tr>
                            <table>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>

<table align="center" width="1024" border="0" cellspacing="0" cellpadding="0" style="background-image:url(templates/grafika_07/images/bgbody.jpg); background-position:top; background-repeat:repeat-x ">
    <tr>
      <td height="81" align="left" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr align="left" valign="top">
          <td width="281"><a href="http://rattanland.pl"><img src="templates/grafika_07/images/logo.jpg" alt="rattanland.pl - meble rattanowe" width="281" height="81" /></a></td>
          <td width="360" align="right"><img src="templates/grafika_07/images/spacer.gif" height="35" style="display:block "></td>
          <td width="30" align="left"><img src="templates/grafika_07/images/h002.jpg" width="2" height="53" style="margin-top:20px; margin-left:17px "></td>
          <td><img src="templates/grafika_07/images/spacer.gif" height="32" style="display:block ">
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="23" align="left" valign="top"><table width="353"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="109"><span class="currenc"></span></td>
                    <td width="140"> </td>
                    <td width="14"></td>
                    <td width="90"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="right" valign="top"><table width="244" border="0" cellspacing="0" cellpadding="0">
                  <tr align="center" valign="middle">
                    <td width="86" height="17" style="background-color:#fffff7 "><span class="ShoppingCart"></span><?php include(DIR_WS_BOXES . 'shopping_cart2.php'); ?></td>
                    <td width="4"></td>
                    <td width="138" style="background-color:#fffff7 "><span class="ShoppingCart">
                      <?php include(DIR_WS_BOXES . 'shopping_cart3.php'); ?>
                    </span></td>
                    <td width="16">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="231" align="left" valign="top"><table width="1024"  border="0" cellspacing="0" cellpadding="0">
        <tr align="left" valign="top">
          <td width="389" height="231"><img src="templates/grafika_07/images/banner1.jpg" alt="meble ogrodowe technorattan" width="389" height="231" ></td>
          <td width="270"><table width="100%"  border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF ">
            <tr>
              <td height="166" align="center" valign="top"><table width="264" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" valign="top" style="background-image:url(templates/grafika_07/images/h003.jpg); background-position:top; background-repeat:repeat-x "><table width="220" border="0" cellspacing="0" cellpadding="0" style="margin-top:26px ">
                    <tr>
                      <td height="31" align="left" valign="top"><img src="templates/grafika_07/images/lupa.jpg" width="23" height="22" style="margin-right:10px "><span class="searchz"><?php echo BOX_HEADING_SEARCH ?></span></td>
                    </tr>
                    <tr>
                      <td height="32" align="left" valign="top"></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><?php include(DIR_WS_BOXES . 'search2.php'); ?></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="65" align="center" valign="top"><img src="templates/grafika_07/images/banner2.jpg" width="270" height="65"></td>
            </tr>
          </table></td>
          <td width="365"><table width="365"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="365" height="167" align="left" valign="top">
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab"
  id="baner_prawy" width="365" height="167">
<param name="allowFullScreen" value="true">
<param name="movie" value="templates/grafika_07/flash/baner_prawy.swf">
<param name="quality" value="high">
<param name="bgcolor" value="#FFFFFF">
<param name="wmode" value="window">
<embed src="templates/grafika_07/flash/baner_prawy.swf" width="365" height="167"
  allowFullScreen="true" quality="high" bgcolor="#FFFFFF" wmode="window"
  pluginspage="http://www.macromedia.com/go/getflashplayer"
  type="application/x-shockwave-flash">
</embed></object>

		</td>
            </tr>
            <tr>
              <td height="20" align="left" valign="top"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('aa01.jpg') . '</a>'; ?><?php echo '<a href="' . tep_href_link(FILENAME_CONTACT_US) . '">' . tep_image_button('aa05.jpg') . '</a>'; ?></td>
            </tr>
            <tr>
              <td height="44" align="left" valign="top"><?php echo '<a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' . tep_image_button('aa02.jpg') . '</a>'; ?><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT) . '">' . tep_image_button('aa03.jpg') . '</a>'; ?><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_PROCESS) . '">' . tep_image_button('aa04.jpg') . '</a>'; ?></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="11" align="left" valign="top" style="background-color:#FFFFFF "></td>
    </tr>
  </table>
 <table align="center" width="1024" border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF ">
 <!-- header_eof //-->
 <!-- body //-->
                    <tr>
                        <td>
                            <!-- body //-->
                            <table border="0" width="100%" cellspacing="10" cellpadding="0">
                                <tr>
                                    <td width="<?php echo BOX_WIDTH_LEFT_IS; ?>" valign="top">
                                        <table border="0" width="<?php echo BOX_WIDTH_LEFT_IS; ?>" cellspacing="0" cellpadding="0">
                                            <!-- column_left //-->
                                            <?php require(bts_select('column', 'column_left.php')); // BTSv1.5 ?>
                                            <!-- column_left eof //-->
                                        </table>
                                    </td>
                                    <td width="100%" valign="top">
                                        <!-- content //-->
                                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                            <tr>
                                                <td>
                                                    <?php require (bts_select ('content')); // BTSv1.5 ?>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- content_eof //-->
                                    </td>
                                    <td width="<?php echo BOX_WIDTH_RIGHT_IS; ?>" valign="top">
                                        <table border="0" width="<?php echo BOX_WIDTH_RIGHT_IS; ?>" cellspacing="0" cellpadding="0">
                                            <!-- column_right //-->
                                            <?php require(bts_select('column', 'column_right.php')); // BTSv1.5 ?>
											 <!-- column_right eof //-->
                                        </table>
										<center><a href="https://www.facebook.com/pages/Rattanland/513557228716863"><img src="http://rattanland.pl/images/Facebook.jpg" alt="Facebook"></a></center>
                                           
                                    </td>
                                </tr>
                            </table>
							
                            <!-- body_eof //-->
                        </td>
                    </tr>
 <!-- body_eof //-->
 </table>
					<tr>
                        <td>
                            <table align="center" border="0" width="1024" cellspacing="10" cellpadding="1" bgcolor=#ffffff>
                                <tr>
                                    <td>
                                        <table width="100%" cellspacing="0" cellpadding="1" class="">
                                            <tr>
                                                <td>
                                                    <table border="0" width="100%" cellspacing="0" cellpadding="0" class="">
                                           <tr>
						                        <td><?php if ($banner = tep_banner_exists('dynamic', '468x50')) { ?>
		                                            <table align="center" border="0" width="100%" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="14" height="40"></td>
                                                            <td height="35" class="infoBoxHeading" width="100%"><?php echo BOX_HEADING_ADVERTISE; ?></td>
                                                            <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_right.gif" border="0" alt="" width="15" height="40"></td>
                                                        </tr>
						                            </table>
                                                        <table align="center" border="0" width="100%" cellspacing="0" cellpadding="0" class="infoBoxContents_Box">
                                                            <tr>
                                                                <td>
													                <tr>
                                                                        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                       <td align="center"><?php echo tep_display_banner('static', $banner); ?></td>
                                                                    </tr>
																    <tr>
                                                                        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                                                                    </tr>
															    </td>
														    </tr>
                                                        </table>
                                                     <?php
                                                        }
                                                     ?>
		                                        </td>
										    </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                        <tr>
                            <td>
                                <?php require(DIR_WS_INCLUDES . 'counter.php'); ?>
        <table cellspacing=0 cellpadding=0 align=center bgcolor=#ffffff>
         <tr><td height=5 colspan=4></td></tr>
         <tr><td width=1024 height=10 bgcolor=#ffffff colspan=4></td></tr>
         <tr bgcolor=#a1aa38><td height=2 colspan=4></td></tr>
         <tr bgcolor=#f4efd9><td width=207 align=center valign=center><img src=templates/grafika_07/images/m33.gif width=161 height=26></td>
             <td><img src="templates/grafika_07/images/h002.jpg" width="2" height="53"></td>
             <td width=21></td>
             <td width=506>
              <table cellspacing=0 cellpadding=0 bgcolor=#f4efd9>
               <tr><td height=15></td></tr>
               <tr>
          <td class="main"><a href=<?=tep_href_link('index.php')?> class=ml2>Strona Główna</a>
            &nbsp;<img src=templates/grafika_07/images/m32.gif width=2 height=11 align=absmiddle> &nbsp;<a href="shipping.php" class=ml2>Wysyłka</a>
            &nbsp;<img src=templates/grafika_07/images/m32.gif width=2 height=11 align=absmiddle>
            &nbsp;<a href="sitemap.php" class=ml2>Mapa Strony</a> &nbsp;<img src=templates/grafika_07/images/m32.gif width=2 height=11 align=absmiddle>
            &nbsp;<a href="allprods.php" class=ml2>Katalog Produktów</a> &nbsp;<img src=templates/grafika_07/images/m32.gif width=2 height=11 align=absmiddle>
            &nbsp;<a href="./info_pages.php?pages_id=1" class=ml2>Regulamin</a>
            &nbsp;<img src=templates/grafika_07/images/m32.gif width=2 height=11 align=absmiddle> &nbsp;</td>
        </tr>
               <tr><td height=10></td></tr>
               <tr><td class="main">Copyright © <?php echo ''.date ("Y").' '.STORE_NAME.''; ?> &nbsp;&nbsp;<?php echo $counter_now . ' ' . FOOTER_TEXT_REQUESTS_SINCE . ' ' . $counter_startdate_formatted; ?></td></tr>
               <tr><td height=30></td></tr>
              </table>
             </td></tr>
         <tr style="background-image:url(templates/grafika_07/images/bgbody1.jpg); background-position:top; background-repeat:repeat-x "><td height=13 colspan=4></td></tr>
        </table>
                            </td>
                        </tr>
                </table>
            </td>
        </tr>
            <tr>
			    <td>
					<table align="center" border="0" width="1024" cellspacing="0" cellpadding="0">
						<tr>
                            <td ><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                        </tr>
                           <tr>
		                      <td  align="right"><a href="http://www.esklep-os.com"><img src="templates/grafika_07/images/misc/male_logo.png" border="0" alt="Na Oprogramowaniu eSklep-Os" width="74" height="20"></a></td>
		                   </tr>
                    </table>
			    </td>
		    </tr></table>
<?php
if ( CENTER_SHOP_BACKGROUND_ON == 'on' ) {
?>
                </td>
            </tr>
        </table>
<?php } ?>
</body>
</html>