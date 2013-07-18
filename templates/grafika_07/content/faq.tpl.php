<?php
/*
  $Id: \templates\standard\content\logoff.tpl.php; 10.07.2006

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

 <!-- Naglowek BOF -->
	<tr>  
      <td height="40" class="infoBoxHeading"><img src="templates/grafika_07/images/infobox/corner_left.gif" border="0" alt="" width="22" height="40"></td>
      <td height="35" class="infoBoxHeading" width="100%"><?php echo HEADING_TITLE; ?></td>
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
   <table width="100%" cellspacing="1" cellpadding="2" class="infoBox">
    <tr class="infoBoxContents">
     <td>
      <table width="100%" cellspacing="0" cellpadding="2">
       <tr>
        <td><?php echo tep_image(DIR_WS_TEMPLATES . 'images/logoff.gif', HEADING_TITLE); ?></td>
        <td valign="top">
         <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
           <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
           <td class="main">
					 
						<table border="0" width="100%" cellspacing="0" cellpadding="2">
							<?
							$faq_query = tep_db_query('select f.faq_id, fd.faq_question, fd.faq_answer, f.last_modified, f.sort_order, f.faq_status from '.TABLE_FAQ.' f,  '.TABLE_FAQ_DESCRIPTION.' fd where f.faq_id=fd.faq_id and f.faq_status and fd.language_id='.$_SESSION['languages_id'].' order by f.sort_order, fd.faq_question');
							$count = 1;
							while($faq = tep_db_fetch_array($faq_query)){
								?>
								<tr>
									<td class="main"><b style="cursor:pointer;" onclick="showItem('faq_answer_<?=$faq['faq_id'];?>')"><?=$count.'. '.$faq['faq_question'];?></b></td>
								</tr>
								<tr>
									<td style="padding-top:5px;display:none;" id="faq_answer_<?=$faq['faq_id'];?>">
										<table border="0" cellspacing="0" cellpadding="2">
											<tr>
	            					<td class="main"><?=$faq['faq_answer'];?></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td><?=tep_draw_separator('pixel_trans.gif', '100%', '5')?></td>
								</tr>
								<?
								$count++;
							}
							?>
						</table>					 
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
        <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
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