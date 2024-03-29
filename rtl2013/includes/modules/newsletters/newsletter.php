<?php
/*
  $Id: newsletter.php 1 2007-12-20 23:52:06Z $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

// ################# Contribution Newsletter v050 ##############
  class newsletter {
    var $show_choose_audience, $newsletters_id, $module_subscribers, $title, $header, $content, $unsubscribea, $unsubscribeb;

    function newsletter($newsletters_id, $module_subscribers, $title, $header, $content, $unsubscribea, $unsubscribeb) {
      $this->show_choose_audience = false;
      $this->newsletters_id = $newsletters_id;
      $this->module_subscribers = $module_subscribers;
      $this->title = $title;
	  $this->header = $header;
      $this->content = $content;
      $this->unsubscribea = $unsubscribea;
      $this->unsubscribeb = $unsubscribeb;      					
    }
// ################# END - Contribution Newsletter v050 ##############

    function choose_audience() {
      return false;
    }

    function confirm() {
      global $HTTP_GET_VARS;

      $mail_query = tep_db_query("select count(*) as count from " . TABLE_CUSTOMERS . " where customers_newsletter = '1'");
      $mail = tep_db_fetch_array($mail_query);

// ################# Contribution Newsletter v050 ##############
      $confirm_string = '<table border="0" cellspacing="0" cellpadding="2">' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main"><font color="#ff0000"><b>' . tep_draw_separator('pixel_trans.gif', '20', '1') .  TEXT_TITRE_INFO . '</b></font></td>' . "\n" .
                        '  </tr>' . "\n" .												
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main">' . sprintf(TEXT_COUNT_CUSTOMERS, $mail['count']) . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main">' . TEXT_BULLETIN_NUMB . "&nbsp;" . '<font color="#0000ff">' . $this->newsletters_id . '</font></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main">' . TEXT_MODULE . "&nbsp;" . '<font color="#0000ff">' . $this->module_subscribers . '</font></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main">' . TEXT_TITRE_MAIL . "&nbsp;" . '<font color="#0000ff">' . $this->title . '</font></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main"><font color="#ff0000"><b>' . tep_draw_separator('pixel_trans.gif', '20', '1') . TEXT_TITRE_VIEW . '</b></font></td>' . "\n" .
                        '  </tr>' . "\n" .												
                        '  <tr>' . "\n" .
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main"><tt>' . $this->header . '</tt></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main"><tt>' . $this->content . '</tt></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main"><tt>' . $this->unsubscribea . '</tt></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td class="main"><tt>' . $this->unsubscribeb . '</tt></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .												
                        '    <td>' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
                        '  </tr>' . "\n" .
                        '  <tr>' . "\n" .
                        '    <td align="right"><a href="' . tep_href_link(FILENAME_NEWSLETTERS, 'page=' . $HTTP_GET_VARS['page'] . '&nID=' . $HTTP_GET_VARS['nID'] . '&action=confirm_send') . '">' . tep_image_button('button_send.gif', IMAGE_SEND) . '</a> <a href="' . tep_href_link(FILENAME_NEWSLETTERS, 'page=' . $HTTP_GET_VARS['page'] . '&nID=' . $HTTP_GET_VARS['nID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a></td>' . "\n" .
                        '  </tr>' . "\n" .
                        '</table>';
// ################# END - Contribution Newsletter v050 ##############

      return $confirm_string;
    }

// ################# Contribution Newsletter v050 ##############
    function send($newsletter_id) {
      $mail_query = tep_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_newsletter = '1'");

      $mimemessage = new email(array('X-Mailer: osCommerce bulk mailer'));
      // Préparation de l'envoie du mail en HTML 
      $mimemessage->add_html_newsletter($this->header . "\n\n" . $this->content . "\n\n" . $this->unsubscribeb);
      $mimemessage->build_message();
      while ($mail = tep_db_fetch_array($mail_query)) {

// ################# END - Contribution Newsletter v050 ##############
       $mimemessage->send($mail['customers_firstname'] . ' ' . $mail['customers_lastname'], $mail['customers_email_address'], '', EMAIL_FROM, $this->title);
      }

      $newsletter_id = tep_db_prepare_input($newsletter_id);
      tep_db_query("update " . TABLE_NEWSLETTERS . " set date_sent = now(), status = '1' where newsletters_id = '" . tep_db_input($newsletter_id) . "'");
    }
  }
?>
