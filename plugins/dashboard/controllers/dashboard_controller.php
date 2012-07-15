<?php
class DashboardController extends DashboardAppController {
	var $name = 'Dashboard';
	var $uses = Array(
				'BoardSetup.BoardSetup',
				'Fileattach.Fileattach',
				'Board.Board',
				'Users.UserGroup',				
				'Users.User',
				'Logs.Counter',
			);
	var $components = Array('Session');


	function beforeFilter(){
		parent::beforeFilter();
		$this->pageTitle = "대시보드";
		
		//$menus['root']['name'] = "dashboard";
		//$this->set(compact('menus'));
	}

	function webadm_index(){


		$BOARD = $this->BoardSetup->find('list',array('conditions'=>array('BoardSetup.deleted'=>null),'fields'=>array('bid','bname')));

	
		//최근글
		$this->Board->unbindModelAll();
		$rows = $this->Board->find('all',array(
			'conditions'=>array('Board.deleted'=>null),
			'fields'=>array('Board.no','Board.bid','Board.subject','Board.created'),
			'order'=>array('Board.no'=>'desc'),'limit'=>10)
		);

		$RecentArticles = array();
		foreach($rows as $i=>$data ){
			$RecentArticles[$i] = $data;
			$RecentArticles[$i]['Board']['subject'] = strcut($data['Board']['subject'],40);
			$RecentArticles[$i]['Board']['bname'] = $BOARD[$data['Board']['bid']];			
		}


		$users['total']			= $this->User->find('count');
		$users['today']			= $this->User->find('count',array('conditions'=>array('left(User.`created`,10)'=>date('Y-m-d'))));
		$users['yesterday']	= $this->User->find('count',array('conditions'=>array('left(User.`created`,10)'=>date('Y-m-d',(time()-86400)))));


		$counter['total']			= $this->Counter->getCount('total');
		$counter['today']			= $this->Counter->getCount('today');
		$counter['yesterday'] = $this->Counter->getCount('yesterday');
		

		$this->set('RecentArticles',$RecentArticles);	
		$this->set(compact('users','counter'));
	}
	
}

