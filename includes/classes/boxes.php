<?php
/*
  $Id: \includes\classes\boxes.php; 24.06.2006

 mod eSklep-Os http://www.esklep-os.com

  Licencja: GNU General Public License
*/

  class tableBox {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '2';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBox($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . tep_output_string($this->table_border) . '" width="' . tep_output_string($this->table_width) . '" cellspacing="' . tep_output_string($this->table_cellspacing) . '" cellpadding="' . tep_output_string($this->table_cellpadding) . '"';
      if (tep_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
//        if (tep_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
// ################ Products Description Hack begins ########################""
            if ($contents[$i][$x]['desc_flag'] == 'true') {
              $tableBox_string .= '  </tr>' . "\n";
              $tableBox_string .= '  <tr';
              if ($this->table_row_parameters != '') $tableBox_string .= ' ' . $this->table_row_parameters;
              if ($contents[$i]['params']) $tableBox_string .= ' ' . $contents[$i]['params'];
              $tableBox_string .= '>' . "\n";              
            }
// ############### Products Description Hack ends ################

			if (isset($contents[$i][$x]['text']) && tep_not_null($contents[$i][$x]['text'])) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && tep_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (tep_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td ';
          if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (tep_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td>' . "\n";
        }

        $tableBox_string .= '  </tr>' . "\n";
		if ((tep_not_null($this->table_linia) && tep_output_string($this->table_linia) == 'true')) {
			if ($i < $n-1) {
				$tableBox_string .= '<TR><TD colSpan=3 align="center"><hr></TD></TR>';
			}
		}
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
  }

  class infoBox extends tableBox {
    function infoBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->infoBoxContents($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="infoBox"';
      $this->tableBox($info_box_contents, true);
    }

    function infoBoxContents($contents) {
      $this->table_cellpadding = '3';
      $this->table_parameters = 'class="infoBoxContents"';
      $info_box_contents = array();
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => 'class="boxText"',
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }

  class infoBoxHeading extends tableBox {
    function infoBoxHeading($contents, $left_corner = false, $right_corner = false, $right_arrow = false) {
      $this->table_cellpadding = '0';

      if ($left_corner == true) {
	    if (file_exists(DIR_WS_TEMPLATES . 'images/categoriesbox/corner_left.gif')) {
		  $left_corner = tep_image(DIR_WS_TEMPLATES . 'images/categoriesbox/corner_left.gif');
        } else {
          $left_corner = '';
		}
	  } else {
        $left_corner = tep_image(DIR_WS_TEMPLATES . 'images/categoriesbox/corner_right_left.gif');
      }
      if ($right_arrow == true) {
        $right_arrow = '<a href="' . $right_arrow . '">' . tep_image(DIR_WS_TEMPLATES . 'infobox/categoriesbox/arrow_right.gif', ICON_ARROW_RIGHT) . '</a>';
      } else {
        $right_arrow = '';
      }
      if ($right_corner == true) {
 	    if (file_exists(DIR_WS_TEMPLATES . 'images/categoriesbox/corner_right.gif')) {
         $right_corner = tep_image(DIR_WS_TEMPLATES . 'images/categoriesbox/corner_right.gif');
		} else {
		 $right_corner = '';
		}
      } else {
        $right_corner = $right_arrow . tep_draw_separator('pixel_trans.gif', '11', '14');
      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'class="CornerBoxHeading"',
                                         'text' => ''.$left_corner.''),
                                   array('params' => 'class="infoBoxHeading" width="100%"',
                                         'text' => ''.$contents[0]['text'].''),
                                   array('params' => 'class="CornerBoxHeading"',
                                         'text' => ''.$right_corner.''));

      $this->tableBox($info_box_contents, true);
    }
  }

  class contentBox extends tableBox {
    function contentBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->contentBoxContents($contents));
      $this->table_border = '0';
      $this->table_cellspacing = '0';
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="infoBox"';
      $this->tableBox($info_box_contents, true);
    }

    function contentBoxContents($contents) {
      $this->table_border = '0';
      $this->table_cellpadding = '4';
      $this->table_parameters = 'class="infoBoxContents"';
      return $this->tableBox($contents);
    }
  }

  class contentBoxindex extends tableBox {
    function contentBoxindex($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->contentBoxContentsindex($contents));
      $this->table_cellspacing = '0';
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class=""';
      $this->tableBox($info_box_contents, true);
    }

    function contentBoxContentsindex($contents) {
      $this->table_cellpadding = '0';
      $this->table_border = '0';
      $this->table_parameters = 'class="infoBoxContents"';
      return $this->tableBox($contents);
    }
  }



  class contentBoxRelated extends tableBoxMoja {
    function contentBoxRelated($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->contentBoxContentsRelated($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="infoBox"';
      $this->table_linia = 'true';
      $this->tableBoxMoja($info_box_contents, true);
    }

    function contentBoxContentsRelated($contents) {
      $this->table_cellpadding = '0';
      $this->table_border = '0';
      $this->table_parameters = 'class="infoBoxContents"';
      $this->table_linia = 'true';
      return $this->tableBoxMoja($contents);
    }
  }
  
  class contentBoxHit extends tableBoxMoja {
    function contentBoxHit($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->contentBoxContentsHit($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="infoBox"';
      $this->table_linia = 'false';
      $this->tableBoxMoja($info_box_contents, true);
    }

    function contentBoxContentsHit($contents) {
      $this->table_cellpadding = '0';
      $this->table_border = '0';
      $this->table_parameters = '';
      $this->table_linia = 'true';
      return $this->tableBoxMoja($contents);
    }
  }
  
  class contentBoxHeading extends tableBox {
    function contentBoxHeading($contents) {
      $this->table_width = '100%';
      $this->table_cellpadding = '0';

	  if (file_exists(DIR_WS_TEMPLATES . 'images/modules/corner_left.gif')) {
		$left_corner = tep_image(DIR_WS_TEMPLATES . 'images/modules/corner_left.gif');
      } else {
        $left_corner = '';
	  }
      if (file_exists(DIR_WS_TEMPLATES . 'images/modules/corner_right.gif')) {
       $right_corner = tep_image(DIR_WS_TEMPLATES . 'images/modules/corner_right.gif');
	  } else {
	   $right_corner = '';
	  }

      $info_box_contents = array();

      $info_box_contents[] = array(array('params' => 'class="CornerBoxHeading" width="20" height="20"',
                                         'text' => ''.$left_corner.''),
                                   array('params' => 'class="pageHeading" width="100%"',
                                         'text' => ''.$contents[0]['text'].''),
                                   array('params' => 'class="CornerBoxHeading" width="20" height="20"',
                                         'text' => ''.$right_corner.''));

      $this->tableBox($info_box_contents, true);
    }
  }

  class errorBox extends tableBox {
    function errorBox($contents) {
      $this->table_data_parameters = 'class="errorBox"';
      $this->tableBox($contents, true);
    }
  }

  class productListingBox extends tableBox {
    function productListingBox($contents) {
      $this->table_parameters = 'class="productListing"';
       $this->table_border = '0';
       $this->table_cellpadding = '4';
       $this->table_cellspacing = '0';
     $this->tableBox($contents, true);
    }
  }

//New CategoriesBox Class
  class tableBoxCategories {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '0';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';
    var $td_width = '100%';
    var $td_class = 'CategoryRow';

// class constructor
    function tableBoxCategories($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . tep_output_string($this->table_border) . '" width="' . tep_output_string($this->table_width) . '" cellspacing="' . tep_output_string($this->table_cellspacing) . '" cellpadding="' . tep_output_string($this->table_cellpadding) . '"';
      if (tep_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
		if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if (tep_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
            if (isset($contents[$i][$x]['text']) && tep_not_null($contents[$i][$x]['text'])) {
			  if (file_exists(DIR_WS_TEMPLATES . 'images/categoriesbox/category_bullet.gif')) {	  
				$tableBox_string .= '<td align="center" class="' . tep_output_string($this->td_class) . '">' . tep_image(DIR_WS_TEMPLATES . 'images/categoriesbox/category_bullet.gif') . '</td>';
			  } else {
				$tableBox_string .= '';
			  }
			  $tableBox_string .= '<td width="' . tep_output_string($this->td_width) . '" class="' . tep_output_string($this->td_class) . '"';
              if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && tep_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (tep_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td';
          if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (tep_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td>' . "\n";
        }

        $tableBox_string .= '  </tr>' . "\n";
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</tr></table>' . "\n";
//      $tableBox_string .= '<tr><td height="5"></td></tr></table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
  }


  class CategoriesBox extends tableBoxCategories {
    function CategoriesBox($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->CategoriesBoxContents($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = 'class="infoBox"';
      $this->tableBoxCategories($info_box_contents, true);
    }

    function CategoriesBoxContents($contents) {
      $this->table_cellpadding = '0';
      $this->table_parameters = 'class="infoBoxContents"';
      $info_box_contents = array();
//      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
	  for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => $contents[$i]['align'],
                                           'form' => $contents[$i]['form'],
																					
                                           'params' => '',
																					 //added by thomas ruess to identify the categories box 
										   'id' => 'categoriesBoxContents',
                                           'text' => $contents[$i]['text']));
      }
//      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBoxCategories($info_box_contents);
    }
  }

//New CategoriesBoxHeading Class
  class tableBoxCategoriesHeading {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '0';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBoxCategoriesHeading($contents, $direct_output = false) {
      $tableBox_string = '<tr><td><table border="' . tep_output_string($this->table_border) . '" width="' . tep_output_string($this->table_width) . '" cellspacing="' . tep_output_string($this->table_cellspacing) . '" cellpadding="' . tep_output_string($this->table_cellpadding) . '"';
      if (tep_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if (tep_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
            if (isset($contents[$i][$x]['text']) && tep_not_null($contents[$i][$x]['text'])) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && tep_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (tep_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td';
          if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (tep_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td>' . "\n";
        }

        $tableBox_string .= '  </tr>' . "\n";
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
  }


  class CategoriesBoxHeading extends tableBoxCategoriesHeading {
    function CategoriesBoxHeading($contents, $left_corner = false, $right_corner = false) {
      $this->table_cellpadding = '0';

      if ($left_corner == true) {
	    if (file_exists(DIR_WS_TEMPLATES . 'images/categoriesbox/corner_left.gif')) {
		  $left_corner = tep_image(DIR_WS_TEMPLATES . 'images/categoriesbox/corner_left.gif');
        } else {
          $left_corner = '';
		}
	  } else {
        $left_corner = tep_image(DIR_WS_TEMPLATES . 'images/categoriesbox/corner_right_left.gif');
      }
      if ($right_corner == true) {
 	    if (file_exists(DIR_WS_TEMPLATES . 'images/categoriesbox/corner_right.gif')) {
         $right_corner = tep_image(DIR_WS_TEMPLATES . 'images/categoriesbox/corner_right.gif');
		} else {
		 $right_corner = '';
		}
      } else {
        $right_corner = tep_draw_separator('pixel_trans.gif', '11', '14');
      }

      $info_box_contents = array();
      $info_box_contents[] = array(array('params' => 'class="CornerBoxHeading"',
										 'text' => ''.$left_corner.''),
                                   array('params' => 'class="infoBoxHeading" width="100%"',
                                         'text' => ''.$contents[0]['text'].''),
                                   array('params' => 'class="CornerBoxHeading"',
                                         'text' => ''.$right_corner.''));


      $this->tableBoxCategoriesHeading($info_box_contents, true);
    }
  }

// moje dorobki ***********************************8


  class tableBoxMoja {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '0';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBoxMoja($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . tep_output_string($this->table_border) . '" width="' . tep_output_string($this->table_width) . '" cellspacing="' . tep_output_string($this->table_cellspacing) . '" cellpadding="' . tep_output_string($this->table_cellpadding) . '"';
      if (tep_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if (tep_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
        if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
            if (isset($contents[$i][$x]['text']) && tep_not_null($contents[$i][$x]['text'])) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && tep_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (tep_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td ';
          if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (tep_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td>' . "\n";
        }

        $tableBox_string .= '  </tr>' . "\n";
		if ((tep_not_null($this->table_linia) && tep_output_string($this->table_linia) == 'true')) {
			if ($i < $n-1) {
				$tableBox_string .= '<TR><TD bgColor=#ffffff colSpan=3 height=5></TD></TR>';
			}
		}
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
  }


//+++ HACK product  listing
  class tableBox2 {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '0';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';
	var $rows = 0;
	var $cols = 0;
// class constructor
    function tableBox2($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . $this->table_border . '" width="' . $this->table_width . '" cellspacing="' . $this->table_cellspacing . '" cellpadding="' . $this->table_cellpadding . '"';
      if ($this->table_parameters != '') $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '><tr valign="top" align="center">' . "\n";

      for ($i=0; $i<sizeof($contents); $i++) {
	    if ($cols == MAX_DISPLAY_COLUMN_PRODUCTS_LISTING) {
			$cols = 0;
			$tableBox_string .= '  </tr><tr><td><br></td></tr><tr valign="top" align="center">';
		}
		$cols ++;
		
        if ($contents[$i]['form']) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <td width="25%"';
        if ($this->table_row_parameters != '') $tableBox_string .= ' ' . $this->table_row_parameters;
        if ($contents[$i]['params']) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '><table>' . "\n";

        if (is_array($contents[$i][0])) {
          for ($x=0; $x<sizeof($contents[$i]); $x++) {
            if ($contents[$i][$x]['text']) {
              $tableBox_string .= '    <tr><td';
              if ($contents[$i][$x]['align'] != '') $tableBox_string .= ' align="' . $contents[$i][$x]['align'] . '"';
              if ($contents[$i][$x]['params']) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif ($this->table_data_parameters != '') {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if ($contents[$i][$x]['form']) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if ($contents[$i][$x]['form']) $tableBox_string .= '</form>';
              $tableBox_string .= '</td></tr>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <tr><td';
          if ($contents[$i]['align'] != '') $tableBox_string .= ' align="' . $contents[$i]['align'] . '"';
          if ($contents[$i]['params']) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif ($this->table_data_parameters != '') {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td></tr>' . "\n";
        }

        $tableBox_string .= '  </table></td>' . "\n";
        if ($contents[$i]['form']) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</tr></table>' . "\n";

      if ($direct_output) echo $tableBox_string;

      return $tableBox_string;
    }
  }

  class productListingBoxrows extends tableBox2 {
    function productListingBoxrows($contents) {
      $this->table_parameters = 'class="productListing"';
      $this->tableBox2($contents, true);
    }
  }
 //+++ HACK product  listing

  class contentBoxUpcoming extends tableBox {
    function contentBoxUpcoming($contents) {
      $this->table_width = '100%';
      $this->table_cellpadding = '0';

	  if (file_exists(DIR_WS_TEMPLATES . 'images/modules/corner_left.gif')) {
		$left_corner = tep_image(DIR_WS_TEMPLATES . 'images/modules/corner_left.gif');
      } else {
        $left_corner = '';
	  }
      if (file_exists(DIR_WS_TEMPLATES . 'images/modules/corner_right.gif')) {
       $right_corner = tep_image(DIR_WS_TEMPLATES . 'images/modules/corner_right.gif');
	  } else {
	   $right_corner = '';
	  }

      $info_box_contents = array();

      $info_box_contents[] = array(array('params' => 'class="CornerBoxUpcoming" width="20" height="20"',
                                         'text' => ''.$left_corner.''),
                                   array('params' => 'class="pageUpcoming" width="100%"',
                                         'text' => ''.$contents[0]['text'].''),
                                   array('params' => 'class="CornerBoxUpcoming" width="20" height="20"',
                                         'text' => ''.$right_corner.''));

      $this->tableBox($info_box_contents, true);
    }
  }


  class tableBox3 {
    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '2';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBox3($contents, $direct_output = false) {
      $tableBox_string = '<table border="' . tep_output_string($this->table_border) . '" width="' . tep_output_string($this->table_width) . '" cellspacing="' . tep_output_string($this->table_cellspacing) . '" cellpadding="' . tep_output_string($this->table_cellpadding) . '"';
      if (tep_not_null($this->table_parameters)) $tableBox_string .= ' ' . $this->table_parameters;
      $tableBox_string .= '>' . "\n";

      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= $contents[$i]['form'] . "\n";
        $tableBox_string .= '  <tr';
        if (tep_not_null($this->table_row_parameters)) $tableBox_string .= ' ' . $this->table_row_parameters;
//        if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) $tableBox_string .= ' ' . $contents[$i]['params'];
        $tableBox_string .= '>' . "\n";

        if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
          for ($x=0, $n2=sizeof($contents[$i]); $x<$n2; $x++) {
// ################ Products Description Hack begins ########################""
            if ($contents[$i][$x]['desc_flag'] == 'true') {
              $tableBox_string .= '  </tr>' . "\n";
              $tableBox_string .= '  <tr';
              if ($this->table_row_parameters != '') $tableBox_string .= ' ' . $this->table_row_parameters;
              if ($contents[$i]['params']) $tableBox_string .= ' ' . $contents[$i]['params'];
              $tableBox_string .= '>' . "\n";              
            }
// ############### Products Description Hack ends ################

			if (isset($contents[$i][$x]['text']) && tep_not_null($contents[$i][$x]['text'])) {
              $tableBox_string .= '    <td';
              if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i][$x]['align']) . '"';
              if (isset($contents[$i][$x]['params']) && tep_not_null($contents[$i][$x]['params'])) {
                $tableBox_string .= ' ' . $contents[$i][$x]['params'];
              } elseif (tep_not_null($this->table_data_parameters)) {
                $tableBox_string .= ' ' . $this->table_data_parameters;
              }
              $tableBox_string .= '>';
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= $contents[$i][$x]['form'];
              $tableBox_string .= $contents[$i][$x]['text'];
              if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) $tableBox_string .= '</form>';
              $tableBox_string .= '</td>' . "\n";
            }
          }
        } else {
          $tableBox_string .= '    <td ';
          if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align'])) $tableBox_string .= ' align="' . tep_output_string($contents[$i]['align']) . '"';
          if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) {
            $tableBox_string .= ' ' . $contents[$i]['params'];
          } elseif (tep_not_null($this->table_data_parameters)) {
            $tableBox_string .= ' ' . $this->table_data_parameters;
          }
          $tableBox_string .= '>' . $contents[$i]['text'] . '</td>' . "\n";
        }

        $tableBox_string .= '  </tr>' . "\n";
//		if ((tep_not_null($this->table_linia) && tep_output_string($this->table_linia) == 'true')) {
			if ($i < $n) {
				$tableBox_string .= '<TR><TD width="100%" height="1"colSpan=3 align="center"><img src="'.DIR_WS_TEMPLATES.'images/modules/linia_pozioma.gif" border="0" alt="" width="100%" height="1"></TD></TR>';
			}
//		}
        if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form'])) $tableBox_string .= '</form>' . "\n";
      }

      $tableBox_string .= '</table>' . "\n";

      if ($direct_output == true) echo $tableBox_string;

      return $tableBox_string;
    }
  }

  class noborderBox extends tableBox {
    function noborderBox($contents) {
      $this->table_cellpadding = '0';
      $this->table_data_parameters = 'class="noborderBox"';
      $this->tableBox($contents, true);
    }
  }

  class noborderBox2 extends tableBox {
    function noborderBox2($contents) {
      $info_box_contents = array();
      $info_box_contents[] = array('text' => $this->noborderBox2Contents($contents));
      $this->table_cellpadding = '1';
      $this->table_parameters = '';
      $this->tableBox($info_box_contents, true);
    }
    function noborderBox2Contents($contents) {
      $this->table_cellpadding = '0';
      $this->table_parameters = 'class="infoBoxContents"';
      $info_box_contents = array();
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
        $info_box_contents[] = array(array('align' => (isset($contents[$i]['align']) ? $contents[$i]['align'] : ''),
                                           'form' => (isset($contents[$i]['form']) ? $contents[$i]['form'] : ''),
                                           'params' => 'class="boxText"',
                                           'text' => (isset($contents[$i]['text']) ? $contents[$i]['text'] : '')));
      }
      $info_box_contents[] = array(array('text' => tep_draw_separator('pixel_trans.gif', '100%', '1')));
      return $this->tableBox($info_box_contents);
    }
  }

?>