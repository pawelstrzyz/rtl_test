<?php
/*
Contributed by: <-- R O B --> La Rochelle France
Released under the GNU General Public License
2004/01/29

Automaticly shows all templates folders except the ones starting with an underscore
(i.e.: "_my-secret-template-dir/")
Just copy this file to your templates directory,
and include it in your main_page.tpl.php files for example.

  mod eSklep-Os http://www.esklep-os.com
*/
?>
<?php
if ((TEMPLATE_SWITCHING_ALLOWED == 'true') && (TEMPLATE_SWITCHING_MENU == 'true'))
{
  echo '<div id="templateSwitcher" style="height: 15px; text-align: center; margin: 0px auto; font-family: Verdana, Arial, sans-serif; font-size: 11px; border-bottom: 2px solid #ff8f00; background: #FFFFFF; ">';
  echo 'Wersje Graficzne Sklepu:';
  $dir =  getcwd()."/templates/" ; /* get the current path and add "/templates/" to the end */
  if (is_dir($dir))
  {
    /* check if the path is a directory */
    if ($dh = opendir($dir))
    {
      /* create a file system object ($dh) */
      while (($file = readdir($dh)) !== false)
        {
          /* repeat with all the files in the directory */
          if(filetype($dir . $file) == "dir")
          {
            /* if the file in the directory is a folder */
            if($file != "..")
            {
              /* if the folder isn't called ".." (this is not a folder as such, I think its to go up one level?) */
              $firstchar = substr($file, 0, 1); // get the first character of the folder's name
              if(($firstchar != "_")&&($firstchar != "."))
              {
                /* this means that any folder starting with "_" won't be displayed, allows to have secret template in the directory */
                $ts_template_array[]= $file;              }
            }
          }
        }
      closedir($dh); /* close the file sytem object */
    }
  }
if (is_array ($ts_template_array)) sort ($ts_template_array,SORT_STRING);
foreach ($ts_template_array as $file) {
  echo "| # <a style=\"color: #000000; text-decoration: none; font-weight: bold; margin: 5px;\" href=\"" . tep_href_link('index.php', 'tplDir='.$file) . "\">$file</a>"; 
}  

echo '</div>';
}
?>
