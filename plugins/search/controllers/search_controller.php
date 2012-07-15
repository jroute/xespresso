<?php

class SearchController extends AppController {
	var $name = 'Search';
	var $uses = array(
		'Fileattach.Fileattach',
		'Users.UserGroup',		
		'Users.User',
		'Board.Board',
		'Comment.Comment',
		'Contents.Content',
		'Search.Search',
//		'Pages.Page',				
	);
	
	

	function beforeFilter(){

		parent::beforeFilter();

		//admin page
		if( eregi("webadm_",$this->action) ){

		}//user page
		else{

		}
	}
	
	
	function index(){
		$q = $this->params['url']['q'];
		$this->set('q',$q);
		//게시판 검색
		$rows['board'] = $this->Board->find('all',array(
			'conditions'=>array('Board.deleted'=>null,'OR'=>array('Board.subject like'=>'%'.$q.'%','Board.content like'=>'%'.$q.'%','Board.name like'=>'%'.$q.'%')),
			'order'=>array('Board.sort_no'),
			'limit'=>10
		));
		
		
		//댓글 검색
		$rows['comment'] = $this->Comment->find('all',array(
			'conditions'=>array('Comment.deleted'=>null,'OR'=>array('Comment.comment like'=>'%'.$q.'%','Comment.name like'=>'%'.$q.'%')),
			'order'=>array('Comment.created'=>'desc'),
			'limit'=>10
		));
		
		
		//컨텐츠 검색
		$rows['page'] = $this->Content->find('all',array(
			'conditions'=>array('Content.deleted'=>null,'OR'=>array('Content.title like'=>'%'.$q.'%','Content.content like'=>'%'.$q.'%')),
			'order'=>array('Content.created'=>'desc'),
			'limit'=>10
		));
		
		$this->set('rows',$rows);
		
		$this->Search->save($q);
	
	}
	
	function webadm_index(){
	
		$q = $this->params['url']['q'];
		
		
		//게시판 검색
		$rows['board'] = $this->Board->find('all',array(
			'conditions'=>array('Board.deleted'=>null,'OR'=>array('Board.subject like'=>'%'.$q.'%','Board.content like'=>'%'.$q.'%','Board.name like'=>'%'.$q.'%')),
			'order'=>array('Board.sort_no'),
			'limit'=>10
		));
		
		
		//댓글 검색
		$rows['comment'] = $this->Comment->find('all',array(
			'conditions'=>array('deleted'=>null,'OR'=>array('comment like'=>'%'.$q.'%','name like'=>'%'.$q.'%')),
			'order'=>array('created'=>'desc'),
			'limit'=>10
		));
		
		
		//컨텐츠 검색
		$rows['page'] = $this->Page->find('all',array(
			'conditions'=>array('Page.deleted'=>null,'OR'=>array('Page.title like'=>'%'.$q.'%','Page.content like'=>'%'.$q.'%')),
			'order'=>array('Page.created'=>'desc'),
			'limit'=>10
		));
		
		//사용자 검색
		$rows['user'] = $this->User->find('all',array(
			'conditions'=>array('User.deleted'=>null,'OR'=>array(
						'User.name like'=>'%'.$q.'%',
						'User.email like'=>'%'.$q.'%',
						'User.homepage like'=>'%'.$q.'%',
						'User.addr1 like'=>'%'.$q.'%',
						'User.addr2 like'=>'%'.$q.'%',
						'User.memo like'=>'%'.$q.'%'
			)),
			'order'=>array('User.created'=>'desc'),
			'limit'=>10
		));		
		
		$this->set('rows',$rows);
	}	

}
?>
