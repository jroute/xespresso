<?php
class Menu extends AppModel {

	var $name = "Menu";
	var $actsAs = array('Tree','GroupTree');

	var $validate = array(
									'name' => array('rule' => 'notEmpty','required' => true)
									);

	function loadSubMenu(){

		$folder = new Folder(APP."views".DS.'elements'.DS);

		$folderlist = $folder->read(true,false,false);
		
		$subMenus = Array();
		foreach($folderlist[1] as $_file){
			list($fn,) = explode('.',$_file);
			if( ereg('^submenu_',$_file) ) $subMenus[$fn] = $fn;
		}//end of foreach

		return $subMenus;

	}//end of function loadModule


	function loadModule(){
	
    App::import('Xml'); 
    
		$folder = new Folder(ROOT.DS.'plugins'.DS);


		$folderlist = $folder->read(true,false,true);

		$Module = Array();
		$i= 0 ;
		foreach($folderlist[0] as $_file){

				$file = new File(trim($_file.DS.'index.xml'));
				if( $file->exists() ){
					
					
				 $xml = new Xml($_file.DS.'index.xml');
				 $xmlAsArray = $xml->toArray();				 

				 	$Module[$i]['name'] 				= trim($xmlAsArray['Plugin']['name']);
				 	$Module[$i]['plugin'] 			= trim($xmlAsArray['Plugin']['plugin']);				 
				 	$Module[$i]['controller'] 	= trim($xmlAsArray['Plugin']['controller']);
				 	$Module[$i]['model'] 				= trim($xmlAsArray['Plugin']['model']);
				 	$Module[$i]['action'] 			= trim($xmlAsArray['Plugin']['action']);
				 	$Module[$i]['primaryKey'] 	= trim($xmlAsArray['Plugin']['primaryKey']);
					$Module[$i]['fields'] 			= $xmlAsArray['Plugin']['Fields']['Field'];				 

					$i++;
				}
		}//end of foreach

		return $Module;

	}//end of function loadModule


	function getMenus($controller=null,$model=null, $pass=null){
			$menus['menu'] = $this->find('list',array('conditions'=>array('parent_id'=>null)));

			$menus['submenu'] = array();
			if( $controller ){
				$conditions['controller'] = $controller;
				if( $model ) $conditions['model'] = $model;
				if( $pass ) $conditions['pass'] = $pass;
				
				
				$menu = $this->find('first',array('conditions'=>$conditions));
				
				$path = $this->getpath($menu['Menu']['id']);
				$menus['root'] = $path[0]['Menu'];

				$submenus = $this->children($menus['root']['id']);
					
				$menus['submenu'][0]['id']		= $menus['root']['id'];
				$menus['submenu'][0]['name']	= $menus['root']['name'];
				$menus['submenu'][0]['lft']		=  $menus['root']['lft'];
				$menus['submenu'][0]['rght']	= $menus['root']['rght'];
				$menus['submenu'][0]['link']	= '#';

				$diff = 1;
				$s = 0;
				$e = 0;
				foreach($submenus as $key=>$submenu){
					
			
					if( $submenu['Menu']['lft'] > $s && $submenu['Menu']['lft'] < $e ){
						$prifix = '━━';
					}else if( ( $submenu['Menu']['rght'] - $submenu['Menu']['lft']) == 1 ){
						$prifix = '━';		
					}elseif( ( $submenu['Menu']['rght'] - $submenu['Menu']['lft']) > 1 ){
						$s = $submenu['Menu']['lft'];
						$e = $submenu['Menu']['rght'];
						$prifix = '━';
					}
					$menus['submenu'][$key+1]['id']			= $submenu['Menu']['id'];
					$menus['submenu'][$key+1]['name']	= $prifix.$submenu['Menu']['name'];
					$menus['submenu'][$key+1]['link']	= $submenu['Menu']['link'];
					$menus['submenu'][$key+1]['lft']	= $submenu['Menu']['lft'];
					$menus['submenu'][$key+1]['rght']	= $submenu['Menu']['rght'];
					$menus['submenu'][$key+1]['diff']	= $submenu['Menu']['rght'] - $submenu['Menu']['lft'];
				}
			}

			return $menus;
	}


	function getSubMenus($controller=null,$action=null,$pass=null){
			$menus['menu'] = $this->find('list',array('conditions'=>array('parent_id'=>null)));

			$menus['submenu'] = array();
			if( $controller ){
				
				$conditions['Menu.controller'] = $controller;
				if( $action ){
					$conditions['Menu.action'] = $action;				
				}
				if( $pass ){
					$conditions['Menu.pass'] = $pass;
				}
				
				$menu = $this->find('first',array('conditions'=>$conditions,'fields'=>array('id','x','y','z','html_header','html_footer'),'order'=>'id desc'));

				$menus['current'] = $menu['Menu'];
				$path = $this->getpath($menu['Menu']['id']);

				$menus['root'] = $path[0]['Menu'];

				$submenus = $this->children($menus['root']['id']);
					
				$s = 0;
				$e = 0;
				foreach($submenus as $key=>$submenu){
					
			
					if( $submenu['Menu']['lft'] > $s && $submenu['Menu']['lft'] < $e ){
						$prifix = '━━';
					}else if( ( $submenu['Menu']['rght'] - $submenu['Menu']['lft']) == 1 ){
						$prifix = '';		
					}elseif( ( $submenu['Menu']['rght'] - $submenu['Menu']['lft']) > 1 ){
						$s = $submenu['Menu']['lft'];
						$e = $submenu['Menu']['rght'];
						$prifix = '';
					}
					$menus['submenu'][$key]['id']			= $submenu['Menu']['id'];
					$menus['submenu'][$key]['name']	= $prifix.$submenu['Menu']['name'];
					$menus['submenu'][$key]['link']	= $submenu['Menu']['link'];
					$menus['submenu'][$key]['x']	= $submenu['Menu']['x'];
					$menus['submenu'][$key]['y']	= $submenu['Menu']['y'];
					$menus['submenu'][$key]['z']	= $submenu['Menu']['z'];
				}
			}

			return $menus;
	}

	function getSubFile($controller,$action=null,$pass=null){

				$conditions['Menu.controller'] = $controller;
				if( $action ){
					$conditions['Menu.action'] = $action;				
				}
				if( $pass ){
					$conditions['Menu.pass'] = $pass;
				}

				$menu = $this->find('first',array('conditions'=>$conditions));
				
				if( $menu['Menu']['id'] ){
					$path = $this->getpath($menu['Menu']['id']);
					for( $i = count($path) ; $i >= 0 ; $i-- ){
						if( empty($path[$i]['Menu']['submenu']) ) continue;
						return $path[$i]['Menu']['submenu'];
						break;
					}
				}
		return null;
	}
}
?>