<?php

App::import('Vendor', 'JSON',array('file'=>'JSON.php'));
App::import('Lib', 'Lib',array('file'=>'functions.php'));

class AppController extends Controller {

	var $components = array('Session','Cookie');
	var $helpers = array('Html','Form','Session','Javascript');
	var $uses = array(
		'Setup.Setup',	
		'Menus.Menu'
	);
	var $ext = ".php";  //view file extention change
	
	//관리자 로그인 권한 제한
	var $webadm_allow_level = 8;
	
	var $site = array();
	var $level = array();
	
	var $lang = 'ko';
	
/*
	http://en.wikipedia.org/wiki/ISO_3166-1
	http://en.wikipedia.org/wiki/ISO_3166-2
*/

	var $language = array(
		'ko'=>'한국어',	
		'en'=>'영어'	,
	);
			
	function beforeFilter(){

		$this->Session->start();

		parent::beforeFilter();

		if( Cache::read('Site.settings') == false ){
					$settings = $this->Setup->Read(null,1);
					Cache::write('Site.settings', $settings);
		}else{
			$settings = Cache::read('Site.settings');
		}

		
		$this->site = @unserialize($settings['Setup']['site']);
		
		$this->level = @unserialize($settings['Setup']['level']);		
		$this->set('site',$this->site);
		
		foreach($this->level as $lv=>$ln){
			if( trim($ln) == '' || trim($ln) == '-' ){
				unset($this->level[$lv]);
				continue;
			}
			$this->level[$lv] =  $ln;
		}

		$this->set('level',$this->level);	
    	
    $this->_setLanguage();
    				
		//Administrator
		if( eregi("webadm_",$this->action) ){
		
			$this->layout = 'webadm_layout';
			
			if( $this->Session->Read('Admin.level') < $this->webadm_allow_level && !eregi('webadm_login|webadm_openid',$this->action) ){
				$this->redirect(array('plugin'=>'users','controller'=>'users','action'=>'login','webadm'=>true));
			}
			
			$this->set('language',$this->language);
			
			$this->set('title_for_layout',$this->site['webadm_title']);
			


		}
		else
		{

		 	$this->layout = 'sub_layout';
				
			$this->set('title_for_layout',$this->site['title']);
			
			
			if( !in_array($this->params['controller'],array('index')) ){
				//set submenu
				$pass = @$this->params['pass'][0];
				$cachekey = $this->params['controller'].'-submenus-'.$pass;
				if( Cache::read($cachekey) == false ){
					$submenus = $this->Menu->getSubMenus($this->params['controller'],null,$pass);
					$submenus['submenu'] = $this->Menu->getSubFile($this->params['controller'],null,$pass);
					$this->set('submenus', $submenus);
					Cache::write($cachekey, $submenus);
				}else{
					$submenus = Cache::read($cachekey);
					$this->set('submenus',$submenus);
				}
				
				$this->set('navigation_for_layout',$submenus['current']['html_header']);
	
			}//end of !in_array;

		}
		


	}
	
	

  
  /**
   * Loads a config file.
   * 
   * @param $file Name of the config file
   */
  function __loadConfig($plugin,$file) {
    // still support config values of v2.3 elements
    if (count(explode('.', $file)) > 0) {
      $file = str_replace('.', '_', $file);
    }
    
    // load config from app config folder
    if (Configure::load($file) === false) {
      // load config from plugin config folder
      if( $plugin ){
	      if (Configure::load($plugin.'.'.$file) === false) {
	        echo '<p>Error: The '.$file.'.php could not be found in your app/config or app/plugins/comment/config folder. Please create it from the default comment/config/default.php.</p>';
	      }
	    }else
	    {
	      if (Configure::load($file) === false) {
	        echo '<p>Error: The '.$file.'.php could not be found in your app/config or app/plugins/comment/config folder. Please create it from the default comment/config/default.php.</p>';
	      }	    
	    }
    }
  }
  
  
  	
	function _setLanguage() {

		$here = @explode('/',$this->here);
		if( eregi("^/([a-z]){2}/?",$this->here) && strlen($here[1]) == 2 ){
			$this->lang = $here[1];
		}else if( isset($this->params['named']['language']) && strlen($this->params['named']['language']) == 2  ) {
			$this->lang = $this->params['named']['language'];
		}else{
			$this->lang = Configure::Read('Config.language');
		}

		$this->Session->write('Config.language', $this->lang);
    $this->set('lang',$this->lang);
		

	} 


	function setAlert($msg){
		$this->set('alert',"
			<script type=\"text/javascript\">
			$(function(){
				window.alert(\"".$msg."\");
			});
			</script>
		");
	}
	
		
	function SessionAlert($msg,$key='flash'){
		$this->Session->setFlash("
			<script type=\"text/javascript\">
			$(function(){
				window.alert(\"".$msg."\");
			});
			</script>
		",null,array(),$key);
	}

}//end of class