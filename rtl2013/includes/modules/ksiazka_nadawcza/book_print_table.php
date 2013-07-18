<?
$i = 1;

while ($orders = tep_db_fetch_array($orders_query)) {

	$opis = $orders['title'];
	$wysylka = $HTTP_POST_VARS['pull_shipping'];
	$sprawdz = strpos($opis, $wysylka);

	if ($sprawdz !== false) { 

		if ($i == 1) { ?>
			<table align="center" border="0" cellspacing="0" cellpadding="1" bgcolor="#FFFFFF" width="700" valign="top">
				<tr> 
					<td><h1><strong>Imię i nazwisko (nazwa) oraz adres nadawcy</strong>&nbsp;<?php echo STORE_NAME .', ' . STORE_NAME_ADDRESS; ?></h1></td>
				</tr>
			</table>
			<table align="center" border="0" cellspacing="0" cellpadding="1" bgcolor="#FFFFFF" width="700" valign="top">
				<tr> 
					<td align="center" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;" height="70" valign="middle"><b>L.p</b></td>
					<td align="center" height="70" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>A D R E S A T<br>(imię i nazwisko lub nazwa)</b></td>
					<td align="center" height="70" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>Dokładne miejsce doręczenia</b></td>
					<td colspan="2" align="center" height="70" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>Wartość<br>Kwota</b></td>
					<td colspan="2" align="center" height="70" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>Masa</b></td>
					<td align="center" height="70" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>Nr<br>nadawczy</b></td>
					<td align="center" height="70" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>Uwagi</b></td>
					<td colspan="2" align="center" height="70" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>Opłata</b></td>
					<td colspan="2" align="center" height="70" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>Kwota<br>pobrania</b></td>
					<td colspan="2" align="center" height="70" valign="middle" class="dataTableContent" style="border-right: solid black 1px;border-left: solid black 1px; border-top: solid black 1px;"><b>Opłata za<br>pobranie</b></td>
				</tr>
				<tr> 
					<td width="10" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;">&nbsp;</td>
					<td width="140" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;">&nbsp;</td>
					<td width="150" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;">&nbsp;</td>
					<td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>zł</b></td>
					<td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>gr</b></td>
					<td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>kg</b></td>
					<td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>g</b></td>
					<td width="60" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;">&nbsp;</td>
					<td width="60" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;">&nbsp;</td>
					<td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>zł</b></td>
					<td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>gr</b></td>
					<td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>zł</b></td>
					<td width="20" align="center" valign="middle" class="dataTableContent" style=";border-left: solid black 1px; border-top: solid black 1px;"><b>gr</b></td>
					<td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;"><b>zł</b></td>
					<td width="20" align="center" valign="middle" class="dataTableContent" style="border-right: solid black 1px;border-left: solid black 1px; border-top: solid black 1px;"><b>gr</b></td>
				</tr>
				<tr> 
					<td align="center" valign="top" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px; border-bottom: solid black 1px"><b>1</b></td>
					<td align="center" valign="top" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px; border-bottom: solid black 1px"><b>2</b></td>
					<td align="center" valign="top" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px; border-bottom: solid black 1px"><b>3</b></td>
					<td colspan="2" align="center" valign="top" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px; border-bottom: solid black 1px"><b>4</b></td>
					<td colspan="2" align="center" valign="top" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px; border-bottom: solid black 1px"><b>5</b></td>
					<td align="center" valign="top" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px; border-bottom: solid black 1px"><b>6</b></td>
					<td align="center" valign="top" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px; border-bottom: solid black 1px"><b>7</b></td>
					<td colspan="2" align="center" valign="top" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px; border-bottom: solid black 1px"><b>8</b></td>
					<td colspan="2" align="center" valign="top" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px; border-bottom: solid black 1px"><b>9</b></td>
					<td colspan="2" align="center" valign="top" class="dataTableContent" style="border-right: solid black 1px;border-left: solid black 1px; border-top: solid black 1px; border-bottom: solid black 1px"><b>10</b></td>
				</tr>
				<tr> 
					<td height="30" colspan="3" width="360" align="right" valign="middle" class="dataTableContent" style="border-left: solid black 1px;">Z przeniesienia</td>
					<td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;">&nbsp;</td>
					<td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;">&nbsp;</td>
					<td colspan="4" align="right" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;">Z przeniesienia</td>
					<td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;">&nbsp;</td>
					<td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;">&nbsp;</td>
					<td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;">&nbsp;</td>
					<td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;">&nbsp;</td>
					<td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-top: solid black 1px;">&nbsp;</td>
					<td width="20" align="center" valign="middle" class="dataTableContent" style="border-right: solid black 1px;border-left: solid black 1px; border-top: solid black 1px;">&nbsp;</td>
				</tr>
			<?php 
			} 
		
			$order = new order($orders['orders_id']);

			if ($HTTP_POST_VARS['address'] == 'delivery') {
				if (isset($order->delivery['company'])) {
					$zamowienie = $order->delivery['company'];
				}
				$nazwisko = $order->delivery['name'];
				$ulica = $order->delivery['street_address'];
				$miasto = $order->delivery['postcode'].' '.$order->delivery['city'];
			} elseif ($HTTP_POST_VARS['address'] == 'billing') {
				if (isset($order->billing['company'])) {
					$zamowienie = $order->billing['company'];
				}
				$nazwisko = $order->billing['name'];
				$ulica = $order->billing['street_address'];
				$miasto = $order->billing['postcode'].' '.$order->billing['city'];
			}
			
			$ciag = $order->info['payment_method'];
			$szukany = 'Pobranie';
			$wynik = strpos($ciag, $szukany);

			if ($wynik !== false) {
				$temp_query = tep_db_query("select orders_id, class, title, text, value from " . TABLE_ORDERS_TOTAL. " where orders_id = '".$orders['orders_id']."' and class = 'ot_total' ");
				$pytanie = tep_db_fetch_array($temp_query);
				$pobranie = strip_tags($pytanie['text']);	

				$przecinek = strpos($pobranie, ',');
				$zloty = substr($pobranie, 0, $przecinek); 

				$grosze = substr($pobranie, $przecinek+1, 2);
			} else {
				$zloty = '&nbsp;';
				$grosze = '&nbsp;';
			}

		?>
		<tr> 
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;" height="70"><b><?php echo $i; ?></b></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;"><b><?php echo $nazwisko; ?></b></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;"><b><?php echo $ulica; ?><br><?php echo $miasto; ?></b></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;"><b>&nbsp;</b></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;"><b>&nbsp;</b></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;"><b>&nbsp;</b></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;"><b>&nbsp;</b></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;"><b>&nbsp;</b></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;"><b>
				<?php
				if (strpos($orders['title'], 'Priorytetowa')) {
					echo 'PRIORY';
				} elseif (strpos($orders['title'], 'Ekonomiczna')) {
					echo 'EKON';
				} else {
					echo '&nbsp;';
				}
				?>
			</b></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;"><b>&nbsp;</b></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;">&nbsp;</td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;"><b><?php echo $zloty; ?></b></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;"><strong><?php echo $grosze; ?></strong></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;"><b>&nbsp;</b></td>
			<td align="center" valign="middle" class="dataTableContent" style="border-right: solid black 1px;border-left: solid black 1px;border-top: solid black 1px;border-bottom: solid black 1px;">&nbsp;</td>
		</tr>
		<?php if ($i == 10) { ?>

		<tr> 
      <td height="30" colspan="3" width="360" align="right" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">Do przeniesienia</td>
      <td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">&nbsp;</td>
      <td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">&nbsp;</td>
      <td colspan="4" align="right" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">Do przeniesienia</td>
      <td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">&nbsp;</td>
      <td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">&nbsp;</td>
      <td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;">&nbsp;</td>
      <td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 0px;">&nbsp;</td>
      <td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">&nbsp;</td>
      <td width="20" align="center" valign="middle" class="dataTableContent" style="border-right: solid black 1px;border-left: solid black 1px; border-bottom: solid black 1px;">&nbsp;</td>
    </tr>
		<tr> 
      <td height="30" colspan="13" width="360" align="left" valign="middle" class="dataTableContent">wypełnia się tylko przy nadawaniu przekazów Rubrykę "Do przeniesienia" w kolumnie 4 Do przeniesienia</td>
    </tr>	</table>
	<div class='pagestart'></div>
	<?php } ?>

	<?php
	$i++;
	if ($i > 10) {
		$i = 1;
	}
	}

}	// EOWHILE
?>
		<tr> 
      <td height="30" colspan="3" width="360" align="right" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">Do przeniesienia</td>
      <td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">&nbsp;</td>
      <td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">&nbsp;</td>
      <td colspan="4" align="right" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">Do przeniesienia</td>
      <td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">&nbsp;</td>
      <td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">&nbsp;</td>
      <td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px;">&nbsp;</td>
      <td width="20" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 0px;">&nbsp;</td>
      <td width="40" align="center" valign="middle" class="dataTableContent" style="border-left: solid black 1px; border-bottom: solid black 1px;">&nbsp;</td>
      <td width="20" align="center" valign="middle" class="dataTableContent" style="border-right: solid black 1px;border-left: solid black 1px; border-bottom: solid black 1px;">&nbsp;</td>
    </tr>
		<tr> 
      <td height="30" colspan="13" width="360" align="left" valign="middle" class="dataTableContent">wypełnia się tylko przy nadawaniu przekazów Rubrykę "Do przeniesienia" w kolumnie 4 Do przeniesienia</td>
    </tr>	</table>
