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
<script type="text/javascript" src="swfobject.js"></script>

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">

<!-- warnings //-->
<?php require(DIR_WS_INCLUDES . 'warnings.php'); ?>
<?php require(DIR_WS_INCLUDES . 'common_top.php'); ?>

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
				<tr>
				<td>
				<table border="0" width="100%" cellspacing="0" cellpadding="0" class="ramka_sklep">
                    <tr>
                        <td>
						   <tr>
                              <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                                  </tr> 
								     <tr>
									   <td>
                                          <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                             <tr class="header">
																		<?php
                       								if ( substr(STORE_LOGO, -3, 3) == 'swf' ) {
	  																		$size = getimagesize(DIR_WS_IMAGES . STORE_LOGO);
      																	echo '<td valign="middle" align="center">' . mm_output_flash_movie_ie( STORE_NAME, DIR_WS_IMAGES . STORE_LOGO , $size[0]  , $size[1]) . '</td>';
	  																	} else {
	    																	echo '<td valign="middle" align="center"><a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image(DIR_WS_IMAGES . STORE_LOGO, STORE_NAME) . '</a></td>';
	  																	}
																		?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" width="100%" cellspacing="10" cellpadding="0">
                                <tr>
                                    <td>
                                        <table width="100%" cellspacing="0" cellpadding="1" class="">
                                            <tr>
                                                <td>
                                                    <table border="0" width="100%" cellspacing="0" cellpadding="0" class="infoBoxContents_Box">
                                                        <tr>
                                                            <td height="35" class="headerNavigation" height="25">&#160;&#160;<?php echo $breadcrumb->trail(' &raquo; '); ?></td>
                                                            <td height="35" align="right" class="headerNavigation" height="25"><?php if (tep_session_is_registered('customer_id')) { ?><a href="<?php echo tep_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>" class="headerNavigation"><?php echo HEADER_TITLE_LOGOFF; ?></a> &#160;|&#160; <?php } ?><a href="<?php echo tep_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>" class="headerNavigation"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a> &#160;<?php if ($cart->count_contents() > 0) { ?>|&#160; <a href="<?php echo tep_href_link(FILENAME_SHOPPING_CART); ?>" class="headerNavigation"><?php echo HEADER_TITLE_CART_CONTENTS; ?></a> &#160;<?php } ?><?php if ($cart->count_contents() > 0) { ?>|&#160; <a href="<?php echo tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>" class="headerNavigation"><?php echo HEADER_TITLE_CHECKOUT; ?></a><?php } ?> &#160;&#160;</td>
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
                    <!-- header_eof //-->
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
                                    </td>																												
                                </tr>								
                            </table>
                            <!-- body_eof //-->							
                        </td>
                    </tr>					
					<tr>
                        <td>
                            <table border="0" width="100%" cellspacing="10" cellpadding="0">
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
                                                            <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
                                                            <td height="35" class="infoBoxHeading" width="100%"><?php echo BOX_HEADING_ADVERTISE; ?></td>
                                                            <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_left.gif" border="0" alt="" width="30" height="35"></td>	
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
                                <table border="0" width="100%" cellspacing="0" cellpadding="1" align="center" height="35">
                                    <tr>
                                        <td align="right" class="footer" height="35" width="70%">(C) Wszelkie Prawa Zastrzeżone. All Rights Reserved. <?php echo ''.date ("Y").' '.STORE_NAME.''; ?></td><td align="right" class="footer" height="21"> Licznik Odwiedzin: <?php echo $counter_now ; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                </table>
            </td>
        </tr>
            <tr>
			    <td>
					<table align="center" border="0" width="<?php echo CENTER_SHOP_WIDTH; ?>" cellspacing="0" cellpadding="0">
						<tr>				             
                            <td bgcolor="#f6f8fe"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                        </tr>
                           <tr>
		                      <td bgcolor="#f6f8fe" align="right"><a href="http://www.esklep-os.com"><img src="templates/standard/images/misc/male_logo.png" border="0" alt="Na Oprogramowaniu eSklep-Os" width="74" height="20"></a></td>
		                   </tr>
                    </table>
			    </td>
		    </tr>
<?php
if ( CENTER_SHOP_BACKGROUND_ON == 'on' ) {
?>
                </td>
            </tr>
        </table>
<?php } ?>
</body>
</html>

