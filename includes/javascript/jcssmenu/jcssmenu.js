//<![CDATA[
/*
  devosc, developing open source code
  http://www.devosc.com

  Copyright (c) 2005 devosc

  Released under the GNU General Public License
*/
  var jcss =
  {
    delay:    500,
    timer:    null,
    cPtr:     null,
    minWidth: 88,
    pLIs:     new Array()
  };

  function jcssMenuMouseOut(elementId)
  {
    var cLI = document.getElementById(elementId);

    if (jcss.timer != null && jcss.cPtr == elementId) {

      cLI.firstChild.className = '';

      var cULs = cLI.getElementsByTagName('ul');

      for(var i=0; i < cULs.length; i++)

        cULs.item(i).style.visibility = 'hidden';

      var cLIs = cLI.getElementsByTagName('li');

      for(var i=0; i < cLIs.length; i++)

        cLIs.item(i).firstChild.className = '';

      jcss.cPtr = null;

      jcss.pLIs = new Array();

    } else {

      var className = '';

      for(var i=0; i < jcss.pLIs.length; i++)

        if (jcss.pLIs[i] == elementId) {

          className = 'hover';

          break;

        }

      cLI.firstChild.className = className;

    }
  }

  function jcssMenuMouseOver(elementId)
  {
    for(var i=0; i < jcss.pLIs.length; i++)

      if (jcss.pLIs[i] == elementId)

        break;

    if (i == jcss.pLIs.length)

      jcss.pLIs[i] = elementId;

    if (jcss.timer != null && jcss.cPtr != null) {

      var cLI = document.getElementById(jcss.cPtr);

      cLI.firstChild.className = '';

      var cULs = cLI.getElementsByTagName('ul');

      for(var i=0; i < cULs.length; i++)

        cULs.item(i).style.visibility = 'hidden';

      window.clearTimeout(jcss.timer);

      jcss.timer = null;

      jcss.pLIs = new Array();

    }

    jcss.cPtr = elementId;

    var cLI = document.getElementById(jcss.cPtr);

    if (cLI.parentNode.parentNode.tagName.toLowerCase() == 'li')

      cLI.parentNode.parentNode.firstChild.className = 'hover';

    var cULs = cLI.getElementsByTagName('ul');

    if (cULs.length > 0)

      cULs.item(0).style.visibility = 'visible';
  }

  function jcssMenu(eleId)
  {
    var elementId = (eleId == null) ? 'jcssMenu' : eleId;

    if (document.getElementById(elementId)) {

      var cULs = document.getElementById(elementId).getElementsByTagName('ul');

      for(var i=0; i < cULs.length; i++) {

        var cLIs = cULs.item(i).childNodes;

        var cWidth = (cLIs.item(0).childNodes.item(0).offsetWidth >= jcss.minWidth) ? cLIs.item(0).childNodes.item(0).offsetWidth : jcss.minWidth;

        for(var j=0; j < cLIs.length; j++) {

          cLIs.item(j).setAttribute('id', elementId + i + j);

          if (cLIs.item(j).childNodes.item(0).offsetWidth > cWidth)

            cWidth = cLIs.item(j).childNodes.item(0).offsetWidth;

          cLIs.item(j).onmouseover = function() { jcssMenuMouseOver( this.getAttribute('id') ); };

          cLIs.item(j).onmouseout = function() { jcss.timer = window.setTimeout("jcssMenuMouseOut('"+this.getAttribute('id')+"');",jcss.delay); };

          if (cLIs.item(j).parentNode.parentNode.tagName.toLowerCase() == 'li' && cLIs.item(j).lastChild.tagName.toLowerCase() == 'ul')

            cLIs.item(j).firstChild.firstChild.firstChild.className = 'submenu';

        }

        cLIs.item(j-1).style.borderBottomWidth = '1px'; //Opera

        if (cWidth > cLIs.item(0).childNodes.item(0).offsetWidth)

          cLIs.item(0).childNodes.item(0).style.width = cWidth + 'px';

        var dw = cLIs.item(0).childNodes.item(0).offsetWidth - cWidth;

        if ((cWidth - dw) > 0)

          for(var j=0; j < cLIs.length; j++)

              cLIs.item(j).childNodes.item(0).style.width = cWidth - dw  + 'px';

      }

    }
  }
//]]>