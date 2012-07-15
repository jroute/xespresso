<?php
class UserHistory extends UsersAppModel {

	var $name = "UserHistory";
	var $useTable = 'users_histories';

	function add($uid,$uname,$aid,$aname,$message){
		
		$data['UserHistory'] = array(
			'userid'=>$uid,
			'uname'=>$uname,
			'accessid'=>$aid,
			'aname'=>$aname,
			'message'=>$message,
			'ip'=>$_SERVER['REMOTE_ADDR'],
			'agent'=>$_SERVER['HTTP_USER_AGENT']
		);
		if( $this->save($data) ){
			return true;
		}else{
			return false;
		}

	}
}
