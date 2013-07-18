function SetFocus() {
  if (document.forms.length > 0) {
    var field = document.forms[0];
    for (i=0; i<field.length; i++) {
      if ( (field.elements[i].type != "image") &&
           (field.elements[i].type != "hidden") &&
           (field.elements[i].type != "reset") &&
           (field.elements[i].type != "submit") ) {

        document.forms[0].elements[i].focus();

        if ( (field.elements[i].type == "text") ||
             (field.elements[i].type == "password") )
          document.forms[0].elements[i].select();

        break;
      }
    }
  }
}

function rowOverEffect(object) {
  if (object.className == 'dataTableRow') object.className = 'dataTableRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'dataTableRowOver') object.className = 'dataTableRow';
}

function toggleDivBlock(id) {
	if (document.getElementById) {
		itm = document.getElementById(id);
	} else if (document.all){
		itm = document.all[id];
	} else if (document.layers){
		itm = document.layers[id];
	}
		
	if (itm) {
		if (itm.style.display != "none") {
			itm.style.display = "none";
		} else {
			itm.style.display = "block";
		}
	}
}

var gsFieldToUpdate = "";

function openFileLibrary(vsFieldToUpdate){
	if(vsFieldToUpdate!="") {
		gsFieldToUpdate = vsFieldToUpdate;
	}
	oFileLibraryWindow = window.open('includes/filebrowser/index.php','winFileLib','width=650,height=600,scrollbars=yes,resizable=yes,status=yes,titlebar=0');
	oFileLibraryWindow.focus();
} // end open_file_library

function insertPath(vsFilePath) {
	eval(gsFieldToUpdate+'.value = vsFilePath;');
}

//==========================================
// Check All boxes
//==========================================
function CheckAll(fmobj) {
  for (var i=0;i<fmobj.elements.length;i++) {
    var e = fmobj.elements[i];
    if ( (e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled) ) {
      e.checked = fmobj.allbox.checked;
    }
  }
}

//==========================================
// Check all or uncheck all?
//==========================================
function CheckCheckAll(fmobj) {
  var TotalBoxes = 0;
  var TotalOn = 0;
  for (var i=0;i<fmobj.elements.length;i++) {
    var e = fmobj.elements[i];
    if ((e.name != 'allbox') && (e.type=='checkbox')) {
      TotalBoxes++;
      if (e.checked) {
       TotalOn++;
      }
    }
  }
  if (TotalBoxes==TotalOn) {
    fmobj.allbox.checked=true;
  }
  else {
   fmobj.allbox.checked=false;
  }
}
