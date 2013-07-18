<?php
/*
  $Id: create_account.php 61 2008-02-12 21:10:21Z jmk $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

require('includes/application_top.php');

// BOF Anti Robot Validation v2.4
if (ACCOUNT_VALIDATION == 'true' && ACCOUNT_CREATE_VALIDATION == 'true') {
    require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_VALIDATION);
    include_once('includes/functions/' . FILENAME_ACCOUNT_VALIDATION);
}
// EOF Anti Robot Registration v2.4

// Ingo PWA
if (isset($HTTP_GET_VARS['guest']) && $cart->count_contents() < 1) tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));

// needs to be included earlier to set the success message in the messageStack
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CREATE_ACCOUNT);

// Signup_Confirm_Emailrevision Start
$new_password = tep_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
$crypted_password = tep_encrypt_password($new_password);
// Signup_Confirm_Emailrevision End

$process = false;
// +Country-State Selector
$refresh = false;
if (isset($HTTP_POST_VARS['action']) && (($HTTP_POST_VARS['action'] == 'process') || ($HTTP_POST_VARS['action'] == 'refresh'))) {
  if ($HTTP_POST_VARS['action'] == 'process')  $process = true;
    if ($HTTP_POST_VARS['action'] == 'refresh') $refresh = true;
    // -Country-State Selector
	
	  // -------------------- POCZATEK
	  // SPRAWDZA CZY WYBRANO FIRME
	  $osoba = tep_db_prepare_input($HTTP_POST_VARS['osoba']);
	  if ($osoba == 'firma') {
	      // definicja zmiennych pobranych z formularza
          $company = tep_db_prepare_input($HTTP_POST_VARS['company']);								//nazwa firmy
          $nip = tep_db_prepare_input($HTTP_POST_VARS['nip']);										//NIP
	      $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);					//mail
		  $email_address_confirm = tep_db_prepare_input($HTTP_POST_VARS['email_address_confirm']);	//mail powtorzony
		  $street_address = tep_db_prepare_input($HTTP_POST_VARS['street_address']);				//ulica
	      $postcode = tep_db_prepare_input($HTTP_POST_VARS['postcode']);							//kod pocztowy
	      $city = tep_db_prepare_input($HTTP_POST_VARS['city']);									//miasto
		  if (ACCOUNT_SUBURB == 'true') $suburb = tep_db_prepare_input($HTTP_POST_VARS['suburb']);  //dzielnica
	      if (ACCOUNT_STATE == 'true') {															//wojewodztwo - jezeli jest wlaczone w ADMIN
	        $state = tep_db_prepare_input($HTTP_POST_VARS['state']);
	        if (isset($HTTP_POST_VARS['zone_id'])) {
	          $zone_id = tep_db_prepare_input($HTTP_POST_VARS['zone_id']);
	        } else {
	          $zone_id = false;
	        }
	      }
	      $country = tep_db_prepare_input($HTTP_POST_VARS['country']);								//panstwo	  
		  $firstname = tep_db_prepare_input($HTTP_POST_VARS['firstname']);							//imie
          $lastname = tep_db_prepare_input($HTTP_POST_VARS['lastname']);							//nazwisko
		  $telephone = tep_db_prepare_input($HTTP_POST_VARS['telephone']);							//telefon
          $fax = tep_db_prepare_input($HTTP_POST_VARS['fax']);										//fax
	  }
	  // ------------------------ KONIEC
	  
	  // -------------------- POCZATEK
	  // SPRAWDZA CZY WYBRANO FIRME
	  $osoba = tep_db_prepare_input($HTTP_POST_VARS['osoba']);
	  if ($osoba == 'fizyczna') {
	      // definicja zmiennych pobranych z formularza
		  if (ACCOUNT_GENDER == 'true') {															//plec
	        if (isset($HTTP_POST_VARS['gender'])) {
	          $gender = tep_db_prepare_input($HTTP_POST_VARS['gender']);
	        } else {
	          $gender = false;
	        }
	      }
		  $firstname = tep_db_prepare_input($HTTP_POST_VARS['firstname']);							//imie
          $lastname = tep_db_prepare_input($HTTP_POST_VARS['lastname']);							//nazwisko
		  if (ACCOUNT_NIP == 'true') $nip = tep_db_prepare_input($HTTP_POST_VARS['nip']);			//NIP
		  if (ACCOUNT_DOB == 'true') $dob = tep_db_prepare_input($HTTP_POST_VARS['dob']);			//data urodzenia
		  $street_address = tep_db_prepare_input($HTTP_POST_VARS['street_address']);				//ulica
		  if (ACCOUNT_SUBURB == 'true') $suburb = tep_db_prepare_input($HTTP_POST_VARS['suburb']);  //dzielnica		  
	      $postcode = tep_db_prepare_input($HTTP_POST_VARS['postcode']);							//kod pocztowy
	      $city = tep_db_prepare_input($HTTP_POST_VARS['city']);									//miasto
	      if (ACCOUNT_STATE == 'true') {															//wojewodztwo - jezeli jest wlaczone w ADMIN
	        $state = tep_db_prepare_input($HTTP_POST_VARS['state']);
	        if (isset($HTTP_POST_VARS['zone_id'])) {
	          $zone_id = tep_db_prepare_input($HTTP_POST_VARS['zone_id']);
	        } else {
	          $zone_id = false;
	        }
	      }
	      $country = tep_db_prepare_input($HTTP_POST_VARS['country']);								//panstwo	  		  
	      $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);					//mail
		  $email_address_confirm = tep_db_prepare_input($HTTP_POST_VARS['email_address_confirm']);	//mail powtorzony
		  $telephone = tep_db_prepare_input($HTTP_POST_VARS['telephone']);							//telefon
          $fax = tep_db_prepare_input($HTTP_POST_VARS['fax']);										//fax
	  }
	  // ------------------------ KONIEC	  

      $polecajacy = tep_db_prepare_input($HTTP_POST_VARS['polecajacy']);
      if (isset($HTTP_POST_VARS['newsletter'])) {
        $newsletter = tep_db_prepare_input($HTTP_POST_VARS['newsletter']);
      } else {
        $newsletter = false;
      }
      // Signup_Confirm_Emailrevision Start
      //    $password = tep_db_prepare_input($HTTP_POST_VARS['password']);
      //    $confirmation = tep_db_prepare_input($HTTP_POST_VARS['confirmation']);
      $password = $new_password;
      $confirmation = $new_password;
      // Signup_Confirm_Emailrevision End

      // BOC Added for Account Agreement
      $agreement = tep_db_prepare_input($HTTP_POST_VARS['agreement']);
      // EOC Added for Account Agreement

      // BOF Anti Robot Registration v2.4
      if (ACCOUNT_VALIDATION == 'true' && ACCOUNT_CREATE_VALIDATION == 'true') {
        $antirobotreg = tep_db_prepare_input($HTTP_POST_VARS['antirobotreg']);
      }
      // EOF Anti Robot Registration v2.4

      // FUNKCJA WARUNKOWA JEZELI ZOSTAL WYSLANY FORMULARZ (SPRAWDZA BLEDY)
      if ($process) {
        $error = false;
		
		// SPRAWDZA CZY WYBRANO FIRME -----------------------------------------------------------------------------------------------------------------------------------
	    $osoba = tep_db_prepare_input($HTTP_POST_VARS['osoba']);
	    if ($osoba == 'firma') {
	    
			//sprawdza czy wypelnione pole firma
			if (strlen($company) < ENTRY_COMPANY_MIN_LENGTH) {
				$error = true;
				$messageStack->add('create_account', ENTRY_COMPANY_ERROR);
			}
			//sprawdza czy wypelnione pole NIP
			if (strlen($nip) < ENTRY_NIP_MIN_LENGTH) {
				$error = true;
				$messageStack->add('create_account', ENTRY_NIP_ERROR);
			}
			//sprawdza adres email oraz zgodnosc powtorzonego adresu
		    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
		    	$error = true;
			    $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
		    } elseif (tep_validate_email($email_address) == false) {
			    $error = true;
			    $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
		    } elseif ($email_address != $email_address_confirm) {
			    $error = true;
			    $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CONFIRM_NOT_MATCHING);
		    } else {
			    $check_email_query = tep_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
			    $check_email = tep_db_fetch_array($check_email_query);
			  if ($check_email['total'] > 0) {
			    $error = true;
			    $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
			  }
		    }	
			//sprawdza czy wypelnione pole ulica
	        if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
	           $error = true;
	           $messageStack->add('create_account', ENTRY_STREET_ADDRESS_ERROR);
	        }
			//sprawdza czy wypelnione pole kod pocztowy
	        if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
	           $error = true;
	           $messageStack->add('create_account', ENTRY_POST_CODE_ERROR);
	        }
			//sprawdza czy wypelnione pole miasto
	        if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
	           $error = true;
	           $messageStack->add('create_account', ENTRY_CITY_ERROR);
	        }		
            //sprawdza czy wypelnione pole wojewodztwo
	        if (ACCOUNT_STATE == 'true') {
	          // +Country-State Selector
	          if ($zone_id == 0) {
	          // -Country-State Selector
	            if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
	              $error = true;
	              $messageStack->add('create_account', ENTRY_STATE_ERROR);
	            }
	          }
	        }	
			//sprawdza czy wybrane panstwo
	        if (is_numeric($country) == false) {
	          $error = true;
	          $messageStack->add('create_account', ENTRY_COUNTRY_ERROR);
	        }	
			//sprawdza czy wypelnione pole imie
            if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
               $error = true;
               $messageStack->add('create_account', ENTRY_FIRST_NAME_ERROR);
            }
			//sprawdza czy wypelnione pole nazwisko
            if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
               $error = true;
               $messageStack->add('create_account', ENTRY_LAST_NAME_ERROR);
            }	
			//sprawdza czy wypelnione pole telefon
			if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
			   $error = true;
			   $messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);
			}
			
		}
		  		  
		// SPRAWDZA CZY WYBRANO OSOBE FIZYCZNA --------------------------------------------------------------------------------------------------------------------------
	    $osoba = tep_db_prepare_input($HTTP_POST_VARS['osoba']);
	    if ($osoba == 'fizyczna') {
		
			//sprawdza czy zaznaczone plec	
	        if (ACCOUNT_GENDER == 'true' && ENTRY_GENDER_TEXT != '') {
	          if ( ($gender != 'm') && ($gender != 'f') ) {
	            $error = true;
	            $messageStack->add('create_account', ENTRY_GENDER_ERROR);
	          }
	        }		
			//sprawdza czy wypelnione pole imie
            if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
               $error = true;
               $messageStack->add('create_account', ENTRY_FIRST_NAME_ERROR);
            }
			//sprawdza czy wypelnione pole nazwisko
            if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
               $error = true;
               $messageStack->add('create_account', ENTRY_LAST_NAME_ERROR);
            }
			//sprawdza czy wypelnione pole NIP
			//if (ACCOUNT_NIP == 'true') {
			//	if (strlen($nip) < ENTRY_NIP_MIN_LENGTH) {
			//		$error = true;
			//		$messageStack->add('create_account', ENTRY_NIP_ERROR);
			//	}
			//}
			//sprawdza czy wypelnione pole data urodzenia		
	        if (ACCOUNT_DOB == 'true' && ENTRY_DATE_OF_BIRTH_TEXT != '') {
	          if (checkdate(substr(tep_date_raw($dob), 4, 2), substr(tep_date_raw($dob), 6, 2), substr(tep_date_raw($dob), 0, 4)) == false) {
	            $error = true;
	            $messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);
	          }
	        }			
			//sprawdza czy wypelnione pole ulica
	        if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
	           $error = true;
	           $messageStack->add('create_account', ENTRY_STREET_ADDRESS_ERROR);
	        }
			//sprawdza czy wypelnione pole kod pocztowy
	        if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
	           $error = true;
	           $messageStack->add('create_account', ENTRY_POST_CODE_ERROR);
	        }
			//sprawdza czy wypelnione pole miasto
	        if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
	           $error = true;
	           $messageStack->add('create_account', ENTRY_CITY_ERROR);
	        }		
            //sprawdza czy wypelnione pole wojewodztwo
	        if (ACCOUNT_STATE == 'true') {
	          // +Country-State Selector
	          if ($zone_id == 0) {
	          // -Country-State Selector
	            if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
	              $error = true;
	              $messageStack->add('create_account', ENTRY_STATE_ERROR);
	            }
	          }
	        }	
			//sprawdza czy wybrane panstwo
	        if (is_numeric($country) == false) {
	          $error = true;
	          $messageStack->add('create_account', ENTRY_COUNTRY_ERROR);
	        }							
			//sprawdza adres email oraz zgodnosc powtorzonego adresu
		    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
		    	$error = true;
			    $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
		    } elseif (tep_validate_email($email_address) == false) {
			    $error = true;
			    $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
		    } elseif ($email_address != $email_address_confirm) {
			    $error = true;
			    $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CONFIRM_NOT_MATCHING);
		    } else {
			    $check_email_query = tep_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
			    $check_email = tep_db_fetch_array($check_email_query);
			  if ($check_email['total'] > 0) {
			    $error = true;
			    $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
			  }
		    }	
			//sprawdza czy wypelnione pole telefon
			if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
			   $error = true;
			   $messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);
			}			
		}
		  
      // BOF Anti Robotic Registration v2.4
      if (ACCOUNT_VALIDATION == 'true' && ACCOUNT_CREATE_VALIDATION == 'true') {
        $sql = "SELECT * FROM " . TABLE_ANTI_ROBOT_REGISTRATION . " WHERE session_id = '" . tep_session_id() . "' LIMIT 1";
        if( !$result = tep_db_query($sql) ) {
          $error = true;
          $entry_antirobotreg_error = true;
          $text_antirobotreg_error = ERROR_VALIDATION_1;
        } else {
          $entry_antirobotreg_error = false;
          $anti_robot_row = tep_db_fetch_array($result);
          if (( strtoupper($HTTP_POST_VARS['antirobotreg']) != $anti_robot_row['reg_key'] ) || ($anti_robot_row['reg_key'] == '') || (strlen($antirobotreg) != ENTRY_VALIDATION_LENGTH)) {
            $error = true;
            $entry_antirobotreg_error = true;
            $text_antirobotreg_error = ERROR_VALIDATION_2;
          } else {
            $sql = "DELETE FROM " . TABLE_ANTI_ROBOT_REGISTRATION . " WHERE session_id = '" . tep_session_id() . "'";
            if( !$result = tep_db_query($sql) ) {
              $error = true;
              $entry_antirobotreg_error = true;
              $text_antirobotreg_error = ERROR_VALIDATION_3;
            } else {
              $sql = "OPTIMIZE TABLE " . TABLE_ANTI_ROBOT_REGISTRATION . "";
              if( !$result = tep_db_query($sql) ) {
                $error = true;
                $entry_antirobotreg_error = true;
                $text_antirobotreg_error = ERROR_VALIDATION_4;
              } else {
                $entry_antirobotreg_error = false;
              }
            }
          }
        }
        if ($entry_antirobotreg_error == true) $messageStack->add('create_account', $text_antirobotreg_error);
      }
      // EOF Anti Robotic Registration v2.4

      // Ingo PWA
      if (!isset($HTTP_GET_VARS['guest'])) {

       // Signup_Confirm_Emailrevision Start
       /*

      if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_PASSWORD_ERROR);
      } elseif ($password != $confirmation) {
        $error = true;
        $messageStack->add('create_account', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
      }
      */
      // Signup_Confirm_Emailrevision Ende

	    } // Ingo PWA

      // BOC Added for Account Agreement
      if ($agreement == false) {
        $error = true;
        $messageStack->add('create_account',ENTRY_AGREEMENT_ERROR);
      }
      // EOC Added for Account Agreement

      if ($polecajacy != '') {
          $polecajacy_status = '1';
          $sprawdz_email_query = tep_db_query("select customers_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($polecajacy) . "'");
          $sprawdz_email = tep_db_fetch_array($sprawdz_email_query);
          $polecajacy_id = $sprawdz_email['customers_id'];

	        $customer_order = tep_db_query("select count(*) as total from " . TABLE_ORDERS . " where customers_id = '" . (int)$polecajacy_id . "' and orders_status = '".PROMO_POLECONY_ORDER_STATUS_ID."'");
          $check = tep_db_fetch_array($customer_order);
          if ($check['total'] < '1') {
  	         $error = true;
             $messageStack->add('create_account', ENTRY_POLECAJACY_ORDERS_ERROR);
	        }

      }
///////////////////////////////////////////////////////////////////////////
      if ($error == false) {

        if ( NEW_CUSTOMERS_ENABLED == 'true') $cust_status = 1;
        else $cust_status = 0;

         $sql_data_array = array('customers_firstname' => $firstname,
                              'customers_lastname' => $lastname,
                              'customers_email_address' => $email_address,
                              'customers_telephone' => $telephone,
                              'customers_fax' => $fax,
                              'customers_newsletter' => $newsletter,
							                'customers_agreement' => $agreement,
							                'customers_password' => tep_encrypt_password($password),
                              'customers_polecony' => $polecajacy_status,
                              'customers_polecajacy_id' => $polecajacy_id,
                              'customers_status' => $cust_status);

         if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
         if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = tep_date_raw($dob);

         // Ingo PWA Begin
         if (isset($HTTP_GET_VARS['guest']) && (defined('PURCHASE_WITHOUT_ACCOUNT') && (PURCHASE_WITHOUT_ACCOUNT == 'true'))) {
           $pwa_array_customer = $sql_data_array;
           $customer_id = 0;
           tep_session_register('pwa_array_customer');
         } else {
         // Ingo PWA Ende

           tep_db_perform(TABLE_CUSTOMERS, $sql_data_array);

           $customer_id = tep_db_insert_id();

         } // Ingo PWA

         $sql_data_array = array('customers_id' => $customer_id,
                              'entry_firstname' => $firstname,
                              'entry_lastname' => $lastname,
                              'entry_street_address' => $street_address,
                              'entry_postcode' => $postcode,
                              'entry_city' => $city,
                              'entry_country_id' => $country);

         if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;
         $sql_data_array['entry_company'] = $company;
         if (ACCOUNT_NIP == 'true') $sql_data_array['entry_nip'] = $nip;
         if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb;
         if (ACCOUNT_STATE == 'true') {
           if ($zone_id > 0) {
            $sql_data_array['entry_zone_id'] = $zone_id;
            $sql_data_array['entry_state'] = '';
           } else {
            $sql_data_array['entry_zone_id'] = '0';
            $sql_data_array['entry_state'] = $state;
           }
         }

         // Ingo PWA Begin
        if (isset($HTTP_GET_VARS['guest'])) {
          $pwa_array_address = $sql_data_array;
          tep_session_register('pwa_array_address');
          $address_id = 0;
        } else {
        // Ingo PWA Ende

          tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

          $address_id = tep_db_insert_id();

          tep_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$address_id . "' where customers_id = '" . (int)$customer_id . "'");

          tep_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customer_id . "', '0', now())");

        } // Ingo PWA

        if (SESSION_RECREATE == 'True') {
          tep_session_recreate();
        }

        $customer_first_name = $firstname;
        $customer_default_address_id = $address_id;
        $customer_country_id = $country;
        $customer_zone_id = $zone_id;
        tep_session_register('customer_id');
        tep_session_register('customer_first_name');
        tep_session_register('customer_default_address_id');
        tep_session_register('customer_country_id');
        tep_session_register('customer_zone_id');

        // Ingo PWA
        if (isset($HTTP_GET_VARS['guest'])) tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING));

          // restore cart contents
          $cart->restore_contents();

          // build the message content
          $name = $firstname . ' ' . $lastname;

          if (ACCOUNT_GENDER == 'true') {
            if ($gender == 'm') {
              $email_text = sprintf(EMAIL_GREET_MR, $lastname);
            } else {
              $email_text = sprintf(EMAIL_GREET_MS, $lastname);
            }
          } else {
            $email_text = sprintf(EMAIL_GREET_NONE, $firstname);
          }

          // Signup_Confirm_Emailrevision Start
          $temat = MakeUTF(EMAIL_SUBJECT);
	      $email_text .= EMAIL_WELCOME . EMAIL_USERNAME . EMAIL_PASSWORD . stripslashes($new_password) . "\n\n" . EMAIL_TEXT . EMAIL_CONTACT;
	      tep_mail($name, $email_address, $temat, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
          // Signup_Confirm_Emailrevision Ende

          //TotalB2B start
          if (NEW_CUSTOMERS_ENABLED == 'false') {
            $temat_validate = MakeUTF(EMAIL_VALIDATE_SUBJECT);
            $email_validate_text = EMAIL_VALIDATE . " \n\n" . EMAIL_VALIDATE_PROFILE . " " . tep_href_link('admin/customers.php','cID='.$customer_id.'&action=edit', 'SSL') . " \n" . EMAIL_VALIDATE_ACTIVATE . " " . tep_href_link('admin/customers.php','action=setflag&flag=1&cID='.$customer_id, 'SSL');
      
            tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $temat_validate, $email_validate_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
          }
          //TotalB2B end
          $customersenable = NEW_CUSTOMERS_ENABLED; 
          if ($customersenable=='false') {
            tep_session_unregister('customer_id');
            tep_session_unregister('customer_default_address_id');
            tep_session_unregister('customer_first_name');
            tep_session_unregister('customer_country_id');
            tep_session_unregister('customer_zone_id');
            tep_session_unregister('comments');
          }
          tep_redirect(tep_href_link(FILENAME_CREATE_ACCOUNT_SUCCESS, '', 'SSL'));
        }
      }

      // +Country-State Selector 
    }
    if ($HTTP_POST_VARS['action'] == 'refresh') {$state = '';}
    if (!isset($country)){$country = DEFAULT_COUNTRY;}
    // -Country-State Selector

    // Ingo PWA
    if (tep_session_is_registered('pwa_array_customer') && tep_session_is_registered('pwa_array_address')) {
      $gender = isset($pwa_array_customer['customers_gender'])?$pwa_array_customer['customers_gender']:'';
      $company = isset($pwa_array_address['entry_company'])? $pwa_array_address['entry_company']:'';
      $firstname = isset($pwa_array_customer['customers_firstname'])? $pwa_array_customer['customers_firstname']:'';
      $lastname = isset($pwa_array_customer['customers_lastname'])? $pwa_array_customer['customers_lastname']:'';
      $dob = isset($pwa_array_customer['customers_dob'])? substr($pwa_array_customer['customers_dob'],-2).'.'.substr($pwa_array_customer['customers_dob'],4,2).'.'.substr($pwa_array_customer['customers_dob'],0,4):'';
      $email_address = isset($pwa_array_customer['customers_email_address'])? $pwa_array_customer['customers_email_address']:'';
      $street_address = isset($pwa_array_address['entry_street_address'])? $pwa_array_address['entry_street_address']:'';
      $suburb = isset($pwa_array_address['entry_suburb'])? $pwa_array_address['entry_suburb']:'';
      $postcode = isset($pwa_array_address['entry_postcode'])? $pwa_array_address['entry_postcode']:'';
      $city = isset($pwa_array_address['entry_city'])? $pwa_array_address['entry_city']:'';
      $state = isset($pwa_array_address['entry_state'])? $pwa_array_address['entry_state']:'0';
      $country = isset($pwa_array_address['entry_country_id'])? $pwa_array_address['entry_country_id']:'';
      $telephone = isset($pwa_array_customer['customers_telephone'])? $pwa_array_customer['customers_telephone']:'';
      $fax = isset($pwa_array_customer['customers_fax'])? $pwa_array_customer['customers_fax']:'';
    }

    $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_CREATE_ACCOUNT,   '', 'SSL'));


    $content = CONTENT_CREATE_ACCOUNT;
    $javascript = 'form_check.js.php';
    include (bts_select('main', $content_template)); // BTSv1.5

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
