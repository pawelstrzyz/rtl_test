<?php
// "On the Fly Thumbnailer" using PHP GD Graphics Library by Nathan Welch (v1.5)
// Scales product images dynamically, resulting in smaller file sizes, and keeps
// proper image ratio.  Used in conjunction with modified tep_image in html_output.php
//
// CONFIGURATION SETTINGS 
//
// Use Resampling? Set the value below to true to generate resampled thumbnails
// resulting in smoother-looking images.  Not supported in GD ver. < 2.01
$use_resampling = true;
//
// Create True Color Thumbnails? Better quality overall but set to false if you
// have GD version < 2.01 or if creating transparent thumbnails.
$use_truecolor = true;
//
// Output GIFs as JPEGS? Set this option to true if you have GD version > 1.6
// and want to output GIF thumbnails as JPGs instead of GIFs or PNGs.  Note that your
// GIF transparencies will not be retained in the thumbnail if you output them
// as JPGs. If you have GD Library < 1.6 with GIF create support, GIFs will
// be output as GIFs. Set the "matte" color below if setting this option to true.
$gif_as_jpeg = false;
//
// Define RGB Color Value for background matte color if outputting GIFs as JPEGs
// Example: white is r=255, b=255, g=255; black is r=0, b=0, g=0; red is r=255, b=0, g=0;
$r = 255; // Red color value (0-255)
$g = 255; // Green color value (0-255)
$b = 255; // Blue color value (0-255)
//
// Maintain aspect ration
$maintain_aspect_ratio = true;
// END CONFIGURATION SETTINGS

// get and validate image path disabled for admin area
$image_path = str_replace ( "../", "", $_GET['img'] );


$image_path = $_GET['img'];
$new_width = $_GET['w'];
$new_height = $_GET['h'];


// Get the size of the image
$image = @getimagesize($image_path);
$orig_width = $image[0];
$orig_height = $image[1];

// Do not output if get values are larger than orig image
if ($new_width > $orig_width || $new_height > $orig_height) {
        $new_width = $orig_width;
        $new_height = $orig_height;     
} else {
        //adjust width and height for aspect ratio
        if ($maintain_aspect_ratio) {
                //get lowest side
                if($orig_width>$orig_height){
                        // height is smaller so constrain width
                        $new_width = $orig_width*$new_height/$orig_height;
                } else {
                        // width is smaller or same
                        $new_height = $orig_height*$new_width/$orig_width;
                }
        } // end if
} // end if
 

// Create appropriate image header
if ($image[2] == 2 || ($image[2] == 1 && $gif_as_jpeg)) {
        header('Content-type: image/jpeg');
} elseif ($image[2] == 1 && function_exists("imagegif")) {
        header('Content-type: image/gif');
}  elseif ($image[2] == 3 || $image[2] == 1) {
        header('Content-type: image/png');
} 

// Create a new, empty image based on settings
if (function_exists("imagecreatetruecolor") && $use_truecolor)
        $tmp_img = imagecreatetruecolor($new_width,$new_height);
else
        $tmp_img = imagecreate($new_width,$new_height); 

$th_bg_color = imagecolorallocate($tmp_img, $r, $g, $b);
                
imagefill($tmp_img, 0, 0, $th_bg_color);
imagecolortransparent($tmp_img, $th_bg_color);

// Create the image to be scaled
if ($image[2] == 2 && function_exists("imagecreatefromjpeg")) {
        $src = imagecreatefromjpeg($image_path);
} elseif ($image[2] == 1 && function_exists("imagecreatefromgif")) {
        $src = imagecreatefromgif($image_path);
} elseif (($image[2] == 3 || $image[2] == 1) && function_exists("imagecreatefrompng")) {
        $src = imagecreatefrompng($image_path);
} 

// Scale the image based on settings
if (function_exists("imagecopyresampled") && $use_resampling)
        imagecopyresampled($tmp_img, $src, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);
else
        imagecopyresized($tmp_img, $src, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);

                
// Output the image
if ($image[2] == 2 || ($image[2] == 1 && $gif_as_jpeg)) {
        imagejpeg($tmp_img);
} elseif ($image[2] == 1 && function_exists("imagegif")) {
        imagegif($tmp_img);
} elseif ($image[2] == 3 || $image[2] == 1) {
        imagepng($tmp_img);
}

// Clear the image from memory
imagedestroy($src);
imagedestroy($tmp_img);

?>