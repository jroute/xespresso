<?php
class BoardCategory extends BoardAppModel {

	var $name = "BoardCategory";
	var $useTable = 'board_categories';
	var $actsAs = array('Tree');
	
	
	var $validate = array(
									'bid' => array('rule' => 'notEmpty','required' => true),
									'name' => array('rule' => 'notEmpty','required' => true)
									);

	function get($bid){
		
		$data = $this->find('all',array('conditions'=>array('bid'=>$bid),'fields'=>array('id','name')));

		$categories = array();
		if( is_array($data) ){
			foreach($data as $key=>$cate){
				$id = $cate['BoardCategory']['id'];
				$categories[$id] = $cate['BoardCategory']['name'];
			}
		}
		return $categories;
	}
}
?>