<!-- newsdesk //-->
<?php
/*

 mod eSklep-Os http://www.esklep-os.com

*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0" class="templateinfoBox">
	<tr>  
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo TABLE_HEADING_NEWSDESK; ?></td>
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_left.gif" border="0" alt="" width="30" height="35"></td>	
    </tr>
<table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <tr>
  <td>
    <tr>
        <td class="main" align="center">
            <?php
            $configuration_query = tep_db_query("select configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_NEWSDESK_CONFIGURATION . "");
            while ($configuration = tep_db_fetch_array($configuration_query)) {
                define($configuration['cfgKey'], $configuration['cfgValue']);
            }

            $newsdesk_var_query = tep_db_query('select p.newsdesk_id, pd.language_id, pd.newsdesk_article_name, pd.newsdesk_article_description, pd.newsdesk_article_shorttext, pd.newsdesk_article_url, pd.newsdesk_article_url_name,  p.newsdesk_image, p.newsdesk_image_two, p.newsdesk_image_three, p.newsdesk_date_added, p.newsdesk_last_modified, pd.newsdesk_article_viewed,  p.newsdesk_date_available, p.newsdesk_status  from ' . TABLE_NEWSDESK . ' p, ' . TABLE_NEWSDESK_DESCRIPTION . '  pd WHERE pd.newsdesk_id = p.newsdesk_id and pd.language_id = "' . $languages_id . '" and newsdesk_status = 1 and p.newsdesk_sticky = 0 ORDER BY newsdesk_date_added DESC LIMIT ' . MAX_DISPLAY_NEWSDESK_NEWS);

            if (!tep_db_num_rows($newsdesk_var_query)) { // there is no news
                echo '<!-- ' . TEXT_NO_NEWSDESK_NEWS . ' -->';
            } else {
            ?>
        </td>
    </tr>
        <tr>
            <td class="main" align="center">
                <table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="main" align="center">

                            <?php
                            $info_box_contents = array();
                            $row = 0;
                            $info_box_contents[$row] = array('align' => 'left',
                                                                             'text' => '
                            <table border="0" width="100%" cellspacing="0" cellpadding="3" class="templateinfoBox">
                                <tr>
                                    <td class="main" align="center">
                                        <table border="0" cellspacing="0" cellpadding="0" align="right" width="98%" style="border-collapse: collapse" bordercolor="#000000">
                                            <tr>
                                                <td valign="top">');
                                 
                                                    while ($newsdesk_var = tep_db_fetch_array($newsdesk_var_query)) {
                                                        if ( DISPLAY_NEWSDESK_IMAGE ) {
                                                            if ($newsdesk_var['newsdesk_image'] != '') {
                                                                $insert_image = '
                                                                <table border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td>
                                                                            <a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdesk_id=' . $newsdesk_var['newsdesk_id']) . '">' . tep_image(DIR_WS_IMAGES . $newsdesk_var['newsdesk_image'], '', '') . '</a>
                                                                        </td>
                                                                    </tr>
                                                                </table>';
                                                            }
                                                        }

                                                        if ( DISPLAY_NEWSDESK_IMAGE_TWO ) {
                                                            if ($newsdesk_var['newsdesk_image_two'] != '') {
                                                                $insert_image_two = '
                                                                <table border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td>
                                                                            <a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdesk_id=' . $newsdesk_var['newsdesk_id']) . '">' . tep_image(DIR_WS_IMAGES . $newsdesk_var['newsdesk_image_two'], '', '') . '</a>
                                                                        </td>
                                                                    </tr>
                                                                </table>';
                                                            }
                                                        }

                                                        if ( DISPLAY_NEWSDESK_IMAGE_THREE ) {
                                                            if ($newsdesk_var['newsdesk_image_three'] != '') {
                                                                $insert_image_three = '
                                                                <table border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td>
                                                                            <a href="' . tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdesk_id=' . $newsdesk_var['newsdesk_id']) . '">' . tep_image(DIR_WS_IMAGES . $newsdesk_var['newsdesk_image_three'], '', '') . '</a>
                                                                        </td>
                                                                    </tr>
                                                                </table>';
                                                            }
                                                        }

                                                        if ( DISPLAY_NEWSDESK_VIEWCOUNT ) {
                                                            $insert_viewcount = '<i>' . TEXT_NEWSDESK_VIEWED . $newsdesk_var['newsdesk_article_viewed'] . '</i>';
                                                        }

                                                        if ( DISPLAY_NEWSDESK_READMORE ) {
                                                            $insert_readmore = '<a class="boxlink" href="' . tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdesk_id=' . $newsdesk_var['newsdesk_id']) . '">[' . TEXT_NEWSDESK_READMORE . ']</a>';
                                                        }

                                                        if ( DISPLAY_NEWSDESK_SUMMARY ) {
                                                            $insert_summary = '<span class="smallText">'. $newsdesk_var['newsdesk_article_shorttext'] . '</span>';
                                                        }

                                                        if ( DISPLAY_NEWSDESK_HEADLINE ) {
                                                            $insert_headline = '<span class="smallText"><b>&raquo; ' . $newsdesk_var['newsdesk_article_name'] . '</b></span>';
                                                        }

                                                        if ( DISPLAY_NEWSDESK_DATE ) {
                                                            $insert_date = '<span class="smallText"> - <i>' . tep_date_long($newsdesk_var['newsdesk_date_added']) . '</i></span>';
                                                        }

                                                        $info_box_contents[$row] = array(
                                                        'align' => 'left',
                                                        'params' => 'class="smallText" valign="top"',
                                                        'text' => '
                                                        <table border="0" width="100%" cellspacing="0" cellpadding="3">
                                                            <tr>
                                                                <td colspan="2">' . $insert_headline . ' ' . $insert_date . '</td>
                                                                <td colspan="2" align="right">' . $insert_viewcount . '</td>
                                                            </tr>
                                                        </table>

                                                        <table border="0" width="100%" cellspacing="3" cellpadding="0">
                                                            <tr>
                                                                <td>
                                                                    <table border="0" width="100%" cellspacing="3" cellpadding="0">
                                                                        <tr>
                                                                            <td>' . $insert_summary . '</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>' . tep_draw_separator('pixel_trans.gif', '100%', '5') . '</td>
                                                                        </tr>
                                                                        '.(($newsdesk_var['newsdesk_article_description'] != '') ? '
                                                                        <tr>
                                                                            <td>' . $insert_readmore . '</td>
                                                                        </tr>' : '').'
                                                                    </table>
                                                                </td>
                                                                <td valign="top" align="right">' . $insert_image . '' . $insert_image_two . '' . $insert_image_three . '</td>
                                                            </tr>
                                                        </table>
                  
                                                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td colspan="2">' . tep_draw_separator('pixel_trans.gif', '100%', '5') . '</td>
                                                            </tr>
                                                        </table>');

                                                        $insert_image = '';
                                                        $insert_image_two = '';
                                                        $insert_image_three = '';
                                                        $row++;
                                                    }
                                                    $row = $row+1;


                                                    $info_box_contents[$row] = array(
                                                'text' => ' 
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>');

                            new contentBoxindex($info_box_contents);
                        ?>
                        </td>
                    </tr>
                </table>
                <?php
            }
            ?>
        </td>
    </tr>
</table>
<!-- newsdesk_eof //-->