<?php
if (!$message) {
	$order_statuses = array();
	$orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $languages_id . "'");
	$orders_statuses[] = array('id' => 0, 'text' => '----------');
	while ($orders_status = tep_db_fetch_array($orders_status_query)) {
		$orders_statuses[] = array('id' => $orders_status['orders_status_id'],'text' => $orders_status['orders_status_name']);
	}
	?>

	<tr>
<!-- 	<form name="print_book" action="http://oscgold.home/administracja/ksiazka_nadawcza.php?act=1" method="post" target="_blank"> -->
		<?php echo tep_draw_form('print_book', BOOK_PRINT_FILE, 'act=1', POST, 'target="_blank"'); ?>
		<td>
	    <table border="0" cellpadding="5" cellspacing="0" width="100%" style="border-color: #424242; border-width: 1px; border-style: solid;">
    		<tr>
        	<td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
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
        	<td class="dataTableContent"><?php echo TEXT_INCLUDE_SHIPPING_METHOD; ?></td>
          <td width="50%">
	  <?php 
		  // Tworzenie listy dostepnych sposobow wysylki
			$enabled_shipping = array();
			$enabled_shipping[] = array('id' => '0', 'text' => '----------');
			$module_directory = DIR_FS_CATALOG_MODULES . 'shipping/';
			$file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));

			if ($dir = @dir($module_directory)) {
				while ($file = $dir->read()) {
					if (!is_dir( $module_directory . $file)) {
						if (substr($file, strrpos($file, '.')) == $file_extension) {
							$directory_array[] = $file;
						}
					}
				}
				sort($directory_array);
				$dir->close();
			}

			// For each available payment module, check if enabled
			for ($i=0, $n=sizeof($directory_array); $i<$n; $i++) {
				$file = $directory_array[$i];

				include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/shipping/' . $file);
				include($module_directory . $file);

				$class = substr($file, 0, strrpos($file, '.'));
				if (tep_class_exists($class)) {
					$module = new $class;
					if ($module->check() > 0) {
						// If module enabled create array of titles
      			$enabled_shipping[] = array('id' => $module->title, 'text' => $module->title);
					}
				}
			}
			echo tep_draw_pull_down_menu('pull_shipping', $enabled_shipping);
		?>
					</td>
        </tr>
        <tr class="dataTableRow">
        	<td width="50%" class="dataTableContent"> <?php echo TEXT_PRINTING_LABELS_BILLING_DELIVERY; ?></td>
          <td width="50%" class="dataTableContent"><?php echo TEXT_DELIVERY; ?><?php echo tep_draw_selection_field('address', 'radio', "delivery", true); ?><?php echo TEXT_BILLING; ?><?php echo tep_draw_selection_field('address', 'radio', "billing", false); ?></td>
        </tr>
        <tr>
        	<td class="main" colspan="2"><?php // echo TEXT_OPIS; ?></td>
        </tr>
        <tr>
        	<td align="right" colspan="2"><?php echo tep_image_submit('button_confirm.gif', IMAGE_CONFIRM); ?></td>
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