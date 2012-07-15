<?php
class Slogan extends AppModel {
	var $name = 'Slogan';
	var $useTable = 'slogans';//



	var $validate = array(
									'name' => array('rule' => 'notEmpty','required' => true),
									'email'=>array('rule'=>'email','required'=>true),
									'phone' => array('rule' => 'notEmpty','required' => true),
									'organization' => array('rule' => 'notEmpty','required' => true),
									'slogan' => array('rule' => 'notEmpty','required' => true),
									'description' => array('rule' => 'notEmpty','required' => true),									
									);

}
