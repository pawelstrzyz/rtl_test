<?php
/*
  $Id: pdf_datasheet_config.php 1 2007-12-20 23:52:06Z $
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2003 osCommerce
  Released under the GNU General Public License
  Modified by Jochen Kirchhoff, jochen888@web.de
  
*/

	//PDF Data Sheet Config ------------------
	// " $this->SetFont('helvetica','B',18); " in pdf_datasheet_functions.php defines txt style,  ---> (font face) , [empty string: regular - B: bold - I: italic - U: underline ], (size)
	// available fonts in "font" folder
	//PDF_SHOW_LOGO
	//	define('SHOW_LOGO',1);						// set to 1 if company logo must be displayed
	//	define('PDF_STORE_LOGO', DIR_WS_IMAGES . 'pdflogo/logo.gif');	// path to company logo. Default = gif type. If not, please change in pdf_datasheet_functions.php where PDF_STORE_LOGO is used
	//StoreName Txt color
	//	define('HEADER_COLOR_TEXT','0,200,200');
	// Body Text color
	//	define('BODY_COLOR_TEXT','0,0,0');
	//Header Cell bg color
	//	define('HEADER_COLOR_TABLE','230,230,230');
	//Product name bg color
	define('PRODUCT_NAME_COLOR_TABLE','230,230,230');
	//Product name text color
	define('PRODUCT_NAME_COLOR_TEXT','0,0,0');
	//Bottom Cell bg color
	define('FOOTER_CELL_BG_COLOR','210,210,210');
	//Bottom Cell text color
	define('FOOTER_CELL_TEXT_COLOR','0,0,0');
	// Special Price field color
	define('SPECIAL_PRICE_COLOR_FIELD','255,255,0');
	// Special Price text color
	define('SPECIAL_PRICE_COLOR_TEXT','255,0,0');
	//	define('SHOW_BACKGROUND',0);      //Shows bg color defined here below
	//Page Bg color
	//	define('PAGE_BG_COLOR','250,250,250');
	//	define('SHOW_WATERMARK',1);      //Prints Store Name as watermark, a bit of customization can be done in the functions file
	//function Watermark() at page bottom
	//Page Watermark color
	//define('PAGE_WATERMARK_COLOR','236,245,255');   //keep it light :-)
	//Images
	//	define('PDF_IMAGE_KEEP_PROPORTIONS',1);  //With custom image (different sizes then std.) set this to 1,
                                              //set the following  MAX_IMAGE_WIDTH to the width size you desire es.: 200,
                                              //MAX_IMAGE_HEIGHT can be anything but not NULL
	//	define('MAX_IMAGE_WIDTH', 200);   //Width max in mm
	//	define('MAX_IMAGE_HEIGHT',200);   //Height max in mm
	//define('PDF_TO_MM_FACTOR',0.3526); //Pix to mm factor
         
	//Path to your saved Documents (remember to change (chmod) the rights for that folder!)
	//	define('PDF_DOC_PATH', 'pdfdocs/');
	// Height for products descriptions, needed for pagebreak calcultations
	define('TEXT_HEIGHT', 240);

	//redirect to the file or download it (1->redirect,0-<download)
	//	define('FILE_REDIRECT', 0);
	//indicate the name of the DB field containing the alternate image (es.: $products_bimage) 
	define('PDF_ALT_IMAGE', 'products_image');   //If an image other than the small std. image is used

	// BOF Mod for 3 Images Contrib
	if(PDF_ALT_IMAGE == 'products_image') {
		define('DIR_IMAGE', DIR_WS_IMAGES);
	}
	elseif(PDF_ALT_IMAGE == 'products_image_medium'){
		define('DIR_IMAGE', DIR_WS_IMAGES . 'medium/');
	}
	elseif(PDF_ALT_IMAGE == 'products_image_large'){
		define('DIR_IMAGE', DIR_WS_IMAGES . 'large/');
	}
	// EOF Mod for 3 Images Contrib

	//Display Options
	define('SHOW_PATH',1);
	define('SHOW_IMAGES',1);
	define('SHOW_NAME',1);            //Shows products name in description  (I guess no need, it is already in the title)
	define('SHOW_MODEL',1);
	define('SHOW_DESCRIPTION',1);
	define('SHOW_MANUFACTURER',1);
	define('SHOW_PRICE',1);
	define('SHOW_PRICES_INC_EX_TAX', 1);  //Set this = 1 to show both inc TAX and (ex TAX prices), works ONLY IF "admin > Configuration > My Store > Display Prices with Tax"  is set to true.
	define('SHOW_SPECIALS_PRICE',1);      //Will show both inc TAX and (ex TAX prices) according to the above setting.
	define('SHOW_SPECIALS_PRICE_EXPIRES',1);  //Set this = 1 to show expiring date of special price.
	define('SHOW_TAX_CLASS_ID',0);
	define('SHOW_OPTIONS',1);
	define('SHOW_DATE_ADDED_AVAILABLE',1);
	define('SHOW_OPTIONS_PRICE',1);       	// Only if  'SHOW_OPTIONS' = 0  :-)
	define('SHOW_OPTIONS_VERTICAL', 1)	// set to 1 if you want your options values vertically displayed
?>