<?php
/*
  $Id: \templates\standard\content\address_book_process.tpl.php; 10.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php if (!isset($HTTP_GET_VARS['delete'])) echo tep_draw_form('addressbook', tep_href_link(FILENAME_ADDRESS_BOOK_PROCESS, (isset($HTTP_GET_VARS['edit']) ? 'edit=' . $HTTP_GET_VARS['edit'] : ''), 'SSL'), 'post', 'onSubmit="return check_form(addressbook);"'); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
 <tr>
  <td>
  <?php
  $info_box_contents = array();
  if (isset($HTTP_GET_VARS['edit'])) {
   $info_box_contents[] = array('text' => sprintf(HEADING_TITLE_MODIFY_ENTRY));
  } elseif (isset($HTTP_GET_VARS['delete'])) {
   $info_box_contents[] = array('text' => sprintf(HEADING_TITLE_DELETE_ENTRY));
  } else { $info_box_contents[] = array('text' => sprintf(HEADING_TITLE_ADD_ENTRY));
  }
  new contentBoxHeading($info_box_contents);
  ?>
  </td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <!-- Naglowek EOF -->

 <?php
 if ($messageStack->size('addressbook') > 0) {
 ?>
 <tr>
  <td><?php echo $messageStack->output('addressbook'); ?></td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <?php
 }

 if (isset($HTTP_GET_VARS['delete'])) {
 ?>
 <tr>
  <td class="main"><b><?php echo DELETE_ADDRESS_TITLE; ?></b></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="0">
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main" width="50%" valign="top"><?php echo DELETE_ADDRESS_DESCRIPTION; ?></td>
        <td align="right" width="50%" valign="top">
		 <table border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td class="main" align="center" valign="top"><b><?php echo SELECTED_ADDRESS; ?></b><br><?php echo tep_image(DIR_WS_TEMPLATES . 'images/misc/arrow_south_east.gif'); ?></td>
           <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
           <td class="main" valign="top"><?php echo tep_address_label($customer_id, $HTTP_GET_VARS['delete'], true, ' ', '<br>'); ?></td>
           <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
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
 
 <!-- Przyciski BOF -->
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
 </tr>
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td><?php echo '<a href="' . tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
        <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $HTTP_GET_VARS['delete'] . '&action=deleteconfirm', 'SSL') . '">' . tep_image_button('button_delete.gif', IMAGE_BUTTON_DELETE) . '</a>'; ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 <!-- Przyciski EOF -->
 
 <?php
 } else {
 ?>
 
 <tr>
  <td><?php include(DIR_WS_MODULES . 'address_book_details.php'); ?></td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
 </tr>
 <?php
 if (isset($HTTP_GET_VARS['edit']) && is_numeric($HTTP_GET_VARS['edit'])) {
 ?>

 <!-- Przyciski BOF -->
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td><?php echo '<a href="' . tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
        <td align="right"><?php echo tep_draw_hidden_field('action', 'update') . tep_draw_hidden_field('edit', $HTTP_GET_VARS['edit']) . tep_image_submit('button_update.gif', IMAGE_BUTTON_UPDATE); ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 <!-- Przyciski EOF -->
 
 <?php
 } else {

 if (sizeof($navigation->snapshot) > 0) {
  $back_link = tep_href_link($navigation->snapshot['page'], tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode']);
 } else {
  $back_link = tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL');
 }
 ?>
 
 <!-- Przyciski BOF -->
 <tr>
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td><?php echo '<a href="' . $back_link . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
        <td align="right"><?php echo tep_draw_hidden_field('action', 'process') . tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
       </tr>
      </table>
	 </td>
    </tr>
   </table>
  </td>
 </tr>
 <!-- Przyciski EOF -->

 <?php
 }
 }
 ?>
</table>
<?php if (!isset($HTTP_GET_VARS['delete'])) echo '</form>'; ?>