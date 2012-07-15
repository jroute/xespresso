<?php
class PopupzoneController extends PopupAppController {

	var $name = "Popupzone";
	var $uses = array('Popupzone.Popupzone');
	var $components = array();

	var $paginate = array(
				'Popupzone'=>array(
									'conditions'=>array('Popupzone.deleted'=>null),
									'limit'=>15,
									'order' => array(
													'Popupzone.created' => 'desc'
									)
				)			
	);

	var $spath = '';
	/***
	*
	*
	*/	
	function beforeFilter(){
		parent::beforeFilter();
		
		
		$this->set('paginate',$this->paginate);
		
		$this->spath = APP.'webroot'.DS.'files'.DS.'popupzone';
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
		$this->set('rows',$this->paginate('Popupzone',array()));
	}
	
	
	function __fileupload($file){
		if( $file['tmp_name'] ){
			$tmp = explode('.',$file['name']);
			$ext = array_pop($tmp);
			$sfile_name = time().'.'.$ext;

			if( move_uploaded_file($file['tmp_name'],$this->spath.DS.$sfile_name) ){
				return $sfile_name;				
			}

		}
		return "";
	}
	
	function webadm_add(){
		if( empty($this->data) ){
			
			
		}else{
			$this->data['Popupzone']['banner'] = $this->__fileupload($this->data['Popupzone']['usrfile']);
			
			if( $this->Popupzone->save($this->data)){
				$this->Session->setFlash("등록 되었습니다.");
				$this->redirect(array('action'=>'index'));
			}
		}
		
		$this->render('webadm_form');
	}
	
	function webadm_edit($id){
	
		if( empty($this->data) ){
		
			$this->data = $this->Popupzone->Read(null,$id);
			
		}else{
		
			$data = $this->Popupzone->Read(null,$id);
			if( $this->data['Popupzone']['delfile'] ){
				@unlink($this->spath.DS.$data['Popupzone']['banner']);
				$this->data['Popupzone']['banner'] = '';
			}else{
				$this->data['Popupzone']['banner'] = $data['Popupzone']['banner'];
			}
			
			if( $this->data['Popupzone']['usrfile']['tmp_name'] ){
				$this->data['Popupzone']['banner'] = $this->__fileupload($this->data['Popupzone']['usrfile']);
			}
					
			if( $this->Popupzone->save($this->data)){
				$this->Session->setFlash("수정 되었습니다.");
				$this->redirect(array('action'=>'index'));
			}
		}	
		$this->render('webadm_form');		
	}
	
	function webadm_delete($id){
		$this->autoRender = false;
		
		if( $this->Popupzone->del($id) ){
			$this->Session->setFlash("삭제 되었습니다.");
			$this->redirect(array('action'=>'index'));
		}else{
			$this->Session->setFlash("시스템 오류로 삭제 할 수 없습니다.");
			$this->redirect(array('action'=>'index'));		
		}
	}
	
}
?>