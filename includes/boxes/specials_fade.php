<?php
/*
  /////////////////////////////////////////////////////////////////////////
  FADE-IN dla SPECIAL.PHP
  zastosowanie funkcji new fadeshow(nazwa tablicy, szerokosc, wysokosc, borderwidth, delay, pause (0=no, 1=yes), optionalRandomOrder)
  dopasowanie do oscCommerce - Mlody - (C) Copyright !!!!
  
  trzeba zdefiniowac:
  fadebgcolor - kolor tla obrazka
  tlocolor - kolor tla napisow
  ewentualnie w funkcji fadeshow paramtery j.w.
  /////////////////////////////////////////////////////////////////////////
  
*/
$query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;

$boxHeading = BOX_HEADING_SPECIALS;
$corner_left = 'rounded';
$corner_right = 'rounded';
$boxContent_attributes = ' align="center"';
$szerokosc = SMALL_IMAGE_WIDTH+10;
$wysokosc = SMALL_IMAGE_HEIGHT+10;

$box_base_name = 'specials'; // for easy unique box template setup (added BTSv1.2)
$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)
$boxLink = '<a class="boxLink" href="' . tep_href_link(FILENAME_SPECIALS) . '">' .tep_image(DIR_WS_TEMPLATES . 'images/infobox/arrow_right.gif') .'</a>';

if (!isset($customer_id)) $customer_id = 0;
	$customer_group = tep_get_customers_groups_id();
    $rp_query = tep_db_query("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c  where c.categories_status='1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p.products_status = '1' and p.products_id = s.products_id and pd.products_id = s.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' and ((s.customers_id = '" . $customer_id . "' and s.customers_groups_id = '0') or (s.customers_id = '0' and s.customers_groups_id = '" . $customer_group . "') or (s.customers_id = '0' and s.customers_groups_id = '0')) order by RAND() ");
    if (tep_db_num_rows($rp_query)) {

      $i = 0;
      while ($random_product = tep_db_fetch_array($rp_query)) {

	      $random_product['products_price'] = tep_xppp_getproductprice($random_product['products_id']);
          $random_product['specials_new_products_price'] = tep_get_products_special_price($random_product['products_id']);
          $query_special_prices_hide_result = SPECIAL_PRICES_HIDE;

		  if ($random_product['products_image'] != ''){
                $pausecontent[$i] .=  DIR_WS_IMAGES . $random_product['products_image'];
				$obraz = getimagesize($pausecontent[$i]);      //tworzy tablice z rozmiarami obrazka

				$szei = $szerokosc / $obraz[0];       //oblicza wspolczynnik szerokosci okna do szerokosci obrazka
				$wysi = $wysokosc / $obraz[1];				
				if ($szei <= $wysi) {
					$szerokosc_ostateczna[$i] = ($obraz[0] * $szei)-2;		// szerokosc okna
					$wysokosc_ostateczna[$i] = ($obraz[1] * $szei)-2;		// wysokosc okna
				   } else {
					$szerokosc_ostateczna[$i] = ($obraz[0] * $wysi)-2;
					$wysokosc_ostateczna[$i] = ($obraz[1] * $wysi)-2;				   
				}
				
				$lin[$i]=FILENAME_PRODUCT_INFO .'?products_id=' .$random_product['products_id'];	// tworzy link produktu
				$nazwa_produktu[$i] = osc_trunc_string($random_product['products_name'], 50, 1);	// tworzy nazwe produktu
          }
		  
          if ($query_special_prices_hide_result == 'true') {
            $kwota[$i] = '<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>';
          } else {
            if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
              $kwota[$i] = '<s>' . $currencies->display_price($random_product['products_id'], $random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>';
            } else {
              $kwota[$i] = '<span class="smallText"><b>' .PRICES_LOGGED_IN_TEXT. '</b></span>';
            }
         }		  		  
		  $i++;
       }
  }
?>
<script type="text/javascript">

var fadebgcolor="ffffff"   //kolo tla obrazka
var fadeimages=new Array();
<?php
$tlocolor="ffffff";	// kolor tla napisow
$i = 0;
while ($pausecontent[$i]) {		//tworzy tablice z obrazkamki
	echo "fadeimages[".$i."] = ['".$pausecontent[$i]."','".$lin[$i]."','','" . $szerokosc_ostateczna[$i] . "','" . $wysokosc_ostateczna[$i] . "','" . $nazwa_produktu[$i] . "','" . $kwota[$i] . "'];	
";
	$i++;
}
?>

</script>

<script type="text/javascript">
var fadearray=new Array() //array to cache fadeshow instances
var fadeclear=new Array() //array to cache corresponding clearinterval pointers
 
var dom=(document.getElementById) //modern dom browsers
var iebrowser=document.all
 
function fadeshow(theimages, fadewidth, fadeheight, borderwidth, delay, pause, displayorder){
this.pausecheck=pause
this.mouseovercheck=0
this.delay=delay
this.degree=10 //initial opacity degree (10%)
this.curimageindex=0
this.nextimageindex=1
fadearray[fadearray.length]=this
this.slideshowid=fadearray.length-1
this.canvasbase="canvas"+this.slideshowid
this.curcanvas=this.canvasbase+"_0"
if (typeof displayorder!="undefined")
theimages.sort(function() {return 0.5 - Math.random();}) //thanks to Mike (aka Mwinter) :)
this.theimages=theimages
this.imageborder=parseInt(borderwidth)
this.postimages=new Array() //preload images
this.obrazek=new Array()  //tworzy tablice z obrazkami
for (p=0;p<theimages.length;p++){
this.postimages[p]=new Image()
this.postimages[p].src=theimages[p][0]
this.obrazek[p]=theimages[p][0];
}
 
var fadewidth=fadewidth+this.imageborder*2
var fadeheight=fadeheight+this.imageborder*2
 
if (iebrowser&&dom||dom) //if IE5+ or modern browsers (ie: Firefox)
document.write('<div id="master'+this.slideshowid+'" style="position:relative;width:'+fadewidth+'px;height:'+fadeheight+'px;overflow:hidden;"><div id="'+this.canvasbase+'_0" style="position:absolute;width:'+fadewidth+'px;height:'+fadeheight+'px;top:0;left:0;filter:progid:DXImageTransform.Microsoft.alpha(opacity=10);opacity:0.1;-moz-opacity:0.1;-khtml-opacity:0.1;background-color:'+fadebgcolor+'"></div><div id="'+this.canvasbase+'_1" style="position:absolute;width:'+fadewidth+'px;height:'+fadeheight+'px;top:0;left:0;filter:progid:DXImageTransform.Microsoft.alpha(opacity=10);opacity:0.1;-moz-opacity:0.1;-khtml-opacity:0.1;background-color:'+fadebgcolor+'"></div></div>')
else
document.write('<div><img name="defaultslide'+this.slideshowid+'" src="'+this.postimages[0].src+'" width="'+this.theimages[picindex][3]+'px" height="'+this.theimages[picindex][4]+'px"></div>')
 
if (iebrowser&&dom||dom) //if IE5+ or modern browsers such as Firefox
this.startit()
else{
this.curimageindex++
setInterval("fadearray["+this.slideshowid+"].rotateimage()", this.delay)
}
}

function fadepic(obj){
if (obj.degree<100){
obj.degree+=10
if (obj.tempobj.filters&&obj.tempobj.filters[0]){
if (typeof obj.tempobj.filters[0].opacity=="number") //if IE6+
obj.tempobj.filters[0].opacity=obj.degree
else //else if IE5.5-
obj.tempobj.style.filter="alpha(opacity="+obj.degree+")"
}
else if (obj.tempobj.style.MozOpacity)
obj.tempobj.style.MozOpacity=obj.degree/101
else if (obj.tempobj.style.KhtmlOpacity)
obj.tempobj.style.KhtmlOpacity=obj.degree/100
else if (obj.tempobj.style.opacity&&!obj.tempobj.filters)
obj.tempobj.style.opacity=obj.degree/101
}
else{
clearInterval(fadeclear[obj.slideshowid])
obj.nextcanvas=(obj.curcanvas==obj.canvasbase+"_0")? obj.canvasbase+"_0" : obj.canvasbase+"_1"
obj.tempobj=iebrowser? iebrowser[obj.nextcanvas] : document.getElementById(obj.nextcanvas)
obj.populateslide(obj.tempobj, obj.nextimageindex)
obj.nextimageindex=(obj.nextimageindex<obj.postimages.length-1)? obj.nextimageindex+1 : 0
setTimeout("fadearray["+obj.slideshowid+"].rotateimage()", obj.delay)
}
}
 
fadeshow.prototype.populateslide=function(picobj, picindex){
var slideHTML=""
if (this.theimages[picindex][1]!="") //if associated link exists for image
linkHTML='<a class="boxLink" href="'+this.theimages[picindex][1]+'" target="'+this.theimages[picindex][2]+'">';
<?php
$ewys=$wysokosc+4;
$esze=$szerokosc+4;
?>
slideHTML='<table cellspacing="0" cellpadding="2" style="border:0px solid #000000;"><tr><td height="40px" align="center" bgcolor="#<?php echo $tlocolor; ?>"><a class="boxLink" href="'+this.theimages[picindex][1]+'" target="'+this.theimages[picindex][2]+'">'+this.theimages[picindex][5]+'</a></td></tr><tr><td height="<?php echo $ewys;?>px" width="<?php echo $esze;?>px" valign="middle"><a href="'+this.theimages[picindex][1]+'" target="'+this.theimages[picindex][2]+'"><img src="product_thumb.php?img='+this.obrazek[picindex]+'&amp;w='+this.theimages[picindex][3]+'&amp;h='+this.theimages[picindex][4]+'" border="'+this.imageborder+'px" width="'+this.theimages[picindex][3]+'px" height="'+this.theimages[picindex][4]+'px"></a></td></tr>';
slideHTML+='<tr><td height="40px" align="center" bgcolor="#<?php echo $tlocolor; ?>"><a class="boxLink" href="'+this.theimages[picindex][1]+'" target="'+this.theimages[picindex][2]+'">'+this.theimages[picindex][6]+'</a></td></tr><tr></table>';
picobj.innerHTML=slideHTML
}
 
fadeshow.prototype.rotateimage=function(){
if (this.pausecheck==1) //if pause onMouseover enabled, cache object
var cacheobj=this
if (this.mouseovercheck==1)
setTimeout(function(){cacheobj.rotateimage()}, 100)
else if (iebrowser&&dom||dom){
this.resetit()
var crossobj=this.tempobj=iebrowser? iebrowser[this.curcanvas] : document.getElementById(this.curcanvas)
crossobj.style.zIndex++
fadeclear[this.slideshowid]=setInterval("fadepic(fadearray["+this.slideshowid+"])",50)
this.curcanvas=(this.curcanvas==this.canvasbase+"_0")? this.canvasbase+"_1" : this.canvasbase+"_0"
}
else{
var ns4imgobj=document.images['defaultslide'+this.slideshowid]
ns4imgobj.src=this.postimages[this.curimageindex].src
}
this.curimageindex=(this.curimageindex<this.postimages.length-1)? this.curimageindex+1 : 0
}
 
fadeshow.prototype.resetit=function(){
this.degree=10
var crossobj=iebrowser? iebrowser[this.curcanvas] : document.getElementById(this.curcanvas)
if (crossobj.filters&&crossobj.filters[0]){
if (typeof crossobj.filters[0].opacity=="number") //if IE6+
crossobj.filters(0).opacity=this.degree
else //else if IE5.5-
crossobj.style.filter="alpha(opacity="+this.degree+")"
}
else if (crossobj.style.MozOpacity)
crossobj.style.MozOpacity=this.degree/101
else if (crossobj.style.KhtmlOpacity)
crossobj.style.KhtmlOpacity=this.degree/100
else if (crossobj.style.opacity&&!crossobj.filters)
crossobj.style.opacity=this.degree/101
}
 
fadeshow.prototype.startit=function(){
var crossobj=iebrowser? iebrowser[this.curcanvas] : document.getElementById(this.curcanvas)
this.populateslide(crossobj, this.curimageindex)
if (this.pausecheck==1){ //IF SLIDESHOW SHOULD PAUSE ONMOUSEOVER
var cacheobj=this
var crossobjcontainer=iebrowser? iebrowser["master"+this.slideshowid] : document.getElementById("master"+this.slideshowid)
crossobjcontainer.onmouseover=function(){cacheobj.mouseovercheck=1}
crossobjcontainer.onmouseout=function(){cacheobj.mouseovercheck=0}
}
this.rotateimage()
}
</script>

<?php
$boxContent = '';
$wysokosc_pola = $wysokosc + 86;	//  wysokosc obrazka + wysokosc wierszy z napisami (2 x 40px) + cellpadding 6 px
$szerokosc_pola = $szerokosc + 4;
$boxContent .= "<script type='text/javascript'>new fadeshow(fadeimages, " . $szerokosc_pola . ", " . $wysokosc_pola . ", 0, 2000, 0, 'R');</script>";
$boxContent .= '<b><br><a class="boxLink" href="'.tep_href_link(FILENAME_SPECIALS).'">'.WHATS_NEW_ALL.'</a></b>';

       include (bts_select('boxes', $box_base_name)); // BTS 1.5

    $boxLink = '';

    $boxContent_attributes = '';

?>