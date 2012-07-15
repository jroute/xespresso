<?php

App::import('Vendor', 'JSON',array('file'=>'JSON.php'));

class MenusController extends MenusAppController {

	var $name = "Menus";

	var $components = array('Session');
	var $uses = array(
				'Menus.Menu',
				'Board.BoardSetup',
				'Contents.Content',
				'Poll.PollSetup'
			);
	var $helpers = array('Tree');

	var $Modules;

	/***
	 *
	 */
	function beforeFilter(){

		parent::beforeFilter();


		if( eregi("webadm_",$this->action) ) {
			$this->pageTitle = "메뉴관리";
			//모듈 로드
			$this->Modules = $this->Menu->loadModule();
		}


	}

	function sub($id=null){
        if( empty($id) ) $this->redirect('/');
		$this->Menu->id = $id;
		$data = $this->Menu->find('first');


		if( $data['Menu']['link'] ){
			if( $this->lang == '' || $this->lang != 'kr' ){
				$this->redirect('/'.$this->lang.'/'.$data['Menu']['link'].'/'.$data['Menu']['key'].$data['Menu']['pass']);
			}else{
				$this->redirect('/'.$data['Menu']['link'].'/'.$data['Menu']['key'].$data['Menu']['pass']);
			}
		}else{
			return $this->flash("연결된 메뉴정보가 없습니다.","/");
		}
	}

	function webadm_sub($id){

		$data = $this->Menu->Read(null,$id);

		if( $data['Menu']['link'] ){

			$data['Menu']['link'] = str_replace('/view','/edit',$data['Menu']['link']);

			$this->redirect('/webadm/'.$data['Menu']['link'].'/'.$data['Menu']['key'].$data['Menu']['pass']);
		}else{
			return $this->flash("연결된 메뉴정보가 없습니다.","/webadm");
		}
	}


	/***
	 *
	 * @return :	json
	 */
	function webadm_ajax_options($id){
		Configure::write('debug',0);
		$this->autoRender = false;

		$json = new Services_JSON();

		$data = $this->Menu->Read(null,$id);
		echo $json->encode($data);
	}


    /***
     *
     *
     * desc : 머리글 / 바닥글 설정
     */
    function webadm_html($lang='kr',$id=null){
			Configure::write('debug',0);
			
			$this->set("lang",$lang);

      $parent_id = null;
      if( $id ) $parent_id = $this->Menu->getparentnode($id);

			$categories = $this->Menu->generatetreelist(array('lang'=>$lang), null, null, '━');
			$this->set(compact("categories"));
      $this->set('id',$id);
      $this->set('parent_id',$parent_id);

      if( empty($this->data) ){

      }else{
					$this->Menu->validate = array();//validate clear;
          if( $this->Menu->save($this->data)){

						$data = array_shift($this->Menu->find('first',array('id'=>$this->data['Menu']['id'])));

						if( $data['model'] && $data['key'] ){
							Cache::write($data['model'].'-submenus-'.$data['key'] , $this->Menu->getSubMenus($data['model'],$data['key']));
							Cache::write($data['model'].'-submenu-'.$data['key'] , $this->Menu->getSubFile('BoardSetup',$data['key']));
						}


						echo "success";
          }else{
						echo "failure";
					}
					exit;
      }
    }
	/***
	 *
	 */
	function webadm_index($lang='kr',$parentid=null){

		$this->set("lang",$lang);

		$categories = $this->Menu->generatetreegrouped();

		$this->set(compact("categories",'parentid'));

		$submenus = $this->Menu->loadSubMenu();

		$modules = array();
		foreach($this->Modules as $key=>$module){

			if( !in_array($module['model'], $this->uses) ) {
				return $this->flash($module['model']." 모듈을 로드 할 수 없습니다.<br /><br /> menus_controller 에 등록해주세요",'/');
			}else{
				if( strpos($module['model'],'.') === false ){
					$rows = $this->{$module['model']}->find('list',array('fields'=>$module['fields'],'recursive'=>0));				
				}else{
					list(,$model) = explode('.',$module['model']);
					$rows = $this->{$model}->find('list',array('fields'=>$module['fields'],'recursive'=>0));
				}

				$modules[$key]['plugin']				= $module['plugin'];
				$modules[$key]['name']				= $module['name'];
				$modules[$key]['model']				= $module['model'];
				$modules[$key]['controller']	= $module['controller'];
				$modules[$key]['action']			= $module['action'];
				$modules[$key]['key']					= $module['primaryKey'];
				$modules[$key]['data']				= $rows;

			}
		}

		$this->set(compact('modules','submenus'));




		if( empty($this->data) ){

		}else{

			if( "delete" == $this->data['Menu']['method'] ){
				if( $this->Menu->delete($this->data['Menu']['id']) ){
					$this->Session->setFlash("삭제 되었습니다.");
					$this->redirect(array('action'=>'index'));
				}else{

				}
			}else{

				if( $model = $this->data['Menu']['model'] ){
					@$this->data['Menu']['key']	= @$this->data[$model]['key'];
				}

				if( $this->Menu->save($this->data) ){
					$this->redirect(array('action'=>'index',$lang,@$this->data['Menu']['parent_id']));
				}else{

				}
			}
		}

	}


	/***
	 *
	 */
	function webadm_sitemap($lang='kr'){

		$this->set("lang",$lang);

		$categories = $this->Menu->generatetreelist(array('lang'=>$lang), null, null, '━');

		foreach($categories as $id=>$name){

			$data = $this->Menu->read(null,$id);
			$categories[$id] = array_shift($data);
			$categories[$id]['name'] = $name;
		}


		$this->set(compact("categories"));

	}


	function webadm_movedown($id= null, $delta = null){
		if ($delta > 0) {
			$this->Menu->moveDown($id, abs($delta));
		} else {
			$this->Session->setFlash('Please provide a number of positions the category should be moved up.');
		}

		$this->redirect(array('action' => 'index'), null, true);
	}


	function webadm_moveUp($id= null, $delta = null){
		if ($delta > 0) {
			$this->Menu->moveup($id, abs($delta));
		} else {
			$this->Session->setFlash('Please provide a number of positions the category should be moved up.');
		}

		$this->redirect(array('action' => 'index'), null, true);
	}


	function webadm_jstree_move()
	{
		$this->autoRender = false;
		$data['Menu']['parent_id'] = (int)$_POST['id'];
		$data['Menu']['name'] = $_POST['title'];		
		$this->Menu->save($data);	
		$id = $this->Menu->getInsertID();
		$result = array('status'=>1,'id'=>$id);
		return json_encode($result);
	}
	
	function webadm_jstree_create()
	{
		$this->autoRender = false;
		$data['Menu']['parent_id'] = (int)$_POST['id'];
		$data['Menu']['name'] = $_POST['title'];		
		$this->Menu->save($data);	
		$id = $this->Menu->getInsertID();
		$result = array('status'=>1,'id'=>$id);
		return json_encode($result);
	}
	
	function webadm_jstree_rename()
	{
		$this->autoRender = false;
		$this->Menu->id = (int)$_POST['id'];
		$this->Menu->save(array('name'=>$_POST['title']));	

		$result = array('status'=>1);
		return json_encode($result);
	}

	function webadm_get_children($id=null)
	{
			$this->autoRender = false;
			
			$data = $_GET;
			
			if( @(int)$data["id"] == '' ) @(int)$data["id"] = 1;

      $tmp = $this->Menu->children(@(int)$data["id"], true);
      if( @(int)$data["id"] === 1 && count($tmp) === 0) {
              $tmp = $this->_get_children(@(int)$data["id"]);
      }
      $result = array();
      if(@(int)$data["id"] === 0) return json_encode($result);
      foreach($tmp as $k => $v) {
              $result[] = array(
                      "attr" => array("id" => "node_".$v['Menu']['id'], "rel" => ((int)$v['Menu']['rght'] - (int)$v['Menu']['lft'] > 1) ? "folder" : "default"),
                      "data" => $v['Menu']['name'],
                      "state" => ((int)$v['Menu']['rght'] - (int)$v['Menu']['lft'] > 1) ? "closed" : ""
              );
      }
      return json_encode($result);
	
	}

	/***
	 *
	 */
	function afterFilter(){

	}

}//end of class
?>