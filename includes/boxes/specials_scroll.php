<?php
/*
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
$query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;

$boxHeading = BOX_HEADING_SPECIALS;
$corner_left = 'rounded';
$corner_right = 'rounded';
$boxContent_attributes = ' align="center"';
$szerokosc = SMALL_IMAGE_WIDTH+1;
$wysokosc = SMALL_IMAGE_HEIGHT+1;

$box_base_name = 'specials'; // for easy unique box template setup (added BTSv1.2)
$box_id = $box_base_name . 'Box';  // for CSS styling paulm (editted BTSv1.2)
$boxLink = '<a class="boxLink" href="' . tep_href_link(FILENAME_SPECIALS) . '">' .tep_image(DIR_WS_TEMPLATES . 'images/infobox/arrow_right.gif') .'</a>';

if (!isset($customer_id)) $customer_id = 0;
	$customer_group = tep_get_customers_groups_id();
  $rp_query = tep_db_query("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c  where c.categories_status='1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p.products_status = '1' and p.products_id = s.products_id and pd.products_id = s.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' and ((s.customers_id = '" . $customer_id . "' and s.customers_groups_id = '0') or (s.customers_id = '0' and s.customers_groups_id = '" . $customer_group . "') or (s.customers_id = '0' and s.customers_groups_id = '0')) order by RAND() ");
  if (tep_db_num_rows($rp_query)) {

		?>
		<script type='text/javascript'>
		//<![CDATA[
		var pausecontent=new Array()
		//]]>
		</script>

		<?php

		$i = 0;
    while ($random_product = tep_db_fetch_array($rp_query)) {


			$random_product['products_price'] = tep_xppp_getproductprice($random_product['products_id']);
      $random_product['specials_new_products_price'] = tep_get_products_special_price($random_product['products_id']);
      $query_special_prices_hide_result = SPECIAL_PRICES_HIDE;

      $pausecontent[$i] = '<table border="0" cellpadding="1" cellspacing="0" width="100%"><tr><td align="center">';

		  if ($random_product['products_image'] != ''){
  				$pausecontent[$i] .= '<table class="dia" cellpadding="0" cellspacing="0">';
  				$pausecontent[$i] .= '<tr><td width="'.$szerokosc.'" height="'.$wysokosc.'">';
          $pausecontent[$i] .= '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product["products_id"]) . '">' . tep_image(DIR_WS_IMAGES . $random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>';
  				$pausecontent[$i] .= '</td></tr></table>';
          }

					$pausecontent[$i] .= '</td></tr><tr><td class="smallText" align="center">';
  
          if ($query_special_prices_hide_result == 'true') {
            $pausecontent[$i] .= '<a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">' . osc_trunc_string($random_product['products_name'], 50, 1) . '</a><br><span class="productSpecialPrice">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>';
          } else {
            if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
              $pausecontent[$i] .= '<a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">' . osc_trunc_string($random_product['products_name'], 50, 1) . '</a><br><s>' . $currencies->display_price($random_product['products_id'], $random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>';
            } else {
              $pausecontent[$i] .= '<a class="boxLink" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">' . osc_trunc_string($random_product['products_name'], 50 ,1) . '</a><br><span class="smallText"><b>' .PRICES_LOGGED_IN_TEXT. '</b></span>';
            }
         }

         $pausecontent[$i] .= '</td></tr></table>';
			
			$i++;
    }

?>
<?php
  }
?>
<script type="text/javascript">
//<![CDATA[
/* merge server php and client javascript arrays */
var pausecontent=new Array();
<?php
$i = 0;
while ($pausecontent[$i]) {
	echo "pausecontent[".$i."] = '".$pausecontent[$i]."';
	
";
	$i++;
}
?>
//]]>
</script>
<script type="text/javascript">
//<![CDATA[
function pausescroller(content, divId, divClass, delay){
this.content=content //message array content
this.tickerid=divId //ID of ticker div to display information
this.delay=delay //Delay between msg change, in miliseconds.
this.mouseoverBol=0 //Boolean to indicate whether mouse is currently over scroller (and pause it if it is)
this.hiddendivpointer=1 //index of message array for hidden div
document.write('<div id="'+divId+'" class="'+divClass+'" style="position: relative; display:block; overflow: hidden;"><div class="innerDiv" style="position: absolute; width: 100%;" id="'+divId+'1">'+content[0]+'</div><div class="innerDiv" style="position: relative; width: 100%; visibility: hidden" id="'+divId+'2">'+content[1]+'</div></div>')
var scrollerinstance=this
if (window.addEventListener) //run onload in DOM2 browsers
window.addEventListener("load", function(){scrollerinstance.initialize()}, false)
else if (window.attachEvent) //run onload in IE5.5+
window.attachEvent("onload", function(){scrollerinstance.initialize()})
else if (document.getElementById) //if legacy DOM browsers, just start scroller after 0.5 sec
setTimeout(function(){scrollerinstance.initialize()}, 500)
}

// -------------------------------------------------------------------
// initialize()- Initialize scroller method.
// -Get div objects, set initial positions, start up down animation
// -------------------------------------------------------------------

pausescroller.prototype.initialize=function(){
this.tickerdiv=document.getElementById(this.tickerid)
this.visiblediv=document.getElementById(this.tickerid+"1")
this.hiddendiv=document.getElementById(this.tickerid+"2")
this.visibledivtop=parseInt(pausescroller.getCSSpadding(this.tickerdiv))
//set width of inner DIVs to outer DIV's width minus padding (padding assumed to be top padding x 2)
this.visiblediv.style.width=this.hiddendiv.style.width=this.tickerdiv.offsetWidth-(this.visibledivtop*2)+"px"
this.getinline(this.visiblediv, this.hiddendiv)
this.hiddendiv.style.visibility="visible"
var scrollerinstance=this
document.getElementById(this.tickerid).onmouseover=function(){scrollerinstance.mouseoverBol=1}
document.getElementById(this.tickerid).onmouseout=function(){scrollerinstance.mouseoverBol=0}
if (window.attachEvent) //Clean up loose references in IE
window.attachEvent("onunload", function(){scrollerinstance.tickerdiv.onmouseover=scrollerinstance.tickerdiv.onmouseout=null})
setTimeout(function(){scrollerinstance.animateup()}, this.delay)
}


// -------------------------------------------------------------------
// animateup()- Move the two inner divs of the scroller up and in sync
// -------------------------------------------------------------------

pausescroller.prototype.animateup=function(){
var scrollerinstance=this
if (parseInt(this.hiddendiv.style.top)>(this.visibledivtop+2)){
this.visiblediv.style.top=parseInt(this.visiblediv.style.top)-2+"px"
this.hiddendiv.style.top=parseInt(this.hiddendiv.style.top)-2+"px"
setTimeout(function(){scrollerinstance.animateup()}, 50)
}
else{
this.getinline(this.hiddendiv, this.visiblediv)
this.swapdivs()
setTimeout(function(){scrollerinstance.setmessage()}, this.delay)
}
}

// -------------------------------------------------------------------
// swapdivs()- Swap between which is the visible and which is the hidden div
// -------------------------------------------------------------------

pausescroller.prototype.swapdivs=function(){
var tempcontainer=this.visiblediv
this.visiblediv=this.hiddendiv
this.hiddendiv=tempcontainer
}

pausescroller.prototype.getinline=function(div1, div2){
div1.style.top=this.visibledivtop+"px"
div2.style.top=Math.max(div1.parentNode.offsetHeight, div1.offsetHeight)+"px"
}

// -------------------------------------------------------------------
// setmessage()- Populate the hidden div with the next message before it's visible
// -------------------------------------------------------------------

pausescroller.prototype.setmessage=function(){
var scrollerinstance=this
if (this.mouseoverBol==1) //if mouse is currently over scoller, do nothing (pause it)
setTimeout(function(){scrollerinstance.setmessage()}, 100)
else{
var i=this.hiddendivpointer
var ceiling=this.content.length
this.hiddendivpointer=(i+1>ceiling-1)? 0 : i+1
this.hiddendiv.innerHTML=this.content[this.hiddendivpointer]
this.animateup()
}
}

pausescroller.getCSSpadding=function(tickerobj){ //get CSS padding value, if any
if (tickerobj.currentStyle)
return tickerobj.currentStyle["paddingTop"]
else if (window.getComputedStyle) //if DOM2
return window.getComputedStyle(tickerobj, "").getPropertyValue("padding-top")
else
return 0
}

//new pausescroller(pausecontent, "pscroller1", "someclass", 2000);
//]]>
</script>
<?php
$boxContent = '';
$boxContent .= "<script type='text/javascript'>new pausescroller(pausecontent, 'pscroller1', 'someclass', 2000);</script>";
$boxContent .= '<b><a class="boxLink" href="'.tep_href_link(FILENAME_SPECIALS).'">'.WHATS_NEW_ALL.'</a></b>';

       //$boxContent .= '</marquee>';
       include (bts_select('boxes', $box_base_name)); // BTS 1.5

    $boxLink = '';

    $boxContent_attributes = '';

?>