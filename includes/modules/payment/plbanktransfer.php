<?php
/*
	$Id: plbanktransfer.php,v 1.9.1 2006/07/04 12:00:00 jb_gfx

	Thanks to all the developers from the EU-Standard Bank Transfer module

	osCommerce, Open Source E-Commerce Solutions
	http://www.oscommerce.com

	Released under the GNU General Public License

           mod eSklep-Os http://www.esklep-os.com
*/

	class plbanktransfer {
		var $code, $title, $description, $enabled;

		// begin: class constructor
		function plbanktransfer() {
			global $order;

			$this->code = 'plbanktransfer';
			$this->title = MODULE_PAYMENT_PL_BANKTRANSFER_TEXT_TITLE;
			$this->description = MODULE_PAYMENT_PL_BANKTRANSFER_TEXT_DESCRIPTION;
			$this->sort_order = MODULE_PAYMENT_PL_BANKTRANSFER_SORT_ORDER;
			$this->enabled = ((MODULE_PAYMENT_PL_BANKTRANSFER == 'True') ? true : false);

			if ((int)MODULE_PAYMENT_PL_BANKTRANSFER_ID > 0) {
				$this->order_status = MODULE_PAYMENT_PL_BANKTRANSFER_ORDER_STATUS_ID;
			}

			if (is_object($order)) {
				$this->update_status();
			}
			$this->email_footer = MODULE_PAYMENT_PL_BANKTRANSFER_TEXT_EMAIL_FOOTER;
		} // end: class constructor

		// begin: class methods
		function update_status() {
			global $order;

			if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PL_BANKTRANSFER_ZONE > 0) ) {
				$check_flag = false;
				$check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_PL_BANKTRANSFER_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
				while ($check = tep_db_fetch_array($check_query)) {
					if ($check['zone_id'] < 1) {
						$check_flag = true;
						break;
					} elseif ($check['zone_id'] == $order->billing['zone_id']) {
						$check_flag = true;
						break;
					}
				}

				if ($check_flag == false) {
					$this->enabled = false;
				}
			}

			// disable the module if the order only contains virtual products
			if ( ($this->enabled == true) && ($order->content_type == 'virtual') ) {
				$this->enabled = false;
			}
		}

		function javascript_validation() {
			return false;
		}

		function selection() {
			return array(
				'id' => $this->code,
				'module' => $this->title);
		}

		function pre_confirmation_check() {
			return false;
		}

		function confirmation() {
			return array('title' => MODULE_PAYMENT_PL_BANKTRANSFER_TEXT_DESCRIPTION);
		}

		function process_button() {
			return false;
		}

		function before_process() {
			return false;
		}

		function after_process() {
			return false;
		}

		function get_error() {
			return false;
		}

		function check() {
			if (!isset($this->check)) {
				$check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PL_BANKTRANSFER'");
				$this->check = tep_db_num_rows($check_query);
			}
			return $this->check;
		}

		function install() {
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Przelew bankowy', 'MODULE_PAYMENT_PL_BANKTRANSFER', 'True', 'Czy chcesz akceptować zapłatę przelewem bankowym ?', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now());");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Nazwa Banku', 'MODULE_PAYMENT_PL_BANKNAME', 'Tutaj wpisz nazwę banku', 'Nazwa Banku', '6', '1', now());");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Nazwa konta', 'MODULE_PAYMENT_PL_ACCOUNT_HOLDER', 'Wpisz nazwę właściciela konta', 'Nazwa właściciela konta', '6', '1', now());");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Numer konta', 'MODULE_PAYMENT_PL_IBAN', '00 0000 0000 0000 0000 0000 000', 'Numer Twojego konta', '6', '1', now());");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Strefa płatności', 'MODULE_PAYMENT_PL_BANKTRANSFER_ZONE', '0', 'Jeżeli jest wybrana strefa - płatność będzie stosowana tylko do wybranej strefy.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Status zamówienia', 'MODULE_PAYMENT_PL_BANKTRANSFER_ORDER_STATUS_ID', '0', 'Ustaw Status Zamówienia', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Kolejność wyświetlania', 'MODULE_PAYMENT_PL_BANKTRANSFER_SORT_ORDER', '0', 'Kolejność wyświetlania.', '6', '0', now())");
		}

		function remove() {
			tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
		}

		function keys() {
			return $keys = array(
				'MODULE_PAYMENT_PL_BANKTRANSFER',
				'MODULE_PAYMENT_PL_BANKNAME',
				'MODULE_PAYMENT_PL_ACCOUNT_HOLDER',
				'MODULE_PAYMENT_PL_IBAN',
				'MODULE_PAYMENT_PL_BANKTRANSFER_ZONE',
				'MODULE_PAYMENT_PL_BANKTRANSFER_ORDER_STATUS_ID',
				'MODULE_PAYMENT_PL_BANKTRANSFER_SORT_ORDER');
		}
	} // end: class methods
?>