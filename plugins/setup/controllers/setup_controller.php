<?php

uses("File","Folder");

class SetupController extends AppController {

	var $name = "Setup";

	var $components = array('Image');
	var $uses = array('Setup.Setup');
	var $helpers = array();

	/***
	 *
	 */
	function beforeFilter(){

		parent::beforeFilter();

		$this->set('title_for_layout','설정');
		
		$this->set('levels',$this->Setup->default_levels);
		$this->set('default_levels',$this->Setup->default_levels);		
	}

	
	/***
	 *
	 */
	function index(){
		//empty
	}

	function webadm_index($id=1){

		if( empty($this->data) ){
		
			$settings = $this->Setup->Read(null,$id);
			$this->data['Site'] = @unserialize($settings['Setup']['site']);
			

			$this->data['Level'] = @unserialize($settings['Setup']['level']);			
		}else{

		}

		//$this->resizeImage('resizeCrop', $tempuploaddir, $filename, $smalluploaddir, $filename, $thumbscalew, $thumbscaleh, 75);
	}
	
	//사이트 설정
	function webadm_site($id=1){
		
			$set = $this->data['Site'];
			
			
			$tmp = $this->Setup->Read(null,$id);
			$old = unserialize($tmp['Setup']['site']);
			
			if( @$this->data['Site']['logo']['tmp_name'] ){
			
				$ext = substr($this->data['Site']['logo']['name'],strrpos($this->data['Site']['logo']['name'],'.'));
				$upload_dir = APP.'webroot'.DS.'files';
				$logo_name = 'logo'.$id.$ext;
				$tmp_name = $this->data['Site']['logo']['name'];
				$upload_image = $upload_dir.DS.$tmp_name;

				if (!($moved = move_uploaded_file($this->data['Site']['logo']['tmp_name'], $upload_image)) ){
					$this->Session->setFlash('로고파일 업로드 실패.');
					$this->redirect(array('action'=>'index'));
				}

				$file = new File(APP.'webroot'.DS.'files'.DS.$logo_name);
				
				if( $file->exists( ) ) $file->delete();				
				$this->Image->resizeImage('resizeCrop', $upload_dir, $tmp_name, $upload_dir, $logo_name, 200, 50, 75);			
				if( file_exists($upload_image) ) @unlink($upload_image);
				
				$set['logo'] = '/files/'.$logo_name;
			}else{
				if( @$old['logo'] ){
					$set['logo'] = $old['logo'];				
				}else{
					$set['logo'] = '/files/logo.png';
				}
			}


			$data['Setup']['id'] = $id;
			$data['Setup']['site'] = @serialize($set);
			
			if( $this->Setup->save($data) ){
				$this->Session->setFlash("사이트 정보가 저장되었습니다.");
			}	
			$this->redirect(array('action'=>'index'));			
	}
	
	//그룹 설정
	function webadm_group($id=1){
	
	}
	
	//권한 설정
	function webadm_level($id=1){


			$data['Setup']['id'] = $id;
			$data['Setup']['level'] = serialize($this->data['Level']);
			
			if( $this->Setup->save($data) ){
				$this->Session->setFlash("권한 정보가 저장되었습니다.");
			}
			
			$this->redirect(array('action'=>'index'));			
			
	}		

}//end of class
?>