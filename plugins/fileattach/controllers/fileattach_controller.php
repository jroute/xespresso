<?php

//Configure::load('Fileattach.fileupload');

class FileattachController extends AppController {

	var $name = "Fileattach";

	var $components = array('Fileattach.Swfupload');
	var $uses = array('Fileattach.Fileattach');
	var $helpers = array();


	/***
	 *
	 */
	function beforeFilter(){

		parent::beforeFilter();

		if( eregi("webadm_",$this->action) ) {

		}		
		
		Configure::write('debug',0);
		$this->autoRender = false;		
	}
	
	function download($id){
		
		set_time_limit(0);
		
				

		$files = $this->Fileattach->Read(null,$id);


		$filepath = APP.'webroot'.DS.'files'.DS.$files['Fileattach']['fsname'];
		
		if( $files['Fileattach']['name'] && file_exists($filepath) ){

			$files['Fileattach']['size'] = filesize($filepath);

			$fp = fopen($filepath, 'rb');
			//ini_set('zlib.output_compression', 'off');
			header('Content-Disposition: attachment; filename="' . $files['Fileattach']['name'] . '"');
			header('Content-Transfer-Encoding: binary');
			header('Last-Modified: ' . date ("F d Y H:i:s.", getlastmod()));
			header('Content-Length: ' . $files['Fileattach']['size']);
			header('Content-Type: ' . getMIMEType($files['Fileattach']['name']));
			header('Cache-Control: private');
			header('Pragma: no-cache'); 
			header('Connection: close');
			fpassthru($fp);
			fclose($fp);
		}else{
			return $this->alert('파일이 존재 하지 않습니다.');
		}	
	}
	

	function init(){


		$this->autoRender = false;
		
		$sessid 		= @$_POST['PHPSESSID'];
		$plugin 		= @$_POST['module'];
		$model 			= @$_POST['model'];		
		$dir 				= @$_POST['dir'];				
		$parent_id	= @(int)$_POST['parent_id'];		
		$sort				= @(int)$this->params['form']['sort'];				

		$this->params['form']['Filedata'] = array_shift($_FILES);


		if (isset($this->params['form']['Filedata'])) {


			if ($this->Swfupload->upload($dir)) {

				// save the file to the db, or do whateve ryou want to do with the data
				$this->params['form']['Filedata']['name'] = $this->Swfupload->filename;
				$this->params['form']['Filedata']['path'] = $this->Swfupload->uploadpath;
				$this->params['form']['Filedata']['fspath'] = $this->Swfupload->uploadpath . $this->Swfupload->savefilename;
				$this->params['form']['Filedata']['type'] = @mime_content_type($this->Swfupload->uploadpath . $this->Swfupload->savefilename);

				$this->data['Fileattach'] = $this->params['form']['Filedata'];

				$this->data['Fileattach']['plugin']				= $plugin;
				$this->data['Fileattach']['model']				= $model;
				$this->data['Fileattach']['parent_id']		= $parent_id;
				$this->data['Fileattach']['fsname']				=	 $this->Swfupload->savefilename;
				$this->data['Fileattach']['session_id']		= isset($this->params['form']['PHPSESSID'])?$this->params['form']['PHPSESSID']:$this->Session->id();
				$this->data['Fileattach']['sort']					= $sort;
				
				
				$this->data['Fileattach']['path'] = str_replace(APP.'webroot'.DS,'',$this->data['Fileattach']['path']);
				$this->data['Fileattach']['fspath'] = str_replace(APP.'webroot'.DS,'',$this->data['Fileattach']['fspath']);				
				
				unset($this->data['Fileattach']['error']);
				unset($this->data['Fileattach']['tmp_name']);


				if( $parent_id!=0 && !empty($sort) ){
					$this->Fileattach->remove(null,$parent_id,$sort);
				}

				if (!($file = $this->Fileattach->save($this->data))){
					echo "({error:'Error Database'})";
				} else {
					header('Content-Type: text/html; charset=utf-8');
					echo "({error:0,id:".$this->Fileattach->getLastInsertId().",name:'".$this->params['form']['Filedata']['name']."',fsname:'".$this->data['Fileattach']['fsname']."',path:'".str_replace(APP.'webroot'.DS,'',$this->params['form']['Filedata']['path'])."',size:".$this->params['form']['Filedata']['size']."})";
				}
			}else{
					echo "({error:'".$this->Swfupload->errorMessage."'})";
			}
		}





	}
		
	function get(){
	
		$sessid = @$_POST['PHPSESSID'];
		$plugin = @$_POST['module'];
		$parent_id = (int)$_POST['parent_id'];		
	
		$conditions = array(
			'Fileattach.deleted'=>null,
			'Fileattach.plugin'=>$plugin
		);
		
		if( $parent_id ){
			$conditions['Fileattach.parent_id'] = $parent_id;
		}else{
			$conditions['Fileattach.session_id']=$sessid;
			$conditions['OR'] = array('parent_id'=>null,'parent_id'=>0);
		}

		
		$rows  = $this->Fileattach->find('all',array('conditions'=>$conditions));
	
		$file = array();
		if( is_array($rows) ){
			foreach($rows as $row){
				$file[] = $row['Fileattach'];
			}
		}

		if( function_exists('json_encode') ){
			print(json_encode($file));
		}else{
			$json = new Services_JSON();
			print($json->encode($file));
		}
	}
	
	
	function delete(){
	
		$id = (int)$_POST['id'];
		
		$path = APP.'webroot'.DS;
		
		if( $id ){
			$rows = $this->Fileattach->find('all',array('conditions'=>array('deleted'=>null,'id'=>$id)));
			foreach($rows as $row){	
				@unlink($path.$row['Fileattach']['fspath']);	
				$this->Fileattach->delete($row['Fileattach']['id']);
			}
			echo "ok";
		}else{
			echo "fial";
		}
	}

	
	/***
	*
	*
	***/
	function expose($id,$pid=null){
		
		if( $id ){
			if( $pid ){
				$this->Fileattach->query("update ".$this->Fileattach->tablePrefix.$this->Fileattach->table." set expose='0' where parent_id=".$pid);
			}else{
				$this->Fileattach->query("update ".$this->Fileattach->tablePrefix.$this->Fileattach->table." set expose='0' where session_id='".$this->Session->id()."'");			
			}

			$this->Fileattach->query("update ".$this->Fileattach->tablePrefix.$this->Fileattach->table." set expose='1' where id=".$id);
			echo 'success';
		}else{
			echo 'failure';
		}
	}
		


}//end of class
?>