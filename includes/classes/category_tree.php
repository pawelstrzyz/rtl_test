<?php
/*
 $Id: category_tree.php 1 2007-12-20 23:52:06Z  $

 osCommerce, Open Source E-Commerce Solutions
 http://www.oscommerce.com

 Copyright (c) 2004 osCommerce

 Released under the GNU General Public License

 mod eSklep-Os http://www.esklep-os.com
*/

 class osC_CategoryTree {
   var $root_category_id = 0,
       $max_level = 0,
       $data = array(),
       $root_start_string = '',
       $root_end_string = '',
       $parent_start_string = '',
       $parent_end_string = '',
       $parent_group_start_string = '<ul>',
       $parent_group_end_string = '</ul>',
       $child_start_string = '<li>',
       $child_end_string = '</li>',
       $spacer_string = '',
       $spacer_multiplier = 1;

   function osC_CategoryTree($load_from_database = true) {
     global $languages_id;
         $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and c.categories_status = '1' and cd.language_id = '" . (int)$languages_id . "' order by c.parent_id, c.sort_order, cd.categories_name");
         $this->data = array();
         while ($categories = tep_db_fetch_array($categories_query)) {
			// Ultimate SEO URLs compatibility - Chemo
			# initialize array container
			$c = array();
			# Get the category path, $c is passed by reference
			tep_get_parent_categories($c, $categories['categories_id']);
			# For some reason it seems to return in reverse order so reverse the array
			$c = array_reverse($c);
			# Implode the array to get the full category path
			$id = (implode('_', $c) ? implode('_', $c) . '_' . $categories['categories_id'] : $categories['categories_id']);
           $this->data[$categories['parent_id']][$id] = array('name' => $categories['categories_name'], 'count' => 0);
         }
   }

   function buildBranch($parent_id, $level = 0) {
     $result = $this->parent_group_start_string;

     if (isset($this->data[$parent_id])) {
       foreach ($this->data[$parent_id] as $category_id => $category) {
         $category_link = $category_id;
         $result .= $this->child_start_string;
         if (isset($this->data[$category_id])) {
           $result .= $this->parent_start_string;
         }

         if ($level == 0) {
           $result .= $this->root_start_string;
         }
         $result .= str_repeat($this->spacer_string, $this->spacer_multiplier * $level) . '<a href="' . tep_href_link(FILENAME_DEFAULT, 'cPath=' . $category_link) . '">';
         $result .= $category['name'];
         $result .= '</a>';
		 
		 $result .= $this->buildProducts($category_id);
         
		 if ($level == 0) {
           $result .= $this->root_end_string;
         }

         if (isset($this->data[$category_id])) {
           $result .= $this->parent_end_string;
         }

         $result .= $this->child_end_string;

         if (isset($this->data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level+1))) {
           $result .= $this->buildBranch($category_id, $level+1);
         }
       }
     }

     $result .= $this->parent_group_end_string;

     return $result;
   }
/**
	* function qui va ajouter a la liste result les produit de la category defini
	* vandoorn Bruno karando@karando.com
*/
	function buildProducts($category_id)
	{
     	global $languages_id;
		if (strpos($category_id,"_")!==false)
		{
			$categori_id = explode("_",$category_id); 
			$categori_id=$categori_id[sizeof($categori_id)-1];
		}
		else
		{
			$categori_id=$category_id;
		}
		$req="select * from products prod, products_to_categories prodcate , products_description proddescr
		where prodcate.categories_id=".$categori_id." and prod.products_id=prodcate.products_id 
		and proddescr.language_id=".$languages_id." and proddescr.products_id=prod.products_id ";
		$products_query = tep_db_query($req);
		//echo $req;
		$result="";
		$result .= $this->parent_group_start_string;
		while ($products = tep_db_fetch_array($products_query)) 
		{
			$result .= $this->child_start_string;
			$result.='&nbsp;<a href="' .tep_href_link(FILENAME_PRODUCT_INFO, ($category_id ? 'cPath=' . $category_id . '&' : '') . 'products_id=' . $products['products_id']) . '">' . $products['products_name'] . '</a>&nbsp;';
			$result .= $this->child_end_string;
		}
		$result .= $this->parent_group_end_string;
		return $result;
	}


   function buildTree() {
     return $this->buildBranch($this->root_category_id);
   }
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
?>