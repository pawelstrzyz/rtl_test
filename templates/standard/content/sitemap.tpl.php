<?php
/*
  $Id: sitemap.php,v1.0 2004/05/25 devosc Exp $

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
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
 <!-- Naglowek EOF -->
 
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	    <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="50%" class="main" valign="top"><?php require DIR_WS_CLASSES . 'category_tree.php'; $osC_CategoryTree = new osC_CategoryTree; echo $osC_CategoryTree->buildTree(); ?></td>
        <td width="50%" class="main" valign="top">
         <ul>
          <li><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . PAGE_ACCOUNT . '</a>'; ?></li>
           <ul>
            <li><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL') . '">' . PAGE_ACCOUNT_EDIT . '</a>'; ?></li>
            <li><?php echo '<a href="' . tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . PAGE_ADDRESS_BOOK . '</a>'; ?></li>
            <li><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">' . PAGE_ACCOUNT_HISTORY . '</a>'; ?></li>
            <li><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL') . '">' . PAGE_ACCOUNT_NOTIFICATIONS . '</a>'; ?></li>
           </ul>
          <li><?php echo '<a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' . PAGE_SHOPPING_CART . '</a>'; ?></li>
          <li><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . PAGE_CHECKOUT_SHIPPING . '</a>'; ?></li>
          <li><?php echo '<a href="' . tep_href_link(FILENAME_ADVANCED_SEARCH) . '">' . PAGE_ADVANCED_SEARCH . '</a>'; ?></li>
          <li><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_NEW) . '">' . PAGE_PRODUCTS_NEW . '</a>'; ?></li>
          <li><?php echo '<a href="' . tep_href_link(FILENAME_SPECIALS) . '">' . PAGE_SPECIALS . '</a>'; ?></li>
          <li><?php echo '<a href="' . tep_href_link(FILENAME_REVIEWS) . '">' . PAGE_REVIEWS . '</a>'; ?></li>
          <li><?php echo BOX_HEADING_INFORMATION; ?></li>
			     <ul>
            <?php
            // Extra Pages ADDED BEGIN 
            $page_query = tep_db_query("select  p.pages_id, p.sort_order, p.status, p.page_type, s.pages_title, s.pages_html_text, s.intorext, s.externallink, s.link_target   from " . TABLE_PAGES . " p LEFT JOIN " .TABLE_PAGES_DESCRIPTION . " s on p.pages_id = s.pages_id where p.status = 1 and s.language_id = '" .(int)$languages_id . "' order by p.sort_order, s.pages_title");
      
            $rows = 0;
            while ($page = tep_db_fetch_array($page_query)) {
             $rows++;

             $target="";
             if($page['link_target']== 1)  {
              $target="_blank";
             } else {
              $target="_self";
             }

             switch ($page['page_type']) {
              case 1:  
               $link = FILENAME_CONDITIONS;
               break;
              case 2:  
               $link = FILENAME_CONTACT_US;
               break;
              case 3:  
               $link = FILENAME_PRIVACY;
               break;
              case 4:  
               $link = FILENAME_SHIPPING;
               break;
              default:
               $link = FILENAME_PAGES . '?pages_id=' . $page['pages_id'];
               break;
             }  // end switch

             if($page['intorext'] == 1)  {
              echo '<li><a class="boxLink" target="'.$target.'" href="' . $page['externallink'] . '">' . $page['pages_title'] . '</a></li>';
             } else {
              echo '<li><a class="boxLink" target="'.$target.'" href="' . tep_href_link($link) . '">' . $page['pages_title'] . '</a></li>';
             }
            }
            echo '<li><a class="boxLink" href="' .tep_href_link(FILENAME_SITEMAP). '">' .BOX_INFORMATION_SITEMAP. '</a></li>';

            if (ALL_PRODUCTS == 'true') {
             echo '<li><a class="boxLink" href="' .tep_href_link(FILENAME_ALLPRODS). '">' .BOX_INFORMATION_ALLPRODS. '</a></li>';
            }
            // Extra Pages ADDED END
           ?>
		       </ul>
          </ul>
        </td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
  </td>
 </tr>

  <!-- Przyciski BOF -->
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 <!-- Przyciski EOF -->

</table>