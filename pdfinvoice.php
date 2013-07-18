<?php
/*
  $Id: create_customer_pdf,v 1.1 2007/07/25 clefty (osc forum id chris23)

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
  
  Based on create_pdf , originally written by Neil Westlake (nwestlake@gmail.com
  
  Rewritten to display a PDF invoice for the customer to print / download within account_history_info.php
  
  Changelog v1.1
  --------------
  i)   Added invoice date config choice - today or same as order date - date now follows locale format set in /includes/languages/your-lang/your-lang.php
  ii)  Decode html entities for all invoice text (better multilinual support)
  iii) Remove hardcoded address format. Now uses $order->customer['format_id']
  iv)  Config option to only display pdf link for delivered orders.
  v)   Remove all hardcoded English language
  vi)  Support for vector store logo  - ai / eps formats
  vii) Added customer reference.
  
*/

 	define('FPDF_FONTPATH','pdf/font/');
	require('pdf/fpdf/ufpdf.php');
 	require('includes/application_top.php');
 
  // see if admin passthru is set and valid
 	$admin_access = false;
 	$pass_phrase="awsxdrfvgyhnjikmloqw";
 	$pass_phrase_hash=md5($pass_phrase);
 	if(isset($HTTP_GET_VARS['passthruID'])){
    if($HTTP_GET_VARS['passthruID'] === $pass_phrase_hash){
        $admin_access = true;
        }
  }

 	// perform security check to prevent "get" tampering to view other customer's invoices

  if(!$admin_access){

		if (!tep_session_is_registered('customer_id')) {
  	  $navigation->set_snapshot();
    	tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  	}

  	if (!isset($HTTP_GET_VARS['order_id']) || (isset($HTTP_GET_VARS['order_id']) && !is_numeric($HTTP_GET_VARS['order_id']))) {
    	tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
  	}
  
  	$customer_info_query = tep_db_query("select customers_id from " . TABLE_ORDERS . " where orders_id = '". (int)$HTTP_GET_VARS['order_id'] . "'");
  	$customer_info = tep_db_fetch_array($customer_info_query);
  	if ($customer_info['customers_id'] != $customer_id) {
    	tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
  	}
 
 	}
 
 	require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CUSTOMER_PDF);
 
 	// function to return rgb value for fpdf from supplied hex (#abcdef)
 
 	function html2rgb($color){
  	if ($color[0] == '#')
    	$color = substr($color, 1);

    	if (strlen($color) == 6)
      	list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
    	elseif (strlen($color) == 3)
      	list($r, $g, $b) = array($color[0], $color[1], $color[2]);
    	else
      	return false;

    	$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
    
    	return array($r,$g,$b);
	}
   
  // function to decode html entities
  function tep_html_entity_decode($text, $quote_style = ENT_QUOTES){
  	return html_entity_decode($text, $quote_style);
  }
        
  // find image type
  function findextension ($filename) {
  	$filename = strtolower($filename);
    $extension= split("\.", $filename);
    $n = count($extension)-1;
    $extension = $extension[$n];
    return $extension;
  }

  $border_color = html2rgb('#333333');
  $cell_color = html2rgb('#f3f3f3');
  $invoice_line = html2rgb('#808080');
  $highlight_color = explode(",",PDF_HEADER_COLOR_TEXT);;
  $standard_color = explode(",",PDF_BODY_COLOR_TEXT);;
//  $watermark_color = html2rgb(PDF_INV_WATERMARK_COLOR);
    
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_HISTORY_INFO);

  require(DIR_WS_CLASSES . 'order.php');
  $order = new order($HTTP_GET_VARS['order_id']);
  
  // set invoice date - today or day ordered. set in config
  $date = (PDF_INV_DATE_TODAY == 'today') ? strftime(DATE_FORMAT_LONG) : tep_date_long($order->info['date_purchased']);

	class PDF extends UFPDF {

	//Page header
 	function RoundedRect($x, $y, $w, $h,$r, $style = '') {
  	$k = $this->k;
    $hp = $this->h;
    if($style=='F')
    	$op='f';
    elseif($style=='FD' or $style=='DF')
    	$op='B';
    else
    	$op='S';
      $MyArc = 4/3 * (sqrt(2) - 1);
      $this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));
      $xc = $x+$w-$r ;
      $yc = $y+$r;
      $this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));

      $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
      $xc = $x+$w-$r ;
      $yc = $y+$h-$r;
      $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
      $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
      $xc = $x+$r ;
      $yc = $y+$h-$r;
      $this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
      $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
      $xc = $x+$r ;
      $yc = $y+$r;
      $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
      $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
      $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
    	$h = $this->h;
      $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }
	
    function Header() {
    	global $HTTP_GET_VARS, $highlight_color, $date, $image_function, $customer_id;

			//Logo
			if(PDF_SHOW_LOGO != 'false' ) {
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
		
		$this->$image_function(PDF_STORE_LOGO,7,10,($size[0]*PDF_INV_IMG_CORRECTION),($size[1]*PDF_INV_IMG_CORRECTION), $imagetype);
		// EOF Mod for correct imagesize & type

				
//				$size =getimagesize(PDF_STORE_LOGO);
//    		$this->$image_function(PDF_STORE_LOGO,7,10,($size[0]*PDF_INV_IMG_CORRECTION),($size[1]*PDF_INV_IMG_CORRECTION),'', FILENAME_DEFAULT);
			} else {
    		//Store Name

				$this->SetY(10);
				$this->SetFont(PDF_INV_CORE_FONT,'B',14);
				$this->SetTextColor($highlight_color[0],$highlight_color[1],$highlight_color[2]);
    		$this->Ln(0);
				$this->Cell(1);
				$this->MultiCell(90, 5,STORE_NAME,0,'L');

			}
    	// Company name
			$this->SetX(0);
			$this->SetY(10);
    	$this->SetFont(PDF_INV_CORE_FONT,'B',11);
			$this->SetTextColor($highlight_color[0],$highlight_color[1],$highlight_color[2]);
    	$this->Ln(0);
    	$this->Cell(91);
			$this->MultiCell(100, 5, tep_html_entity_decode(STORE_NAME),0,'R');
    
			// Company Address
			$stopka = STORE_NAME_ADDRESS;
			$stopka = str_replace("\r", ' ', $stopka);
  		$stopka = str_replace("\n", ' ', $stopka);

			$this->SetX(0);
			$this->SetY(25);
    	$this->SetFont(PDF_INV_CORE_FONT,'B',10);
			$this->SetTextColor($highlight_color[0],$highlight_color[1],$highlight_color[2]);
    	$this->Ln(0);
    	$this->Cell(91);
			$this->MultiCell(100, 3.5, tep_html_entity_decode($stopka),0,'R');
	
    	// Invoice Number, customer reference and date
			$this->SetX(0);
			$this->SetFont(PDF_INV_CORE_FONT,'B',10);
			$this->SetTextColor($highlight_color[0],$highlight_color[1],$highlight_color[2]);
			$this->SetY(36);
			$this->Cell(91,6, tep_html_entity_decode(PRINT_INVOICE_TITLE) . (int)$HTTP_GET_VARS['order_id'],0,'L');
    	$this->Ln(6);
    	$this->Cell(91,6, $date ,0,'L');
    
			//Email
			$this->SetX(0);
			$this->SetY(36);
			$this->SetFont(PDF_INV_CORE_FONT,'B',10);
			$this->SetTextColor($highlight_color[0],$highlight_color[1],$highlight_color[2]);
    	$this->Cell(91);
			$this->MultiCell(100, 6, tep_html_entity_decode(PDF_INV_EMAIL) . STORE_OWNER_EMAIL_ADDRESS,0,'R');
	
			//Website
			$this->SetX(0);
			$this->SetY(36);
			$this->SetFont(PDF_INV_CORE_FONT,'B',10);
			$this->SetTextColor($highlight_color[0],$highlight_color[1],$highlight_color[2]);
    	$this->Ln(6);
    	$this->Cell(91);
			$this->MultiCell(100, 6, tep_html_entity_decode(PDF_INV_WEB) . HTTP_SERVER,0,'R');
    
    	// VAT / Tax number (if enabled)
    	//if (DISPLAY_PDF_TAX_NUMBER == 'true'){
    	//	$this->SetX(0);
			//	$this->SetY(53);
			//	$this->SetFont(PDF_INV_CORE_FONT,'B',10);
			//	$this->SetTextColor($highlight_color[0],$highlight_color[1],$highlight_color[2]);
			//	$this->Ln(0);
    	//	$this->Cell(88);
			//	$this->MultiCell(100, 6, tep_html_entity_decode(PDF_TAX_NAME) . " " . PDF_TAX_NUMBER,0,'R');
   		//}
		}

		// function taken and modified from $Id: pdfinvoice.php 160 2008-03-07 11:36:54Z kamelianet $

  	function RotatedText($x,$y,$txt,$angle) {
    	//Text rotated around its origin
    	$this->Rotate($angle,$x,$y);
    	$this->Text($x,$y,$txt);
    	$this->Rotate(0);
 		}

 
 		function Watermark() {
    	global $watermark_color;
    	$this->SetFont(PDF_INV_CORE_FONT,'B',60);
      $watermark_color=explode(",",PAGE_WATERMARK_COLOR);
    	$this->SetTextColor($watermark_color[0], $watermark_color[1], $watermark_color[2]);
    	$ang=30;
    	$cos=cos(deg2rad($ang));
    	$wwm=($this->GetStringWidth(substr(tep_html_entity_decode(STORE_NAME),0,15))*$cos);
    	$this->RotatedText(($this->w-$wwm)/2,$this->w,STORE_NAME,$ang);
 		}

		function Footer() {
    	global $highlight_color, $invoice_line;

			$stopka = STORE_NAME_ADDRESS;
			$stopka = str_replace("\r", ' ', $stopka);
  		$stopka = str_replace("\n", ' ', $stopka);
				
    	// insert horiz line
    	$this->SetY(-19);
    	$this->SetDrawColor($invoice_line[0],$invoice_line[1],$invoice_line[2]);
    	$this->Cell(198,.1,'',1,1,'L',1);
    
    	//Position at 1.5 cm from bottom
    	$this->SetY(-17);
    	$this->SetFont(PDF_INV_CORE_FONT,'',8);
			$this->SetTextColor($highlight_color[0],$highlight_color[1],$highlight_color[2]);
			$this->Cell(0,10,tep_html_entity_decode($stopka),0,0,'C');
		}



    //Cell with horizontal scaling if text is too wide
    function CellFit($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='',$scale=0,$force=1)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $ratio=($w-$this->cMargin*2)/$str_width;

        $fit=($ratio < 1 || ($ratio > 1 && $force == 1));
        if ($fit)
        {
            switch ($scale)
            {

                //Character spacing
                case 0:
                    //Calculate character spacing in points
                    $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                    //Set character spacing
                    $this->_out(sprintf('BT %.2f Tc ET',$char_space));
                    break;

                //Horizontal scaling
                case 1:
                    //Calculate horizontal scaling
                    $horiz_scale=$ratio*100.0;
                    //Set horizontal scaling
                    $this->_out(sprintf('BT %.2f Tz ET',$horiz_scale));
                    break;

            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale==0 ? '0 Tc' : '100 Tz').' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,1,0);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,1,1);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,0,0);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='')
    {
        //Same as calling CellFit directly
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,0,1);
    }

    //Patch to also work with CJK double-byte text
    function MBGetStringLength($s)
    {
        if($this->CurrentFont['type']=='Type0')
        {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++)
            {
                if (ord($s[$i])<128)
                    $len++;
                else
                {
                    $len++;
                    $i++;
                }
            }
            return $len;
        }
        else
            return strlen($s);
    }


	}

	/***************************
	* Software: FPDF_EPS
	* Version:  1.3
	* Date:     2006-07-28
	* Author:   Valentin Schmidt
	****************************/
	class PDF_EPS extends PDF {

		function PDF_EPS($orientation='P',$unit='mm',$format='A4'){
		parent::FPDF($orientation,$unit,$format);
	}

	function ImageEps ($file, $x, $y, $w=0, $h=0, $link='', $useBoundingBox=true){
		$data = file_get_contents($file);
		if ($data===false) $this->Error('EPS file not found: '.$file);

		# strip binary bytes in front of PS-header
		$start = strpos($data, '%!PS-Adobe');
		if ($start>0) $data = substr($data, $start);

		# find BoundingBox params
		ereg ("%%BoundingBox:([^\r\n]+)", $data, $regs);
		if (count($regs)>1){
			list($x1,$y1,$x2,$y2) = explode(' ', trim($regs[1]));
		}
		else $this->Error('No BoundingBox found in EPS file: '.$file);

		$start = strpos($data, '%%EndSetup');
		if ($start===false) $start = strpos($data, '%%EndProlog');
		if ($start===false) $start = strpos($data, '%%BoundingBox');

		$data = substr($data, $start);

		$end = strpos($data, '%%PageTrailer');
		if ($end===false) $end = strpos($data, 'showpage');
		if ($end) $data = substr($data, 0, $end);

		# save the current graphic state
		$this->_out('q');

		$k = $this->k;

		if ($useBoundingBox){
			$dx = $x*$k-$x1;
			$dy = $y*$k-$y1;
		}else{
			$dx = $x*$k;
			$dy = $y*$k;
		}
	
		# translate
		$this->_out(sprintf('%.3f %.3f %.3f %.3f %.3f %.3f cm', 1,0,0,1,$dx,$dy+($this->hPt - 2*$y*$k - ($y2-$y1))));
	
		if ($w>0){
			$scale_x = $w/(($x2-$x1)/$k);
			if ($h>0){
				$scale_y = $h/(($y2-$y1)/$k);
			}else{
				$scale_y = $scale_x;
				$h = ($y2-$y1)/$k * $scale_y;
			}
		}else{
			if ($h>0){
				$scale_y = $h/(($y2-$y1)/$k);
				$scale_x = $scale_y;
				$w = ($x2-$x1)/$k * $scale_x;
			}else{
				$w = ($x2-$x1)/$k;
				$h = ($y2-$y1)/$k;
			}
		}
	
		# scale
		if (isset($scale_x))
		$this->_out(sprintf('%.3f %.3f %.3f %.3f %.3f %.3f cm', $scale_x,0,0,$scale_y, $x1*(1-$scale_x), $y2*(1-$scale_y)));
	
		# handle pc/unix/mac line endings
		$lines = split ("\r\n|[\r\n]", $data);

		$u=0;
		$cnt = count($lines);
		for ($i=0;$i<$cnt;$i++){
			$line = $lines[$i];
			if ($line=='' || $line{0}=='%') continue;
			$len = strlen($line);
			if ($len>2 && $line{$len-2}!=' ') continue;
			$cmd = $line{$len-1};

			switch ($cmd){
				case 'm':
				case 'l':
				case 'v':
				case 'y':
				case 'c':
				case 'k':
				case 'K':
				case 'g':
				case 'G':
      	case 's':
				case 'S':
  			case 'J':
				case 'j':
				case 'w':
				case 'M':
				case 'd' :
			  case 'n' :
				case 'v' :
					$this->_out($line);
					break;
										
				case 'x': # custom colors
					list($c,$m,$y,$k) = explode(' ', $line);
					$this->_out("$c $m $y $k k");
					break;
				
				case 'Y':
					$line{$len-1}='y';
					$this->_out($line);
					break;

				case 'N':
					$line{$len-1}='n';
					$this->_out($line);
					break;
		
				case 'V':
					$line{$len-1}='v';
					$this->_out($line);
					break;
												
				case 'L':
					$line{$len-1}='l';
					$this->_out($line);
					break;

				case 'C':
					$line{$len-1}='c';
					$this->_out($line);
					break;

				case 'b':
				case 'B':
					$this->_out($cmd . '*');
					break;

				case 'f':
				case 'F':
					if ($u>0){
						$isU = false;
						$max = min($i+5,$cnt);
						for ($j=$i+1;$j<$max;$j++)
							$isU = ($isU || ($lines[$j]=='U' || $lines[$j]=='*U'));
							if ($isU) $this->_out("f*");
							}else
							$this->_out("f*");
					break;

				case 'u':
					if ($line{0}=='*') $u++;
					break;

				case 'U':
					if ($line{0}=='*') $u--;
					break;
			
				#default: echo "$cmd<br>"; #just for debugging
			}
    }

		# restore previous graphic state
		$this->_out('Q');
		if ($link)
			$this->Link($x,$y,$w,$h,$link);
		}

	} # END CLASS

	# for backward compatibility
	if (!function_exists('file_get_contents')){
		function file_get_contents($filename, $use_include_path = 0){
			$file = @fopen($filename, 'rb', $use_include_path);
			if ($file){
				if ($fsize = @filesize($filename))
				$data = fread($file, $fsize);
				else {
				$data = '';
				while (!feof($file)) $data .= fread($file, 1024);
				}
				fclose($file);
				return $data;
			}else
			return false;
		}
	}

	// Instanciation of inherited class - choose according to logo supplied, vector or raster
	if(findextension(PDF_STORE_LOGO) == 'ai' || findextension(PDF_STORE_LOGO) == 'eps'){
  	$pdf=new PDF_EPS();
    $image_function = "ImageEps";
  } else {
    $pdf=new PDF();
    $image_function = "Image";
  }

	$pdf->AddFont(PDF_INV_CORE_FONT, '', 'arial.php');
	$pdf->AddFont(PDF_INV_CORE_FONT, 'B', 'arialbd.php');
	$pdf->AddFont(PDF_INV_CORE_FONT, 'I', 'ariali.php');

	// Set the Page Margins
	$pdf->SetMargins(6,2,6);

	$pdf->SetDisplayMode("real");

	// Add the first page
	$pdf->AddPage();

  // add watermark if required
  if(PDF_SHOW_WATERMARK == 'true'){
 	$pdf->Watermark();
  }

	//Draw the top line with invoice text
	$pdf->SetX(0);
	$pdf->SetY(60);
	$pdf->SetDrawColor($invoice_line[0],$invoice_line[1],$invoice_line[2]);
	$pdf->Cell(15,.1,'',1,1,'L',1);
	$pdf->SetFont(PDF_INV_CORE_FONT,'BI',15);
	$pdf->SetTextColor($invoice_line[0],$invoice_line[1],$invoice_line[2]);
	$pdf->Text(22,61.5,tep_html_entity_decode(PRINT_INVOICE_HEADING));
	$pdf->SetY(60);
	$pdf->SetDrawColor($invoice_line[0],$invoice_line[1],$invoice_line[2]);
	$pdf->Cell(66);
	$pdf->Cell(126,.1,'',1,1,'L',1);

	//Draw Box for Invoice Address
	$pdf->SetDrawColor($border_color[0],$border_color[1],$border_color[2]);
	$pdf->SetLineWidth(0.2);
	$pdf->SetFillColor($cell_color[0],$cell_color[1],$cell_color[2]);
	$pdf->RoundedRect(6, 67, 90, 35, 2, 'DF');

	//Draw the invoice address text
  $pdf->SetFont(PDF_INV_CORE_FONT,'B',10);
	$pdf->SetTextColor($standard_color[0],$standard_color[1],$standard_color[2]);
	$pdf->Text(11,72, tep_html_entity_decode(ENTRY_SOLD_TO));
	$pdf->SetX(0);
	$pdf->SetY(75);
  $pdf->Cell(9);
	$pdf->MultiCell(70, 3.8, tep_html_entity_decode(tep_address_format($order->customer['format_id'], $order->customer, '', '', "\n")),0,'L');
	
	//Draw Box for Delivery Address
	$pdf->SetDrawColor($border_color[0],$border_color[1],$border_color[2]);
	$pdf->SetLineWidth(0.2);
	$pdf->SetFillColor(255);
	$pdf->RoundedRect(108, 67, 90, 35, 2, 'DF');
	
	//Draw the invoice delivery address text
  $pdf->SetFont(PDF_INV_CORE_FONT,'B',10);
	$pdf->SetTextColor($standard_color[0],$standard_color[1],$standard_color[2]);
	$pdf->Text(113,72,tep_html_entity_decode(ENTRY_SHIP_TO));
	$pdf->SetX(0);
	$pdf->SetY(75);
  $pdf->Cell(111);
	$pdf->MultiCell(70, 3.8, tep_html_entity_decode(tep_address_format($order->delivery['format_id'], $order->delivery, '', '', "\n")),0,'L');
    
	//Draw Box for Order Number, Date & Payment method
	$pdf->SetDrawColor($border_color[0],$border_color[1],$border_color[2]);
	$pdf->SetLineWidth(0.2);
	$pdf->SetFillColor($cell_color[0],$cell_color[1],$cell_color[2]);
	$pdf->RoundedRect(6, 107, 192, 18, 2, 'DF');

	//Draw Order Number Text
	$pdf->Text(10,113, tep_html_entity_decode(PRINT_INVOICE_ORDERNR) . (int)$HTTP_GET_VARS['order_id']);	

	//Draw Date of Order Text
	$pdf->Text(10,117, tep_html_entity_decode(PRINT_INVOICE_DATE) . tep_date_short($order->info['date_purchased']));
	//Draw Payment Method Text
	$temp = $order->info['payment_method'];
	$pdf->Text(10,121, tep_html_entity_decode(ENTRY_PAYMENT_METHOD) . ' ' . tep_html_entity_decode($temp));
  // Draw customer reference
  //$pdf->Text(10,117, tep_html_entity_decode(PDF_INV_CUSTOMER_REF) . (int)$customer_id);
    

	//Fields Name position
	$Y_Fields_Name_position = 129;

	//Table position, under Fields Name
	$Y_Table_Position = 135;


	function output_table_heading($Y_Fields_Name_position){
  	global  $pdf, $cell_color;
		//First create each Field Name
		// Config color filling each Field Name box
		$pdf->SetFillColor($cell_color[0],$cell_color[1],$cell_color[2]);

		//Bold Font for Field Name
		$pdf->SetFont(PDF_INV_CORE_FONT,'B',9);
		$pdf->SetY($Y_Fields_Name_position);
		$pdf->SetX(6);
		$pdf->Cell(9,6,tep_html_entity_decode(PDF_INV_QTY_CELL),1,0,'C',1);
		$pdf->SetX(15);
		$pdf->Cell(18,6,tep_html_entity_decode(TABLE_HEADING_PRODUCTS_MODEL),1,0,'C',1);
		$pdf->SetX(33);
		$pdf->Cell(75,6,tep_html_entity_decode(TABLE_HEADING_PRODUCTS),1,0,'C',1);
		$pdf->SetX(108);
		$pdf->Cell(20,6,tep_html_entity_decode(TABLE_HEADING_PRICE_EXCLUDING_TAX),1,0,'C',1);
		$pdf->SetX(128);
		$pdf->Cell(20,6,tep_html_entity_decode(TABLE_HEADING_PRICE_INCLUDING_TAX),1,0,'C',1);
		$pdf->SetX(148);
		$pdf->Cell(25,6,tep_html_entity_decode(TABLE_HEADING_TOTAL_EXCLUDING_TAX),1,0,'C',1);
		$pdf->SetX(173);
		$pdf->Cell(25,6,tep_html_entity_decode(TABLE_HEADING_TOTAL_INCLUDING_TAX),1,0,'C',1);
		$pdf->Ln();
	}

	output_table_heading($Y_Fields_Name_position);
	//Show the products information line by line
	for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
		$pdf->SetFont(PDF_INV_CORE_FONT,'',9);
		$pdf->SetY($Y_Table_Position);
		$pdf->SetX(6);
		$pdf->MultiCell(9,5,$order->products[$i]['qty'],'T','C');
		$pdf->SetY($Y_Table_Position);
    
    $prod_attribs='';
    //get attribs and concat
    if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
    	for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
      	$atrybut = $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];
				if ( strlen($atrybut) > 50 ) {
					$atrybut = osc_trunc_string($atrybut, 50, 1);
      	}
				$prod_attribs .= "\n" . " - " .$atrybut;
      }
    }
    
	  $pdf->SetFont(PDF_INV_CORE_FONT,'',9);
	  $pdf->SetY($Y_Table_Position);
	  $pdf->SetX(15);
    $pdf->SetFont(PDF_INV_CORE_FONT,'',9);
	  $pdf->MultiCell(18,5,tep_html_entity_decode($order->products[$i]['model']),'T','C');
	  $pdf->SetY($Y_Table_Position);
	  $pdf->SetX(108);
    $pdf->SetFont(PDF_INV_CORE_FONT,'',9);
	  $pdf->MultiCell(20,5,$currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']),'T','R');
	  $pdf->SetY($Y_Table_Position);
	  $pdf->SetX(128);
	  $pdf->MultiCell(20,5,$currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']),'T','R');
	  $pdf->SetY($Y_Table_Position);
	  $pdf->SetX(148);
	  $pdf->MultiCell(25,5,$currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']),'T','R');
	  $pdf->SetY($Y_Table_Position);
	  $pdf->SetX(173);
	  $pdf->MultiCell(25,5,$currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']),'T','R');

	  $pdf->SetY($Y_Table_Position);
		$pdf->SetX(33);
		$product_name_attrib_contact = osc_trunc_string($order->products[$i]['name'], 50, 1) . $prod_attribs;
    $pdf->SetFont(PDF_INV_CORE_FONT,'',9);
		$pdf->MultiCell(75,5,tep_html_entity_decode($product_name_attrib_contact),'T','L');

		$Y = $pdf->GetY();
        
//	  $Y_Table_Position += $Y;
	  $Y_Table_Position = $Y;

    //Check for product line overflow
    $item_count++;
    if ((is_long($item_count / 32) && $i >= 20) || ($i == 20)){
    	$pdf->AddPage();
      //Fields Name position
      $Y_Fields_Name_position = 125;
      //Table position, under Fields Name
      $Y_Table_Position = 70;
      output_table_heading($Y_Table_Position-6);
      if ($i == 20) $item_count = 1;
    }
	}
  
	$pdf->Ln(2);
  $pdf->SetDrawColor($invoice_line[0],$invoice_line[1],$invoice_line[2]);
  $pdf->Cell(192,.1,'',1,1,'L',1);

	
	for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
		$pdf->SetY($Y_Table_Position + 6);
		$pdf->SetX(6);
		$temp = substr ($order->totals[$i]['text'],0 ,3);
		if ($temp == '<b>') {
			$pdf->SetFont(PDF_INV_CORE_FONT,'B',10);
			$temp2 = substr($order->totals[$i]['text'], 3);
			$order->totals[$i]['text'] = substr($temp2, 0, strlen($temp2)-4);
		}

		$pdf->CellFitScale(164,6,$order->totals[$i]['title'],0,0,'R',0);
	  $pdf->SetY($Y_Table_Position + 6);
    $pdf->SetX(170);
		$pdf->MultiCell(28,6,$order->totals[$i]['text'],0,'R');
		$Y_Table_Position += 6;
	}

  // set PDF metadata
  $pdf->SetTitle(PDF_META_TITLE);
  $pdf->SetSubject(PDF_META_SUBJECT . $HTTP_GET_VARS['order_id']);
  $pdf->SetAuthor(STORE_OWNER);
     
  // PDF created

  function safe_filename ($filename) {
  	$search = array(
    '/ß/',
    '/ä/','/Ä/',
    '/ö/','/Ö/',
    '/ü/','/Ü/',
    '([^[:alnum:]._])' 
    );
    $replace = array(
    'ss',
    'ae','Ae',
    'oe','Oe',
    'ue','Ue',
    '_'
    );
    
    // return a safe filename, lowercased and suffixed with invoice number.
    
    return strtolower(preg_replace($search,$replace,$filename));
	}

	$file_name = safe_filename(STORE_NAME);
  $file_name .= "_invoice_" . $HTTP_GET_VARS['order_id'] . ".pdf";
  $mode = (PDF_FILE_REDIRECT == '0') ? 'D' : 'I';

	// what do we do? display inline or force download
	$pdf->Output($file_name , $mode);
?>