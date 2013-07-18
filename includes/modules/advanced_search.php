<?php
/*
  $Id: \templates\standard\content\advanced_search.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('advanced_search', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get', 'onSubmit="return check_form(this);"') . tep_hide_session_id(); ?>

 <table border="0" width="100%" cellspacing="0" cellpadding="0" class="templateinfoBox">
  <tr>
   <td class="main">
    <?php
    $info_box_contents = array();
    $info_box_contents[] = array('text' => BOX_HEADING_SEARCH);
    new contentBoxHeading($info_box_contents);
    ?>
   </td>
  </tr>
  <tr>
  <tr>
   <table border="0" cellspacing="0" cellpadding="3">
    <tr>
  <td class="boxText"><b><?php echo BOX_SEARCH_TEXT; ?></b></td>
  <td class="boxText"><?php echo tep_draw_input_field('keywords', ''); ?></td>

  <?php
  $attributes_query = tep_db_query("select * from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . (int)$languages_id . "'");
  while ($attributes = tep_db_fetch_array($attributes_query)) {?>
   <td class="fieldKey"><?php echo $attributes["products_options_name"]; ?></td>
    <?php
    $option_values_query = tep_db_query("select pv.products_options_values_id, pv.products_options_values_name from products_options_values pv, products_options po, products_options_values_to_products_options popv where popv.products_options_id = po.products_options_id and pv.products_options_values_id = popv.products_options_values_id and popv.products_options_id =" . $attributes["products_options_id"] . " and po.language_id =". (int)$languages_id . " group by products_options_values_id, products_options_values_name");
    echo '<td class="fieldValue">';
    echo '<select name="'.$attributes["products_options_id"].'">';
    echo '<option selected></option>';
    while ($option_values = tep_db_fetch_array($option_values_query)) {
   	 echo '<option value="'.$option_values["products_options_values_id"].'">'.$option_values["products_options_values_name"].'</option>';
    }
    echo '</select>'; ?>
   </td>
   <?php
   }
   ?>
  </td>

  <!-- Przyciski BOF -->
  <td>
   <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td>
         <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
           <td class="smallText" align="right"><?php echo tep_image_submit('button_search.gif', IMAGE_BUTTON_SEARCH); ?></td>
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
 <!-- Przyciski EOF -->
 

</table>
</form>