<?php
/*
  $Id: \templates\standard\content\conditions.tpl.php; 09.07.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td class="pageHeading"><?php  echo HEADING_TITLE; ?></td>
					<td align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_payment.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
				</tr>
			</table>
		</td>
  </tr>
  <tr>
  	<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	</tr>
	<?php // Success
	if(isset($transStatus) && $transStatus == "Y") {
		$url = tep_href_link(FILENAME_CHECKOUT_PROCESS, $cartId, 'NONSSL', false);
//		echo "<meta http-equiv='Refresh' content='2; Url=\"$url\"'>";
		?>
		<tr>
			<td class="pageHeading" width="100%" colspan="2" align="center"><?php echo WP_TEXT_SUCCESS; ?></td>
		</tr>
		<tr>
			<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '50'); ?></td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<table border="2" bordercolor="#FF0000" width="80%" cellspacing="0" cellpadding="2">
					<tr>
						<td class="main" align="center"><p><?php echo WP_TEXT_HEADING; ?></p><p><?php echo '<WPDISPLAY ITEM=banner>'; ?></p></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '50'); ?></td>
		</tr>
		<tr>
			<td class="pageHeading" width="100%" colspan="2" align="center"><h3><?php echo WP_TEXT_SUCCESS_WAIT; ?></h3></td>
		</tr>
		<tr align="right">
			<td><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL', false) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
		</tr>
		<tr>
			<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '50'); ?></td>
		</tr>
		<?php // Failure
	} else {
		$url = tep_href_link(FILENAME_CHECKOUT_PAYMENT, $cartId, 'NONSSL', false);
//		echo "<meta http-equiv='Refresh' content='2; Url=\"$url\"'>";
	?>
		<tr>
			<td class="main" width="100%" colspan="2" align="center"><?php echo WP_TEXT_FAILURE; ?></td>
    </tr>
		<tr>
			<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '50'); ?></td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<table border="2" bordercolor="#FF0000" width="80%" cellspacing="0" cellpadding="2">
					<tr>
						<td class="main" align="center"><p><?php echo WP_TEXT_HEADING; ?></p><p><?php echo '<WPDISPLAY ITEM=banner>'; ?></p></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '50'); ?></td>
		</tr>
		<tr>
			<td class="main" width="100%" colspan="2" align="center"><h5><?php echo WP_TEXT_FAILURE_WAIT; ?></h5></td>
		</tr>
		<tr align="right">
			<td><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', false) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
		</tr>
		<tr>
			<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '50'); ?></td>
		</tr>
	<?php
	}
	?>
</table>