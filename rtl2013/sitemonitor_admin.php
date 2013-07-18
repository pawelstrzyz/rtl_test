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
 
 $fileDeleted = false;
 $foundErrors = 0;
 $refFile     = "sitemonitor_reference.php";
 $showErrors  = 0;
 
 $actionDelete = (isset($_POST['action_delete']) ? $_POST['action_delete'] : '');
 $actionExecute = (isset($_POST['action_execute']) ? $_POST['action_execute'] : '');
 
 if (tep_not_null($actionDelete) || tep_not_null($actionExecute))
 {
   if (is_file($refFile))
   {
      if (tep_not_null($actionDelete))      //delete the reference file before running
       if (unlink($refFile))
        $fileDeleted = true;
   } 

   require('sitemonitor_configure.php');
   require('includes/functions/sitemonitor_functions.php');
  
   $foundErrors = runSitemonitor(0);        //create the reference files
   $showErrors = 1;  
   switch ($foundErrors)                    //report result
   {
     case -1: $errmsg = 'Plik referencyjny nie zostal utworzony.'; break;
     case -2: $errmsg = 'Tworzenie pliku. Plik referencyjny zostal utworzony i zapisany.'; break;
     case  0: $errmsg = 'Nie znaleziono różnic'; break;
     default: $errmsg = sprintf("Ilosć znalezionych różnic : %d <br>Uruchom program ręcznie lub sprawdź wiadomosć w poczcie, aby zobaczyć wyniki.", $foundErrors); break;
   }
 }  
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/css/stylesheet.css">
</head>
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
      <td class="pageHeading"><?php echo HEADING_SITEMONITOR_ADMIN; ?></td>
     </tr>
     <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
     <tr>
      <td><?php echo TEXT_SITEMONITOR_ADMIN; ?></td>
     </tr>
     <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
     </tr>
     <tr>
      <td><?php echo tep_black_line(); ?></td>
     </tr>
     
     <!-- BEGIN DELETE AND GENERATE FILE -->
     <tr>
      <td><table width="100%">
       <tr>
        <td align="right"><?php echo tep_draw_form('header_tags_auto', FILENAME_SITEMONITOR_ADMIN, '', 'post') . tep_draw_hidden_field('action_delete', 'process'); ?></td>
         <tr>
          <td><table border="0" width="40%" cellspacing="0" cellpadding="2">
           <tr>
            <td class="main" width="70%"><b><?php echo TEXT_SITEMONITOR_DELETE_REFERENCE; ?></b></td>
           </tr>
           <tr>
            <td class="smallText"><?php echo TEXT_SITEMONITOR_DELETE_EXPLAIN; ?></td>            
            <td align="center"><?php echo (tep_image_submit('button_update.gif', IMAGE_UPDATE) ) . ' <a href="' . tep_href_link(FILENAME_SITEMONITOR_ADMIN, '') .'">' . '</a>'; ?></td>
           </tr>     
           <?php if ($actionDelete && $fileDeleted) { ?>
            <tr><td class="smallText"><?php echo $refFile . ' zostal skasowany!'; ?></td></tr>
           <?php } ?>     
           <?php if ($actionDelete && $showErrors) { ?>
            <tr><td class="smallText"><b><?php echo $errmsg; ?></b></td></tr>
           <?php } ?>  
           <tr>
          <table></td>
         </tr>        
        </form>
        </td>
       </tr>   
      </table></td>
     </tr>  
     <!-- END DELETE AND GENERATE FILE -->   

     <tr>
      <td><?php echo tep_black_line(); ?></td>
     </tr>
     
     <!-- BEGIN EXECUTE FILE -->
     <tr>
      <td><table width="100%">
        <tr>
        <td align="right"><?php echo tep_draw_form('header_tags_auto', FILENAME_SITEMONITOR_ADMIN, '', 'post') . tep_draw_hidden_field('action_execute', 'process'); ?></td>
         <tr>
          <td><table border="0" width="40%" cellspacing="0" cellpadding="2">
           <tr>
            <td class="main" width="70%"><b><?php echo TEXT_SITEMONITOR_EXECUTE; ?></b></td>
           </tr>
           <tr>
            <td class="smallText"><?php echo TEXT_SITEMONITOR_EXECUTE_EXPLAIN; ?></td> 
            <td align="center"><?php echo (tep_image_submit('button_update.gif', IMAGE_UPDATE) ) . ' <a href="' . tep_href_link(FILENAME_SITEMONITOR_ADMIN, '') .'">' . '</a>'; ?></td>
           </tr>     
           <?php if ($actionExecute && $showErrors) { ?>
            <tr><td class="smallText"><b><?php echo $errmsg; ?></b></td></tr>
           <?php } ?>  
           <tr>
          <table></td>
         </tr>        
        </form>
        </td>
       </tr>     
      </table></td>
     </tr>  
     <!-- END EXECUTE FILE -->      
	 
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
