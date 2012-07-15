<?php
class LogsController extends LogsAppController {
	var $name = 'Logs';

	var $components = array('Session');
	var $uses = array('Logs.Logs','Logs.Counter');
	var $helpers = array('Form');

	var $paginate = array(
								'Logs'=>array(
									'limit'=>5,
									'order' => array(
													'created' => 'DESC'
													)
									),
								'Counter'=>array(
									'limit'=>10,
									'order' => array(
													'created' => 'DESC'
													)
									)
							);

	function beforeFilter(){
		parent::beforeFilter();

		if( eregi("webadm_",$this->action) ){
			$this->pageTitle = "로그관리";
		}

	}


	function get_conditions($cond){
		$keyword = @$this->passedArgs['keyword'];
		$keyword = str_replace(array("'"),"",$keyword);
		$su = @$this->passedArgs['su'];
		$sn = @$this->passedArgs['sn'];

		$conditions = array('AND'=>array(1));

		if( $keyword ){
			$condition = array();
			if( $su ) array_push($condition,array('Log.userid LIKE'=>"$keyword%"));
			if( $sn ) array_push($condition,array('Log.name LIKE'=>"$keyword%"));

			switch(count($condition)){
				case 2: array_push($conditions,array('OR'=>$condition)); break;
				case 1: array_push($conditions,$condition); break;
			}
		}

		if( is_array($cond) ){
			array_push($conditions,$cond);
		}
		return $conditions;
	}

	function counter(){
		$this->autoRender = false;
		Configure::write('debug',0);
		
		$userAgent = $_SERVER['HTTP_USER_AGENT'];

		$data['Counter'] = $this->params['url'];
		$data['Counter']['session'] = $this->Session->_userAgent;;
		$data['Counter']['ip'] = $_SERVER['REMOTE_ADDR'];
		$this->Counter->write($data);
	}

	function webadm_index(){


		$cnt = $this->Counter->getCount();

		$count['uv']['total'] = $cnt['uv'];
		$count['pv']['total'] = $cnt['pv'];

		$cnt = $this->Counter->getCount('yesterday');

		$count['uv']['yesterday'] = $cnt['uv'];
		$count['pv']['yesterday'] = $cnt['pv'];

		$cnt = $this->Counter->getCount('today');

		$count['uv']['today'] = $cnt['uv'];
		$count['pv']['today'] = $cnt['pv'];

		$this->set('count',$count);

		/*******************************/
		$max_height = 200;
		$max_total = 0;

		$rows = $this->Counter->getRecentDays();

		foreach($rows as $i=>$data){
			if( $data[0]['total'] > $max_total ) $max_total = $data[0]['total'];
		}

		foreach($rows as $i=>$data){
			$rows[$i][0]['uvh'] = round($data[0]['uv']/$max_total*$max_height);
			$rows[$i][0]['pvh'] = round($data[0]['pv']/$max_total*$max_height);
		}

		for($st = strtotime(date('Y-m-d',time()-(86400*19))); $st <= strtotime(date('Y-m-d'));){

			$date = date('Y-m-d',$st);

			foreach($rows as $i=>$data){

				if($data[0]['date'] == $date ){
					$logs[$date] = array_shift($data);
					break;
				}
			}


			if( isset($logs[$date]) ){

			}else{
				$logs[$date] = array('uv'=>0,'pv'=>0,'total'=>0,'uvh'=>0,'pvh'=>0);
			}

			$st+= 86400;

		}//end for


		$this->set('logs',$logs);


		/******* last hits ***********/
		$this->set('hits',$this->Counter->getLastHits());
		
	}

	function webadm_counter($w='time'){


		$syear = $this->Counter->getBeginYear();

		$options['year'] = array();
		$options['month'] = array();
		$options['day'] = array();
		for( $i = $syear ; $i <= date('Y') ; $i++ ){
			$options['year'][$i] = $i;
		}

		for($i = 1; $i <= 12 ;$i++ ){
			$m = sprintf('%02d',$i);
			$options['month'][$m] = $m;
		}

		for($i = 1; $i <= 31 ;$i++ ){
			$d = sprintf('%02d',$i);
			$options['day'][$d] = $d;
		}


		if( !ereg("[0-9]{4}",@$this->data['Logs']['year']) ){
			$this->data['Logs']['year'] = date('Y');
		}
		if( !ereg("[0-9]{2}",@$this->data['Logs']['month']) ){
			$this->data['Logs']['month'] = date('m');
		}
		if( !ereg("[0-9]{2}",@$this->data['Logs']['day']) ){
			$this->data['Logs']['day'] = date('d');
		}


		$date = $this->data['Logs']['year'].'-'.$this->data['Logs']['month'].'-'.$this->data['Logs']['day'];

		$this->set('selectOptions',$options);

		$data = $this->Counter->getStatistics($w,$date);


		$counter['total']			= $this->Counter->getCount('total');
		$counter['today']			= $this->Counter->getCount('today');
		$counter['yesterday'] = $this->Counter->getCount('yesterday');


//		$this->set('data',$data);
		$this->set(compact('w','counter','data'));
	}


	function webadm_users(){

		if( count($this->passedArgs) > 1 ){
			$this->data['Logs'] = $this->passedArgs;
		}else{
			$this->passedArgs = $this->data['Logs'] = $this->params['url'];
			unset($this->data['Logs']['url']);
			unset($this->passedArgs['url']);

		}
		

		$conditions = $this->get_conditions(array('OR'=>array('level <'=>8,'`level` ='=>null)));
		$rows = $this->paginate('Logs',$conditions);
		$this->set(compact('rows'));

		$this->render('webadm_list');
	}


	function webadm_admins(){

		if( count($this->passedArgs) > 1 ){
			$this->data['Logs'] = $this->passedArgs;
		}else{
			$this->passedArgs = $this->data['Logs'] = $this->params['url'];
			unset($this->data['Logs']['url']);
			unset($this->passedArgs['url']);

		}

		$conditions = $this->get_conditions(array('`level` >='=>8,'`level` !='=>null));
		$rows = $this->paginate('Logs',$conditions);
		$this->set(compact('rows'));

		$this->render('webadm_list');
	}

}
?>
