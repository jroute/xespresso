<?php
class Tag extends AppModel {

	var $name = "Tag";
	var $useTable = 'tags';

	var $validate = array(
		'tag' => array('rule' => 'notEmpty','required' => true)
	);

	private function getTagId($tag)
	{
		$data = $this->find('first',array('conditions'=>array('tag'=>$tag)));
		return ($data['Tag']['id'] ? $data['Tag']['id']:FALSE);
	}

	function add($tag)
	{
		$data['Tag']['tag'] = trim($tag);
		if( ($tagid = $this->getTagId($data['Tag']['tag'])) == FALSE )
		{
			$this->create();
			$this->save($data);
			return $this->getLastInsertID();
		}
		return $tagid;
	}
	
	
}
