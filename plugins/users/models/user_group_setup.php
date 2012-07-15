<?php
class UserGroupSetup extends UsersAppModel {

	var $name = "UserGroupSetup";
	var $useTable = 'users_groups_setups';
	var $primaryKey = "grpid";
	
	var $validate = array(
			'grp_name' => array('rule' => 'notEmpty','required' => true),
			'grp_note' => array('rule' => 'notEmpty','required' => true)
	);

	function get(){
		return $this->find('list',array('conditions'=>array('deleted'=>null),'fields'=>array('grpid','grp_name')));
	}

}
?>