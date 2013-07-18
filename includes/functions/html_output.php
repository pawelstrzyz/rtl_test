<?php
/*
  $Id: html_output.php 170 2008-03-21 21:52:13Z jmk $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License

 mod eSklep-Os http://www.esklep-os.com
*/

////
// Ultimate SEO URLs v2.1
// The HTML href link wrapper function
if (SEO_ENABLED == 'true') { //run chemo's code

// Ultimate SEO URLs v2.1
// The HTML href link wrapper function
  function tep_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true) {
        global $seo_urls;
                if ( !is_object($seo_urls) ){
                        if ( !class_exists('SEO_URL') ){
                                include_once(DIR_WS_CLASSES . 'seo.class.php');
                        }
                        global $languages_id;
                        $seo_urls = new SEO_URL($languages_id);
                }
        return $seo_urls->href_link($page, $parameters, $connection, $add_session_id);
  }

} else { //run original code

  // The HTML href link wrapper function
  function tep_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true) {
    global $kill_sid, $HTTP_GET_VARS;
    global $request_type, $session_started, $SID;
    $parameters = tep_output_string($parameters);

    if ($connection == 'NONSSL') {
      $link = HTTP_SERVER . DIR_WS_HTTP_CATALOG;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL == true) {
        $link = HTTPS_SERVER . DIR_WS_HTTPS_CATALOG;
      } else {
        $link = HTTP_SERVER . DIR_WS_HTTP_CATALOG;
      }
    } else {
      die('<br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL SSL</b><br><br>');
    }

    //SID KILLER START	
	  if ($HTTP_GET_VARS['language'] && $kill_sid) {
      $l = ereg('[&\?/]?language[=/][a-z][a-z]', $parameters, $m);
      if ($l) {
        $parameters = ereg_replace("[&\?/]?language[=/][a-z][a-z]", "", $parameters);
        $HTTP_GET_VARS['language'] = substr($m[0],-2);
      }
      if (tep_not_null($parameters)) {
        $parameters .= "&language=" . $HTTP_GET_VARS['language'];
      } else {
        $parameters = "language=" . $HTTP_GET_VARS['language'];
      }
    }
    //SID KILLER END	

    if (tep_not_null($parameters)) {
      $link .= $page . '?' . tep_output_string($parameters);
      $separator = '&amp;';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&amp;') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
    if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
      if (tep_not_null($SID)) {
        $_sid = $SID;
      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == true) ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
        if (HTTP_COOKIE_DOMAIN != HTTPS_COOKIE_DOMAIN) {
          $_sid = tep_session_name() . '=' . tep_session_id();
        }
      }
    }

//    if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
//      while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);

//      $link = str_replace('?', '/', $link);
//      $link = str_replace('&', '/', $link);
//      $link = str_replace('=', '/', $link);

//      $separator = '?';
//    }

if (!tep_session_is_registered('customer_id') && ENABLE_PAGE_CACHE == 'true' && class_exists('page_cache')) {
    if (isset($_sid) && ( !$kill_sid ) ) {
      $link .= $separator . '<osCsid>';
    }
} elseif (isset($_sid)) {
      $link .= $separator . tep_output_string($_sid);
}

    $link = str_replace('&', '&amp;', $link);
    return $link;
  }
}

////
// "On the Fly" Auto Thumbnailer using GD Library, servercaching and browsercaching
// Scales product images dynamically, resulting in smaller file sizes, and keeps
// proper image ratio. Used in conjunction with product_thumb.php t/n generator.
function tep_image($src, $alt = '', $width = '', $height = '', $params = '') { 

//	$znaczki = array("%5B", "%5D");
//	$nawiasy = array("[", "]");
//	$src = 	str_replace($znaczki, $nawiasy, $src);

  // Set default image variable and code
  $image = '<img src="' . $src . '"';
  
  // Don't calculate if the image is set to a "%" width
  if (strstr($width,'%') == false || strstr($height,'%') == false) { 
    $dont_calculate = 0; 
  } else {
    $dont_calculate = 1;    
  }

  // Dont calculate if a pixel image is being passed (hope you dont have pixels for sale)
  if (!strstr($image, 'pixel')) {
    $dont_calculate = 0;
  } else {
    $dont_calculate = 1;
  } 
  
  // Do we calculate the image size?
  if (CONFIG_CALCULATE_IMAGE_SIZE && !$dont_calculate) { 
    
    // Get the image's information
    if ($image_size = @getimagesize($src)) { 
      
      $ratio = $image_size[1] / $image_size[0];
      
      // Set the width and height to the proper ratio
      if (!$width && $height) { 
        $ratio = $height / $image_size[1]; 
        $width = intval($image_size[0] * $ratio); 
      } elseif ($width && !$height) { 
        $ratio = $width / $image_size[0]; 
        $height = intval($image_size[1] * $ratio); 
      } elseif (!$width && !$height) { 
        $width = $image_size[0]; 
        $height = $image_size[1]; 
      } 
      
      // Scale the image if not the original size
      if ($image_size[0] != $width || $image_size[1] != $height) { 
        $rx = $image_size[0] / $width; 
        $ry = $image_size[1] / $height; 
  
        if ($rx < $ry) { 
          $width = intval($height / $ratio); 
        } else { 
          $height = intval($width * $ratio); 
        } 
  
        $image = '<img src="product_thumb.php?img='.$src.'&amp;w='.
        tep_output_string($width).'&amp;h='.tep_output_string($height).'"';
      }
      
    } elseif (IMAGE_REQUIRED == 'false') { 
      return ''; 
    } 
  } 
  
  // Add remaining image parameters if they exist
  if ($width) { 
    $image .= ' width="' . tep_output_string($width) . '"'; 
  } 
  
  if ($height) { 
    $image .= ' height="' . tep_output_string($height) . '"'; 
  }     
  
  if (tep_not_null($params)) $image .= ' ' . $params;
  
  $image .= ' border="0" alt="' . tep_output_string($alt) . '"';
  
  if (tep_not_null($alt)) {
    $image .= ' title="' . tep_output_string($alt) . '"';
  }
  
  $image .= '>';   
  
  return $image; 
}



function tep_background($src) { 
  
  // Set default image variable and code
  $image = 'background="' . $src . '"';
  
  // Don't calculate if the image is set to a "%" width
  if (strstr($width,'%') == false || strstr($height,'%') == false) { 
    $dont_calculate = 0; 
  } else {
    $dont_calculate = 1;    
  }

  // Dont calculate if a pixel image is being passed (hope you dont have pixels for sale)
  if (!strstr($image, 'pixel')) {
    $dont_calculate = 0;
  } else {
    $dont_calculate = 1;
  } 
  
  // Do we calculate the image size?
  if (CONFIG_CALCULATE_IMAGE_SIZE && !$dont_calculate) { 
    
    // Get the image's information
    if ($image_size = @getimagesize($src)) { 
      
      $ratio = $image_size[1] / $image_size[0];
      
      // Set the width and height to the proper ratio
      if (!$width && $height) { 
        $ratio = $height / $image_size[1]; 
        $width = intval($image_size[0] * $ratio); 
      } elseif ($width && !$height) { 
        $ratio = $width / $image_size[0]; 
        $height = intval($image_size[1] * $ratio); 
      } elseif (!$width && !$height) { 
        $width = $image_size[0]; 
        $height = $image_size[1]; 
      } 
      
    } elseif (IMAGE_REQUIRED == 'false') { 
      return ''; 
    } 
  } 
  
  // Add remaining image parameters if they exist
  
  $image .= '';   
  
  return $image; 
}




////
// The HTML form submit button wrapper function
// Outputs a button in the selected language
  function tep_image_submit($image, $alt = '', $parameters = '') {
    global $language;


    $image_submit = '<input type="image" name="button" src="' . tep_output_string(DIR_WS_TMPL_IMAGES . 'buttons/' . $language . '/' . $image) . '" style="border: 0px; border-collapse:collapse;" alt="' . tep_output_string($alt) . '"';

    if (tep_not_null($alt)) $image_submit .= ' title=" ' . tep_output_string($alt) . ' "';

    if (tep_not_null($parameters)) $image_submit .= ' ' . $parameters;

    $image_submit .= '>';

    return $image_submit;
  }


////
// Output a function button in the selected language
  function tep_image_button($image, $alt = '' , $parameters = '') {
    global $language;

//    return tep_image(DIR_WS_LANGUAGES . $language . '/images/buttons/' . $image, $alt, '', '', $parameters);
    return tep_image(DIR_WS_TMPL_IMAGES . 'buttons/'. $language .'/' .$image, $alt, '', '', $parameters);
  }

////
// Output a separator either through whitespace, or with an image
  function tep_draw_separator($image = 'pixel_black.gif', $width = '100%', $height = '1') {
    return tep_image(DIR_WS_TMPL_IMAGES . 'misc/' . $image, '', $width, $height);
  }

////
// Output a form
  function tep_draw_form($name, $action, $method = 'post', $parameters = '') {
    $form = '<form name="' . tep_output_string($name) . '" action="' . tep_output_string($action) . '" method="' . tep_output_string($method) . '"';

    if (tep_not_null($parameters)) $form .= ' ' . $parameters;

    $form .= '>';

    return $form;
  }

////
// Output a form input field
  function tep_draw_input_field($name, $value = '', $parameters = '', $required = false, $type = 'text', $reinsert_value = true) {
		global $HTTP_GET_VARS, $HTTP_POST_VARS;
    $field = '<input type="' . tep_output_string($type) . '" name="' . tep_output_string($name) . '"';

    if ( ($reinsert_value == true) && ( (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) || (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) ) ) {
      if (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) {
        $value = stripslashes($HTTP_GET_VARS[$name]);
      } elseif (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) {
        $value = stripslashes($HTTP_POST_VARS[$name]);
      }
    }

    if (tep_not_null($value)) {
      $field .= ' value="' . tep_output_string($value) . '"';
    }

    if (tep_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
  }

////
// Output a form password field
  function tep_draw_password_field($name, $value = '', $required = false) {
    $field = tep_draw_input_field($name, $value, 'maxlength="40"', $required, 'password', false);

    return $field;
  }

////
// Output a selection field - alias function for tep_draw_checkbox_field() and tep_draw_radio_field()
  function tep_draw_selection_field($name, $type, $value = '', $checked = false, $compare = '') {
		global $HTTP_GET_VARS, $HTTP_POST_VARS;
    $selection = '<input type="' . tep_output_string($type) . '" name="' . tep_output_string($name) . '"';

    if (tep_not_null($value)) $selection .= ' value="' . tep_output_string($value) . '"';
	
    if ( ($checked == true) || (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name]) && (($HTTP_GET_VARS[$name] == 'on') || (stripslashes($HTTP_GET_VARS[$name]) == $value))) || (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name]) && (($HTTP_POST_VARS[$name] == 'on') || (stripslashes($HTTP_POST_VARS[$name]) == $value))) || (tep_not_null($compare) && ($value == $compare)) ) {
      $selection .= ' CHECKED';
    }

	if (tep_not_null($compare)) $selection .= ' ' . $compare;

    $selection .= '>';

    return $selection;
  }

////
// Output a form checkbox field
  function tep_draw_checkbox_field($name, $value = '', $checked = false, $compare = '') {
    return tep_draw_selection_field($name, 'checkbox', $value, $checked, $compare);
  }

////
// Output a form radio field
  function tep_draw_radio_field($name, $value = '', $checked = false, $compare = '') {
    return tep_draw_selection_field($name, 'radio', $value, $checked, $compare);
  }

/// funkcja do podzielenia lancucha znakow np 128mb (67 zl) - zeby po mb bylo <br>
  function podziel($tekst) {
    $b=strpos($tekst, "("); 
	$poczatek=substr($tekst,0,$b);
	$ile_znakow=strlen($tekst);
	$koniec=substr($tekst,$b,$ile_znakow);
	$caly_ciag=$poczatek . '<br>' . $koniec;
   return $caly_ciag;
 }

  
  
////
// Output a form textarea field
  function tep_draw_textarea_field($name, $wrap, $width, $height, $text = '', $parameters = '', $reinsert_value = true) {
		global $HTTP_GET_VARS, $HTTP_POST_VARS;
    $field = '<textarea name="' . tep_output_string($name) . '" wrap="' . tep_output_string($wrap) . '" cols="' . tep_output_string($width) . '" rows="' . tep_output_string($height) . '"';

    if (tep_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if ( ($reinsert_value == true) && ( (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) || (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) ) ) {
      if (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) {
        $field .= tep_output_string_protected(stripslashes($HTTP_GET_VARS[$name]));
      } elseif (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) {
        $field .= tep_output_string_protected(stripslashes($HTTP_POST_VARS[$name]));
      }
    } elseif (tep_not_null($text)) {
      $field .= tep_output_string_protected($text);
    }

    $field .= '</textarea>';

    return $field;
  }

////
// Output a form hidden field
  function tep_draw_hidden_field($name, $value = '', $parameters = '') {
		global $HTTP_GET_VARS, $HTTP_POST_VARS;

    $field = '<input type="hidden" name="' . tep_output_string($name) . '"';

    if (tep_not_null($value)) {
      $field .= ' value="' . tep_output_string($value) . '"';
    } elseif ( (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) || (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) ) {
      if ( (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) ) {
        $field .= ' value="' . tep_output_string(stripslashes($HTTP_GET_VARS[$name])) . '"';
      } elseif ( (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) ) {
        $field .= ' value="' . tep_output_string(stripslashes($HTTP_POST_VARS[$name])) . '"';
      }
    }

    if (tep_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    return $field;
  }

////
// Hide form elements
  function tep_hide_session_id() {
    global $session_started, $SID;

    if (($session_started == true) && tep_not_null($SID)) {
      return tep_draw_hidden_field(tep_session_name(), tep_session_id());
    }
  }

////
// Output a form pull down menu
  function tep_draw_pull_down_menu($name, $values, $default = '', $parameters = '', $required = false) {
    global $HTTP_GET_VARS, $HTTP_POST_VARS;

		$field = '<select name="' . tep_output_string($name) . '"';

    if (tep_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if (empty($default) && ( (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) || (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) ) ) {
      if (isset($HTTP_GET_VARS[$name]) && is_string($HTTP_GET_VARS[$name])) {
        $default = stripslashes($HTTP_GET_VARS[$name]);
      } elseif (isset($HTTP_POST_VARS[$name]) && is_string($HTTP_POST_VARS[$name])) {
        $default = stripslashes($HTTP_POST_VARS[$name]);
      }
    }

    for ($i=0, $n=sizeof($values); $i<$n; $i++) {
      $field .= '<option value="' . tep_output_string($values[$i]['id']) . '"';
      if ($default == $values[$i]['id']) {
        $field .= ' SELECTED';
      }

      $field .= '>' . tep_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>';
    }
    $field .= '</select>';

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
  }

////
// Creates a pull-down list of countries
  function tep_get_country_list($name, $selected = '', $parameters = '') {
    $countries_array = array(array('id' => '', 'text' => PULL_DOWN_DEFAULT));
    $countries = tep_get_countries();

    for ($i=0, $n=sizeof($countries); $i<$n; $i++) {
      $countries_array[] = array('id' => $countries[$i]['countries_id'], 'text' => $countries[$i]['countries_name']);
    }

    return tep_draw_pull_down_menu($name, $countries_array, $selected, $parameters);
  }

//// 
// output a flash movie - by ManMachine
/*
$name is for the movie id 
$movie is the flash file   ie : movie.swf
if no width or height are set the movie will be displayed as big as possible ( depending on browser ) .
if no background is set , will be a trasnparent background 
parameters must look like   :  'param1=value1&param2=valu2'  or 'param1='.$value1.'$param2=value2'  ..etc..
enjoy ;)
ManMachine
*/
  function mm_output_flash_movie($name, $movie, $width = '' , $height = '' , $background = '' , $parameters = '') {
    
    if(tep_not_null($width)) {
		$movie_width = 'width="'.$width.'"' ;
	}
    
	if(tep_not_null($height)) {
		$movie_height = 'height="'.$height.'"' ;
	}

	if(tep_not_null($parameters)) {
	  $flash_movie = $movie . '?' . $parameters ;
	} else {
	  $flash_movie = $movie ;
	}
	
	$flash  = '<object type="application/x-shockwave-flash" data="'.$movie.'" '.$movie_width . $movie_height.'>'."\n";
	$flash .= '<param name="movie" value="'.$flash_movie.'" />' . "\n";
 
	if(tep_not_null($background)) {
	  $flash .= '<param name="bgcolor" value="#'.$background.'" />' . "\n" ;	
	} else {
	  $flash .= '<param name="wmode" value="transparent">' . "\n" ;
	}
	
	$flash .= '</object>' . "\n" ;

    return $flash;



    return $flash;
  }

////
// "On the Fly" Auto Thumbnailer using GD Library, servercaching and browsercaching
// Scales product images dynamically, resulting in smaller file sizes, and keeps
// proper image ratio. Used in conjunction with product_thumb.php t/n generator.
function tep_obrazek($src, $width = '', $height = '') { 
  
  // Set default image variable and code
  $image = '' . $src . '';
  
  // Don't calculate if the image is set to a "%" width
  if (strstr($width,'%') == false || strstr($height,'%') == false) { 
    $dont_calculate = 0; 
  } else {
    $dont_calculate = 1;    
  }

  // Dont calculate if a pixel image is being passed (hope you dont have pixels for sale)
  if (!strstr($image, 'pixel')) {
    $dont_calculate = 0;
  } else {
    $dont_calculate = 1;
  } 
  
  // Do we calculate the image size?
  if (CONFIG_CALCULATE_IMAGE_SIZE && !$dont_calculate) { 
    
    // Get the image's information
    if ($image_size = @getimagesize($src)) { 
      
      $ratio = $image_size[1] / $image_size[0];
      
      // Set the width and height to the proper ratio
      if (!$width && $height) { 
        $ratio = $height / $image_size[1]; 
        $width = intval($image_size[0] * $ratio); 
      } elseif ($width && !$height) { 
        $ratio = $width / $image_size[0]; 
        $height = intval($image_size[1] * $ratio); 
      } elseif (!$width && !$height) { 
        $width = $image_size[0]; 
        $height = $image_size[1]; 
      } 
      
      // Scale the image if not the original size
      if ($image_size[0] != $width || $image_size[1] != $height) { 
        $rx = $image_size[0] / $width; 
        $ry = $image_size[1] / $height; 
  
        if ($rx < $ry) { 
          $width = intval($height / $ratio); 
        } else { 
          $height = intval($width * $ratio); 
        } 
  
        $image = 'product_thumb.php?img='.$src.'&w='.
        tep_output_string($width).'&h='.tep_output_string($height).'';
      }
      
    } elseif (IMAGE_REQUIRED == 'false') { 
      return ''; 
    } 
  } 
  
  
  return $image; 
}

//Start Code - ShowNewPrice

  function tep_draw_pull_down_menu_price_update($name, $values, $default = '', $parameters = '', $required = false) {
    $field = '<select onchange="Total();" name="' . tep_output_string($name) . '"';
    if (tep_not_null($parameters)) $field .= ' ' . $parameters;
    $field .= '>';
    if (empty($default) && isset($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);
    for ($i=0, $n=sizeof($values); $i<$n; $i++) {
      $field .= '<option value="' . tep_output_string($values[$i]['id']) . '"';
      if ($default == $values[$i]['id']) {
        $field .= ' SELECTED';
      }
      
      
      $field .= '>' . tep_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) .$strip_prices. '</option>';
    }
    $field .= '</select>';
    if ($required == true) $field .= TEXT_FIELD_REQUIRED;
    return $field;
  }
  
//Stop Code - ShowNewPrice

?>