<?php
/*
  $Id: order_history.php 1 2007-12-20 23:52:06Z $

  autor: Diana Kononova
  diana@itconnection.ru
*/

  if (tep_session_is_registered('customer_id')) {
  	$orders_query = tep_db_query("select o.orders_id, o.date_purchased, ot.text as order_total from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$customer_id . "' and o.orders_id = ot.orders_id and ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' order by orders_id desc limit " . MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX);

    if (tep_db_num_rows($orders_query)) {

      $boxHeading = BOX_HEADING_CUSTOMER_ORDERS;
      $corner_left = 'rounded';
      $corner_right = 'rounded';

      $box_base_name = 'order_history'; // for easy unique box template setup (added BTSv1.2)
      $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

      $boxContent = '<table border="0" width="100%" cellspacing="0" cellpadding="1">';
	  	while ($orders = tep_db_fetch_array($orders_query)) {
 				$boxContent .= '  <tr>' .
                       '    <td class="boxContents" align="left" valign="top" nowrap><a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL') . '">' .tep_date_short($orders['date_purchased']).'</a></td><td class="boxContents" align="right">#<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL') . '">'. $orders['orders_id'].'</a></td><td class="boxContents" align="right">'.strip_tags($orders['order_total']).'</td>' .
                       '  </tr>';
	  	}
      $boxContent .= '</table>';
               
      include (bts_select('boxes', $box_base_name)); // BTS 1.5
    }
  }
?>
