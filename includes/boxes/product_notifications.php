<?php
/*
  $Id: \includes\boxes\product_notifications.php; 23.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

  if (isset($HTTP_GET_VARS['products_id'])) {

    $boxHeading = BOX_HEADING_NOTIFICATIONS;
    $corner_left = 'rounded';
    $corner_right = 'rounded';
    $boxLink = '<a href="' . tep_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL') . '">' .tep_image(DIR_WS_TEMPLATES . 'images/infobox/arrow_right.gif') .'</a>';

    $box_base_name = 'product_notifications'; // for easy unique box template setup (added BTSv1.2)
    $box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)

    if (tep_session_is_registered('customer_id')) {
      $check_query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS_NOTIFICATIONS . " where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and customers_id = '" . (int)$customer_id . "'");
      $check = tep_db_fetch_array($check_query);
      $notification_exists = (($check['count'] > 0) ? true : false);
    } else {
      $notification_exists = false;
    }

    if ($notification_exists == true) {

      $boxContent = '<table border="0" cellspacing="0" cellpadding="2"><tr><td class="boxContents"><a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=notify_remove', $request_type) . '">' . tep_image(DIR_WS_TEMPLATES . 'images/misc/box_products_notifications_remove.gif', IMAGE_BUTTON_REMOVE_NOTIFICATIONS) . '</a></td><td class="boxContents"><a class="boxLink" href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=notify_remove', $request_type) . '">' . sprintf(BOX_NOTIFICATIONS_NOTIFY_REMOVE, tep_get_products_name($HTTP_GET_VARS['products_id'])) .'</a></td></tr></table>';
    } else {
      $boxContent = '<table border="0" cellspacing="0" cellpadding="2"><tr><td class="boxContents"><a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=notify', $request_type) . '">' . tep_image(DIR_WS_TEMPLATES . 'images/misc/box_products_notifications.gif', IMAGE_BUTTON_NOTIFICATIONS) . '</a></td><td class="boxContents"><a class="boxLink" href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=notify', $request_type) . '">' . sprintf(BOX_NOTIFICATIONS_NOTIFY, tep_get_products_name($HTTP_GET_VARS['products_id'])) .'</a></td></tr></table>';
    }

    include (bts_select('boxes', $box_base_name)); // BTS 1.5
    $boxLink = '';

  }

?>