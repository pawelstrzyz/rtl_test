<?php
/* ------------------------------------------------

  coolMenu for osCommerce
  
  author:	Andreas Kothe 
  url:		http://www.oddbyte.de
  copyright: 2003 Andreas Kothe
  modified: 2003-07-28 Marc Zacher

  extended to work for javascript enanbled and disabled
  with javascript disabled, the conventional categories box is shown
  this extension is provided by Marc Zacher
  
  The copyright notice of Andreas Kothe in the html output
  has been removed and put in this header
  since it would cause problems in javascript context.

  Released under the GNU General Public License
  

 mod eSklep-Os http://www.esklep-os.com
  ------------------------------------------------ 
*/

?>
<script type="text/javascript">
<!--
document.write(" <TR> <TD> ");
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
			       'text'  => BOX_HEADING_CATEGORIES
			      );
  $coolmenuinfoboxheading = new infoBoxHeading($info_box_contents, true, false, false, false);
  $output_string = $coolmenuinfoboxheading->table_string;


  $info_box_contents = array();
  if (MAX_MANUFACTURERS_LIST < 2) {
	$cat_choose = array(array('id' => '', 'text' => BOX_CATEGORIES_CHOOSE));
  } else {
	$cat_choose = '';
  }



  $info_box_contents[] = array('text'  => '
	<img src="images/trans.gif" width="150" height="' . $height . '">');

  $coolmenuinfobox = new infoBox($info_box_contents, false);
  $output_string .= $coolmenuinfobox->table_string;
  //remove all html commments
  $output_string = preg_replace("/<!--.*?-->/", "", $output_string);
  //escape all occurences of "
  $output_string = preg_replace('/"/', '\"', $output_string);
  //escape all occurences of /
  $output_string = preg_replace('/\//', '\/', $output_string);
  //remove trailing \n
  $output_string = preg_replace('/\\n+$/', '', $output_string);
  //replace all \n with ");\ndocument.write("
  $output_string = preg_replace('/\\n/', "\");\ndocument.write(\"", $output_string); 
  //prepend document.write at the beginning and append ");\n
  $output_string = "document.write(\"" . $output_string . "\");\n";
  echo $output_string;
?>
document.write(" <\/TD> <\/TR> ");
//--> </script>
<noscript>
<?php
  include(DIR_WS_BOXES . 'categories.php');
?>
</noscript>
