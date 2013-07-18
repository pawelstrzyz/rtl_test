<?php
/*
  $Id: \templates\standard\content\advanced_search.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('advanced_search', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get', 'onSubmit="return check_form(this);"') . tep_hide_session_id(); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
      
 <!-- Naglowek BOF -->
	<tr>  
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_right.gif" border="0" alt="" width="30" height="35"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo HEADING_TITLE_1; ?></td>
      <td height="35" class="infoBoxHeading"><img src="templates/standard/images/infobox/corner_left.gif" border="0" alt="" width="30" height="35"></td>	
	</tr> 
 </table></td>
      </tr>	  
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 <!-- Naglowek EOF -->

 <?php
 if ($messageStack->size('search') > 0) {
 ?>
 <tr>
  <td><?php echo $messageStack->output('search'); ?></td>
 </tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
 <?php
 }
 ?>
<tr>
<td class="main"><img src="templates/standard/images/categoriesbox/category_bullet.gif" class="s" alt=""> <?php echo BOX_ADVSEARCH_KW; ?></td>
<td class="main"><?php echo tep_draw_input_field('keywords', '', 'style="width: 100%"'); ?></td>
</tr>
<tr>
<td class="main"><img src="templates/standard/images/categoriesbox/category_bullet.gif" class="s" alt=""> <?php echo TEXT_SEARCH_IN_DESCRIPTION; ?></td>
<td class="main"><?php echo tep_draw_checkbox_field('search_in_description', '1');?></td>
</tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
<tr>
<td class="main"><img src="templates/standard/images/categoriesbox/category_bullet.gif" class="s" alt=""> <?php echo ENTRY_CATEGORIES; ?></td>
<td class="main"><?php echo tep_draw_pull_down_menu('categories_id', tep_get_categories(array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES)))); ?></td>
</tr>
<tr>
<td class="main"><img src="templates/standard/images/categoriesbox/category_bullet.gif" class="s" alt=""> <?php echo ENTRY_INCLUDE_SUBCATEGORIES; ?></td>
<td class="main"><?php echo tep_draw_checkbox_field('inc_subcat', '1', true) ; ?></td>
</tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
<tr>
<td class="main"><img src="templates/standard/images/categoriesbox/category_bullet.gif" class="s" alt=""> <?php echo ENTRY_MANUFACTURERS; ?></td>
<td class="main"><?php echo tep_draw_pull_down_menu('manufacturers_id', tep_get_manufacturers(array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS)))); ?></td>
</tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
<tr>
<td class="main"><img src="templates/standard/images/categoriesbox/category_bullet.gif" class="s" alt=""> <?php echo ENTRY_PRICE_FROM; ?></td>
<td class="main"><?php echo tep_draw_input_field('pfrom'); ?></td>
</tr>
<tr>
<td class="main"><img src="templates/standard/images/categoriesbox/category_bullet.gif" class="s" alt=""> <?php echo ENTRY_PRICE_TO; ?></td>
<td class="main"><?php echo tep_draw_input_field('pto'); ?></td>
</tr>
 <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
 </tr>
<tr>
<td class="main"><img src="templates/standard/images/categoriesbox/category_bullet.gif" class="s" alt=""> <?php echo ENTRY_DATE_FROM; ?></td>
<td class="main"><?php echo tep_draw_input_field('dfrom', DOB_FORMAT_STRING, 'onFocus="RemoveFormatString(this, \'' . DOB_FORMAT_STRING . '\')"'); ?></td>
</tr>
<tr>
<td class="main"><img src="templates/standard/images/categoriesbox/category_bullet.gif" class="s" alt=""> <?php echo ENTRY_DATE_TO; ?></td>
<td class="main"><?php echo tep_draw_input_field('dto', DOB_FORMAT_STRING, 'onFocus="RemoveFormatString(this, \'' . DOB_FORMAT_STRING . '\')"'); ?></td>
</tr>			  			
<tr>
<td align="right" colspan="2" class="main"><?php echo tep_image_submit('button_search.gif', IMAGE_BUTTON_CONTINUE); ?></td>
</tr>
 <!-- Przyciski EOF -->
 

</table>
</form>