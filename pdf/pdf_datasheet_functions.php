<?php
/*
  $Id: pdf_datasheet_functions.php 1 2007-12-20 23:52:06Z $
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2003 osCommerce
  Released under the GNU General Public License
  
  Modified by Jochen Kirchhoff, jochen888@web.de
  Anmerkung:
  -Anpassung für 3 Images Contribution optional im Quelltext
*/

define('FPDF_FONTPATH','pdf/font/');
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PDF_DATASHEET);
require('pdf/pdf_datasheet_config.php');
require('pdf/fpdf/ufpdf.php');

$products_id = $HTTP_GET_VARS['products_id'];

if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') { 
   $products_id = substr (strrchr (getenv('PATH_INFO'), "/"), 1 ); 
 }

// global name of the later document
$docfilename = ''; 
 
class PDF extends UFPDF
{
//Starting Y position
var $y0;

 function Header()
 {
 global $products_id;
 global $languages_id;
 
    if(PDF_SHOW_BACKGROUND){
    //Show background
    $this->Background();
    }
    if(PDF_SHOW_WATERMARK){
    //Put watermark
    $this->Watermark();
    }
	
	if(PDF_SHOW_LOGO != 'false' )
    	{
    		// Store Logo
		// BOF Mod for correct imagesize & type
		// Get the data of this picture
		$size =getimagesize(PDF_STORE_LOGO);
		//Get the type of this picture
		switch ($size[2]) {
			case 1:
			//picturetype is 'gif'
				$imagetype ='GIF';
				break;
			case 2:
			//picturetype is 'jpg'
				$imagetype ='JPG';
				break;
			case 3:
			//picturetype is 'png'
				$imagetype ='PNG';
				break;
		}
		
		$this->Image(PDF_STORE_LOGO,'15','5',($size[0]*PDF_INV_IMG_CORRECTION),($size[1]*PDF_INV_IMG_CORRECTION), $imagetype, HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_DEFAULT);
		// EOF Mod for correct imagesize & type
	} else {
    		//Store Name
    		$this->SetFont('arialb','B',18);
				$this->SetLineWidth(0);
    		$w=$this->GetStringWidth(STORE_NAME)+6;
    		$header_text_color=explode(",",PDF_HEADER_COLOR_TEXT);
    		$this->SetTextColor($header_text_color[0], $header_text_color[1], $header_text_color[2]);
    		$this->Cell($w,8,STORE_NAME,0,0,'C');
	}

	//PDF-Info
	$this->SetAuthor(STORE_NAME);
	$this->SetTitle($this->ProductsName($products_id, $languages_id));
	$this->SetSubject(PDF_TITLE);

	//Today's date
	$this->SetTextColor(0,0,0);
	$date = strftime(DATE_FORMAT_LONG);
	$this->SetFont('arial','',9);
	$this->Cell(0,8,PDF_CREATION_DATE . ' : ' . $date . ' ',0,1,'R');
  $this->Ln(1);
	$x=$this->GetX();
	$y=$this->GetY();
	$this->Line($x,$y,$this->w-$this->rMargin,$y);
	$this->Ln(0.5);
    //Keep Y position
    $this->y0=$this->GetY();

    $this->Ln(0);
    $path = $this->GetPath($products_id, $languages_id);
    $products_name = $this->ProductsName($products_id, $languages_id);
		$this->SetFont('ariali','I',10);
    $header_color_table=explode(",",PDF_HEADER_COLOR_TABLE);
    $this->SetFillColor($header_color_table[0], $header_color_table[1], $header_color_table[2]);
    $this->Cell(0,6,$path .' > '. $products_name,0,0,'L',1);
    $this->Ln(10);

	// Display product name
    $this->SetFont('arialb','B',16);
    $product_name_color_table=explode(",",PRODUCT_NAME_COLOR_TABLE);
    $this->SetFillColor($product_name_color_table[0], $product_name_color_table[1], $product_name_color_table[2]);
	  $product_name_color_text=explode(",",PRODUCT_NAME_COLOR_TEXT);
    $this->SetTextColor($product_name_color_text[0], $product_name_color_text[1], $product_name_color_text[2]);		
	  $this->MultiCell(0,8,$products_name,0,'L',1);
	  $this->Ln(9);
 }
 
  function RotatedText($x,$y,$txt,$angle)
 {
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
 }

 function Footer()
 {
    //Footer notes
    $this->SetY(-8);
    $footer_color_cell=explode(",",FOOTER_CELL_BG_COLOR);
    $this->SetFillColor($footer_color_cell[0], $footer_color_cell[1], $footer_color_cell[2]);
 	  $footer_color_text=explode(",",FOOTER_CELL_TEXT_COLOR);
    $this->SetTextColor($footer_color_text[0], $footer_color_text[1], $footer_color_text[2]);
    $this->SetFont('arial','',8);
	  $this->Cell(0,6,TEXT_PDF_FOOTER . " - " . STORE_OWNER_EMAIL_ADDRESS . '                       ' . TEXT_PAGE . ' ' . $this->PageNo().'/{nb}',0,0,'L',1,'mailto:'. STORE_OWNER_EMAIL_ADDRESS);
 }

 function CheckPageBreak($h)
 {
	//Creates a new page if needed
	if($this->GetY()+$h>$this->PageBreakTrigger){
		$this->AddPage($this->CurOrientation);
		}
 }

 function NbLines($w,$txt)
 {
	//Calculate number of lines for a "w" width Multicell
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}

 function LineString($x,$y,$txt,$cellheight)
 {
		//calculate the width of the string
		$stringwidth=$this->GetStringWidth($txt);

		//calculate the width of an alpha/numerical char
		$numberswidth=$this->GetStringWidth('1');
		$xpos=($x+$numberswidth);
	    $ypos=($y+($cellheight/2));
		$this->Line($xpos,$ypos,($xpos+$stringwidth),$ypos);
 }

 function ShowImage(&$width,&$height,$path,$loc='',$x_pos=1)
 {
 	$width=min($width,PDF_MAX_IMAGE_WIDTH);
	$height = (IMAGE_KEEP_PROPORTIONS != 0 ? $height : min($height,PDF_MAX_IMAGE_HEIGHT));
 	$this->SetLineWidth(1);
	$this->Cell($width,$height,"",0,0);
	$this->SetLineWidth(0.2);
	$pos=strrpos($path,'.');
	$type=substr(strtolower($path),$pos+1);
	if($type=='jpg' or $type=='jpeg' or $type=='png' or $type=='gif'){
				if ($loc==false){
        $this->Image($path,($this->GetX()-$width)+1, $this->GetY(), $width, $height);
    }else{
					$this->SetY(($this->GetY())+5);
					$this->Image($path,$x_pos +1, $this->GetY(), $width, $height);
				}
    }else{
        $this->SetDrawColor(230,230,230);
				if($loc==false){
        $this->x = $this->GetX()-$width;
				}else{
					$this->x = $this->GetX();
				}
        $this->SetTextColor(230,230,230);
        $this->Cell($width,$height,'No image',1,0,C);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
	}
 }

 function CalculatedSpace($y1,$y2,$imageheight)
 {
 	//Si les commentaires sont - importants que l'image au niveau de l'espace d'affichage
	if(($h2=$y2-$y1) < $imageheight)
	{
	   $this->Ln(($imageheight-$h2)+3);
	}
	else
	{
	   $this->Ln(3);
	}
 }

 function DrawCells($data_array)
 {
 	 $totallines=0;

	 for($i=2;$i<(sizeof($data_array)-1);$i++)
	 {
	 	$totallines+=$this->NbLines((220-$data_array[0]),$data_array[$i]);
	 }

	 //5 = cells height
	 $h=5*$totallines."<br />";

	 //if products description takes the whole page height goes to new page
	 if($h<TEXT_HEIGHT)
	 {
	 	$this->CheckPageBreak($h);
	 }
 if(SHOW_IMAGES && strlen($data_array[10]))
 	{
        //If custom image
        if(PDF_IMAGE_KEEP_PROPORTIONS != 0 )
        {
		$heightwidth=getimagesize($data_array[10]);
		$factor = $heightwidth[0]/$heightwidth[1];
                $data_array[0]=$imagewidth=PDF_MAX_IMAGE_WIDTH*PDF_INV_IMG_CORRECTION;
// 		Bild in Orginalgröße abbilden, maximale Größe ignorieren
//		$data_array[0]=$imagewidth=$heightwidth[1]*PDF_INV_IMG_CORRECTION;
		$data_array[1]=$data_array[0]/$factor;

		$this->ShowImage($data_array[0],$data_array[1],$data_array[10]);
		$y1=$this->GetY();
        }

	 	//If Small Image Width and Small Image Height are defined
	 	else if(strlen($data_array[0])>1 && strlen($data_array[1])>1)
		{
	 		$this->ShowImage($data_array[0],$data_array[1],$data_array[10]);
	 		$y1=$this->GetY();
		}
	    //If only Small Image Width is defined
		else if(strlen($data_array[0])>1 && strlen($data_array[1]))
		{
		    $heightwidth=getimagesize($data_array[10]);
			$data_array[0]=$data_array[0];
		    $data_array[1]=$heightwidth[1]*PDF_INV_IMG_CORRECTION;

	 		$this->ShowImage($data_array[0],$data_array[1],$data_array[10]);
	 		$y1=$this->GetY();
		}
		//If only Small Image Height is defined
		else if(strlen($data_array[0]) && strlen($data_array[1])>1)
		{
			$heightwidth=getimagesize($data_array[10]);
			$data_array[0]=$width=$heightwidth[0]*PDF_INV_IMG_CORRECTION;
		    $data_array[1]=$data_array[1];

	 		$this->ShowImage($data_array[0],$data_array[1],$data_array[10]);
	 		$y1=$this->GetY();
		}
		else
		{
			$heightwidth=getimagesize($data_array[10]);
			$data_array[0]=$heightwidth[0]*PDF_INV_IMG_CORRECTION;
		    $data_array[1]=$heightwidth[1]*PDF_INV_IMG_CORRECTION;

	 		$this->ShowImage($data_array[0],$data_array[1],$data_array[10]);
	 		$y1=$this->GetY();
		}
	}
	else
	{
		$data_array[0]=$data_array[1]=0;
		$y1=$this->GetY();
	}

     $this->SetFont('arial','',11);
     $body_color_text=explode(",",PDF_BODY_COLOR_TEXT);
     $this->SetTextColor($body_color_text[0], $body_color_text[1], $body_color_text[2]);

	 if(SHOW_MODEL)
	 {
	 	$this->Cell(3,5,"",0,0);
		$this->SetFont('arial','',9);
	 	$this->MultiCell(180-$data_array[0],5,TEXT_PRODUCTS_MODEL . $data_array[2],0,'L');
	 }
	 if(SHOW_NAME)
	 {
	 	$this->Cell($data_array[0]+3,5,"",0,0);
	 	$this->MultiCell(180-$data_array[0],5,$data_array[3],0,'L');
	 }
	 if(SHOW_MANUFACTURER)
	 {
	    $this->SetFont('arial','',9);
	 	$this->Cell($data_array[0]+3,5,"",0,0);
	 	$this->MultiCell(180-$data_array[0],10,TEXT_PRODUCTS_MANUFACTURER . $data_array[5],0,'L');
	 }
	 if(SHOW_DESCRIPTION)
	 {
		$this->SetFont('arial','',9);
	 	$this->Cell($data_array[0]+3,5,"",0,0);
		$desc= array();
		$desc= explode("\n",$data_array[6]);
	 	$x=$this->GetX();
				foreach ($desc as $desc_row){
					$desc_row= str_replace("\n",'',$desc_row);
					$desc_row= str_replace("<br />",'',$desc_row);
					$desc_row= str_replace("<li>",'• ',$desc_row);
					$desc_row= str_replace("<LI>",'• ',$desc_row);
					$y=($this->GetY()+5);
					$found= eregi('images/(.*\.gif|.*\.jpg)',$desc_row,$img);
					if($found==true){
						$img[1]=str_replace('.gif','.jpg',$img[1]);
						$path_to_image = DIR_IMAGE . $img[1];
						if(file_exists($path_to_image)){
							$desc_row='IMG ' . $path_to_image;
							$img_size= GetImageSize($path_to_image);
							$img[7]=($img_size[1]*PDF_INV_IMG_CORRECTION);
							$img[6]=$img_size[0]*PDF_INV_IMG_CORRECTION;
							$this->ShowImage($img[6],$img[7],$path_to_image,$loc=1,$x);
							$this->SetY($img[7]+$y +5);
						}else{
							$this->ln(2);
						}
					}else{
						$text2= strip_tags($desc_row);
						$this->SetX($x);
						$this->MultiCell(180-$data_array[0]- $this->rMargin,4,$text2,0,'L');
					}
				}
	 }
	 if(SHOW_TAX_CLASS_ID)
	 {
	    $this->Cell($data_array[0]+3,5,"",0,0);
	 	$this->MultiCell(180-$data_array[0],5,$data_array[7],0,'L');

	 }
     if(SHOW_PRICE)
     {
		$this->SetTextColor(128, 31, 27);
        $this->SetFont('arialb','B',11);
  	 	if(strlen($data_array[8]) && SHOW_SPECIALS_PRICE != 0) //If special price
		{
	 		$this->Cell($data_array[0]+3,5,"",0,0);
			$x=$this->GetX();
			$y=$this->GetY();
			$sw=$this->GetStringWidth($data_array[9]);
	  		$this->MultiCell($sw+5,5,$data_array[9],0,'L');
			$this->LineString($x,$y,$data_array[9],5);
		}
  		else if(strlen($data_array[9]))
		{
			$this->Cell($data_array[0]+3,5,"",0,0);
			$this->MultiCell(160-$data_array[0],5,$data_array[9],0,'L');

		}
      }
     if(SHOW_SPECIALS_PRICE)
	 {
        $this->SetFont('arialb','B',11);
  		$special_price_color_field=explode(",",SPECIAL_PRICE_COLOR_FIELD);
    	$this->SetFillColor($special_price_color_field[0], $special_price_color_field[1], $special_price_color_field[2]);
  		$special_price_color_text=explode(",",SPECIAL_PRICE_COLOR_TEXT);
    	$this->SetTextColor($special_price_color_text[0], $special_price_color_text[1], $special_price_color_text[2]);
	    $this->Cell($data_array[0]+3,7,"",0,0);
	 	$this->MultiCell(180-$data_array[0],7,$data_array[8],0,'L');
    	$this->SetFillColor(0,0,0);
     	$this->SetFont('arial','',9);
        if(strlen($data_array[8]) && SHOW_SPECIALS_PRICE_EXPIRES != 0)
	    {
        $this->Cell($data_array[0]+3,5,"",0,0);
        $this->MultiCell(180-$data_array[0],5,$data_array[11],0,'L');
        }
	 }

	 $x2=$this->GetX();
	 $y2=$this->GetY();

     $this->SetFont('arial','',9);

     //if products description does not takes the whole page height
//	 if($h<260)
//	 {
		 $this->CalculatedSpace($y1,$y2,$data_array[1]);
// 	 }
 }

 function GetPath($products_id, $languages_id) {
    $cPath = '';

    $cat_count_sql = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $products_id . "'");
    $cat_count_data = tep_db_fetch_array($cat_count_sql);

    if ($cat_count_data['count'] == 1) {
      $categories = array();

      $cat_id_sql = tep_db_query("select pc.categories_id, cd.categories_name from " . TABLE_PRODUCTS_TO_CATEGORIES . " pc,  " . TABLE_CATEGORIES_DESCRIPTION . " cd where
                                  pc.products_id = '" . $products_id . "' and
                                  cd.categories_id = pc.categories_id and
								  cd.language_id = '" . $languages_id . "'");
      $cat_id_data = tep_db_fetch_array($cat_id_sql);
      tep_get_parent_categories($categories, $cat_id_data['categories_id']);

      $size = sizeof($categories)-1;
      for ($i = $size; $i >= 0; $i--) {
        if ($cPath != '') $cPath .= ' > ';
        $parent_id_sql = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where
           	                          categories_id = '" . $categories[$i] . "' and
                               		  language_id = '" . $languages_id . "'");
        $parent_id_data = tep_db_fetch_array($parent_id_sql);
        $cPath .= $parent_id_data['categories_name'];
      }
      if ($cPath != '') $cPath .= ' > ';
      $cPath .= $cat_id_data['categories_name'];
    }

    return $cPath;
  }


 function ProductsName($products_id, $languages_id){
	    $products_name_query = tep_db_query("select products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where
                               products_id = '" . $products_id . "' and
                               language_id = '" . $languages_id . "'");
      $products_name = tep_db_fetch_array($products_name_query);
      return $products_name['products_name'];
}


  function ProductsDataSheet($languages_id, $products_id){
      global $currencies;
      global $docfilename;

	  //Convertion pixels -> mm
   	  $imagewidth=SMALL_IMAGE_WIDTH*PDF_INV_IMG_CORRECTION;
	  $imageheight=SMALL_IMAGE_HEIGHT*PDF_INV_IMG_CORRECTION;

			
    $print_catalog_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.". PDF_ALT_IMAGE .", p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.products_status, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price,  s.expires_date, m.manufacturers_name
                                                         from ((" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd)
                                                         left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id)
                                                         left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                                                         where p.products_status = '1' and p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");

			
        if ($print_catalog = tep_db_fetch_array($print_catalog_query)){
            $price_with_tax_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'DISPLAY_PRICE_WITH_TAX'");
            $price_with_tax = tep_db_fetch_array($price_with_tax_query);
            $price_tax = $price_with_tax['configuration_value'];
         if(SHOW_PRICES_INC_EX_TAX != 0 && DISPLAY_PRICE_WITH_TAX == 'true'){
             if ($new_price = tep_get_products_special_price($print_catalog['products_id'])) {
             $specials_price =  TEXT_PRODUCTS_SPECIALS_PRICE . $currencies->display_price($print_catalog['products_id'],$new_price, tep_get_tax_rate($print_catalog['products_tax_class_id'])) . TEXT_PRICE_VAT_INCLUDED . '  (' . $currencies->display_price($print_catalog['products_id'],$new_price, tep_get_tax_rate('')) . TEXT_PRICE_EX_VAT . ')';
             $products_price = TEXT_PRODUCTS_PRICE . $currencies->display_price($print_catalog['products_id'],$print_catalog['products_price'], tep_get_tax_rate($print_catalog['products_tax_class_id'])) . TEXT_PRICE_VAT_INCLUDED . '  (' . $currencies->display_price($print_catalog['products_id'],$print_catalog['products_price'], '') . TEXT_PRICE_EX_VAT . ')';
             } else {
                     $products_price = TEXT_PRODUCTS_PRICE . $currencies->display_price($print_catalog['products_id'],$print_catalog['products_price'], tep_get_tax_rate($print_catalog['products_tax_class_id'])) . TEXT_PRICE_VAT_INCLUDED . '  (' . $currencies->display_price($print_catalog['products_id'],$print_catalog['products_price'], '') . TEXT_PRICE_EX_VAT . ')';
             }
         } else {
              if ($new_price = tep_get_products_special_price($print_catalog['products_id'])) {
             $specials_price =  TEXT_PRODUCTS_SPECIALS_PRICE . $currencies->display_price($print_catalog['products_id'],$new_price,  tep_get_tax_rate($print_catalog['products_tax_class_id']));
             $products_price = TEXT_PRODUCTS_PRICE . $currencies->display_price($print_catalog['products_id'],$print_catalog['products_price'], tep_get_tax_rate($print_catalog['products_tax_class_id']));
             } else {
                     $products_price = TEXT_PRODUCTS_PRICE . $currencies->display_price($print_catalog['products_id'],$print_catalog['products_price'], tep_get_tax_rate($print_catalog['products_tax_class_id']));
             }
         }
         
          if(SHOW_SPECIALS_PRICE_EXPIRES && $print_catalog['expires_date'] != 0){
              $specials_expires = TEXT_PRODUCTS_SPECIALS_PRICE_EXPIRES .' '. tep_date_long($print_catalog['expires_date']);
              }

         $print_catalog_array = array(
   			                        'id' => $print_catalog['products_id'],
                   			        'name' => $print_catalog['products_name'],
                        			'description' => $print_catalog['products_description'],
                        			'model' => $print_catalog['products_model'],
                        			'image' => $print_catalog[PDF_ALT_IMAGE],
                        			'price' => $products_price,
   			                        'specials_price' => $specials_price,
   			                        'specials_expires' => $specials_expires,
   		                         	'tax_class_id' => $print_catalog['products_tax_class_id'],
   		                         	'status'=> $print_catalog['products_status'],
   		                         	'date_added' => tep_date_long($print_catalog['products_date_added']),
   		                         	'date_available' => tep_date_long($print_catalog['products_date_available']),
                                    'manufacturer' => $print_catalog['manufacturers_name']);
	     }

         $this->AddPage();

					$imagepath=DIR_IMAGE.$print_catalog_array['image'];
				 	$name = rtrim(strip_tags($print_catalog_array['name']));
					$model = rtrim(strip_tags($print_catalog_array['model']));
					$description = $print_catalog_array['description'];
					$manufacturer = rtrim(strip_tags($print_catalog_array['manufacturer']));
					$price = rtrim(strip_tags($print_catalog_array['price']));
					$specials_price = rtrim(strip_tags($print_catalog_array['specials_price']));
					$specials_expires = rtrim(strip_tags($print_catalog_array['specials_expires']));
					$tax_class_id = rtrim(strip_tags($print_catalog_array['tax_class_id']));
                    if (($print_catalog['products_date_available'] > date('Y-m-d H:i:s'))){
			        $date =  TEXT_DATE_AVAILABLE. $print_catalog_array['date_available'];
                    }else{
                    $date = TEXT_DATE_ADDED. $print_catalog_array['date_added'] ;
                    }

					// Check for empty fields
					if ($model == '') $model = "-";
					if ($manufacturer == '') $manufacturer = "-";
					
					$data_array=array($imagewidth,$imageheight,$model,$name,$date,$manufacturer,$description,$tax_class_id,$specials_price,$price,$imagepath,$specials_expires);
					
					$this->DrawCells($data_array);

        $products_options_name = tep_db_query("select distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where
                                               patrib.products_id='" . $products_id . "' and
                                               patrib.options_id = popt.products_options_id and
                                               popt.language_id = '" . $languages_id . "'");

   	    $this->SetTextColor(0,0,0);
        $x=$this->GetX();
	    $y=$this->GetY();
	    $this->SetLineWidth(0.5);
	    $product_name_color_table=explode(",",PRODUCT_NAME_COLOR_TABLE);
	    $this->SetDrawColor(210,210,210);
	    $this->SetDrawColor($product_name_color_table[0], $product_name_color_table[1], $product_name_color_table[2]);
	    $this->Line(40,$y,170,$y);
	    $this->Ln(5);
	    $this->SetDrawColor(0,0,0);

     if(SHOW_OPTIONS)
     {
//		if (OPTIONS_AS_IMAGES_ENABLED) 
		if (OPTIONS_AS_IMAGES_ENABLED == 'true')
		{
                if (tep_db_num_rows($products_options_name)) {
                    $this->MultiCell(0, 8, TEXT_PRODUCTS_OPTIONS . $print_catalog_array['name'] . ' :', 0, 'L', 0);
                    $this->Ln(-5);
                }
                //OAI query
                $products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name, popt.products_options_images_enabled from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$products_id . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_name");

			if (SHOW_OPTIONS_VERTICAL != 0)
			// Option values are displayed horizontaly
			{
                while ($products_options_name_values = tep_db_fetch_array($products_options_name_query)) {
                    $this->Ln(6);
                    $this->SetFont('arialb', 'b', 11);
                    $this->Cell(190, 5, $products_options_name_values['products_options_name'], 0, 0, 'L');
                    $this->Ln();

                    $products_options = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . $products_id . "' and pa.options_id = '" . $products_options_name_values['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . $languages_id . "'" . " order by 0+pov.products_options_values_name");
                    $count_options_values = tep_db_num_rows($products_options);
                    $count_options = 0;
                    $largest_y = $this->GetY();
                    //OAI query
                    $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pov.products_options_values_thumbnail, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$products_id . "' and pa.options_id = '" . (int)$products_options_name_values['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "'");
                    while ($products_options_values = tep_db_fetch_array($products_options_query)) {
                        $w = $this->GetStringWidth($products_options_values['products_options_values_name']) + 2;
                        $this->SetFont('arial', '', 10);
                        $this->SetTextColor(0, 0, 200);
                        $option_string = $products_options_values['products_options_values_name'];
                        $current_x = $this->GetX();
                        if ($products_options_values['options_values_price'] != ' 0.0000' && SHOW_OPTIONS_PRICE == '1') {
                            $count_options++;
                            $add_to = ($count_options_values != $count_options ? ',' : '.');
                            $this->Write(5, $option_string . ' (' . $products_options_values['price_prefix'] . $currencies->display_price($print_catalog['products_id'],$products_options_values['options_values_price'], tep_get_tax_rate($print_catalog['products_tax_class_id'])) . ')' . $add_to);
                        } else {
                            $count_options++;
                            $add_to = ($count_options_values != $count_options ? ',' : '.');
                            $this->Write(5, $option_string . $add_to);
                        }
                        $largest_y = $this->GetY();
                        $next_x = $this->GetX();
                        if ($products_options_name_values['products_options_images_enabled'] == 'true') {
                            $path_to_image = DIR_IMAGE . 'options/' . $products_options_values['products_options_values_thumbnail'];
                            $img_size = GetImageSize($path_to_image);
                            $img_h = ($img_size[1] * PDF_INV_IMG_CORRECTION);
                            $img_w = $img_size[0] * PDF_INV_IMG_CORRECTION;
			    if ($next_x < ($current_x + $img_w)) {
			       $next_x = $current_x + $img_w;
			    }
                            $current_y = $this->GetY();
                            $image_y = ($this->GetY()) + 5;
                            $largest_y = $image_y + $img_h;
                            $this->SetY($image_y);
                            $this->SetX($current_x);
                            $this->ShowImage($img_w, $img_h, $path_to_image); //, false, 0);
                            $this->SetY($current_y);
                            $this->SetX($next_x);
                        }
                        $this->Cell(3, 6, "", 0, 0, 'C');
                        $this->SetTextColor(0, 0, 0);
                                            }
                    $this->SetY($largest_y);
                }
			}
			else 
			{
				// Option values are displayed vertically
                while ($products_options_name_values = tep_db_fetch_array($products_options_name_query)) 
				{
                    $this->Ln(6);
                    $this->SetFont('arialb', 'B', 11);
                    $this->Cell(190, 5, $products_options_name_values['products_options_name'], 0, 0, 'L');
                    $this->Ln();

                    $products_options = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . $products_id . "' and pa.options_id = '" . $products_options_name_values['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . $languages_id . "'" . " order by pov.products_options_values_name");
                    $count_options_values = tep_db_num_rows($products_options);
                    //OAI query
                    $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pov.products_options_values_thumbnail, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$products_id . "' and pa.options_id = '" . (int)$products_options_name_values['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "'");
					// Loop on all option values
                    while ($products_options_values = tep_db_fetch_array($products_options_query)) 
					{							
                        $this->SetFont('arial', '', 9);
						$body_color_text=explode(",",PDF_BODY_COLOR_TEXT);
     					$this->SetTextColor($body_color_text[0], $body_color_text[1], $body_color_text[2]);
                        $option_string = $products_options_values['products_options_values_name'];
                        if ($products_options_values['options_values_price'] != ' 0.0000' && SHOW_OPTIONS_PRICE == '1') 
						{
                            $this->Write(5, $option_string . ' (' . $products_options_values['price_prefix'] . $currencies->display_price($print_catalog['products_id'],$products_options_values['options_values_price'], tep_get_tax_rate($print_catalog['products_tax_class_id'])) . ')' . $add_to);
                        } else {
                            $this->Write(5, $option_string);
                        }
                        if ($products_options_name_values['products_options_images_enabled'] == 'true') 
						{
                            $path_to_image = DIR_IMAGE . 'options/' . $products_options_values['products_options_values_thumbnail'];
                            $img_size = GetImageSize($path_to_image);
                            $img_h = ($img_size[1] * PDF_INV_IMG_CORRECTION);
                            $img_w = $img_size[0] * PDF_INV_IMG_CORRECTION;
							$this->SetX(50);
                            $this->ShowImage($img_w, $img_h, $path_to_image); //, false, 0);
                            $this->SetX(0);
                        } 
                        $this->Ln();
                        $this->SetTextColor(0, 0, 0);
                    } // end loop on options values
                } // end loop on options

			}
        }
        else {

        if (tep_db_num_rows($products_options_name)) {

        $this->MultiCell(0,8,TEXT_PRODUCTS_OPTIONS . $print_catalog_array['name'] .' :',0,'L',0);
        $this->Ln(-5);
        }
        while ($products_options_name_values = tep_db_fetch_array($products_options_name)) {
        $products_options_array = array();
        $products_options_name_values['products_options_name'];
        $this->Ln(6);
        $this->SetFont('arialb','b',11);
        $this->Cell(190,5,$products_options_name_values['products_options_name'],0,0,'L');
        $this->Ln();

        $products_options = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . $products_id . "' and pa.options_id = '" . $products_options_name_values['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . $languages_id . "'" . " order by 0+pov.products_options_values_name");
        $count_options_values = tep_db_num_rows($products_options);
   		$count_options = 0;

        while ($products_options_values = tep_db_fetch_array($products_options)) {
          $products_options_array[] = array('id' => $products_options_values['products_options_values_id'], 'text' => $products_options_values['products_options_values_name'],  'price_id' => $products_options_values['products_options_values_id'],   'text2' => $products_options_values['options_values_price']);

        $w=$this->GetStringWidth($products_options_values['products_options_values_name'])+2;
        $this->SetFont('arial','',10);
        $this->SetTextColor(0,0,200);
        $option_string = $products_options_values['products_options_values_name'] . $option_value;
          if ( $products_options_values['options_values_price'] != ' 0.0000' && SHOW_OPTIONS_PRICE == '1') {
         $count_options++; $add_to = ($count_options_values != $count_options ? ',' : '.' );
         $this->Write(5,$products_options_values['products_options_values_name']. ' (' . $products_options_values['price_prefix'] . $currencies->display_price($print_catalog['products_id'],$products_options_values['options_values_price'], tep_get_tax_rate($print_catalog['products_tax_class_id'])) . ')' . $add_to);
          } else {
         $count_options++; $add_to = ($count_options_values != $count_options ? ',' : '.' );
         $this->Write(5,$products_options_values['products_options_values_name'] . $add_to);
          }
        $this->Cell(3,6,"",0,0,'C');
        $this->SetTextColor(0,0,0);

         }
		}        
		}
       }
        	 if(SHOW_DATE_ADDED_AVAILABLE)
	            {
                 //Date available
	             $x=$this->GetX();
	             $y=$this->GetY();
                 $this->Ln(10);
                 $this->SetFont('ariali','I',9);
                 $new_color_table=explode(",",PDF_HEADER_COLOR_TABLE);
                 $this->SetFillColor($new_color_table[0], $new_color_table[1], $new_color_table[2]);
                 $this->MultiCell(0,5,$data_array[4],0,'L',1);
               }
	 }

 function Background()
 {
    $bg_color=explode(",",PDF_PAGE_BG_COLOR);
    $this->SetFillColor($bg_color[0], $bg_color[1], $bg_color[2]);
    $this->Rect($this->lMargin,0,$this->w-$this->rMargin,$this->h,'F');
 }

 function Watermark()
 {
    $this->SetFont('arialb','B',80);                                                      //font face , empty string: regular - B: bold - I: italic - U: underline , size
    $watermark_color=explode(",",PAGE_WATERMARK_COLOR);
    $this->SetTextColor($watermark_color[0], $watermark_color[1], $watermark_color[2]);
    $ang=30;                                                                             //rotation angle
    $cos=cos(deg2rad($ang));
    $wwm=($this->GetStringWidth(STORE_NAME)*$cos);
    $this->RotatedText(($this->w-$wwm)/2,$this->w,STORE_NAME,$ang);                           //position : in this case horizontal center & 210 from top
 }
}

function WriteDocument($pdf,$docfilename){
// Variable $docfilename kommt aus function ProductsDataSheet(), dann aus function GenerateFilename()

	//Save PDF to file
	$pdf->Output(PDF_DOC_PATH . $docfilename);
}

function GenerateFilename($docfilename){
// Variable $docfilename kommt aus function ProductsDataSheet
global $languages_id;
//$find = array('/ä/','/ö/','/ü/','/ß/','/Ä/','/Ö/','/Ü/','/ /','/:/','/;/');
$find = array('/ä/','/ö/','/ü/','/ß/','/Ä/','/Ö/','/Ü/','/ /','/[:;]/','/\//');
$replace = array('ae','oe','ue','ss','Ae','Oe','Ue','_','','-');
return preg_replace ($find , $replace, strtolower($docfilename) . '_l' . $languages_id . '.pdf'); 
}	

function StartDownload($filename){

$filename = realpath($filename); //server specific 
$file_extension = strtolower(substr(strrchr($filename,"."),1)); 

if (! file_exists( $filename ) ) 
{ 
	die("NO FILE HERE"); 
}

switch( $file_extension ) 
{ 
	case "pdf": $ctype="application/pdf"; break; 
	case "exe": $ctype="application/octet-stream"; break; 
	case "zip": $ctype="application/zip"; break; 
	case "doc": $ctype="application/msword"; break; 
	case "xls": $ctype="application/vnd.ms-excel"; break; 
	case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
	case "gif": $ctype="image/gif"; break; 
	case "png": $ctype="image/png"; break; 
	case "jpe": case "jpeg": 
	case "jpg": $ctype="image/jpg"; break; 
	default: $ctype="application/force-download"; 
} 
header("Pragma: public"); // required 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=1, pre-check=0"); 
header("Cache-Control: private",false); // required for certain browsers 
header("Content-Type: $ctype"); 
header("Content-Disposition: attachment; filename=".basename($filename).";" ); 
header("Content-Transfer-Encoding: binary"); 
header("Content-Length: ".@filesize($filename)); 
@readfile("$filename") or die("File not found."); 
exit(); 
}

	$products_name_query = tep_db_query("SELECT products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where  products_id = '" . $products_id . "' and  language_id = '" . $languages_id . "'");

	$checkfilename = tep_db_fetch_array($products_name_query);
	$docfilename = GenerateFilename($checkfilename['products_name']);
	//If the File has been generated before, break up here and immediatly start the download or the redirect
	if (file_exists(PDF_DOC_PATH . $docfilename) ) {
		if (PDF_FILE_REDIRECT){
			header('Location: ' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . PDF_DOC_PATH . $docfilename );
			exit();
		} else {
			StartDownload(PDF_DOC_PATH . $docfilename);
		}
	}
//old JavaScript redirection
//	echo "<HTML><script>document.location='pdfdocs/$docfilename';</SCRIPT></HTML>";
//	echo "<HTML><script>document.location='$file';</SCRIPT></HTML>";
			
	$pdf=new PDF();
	$pdf->AddFont('arial', '', 'arial.php');
	$pdf->AddFont('arialb', 'B', 'arialbd.php');
	$pdf->AddFont('ariali', 'I', 'ariali.php');
	$pdf->Open();
	$pdf->SetMargins( 20, 20, 20 );
	$pdf->SetAutoPageBreak = false;//otherwise the pagebreak will not be calculated correctly, but automaticly (sometimes wrong) set.
	$pdf->SetDisplayMode("real");
	$pdf->AliasNbPages();
	$pdf->ProductsDataSheet($languages_id, $products_id);
	
	If(!PDF_SAVE_DOCUMENT){
		if (!PDF_FILE_REDIRECT){
			$pdf->Output($docfilename,"D");
		}else{
			$pdf->Output($docfilename,'I');
		}
	} else {
		//Write Document to defined PDF_DOC_PATH
		WriteDocument($pdf,$docfilename);
		//start the download or the redirect
		if (PDF_FILE_REDIRECT){
			header('Location: ' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . PDF_DOC_PATH . $docfilename );
			exit();
		} else {
			StartDownload(PDF_DOC_PATH . $docfilename);
		}
	}
	exit;
?>