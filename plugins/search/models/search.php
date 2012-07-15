<?php
class Search extends AppModel {

	var $name = "Search";
	var $useTable = 'searchs';

	var $validate = array(
									'keyword' => array('rule' => 'notEmpty','required' => true),
									);



	function save($q)
	{
		if( trim($q) == '' ) return;
		
		$data['Search']['keyword'] = $q;
		$data['Search']['ip'] = env('REMOTE_ADDR');
		$data['Search']['agent'] = env('HTTP_USER_AGENT');
		parent::save($data);				
	}
}
