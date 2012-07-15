<?php
class SloganController extends AppController {

	var $name = "Slogan";
	var $uses = array('Slogan.Slogan');
	var $components = array();



	/***
	*
	*
	*/	
	function beforeFilter(){
		parent::beforeFilter();
		$this->set('title_for_layout','연구개발특구 포스터&amp;슬로건 공모전');
	}
	
	
	/***
	*
	*
	*/
	function index(){
		Configure::write('debug',0);
		$this->layout = 'default';
		
		
		if( empty($this->data)){
			
		}else{
		
			if( $this->Slogan->save($this->data) ){
				header('Content-type:text/html; charset=utf-8');
				echo "<script type='text/javascript'>";
				echo 'alert("정상적으로 응모되셨습니다.");';
				echo 'self.close();';
//				echo ' window.location.href = "http://ddi.or.kr/kor/popup/popup20110513.jsp";';	
				echo '</script>';
				exit;
			}else{
			
			}
		}
	}
	

	function result(){
		Configure::write('debug',0);
		$this->layout = 'default';
		
		if( $this->Session->read('slogan') == 'ok' ){
			
			$rows = $this->Slogan->find('all',array('conditions'=>array('deleted'=>null),'order'=>array('id'=>'desc')));
			$this->set('rows',$rows);
		
			$this->render('result');		
		}else{
			if( empty($this->data)){
				$this->render('login');				
			}else{
				if($this->data['Auth']['passwd'] == 'ddislogan' ){
					$this->Session->write('slogan','ok');
					$this->redirect(array('action'=>'result'));
				}else{
					$this->SessionAlert('비밀번호를 확인하세요');
					$this->redirect(array('action'=>'result'));				
				}
			}
		}
		
	
	}
	
	
	function xlsdown(){
		Configure::write('debug',0);
		$this->layout = null;
		
		if( $this->Session->read('slogan') != 'ok' ){
			$this->redirect(array('action'=>'result'));
		}
		
		
			$filename = "포스터&슬로건 공모전-".date('Ymd').'.xls';
		

			//ini_set('zlib.output_compression', 'off');
			if( ereg('MSIE',$_SERVER['HTTP_USER_AGENT']) ){			
				header('Content-Disposition: attachment; filename="' . urlencode($filename) . '"');
			}else{
				header('Content-Disposition: attachment; filename="' . $filename . '"');			
			}
			header('Content-Transfer-Encoding: binary');
			header('Last-Modified: ' . date ("F d Y H:i:s.", getlastmod()));
			header('Cache-Control: private');
			header('Pragma: no-cache'); 
			header('Connection: close');		
		
			$rows = $this->Slogan->find('all',array('conditions'=>array('deleted'=>null),'order'=>array('id'=>'desc')));
			$this->set('rows',$rows);
		
			$this->render('xlsdown');		
			
	}
	
	function delete($id){
		Configure::write('debug',2);
		
		if( $this->Session->read('slogan') != 'ok' ){
			$this->redirect(array('action'=>'result'));
		}
		
		if( $this->Slogan->del($id)){
			$this->SessionAlert('삭제되었습니다.');
			$this->redirect(array('action'=>'result'));
		}
		
			
	}
	
}