<?php
/*
  $Id: menu.php 1 2007-12-20 23:52:06Z  $

  E-Commerce Solutions

  Copyright (c) 2005 www.flash-template-design.com

  Released under the GNU General Public License
*/
?>
<table border="0" height="56" cellpadding="0" cellspacing="0" width="461">
					<tr align="center">
						<td width="90" height="32"><a class="menu"  href="<?php echo tep_href_link(FILENAME_DEFAULT) ?>"><?php echo HEADER_TITLE_TOP; ?></a></td>
						<td width="2" height="56"><img src="images/menu_line.gif" width="2" height="51" alt="" style="margin-top:2px; " /></td>
						<td width="91" ><a class="menu" href="<?php echo tep_href_link(FILENAME_ACCOUNT, '', 'SSL') ?>"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a></td>
						<td width="2" height="56"><img src="images/menu_line.gif" width="2" height="51" alt="" style="margin-top:2px; " /></td>						
						<td width="91" ><a class="menu" href="<?php echo tep_href_link(FILENAME_SHOPPING_CART) ?>"><?php echo HEADER_TITLE_CART_CONTENTS; ?></a></td>
						<td width="2" height="56"><img src="images/menu_line.gif" width="2" height="51" alt="" style="margin-top:2px; " /></td>
   	  				    <td width="90"><a class="menu" href="<?php echo tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') ?>"><?php echo HEADER_TITLE_CHECKOUT; ?></a></td>
						
					</tr>
					
					
</table>

