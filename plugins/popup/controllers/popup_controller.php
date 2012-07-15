<?php
class PopupController extends PopupAppController {
	var $name = 'Popup';

	var $components = array('Session');
	var $uses = array('Popup.Popup');
	var $helpers = array('Editor');

	var $paginate = array('limit'=>10,'order' => array('created' => 'DESC'));

	var $version = '1.0.0';

	function beforeFilter(){
		parent::beforeFilter();

		$this->set('version',$this->version);


		if( eregi("webadm_",$this->action) ){

			$this->pageTitle = "팝업관리";
			$menus = $this->Menu->getMenus();
			$menus['submenu'] = array(array('id'=>null,'name'=>'dashboard','link'=>'#'));
			$this->set(compact('menus'));

		}else{
			$this->layout = 'popup_layout';
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
			if( $su ) array_push($condition,array('Popup.title LIKE'=>"$keyword%"));
			if( $sn ) array_push($condition,array('Popup.name LIKE'=>"$keyword%"));

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

	function error(){
		//empty;
	}
	
	function index(){
		$this->redirect(array('action'=>'view'));
	}


	function view($id=1){

		if( !empty($id) ){
			$this->data = $this->Popup->Read(null,$id);
			$this->pageTitle = $this->data['Popup']['title'];
		}else{
			$this->Session->setFlash('등록된 팝업 내용이 없습니다.');
			$this->redirect(array('action'=>'error'));
		}

		$this->render('view');
	}


	function webadm_index($w='time'){
		$this->set("datas",$this->paginate('Popup'));			
	}


	function webadm_add(){
		
		if( empty($this->data) ){

			$this->data['Popup']['sdate'] = date('Y-m-d 00:00');
			$this->data['Popup']['edate'] = date('Y-m-d 00:00');

			$this->data['Popup']['dimensions'] = '0,0,300,400';

			$this->data['Popup']['scrollbars'] = '0';
			$this->data['Popup']['state'] = 'N';
		}else{
			if( $this->Popup->save($this->data) ){
				$this->Session->setFlash('추가 되었습니다.');
				$this->redirect(array('action'=>'index'));
			}
		}
		$this->render('webadm_form');
	}


	function webadm_edit($id){

		if( empty($this->data) ){
			$this->data = $this->Popup->Read(null,$id);
			
		}else{
			if( $this->Popup->save($this->data) ){
				$this->Session->setFlash('수정 되었습니다.');
				$this->redirect(array('action'=>'index'));
			}
		}

		$this->render('webadm_form');
	}

	function webadm_delete($id){
		$this->Popup->id = $id;
		if( $this->Popup->delete() ){
			$this->Session->setFlash('삭제 되었습니다.');
			$this->redirect(array('action'=>'index'));
		}else{
			$this->Session->setFlash('삭제 실패');
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
