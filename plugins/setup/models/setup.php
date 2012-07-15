<?php
class Setup extends AppModel {
	var $name = "Setup";
	var $useTable = 'settings';
	
	var $primaryKey = "id";
	
	var $validate = array(
	);
	
	
	var $default_levels = array(
		0=>'비회원',
		1=>'일반회원',
		2=>'-',
		3=>'-',
		4=>'-',
		5=>'-',
		6=>'-',
		7=>'-',
		8=>'운영자',
		9=>'최고관리자'
	);

	function get(){

		$data = $this->find('first');

		return @array_shift($data);
  }

}
?>