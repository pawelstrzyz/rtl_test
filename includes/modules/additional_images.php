<?php
/*

 mod eSklep-Os http://www.esklep-os.com

*/

?>
  <script type="text/javascript" src="includes/javascript/motiongallery.js"></script>

  <!-- additional_images //-->
	<table width="100%" align="center" cellspacing="0" cellpadding="0" border="0">
	 <tr>
	  <td align="center" valign="middle">
	     <div id="motioncontainer" style="position:relative;width:100%;height:80px;overflow:hidden;">
  	   <div id="motiongallery" style="position:absolute;left:0;top:0;white-space: nowrap;">
    	 <nobr id="trueContainer">

				<table align="center" cellspacing="0" cellpadding="0" border="0">
	 				<tr>
            <?php
       			$j = 0;
       			?>
        		<td>
							<table class="dia" cellpadding="0" cellspacing="0" width="70" height="70">
								<tr>
									<td>
										<A HREF="javascript:LoadMidPicture(<?php echo $j;?>)"><?php $obrazek = tep_obrazek(DIR_WS_IMAGES . $product_info['products_image'], 70, 70); echo '<img src="'.$obrazek.'" alt="">'; ?></a>
									</td>
								</tr>
							</table>
						</td>
						<?php
						$j++;
            while ($new_products = tep_db_fetch_array($images_product)) {
        		?>
            <td>
							<table class="dia" cellpadding="0" cellspacing="0" width="70" height="70">
								<tr>
									<td>
										<A HREF="javascript:LoadMidPicture(<?php echo $j;?>)"><?php $obrazek = tep_obrazek(DIR_WS_IMAGES . $new_products['popup_images'], 70, 70); echo '<img src="'.$obrazek.'" alt="">'; ?></a>
									</td>
								</tr>
							</table>
						</td>
         		<?php
						$j++;
        		}
        		?>
					</tr>
				</table>
     </nobr>
     </div>
     </div>
    </td>
   </tr>
	</table>
  <!-- additional_images_eof //-->