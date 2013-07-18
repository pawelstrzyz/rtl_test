/**************************************
	Fancy Menu
	v1.0
	last revision: 01.18.2005
	steve@slayeroffice.com

	based on wellvetted.com's Flash menu

	should you modify or improve upon this
	code, please let me know so I can update the
	version hosted on slayeroffice

	please leave this notice in tact!

**************************************/

window.onload = fm_init;		// set up the onload event
var d = document;			// shortcut reference to the document object
var fm_textValues = new Array();	// array that will hold the text node values in the anchor tags
var fm_activeLI = new Array();	// array of boolean values that will tell us if the expander DIV elements are in a transitional state
var fm_expandObj = new Array();	// object array that we'll use to reference the expander DIV elements
var fm_liObj;			// object array that we'll use to reference the LI elements
var zInterval = new Array();		// the interval var we'll use for the expansion. array'd for each object for multiple running intervals
var kInterval = new Array();		// the interval var we'll use for the fade. array'd for each object for multiple running intervals

var fm_curOpacity = new Array();	// the current opacity value for each expander div
var fm_doFade = new Array(); 	// an array that we'll set as a function for passing through the setInterval for the fade
var fm_doExpansion = new Array();	// an array that we'll set as a function for passing through the setInterval for the expansion
var fm_stringIndex = new Array();	// used to track each indexOf in the fm_textValues array as the text is written back into the anchor tags.


function fm_init() {
	// bail out if this is an older browser
	if(!d.getElementById)return;

	// reference the UL element
	ulObj = d.getElementById("fancyMenu");
	// create the array of LI elements that decend from the UL element
	fm_liObj  = ulObj.getElementsByTagName("li");
	// loop over the length of LI's and set them up for the script
	for(i=0;i<fm_liObj.length;i++) {
		// bogus xindex attribute is used to pass the index of the LI back to our event handlers so we know which object to reference
		// in the liObj array
		fm_liObj[i].xindex = i;
		// reference to the anchor tag in the LI
		aObj = fm_liObj[i].getElementsByTagName("a")[0];
		// set up the mouse events for the anchor tags.
		aObj.onmouseover = function() { fm_handleMouseOver(this.parentNode.xindex); }
		aObj.onmouseout = function() { fm_handleMouseOut(this.parentNode.xindex); }

		// get the "innerText" of the anchor tag
		fm_textValues[i] = aObj.innerHTML;

		// create the expander DIV element as a child of the current LI
		fm_expandObj[i] = fm_liObj[i].appendChild(d.createElement("div"));
		fm_expandObj[i].className = "expander";
		fm_expandObj[i].style.top = fm_liObj[i].offsetHeight/2 + "px";
		fm_expandObj[i].xindex = i;

		// initialize our intervals 
		zInterval[i] = null; kInterval[i] = null;
		// initialize the string index array, opacity array and activeLI array
		fm_stringIndex[i] = 1;
		fm_curOpacity[i] = 100;
		fm_activeLI[i] = 0;
	}
}


function fm_handleMouseOver(objIndex) {
	// do nothing if the user has already moused over this element
	if(fm_activeLI[objIndex])return;

	// set activeLI to true for this element
	fm_activeLI[objIndex]=1;
	// set the expander div up
	fm_expandObj[objIndex].style.display = "block";
	fm_expandObj[objIndex].style.height = "1px";
	fm_expandObj[objIndex].style.top = fm_liObj[objIndex].offsetHeight/2+"px";

	// create a reference var for the function to pass to the interval
	fm_doExpansion[objIndex] = function() { fm_expandDIV(objIndex); }
	zInterval[objIndex] = setInterval(fm_doExpansion[objIndex],10);
}

function fm_handleMouseOut(objIndex) {
	// do nothing if this is already running for the object
	if(kInterval[objIndex] != null) return;

	// reference to the anchor tag in the LI
	aObj = fm_liObj[objIndex].getElementsByTagName("a")[0];
	// blank out the innerHTML of the anchor tag
	aObj.innerHTML = "";
	// set the first letter of the text as the innerHTML of the anchor tag.
	//aObj.appendChild(d.createTextNode(fm_textValues[objIndex].substring(0,1)));
	aObj.innerHTML = fm_textValues[objIndex].substring(0,1);

	// create a reference var for the function to pass to the interval
	fm_doFade[objIndex] = function() { fm_fadeExpander(objIndex); }
	kInterval[objIndex] = setInterval(fm_doFade[objIndex],10);
}

function fm_expandDIV(objIndex) {
	// height and top arrays
	h = new Array(); y = new Array();
	// if the top of the expanding div is less than 0, go on...
	if(fm_expandObj[objIndex].offsetTop>=0) {
		// get the current top and height of the expanding div
		h[objIndex] = fm_expandObj[objIndex].offsetHeight;
		y[objIndex] = fm_expandObj[objIndex].offsetTop;
		// if the height is less than than the height of the parent LI, increment
		if(h[objIndex]<fm_liObj[objIndex].offsetHeight)h[objIndex]+=2;
		// decrement the top
		y[objIndex]--;
		// put the div where it needs to be
		fm_expandObj[objIndex].style.top = y[objIndex]+"px";
		fm_expandObj[objIndex].style.height = h[objIndex]+"px";
	} else {
		// finished expanding. clear the interval, null out the function reference and the interval reference
		clearInterval(zInterval[objIndex]);
		fm_doExpansion[objIndex]=null;
		zInterval[objIndex] = null;
	}
}

function fm_fadeExpander(objIndex) {
	// MSIE uses an percentage (0-100%) for opacity values, while everything else uses a floating point
	// between 0 and 1. next lines adress the difference
	fm_curOpacity[objIndex]=d.all?fm_curOpacity[objIndex]:fm_curOpacity[objIndex]/100;
	// subtract 5 (or .5 if not MSIE) from the current opacity
	fm_curOpacity[objIndex]-=d.all?5:0.05;

	// set the opacity values in all their different flavors.
	fm_expandObj[objIndex].style.opacity = fm_curOpacity[objIndex];
	fm_expandObj[objIndex].style.MozOpacity = fm_curOpacity[objIndex];
	fm_expandObj[objIndex].style.filter="alpha(opacity=" + fm_curOpacity[objIndex] + ")";

	// reference to the anchor tag in the LI
	aObj = fm_liObj[objIndex].getElementsByTagName("a")[0];
	// if the current opacity is less than 60%, start adding the letters back in
	if(fm_curOpacity[objIndex]<(d.all?60:0.6)) {	
		aObj.appendChild(d.createTextNode(fm_textValues[objIndex].charAt(fm_stringIndex[objIndex])));
		fm_stringIndex[objIndex]++;
	}

	// if the opacity is less than 0 and the text has finished drawing, clean up
	if(fm_curOpacity[objIndex]<=0 && aObj.innerHTML==fm_textValues[objIndex]) {
		// clear the interval and null them out
		clearInterval(kInterval[objIndex]);
		kInterval[objIndex] = null;
		// hide the expander div
		fm_expandObj[objIndex].style.display = "none";

		// reset the expander div back to opaque
		fm_expandObj[objIndex].style.opacity = 0.99;
		fm_expandObj[objIndex].style.MozOpacity = 0.99;
		fm_expandObj[objIndex].style.filter="alpha(opacity=100)";
		// put the expander back at 1 pixel high and in the middle of the LI
		fm_expandObj[objIndex].style.height = "1px";
		fm_expandObj[objIndex].style.top = fm_liObj[objIndex].offsetHeight/2 + "px";
		// set the activeLI to false
		fm_activeLI[objIndex]=0;
		// reset the currentOpacity to 100
		fm_curOpacity[objIndex] = 100;
		// reset the stringIndex for the next go-round
		fm_stringIndex[objIndex] = 1;
		return;
	}
	// if this isnt MSIE, multiply the opacity value by 100 for the next go round.
	if(!d.all)fm_curOpacity[objIndex]*=100;
}