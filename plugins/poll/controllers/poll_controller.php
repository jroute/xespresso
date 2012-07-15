<?php
class PollController extends AppController {

	var $name = "Poll";

	var $components = array('Session');
	var $uses = Array(
			'Poll.PollSetup',
			'Poll.PollQuestion',
			'Poll.PollItem',
			'Poll.PollAnswer');
			
	var $helpers = array('Ajax', "Form");

	var $paginate = array(
			'PollSetup'=>array(
					'conditions'=>array('deleted'=>null),
					'order'=>array('created'=>'desc'),
					'limit' => 10
			)
	);

			


	function beforeFilter(){

		parent::beforeFilter();

		if( eregi("webadm_",$this->action) ){

		}else{
		

				//set submenu
				$pass = @$this->params['pass'][0];
				$cachekey = $this->params['controller'].'-submenu';
				if( Cache::read($cachekey) == false ){
					$submenus = $this->Menu->getSubMenus($this->params['controller'],null,null);
					$this->set('submenus', $submenus);
					Cache::write($cachekey, $submenus);
				}else{
					$submenus = Cache::read($cachekey);
					$this->set('submenus',$submenus);
				}
				
				$this->set('navigation_for_layout',$submenus['current']['html_header']);
	
				$cachekey = $this->params['controller'].'-submenu-';
				if( Cache::read($cachekey) == false ){
					$submenu = $this->Menu->getSubFile($this->params['controller'],null,null);
					$this->set('submenu', $submenu);
					Cache::write($cachekey,$submenu);
				}else{
					$this->set('submenu',Cache::read($cachekey));
				}

			$this->set('skin_header',@$skin_header);
			$this->set('skin_footer',@$skin_footer);							
		}





	}

	function vote($pid){

		Configure::write('debug',0);

		$this->autoRender = false;


		$QDATA = $this->PollQuestion->find('all',array('conditions'=>array('poll_id'=>$pid)));


		$data['PollAnswer']['id'] = null;
		$data['PollAnswer']['poll_id'] = $pid;
		$data['PollAnswer']['userid'] = $this->Session->Read('User.userid');
		$data['PollAnswer']['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['PollAnswer']['agent'] = $_SERVER['HTTP_USER_AGENT'];
		
		//마감체크
		$setup = $this->PollSetup->Read(null,$pid);

		if( $setup['PollSetup']['open'] == 'N' ){
				echo '본 설문은 비공개 설문이므로 참여 하실 수 없습니다.';
				exit;
		}

		if( $setup['PollSetup']['edate'] < date('Y-m-d H:i:s') ){
				echo '설문이 종료되어 참여 하실 수 없습니다.';
				exit;
		}

		//중복 참여 체크
		if( $userid = $this->Session->Read('User.userid') ){
			$chk = $this->PollAnswer->find('count',array('conditions'=>array('userid'=>$userid,'poll_id'=>$pid)));
			if( $chk > 0 ){
				echo $this->Session->Read('User.name').'님께서는 이미 참여하셨습니다.';
				exit;
			}
		}else{
			$chk = $this->PollAnswer->find('count',array('conditions'=>array('ip'=>$_SERVER['REMOTE_ADDR'],'agent'=>$_SERVER['HTTP_USER_AGENT'],'poll_id'=>$pid)));
			if( $chk > 0 ){
				echo '이미 참여하셨습니다.';
				exit;
			}
		}

		foreach($QDATA as $key=>$tmp){

			$qdata = array_shift($tmp);
			

			$data['PollAnswer']['question_id'] = $qdata['id'];
	
			if( $qdata['type'] == 'S' ){//주관식

				$data['PollAnswer']['id'] = null;
				$data['PollAnswer']['item_id'] = null;
				$data['PollAnswer']['item_etc'] = $this->data['answer'][$qdata['id']];
				
				if( $this->PollAnswer->save($data) ){
				}else{
					die('error1 : '.$qdata['id']);
				}

			}elseif( $qdata['type'] == 'O' ){//객관식

				if( $qdata['select_type'] == 'M' ){
					foreach(@$this->data['answer'][@$qdata['id']] as $itemid){

						$data['PollAnswer']['id'] = null;
						$data['PollAnswer']['item_id'] = $itemid;
						$data['PollAnswer']['item_etc'] = $this->data['answeretc'][$qdata['id']][$itemid];

						if( $this->PollAnswer->save($data) ){
						}else{
							die('error2 : '.$qdata['id']);
						}
					}//end of foreach;

				}else{

					$data['PollAnswer']['id'] = null;
					$data['PollAnswer']['item_id'] = $this->data['answer'][$qdata['id']];
					$data['PollAnswer']['item_etc'] = @$this->data['answeretc'][$qdata['id']][$this->data['answer'][$qdata['id']]];
					
					if( $this->PollAnswer->save($data) ){
					}else{
						die('error3 : '.$qdata['id']);
					}
				}
			}
			
		}//end of foreach;

		echo "참여해주셔서 감사합니다.";
	}

	function itemetc($poll_id,$qtype,$qid,$iid=null){
		Configure::write('debug',0);
		$this->layout = 'default';
//		$this->autoRender = false;
		
		if( empty($iid) ){
			$this->data = $this->PollAnswer->find('all',array('conditions'=>array('poll_id'=>$poll_id,'question_id'=>$qid)));
		}else{
			$this->data = $this->PollAnswer->find('all',array('conditions'=>array('poll_id'=>$poll_id,'question_id'=>$qid,'item_id'=>$iid)));
		}

		$this->render('itemetc');
	}

	function index(){
			
		$this->data = $this->paginate('PollSetup',array('open'=>'Y'));
	
		foreach($this->data as $i=>$data ){
			//참여자 카운트 ( 해당 설문의 첫번째 질문의 갯수를 가지고 카운트 함 )
			$que = $this->PollQuestion->find('first',array('conditions'=>array('deleted'=>null,'poll_id'=>$data['PollSetup']['id']),'order'=>array('sort'=>'asc')));		
			$this->data[$i]['PollSetup']['persons'] = $this->PollAnswer->find('count',array('conditions'=>array('poll_id'=>$data['PollSetup']['id'],'question_id'=>$que['PollQuestion']['id'])));
		}
		
    $this->render('index');
	}

  function webadm_index(){
		
		$this->data = $this->paginate('PollSetup');
		
		
		foreach($this->data as $i=>$data){
			//참여자 카운트 ( 해당 설문의 첫번째 질문의 갯수를 가지고 카운트 함 )
			$que = $this->PollQuestion->find('first',array('conditions'=>array('deleted'=>null,'poll_id'=>$data['PollSetup']['id']),'order'=>array('sort'=>'asc')));		
			$this->data[$i]['PollSetup']['persons'] = $this->PollAnswer->find('count',array('conditions'=>array('poll_id'=>$data['PollSetup']['id'],'question_id'=>$que['PollQuestion']['id'])));
		}
					
    $this->render('webadm_index');
	}

  function view($id){
		
		$this->data = $this->PollSetup->find('first',array('conditions'=>array('deleted'=>null,'open'=>'Y','id'=>$id)));

		$Questions = $this->PollQuestion->find('all',array('conditions'=>array('deleted'=>null,'poll_id'=>$id),'order'=>array('sort'=>'asc')));

		$this->set('Questions',$Questions);

        $this->render('view');
    }

	function result($id){

		$this->data = $this->PollSetup->read(null,$id);

		$qdatas = $this->PollQuestion->find('all',array('conditions'=>array('deleted'=>null,'poll_id'=>$id)));

		foreach($qdatas as $i=>$qdata){

			if( $qdata['PollQuestion']['type'] == 'O' ){//객관식
				$answer_total = $this->PollAnswer->find('count',array('conditions'=>array('poll_id'=>$id,'question_id'=>$qdata['PollQuestion']['id'])));

				foreach($qdata['PollItem'] as $idx=>$item){
					$qdata['PollItem'][$idx]['total'] = $answer_total;
					$qdata['PollItem'][$idx]['vote'] = $this->PollAnswer->find('count',array('conditions'=>array('poll_id'=>$id,'question_id'=>$qdata['PollQuestion']['id'],'item_id'=>$item['id'])));
				}
				
			}
			$questions[$i] = $qdata;
			

		}

		$this->set('questions',$questions);
	}


    function webadm_view($id){
		
		$this->data = $this->PollSetup->read(null,$id);

		//참여자 카운트 ( 해당 설문의 첫번째 질문의 갯수를 가지고 카운트 함 )
		$que = $this->PollQuestion->find('first',array('conditions'=>array('deleted'=>null,'poll_id'=>$id),'order'=>array('sort'=>'asc')));		
		$this->set('persons',$this->PollAnswer->find('count',array('conditions'=>array('poll_id'=>$id,'question_id'=>$que['PollQuestion']['id']))));
		
			
		$Questions = $this->PollQuestion->find('all',array('conditions'=>array('deleted'=>null,'poll_id'=>$id),'order'=>array('sort'=>'asc')));

		$this->set('Questions',$Questions);

        $this->render('webadm_view');
    }



    function webadm_add(){
        if( empty($this->data) ){
						$this->data['PollSetup']['sdate'] = date('Y-m-d 00:00');
						$this->data['PollSetup']['edate'] = date('Y-m-d 24:00');						
        }else{

	        if( $this->PollSetup->save($this->data)){
	
						$pid = $this->PollSetup->getInsertId();
		

						foreach($this->data['PollQuestion'] as $ques){
		
								unset($data);
								if( !isset($ques['question']) ) continue;
								
								$data['PollQuestion'] = $ques;
								$data['PollQuestion']['id']			= null;
								$data['PollQuestion']['poll_id']	= $pid;

								if( $this->PollQuestion->save($data) ){
									
									$qid = $this->PollQuestion->getInsertId();
									if( isset($ques['items']) && is_array($ques['items']) ){
										foreach( $ques['items'] as $idx=>$item ){
											unset($data);
											if( empty($item) ) continue;
											$data['PollItem']['id'] = null;
											$data['PollItem']['question_id'] = $qid;
											$data['PollItem']['item']			= $item;
											$data['PollItem']['etc']			= ( @$ques['itemetc'][$idx] ) ? "1":"0";
			
											if( $this->PollItem->save($data) ){
			
											}else{
		//										print_r($data);
												die("아이템 등록 실패");
											}
										}//end of foreach
									}
								}else{
		//							print_r($data);
									pr($this->PollQuestion->invalidFields());
									die("질문 등록 실패");
								}
						}//end of foreach
            $this->Session->setFlash('등록되었습니다.');
            $this->redirect(array('action'=>'index'));
           }
        }

		$this->set('Questions',array());
        $this->render('webadm_form');
    }

	function webadm_result($id){

		$this->data = $this->PollSetup->read(null,$id);

		//참여자 카운트 ( 해당 설문의 첫번째 질문의 갯수를 가지고 카운트 함 )
		$que = $this->PollQuestion->find('first',array('conditions'=>array('deleted'=>null,'poll_id'=>$id),'order'=>array('sort'=>'asc')));		
		$this->set('persons',$this->PollAnswer->find('count',array('conditions'=>array('poll_id'=>$id,'question_id'=>$que['PollQuestion']['id']))));

		$qdatas = $this->PollQuestion->find('all',array('conditions'=>array('deleted'=>null,'poll_id'=>$id),'order'=>array('sort'=>'asc')));

		foreach($qdatas as $i=>$qdata){

			if( $qdata['PollQuestion']['type'] == 'O' ){//객관식
				$answer_total = $this->PollAnswer->find('count',array('conditions'=>array('poll_id'=>$id,'question_id'=>$qdata['PollQuestion']['id'])));

				foreach($qdata['PollItem'] as $idx=>$item){
					$qdata['PollItem'][$idx]['total'] = $answer_total;
					$qdata['PollItem'][$idx]['vote'] = $this->PollAnswer->find('count',array('conditions'=>array('poll_id'=>$id,'question_id'=>$qdata['PollQuestion']['id'],'item_id'=>$item['id'])));
				}
				
			}
			$questions[$i] = $qdata;
			

		}

		$this->set('questions',$questions);
	}

	function webadm_itemetc($poll_id,$qtype,$qid,$iid=null){
		$this->layout = null;
		if( empty($iid) ){
			$this->data = $this->PollAnswer->find('all',array('conditions'=>array('poll_id'=>$poll_id,'question_id'=>$qid)));
		}else{
			$this->data = $this->PollAnswer->find('all',array('conditions'=>array('poll_id'=>$poll_id,'question_id'=>$qid,'item_id'=>$iid)));
		}
	}

    function webadm_edit($id){

        if( empty($this->data) ){

            $this->data = $this->PollSetup->read(null,$id);

			$Questions = $this->PollQuestion->find('all',array('conditions'=>array('deleted'=>null,'poll_id'=>$id),'order'=>array('sort'=>'asc')));

			$this->set('Questions',$Questions);

        }else{


//pr($this->data);exit;
	          if( $this->PollSetup->save($this->data)){
	          
	          	//삭제된 질문 삭제 처리
	          	$Q = array();
	          	foreach($this->data['PollQuestion'] as $ques){
	          		if( @$ques['qid'] == '' ) continue;
	          		$Q[] = $ques['qid'];
	          	}
	          	
							$qrows = $this->PollQuestion->find('all',array('conditions'=>array('poll_id'=>$id,'id not in ('.@implode(',',$Q).')')));

							foreach($qrows as $qrow){
								$this->PollQuestion->del($qrow['PollQuestion']['id']);
							}


							foreach($this->data['PollQuestion'] as $ques){
			
									unset($data);
			
									$data['PollQuestion'] = $ques;
									$data['PollQuestion']['id']			= @$ques['qid'];
									$data['PollQuestion']['poll_id']	= $id;
			
									if( $this->PollQuestion->save($data) ){
										
										$qid = $this->PollQuestion->getInsertId();
										
										if( isset($ques['items']) && is_array($ques['items']) ){
										
											//삭제된 아이템 제거
											if( @$ques['qid'] ){
												$item_rows = $this->PollItem->find('all',array('conditions'=>array('question_id'=>@$ques['qid'],'id not in ('.@implode(',',$ques['itemid']).')')));
												foreach($item_rows as $item){
													$this->PollItem->del($item['PollItem']['id']);
												}
											}

										
											foreach( $ques['items'] as $idx=>$item ){
												unset($data);
												if( empty($item) ) continue;
				
				
												if( empty($ques['qid']) ) $ques['qid'] = $this->PollQuestion->getInsertId();
												$data['PollItem']['id']					= @$ques['itemid'][$idx];
												$data['PollItem']['question_id']	=  $ques['qid'];
												$data['PollItem']['item']				= $item;
												$data['PollItem']['etc']				= ( @$ques['itemetc'][$idx] ) ? "1":"0";
				
												if( $this->PollItem->save($data) ){
				
												}else{
													die("아이템 등록 실패");
												}
											}//end of foreach
											
										}
									}else{
										die("질문 등록 실패");
									}
							}//end of foreach
			
              $this->Session->setFlash('수정되었습니다.');
              $this->redirect(array('action'=>'view',$id));
           }
        }
        $this->render('webadm_form');
    }

    function webadm_delete($id){

		if( $this->PollSetup->delete($id) ){
			$this->Session->setFlash("삭제 되었습니다.");
			$this->redirect(array('action'=>'index'));
        }else{
			$this->Session->setFlash("삭제 할 수 없습니다.");
			$this->redirect(array('action'=>'index'));
        }
    }
}//end of class
?>