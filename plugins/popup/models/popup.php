<?php
class Popup extends PopupAppModel {

	var $name = "Popup";

	var $validate = array(
									'title' => array('rule' => 'notEmpty','required' => true),
									'dimensions' => array('rule' => 'notEmpty','required' => true),
									'content' => array('rule' => 'notEmpty','required' => true)
									);

	function get(){
		return $this->find('all',array('conditions'=>array(1,"left(sysdate(),16) BETWEEN sdate AND edate","state='Y'"),'fields'=>array('id','dimensions','scrollbars')));
	}

}
