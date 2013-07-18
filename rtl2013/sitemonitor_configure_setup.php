<?php
/*
  $Id: sitemonitor_admin.php,v 1.2 2006/09/24 
  sitemonitor Originally Created by: Jack mcs
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
  
  mod eSklep-Os http://www.esklep-os.com
*/
 
  require('includes/application_top.php');
  require('includes/functions/sitemonitor_functions.php');

  /*********** BUILD THE DIRECTORY LIST *************/  
  $exclude_array = array();
  $exclude_array = GetList(DIR_FS_CATALOG, 1, 1, $exclude_array);
  $exclude_selector = array(); 
 
  $exclude_selector[] = array('id' => 0, 
                              'text' => 'Wybierz katalog');
  for ($i = 0; $i < count($exclude_array); ++$i)
  {
    $exclude_selector[] = array('id' => $i+1, 
                                'text' => GetDirectoryName($exclude_array[$i]));
  }
                              
  /*********** LOAD THE CONFIGURE SETTINGS **********/
  $filenameConfigure = DIR_FS_ADMIN . FILENAME_SITEMONITOR_CONFIGURE;
  $switch = array(); 
  $fp = @file($filenameConfigure);
  for ($i = 0; $i < count($fp); ++$i)
  {
    if (strpos($fp[$i], "\$always_email") !== FALSE)
    {
      if (($pos = strpos($fp[$i], ";")) !== FALSE)
       $switch['always_email'] = ((int)substr($fp[$i], $pos -1) == 1) ? 'Checked' : '';
    }  
    else if (strpos($fp[$i], "\$verbose") !== FALSE)
    {
      if (($pos = strpos($fp[$i], ";")) !== FALSE) 
       $switch['verbose'] = ((int)substr($fp[$i], $pos -1) == 1) ? 'Checked' : '';
    }
    else if (strpos($fp[$i], "\$logfile") !== FALSE && strpos($fp[$i], "\$logfile_") === FALSE)
    {
      if (($pos = strpos($fp[$i], ";")) !== FALSE) 
       $switch['logfile'] = ((int)substr($fp[$i], $pos -1) == 1) ? 'Checked' : '';
    } 
    else if (strpos($fp[$i], "\$logfile_size") !== FALSE)
    {
      if (($pos = strpos($fp[$i], ";")) !== FALSE) 
       $switch['logfile_size'] = (((int)substr($fp[$i], $pos -1) > 0) ? substr($fp[$i], $pos -1) : '100000');
    }   
    else if (strpos($fp[$i], "\$quarantine") !== FALSE)
    {
      if (($pos = strpos($fp[$i], ";")) !== FALSE) 
       $switch['quarantine'] = ((int)substr($fp[$i], $pos -1) == 1) ? 'Checked' : '';
    }          
    else if (strpos($fp[$i], "\$to") !== FALSE) 
    { 
      $switch['to_address'] = GetConfigureSetting($fp[$i], "'", "'");
    }   
    else if (strpos($fp[$i], "\$from") !== FALSE)
    {  
      $switch['from_address'] = GetConfigureSetting($fp[$i], "'", "'");
      $switch['from_address'] = str_replace("From: ", "", $switch['from_address']);
    }   
    else if (strpos($fp[$i], "\$start_dir") !== FALSE)
    {  
      $switch['start_dir'] = GetConfigureSetting($fp[$i], "'", "'");    
    }   
    else if (strpos($fp[$i], "\$excludeList") !== FALSE)  
    {
      $switch['exclude_list'] = stripslashes(GetConfigureSetting($fp[$i], "(", ")"));
    }   
   }                                  
                     
  /*********** CHECK THE INPUT *************/          
  $action = (isset($_POST['action']) ? $_POST['action'] : '');
  $action_exclude = (isset($_POST['action_exclude']) ? $_POST['action_exclude'] : ''); 
  $action_reset = $_GET['action_reset'];

  if (tep_not_null($action_exclude))
  {
    if ($_POST['exclude_selector'] > 0)     //pulldown was used to make selection
    {
      $curList = $_POST['exclude_list'];
      $switch['exclude_list'] = AddToExcludeList($curList,GetDirectoryName($exclude_array[$_POST['exclude_selector']-1])); 
    }
    else                                    //grab what is in the string
      $switch['exclude_list'] = stripslashes($_POST['exclude_list']);
  }
  else if (tep_not_null($action))
  {
    $switch['always_email'] = (isset($_POST['always_email'])) ? 'Checked' : '';
    $switch['verbose'] = (isset($_POST['verbose'])) ? 'Checked' : '';
    $switch['logfile'] = (isset($_POST['logfile'])) ? 'Checked' : '';
    $switch['logfile_size'] = $_POST['logfile_size'];
    $switch['quarantine'] = (isset($_POST['quarantine'])) ? 'Checked' : '';
    $switch['to_address'] = $_POST['to_address'];
    $switch['from_address'] = $_POST['from_address'];
    $switch['start_dir'] = $_POST['start_dir'];
    $switch['exclude_list'] = stripslashes($_POST['exclude_list']); 
 
    $error = false;
    $errmsg = '';
      
    if (empty($switch['to_address']))
    {
      $errmsg = "To address is required.";
      $error = true;
    }      
    else if (empty($switch['from_address']))
    {
      $errmsg = "From address is required.";
      $error = true;
    }
    else if (empty($switch['start_dir']))
    {
      $errmsg = "Start directory is required.";
      $error = true;
    }    
  

    if (! $error)
    {   
      $options = array();
      
      $opt = ($switch['always_email']) == 'Checked' ? 1 : 0; 
      $options['always_email'] = sprintf("\$always_email = %d; //set to 1 to always email the results", $opt);
      
      $opt = ($switch['verbose']) == 'Checked' ? 1 : 0; 
      $options['verbose'] = sprintf("\$verbose = %d; //set to 1 to see the results displayed on the page (for when running manually)", $opt);

      $opt = ($switch['logfile']) == 'Checked' ? 1 : 0; 
      $options['logfile'] = sprintf("\$logfile = %d; //set to 1 to see to track results in a log file", $opt);

      $opt = (empty($switch['logfile_size'])) ? '100000' : $switch['logfile_size']; 
      $options['logfile_size'] = sprintf("\$logfile_size = %d; //set the maximum size of the logfile", $opt);

      $opt = ($switch['quarantine']) == 'Checked' ? 1 : 0; 
      $options['quarantine'] = sprintf("\$quarantine = %d; //set to 1 to move new files found to the quarantine directory", $opt);
         
      $opt = $switch['to_address']; 
      $options['to_address'] = sprintf("\$to = '%s'; //where email is sent to", $opt);
      
      $opt = $switch['from_address']; 
      $options['from_address'] = sprintf("\$from = 'From: %s'; //where email is sent from", $opt);    

      $opt = $switch['start_dir'] ; 
      $options['start_dir'] = sprintf("\$start_dir = '%s'; //your shops root", $opt); 

      $opt = CheckExcludeList($switch['exclude_list']);  //special case - must be last

      if (strpos($opt, "FAILED") === FALSE)
      {        
        $options['exclude_list'] = stripslashes(sprintf("\$excludeList = array(%s); //don't check these directories - change to your liking - must be set prior to first run", $opt));
        
        $fp = file($filenameConfigure);
        $fp_out = array();
        for ($i = 0; $i < count($fp); ++$i)
        {
          if (strpos($fp[$i], "\$always_email") !== FALSE)
           $fp_out[] = $options['always_email'] . "\n";
          else if (strpos($fp[$i], "\$verbose") !== FALSE)  
           $fp_out[] = $options['verbose'] . "\n";
          else if (strpos($fp[$i], "\$logfile") !== FALSE && (strpos($fp[$i], "\$logfile_") === FALSE) )  
           $fp_out[] = $options['logfile'] . "\n";
          else if (strpos($fp[$i], "\$logfile_size") !== FALSE)  
           $fp_out[] = $options['logfile_size'] . "\n";
          else if (strpos($fp[$i], "\$quarantine") !== FALSE)  
           $fp_out[] = $options['quarantine'] . "\n";
          else if (strpos($fp[$i], "\$to") !== FALSE)  
           $fp_out[] = $options['to_address'] . "\n";
          else if (strpos($fp[$i], "\$from") !== FALSE)  
           $fp_out[] = $options['from_address'] . "\n";
          else if (strpos($fp[$i], "\$start_dir") !== FALSE)  
           $fp_out[] = $options['start_dir'] . "\n";      
          else if (strpos($fp[$i], "\$excludeList") !== FALSE)  
           $fp_out[] = $options['exclude_list'] . "\n";            
          else
           $fp_out[] = $fp[$i];
        }
        
        WriteConfigureFile($filenameConfigure, $fp_out);
      }
      else
      {
        $messageStack->add($opt, 'error');
      }    
    }
    else if ($error)
     $messageStack->add($errmsg, 'error');  
  } 
  else if (tep_not_null($action_reset))
  {
    $switch['exclude_list'] = '';
  } 
  
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/css/stylesheet.css">
<style type="text/css">
td.HTC_Head {font-family: Verdana, Arial, sans-serif; font-size: 15px; color: #4E8F00; font-weight: bold;}
td.HTC_subHead {font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #4E8F00; }
</style></head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
     <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '15'); ?></td>
      </tr>
    <tr>
      <td class="HTC_Head"><?php echo HEADING_SITEMONITOR_CONFIGURE_SETUP; ?></td>
     </tr>
     <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
     <tr>
      <td class="HTC_subHead"><?php echo TEXT_SITEMONITOR_CONFGIURE_SETUP; ?></td>
     </tr>
     <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
     </tr>
       <tr>
        <td><?php echo tep_black_line(); ?></td>
       </tr>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>       
              
       <!-- BEGIN SITEMONITOR CONFIGURE SETTINGS -->      
       <tr>
        <td align="right"><?php echo tep_draw_form('sitemonitor', FILENAME_SITEMONITOR_CONFIG_SETUP, '', 'post') . tep_draw_hidden_field('action', 'process'); ?></td>
         <tr>
          <td><table border="0" width="100%" cellspacing="0" cellpadding="2"> 
           <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
             <tr class="main">
              <td width="20%"><?php echo TEXT_OPTION_ALWAYS_EMAIL; ?></td>
              <td width="10%"><?php echo tep_draw_checkbox_field('always_email', '', $switch['always_email'], ''); ?> </td>
              <td class="smallText" valign="top"><?php echo TEXT_OPTION_ALWAYS_EMAIL_EXPLAIN; ?></td>
             </tr>
            </table></td>  
           </tr>
           <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
             <tr class="main">           
              <td width="20%"><?php echo TEXT_OPTION_VERBOSE; ?></td>
              <td width="10%"><?php echo tep_draw_checkbox_field('verbose', '', $switch['verbose'], ''); ?> </td>
              <td class="smallText" valign="top" align="left"><?php echo TEXT_OPTION_VERBOSE_EXPLAIN; ?></td>
             </tr>
            </table></td>              
           </tr>
           <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
             <tr class="main">           
              <td width="20%"><?php echo TEXT_OPTION_LOGFILE; ?></td>
              <td width="10%"><?php echo tep_draw_checkbox_field('logfile', '', $switch['logfile'], ''); ?> </td>
              <td class="smallText" valign="top" align="left"><?php echo TEXT_OPTION_LOGFILE_EXPLAIN; ?></td>
             </tr>
            </table></td>              
           </tr>         
           <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
             <tr class="main">           
              <td width="20%"><?php echo TEXT_OPTION_LOGFILE_SIZE; ?></td>
                <td width="20%"><?php echo tep_draw_input_field('logfile_size',$switch['logfile_size'], 'maxlength="255", size="20"', false, 300); ?> </td>
              <td class="smallText" valign="top" align="left"><?php echo TEXT_OPTION_LOGFILE_SIZE_EXPLAIN; ?></td>
             </tr>
            </table></td>              
           </tr>  
           <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
             <tr class="main">           
              <td width="20%"><?php echo TEXT_OPTION_QUARANTINE; ?></td>
              <td width="10%"><?php echo tep_draw_checkbox_field('quarantine', '', $switch['quarantine'], ''); ?> </td>
              <td class="smallText" valign="top" align="left"><?php echo TEXT_OPTION_QUARANTINE_EXPLAIN; ?></td>
             </tr>
            </table></td>              
           </tr>                                          
           <tr>
            <td colspan="2"><table border="0" width="100%">        
             <tr>
              <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
               <tr class="main">             
                <td width="20%"><?php echo TEXT_OPTION_TO_EMAIL; ?></td>
                <td width="20%"><?php echo tep_draw_input_field('to_address', $switch['to_address'], 'maxlength="255", size="40"', false, 300); ?> </td>
                <td class="smallText" valign="top"><?php echo TEXT_OPTION_TO_ADDRESS_EXPLAIN; ?></td>
               </tr>
              </table></td>                
             </tr>  
             <tr>
              <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
               <tr class="main">             
                <td width="20%"><?php echo TEXT_OPTION_FROM_EMAIL; ?></td>
                <td width="20%"><?php echo tep_draw_input_field('from_address', $switch['from_address'], 'maxlength="255", size="40"', false, 300); ?> </td>
                <td class="smallText" valign="top"><?php echo TEXT_OPTION_FROM_ADDRESS_EXPLAIN; ?></td>
               </tr>
              </table></td>                
             </tr>
             <tr>
              <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
               <tr class="main">             
                <td width="20%"><?php echo TEXT_OPTION_START_DIR; ?></td>
                <td width="20%"><?php echo tep_draw_input_field('start_dir', (empty($switch['start_dir']) ? DIR_FS_DOCUMENT_ROOT : $switch['start_dir']), 'maxlength="255", size="40"', false, 300); ?> </td>
                <td class="smallText" valign="top"><?php echo TEXT_OPTION_START_DIR_EXPLAIN; ?></td>
               </tr>
              </table></td>                
             </tr>   
             <tr>
              <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
               <tr class="main">             
                <td width="20%"><?php echo TEXT_OPTION_EXCLUDE_LIST; ?></td>
                <td width="20%"><?php echo tep_draw_textarea_field('exclude_list', 'hard', 36, 5, $switch['exclude_list'], '', false); ?></td>
                <td class="smallText" valign="top"><?php echo TEXT_OPTION_EXCLUDE_LIST_EXPLAIN; ?></td>
               </tr>
              </table></td>                
             </tr>                               
            </table></td>
           </tr>                          
           <tr>
             <td align="center"><?php echo (tep_image_submit('button_update.gif', IMAGE_UPDATE) ) . ' <a href="' . tep_href_link(FILENAME_SITEMONITOR_CONFIG_SETUP, '') .'">' . '</a>'; ?></td>
           </tr>       
          <table></td>
         </tr>        
        </form>
        </td>
       </tr>   
      </table></td>
     </tr>  
     <!-- END SITEMONITOR CONFIGRE SETTINGS -->   

     <tr>
      <td><?php echo tep_black_line(); ?></td>
     </tr>
     <tr>
      <td class="HTC_subHead"><b>UWAGA:</b> Wywolanie programu można dodać do zadań crona w celu jego zautomatyzowania. Należy wówczas do zadań crona dodać uruchomienie programu <i>/admin/sitemonitor.php</i> Konkretne ustawienia wywolania są zależne od konkretnego serwera.</td>
     </tr>

    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
