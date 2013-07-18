<?php
if (!$message) {
	$order_statuses = array();
	$orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $languages_id . "'");
	$orders_statuses[] = array('id' => 0, 'text' => '----------');
	while ($orders_status = tep_db_fetch_array($orders_status_query)) {
		$orders_statuses[] = array('id' => $orders_status['orders_status_id'],'text' => $orders_status['orders_status_name']);
	}
	$directory = 'includes/pdf_tpl';
	$resc = opendir($directory);
	if (!$resc) {
		echo "Problem opening directory $directory. Error: $php_errormsg";
	exit;
	}
	$file_type_array = array();
	while ($file = readdir($resc)) {
		$ext = strrchr($file, ".");
		if ($ext == ".php") {
			$filename = str_replace('_', " ",$file);
			$filename = str_replace('-', " ",$filename);
			$filename = str_replace($ext, "",$filename);
			$file_type_array[] = array('id' => $file,'text' => $filename);
		}
	}

  $label_type_array = array();
	$label_type_array[] = array('id' => 'L7163','text' => 'L7163 A4 99,1mm x 38.1mm');
	$label_type_array[] = array('id' => '8600','text' => '8600 letter 66.6mm x 25.4mm');
	$label_type_array[] = array('id' => '5160','text' => '5160 letter 66.675mm x 25.4mm');
	$label_type_array[] = array('id' => '5161','text' => '5161 letter 101.6mm 25.4mm');
	$label_type_array[] = array('id' => '5162','text' => '5162 letter 100.807mm x 35.72mm');
	$label_type_array[] = array('id' => '5163','text' => '5163 letter 101.6mm x 50.8mm');
	$label_type_array[] = array('id' => '5164','text' => '5164 letter 4.0in x 3.33in');
	$label_type_array[] = array('id' => '0001','text' => '0001 A4 66.0mm x 34.00mm');
	?>

	<tr>
		<?php echo tep_draw_form('batch', FILENAME_BATCH_PRINT, 'act=1'); ?>
		<td>
	    <table border="0" cellpadding="5" cellspacing="0" width="100%" style="border-color: #424242; border-width: 1px; border-style: solid;">
    		<tr>
        	<td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
        </tr>
        <tr class="dataTableRow">
        	<td class="dataTableContent"><?php echo TEXT_CHOOSE_TEMPLATE; ?></td>
          <td width="50%"><?php echo tep_draw_pull_down_menu('file_type', $file_type_array, 1); ?></td>
        </tr>
        <tr class="dataTableRow">
        	<td class="dataTableContent"><?php echo TEXT_CHOOSE_LABEL; ?></td>
          <td width="50%"><?php echo tep_draw_pull_down_menu('label_type', $label_type_array, 1); ?></td>
        </tr>
        <tr class="dataTableRow">
					<td class="dataTableContent" width="50%"><?php echo TEXT_ORDER_NUMBERS_RANGES; ?></td>
          <td width="50%" class="dataTableContent"><?php echo tep_draw_input_field('invoicenumbers'); ?></td>
        </tr>
        <tr class="dataTableRow">
		   		<td class="dataTableContent" width="50%"><?php echo TEXT_DATES_ORDERS_EXTRACTRED; ?></td>
          <td width="50%" class="dataTableContent">
            <table border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td class="dataTableContent">
          				<?php echo TEXT_FROM; ?><script language="javascript">dateAvailable.writeControl(); dateAvailable.dateFormat="yyyy-MM-dd";</script></td>
                <td class="dataTableContent">
            			<?php echo TEXT_TO; ?>  <script language="javascript">dateAvailable1.writeControl(); dateAvailable1.dateFormat="yyyy-MM-dd";</script></td>
							</tr>
						</table>
					</td>
        </tr>
        <tr class="dataTableRow">
        	<td class="dataTableContent"><?php echo TEXT_INCLUDE_ORDERS_STATUS; ?></td>
          <td width="50%"><?php echo tep_draw_pull_down_menu('pull_status', $orders_statuses, 0); ?></td>
        </tr>
        <tr class="dataTableRow">
        	<td width="50%" class="dataTableContent"> <?php echo TEXT_PRINTING_LABELS_BILLING_DELIVERY; ?></td>
          <td width="50%" class="dataTableContent"><?php echo TEXT_DELIVERY; ?><?php echo tep_draw_selection_field('address', 'radio', "delivery", true); ?><?php echo TEXT_BILLING; ?><?php echo tep_draw_selection_field('address', 'radio', "billing", false); ?></td>
        </tr>
        <tr class="dataTableRow">
		   		<td class="dataTableContent" width="50%"><?php echo TEXT_POSITION_START_PRINTING_COL; ?></td>
          <td width="50%" class="dataTableContent"><?php echo tep_draw_input_field('startcol', '1'); ?></td>
        </tr>
        <tr class="dataTableRow">
		   		<td class="dataTableContent" width="50%"><?php echo TEXT_POSITION_START_PRINTING_ROW; ?></td>
          <td width="50%" class="dataTableContent"><?php echo tep_draw_input_field('startrow', '1'); ?></td>
        </tr>

        <tr>
        	<td class="main" colspan="2"><?php echo TEXT_OPIS; ?></td>
        </tr>
        <tr>
        	<td align="right" colspan="2"><?php echo tep_image_submit('button_send.gif', IMAGE_SEND_EMAIL); ?></td>
        </tr>
			</table>
		</td>
		</form>
	</tr>
<?php
} else {
?>
	<tr>
		<td>
	  	<table border="0" cellpadding="5" cellspacing="0" width="100%">
      	<tr>
        	<td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
        </tr>
        <tr class="dataTableRowSelected">
					<td class="dataTableContent" width="50%"><b>Informacja :</b></td>
				</tr>
        <tr class="dataTableRow">
        	<td class="dataTableContent"><?php echo $message; ?></td>
        </tr>
			</table>
		</td>
	</tr>
<?php
}
?>