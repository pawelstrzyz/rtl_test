<?php
/*
  $Id: \templates\standard\content\index_default.tpl.php; 25.06.2006

  oscGold, Autorska dystrybucja osCommerce
  http://www.oscgold.com
  autor: Jacek Krysiak

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
 
	<?php
	$tresc_pliku = DIR_WS_LANGUAGES . $language . '/' . FILENAME_DEFINE_MAINPAGE;
    $plik = fopen($tresc_pliku,"r");
    $tresc = fgets($plik);
    fclose($plik);
	
	if (strlen($tresc) > 10) {
    ?>
 
    <!-- Naglowek BOF -->
	<tr>  
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="22" height="40"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo HEADING_TITLE; ?></td>
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_right.gif" border="0" alt="" width="16" height="40"></td>	
	</tr> 
 </table>
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
    <!-- Naglowek EOF -->	

    <tr>
        <td>
            <table width="100%" cellspacing="0" cellpadding="1" class="">
                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0" class="infoBoxContents">
                            <tr>
                                <td>
                                    <table border="0" width="100%" cellspacing="0" cellpadding="4">
                                        <tr>
                                            <td class="main"><?php echo $tresc; ?></td>
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
</table></td></tr>

	<?php
	}
	?>
	
                <tr>
                    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '9'); ?></td>
                </tr>
    <tr>
        <td>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">

                <?php if (SHOW_MAINCATEGORIES=='true') { ?>
                <tr>
                    <td><?php include($modules_folder . FILENAME_MAIN_CATEGORIES); ?></td>
                </tr>

                <?php } ?>

                <?php if (SHOW_STARPRODUCT=='true') { ?>
                <tr>
                    <td><?php include($modules_folder . FILENAME_STAR_PRODUCT); ?></td>
                </tr>
                <tr>
                    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '9'); ?></td>
                </tr>
                <?php } ?>

                <?php if (SHOW_DEFAULTSPECIALS=='true' && SPECIAL_PRICES_HIDE=='false') { ?>
                  <tr>
                    <td><?php include($modules_folder . FILENAME_SPECIALS_DEFAULT); ?></td>
                  </tr>
                <tr>
                    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '9'); ?></td>
                </tr>
                 <?php } ?>


                <?php if (SHOW_NEWSDESK=='true') { ?>
                <tr>
                    <td><?php include($modules_folder . FILENAME_NEWSDESK); ?></td>
                </tr>
                <tr>
                    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '9'); ?></td>
                </tr>
                <?php } ?>

                <?php if (SHOW_NEWPRODUCTS=='true') { ?>
                <tr>
                    <td><?php include($modules_folder . FILENAME_NEW_PRODUCTS); ?></td>
                </tr>
                <tr>
                    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>
                <?php } ?>

                <?php if (FEATURED_PRODUCTS_DISPLAY=='true') { ?>
                <tr>
                    <td><?php include($modules_folder . FILENAME_FEATURED); ?></td>
                </tr>

                <?php } ?>

                <?php if (SHOW_UPCOMINGPRODUCTS=='true') { ?>
                <tr>
                    <td><?php include($modules_folder . FILENAME_UPCOMING_PRODUCTS); ?></td>
                </tr>

                <?php } ?>
            </table>
        </td>
    </tr>
</table>