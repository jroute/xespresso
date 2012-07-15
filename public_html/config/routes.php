<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::parseExtensions('rss');

 	Router::connect('/:language/board/:action/*', array('plugin'=>'board','controller'=>'board'),  array('language' => '[a-z]{2}'));  	

// 	Router::connect('/:language/:controller/:action/*', array(),  array('language' => '[a-z]{2}'));
 	
 	 
	Router::connect('/', array('plugin'=>'index','controller' => 'index', 'action' => 'home'));
	Router::connect('/home/*', array('plugin'=>'index','controller' => 'index','action'=>'home'));	
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	//Settings
	Router::connect('/webadm/setup/:action/*', array('plugin'=>'setup','controller'=>'setup','webadm'=>true));
		 
	Router::connect('/captcha/:action/*', array('plugin'=>'captcha','controller' => 'captcha'));
	 
	Router::connect('/webadm', array('plugin'=>'users','controller'=>'users', 'action'=>'login','webadm'=>true));
	Router::connect('/webadm/openid', array('plugin'=>'users','controller'=>'users', 'action'=>'openid','webadm'=>true));	
		 
	Router::connect('/search/*', array('plugin'=>'search','controller' => 'search', 'action' => 'index'));
	Router::connect('/webadm/search/*', array('plugin'=>'search','controller'=>'search','action'=>'index','webadm'=>true));
	 

	Router::connect('/contents/edit/*', array('plugin'=>'contents','controller' => 'contents', 'action' => 'edit'));	 
	Router::connect('/contents/*', array('plugin'=>'contents','controller' => 'contents', 'action' => 'view'));
	Router::connect('/webadm/contents/:action/*', array('plugin'=>'contents','controller'=>'contents','webadm'=>true));
		

	Router::connect('/board/:action/*', array('plugin'=>'board','controller'=>'board'));
	Router::connect('/webadm/board/:action/*', array('plugin'=>'board','controller'=>'board','webadm'=>true));
	Router::connect('/webadm/board_setup/:action/*', array('plugin'=>'board','controller'=>'board_setup','webadm'=>true));
	
	Router::connect('/comment/:action/*', array('plugin'=>'comment','controller'=>'comment'));
	Router::connect('/webadm/comment/:action/*', array('plugin'=>'comment','controller'=>'comment','webadm'=>true));
		
	Router::connect('/menus/:action/*', array('plugin'=>'menus','controller'=>'menus'));
	Router::connect('/webadm/menus/:action/*', array('plugin'=>'menus','controller'=>'menus','webadm'=>true));

	Router::connect('/zipfinder/:action/*', array('plugin'=>'zipfinder','controller'=>'zipfinder'));		
		
	Router::connect('/popup/:action/*', array('plugin'=>'popup','controller'=>'popup'));
	Router::connect('/webadm/popup/:action/*', array('plugin'=>'popup','controller'=>'popup','webadm'=>true));	
	//팝업존
	Router::connect('/popupzone/:action/*', array('plugin'=>'popup','controller'=>'popupzone'));
	Router::connect('/webadm/popupzone/:action/*', array('plugin'=>'popup','controller'=>'popupzone','webadm'=>true));					
		
	Router::connect('/logs/:action/*', array('plugin'=>'logs','controller'=>'logs'));
	Router::connect('/webadm/logs/:action/*', array('plugin'=>'logs','controller'=>'logs','webadm'=>true));		
	
	Router::connect('/users/:action/*', array('plugin'=>'users','controller'=>'users'));
	Router::connect('/webadm/users/:action/*', array('plugin'=>'users','controller'=>'users','webadm'=>true));		
	
	Router::connect('/poll/:action/*', array('plugin'=>'poll','controller'=>'poll'));
	Router::connect('/webadm/poll/:action/*', array('plugin'=>'poll','controller'=>'poll','webadm'=>true));			

	Router::connect('/calendar/:action/*', array('plugin'=>'calendar','controller'=>'calendar'));
	Router::connect('/webadm/calendar/:action/*', array('plugin'=>'calendar','controller'=>'calendar','webadm'=>true));				

	Router::connect('/fileattach/:action/*', array('plugin'=>'fileattach','controller'=>'fileattach'));		
		
	Router::connect('/snsapi/:action/*', array('plugin'=>'snsapi','controller'=>'snsapi'));	
	
	Router::connect('/ratings/:action/*', array('plugin'=>'ratings','controller'=>'ratings'));		
	

	
	//마이제피이지
	Router::connect('/mypage/:action/*', array('plugin'=>'mypage','controller'=>'mypage'));	

	Router::connect('/webadm/acl/:action/*', array('plugin'=>'acl','controller'=>'acl','webadm'=>true));		
	
	
	
	
	
	Router::connect('/html-css', array('plugin'=>'index','controller'=>'index','html-css'));		
	Router::connect('/javascript', array('plugin'=>'index','controller'=>'index','javascript'));		
	Router::connect('/java', array('plugin'=>'index','controller'=>'index','java'));		
	Router::connect('/php', array('plugin'=>'index','controller'=>'index','php'));		
	Router::connect('/ios-android', array('plugin'=>'index','controller'=>'index','ios-android'));		
	Router::connect('/database', array('plugin'=>'index','controller'=>'index','database'));
	Router::connect('/was', array('plugin'=>'index','controller'=>'index','was'));	
	Router::connect('/server', array('plugin'=>'index','controller'=>'index','server'));
	Router::connect('/community', array('plugin'=>'index','controller'=>'index','community'));
	