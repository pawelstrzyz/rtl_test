<?php
/*
  $Id: book_print_header_print.php 103 2008-02-24 16:45:51Z  $
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2003 osCommerce
  Released under the GNU General Public License

   mod eSklep-Os http://www.esklep-os.com
*/

//require('includes/application_top.php');
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Książka adresowa</title>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_ADMIN . 'includes/css/print.css'; ?>">
<style type='text/css'>
@media print  
{  
  .pagestart { page-break-after:always; }  
}  
</style>
</head>
<body>

<!-- body_text //-->
<table border="0" width="700" cellspacing="0" cellpadding="2" align="center">
  <tr> 
    <td align="center" class="main"><table align="center" width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr> 
        <td valign="top" align="left" class="main"><script language="JavaScript">
         if (window.print) {
          document.write('<a href="javascript:;" onClick="javascript:window.print()" onMouseOut=document.imprim.src="<?php echo (DIR_WS_IMAGES. 'printimage.gif'); ?>" onMouseOver=document.imprim.src="<?php echo (DIR_WS_IMAGES . 'printimage_over.gif'); ?>"><img src="<?php echo (DIR_WS_IMAGES . 'printimage.gif'); ?>" width="43" height="28" align="absbottom" border="0" name="imprim">' + '<?php echo IMAGE_BUTTON_PRINT; ?></a></center>');
         }
          else document.write ('<h2><?php echo IMAGE_BUTTON_PRINT; ?></h2>')
         </script>
        </td>
        <td align="right" valign="bottom" class="main"><p align="right" class="main"><a href="javascript:window.close();"><img src=<?php echo DIR_WS_IMAGES . 'close_window.jpg'; ?> border=0></a></p></td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '15'); ?></td>
  </tr>
</table>
