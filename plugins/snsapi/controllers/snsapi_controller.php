<?php


Configure::load('Snsapi.snsapi');
App::import('Vendor', 'Facebook',array('plugin'=>'Snsapi','file'=>'facebook/facebook.php'));
App::import('Vendor', 'JSON',array('file'=>'JSON.php'));

class SnsapiController extends AppController {

	var $name = "Snsapi";

	var $components = array('OauthConsumer');
	var $uses = array();
	var $helpers = array();


	var $me2day		= null;
	var $twitter	= null;
	var $facebook	=null;
	/***
	 *
	 */
	function beforeFilter(){

		parent::beforeFilter();


		if( eregi("webadm_",$this->action) ) {

		}

		$this->me2day 	= Configure::read('Snsapi.Me2day');
		$this->twitter 	= Configure::read('Snsapi.Twitter');
		$this->facebook = Configure::read('Snsapi.Facebook');
		

	}


    function twitter() {
        $requestToken = $this->OauthConsumer->getRequestToken('Twitter', 'http://twitter.com/oauth/request_token', 'http://'.$_SERVER['HTTP_HOST'].'/snsapi/twitter_callback');
        $this->Session->write('twitter.request_token', $requestToken);
        $this->redirect('http://twitter.com/oauth/authorize?oauth_token=' . $requestToken->key);
    }

		function _close(){
   		$this->autoRender = false;		
			echo "<script type=\"text/javascript\">self.close();</script>";
		}

    function twitter_callback() {
    		$this->autoRender = false;
        $requestToken = $this->Session->read('twitter.request_token');
        $accessToken = $this->OauthConsumer->getAccessToken('Twitter', 'http://twitter.com/oauth/access_token', $requestToken);

				$this->Session->Write('twitter.key',$accessToken->key);
				$this->Session->Write('twitter.secret',$accessToken->secret);				
				$this->_close();
    }
    
    function me2day(){
    	$this->autoRender = false;
//    	Configure::write('debug',2);

	    $result = json_decode(file_get_contents("http://me2day.net/api/get_auth_url.json?akey=" . $this->me2day['akey']));
	    $this->redirect($result->url);
			    
    }
    
    function me2day_callback(){
	    //http://mudchobo.tistory.com/502
    	$this->autoRender = false;    

		  $token = $_GET["token"];
	    $uid = $_GET["user_id"];
	    $ukey = $_GET["user_key"];
	    $result = $_GET["result"];

	    $authKey = "12345678" . md5("12345678" . $ukey);	   
	    // 세션저장
	    $this->Session->Write('me2day.uid',$uid);
	    $this->Session->Write('me2day.authKey',$authKey);	    

	   
	    // 인증이 확실한지 확인
	    $result = file_get_contents("http://me2day.net/api/noop?uid={$uid}&ukey={$authKey}&akey=" . $this->me2day['akey']);    
			$this->_close();


    }
    
    function facebook(){
    
    
			$facebook = new Facebook(array(
			  'appId'  => $this->facebook['appid'],
			  'secret' => $this->facebook['secret'],
			  'cookie' => true,
				'domain' => $_SERVER['HTTP_HOST']			  
			));
			    
			$session = $facebook->getSession();
			 
			if (!$session) {
			 
				$url = $facebook->getLoginUrl(array(
				'canvas' => 0,
				'fbconnect' => 0
				));

				$this->redirect($url);
			}else{
				
				$uid = $facebook->getUser();
				$me = $facebook->api('/me');
				 
				$updated = date("l, F j, Y", strtotime($me['updated_time']));
				 
				echo "Hello " . $me['name'] . "<br />";
				echo "You last updated your profile on " . $updated;
				 			
			
			}
			     
//    	$this->redirect('https://graph.facebook.com/oauth/authorize?client_id='.$this->facebook['appid'].'&type=user_agent&scope=&redirect_uri=http://'.$_SERVER['HTTP_HOST'].'/snsapi/facebook_callback');
    }
    
    function facebook_callback(){
    
			$facebook = new Facebook(array(
			  'appId'  => $this->facebook['appid'],
			  'secret' => $this->facebook['secret'],
			  'cookie' => true,
			));
			$session = $facebook->getSession();  
			pr($session);
			echo 'adfadf';
 
			pr($_SERVER);
			pr($this);
    }
    
    function twitter_save($data){
				$key = $this->Session->read('twitter.key');
				$secret = $this->Session->read('twitter.secret');    
			$this->OauthConsumer->post('Twitter', $key, $secret, 'http://twitter.com/statuses/update.json', array('status' =>$data));    
    }
    
    function me2day_save($data){
	    $uid = $this->Session->read('me2day.uid');
	    $authKey = $this->Session->read('me2day.authKey');	    
	   	$result = file_get_contents("http://me2day.net/api/create_post/{$uid}.json?uid={$uid}&ukey={$authKey}&akey=" . $this->me2day_akey . "&post[body]=".urlencode($data));

  	  //header("Content-type: application/json");
	    //echo "{$callback}({'result':'{$result}'})";        
    }
    
    function index(){
    	Configure::write('debug',0);
    	   
    	if( empty($this->data) ){
    	
    	}else{
    	
    		$data = @$_POST['data'];
    		
    		if( @$_POST['me2day'] ) $this->me2day_save($data);
    		if( @$_POST['twitter'] ) $this->twitter_save($data);    		
    	 	echo "등록 완료";
    	}
    
    }



}//end of class
?>