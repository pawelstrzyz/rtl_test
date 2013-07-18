<?php

include('includes/ajax_top.php');

if($_GET['field'] && $_GET['file'] && $_GET['language'] && $_GET['text'] && $_GET['directory'] ) {
	
	$file = $_GET['file'];
	$language = $_GET['language'];
	$field = $_GET['field'];
	$text = trim($_GET['text']);
	
	//echo $language."<br>".$file."<br>".$field."<br>".$text."<br>".$directory."<br>";
	
	if($_GET['directory'] == 'admin'){
			$directory = DIR_FS_ADMIN_LANGUAGES;
	} elseif ($_GET['directory'] == 'catalog'){
			$directory = DIR_FS_CATALOG_LANGUAGES;
	} else {
		$directory = DIR_FS_CATALOG_LANGUAGES;
	}
	
	if(file_exists($directory.$language."/".$file)){
		
		$return = addlineItem($directory.$language."/".$file, $field, $text);
		if($return == ""){
			$return = "error - no string entered";
		}
		echo $return;
	}else{
		echo "error -  $file does not existent";
	}

} else {
	echo "error - all variables not set file - $file, language - $language, field - $field, directory  $directory, text - $text";
}


include('includes/ajax_bottom.php');


/* 
 * 1. Find out how many links (and passes) and sitemap files to generate 
 * 2. Itilialize the xml string Add common main-website links (contribute, download,discover, Legal etc..)
 * 3. Query for single words and write those in as pages in xml
 * 4. Query for individual images (group by products_model order by keyword_count desc)
 * 5. Save local file xml
 * 6. Send email. 
 */

//********************* 1. Configuration of how many links/files *****************


function addlineItem($theFile, $field, $text){
    $contents = file_get_contents($theFile);
    //echo "here are contents: ".htmlspecialchars($contents);
    
    $str_pos1_single=strpos($contents,"'".$field."'");
    
    if ($str_pos1_single !=''){
    	$sep_char = "'";
    	$str_pos1 = $str_pos1_single;
    }else{
    	$str_pos1_double=strpos($contents,'"'.$field.'"');
    	if ($str_pos1_double !=''){
    		$sep_char = "\"";
    		$str_pos1 = $str_pos1_double;
    	}else{
    		$str_pos1='';
    	}
    }

    //$str_pos1=strpos($contents,$field);
 
	//echo "<br>strpos1".$str_pos1."<br>";
	
	//if found: check the seperating character ' or " as well as the second position
	if($str_pos1 != ''){

		//now find the end
		$str_pos2 = strpos($contents,$sep_char.");",$str_pos1);
	
		//if there is a second position do the replacement
		if($str_pos2 !=''){
			$str_pos2 = $str_pos2+3;
			$length=$str_pos2-$str_pos1+1;
			$start=$str_pos1-1;
			$string_insert = $sep_char.$field.$sep_char.",".$sep_char.$text.$sep_char.");";
			//echo $length."  ".__LINE__." Line <br>";
			//echo "<br>OK final check:<br><br> contents:".htmlspecialchars($contents)."<br>string insert: $string_insert <br><br>pos1 $str_pos1 and length ".$length."";
			$contents_new = substr_replace($contents,$string_insert,$start,$length);
			//echo htmlspecialchars($contents_new)."<br>";
		} else {
			return "error - $field unable to find string end";
		}

	}else{
			$str_pos1=strpos($contents,"?>");
			$str_pos2=$str_pos1+2;
			$length=$str_pos2-$str_pos1;
			$date = date("Y.m.d", mktime(0, 0, 0));
			$string_insert = "//New variable inserted on ".$date."\n"."define('".$field."','".$text."');"."\n\n"."?>";
			
			$contents_new = substr_replace($contents,$string_insert,$str_pos1,$length);
			
	}
	//end if the field to change is found
	$outFileHandle = fopen($theFile, 'w');
	fwrite($outFileHandle, $contents_new);
	fclose($outFileHandle);
	
	return $text;
// ********/
}






?>