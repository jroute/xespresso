<?php
class Logs extends AppModel {
	var $name = 'Logs';
//	var $useTable = false;


	function write($uid,$name,$level,$state){

			$this->data['Logs']['userid']		= $uid;
			$this->data['Logs']['name']			= $name;
			$this->data['Logs']['level']		= $level;
			$this->data['Logs']['state']		= $state;
			$this->data['Logs']['ip']				= @$_SERVER['REMOTE_ADDR'];
			$this->data['Logs']['agent']		= @$_SERVER['HTTP_USER_AGENT'];
			$this->data['Logs']['referral']	= @$_SERVER['HTTP_REFERER'];
			$this->data['Logs']['cookie']		= @$_SERVER['HTTP_COOKIE'];

			$this->save($this->data);
	}
}

?>