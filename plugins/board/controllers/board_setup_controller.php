<?php
#	/app/controllers/board_setups_controller.php
uses("File","Folder","Xml");

class BoardSetupController extends BoardAppController {

	var $name = "BoardSetup";
	var $uses = Array(
			'Board.BoardSetup',
			'Board.BoardCategory'
	);
	var $components = array();
	var $helpers = array();


	function beforeFilter(){
		parent::beforeFilter();

		//Administrator
		if( eregi("webadm_",$this->action) ){
			$this->set('title_for_layout','게시판 관리');
			$this->set("boards", $this->BoardSetup->find('all',array(
				'conditions'=>array('deleted'=>null),
				'fields'=>array('bid','bname')
				)));			
		}else{

		}

	}
	
	function __write_cache($bid){
		Cache::write('board.setup.'.$bid,$this->BoardSetup->getSetup($bid));
	}

	function webadm_index(){
		$rows = $this->BoardSetup->find('all',array('conditions'=>array('deleted'=>null)));
		$this->set("bsetup",$rows);
	}
	


	function webadm_add(){
		if( empty($this->data) ){

		}else{
			if( $this->BoardSetup->save($this->data) ){
				$this->__write_cache($this->data['BoardSetup']['bid']);
				$this->Session->setFlash("추가 되었습니다.");
				$this->redirect(array('action'=>'index'));
			}
		}

		$this->render('webadm_add');

	}


	function webadm_edit($bid){
	
		$this->set("bid",$bid);

		if( empty($this->data) ){
			$this->data = $this->BoardSetup->read(null,$bid);
		}else{

			if( $this->BoardSetup->save($this->data) ){
				$this->Session->setFlash("수정 되었습니다.");
				$this->__write_cache($bid);
				$this->redirect(array('action'=>'edit',$bid));
			}else{
				$errors = $this->BoardSetup->invalidFields();			
//				debug($errors);
			}
		}

		$this->render('webadm_setup');

	}

	
	/***
	 * Description : 스킨정보 수정
	 */
	function webadm_edit_skin($bid){

		$this->set("bid",$bid);

		if( empty($this->data) ){
			

			$folder = new Folder(ROOT.DS.'plugins'.DS.'board'.DS.'views'.DS."board".DS."skins".DS);

			$folderlist = $folder->read(true,false,true);
			$SKINS = array();
			foreach($folderlist[0] as $_folder){
				if( !empty($_folder) ){

					$file = new File($_folder.DS."index.xml");
					if( $file->exists() ){
						$xml = new XML();
						$xml->load($file->read());
						$_skin = $xml->toArray();

						$SKINS[] = $_skin['Skin'];
					}
				}
			}

			$this->set("skins",$SKINS);


			//buttons
			$folder = new Folder(ROOT.DS.'plugins'.DS."board".DS.'webroot'.DS."img".DS.'buttons');

			$folderlist = $folder->read(true,false,true);

			$BUTTONS = array();
			foreach($folderlist[0] as $_folder){
				if( !empty($_folder) ){

					$file = new File($_folder.DS."index.xml");
					if( $file->exists() ){
						$xml = new XML();
						$xml->load($file->read());
						$_button = $xml->toArray();

						$BUTTONS[] = $_button['Button'];
					}
				}
			}

			$this->set("buttons",$BUTTONS);


			//icons
			$folder = new Folder(ROOT.DS.'plugins'.DS."board".DS.'webroot'.DS."img".DS.'icons');

			$folderlist = $folder->read(true,false,true);

			$ICONS = array();
			foreach($folderlist[0] as $_folder){
				if( !empty($_folder) ){

					$file = new File($_folder.DS."index.xml");
					if( $file->exists() ){
						$xml = new XML();
						$xml->load($file->read());
						$_icon = $xml->toArray();

						$ICONS[] = $_icon['Icon'];
					}
				}
			}

			$this->set("icons",$ICONS);


			//file extensions
			$folder = new Folder(ROOT.DS.'plugins'.DS."board".DS.'webroot'.DS."img".DS.'exts');

			$folderlist = $folder->read(true,false,true);

			$EXTS = array();
			foreach($folderlist[0] as $_folder){
				if( !empty($_folder) ){

					$file = new File($_folder.DS."index.xml");
					if( $file->exists() ){
						$xml = new XML();
						$xml->load($file->read());
						$_ext = $xml->toArray();

						$EXTS[] = $_ext['Ext'];
					}
				}
			}

			$this->set("exts",$EXTS);

			$this->data = $this->BoardSetup->find('first',array('conditions'=>array('bid'=>$bid)));

		}else{
			if( $this->BoardSetup->save($this->data) ){
				$this->Session->setFlash("수정되었습니다.");
				$this->__write_cache($bid);				
				$this->redirect(array('action'=>'edit_skin',$bid));
			}
		}
		$this->render('webadm_setup_skin');
	}

	/***
	 * Description : 레벨정보 수정
	 */
	function webadm_edit_level($bid){
		$this->set("bid",$bid);

		if( empty($this->data) ){

			$this->data = $this->BoardSetup->find('first',array('conditions'=>array('bid'=>$bid)));
			
			$bname = $this->data['BoardSetup']['bname'];
			$this->data['BoardSetup'] = unserialize($this->data['BoardSetup']['auth_level']);
			$this->data['BoardSetup']['bid'] = $bid;
			$this->data['BoardSetup']['bname'] = $bname;

		}else{
			$this->data['BoardSetup']['bid'] = $bid;

			
			$data = $this->data['BoardSetup'];
			unset($data['bname']);
			$this->data['BoardSetup']['auth_level'] = serialize($data);

			if( $this->BoardSetup->save($this->data) ){
				$this->Session->setFlash("수정되었습니다.");
				$this->__write_cache($bid);				
			}else{
				$this->Session->setFlash("수정 할 수 없습니다.");
			}



			$this->redirect(array('action'=>$this->action,$bid));
		}
		$this->render('webadm_setup_level');
	}



	/***
	 * Description : 필터링
	 */
	function webadm_edit_filter($bid){

		$this->set("bid",$bid);

		if( empty($this->data) ){

			$this->data = $this->BoardSetup->find('first',array('conditions'=>array('bid'=>$bid)));

		}else{

			if( $this->BoardSetup->save($this->data) ){
				$this->Session->setFlash("수정되었습니다.");
				$this->__write_cache($bid);				
				$this->redirect(array('action'=>$this->action,$bid));
			}
		}
		$this->render('webadm_setup_filter');
	}


	/***
	 * Description : 
	 */
	function webadm_edit_category($bid){

		$this->set("bid",$bid);

		$categorys = $this->BoardCategory->generatetreelist(array('bid'=>$bid), null, null, '━');


		if( empty($this->data) ){
			$this->data['BoardSetup']['bid'] = $bid;
			$this->data['BoardCategory']['bid'] = $bid;

		}else{

			if( "delete" == $this->data['BoardCategory']['action'] ){
				$this->BoardCategory->id = $this->data['BoardCategory']['id'];
				if( $this->BoardCategory->delete() ){
					$this->Session->setFlash("삭제 되었습니다.");
					Cache::write('board.categories.'.$bid,$this->BoardCategory->generatetreelist(array('bid'=>$bid), null, null, '━'));
					$this->redirect(array('action'=>$this->action,$bid));
				}else{

				}
			}else{

				if( $this->BoardCategory->save($this->data) ){
					$this->Session->setFlash("등록 되었습니다.");
					Cache::write('board.categories.'.$bid,$this->BoardCategory->generatetreelist(array('bid'=>$bid), null, null, '━'));
					$this->redirect(array('action'=>$this->action,$bid));
				}else{

				}
			}
		}

		$this->set(compact("categorys"));
		$this->render('webadm_setup_category');
	}



	function webadm_category_movedown($bid,$id= null, $delta = null){
		if ($delta > 0) {
			$this->BoardCategory->moveDown($id, abs($delta));
			Cache::write('board.categories.'.$bid,$this->BoardCategory->generatetreelist(array('bid'=>$bid), null, null, '━'));			
		} else {
			$this->Session->setFlash('Please provide a number of positions the category should be moved up.');
		}

		$this->redirect(array('action' => 'edit_category',$bid), null, true);
	}


	function webadm_category_moveup($bid, $id= null, $delta = null){
	
		if ($delta > 0) {
			$this->BoardCategory->moveup($id, abs($delta));
			Cache::write('board.categories.'.$bid,$this->BoardCategory->generatetreelist(array('bid'=>$bid), null, null, '━'));			
		} else {
			$this->Session->setFlash('Please provide a number of positions the category should be moved up.');
		}

		$this->redirect(array('action' => 'edit_category',$bid), null, true);
	}


}//end of class
?>