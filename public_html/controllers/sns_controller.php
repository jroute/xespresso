<?php
class SnsController extends AppController {
		var $name = 'Sns';
    var $uses = array();
    var $components = array('OauthConsumer');


		var $me2day_akey = '88856fa8a5de3372b1def3c6b2027974';
		
		var $facebook = array(
			'client_id'=>'132667223462965'			
		);

    function twitter() {
        $requestToken = $this->OauthConsumer->getRequestToken('Twitter', 'http://twitter.com/oauth/request_token', 'http://ck.plani.co.kr/sns/twitter_callback');
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

	    $result = json_decode(file_get_contents("http://me2day.net/api/get_auth_url.json?akey=" . $this->me2day_akey));
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
	    $result = file_get_contents("http://me2day.net/api/noop?uid={$uid}&ukey={$authKey}&akey=" . $this->me2day_akey);    
			$this->_close();


    }
    
    function facebook(){
    	$this->redirect('https://graph.facebook.com/oauth/authorize?client_id='.$this->facebook['client_id'].'&type=user_agent&scope=&redirect_uri=http://ck.plani.co.kr/sns/facebook_callback/');
    }
    function facebook_callback(){
    	
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
    
    function write(){
    	Configure::write('debug',0);
    	
    	$this->autoRender = false;       
    	if( empty($this->data) ){
?>
<meta charset="UTF-8" />
<script type="text/javascript" src="/js/jquery/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
$(function(){
	$('#me2day').click(function(){
		if( $(this).is(':checked') == true ){
			window.open('/sns/me2day','me2win','width=800,height=500');
		}
	});
	$('#twitter').click(function(){
		if( $(this).is(':checked') == true ){	
			window.open('/sns/twitter','twt2win','width=800,height=500');	
		}
	});	
	$('#facebook').click(function(){
		if( $(this).is(':checked') == true ){	
			window.open('/sns/facebook','fbwin','width=800,height=500,scrollbars=yes');	
		}
	});		
})
</script>
<form action="/sns/write" method="post">
<input type="checkbox" name="me2day" id="me2day" value="1" /><img src="/img/me2day_logo.gif" />
<input type="checkbox" name="twitter" id="twitter" value="1" /><img src="/img/twitter_logo.gif" />
<input type="checkbox" name="facebook" id="facebook" value="1" /><img src="/img/facebook_logo.gif" />
<textarea rows="5" cols="50" name="data" ></textarea>
<input type="submit" value="등록" />
</form>
<?    	
    	}else{
    	
    		$data = @$_POST['data'];
    		
    		if( @$_POST['me2day'] ) $this->me2day_save($data);
    		if( @$_POST['twitter'] ) $this->twitter_save($data);    		
    	 echo "등록 완료";
    	}
    
    }
}
?>