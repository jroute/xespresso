<?php
class CommentController extends CommentAppController {
	var $name = 'Comment';

	var $components = array('Session','Email','Crypter');
	var $uses = array(
		'Users.UserGroup',	
		'Users.User',
		'Fileattach.Fileattach',
		'Comment.Comment'
	);
	var $helpers = array('Editor');

	var $paginate = array('limit'=>10,'order' => array('created' => 'DESC'));

	var $version = '1.0.0';

	function beforeFilter(){
		parent::beforeFilter();

		$this->set('version',$this->version);

    // load the config file
    $this->__loadConfig($this->params['controller'],'default');
    
    
		if( eregi("webadm_",$this->action) ){

		}else{


		}
		
		$this->Comment->validate = array(
									'model' => array('rule' => 'notEmpty','required' => true),	
									'model_key' => array('rule' => 'notEmpty','required' => true),									
									'model_id' => array('rule' => 'notEmpty','required' => true),									
									'name'=>array(
										'rule'=>'notEmpty', 
										'required'=>true, 
										'message'=>__('Please enter your name.',true)
									),
									'email'=>array('rule'=>'email', 'allowEmpty'=>true,'message'=>__('Invalid email format.',true)),
									'homepage'=>array('rule' => 'url', 'allowEmpty'=>true,'message'=>__('Invalid website format.',true)),
									'passwd' => array('rule'=>'notEmpty', 'required' => true,'message'=>__('Please enter your password.',true)),
									'comment' => array('rule'=>'notEmpty', 'required' => true,'message'=>__('Please write a comment.',true))
									);		

	}


	function get_conditions($cond){
		$keyword = @$this->passedArgs['keyword'];
		$keyword = str_replace(array("'"),"",$keyword);
		$su = @$this->passedArgs['su'];
		$sn = @$this->passedArgs['sn'];

		$conditions = array('AND'=>array(1));

		if( $keyword ){
			$condition = array();
			if( $sn ) array_push($condition,array('Comment.name LIKE'=>"$keyword%"));

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
	
	/**
	* element
	*/
	function latest()
	{
		$this->autoRender = false;	
		
		$limit = $this->params['limit'];
		$length = @$this->params['length'];

		$rows =  $this->Comment->latest($limit,$length);	
		
		if( $this->params['requested'] ){
			return $rows;
		}else{
			$this->set('rows',$rows);		
		}
	}
		
	function index(){
		$this->redirect(array('action'=>'view'));
	}
	
	//requestAction
	function lst($model,$id){
	
		$this->autoRender = false;
		$rows = $this->Comment->find('all',array('conditions'=>array(
		'Comment.deleted'=>null,
		'Comment.model'=>$model,
		'Comment.model_id'=>$id),'order'=>array('Comment.created'=>'asc')));
		
		$data=array();
		foreach($rows as $i=>$row){
			$data[$i] = $row;
			@$data[$i]['Comment']['crypt_userid'] = $this->Crypter->encrypt($row['Comment']['userid'].'⇋'.time().'⇋'.$data['Comment']['no']);
		}
		
		return $data;
	}
	
	/**
	* 댓글 등록시 메일 발송
	*
	*/
	function __sendmail($from_name,$from_email,$to_name,$to_email,$subject,$comment,$return_url)
	{
		if( trim($to_email) == '' ) return false;
		
		$this->Email->to = $to_email;
		$this->Email->bcc = array($this->site['mailing_email']);
		$this->Email->subject = $subject;
		$this->Email->replyTo = $this->site['mailing_email'];
		$this->Email->from = $this->site['mailing_name'].' <'.$this->site['mailing_email'].'>';
		$this->Email->template = 'comment_message'; // note no '.ctp'
		//Send as 'html', 'text' or 'both' (default is 'text')
		$this->Email->sendAs = 'both'; // because we like to send pretty mail
		//Set view variables as normal
		$this->set('from_name', $from_name);
		$this->set('from_email', $from_email);
				
		$this->set('to_name', $to_name);
		$this->set('to_email', $to_email);
		$this->set('return_url', $return_url);
		$this->set('comment', $comment);	
		//Do not pass any args to send()
		$this->Email->send();
		return true;
	}
	
	
	function __updateCommentTotalCount($model,$key,$id)
	{

		if( Configure::read('Comment.updateToModel') ){
		
	    $modelInstance = ClassRegistry::init($model);

	    $modelInstance->id = $id;
      // save rating values
      if ($modelInstance->exists() && Configure::read('Comment.modelTotalField') ) {
      	$total = $this->Comment->find('count',array('conditions'=>array('Comment.deleted'=>null,'Comment.model'=>$model,'Comment.model_key'=>$key,'Comment.model_id'=>$id)));
        $modelInstance->saveField(Configure::read('Comment.modelTotalField'), $total);
      }
    }	
	}
	
	function save($model,$key,$id,$captcha=null, $redirect){
		if( empty($this->data) ){
		
		}else{
		
		
			//add 2011-02-01 captcha
			if( $captcha && !ereg("webadm_",$this->action) ){

				$this->Comment->validate = Set::merge($this->Comment->validate, array(
					'captcha'=>array(
					'required'=>true,
					'minLength'=>6,
					'rule'=>'compcaptcha',
					'message'=>__('Invalid captcha.',true)
					)
				));
			}

					
			$this->data['Comment']['model'] = $model;
			$this->data['Comment']['model_key'] = $key;			
			$this->data['Comment']['model_id'] = $id;
			if( $this->Session->read('User.userid') ){
				$this->data['Comment']['userid'] = $this->Session->read('User.userid');
				$this->data['Comment']['name'] = $this->Session->read('User.name');
				$this->data['Comment']['email'] = $this->Session->read('User.email');
			}elseif( $this->Session->read('Admin.userid') ){
				$this->data['Comment']['userid'] = $this->Session->read('Admin.userid');			
				$this->data['Comment']['name'] = $this->Session->read('Admin.name');
				$this->data['Comment']['email'] = $this->Session->read('Admin.email');				
			}
			if( $this->data['Comment']['passwd'] ){
				$this->data['Comment']['passwd'] = Security::hash($this->data['Comment']['passwd'],'md5',true);
			}
			$this->data['Comment']['ip'] = $_SERVER['REMOTE_ADDR'];			
						
			if( $this->Comment->save($this->data) ){
			
				$mailto = unserialize(base64_decode($this->data['Comment']['mailto']));

				$this->__sendmail($this->data['Comment']['name'],$this->data['Comment']['email'],$mailto['name'],$mailto['email'],$mailto['subject'],$this->data['Comment']['comment'],$mailto['return_url']);
				
				$this->__updateCommentTotalCount($model,$key,$id);

				$this->SessionAlert(__('Comment have been registered.',true));	
				
			}else{
			
				$errors = $this->Comment->invalidFields(); 
				$this->SessionAlert(__("[Alert] Check the following items",true)."\\n\\n".@implode("\\n",$errors));
				
			}

			$this->redirect(base64_decode($redirect));		
		}
	}//end of fucntion save


	function delete($model,$key,$id,$no=0,$redirect=null){ // Lw==  --> /
	
		$error = false;	
		$authority = false;
		
		if( (int)$this->Session->Read('User.level') >= $this->webadm_allow_level ){
			$authority = true;				
		}

		$this->set('authority',$authority);
		$this->set('redirect',base64_decode($redirect));
				
		if( empty($this->data) ){
		
			$this->data = $this->Comment->find('first',array('conditions'=>array(
								'Comment.deleted'=>null,
								'Comment.model'=>$model,
								'Comment.model_key'=>$key,								
								'Comment.model_id'=>$id,
								'Comment.no'=>$no																
								)));
								
			unset($this->data['Comment']['passwd']);
			
		}else{

			$data = $this->Comment->find('first',array('conditions'=>array(
								'Comment.deleted'=>null,
								'Comment.model'=>$model,
								'Comment.model_key'=>$key,								
								'Comment.model_id'=>$id,
								'Comment.no'=>$this->data['Comment']['no']																
								)));

			$passwd = Security::hash($this->data['Comment']['passwd'],'md5',true);								
			if( $passwd == $data['Comment']['passwd'] || (int)$this->Session->Read('Admin.level') >= $this->webadm_allow_level || (int)$this->Session->Read('User.level') >= $this->webadm_allow_level){
				
				if( $this->Comment->del($this->data['Comment']['no']) ){
				
					$this->__updateCommentTotalCount($model,$key,$id);				
					
					$this->SessionAlert(__('Comment has been deleted.',true));
				}else{
					$this->SessionAlert(__('[Error] Can not be deleted.',true));
				}
				
				if( $redirect ){
					$this->redirect(base64_decode($redirect));
				}else{
					$this->redirect(array('action'=>'delete',$model,$id,$no));							
				}
			}else{
				$error = true;
			}


		}
		
		$this->set('error',$error);		
	}


	function webadm_index($w='time'){
		$this->set("datas",$this->paginate('Comment'));			
	}


	function webadm_add(){
		
		if( empty($this->data) ){

			$this->data['Comment']['sdate'] = date('Y-m-d 00:00');
			$this->data['Comment']['edate'] = date('Y-m-d 00:00');

			$this->data['Comment']['dimensions'] = '0,0,300,400';

			$this->data['Comment']['scrollbars'] = '0';
			$this->data['Comment']['state'] = 'N';
		}else{
			if( $this->Comment->save($this->data) ){

				$this->Session->setFlash('추가 되었습니다.');
				$this->redirect(array('action'=>'index'));
			}
		}
		$this->render('webadm_form');
	}


	function webadm_edit($id){

		if( empty($this->data) ){
			$this->data = $this->Comment->Read(null,$id);
			
		}else{
			if( $this->Comment->save($this->data) ){
				$this->Session->setFlash('수정 되었습니다.');
				$this->redirect(array('action'=>'index'));
			}
		}

		$this->render('webadm_form');
	}

	function webadm_delete($id){
		$this->Comment->id = $id;
		if( $this->Comment->delete() ){

			$this->Session->setFlash('삭제 되었습니다.');
			$this->redirect(array('action'=>'index'));
		}else{
			$this->Session->setFlash('삭제 실패');
			$this->redirect(array('action'=>'index'));
		}
	}


}

