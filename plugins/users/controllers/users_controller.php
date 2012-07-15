<?php
#	/app/controllers/users_controller.php

class UsersController extends UsersAppController {

	var $name = "Users";

	var $components = array('Auth', 'Openid', 'Image');
	var $uses = Array(
			'Users.UserGroup',	
			'Users.UserGroupSetup',
			'Users.UserHistory',			
			'Users.Company',
			'Users.User',			
			'Logs.Logs'
	);
	
	var $helpers = array('Ajax', "Form");

	var $paginate = array(
				'User'=>array(
					'limit' => 15,
					'order'=>array('User.created'=>'desc')
				),
				'UserHistory'=>array(
					'limit' => 15,
					'order'=>array('UserHistory.created'=>'desc')
				),				
				
			);

	var $OpenIDreturnTo = null;
	var $openid = array('plani.myid.net');

	
	

	function beforeFilter(){

		parent::beforeFilter();

	
    // load the config file
    $this->__loadConfig($this->params['controller'],'default');
    
		$this->OpenIDreturnTo = 'http://'.$_SERVER['SERVER_NAME'].'/webadm/users/openid';

		$this->set('paginate',$this->paginate);
		$this->set('webadm_allow_level',$this->webadm_allow_level);

		if( eregi("webadm_",$this->action) ){
			$this->pageTitle = "회원관리";
			$this->Auth->loginAction = array('plugin' =>'users', 'controller' => 'users', 'action' => 'login');
		}else{
			$submenus['current']['sort'] = 1;
			$submenus['current']['x'] = 7;			
			$this->set('submenus',$submenus);
			$this->set('submenu','submenu_00');
			
		}

		$this->Auth->loginError ='아이디와 비밀번호를 확인 하십시오';
		$this->Auth->authError ='아이디와 비밀번호를 입력하십시오';

		$this->Auth->fields = array(
											'username' => 'userid',
											'password' => 'passwd'
										);

		$this->Auth->autoRedirect = false;
		
		$this->Auth->allow('checklogin','check','login','logout','agree','edit','signup','thank','find','checkid','privacy','spammail','uploadify',
								'webadm_login',
								'webadm_openid',								
								'webadm_logout',
								'webadm_history',								
								'webadm_index');

				
		$skin_header = '';
		$skin_footer = '';

		$this->set('skin_header',$skin_header);
		$this->set('skin_footer',$skin_footer);
		
		

	}
	
	function uploadify()
	{
		Configure::write('debug',0);
		$this->autoRender = false;
		
		if( @$this->params['form']['xdata'] == '' ) return;

		$userid = base64_decode($this->params['form']['xdata']);
		
		$profile_path  = Configure::read('User.profilePath');

		$data = $this->User->Read(array('User.profile','User.created'),$userid);
		
		
		$division = md5(substr($data['User']['created'],0,4));
		
		$base_dir = $profile_path.DS.$division.DS.$userid;
		if( preg_match("/\/$/",WWW_ROOT)){
			$path = substr(WWW_ROOT,0,-1).$base_dir;
		}else{
			$path = WWW_ROOT.$base_dir;
		}

		//create folder		
		$this->Folder = new Folder($path,true,0777);
		
		$ext = $this->Image->getFileExtension($_FILES['Filedata']['name']);
		$pos = strripos($_FILES['Filedata']['tmp_name'],'/');
		$tmpdir = substr($_FILES['Filedata']['tmp_name'],0,$pos);
		$tmpfile = substr($_FILES['Filedata']['tmp_name'],$pos+1);		
		
		$profile = $base_dir.'/profile.'.$ext;
				
		if( preg_match("/\/$/",WWW_ROOT)){
			@unlink(substr(WWW_ROOT,0,-1).$profile);
		}else{
			@unlink(WWW_ROOT.$profile);
		}

		$this->Image->resizeImage('resizeCrop', $tmpdir, $tmpfile, $path, 'profile.'.$ext, 128, 128, 85);

		$this->User->unbindModelAll();
		$this->User->updateAll(array('profile'=>"'".$profile."'"), array('userid'=>$userid));		
		
		echo $profile;
		
	}//end of function uploadify


	//ajax login check
	function checklogin(){
		Configure::write('debug',0);
		$this->autoRender = false;

		if( $this->Session->Read('User.userid') ){
			echo "logined";
		}else{
			echo "logouted";
		}
	}

	function __duplicate_check_name($name){
		Configure::write('debug',0);
		$this->autoRender = false;	
		$unvalid_name = array('운영자','관리자','espresso','xespresso','webadm','admin','administrator','manager','count');
		
		if( in_array($name,$unvalid_name) ){
			return false;
		}
		
		if( $this->User->find('count',array('conditions'=>array('User.name'=>$name))) ){
			return false;
		}else{
			return true;
		}
		
	}	

	function __duplicate_check_email($email){
		Configure::write('debug',0);
		$this->autoRender = false;	
		
		if( !preg_match('/^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})*$/',$email)){
			return false;
		}
		
		//로그인 상태 일때
		if( $this->Session->Read('User.userid') )
		{
			if( $this->User->find('count',array('conditions'=>array(
					'User.userid !='=>$this->Session->Read('User.userid'),
					'User.email'=>$email))) )
			{
				return false;
			}else{
				return true;
			}		
		}
		else
		{	
			if( $this->User->find('count',array('conditions'=>array('User.email'=>$email))) ){
				return false;
			}else{
				return true;
			}
		}
		
	}	



	function __duplicate_check_userid($uid){
		Configure::write('debug',0);
		$this->autoRender = false;	
		$unvalid_userid = array('espresso','xespresso','webadm','admin','administrator','manager','count');
		
		if(  strlen($uid) < 6 || !preg_match("/^([a-z0-9]{6,12})$/", $uid) || preg_match("/^[0-9]/", $uid) ){
			return false;
		}
		
		if( in_array($uid,$unvalid_userid) ){
			return false;
		}
		
		if( $this->User->find('count',array('conditions'=>array('User.userid'=>$uid))) ){
			return false;
		}else{
			return true;
		}
		
	}

	function __duplicate_check_signnum($signnum){
		Configure::write('debug',0);
		$this->autoRender = false;
			
		if( $this->User->find('count',array('conditions'=>array('User.signnum'=>$signnum))) ){
			return false;
		}else{
			return true;
		}
			
	}
	
	function check($w)
	{
		Configure::write('debug',0);
		$this->autoRender = false;	
		
		$data = trim($_POST['data']);
		switch($w)
		{
			case 'name':
				if( strlen($data) < 3 ){
					$result['result'] = 'false';				
				}elseif( $this->__duplicate_check_name($data) == false ){
					$result['result'] = 'duplicate';
				}else{
					$result['result'] = 'true';				
				}
				break;
			case 'userid':
				if( strlen($data) < 6 || !preg_match("/^([a-z0-9]{6,12})$/", $data) || preg_match("/^[0-9]/", $data) ){
					$result['result'] = 'false';							
				}elseif( $this->__duplicate_check_userid($data) == false ){
					$result['result'] = 'duplicate';
				}else{
					$result['result'] = 'true';				
				}				
				break;
			case 'email':
				if( !preg_match('/^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})*$/', $data) ){
					$result['result'] = 'false';						
				}elseif( $this->__duplicate_check_email($data) == false ){
					$result['result'] = 'duplicate';
				}else{
					$result['result'] = 'true';				
				}				
				break;
		}
		print json_encode($result);
	
	}
	function checkid($tmp){

		Configure::write('debug',0);

		$this->autoRender = false;

		$json = new Services_JSON();
		$result = array();
		$chkid = $this->params['form']['chkid'];

		$result['chkid'] = $chkid;

		if( $chkid ){

			if( $this->__duplicate_check_userid($chkid) ){
				$result['result'] = 'duplicate';
			}else{
				$result['result'] = 'ok';
			}

		}else{
			$result['result'] = 'failure';

		}

		print($json->encode($result));

	}

	function privacy(){

	}

	function spammail(){

	}

	function login(){

		$this->pageTitle = "로그인";
		
		$this->set('navigation_for_layout','<table width="680" border="0" cellspacing="0" cellpadding="0">
                          <tr><td style="text-align:right" class="location">Home  &gt; <span>로그인</span></td></tr>
                          <tr><td><img src="/images/title7_1.jpg" alt="" height="31" /></td></tr></table>');

		if( empty($this->Auth->data) ){

			if( $this->Session->read('User.check') ===  true ){
				$this->redirect($this->Auth->redirect());
			}

			$this->set('redirect',@$this->passedArgs['redirect']);

		}else{

			$uid			= $this->Auth->data['User']['userid'];
			$passwd	= $this->Auth->data['User']['passwd'];

			$data = $this->User->find('first',array('conditions'=>array('User.userid'=>$uid,'User.passwd'=>$passwd)));

			$group = array();
			if( count($data['UserGroup']) ){
				foreach(@$data['UserGroup'] as $key=>$grp ){
					$group[$key] = $grp['grpid'];
				}
			}

			if( !empty($data) && @$data['User']['userid'] ){

				$this->Session->write(array(
					"User.check"=>true,
					"User.uno"=>$data['User']['uno'],
					"User.userid"=>$data['User']['userid'],
					"User.name"=>$data['User']['name'],
					"User.email"=>$data['User']['email'],
					"User.mobile"=>$data['User']['mobile'],
					"User.homepage"=>$data['User']['homepage'],
					"User.level"=>$data['User']['level'],
					"User.group"=>$group,
					"User.datetime"=>date('Y-m-d H:i:s')
					));

				$this->Logs->write($data['User']['userid'],$data['User']['name'],$data['User']['level'],'login');

				$this->UserHistory->add(
					$data['User']['userid'],$data['User']['name'],
					$this->Session->Read('User.userid'),$this->Session->Read('User.name'),
					'로그인'
				);
				//last login
				$this->User->updateAll(array('User.lastlogin'=>'sysdate()'),array('User.userid'=>$uid));

				if(  $this->data['User']['redirect']  ){
					$this->redirect( base64_decode($this->data['User']['redirect']) );
				}else{
					$this->redirect('/');
				}
			}
			$this->SessionAlert('아이디 또는 비밀번호를 확인하십시오');
			$this->redirect(array('action'=>'login','redirect:'.@$this->passedArgs['redirect']));

		}

		$this->render('/users/login');

	}


	/***
	 *  signup
	 */
	function signup(){

		$this->pageTitle = "회원가입";
		
		$this->set('navigation_for_layout','<table width="680" border="0" cellspacing="0" cellpadding="0">
                          <tr><td style="text-align:right" class="location">Home  &gt; <span>회원가입</span></td></tr>
                          <tr><td><img src="/images/title7_2.jpg" alt="" height="31" /></td></tr></table>');
                          		

		if( empty($this->data) ){

			$this->data['User']['name'] = $this->Session->Read('User.name');
			$this->set('groups',$this->UserGroupSetup->get());
			
		}else{

			if( $this->__duplicate_check_userid($this->data['User']['userid']) == false ){
				$this->SessionAlert("이미 사용중인 아이디입니다.");
				$this->redirect(array('action'=>'signup'));
			}
	
//				$this->data['User']['signnum'] = Security::hash($this->data['User']['signnum1'].$this->data['User']['signnum2']);
				$this->data['User']['signnum'] = signencode($this->data['User']['signnum1'].$this->data['User']['signnum2']);
				//주민번호 체크
/*
				if( $this->__duplicate_check_signnum($this->data['User']['signnum']) ){
					$this->SessionAlert("이미 등록된 주민등록번호입니다. 아이디/비밀번호를 찾기를 이용하십시오");
					$this->redirect(array('action'=>'find'));				
				}
*/
				$this->data['User']['email'] = $this->data['User']['email_id'].'@'.$this->data['User']['email_host'];

				$grpid = $this->data['User']['grpid'];
				
				if( $this->User->save($this->data) ){
				
					$this->UserGroup->add($this->data['User']['userid'],$grpid);//기본그룹 추가
	
					//추가 정보 입력
	//				$this->data['Company']['userid'] = $this->data['User']['userid'];
	//				$this->Company->Save($this->data);
	
	
					$this->UserHistory->add(
						$this->data['User']['userid'],$this->data['User']['name'],
						$this->Session->Read('User.userid'),$this->Session->Read('User.name'),
						'회원가입'
					);
					$this->redirect(array('action'=>'thank'));
				}else{
					$this->data['User']['passwd'] = '';
					$this->data['User']['passwd2'] = '';
					//$this->redirect(array('action'=>'signup'));
				}
			
		}
		$this->render('/users/signup');
	}

	/***
	 * 약관 동의
	 */
	function agree(){

		//실명인증 상태
		if( $this->Session->Read('User.check') == false && $this->Session->Read('User.userid') ){
			$this->redirect(array('action'=>'signup'));
		}
		$this->render('/users/agree');
	}

	/***
	 * 회원가입 완료 페이지
	 */
	function thank(){
	
		$this->set('navigation_for_layout','<table width="680" border="0" cellspacing="0" cellpadding="0">
                          <tr><td style="text-align:right" class="location">Home  &gt; <span>회원가입</span></td></tr>
                          <tr><td><img src="/images/title7_2.jpg" alt="" height="31" /></td></tr></table>');
                          		

	
		$this->render('/users/thank');
	}

	/***
	 *  signout
	 */
	function signout(){
		$this->pageTitle = "회원탈퇴";

		if( empty($this->data) ){

		}else{



			$data = $this->User->read(null,$this->Session->Read('User.userid'));

			if( $this->data['User']['passwd'] != $data['User']['passwd'] ){
				$this->Session->setFlash('비밀번호가 일치 하지 않습니다.',$this->layout,array(),'user');
				$this->redirect(array('action'=>'signout'));
			}else{
			
				$data = $this->User->Read(array('userid','name'),$this->Session->Read('User.userid'));
				if( $this->User->signout($this->Session->Read('User.userid')) ){
				
					$this->UserHistory->add(
						$data['User']['userid'],$data['User']['name'],
						$this->Session->Read('User.userid'),$this->Session->Read('User.name'),
						'회원탈퇴'
					);
									
					$this->redirect(array('action'=>'logout'));
				}else{
					$this->Session->setFlash('탈퇴 서비스 오류',null,array(),'user');
					$this->redirect(array('action'=>'signout'));
				}

			}
		}

	}

	/***
	 *  find id/pwd
	 */
	function find(){
		$this->pageTitle = "아이디 / 비밀번호 찾기";

		$this->set('navigation_for_layout','<table width="680" border="0" cellspacing="0" cellpadding="0">
                          <tr><td style="text-align:right" class="location">Home  &gt; <span>아이디/비밀번호찾기</span></td></tr>
                          <tr><td><img src="/images/title7_3.jpg" alt="" height="31" /></td></tr></table>');
                          
		if( empty($this->data) ){

		}else{

			$name			= @$this->data['User']['name'];
			$userid		= @$this->data['User']['userid'];
			$signnum	= signencode($this->data['User']['signnum1'].$this->data['User']['signnum2']);
				
			if( @$this->data['User']['userid'] ){ //비밀번호 찾기


				$data = $this->User->find('first',array('conditions'=>array('User.deleted'=>null,'User.userid'=>$userid,'User.name'=>$name,'User.signnum'=>$signnum)));

				if( @$data['User']['userid'] ){


					//임시 비밀번호 생성
					list($usec, $sec) = explode(' ', microtime());
					mt_srand((float) $sec + ((float) $usec * 100000));
					$tmpPassword = mt_rand(100000,999999);

					if( $this->User->setTmpPassword($data['User']['userid'],$this->Auth->password($tmpPassword)) === false ){
						$this->Session->setFlash("<div class='find-message'>임시 비밀번호 발급을 할 수 없습니다.</div>",$this->layout,array(),'findPassword');
						$this->redirect(array('action'=>$this->action));
					}else{
						$this->Mail->send('html',$data['User']['email'],$data['User']['name'],$this->site['mailing_name'],$this->site['mailing_email'],"임시 비밀번호를 알려드립니다.","$tmpPassword");
						
						$this->UserHistory->add(
							$data['User']['userid'],$data['User']['name'],
							$this->Session->Read('User.userid'),$this->Session->Read('User.name'),
							'비밀번호 찾기 서비스 이용'
						);
					}

					$this->Session->setFlash("<div class='find-message'>$name 님의 임시 비밀번호를  [ ".$data['User']['email']." ] 메일주소로 발송해 드렸습니다.</div>",null,array(),'findPassword');
					$this->redirect(array('action'=>$this->action));
				}else{
					$this->Session->setFlash("<div class='find-message'>일치하는 회원정보가 없습니다.</div>",null,array(),'findPassword');
					$this->redirect(array('action'=>$this->action));
				}

			}else{ //아이디 찾기


				$data = $this->User->find('first',array('conditions'=>array('User.deleted'=>null,'User.name'=>$name,'User.signnum'=>$signnum)));

				if( @$data['User']['userid'] ){

					$this->Session->setFlash("<div class='find-message'>$name 님의 아이디는 [ ".$data['User']['userid']." ] 입니다.</div>",null,array(),'findId');
					
						$this->UserHistory->add(
							$data['User']['userid'],$data['User']['name'],
							$this->Session->Read('User.userid'),$this->Session->Read('User.name'),
							'아이디 찾기 서비스 이용'
						);
											
					$this->redirect(array('action'=>$this->action));
				}else{
					$this->Session->setFlash("<div class='find-message'>일치하는 회원정보가 없습니다.</div>",null,array(),'findId');
					$this->redirect(array('action'=>$this->action));
				}
			}
		}

		$this->render('/users/find');
	}

	/***
	 *  edit
	 */
	function edit(){
		$this->pageTitle = "회원정보 수정";

		if( empty($this->data) ){
			$this->data = $this->User->read(null,$this->Session->Read('User.userid'));
			$this->data['User']['passwd'] = "";
			@list($this->data['User']['email_id'],$this->data['User']['email_host']) = explode('@',$this->data['User']['email']);
			

			if( !empty($this->data['User']['profile']) && file_exists(WWW_ROOT.$this->data['User']['profile']) )
			{
				$this->set('profile',$this->data['User']['profile']);
			}
			else
			{
				$this->set('profile',Configure::read('User.profileDefault'));
			}
		}else{


			$data = $this->User->read(null,$this->Session->Read('User.userid'));

			if( $this->data['User']['passwd'] ==  $data['User']['passwd'] ){

				if( $this->data['User']['passwd2'] ){
					//비밀번호 변경
					$this->data['User']['passwd'] = $this->Auth->password($this->data['User']['passwd2']);
				}else{
					$this->data['User']['passwd2'] = $this->data['User']['passwd'];
				}

			}else{
				$this->Session->setFlash("기존 비밀번호가 일치하지 않습니다.",null,array(),'user');
				$this->redirect(array('action'=>'edit'));
				exit();
			}
			
			unset($this->User->validate['captcha']);
			
			if( $this->User->save($this->data) ){

				//추가 정보 입력
				$this->data['Company']['userid'] = $this->Session->Read('User.userid');
				$this->Company->Save($this->data);

				$this->Session->setFlash("회원정보를 수정하였습니다.",null,array(),'user');
				
					$this->UserHistory->add(
						$data['User']['userid'],$data['User']['name'],
						$this->Session->Read('User.userid'),$this->Session->Read('User.name'),
						'회원정보 수정'
					);
										
				$this->redirect(array('action'=>'edit'));
			}else{
				$this->data['User']['passwd'] = "";
				$this->data['User']['passwd2'] = "";
			}

		}

		$this->render('/users/edit');

	}
	
	function webadm_openid(){
		$this->layout = null;
		
		if( empty($this->Auth->data['User']['userid']) ){

			if( $this->Session->read('Admin.userid') && $this->Session->read('Admin.check') ===  true ){
				$this->redirect(array('plugin'=>'dashboard','controller'=>'dashboard','action'=>'index'));

			}

			//Open ID
			if( $this->data['OpenidUrl']['openid'] ){

					$openid = str_replace(array('http://','/'),'',$this->data['OpenidUrl']['openid']);
			

					if( in_array($openid,$this->openid) ){

						$this->Openid->authenticate($this->data['OpenidUrl']['openid'], $this->OpenIDreturnTo, 'http://'.$_SERVER['SERVER_NAME']);
						exit;
					}else{
						$this->set('message','오픈아이디 정보가 존재 하지 않습니다.');
					}

			}elseif (count($_GET) > 1) {
//pr($this->Auth);exit;

				$response = $this->Openid->getResponse($this->OpenIDreturnTo);

				if ($response->status == Auth_OpenID_CANCEL) {
					$this->set('message','Verification cancelled');
				} elseif ($response->status == Auth_OpenID_FAILURE) {
					$this->set('message','OpenID verification failed: '.$response->message);
				} elseif ($response->status == Auth_OpenID_SUCCESS) {


					$openid = str_replace(array('http://','/'),'',$_GET['openid_identity']);

															
					$data['User'] = array(
						'userid'=>'plani',
						'name'=>'플랜아이',						
						'level'=>9,
						'email'=>'blueb@plani.co.kr',
						'homepage'=>'http://plani.co.kr',
						'mobile'=>'',
						'openid'=>$openid,					
					);
					
					$this->Session->write(array('Auth'=>$data));

					if( !empty($data) && $data['User']['level'] >= $this->webadm_allow_level ){
						$this->__login($data);

						$this->redirect($this->Auth->redirect(array('plugin'=>'dashboard','controller'=>'dashboard','action'=>'index')));
					}else{
						$this->set('message','관리자 인증이 안된 사용자입니다.');
					}
				}


			}
	
		}
	}

	function webadm_login(){
		$this->layout = null;
/*
pr($_SESSION);
pr($this->Auth);exit;	
*/	
//		pr($this->Auth->data);exit;

		if( empty($this->Auth->data['User']['userid']) ){

			if( $this->Session->read('Admin.userid') && $this->Session->read('Admin.check') ===  true ){
				$this->redirect(array('plugin'=>'dashboard','controller'=>'dashboard','action'=>'index'));

			}


		}else{

				$uid			= $this->Auth->data['User']['userid'];
				$passwd	= $this->Auth->data['User']['passwd'];


				$data = $this->User->find('first',array('conditions'=>array(
																									'User.userid'=>$uid,
																									'User.passwd'=>$passwd,
																									'User.level >='=>$this->webadm_allow_level
																								)
																)
														);
				if( !empty($data) && $data['User']['level'] >= $this->webadm_allow_level )
				{
					$this->__login($data);
					
						$this->UserHistory->add(
							$data['User']['userid'],$data['User']['name'],
							$this->Session->Read('Admin.userid'),$this->Session->Read('Admin.name'),
							'[관리자] 로그인'
						);
					$this->redirect($this->Auth->redirect(array('plugin'=>'dashboard','controller'=>'dashboard','action'=>'index')));
				}else{
					$this->Logs->write($uid,$_POST['data']['User']['passwd'],'0','login fialure');
					unset($this->Auth->data['User']['passwd']);
					$this->redirect($this->Auth->redirect(array('action'=>'login')));
				}



		}

	}

	function __login(&$data){

			$group = array();
			if( @is_array($data['UserGroup']) ){
				foreach(@$data['UserGroup'] as $key=>$grp ){
					$group[$key] = $grp['grpid'];
				}
			}


			$this->Session->write(array(
				"Admin.check"=>true,
				"Admin.userid"=>$data['User']['userid'],
				"Admin.name"=>$data['User']['name'],
				"Admin.email"=>$data['User']['email'],
				"Admin.mobile"=>$data['User']['mobile'],
				"Admin.homepage"=>$data['User']['homepage'],
				"Admin.level"=>$data['User']['level'],
				"Admin.group"=>$group,
				"Admin.datetime"=>date('Y-m-d H:i:s')
				));

			$this->Logs->write($data['User']['userid'],$data['User']['name'],$data['User']['level'],'login');
	}

	function logout(){

		$this->layout = '';

		$user = $this->Session->read('User');
		$data = $this->User->Read(array('userid','name'),$this->Session->Read('User.userid'));
		
		$this->Session->delete('User');
		$this->Session->destroy();

		$this->Logs->write($user['userid'],$user['name'],$user['level'],'logout');


		$this->UserHistory->add(
			$data['User']['userid'],$data['User']['name'],
			$this->Session->Read('User.userid'),$this->Session->Read('User.name'),
			'로그아웃'
		);
						
		$this->redirect('/');

	}

	function webadm_logout(){

		$admin = $this->Session->read('Admin');
		$data = $this->User->Read(array('userid','name'),$this->Session->Read('Admin.userid'));
		
		$this->Session->delete('Admin');
		$this->Session->destroy();

		$this->Logs->write($admin['userid'],$admin['name'],$admin['level'],'logout');


		$this->UserHistory->add(
			$data['User']['userid'],$data['User']['name'],
			$this->Session->Read('Admin.userid'),$this->Session->Read('Admin.name'),
			'[관리자] 로그아웃'
		);
		
		$this->redirect($this->Auth->logout());
	}


	/***
	 * Description	: 회원 목록
	 * Author			: 김정수
	 * Date				: 2009-01-16
	 */
	function webadm_index(){

		$this->set("group",$this->UserGroupSetup->get());

		//setting url page parameters
		if( count($this->passedArgs) ){
			$this->data['User'] = $this->passedArgs;
		}else{

			$this->passedArgs = $this->data['User'] = $this->params['url'];
			unset($this->data['User']['url']);
			unset($this->passedArgs['url']);

		}
		$conditions = array();
		$this->set("data",$this->paginate('User',$conditions));

		$this->UserHistory->add(
			'','',
			$this->Session->Read('Admin.userid'),$this->Session->Read('Admin.name'),
			'[관리자] 개인정보 목록 열람'
		);
	}

	function webadm_search(){

		$this->set("group",$this->UserGroupSetup->get());

		//setting url page parameters
		if( count($this->passedArgs) ){
			$this->data['User'] = $this->passedArgs;
		}else{

			$this->passedArgs = $this->data['User'] = $this->params['url'];
			unset($this->data['User']['url']);
			unset($this->passedArgs['url']);

		}


		$keyword = @$this->passedArgs['keyword'];
		$keyword = str_replace(array("'"),"",$keyword);
		$sfield = $this->passedArgs['sfield'];
		$level = (int)$this->passedArgs['level'];
		$grpid = (int)$this->passedArgs['grpid'];


		$conditions = array('AND'=>array(1));

		if( $level ){
			$conditions['User.level'] = $level;
		}
		if( $grpid ){
			//*
			//$this->User->unbindModel(array('hasMany'=>array('UserGroup')),false);
			$this->User->bindModel(
				array('hasOne'=>
					array('UsrGrp'=>
						array('className'=> 'UserGroup',
							'conditions'   => '',
							'order'        => '',
							'dependent'    =>  false,
							'foreignKey'   => 'userid'
						)
					)
				)
			,false);
			$conditions['UsrGrp.grpid'] = $grpid;
			//*/
		}

		if( $keyword ){
			$condition = array();
			array_push($conditions,array('User.'.$sfield.' LIKE'=>"$keyword%"));
		}


		$this->set("data",$this->paginate('User',$conditions));

		$this->render("webadm_index");
	}

	function webadm_history(){

		$conditions = array();
		
		//setting url page parameters
		$sfield = @trim($this->params['url']['sfield']);
		$keyword = @trim($this->params['url']['keyword']);		
		if( $sfield && $keyword )
		{
			$this->passedArgs = $this->data['UserHistory'] = $this->params['url'];
			unset($this->data['UserHistory']['url']);
			unset($this->passedArgs['url']);		
			
			$conditions[$sfield.' like'] = '%'.$keyword.'%';
		}
		else
		{
			$this->data['UserHistory'] = $this->passedArgs;
		}


		
		$this->set("rows",$this->paginate('UserHistory',$conditions));

	}
	
	function webadm_edit($id){

		unset($this->level[0]);//비회원 표시 제거
		$this->set('level',$this->level);
		$this->set("gdata",$this->UserGroupSetup->get());

		if( empty($this->data) ){

			$this->data = $this->User->Read(null,$id);
			$this->data['User']['passwd']=null;
		}else{


			if( empty($_POST['data']['User']['passwd']) ){
				$data = $this->User->findByUserid($id);
				$this->data['User']['passwd2'] = $this->data['User']['passwd'] = $data['User']['passwd'];
			}else{
				$this->data['User']['passwd2'] = $this->data['User']['passwd'];
			}
			
			$groups = $this->data['User']['grpid'] = $this->data['grpid'];
			$this->data['User']['signnum'] = @signencode($this->data['User']['signnum']);

			$this->User->validate = array(
									'userid' => array('rule' => 'notEmpty','required' => true,'minLength'=>'4'),
									'name' => array('rule' => 'notEmpty','required' => true),
									'email'=>array('rule'=>'email','allowEmpty'=>true),
									);
									
			if( $this->User->Save($this->data) ){
				//기존정보 삭제

				if( is_array($groups) ){
					$this->UserGroup->remove($id);				
					foreach($this->data['grpid'] as $grpid ){
						if( 0 === (int)$grpid ) continue;
						//등록
						if( $this->UserGroup->add($id,$grpid) ){
	
						}else{
							$this->Session->setFlash('그룹정보 등록 실패');
							$this->redirect(array('action'=>'edit',$id));
						}
					}//end of foreach;
				}else{
					if( $groups ){
						$this->UserGroup->remove($id);
						if( $this->UserGroup->add($id,$this->data['grpid']) ){	
						}else{
							$this->Session->setFlash('그룹정보 등록 실패');
							$this->redirect(array('action'=>'edit',$id));
						}
					}
				}

				$this->data['Company']['userid'] = $id;
				$this->Company->Save($this->data);

				$this->Session->setFlash("수정되었습니다.");
						
				$this->UserHistory->add(
					$this->data['User']['userid'],$this->data['User']['name'],
					$this->Session->Read('Admin.userid'),$this->Session->Read('Admin.name'),
					'[관리자] 개인정보 수정'
				);
		
						
				$this->redirect(array('action'=>'view',$id));
			}

			$this->data['User']['passwd']=null;
		}

		$this->set('userid',$id);
		$this->render("webadm_form");

	}


	function webadm_view($userid){
	
		
		$this->set("gdata",$this->UserGroupSetup->get());
		
		$this->data = $this->User->Read(null,$userid);
		
		$this->UserHistory->add(
			$this->data['User']['userid'],$this->data['User']['name'],
			$this->Session->Read('Admin.userid'),$this->Session->Read('Admin.name'),
			'[관리자] 개인정보 열람'
		);		
	}





	function webadm_add(){
	
		unset($this->level[0]);//비회원 표시 제거
		$this->set('level',$this->level);
		
		$this->set("gdata",$this->UserGroupSetup->get());
		
		if( empty($this->data) ){

		}else{

			//회원가입시 아이디 중복 체크
			$chk = $this->User->find('count',array('conditions'=>array('User.userid'=>$this->data['User']['userid'])));
			if( $chk > 0 ){
				$this->Session->setFlash('이미 등록된 사용자 아이디 입니다.');
				$this->redirect(array('action'=>'add'));
			}

			if( empty($_POST['data']['User']['passwd']) ){
				$this->data['User']['passwd'] = null;
			}else{
				$this->data['User']['passwd2'] = $this->data['User']['passwd'];
			}
			$this->data['User']['grpid'] = $this->data['grpid'];
			
			$groups = $this->data['grpid'];
			
			//주민번호 암호화
			$this->data['User']['signnum'] = signencode($this->data['User']['signnum']);
			

			$userid = $this->data['User']['userid'];
			
			unset($this->User->validate['validate_signnum']);				
			unset($this->User->validate['captcha']);	
			
			if( $this->User->Save($this->data) ){
				
				
				if( is_array($groups) ){
				
					foreach($this->data['grpid'] as $grpid ){
						if( 0 === (int)$grpid ) continue;
						//등록
						$this->UserGroup->add($userid,$grpid);
					}
				}else{
						$this->UserGroup->add($userid,$this->data['grpid']);
				}

				$this->data['Company']['userid'] = $userid;

				$this->Company->Save($this->data);

				$this->Session->setFlash("등록되었습니다.");
						
				$this->UserHistory->add(
					$this->data['User']['userid'],$this->data['User']['name'],
					$this->Session->Read('Admin.userid'),$this->Session->Read('Admin.name'),
					'[관리자] 개인정보 등록'
				);
						
				$this->redirect(array('action'=>'view',$userid));
			}

			$this->data['User']['passwd']=null;
		}
		$this->render("webadm_form");
	}

	/***
	 *  signout
	 */
	function webadm_signout($uid){

		if( $this->Session->Read('Admin.level') < 9 || $uid == '' ){
					$this->SessionAlert('최고관리자 전용 서비스 입니다.');
					$this->redirect(array('action'=>'index'));
		}else{
				
				$data = $this->User->Read(array('userid','name'),$uid);
				if( $this->User->signout($uid) ){
					$this->SessionAlert('정상적으로 탈퇴처리 되었습니다.');
					
					$this->UserHistory->add(
						$data['User']['userid'],$data['User']['name'],
						$this->Session->Read('Admin.userid'),$this->Session->Read('Admin.name'),
						'[관리자] 회원탈퇴'
					);					

				}else{
					$this->SessionAlert('탈퇴 서비스 오류');
				}
				$this->redirect(array('action'=>'index'));				
		}
	}
	
	
	function webadm_group($id=null){
		$this->set('id',(int)$id);

		$this->set("gdata",$this->UserGroupSetup->find('all',array('conditions'=>array('deleted'=>null))));				
		
		if( empty($this->data) ){

			if( $id ){
				$this->data = $this->UserGroupSetup->Read(null,$id);
			}
		}else{

			if( $this->UserGroupSetup->save($this->data) ){
				$this->Session->setFlash("저장 되었습니다.");
				$this->redirect(array('action'=>'group'));
			}
			
		}
	}

	function webadm_group_del($cid){
		if( $cid == 1 ){
			$this->Session->setFlash("기본 그룹은 삭제 할 수 없습니다.");
			$this->redirect(array('action'=>'group'));
		}
		if( $this->UserGroupSetup->del($cid) ){

		}else{

		}
		$this->redirect(array('action'=>"group"));
	}

	function webadm_get($id){
		$this->layout = null;
		$this->autoRender = false;

		$user = array_shift($this->User->read(null,$id));
		$json = new Services_JSON();
		print_r($json->encode($user));
	}
	
	function webadm_set(){
		$this->layout = null;
		$this->autoRender = false;

		$json = new Services_JSON();

		if( $this->User->save($this->data,false) ){

			$user = array_shift($this->User->read(null,$this->data['User']['userid']));
			print_r($json->encode($user));
		}else{
			print_r($json->encode(array('error'=>'true')));
		}


	}
		
	
}//end of class
