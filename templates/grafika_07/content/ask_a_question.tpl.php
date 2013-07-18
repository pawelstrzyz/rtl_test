<?php
/*
  $Id: \templates\standard\content\ask_a_question.tpl.php; 09.07.2006

  oscGold, Autorska dystrybucja osCommerce
  http://www.oscgold.com
  autor: Jacek Krysiak

  Licencja: GNU General Public License
*/
?>

<?php echo tep_draw_form('email_friend', tep_href_link(FILENAME_ASK_QUESTION, 'action=process&products_id=' . $HTTP_GET_VARS['products_id'])); ?>

	<table border="0" width="100%" cellspacing="0" cellpadding="0">

		<!-- Naglowek BOF -->
	<tr>  
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="22" height="40"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo NAVBAR_TITLE; ?></td>
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_right.gif" border="0" alt="" width="16" height="40"></td>	
	</tr> 
 </table></td>
      </tr>	  
	      <tr>
            <td>
		       <table border="0" width="100%" cellspacing="0" cellpadding="5" class="infoBoxContents_Box">
 		<!-- Naglowek EOF -->

 		<tr>
  		<td>
   			<table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    			<tr class="infoBoxContents">
     				<td>
      				<table border="0" width="100%" cellspacing="0" cellpadding="2">
       					<tr>
        					<td>
         						<table border="0" width="100%" cellspacing="0" cellpadding="2">
          						<tr>
           							<td class="main"><b><?php echo sprintf(HEADING_TITLE, $product_info['products_name']); ?> - (<?php echo $product_info['products_model'] ?>)</b></td>
           							<td class="main" align="center"><?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image'], $product_info['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT); ?></td>
          						</tr>
         						</table>
        					</td>
       					</tr>
       					<tr>
        					<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       					</tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main"><b><?php echo FORM_TITLE_CUSTOMER_DETAILS; ?></b></td>
                <td class="inputRequirement" align="right"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
              <tr class="infoBoxContents">
                <td><table border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="main"><?php echo FORM_FIELD_CUSTOMER_NAME; ?></td>
                    <td class="main"><?php echo tep_draw_input_field('from_name'); ?></td>
                  </tr>
                  <tr>
                    <td class="main"><?php echo FORM_FIELD_CUSTOMER_EMAIL; ?></td>
                    <td class="main"><?php echo tep_draw_input_field('from_email_address'); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td><?php echo tep_draw_hidden_field('to_email_address', STORE_OWNER_EMAIL_ADDRESS) . '&nbsp;<span class="inputRequirement">' . '</span>'; ?><?php echo tep_draw_hidden_field('to_name', STORE_OWNER) . '&nbsp;<span class="inputRequirement">' . '</span>'; ?></td>
          </tr>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><b><?php echo FORM_TITLE_FRIEND_MESSAGE; ?></b></td>
          </tr>
          <tr>
            <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
              <tr class="infoBoxContents">
                <td><?php echo tep_draw_textarea_field('message', 'soft', 40, 8); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>


       <?php
       // BOF Anti Robot Registration v2.5
       if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'ask_a_question') &&  ASKAQUESTION_VALIDATION == 'true') {
       ?>
       <tr>
        <td class="main"><b><?php echo CATEGORY_ANTIROBOTREG; ?></b></td>
       </tr>
       <tr>
        <td>
         <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr class="infoBoxContents">
           <td>
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
             <?php
             if (ACCOUNT_VALIDATION == 'true' && strstr($PHP_SELF,'ask_a_question') && ASKAQUESTION_VALIDATION == 'true') {
              if ($is_read_only == false || (strstr($PHP_SELF,'ask_a_question')) ) {
               $sql = "DELETE FROM " . TABLE_ANTI_ROBOT_REGISTRATION . " WHERE timestamp < '" . (time() - 3600) . "' OR session_id = '" . tep_session_id() . "'";
               if( !$result = tep_db_query($sql) ) { die('Could not delete validation key'); }
               $reg_key = gen_reg_key();
               $sql = "INSERT INTO ". TABLE_ANTI_ROBOT_REGISTRATION . " VALUES ('" . tep_session_id() . "', '" . $reg_key . "', '" . time() . "')";
               if( !$result = tep_db_query($sql) ) { die('Could not check registration information'); }
               ?>
               <tr>
                <td class="main">
                 <table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                   <td class="main">
                    <table border="0" cellspacing="0" cellpadding="2" width="100%">
                     <tr>
                      <td class="main"><?php echo ENTRY_ANTIROBOTREG; ?></td>
                      <td class="main" align="center">
                       <?php
                       $check_anti_robotreg_query = tep_db_query("select session_id, reg_key, timestamp from anti_robotreg where session_id = '" . tep_session_id() . "'");
                       $new_guery_anti_robotreg = tep_db_fetch_array($check_anti_robotreg_query);
                       $validation_images = '<img src="validation_png.php?rsid=' . $new_guery_anti_robotreg['session_id'] . '">';
                       if ($entry_antirobotreg_error == true) {
                        ?>
                        <td>
                        <?php
                        echo $validation_images . '</td><td valign="middle">';
                        echo tep_draw_input_field('antirobotreg') . '</td>';
                       } else {
                        ?>
                        <td>
                        <?php
                        echo $validation_images . '</td><td valign="middle">';
                        echo tep_draw_input_field('antirobotreg', $account['entry_antirobotreg']) . '</td>';
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
               <?php
              }
             }
             ?>
            </table>
           </td>
          </tr>
         </table>
        </td>
       </tr>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>
       <?php
       }
       // EOF Anti Robot Registration v2.5
       ?>


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
        					<td><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['products_id']) . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
        					<td align="right"><?php echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
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
</form>