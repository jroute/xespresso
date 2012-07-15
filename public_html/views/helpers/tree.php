<?php 
class TreeHelper extends AppHelper
{
	var $tree_depth = 0;
	function getCategories($key, $categories, &$mainList) {

	    $result = '<ul>';			

			$this->tree_depth++;	    
	    foreach($categories as $catKey => $name) {
	        $result .= $this->getCategory($catKey, $name, $mainList);
	    }
	    $result .= "</ul>\n";
	    return $result;
	}
	
	function getCategory($key, $value, &$mainList) {
			$class = "";
			if( !array_key_exists($key, $mainList) ) $class = "file.gif";
	    $result = '<li id="node'.$key.'" class="'.$class.'">';
	    $result .= '<a href="#">'.$value.'</a>';
	    
	    if(array_key_exists($key, $mainList)) {
	        $result .= $this->getCategories($key, $mainList[$key], $mainList);
	    }

	    $result .= "</li>\n";
	    
      $this->tree_depth = 0;
	    return $result;
	}
}