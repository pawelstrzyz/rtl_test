<?php
/*
  $Id: attributeManagerConfig.class.php,v 1.0 21/02/06 Sam West$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  
  Copyright � 2006 Kangaroo Partners
  http://kangaroopartners.com
  osc@kangaroopartners.com
*/

require_once('attributeManager/classes/amDB.class.php');
require_once('attributeManager/includes/attributeManagerSessionFunctions.inc.php');

if(file_exists('attributeManager/languages/'.$_SESSION['language'].'/attributeManager.php'))
 include_once('attributeManager/languages/'.$_SESSION['language'].'/attributeManager.php');
else
 include_once('attributeManager/languages/'.'english'.'/attributeManager.php');

class attributeManagerConfig {
	
	var $arrConfig = array();
	
	function attributeManagerConfig() {
		
		
		/**
		 * Default admin interface language id
		 */
		$this->add('AM_DEFAULT_LANGUAGE_ID',$GLOBALS['languages_id']);
		
		
		/**
		 * Dont update the database untill the untill the end of the product addition process
		 */
		$this->add('AM_ATOMIC_PRODUCT_UPDATES', false);
		
		
		/**
		 * Use attribute templates?
		 * 
		 */
		$this->add('AM_USE_TEMPLATES',true);
		
		
		/**
		 * Template Table names
		 */
		$this->add('AM_TABLE_TEMPLATES','am_templates');
		$this->add('AM_TABLE_ATTRIBUTES_TO_TEMPLATES','am_attributes_to_templates');
		
		/** 
		 * Install templates if not already done so 
		 */
		$this->installTemplates();
		
		$this->add('AM_USE_SORT_ORDER' , true);
		$this->add('AM_USE_QT_PRO' , false); // DO NOT USE STILL IN DEV
		
		/**
		 * Sort order tables
		 */
		$this->add('AM_FIELD_OPTION_SORT_ORDER','products_options_sort_order'); // Sort column on Products_options table
		$this->add('AM_FIELD_OPTION_VALUE_SORT_ORDER','products_options_sort_order'); // Sort column on product_attributes table
	
		/**
		 * Install the sort order tables if they dont already exist
		 */
		$this->installSortOrder();
		
		/**
		 * How do sort the drop down lists in the admin - purly asthetic
		 * options
		 * 1 = alpha
		 * 2 = default - by id
		 */
		$this->add('AM_DEFAULT_SORT_ORDER',1);
			
		/**
		 * Password for the session var - doesn't matter what it is. Mix it up if you fee like it :)
		 */
		$this->add('AM_VALID_INCLUDE_PASSWORD','asdfjkasdadfadsff');
		
		/**
		 * Variable names - Shouldn't need editing unless there are conflicts
		 */
		$this->add('AM_SESSION_VAR_NAME','am_session_var'); // main var for atomic
		$this->add('AM_SESSION_CURRENT_LANG_VAR_NAME','am_current_lang_session_var'); // current interface lang
		$this->add('AM_SESSION_VALID_INCLUDE','am_valid_include'); // variable set on categories.php to make sure attributeManager.php has been included
		$this->add('AM_SESSION_SORT_ORDER_INSTALL_CHECKED','am_sort_order_checked');
		$this->add('AM_SESSION_TEMPLATES_INSTALL_CHECKED','am_templates_checked');
		$this->add('AM_ACTION_GET_VARIABLE', 'amAction'); // attribute manager get variable name
		$this->add('AM_PAGE_ACTION_NAME','pageAction'); // attribute manager parent page action e.g. new_product
		
	}
	
	function load() {
		if(0 !== count($this->arrConfig))
			foreach($this->arrConfig as $key => $value)
				define($key, $value);
	}
	
	function getValue($key) {
		if(array_key_exists($key, $this->arrConfig))
			return $this->arrConfig[$key];
		return false;
	}
	
	function add($key, $value) {
		$this->arrConfig[$key] = $value;
	}
	
	function installTemplates() {
		if($this->getValue('AM_USE_TEMPLATES') && !amSessionIsRegistered($this->getValue('AM_SESSION_TEMPLATES_INSTALL_CHECKED'))) {
			
			// register the checked session so that this check is only done once per session
			amSessionRegister('AM_SESSION_TEMPLATES_INSTALL_CHECKED',true);

			amDB::query("CREATE TABLE IF NOT EXISTS ".$this->getValue('AM_TABLE_TEMPLATES')." (
					`template_id` INT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`template_name` VARCHAR( 255 ) NOT NULL
				)"
			);
			amDB::query("CREATE TABLE IF NOT EXISTS ".$this->getValue('AM_TABLE_ATTRIBUTES_TO_TEMPLATES')." (
					`template_id` INT( 5 ) UNSIGNED NOT NULL ,
					`options_id` INT( 5 ) UNSIGNED NOT NULL ,
					`option_values_id` INT( 5 ) UNSIGNED NOT NULL ,
					INDEX ( `template_id` )
				)"
			);
		}
	}
	
	function installSortOrder() {
		if($this->getValue('AM_USE_SORT_ORDER') && !amSessionIsRegistered($this->getValue('AM_SESSION_SORT_ORDER_INSTALL_CHECKED'))) {
			
			// register the checked session so that this check is only done once per session
			amSessionRegister($this->getValue('AM_SESSION_SORT_ORDER_INSTALL_CHECKED'), true);
			
			// check that the fields are in the attributes table
			$attributeFields = amDB::query("SHOW COLUMNS FROM ". TABLE_PRODUCTS_ATTRIBUTES);
			while($field = amDB::fetchArray($attributeFields)) 
				$fields[] = $field['Field'];
			
			
			$oInstalled = in_array($this->getValue('AM_FIELD_OPTION_SORT_ORDER'),$fields);
			$ovInstalled = in_array($this->getValue('AM_FIELD_OPTION_VALUE_SORT_ORDER'),$fields);
			$soInstalled = in_array($this->getValue('AM_FIELD_OPTION_SORT_ORDER'),$fields);
			// if not add them
			if(!$oInstalled) 
				amDB::query("ALTER TABLE ".TABLE_PRODUCTS_OPTIONS." ADD COLUMN ".$this->getValue('AM_FIELD_OPTION_SORT_ORDER')." INT UNSIGNED NOT NULL DEFAULT '0'");
			
			if(!$ovInstalled) 
				amDB::query("ALTER TABLE ".TABLE_PRODUCTS_ATTRIBUTES." ADD COLUMN ".$this->getValue('AM_FIELD_OPTION_VALUE_SORT_ORDER')." INT UNSIGNED NOT NULL DEFAULT '0'");
			if(!$soInstalled && $this->getValue('AM_USE_SORT_ORDER')) 
				amDB::query("ALTER TABLE ".$this->getValue('AM_TABLE_ATTRIBUTES_TO_TEMPLATES')." ADD COLUMN ".$this->getValue('AM_FIELD_OPTION_SORT_ORDER')." INT UNSIGNED NOT NULL DEFAULT '0'");
			
			// now reset all of the sort orders
			if(!$oInstalled || !$ovInstalled) {
				$allAttributes = amDB::getAll("select * from ".TABLE_PRODUCTS_ATTRIBUTES." order by products_id, options_id, options_values_id");
				
				$productId = $optionId = null;
				$oCount = $ovCount = 1;
				
				$updateValues = array();
				if(is_array($allAttributes)) {
					foreach($allAttributes as $attrib) {
						if($productId != $attrib['products_id']) {
							$oCount = $ovCount = 0;
							
						}
						if($optionId != $attrib['options_id']) {
							$oCount++;
							$ovCount = 0;
						}
						
						/** for dev only 
						$updateValues[$attrib['products_attributes_id']]['prdoucts_id'] = $attrib['products_id'];
						$updateValues[$attrib['products_attributes_id']]['options_id'] = $attrib['options_id'];
						$updateValues[$attrib['products_attributes_id']]['options_values_id'] = $attrib['options_values_id'];
						**/
						
						$updateValues[$attrib['products_attributes_id']]['option_sort'] = $oCount;
						$updateValues[$attrib['products_attributes_id']]['option_value_sort'] = ++$ovCount;
	
						
						$productId = $attrib['products_id'];
						$optionId = $attrib['options_id'];
					}
					
					foreach($updateValues as $attributeId => $sorts) 
						amDB::query("update ".TABLE_PRODUCTS_ATTRIBUTES." set ".$this->getValue('AM_FIELD_OPTION_SORT_ORDER')." = '{$sorts['option_sort']}', ".$this->getValue('AM_FIELD_OPTION_VALUE_SORT_ORDER')." = '{$sorts['option_value_sort']}' where products_attributes_id = '$attributeId' limit 1");
					
				}
				//echo '<pre style="text-align:left">'.print_r($updateValues,true);
			}
		}
	}
}

$config = new attributeManagerConfig();
$config->load();

?>