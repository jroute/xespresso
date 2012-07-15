<?php

App::import('Vendor', 'Func',array('file'=>'functions.php'));


class IndexController extends IndexAppController {

	var $name = "Index";
	var $uses = array(
		'Fileattach.Fileattach',
		'Board.Board',
		'Popup.Popup',
		'Popupzone.Popupzone',
		
	);
	var $components = array();
	var $helpers = array('Image');


	var $paginate = array();



	/***
	*
	*
	*/	
	function beforeFilter(){
		parent::beforeFilter();


		$this->set('paginate',$this->paginate);



	}
	
	
	function index($index)
	{
	
		$this->render($index);
	}
	
	/***
	*
	*
	*/
	function home($division=null){

		$this->layout = 'index';
		
		
		//팝업존 정보
		$popupzones = $this->Popupzone->find('all',array('conditions'=>array('deleted'=>null)));

		
		//top공지
/*
		$top_notice = $this->Board->find('first',array('conditions'=>array('deleted'=>null,'Board.bid'=>'espotlight'),'order'=>array('created'=>'desc')));
		$this->set('top_notice',$top_notice);
*/

		//공지사항
//		$notices = $this->Board->latest('notice',null,4,60);
//		$this->set(compact('notices'));

		$popups = $this->Popup->get();

		$this->set(compact('popups','popupzones'));

	}
	
}
