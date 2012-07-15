<?php
class BoardAppController extends AppController 
{
	var $components = array('Session','Image','Email','Crypter','RequestHandler');
	var $helpers = array('Text', 'Form','Editor','Image','MediaInsert','Qrcode','SyntaxHighlighter');	


	
	var $uses = array(
				'Tag',
				'Users.UserGroup',		
				'Users.User',	
				'Fileattach.Fileattach',	
				'Comment.Comment',	
				'Board.BoardCategory',				
				'Board.BoardSetup',				
				'Board.BoardTag',
				'Board.Board',
			);
			
	/***
	 *
	 */
	function beforeFilter(){
	
		parent::beforeFilter();
		

	}

	function captcha($bid=null)
	{
	
		Configure::write('debug',0);

		$this->layout = null;
		$this->autoRender = false;

		//captcha
		if( $this->setup['use_captcha'] ){
			App::import('Vendor', 'Captcha', array('file' => 'captcha'.DS.'captcha_numbersV2.php'));
			$captcha = new CaptchaNumbersV2(6);
			$captcha->font =  dirname(APP).DS.'vendors/captcha/fonts/arial.ttf';
			$captcha->fonts_folder = dirname(APP).DS.'vendors/captcha/fonts/';

			$captcha->display();

			$this->Session->Write('captcha',$captcha->getString());
		
		}else{
			die('Error Board Setup use captch disabled');
		}
	}
	
	protected function addTag($bid,$no,$tags)
	{
		$tagids = array();

		foreach(explode(',',$this->data['Board']['tags']) as $tag){
			$tag = trim($tag);
			if( empty($tag) ) continue;

			if( $tagid = $this->Tag->add($tag) ){
				$tagids[] = $tagid;
				$this->BoardTag->create();
				$this->BoardTag->save($bid,$no,$tagid);
			}
		}//end of foreach;

		$this->BoardTag->del($bid,$no,$tagids);
	
	}
	
		
	public function profile()
	{
		$this->layout = null;
		$data = $this->Crypter->decrypt($this->data['data']);
		@list($userid,$timestamp,$no) = @explode('⇋',$data);
		
		$data = $this->User->Read(array(
			'User.name',
			'User.profile',
			'User.sns_facebook',
			'User.sns_twitter',
			'User.sns_me2day',
			'User.introduce',
			'User.website'
		),$userid);
		if( trim($data['User']['profile']) == '' )
		{
			$data['User']['profile'] = "/users/img/profile.png";
		}
		$this->set('data',$data);
		$this->render('profile');
	}
}
