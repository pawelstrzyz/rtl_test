var opaciT = 100;
var transition = 10;
var speed = 10;
var timer= 0;

function opacity()
{

    opaciT = opaciT - transition;

    var object = document.getElementById('preloader').style;
    object.opacity = (opaciT / 100);
    object.MozOpacity = (opaciT / 100);
    object.KhtmlOpacity = (opaciT / 100);
    object.filter = "alpha(opacity=" + opaciT + ")";
       
        if (opaciT <= 0)
        {
                document.getElementById('preloader').style.display='none';
                clearInterval(timer);
        }

}
 
function preload()
{

        if (document.getElementById)
        {
                document.getElementById('preloadIMG').style.display='none';
                timer = setInterval("opacity()",speed);
        }
       
        else
        {
                if (document.layers)
                {       
                        document.preloadIMG.display='none';
                        timer = setInterval("opacity()",speed);
            }
                else
                {
                        document.all.preloadIMG.style.display='none';
                        timer = setInterval("opacity()",speed);
                }
        }
}

var GIFpreloadLargeur = 20;
var GIFpreloadHauteur = 20;
var myCSS;

myCSS = "<style type=\"text/css\">";

myCSS += "html, body { height:auto; margin:0px; padding:0px;}";

myCSS += "#preloader {";
myCSS += "position:fixed;";
myCSS += "background-color:white;";
myCSS += "width:100%;";
myCSS += "height:100%; ";
myCSS += "display:block;";
myCSS += "z-index:100000;";
myCSS += "}";

myCSS += "#preloadIMG {";
myCSS += "position:absolute;";
myCSS += "left:50%;";
myCSS += "width:" + GIFpreloadLargeur + "px;";
myCSS += "height:" + GIFpreloadHauteur + "px;";
myCSS += "margin-left:-" + (GIFpreloadLargeur / 2) + "px;";
myCSS += "top:150px;";
myCSS += "}";

myCSS += "</style>";

window.document.write(myCSS);

window.onload = function() { preload(); }
