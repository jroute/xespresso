<?php
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
class ContentsController extends AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Contents';

/**
 * Default helper
 *
 * @var array
 * @access public
 */
	var $helpers = array('Editor','Cache','Image');
/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	var $uses = array(
		'Contents.ContentReversion',
		'Fileattach.Fileattach',		
		'Contents.Content',
		'Popup.Popup'
	);
	var $components = array();
	
	var $allow_level = 8;//수정 권한
/*
	var $cacheAction = array(
				'homepage' => '86400',
				'view/' => '31536000'
	);
//*/

	var $paginate = array(
					'Content'=>array(
							'conditions'=>array('Content.deleted'=>null),
							'limit' => 20
					),
					'ContentReversion'=>array(
							'order'=>array('reversion'=>'desc'),
							'limit'=>10
					)
		);
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */

	function beforeFilter(){

		parent::beforeFilter();


		Configure::load('Contents.config');
		
		$this->set('allow_level',$this->allow_level);
		
		//admin page
		if( eregi("webadm_",$this->action) ){

			if( @$this->params['pass'][0] ){
				$menus = $this->Menu->getMenus('Content',$this->params['pass'][0]);
				$this->set(compact('menus'));
			}

		}//user page
		else{

		}
	}

	function intro(){
		$this->layout = null;
	}

	function home(){


	}

	function sitemap(){

	}

	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title'));

		$this->render(join('/', $path));
	}

	function view($id){

		$page = $this->Content->find('first',array('conditions'=>array('Content.deleted'=>null,'Content.id'=>$id)));

		if( $page['Content']['id'] == "" ){
			$this->SessionAlert("페이지가 존재하지 않습니다.");
			$this->redirect('/');
		}

		$content = $page['Content'];

		$this->pageTitle = $this->site['title'].' '.$page['Content']['title'];

		$this->set("id",$id);
		$this->set("content",$content);
		$this->set("_editor",$page['Content']['editor']);		
		$this->render('view');
		
	}

	//사용자 페이지 수정 처리 Ajax
	function edit($id){

		Configure::write('debug', 0);
		$this->layout = '';
		$this->autoRender = false;

		if( $this->Session->Read('User.level') < $this->allow_level && (int)$this->Session->Read('Admin.level') < $this->allow_level ){ echo 'failure'; exit; }

		$this->data['Content']['id'] = $id;
		$this->data['Content']['content'] = stripslashes($_POST['content']);
		
		if( $this->Content->save($this->data,false) ){
		
			$this->Fileattach->link($this->Session->id(),'contents',$id);
			
			$data = $this->Content->Read(null,$id);
			$this->data['Content']['title'] = $data['Content']['title'];
			$this->ContentReversion->add($id,$this->data['Content'],$this->Session->Read('User'));
			echo 'success';
		}else{
			echo 'failurex';
		}
	}

	function webadm_index($lang=null){
		$conditions = array();
		
		$conditions['Content.lang'] = $this->lang;
		$this->Content->bindModel(array(
			'hasOne'=>array(
				'Menu'=>array(
					'className'=>'Menu',
					'conditions'=>array('Menu.controller'=>'contents'),
					'foreignKey'=>'pass'
				),
			),
		),false);
		$this->set("datas",$this->paginate('Content',$conditions));
	}


	function webadm_add(){
	
		$this->set("datas",$this->paginate('Content'));
		$menus = $this->Menu->generatetreelist(null,null,null,'- ',null);
		$this->set(compact('menus'));

		
		if( empty($this->data) ){
		
			if( $this->lang ){
				$this->data['Content']['lang'] = $this->lang;
			}

			$this->data['Content']['editor'] = @$this->passedArgs['editor']?@$this->passedArgs['editor']:'ckeditor';

		}else{
			$mid = $this->data['Menu']['id'];
			
			if( $this->Content->save($this->data) ){
				$parent_id = $this->Content->getInsertId();
				
				$this->Fileattach->link($this->Session->id(),'contents',$parent_id);
							
				$this->ContentReversion->add($parent_id,$this->data['Content'],$this->Session->Read('Admin'));

				//메뉴정보
				$this->__set_menu($mid,$parent_id);
				
				$this->Session->setFlash("등록되었습니다.");
				$this->redirect(array('action'=>'index','language:'.$this->lang));
			}else{

			}
		}
		 $this->set("reversions",array());
		$this->render('webadm_form');
	}

	function webadm_view($id){
			$this->redirect(array('action'=>'edit',$id));
	}

	function webadm_revert($pid,$id=null){

		if( empty($this->data) ){

       $this->set("reversions",$this->paginate('ContentReversion',array('parent_id'=>$pid)));


			$data = $this->ContentReversion->Read(null,$id);
			$this->data['Content'] = $data['ContentReversion'];
			$this->data['Content']['id'] = $data['ContentReversion']['parent_id'];

		}else{

			if( $this->Content->save($this->data) ){
			
				$this->Fileattach->link($this->Session->id(),'contents',$id);
				
				$this->ContentReversion->add($pid,$this->data['Content'],$this->Session->Read('Admin'));

				$this->Session->setFlash("리버전 되었습니다.");
				$this->redirect(array('action'=>'edit',$pid));
			}else{
				$this->Session->setFlash("리버전 할 수 없습니다.");
				$this->redirect(array('action'=>'edit',$pid));
			}
		}

	}

	function __set_menu($mid,$pid){
	
		if( $mid ){//메뉴 싱크
			$data['Menu']['id'] 				= $mid;
			$data['Menu']['controller']	= 'contents';
			$data['Menu']['action'] 		= 'view';
			$data['Menu']['model'] 			= 'Contents.Content';
			$data['Menu']['pass'] 			= $pid;				
			if( $this->Menu->save($data,false) ){ return true; }	
		}else{
		  //이전에 메뉴 설정 후 수정시 메뉴 선택을 안했을 경우
		  if( $this->Menu->find('count',array('conditions'=>array('controller'=>'contents','pass'=>$pid))) ){
		  
			  $tmp = $this->Menu->find('first',array('conditions'=>array('controller'=>'contents','pass'=>$pid)));
				$data['Menu']['id'] 				= $tmp['Menu']['id'];
				$data['Menu']['controller']	= '';
				$data['Menu']['action'] 		= '';
				$data['Menu']['model'] 			= '';
				$data['Menu']['pass'] 			= '';
				if( $this->Menu->save($data,false) ){ return true; }				
			}
		}

		return false;
		
	}

	function webadm_edit($id){

		if( empty($this->data) ){
      $this->set("reversions",$this->paginate('ContentReversion',array('parent_id'=>$id)));

			$this->Content->bindModel(array(
				'hasOne'=>array(
					'Menu'=>array(
						'className'=>'Menu',
						'conditions'=>array('Menu.controller'=>'contents'),
						'foreignKey'=>'pass'
					),
				),
			));
		
			$this->data = $this->Content->Read(null,$id);

			$menus = $this->Menu->generatetreelist(null,null,null,'- ',null);
			$this->set(compact('menus'));			

			$this->data['Content']['editor'] = @$this->passedArgs['editor']?@$this->passedArgs['editor']:$this->data['Content']['editor'];
		}else{

			$mid = $this->data['Menu']['id'];
			if( $this->Content->save($this->data) ){
			
				$this->Fileattach->link($this->Session->id(),'contents',$id);
				
				$this->ContentReversion->add($id,$this->data['Content'],$this->Session->Read('Admin'));
				
				//메뉴정보
				$this->__set_menu($mid,$id);
				
				$this->Session->setFlash("수정되었습니다.");
				$this->redirect(array('action'=>'edit',$id));
			}else{

			}
		}

		$this->render('webadm_form');
	}
	
	function webadm_delete($id){
		if( $this->Content->del($id) ){
			$this->Session->setFlash("삭제되었습니다.");
		}else{
			$this->Session->setFlash("오류 : 삭제 할 수 없습니다.");
		}
		$this->redirect(array('action'=>'index'));		
	}
}

?>