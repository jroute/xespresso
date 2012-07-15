<?php
class User extends UsersAppModel {

	var $name = "User";

	var $primaryKey = "userid";

	var $validate = array(
									'userid' => array('rule' => 'notEmpty','required' => true,'minLength'=>'6'),
									'name' => array('rule' => 'notEmpty','required' => true),
									'email'=>array('rule'=>'email','allowEmpty'=>true),
									'passwd' => array('rule' => 'notEmpty','required' => true,'minLength'=>'6'),
									'passwd2' => array('rule' => 'notEmpty','required' => true,'minLength'=>'6'),
//									'phone' => array('rule' => 'notEmpty','required' => true,'minLength'=>'10'),
//									'mobile' => array('rule' => 'notEmpty','required' => true,'minLength'=>'10'),
//									'zipcode' => array('rule' => 'notEmpty','required' => true,'minLength'=>'7'),
//									'addr1' => array('rule' => 'notEmpty','required' => true),
//									'addr2' => array('rule' => 'notEmpty','required' => true),
//									'validate_signnum'=> array('rule'=>array('validate_signnum')),
									'captcha'=>array('required'=>true,'minLength'=>6,'rule'=>'compcaptcha')									
									);

	var $hasOne = array('Company' =>
                        array('className'    => 'Company',
                              'conditions'   => '',
                              'order'        => '',
                              'dependent'    =>  false,
                              'foreignKey'   => 'userid'
                        )
                  );

	var $hasMany = array('UserGroup' =>
                        array('className'    => 'UserGroup',
                              'conditions'   => '',
                              'order'        => '',
                              'dependent'    =>  false,
                              'foreignKey'   => 'userid'
                        )
                  );

	function compcaptcha($data){
		$data = array_pop($data);
		if( strcmp($data,@$_SESSION['securimage_code_value']) == 0 ) return true;
		return false;
	}
	
	function validate_signnum($data){

		$data = $data['validate_signnum'];

		if(strlen($data) < 13) return 0;
		
			for($i =0; $i < 13; $i++) $p[$i] =substr($data,$i,1);

			                 
			$p[$i] =substr($data,$i,1);
            $check =($p[0] * 2) + ($p[1] * 3) + ($p[2] * 4) + ($p[3] * 5) + ($p[4] * 6) + ($p[5] * 7) + ($p[6] * 8) + ($p[7] * 9) + ($p[8] * 2) + ($p[9] * 3) + ($p[10] * 4) + ($p[11] * 5);
            $check =$check % 11;
            $check =11 - $check;
            $check =substr($check,-1);

            if($p[12] ==$check)
				return true;               
			else
				return false;
	}


	function signout($id){
		if( empty($id) ) return false;
		if( $this->query("update ".$this->tablePrefix.$this->table." set passwd='',signnum='',birthday='',email='',phone='',mobile='',homepage='',zipcode='',addr1='',addr2='',level='0',deleted=sysdate() where 1 and userid='$id'") ){
			return false;
		}else{
			return true;
		}
	}

	//임시 비밀번호 생성
	function setTmpPassword($uid,$password){
		if( $this->query("update ".$this->tablePrefix.$this->table." set passwd='".$password."' where 1 and userid='".$uid."'") ){
			return true;
		}else{
			return false;			
		}
	}


}
?>