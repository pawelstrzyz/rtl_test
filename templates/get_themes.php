<?php
/*
get_themes.php
Original file: common_top_bts.php
Modified by: Vlad Savitsky 2004/12/09
http://www.solti.com.ua
Released under the GNU General Public License

  mod eSklep-Os http://www.esklep-os.com
*/

function get_themes() {
  $dir =  getcwd()."/templates/" ; /* get the current path and add "/templates/" to the end */
  if (is_dir($dir)) { /* check if the path is a directory */
    if ($dh = opendir($dir)) { /* create a file system object ($dh) */

      while (($file = readdir($dh)) !== false) { /* repeat with all the files in the directory */
          if(filetype($dir . $file) == "dir") { /* if the file in the directory is a folder */
            if($file != "..") { /* if the folder isn't called ".." (this is not a folder as such, I think its to go up one level?) */
              $firstchar = substr($file, 0, 1); // get the first character of the folder's name
              /* this means that any folder starting with "_" won't be displayed, allows to have secret template in the directory */
              if(($firstchar != "_")&&($firstchar != ".")) {
                $themes[]=array('id'=>$file, 'text'=>$file);
              }
            }
          }
        }

      closedir($dh); /* close the file sytem object */
    }
  }
return $themes;
}
?>
