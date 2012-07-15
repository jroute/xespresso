<?php
class UserGroup extends UsersAppModel {

	var $name = "UserGroup";
	var $useTable = 'users_groups';

	function remove($id){
		$this->query("delete from ".$this->tablePrefix.$this->table." where 1 and userid='".$id."'");
	}

	function add($uid,$gid){
		$this->query("delete from ".$this->tablePrefix.$this->table." where userid='".$uid."' and grpid='".$gid."'");
		
		if( $this->query("insert into ".$this->tablePrefix.$this->table." (userid,grpid,created) values ('".$uid."',".$gid.",sysdate())") ){
			return true;
		}else{
			return false;
		}

	}
}
