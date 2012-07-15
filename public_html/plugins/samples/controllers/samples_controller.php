<?php
class SamplesController extends SamplesAppController {

	var $name = "Samples";
	var $uses = array('Samples.Sample');
	var $components = array();



	/***
	*
	*
	*/	
	function beforeFilter(){
		parent::beforeFilter();
//		$this->set('title_for_layout','PLANI Project Manager ver 1.0.2');		
	}
	
	
	/***
	*
	*
	*/
	function index(){

	}
	
	function test(){
		$this->render('index');
	}

	function webadm_index(){
	
	}
	
}
?>