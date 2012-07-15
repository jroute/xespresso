<?php
class Company extends UsersAppModel {

	var $name = "Company";

	var $primaryKey = "userid";

	var $validate = array(
									'userid' => array('rule' => 'notEmpty','required' => true,'minLength'=>'6')
									);

}
?>