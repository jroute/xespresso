<?php

class BoardController extends BoardAppController {

	var $name = "Board";

			

	var $bid = null;
	var $setup = array();
	var $paginate = array(
									'conditions'=>array(
										'Board.deleted'=>null
									),
									'fields'=>array(
										'Board.no',
										'Board.sort_depth',
										'Board.userid',
										'Board.email',										
										'Board.category',
										'Board.name',									
										'Board.subject',
										'Board.content',
										'Board.total_comment',
										'Board.hit',
										'Board.created',
										'BoardCategory.name',
										'User.profile'																																														
									),
									'order' => array(
													'Board.sort_no' => 'asc'
													)
							);
 
	var $admin = array('level'=>0);
	var $user = array('level'=>0);
	var $level = array();
	var $approval = array(0=>'승인대기',1=>'승인완료');


	function beforeFilter(){
	
		if( $this->action == 'fileupload' ){
			$this->Session->start();
		}

		parent::beforeFilter();

		if( ($chk = $this->Session->read('Board.CheckNumber'.$this->action)) ){
			if( @$this->params['pass'][1] != $chk ) $this->Session->delete('Board.CheckNumber'.$this->action);
		}
		
		
		if( $this->action != 'latest' ){

			$this->bid = @$this->params['pass'][0];
	
			$this->set('approval',$this->approval);
	
			if( empty($this->bid) || $this->bid == "" ){
				$this->redirect('/');
			}
	
	
			$this->setup = Cache::read('board.setup.'.$this->bid);
			if( $this->setup == false ){
				$this->setup = $this->BoardSetup->getSetup($this->bid);
				Cache::write('board.setup.'.$this->bid,$this->setup);
			}
			
	
			if( empty($this->setup) ){
				$this->redirect('/');
			}
	
			$this->set('setup',$this->setup);
	
			$this->user = $this->Session->read('User');
			if( empty($this->user['level']) ) $this->user['level'] = 0;
	
			$this->level = unserialize($this->setup['auth_level']);
			$this->set('level',$this->level);
	
	
			if( @$this->data['Board']['passwd'] ){
				$this->data['Board']['passwd'] = Security::hash($this->data['Board']['passwd'],'md5',true);
			}
			if( @$this->data['Comment']['passwd'] ){
				$this->data['Comment']['passwd'] = Security::hash($this->data['Comment']['passwd'],'md5',true);
			}
	
			if( $this->setup['use_category'] ){
				$categories = Cache::read('board.categories.'.$this->bid);
				if( $categories == false ){
					$categories = $this->BoardCategory->generatetreelist(array('bid'=>$this->bid), null, null, '━');
					Cache::write('board.categories.'.$this->bid,$categories);
				}
				$this->set("categories",$categories);
			}
			
			//필터링
			$this->Board->filter = $this->setup['filter_word'];		
			if( $this->setup['filter_ip'] ){
	      $ips = implode("|",explode("\r\n",trim(str_replace('.',',',$this->setup['filter_ip']))));
	      $ip = str_replace('.',',',$_SERVER['REMOTE_ADDR']);
	
	      if( eregi($ips,$ip) ){
	      	$this->SessionAlert('사용하시는 아이피는 접근 제한된 상태입니다.','flush');
	      	$this->redirect('/');
	      }
	
			} 
			
	
			
			if( empty($this->data) ){
	
			}else{//데이터 XSS 필터링
			
				if( $this->user['level'] >= 8 || $this->Session->Read('Admin.level') >= 8 ){ //부운영자 이상은 패스
	
				}else{
					if( @$this->data['Board']['name'] ) $this->data['Board']['name'] = $this->Board->XSS(@$this->data['Board']['name']);
					if( @$this->data['Board']['subject'] ) $this->data['Board']['subject'] = $this->Board->XSS(@$this->data['Board']['subject']);
					if( @$this->data['Board']['content'] ) $this->data['Board']['content'] = $this->Board->XSS(@$this->data['Board']['content']);
	
					if( @$this->data['Comment']['comment'] )  $this->data['Comment']['comment'] = $this->Board->XSS(@$this->data['Comment']['comment']);
				}
	
				//add 2009-10-29 captcha
				if( $this->setup['use_captcha'] && !ereg("webadm_",$this->action) ){
	
					$this->Board->validate = Set::merge($this->Board->validate, array(
						'captcha'=>array(
						'required'=>true,
						'minLength'=>6,
						'rule'=>'compcaptcha'
						)
					));
				}
			}
	
			$this->paginate['limit'] = $this->setup['list_rows'];
	
			//Administrator
			if( eregi("webadm_",$this->action) ){
	
				$this->admin = $this->Session->read('Admin');
	
				$this->set("boards", $boards = $this->BoardSetup->find('all',array('conditions'=>array('deleted'=>null),'fields'=>array('bid','bname'))));
	
				$BoardAll = array();
				foreach($boards as $row){
					$setup = array_shift($row);
					if( $setup['bid'] == $this->bid ) continue;
					$BoardAll[$setup['bid']] = $setup['bname'];
				}
				$this->set('BoardAll',$BoardAll);
			}else{
			
				$this->set('title_for_layout',$this->setup['bname']);
			
			}
		}
		

	}
	/**
	* element
	*/
	function latest()
	{
		$this->autoRender = false;	
		
		$rows =  $this->Board->latest($this->params);	
		
		if( $this->params['requested'] ){
			return $rows;
		}else{
			$this->set('rows',$rows);		
		}
	}
	
	/***
	 *
	 */
	function index(){
		//empty
	}

	/***
	 * @params	: string $bid
	 */
	function search($bid=null){
		//empty
	}

	function rss($bid){
		
		Configure::write('debug',0);
		
		$this->layout = null;

		$conditions = $this->create_conditions($bid);
		$items = $this->Board->find('all',array('conditions'=>$conditions));
		
		if( $this->RequestHandler->isRss() ){
			return $this->set(compact('items'));
		}




		$setup = $this->setup;
		

		list($date,$time) = explode(' ',$setup['modified']);
		list($year,$month,$day) = explode("-",$date);
		list($hour,$minute,$second) = explode(":",$time);
		$setup['pubDate'] = date("D, d M Y H:i:s +9000",mktime($hour,$minute,$second,$month,$day,$year));

		$this->set(compact('bid','items','site','setup'));

		$this->render('rss');
		
	}

	function alert($msg,$return_url=null){
		if( $return_url == null ) $return_url = "javascript:window.history.back()";

		$this->set('msg',$msg);
		$this->set('return_url',$return_url);
		
		$this->render("skins".DS.(@$this->setup['skin']?$this->setup['skin']:'default').DS.'alert');
	}
	

	function download($bid,$no,$fid){
		
		Configure::write('debug',0);
		$this->autoRender = false;
		
		set_time_limit(0);
		
		if( $this->user['level'] >= $this->level['lv_read'] ) {

			$data = $this->Board->find('first',array('conditions'=>array('Board.deleted'=>null,'Board.bid'=>$bid,'Board.no'=>$no)));
			
			if( (int)$data['Board']['no'] == 0 ){
				return $this->alert("게시물이 삭제되었거나 존재하지 않습니다.",'/board/lst/'.$bid);	
			}

		}else{
		
			return $this->alert("다운로드 권한이 없습니다.");
		}
				

		$files = $this->Fileattach->find('first',array(
			'conditions'=>array(
				'plugin'=>'board',
				'parent_id'=>$no,
				'id'=>$fid
			)
		));


		if( $files['Fileattach']['name'] && file_exists(APP.'webroot'.DS.'files'.DS.'board'.DS.$bid.DS.$files['Fileattach']['fsname']) ){

			$files['Fileattach']['size'] = filesize(APP.'webroot'.DS.'files'.DS.'board'.DS.$bid.DS.$files['Fileattach']['fsname']);


			$fp = fopen(APP.'webroot'.DS.'files'.DS.'board'.DS.$bid.DS.$files['Fileattach']['fsname'], 'rb');

			//ini_set('zlib.output_compression', 'off');
			if( ereg('MSIE',$_SERVER['HTTP_USER_AGENT']) ){			
				header('Content-Disposition: attachment; filename="' . urlencode($files['Fileattach']['name']) . '"');
			}else{
				header('Content-Disposition: attachment; filename="' . $files['Fileattach']['name'] . '"');			
			}
			header('Content-Transfer-Encoding: binary');
			header('Last-Modified: ' . date ("F d Y H:i:s.", getlastmod()));
			header('Content-Length: ' . $files['Fileattach']['size']);
			header('Content-Type: ' . $this->Fileattach->getMIMEType($files['Fileattach']['name']));
			header('Cache-Control: private');
			header('Pragma: no-cache'); 
			header('Connection: close');
			fpassthru($fp);
			fclose($fp);
			
			$this->Fileattach->updateAll(array('download'=>'download+1'),array('id'=>$files['Fileattach']['id']));
		}else{
			return $this->alert('파일이 존재 하지 않습니다.');
		}
	}
	

	function create_conditions($bid){
	
          $keyword = trim(@$this->passedArgs['keyword']);
          $keyword = str_replace(array("'"),"",$keyword);
          $tag = @$this->passedArgs['tag'];
          $ss = @$this->passedArgs['ss'];
          $sc = @$this->passedArgs['sc'];
          $sn = @$this->passedArgs['sn'];
          $fields = @$this->passedArgs['fields'];          

          $category = trim(@$this->passedArgs['category']);

          $conditions = array('Board.bid'=>$bid);

          if( $category ) array_push($conditions,array('Board.category'=>$category));

		if( $tag ){
			
			$tags = $this->Tag->getByTag($keyword);

			  $this->Board->bindModel(
				 array(
					'hasOne' => 
						array(
							'BoardTag' => 
								array(
									'className' => 'BoardTag',
									'foreignKey'   => 'bno',
								)
						)
				 ),false
			 );
			array_push($conditions,array('BoardTag.tagid'=>$tags['id']));
		}
          
		if( $keyword ){
			$condition = array();
			if( $ss ) array_push($condition,array('Board.subject LIKE'=>"%$keyword%"));
			if( $sc ) array_push($condition,array('Board.content LIKE'=>"%$keyword%"));
			if( $sn ) array_push($condition,array('Board.name LIKE'=>"%$keyword%"));
			if( $fields ) array_push($conditions,array('Board.'.$fields.' LIKE'=>"%$keyword%"));

			switch(count($condition)){
				case 3:
				case 2: array_push($conditions,array('OR'=>$condition)); break;
				case 1: array_push($conditions,$condition); break;
			}
		}
		
		//승인 기능 + 로그인 상태, 승인 대기전 본인 글은 보이도록 처리
		//관리자 페이지에서는 제외
		$RoutingPrefixes = Configure::read('Routing.prefixes');	
		if( !ereg('^'.$RoutingPrefixes[0],$this->action) && $this->setup['use_approve'] ){
		
			array_push($conditions,array('Board.opt_approval'=>1));						
			if( $this->Session->Read('User.userid') ){
				array_push($conditions,array('Board.userid'=>$this->Session->Read('User.userid')));			
			}
		}else{
		
		}
		return $conditions;
	}
	
	
	
	
	
	
	
	
	function __lst($bid){

		//setting url page parameters
		if( @$this->params['url']['keyword'] || @$this->params['url']['category'] ){
			$this->passedArgs = $this->data['Board'] = $this->params['url'];

			unset($this->data['Board']['url']);
			unset($this->passedArgs['url']);
			$this->params['named'] = $this->passedArgs;		
		}else{
			$this->data['Board'] = $this->passedArgs;		
		}
		$this->passedArgs[0] = $bid;
		
		$conditions = $this->create_conditions($bid);
		
		$rows = $this->paginate('Board',$conditions);

			
		if( ereg("L|T|G",trim(@$this->params['url']['ls'])) ){
			$this->setup['list_style'] = trim($this->params['url']['ls']);
		}

		
		$datas = array();
		foreach($rows as $i=>$row){
			$datas[$i] = $row;

			$spacer = '';
			for($depth = 0 ; $depth < $row['Board']['sort_depth']; $depth++){
				$spacer .= '&nbsp;&nbsp;';
			}
			$datas[$i]['Board']['spacer'] = $spacer;
			$datas[$i]['Board']['subject'] = strcut($row['Board']['subject'],$this->setup['maxlength']);
			$datas[$i]['Board']['crypt_userid']='';
			if( $row['Board']['userid'] )
			{
				$datas[$i]['Board']['crypt_userid'] = $this->Crypter->encrypt($row['Board']['userid'].'⇋'.time().'⇋'.$row['Board']['no']);
			}
			

			$datas[$i]['Fileattach'] = array();
			//파일
			if( $this->setup['use_file'] || eregi('T|G',$this->setup['list_style']) ){

				if( eregi('T|G',$this->setup['list_style']) ){
					$conditions = array(
							'plugin'=>'board',
							'parent_id'=>$row['Board']['no'],
							'deleted'=>null,
							'type RegExp'=>'^image',
					);
					$limit = 1;
				}else{
					$conditions = array(
							'plugin'=>'board',
							'parent_id'=>$row['Board']['no'],
							'deleted'=>null
					);
					$limit = null;
				}
				$files = $this->Fileattach->find('first',
					array(
						'conditions'=>$conditions,
						'fields'=>array('name','fsname'),
						'order'=>array('expose'=>'desc'),
						'limit'=>$limit
					)
				);

				if( @$files['Fileattach']['name'] ){
					$datas[$i]['Fileattach'] = $files['Fileattach'];
					$datas[$i]['Fileattach']['ext'] = $this->Fileattach->getFileExtension($files['Fileattach']['name']);

					//thumb 경로
					$folder = new Folder();
					$dir_thumb = APP.'webroot/files/board/'.$bid.'/thumb/';


					$folder->create($dir_thumb);

					if( $this->setup['list_style'] == "T" ){
						list($w,$h) = explode('x',$this->setup['thumb_size_list']);					
						$newImage = $bid.'_'.$w.'x'.$h.'_'.$datas[$i]['Fileattach']['fsname'];
						if( !file_exists($dir_thumb.$newImage) ){
							$this->Image->resizeImage('resizeCrop',APP.'webroot/files/board/'.$bid, $datas[$i]['Fileattach']['fsname'], $dir_thumb , $newImage,$w,$h);
						}
					}elseif( $this->setup['list_style'] == "G" ){

						list($w,$h) = explode('x',$this->setup['thumb_size_gallery']);
						$newImage = $bid.'_'.$w.'x'.$h.'_'.$datas[$i]['Fileattach']['fsname'];
						if( !file_exists($dir_thumb.$newImage) ){
							$this->Image->resizeImage('resizeCrop',APP.'webroot/files/board/'.$bid, $datas[$i]['Fileattach']['fsname'], $dir_thumb, $newImage,$w,$h);
						}
					}

					if( @$newImage ) $datas[$i]['Fileattach']['thumb'] = '/files/board/'.$bid.'/thumb/'.$newImage;
				}else{
					$datas[$i]['Fileattach']['ext'] = 'none';
				}
			}//end of files
		}

//공지글
		$nrows = array();
		if( @$this->setup['use_notice'] ){
			$nrows = $this->Board->find('all',array(
				'conditions'=>array('Board.opt_notice'=>'1','Board.bid'=>$bid,'Board.deleted'=>null),
				'fields'=>array('Board.no',
										'Board.sort_depth',
										'Board.userid',
										'Board.email',										
										'Board.category',
										'Board.name',									
										'Board.subject',
										'Board.content',
										'Board.total_comment',
										'Board.hit',
										'Board.created',
										'BoardCategory.name',
										'User.profile'),
				'order'=>array('Board.created'=>'DESC')
				
				)
			);
			
			foreach($nrows as $Tkey=>$noti){
				$noti['Board']['crtypt_userid']='';
				if( $noti['Board']['userid'] )
				{
					$noti['Board']['crtypt_userid'] = $this->Crypter->encrypt($noti['Board']['userid'].'⇋'.time().'⇋'.$noti['Board']['no']);
				}
				
							
				$noti['Board']['subject'] = strcut($noti['Board']['subject'],$this->setup['maxlength']);	
			

			if( $this->setup['use_file'] ){
					$conditions = array(
							'plugin'=>'board',
							'parent_id'=>$noti['Board']['no'],
							'deleted'=>null
					);
					$limit = null;
				$files = $this->Fileattach->find('first',
					array(
						'conditions'=>$conditions,
						'fields'=>array('name','fsname'),
						'limit'=>$limit
					)
				);
				if( @$files['Fileattach']['name'] ){
					$nrows[$Tkey]['Fileattach'] = $files['Fileattach'];
					$nrows[$Tkey]['Fileattach']['ext'] = $this->Fileattach->getFileExtension($files['Fileattach']['name']);
				}else{
					$nrows[$Tkey]['Fileattach']['ext'] = 'none';
				}
			}//end of files

		}
	}
		$this->set('nrows',$nrows);
			
		//동영상 타입인 경우 최근 게시물 하나 셋
		if( @$this->setup['list_style'] == 'M' ){

			if( empty($this->passedArgs['no']) ){
				$this->data = $this->Board->find('first',array('conditions'=>array('Board.deleted'=>null,'Board.bid'=>$bid),'order'=>array('Board.sort_no'=>'asc')));
			}else{
				$this->data = $this->Board->find('first',array('conditions'=>array('Board.deleted'=>null,'Board.bid'=>$bid,'Board.no'=>$this->passedArgs['no'])));
			}
		}

		$this->set('rows',$datas);	
	}
	
	
	

	/***
	 * @params	: string $bid
	 */
	function ls($bid=null){
	
		$this->set("bid",$bid);

		//권한 체크
		if( @$this->user['level'] >= @$this->level['lv_list'] ){

		}else{
			$this->redirect(array('controller'=>'users','action'=>'login','redirect:'.base64_encode('/board/lst/'.$bid)));
			//return $this->alert("권한이 없습니다.");
		}
		$this->__lst($bid);


		switch(@$this->setup['list_style']){
			case "T": $view = "lst_thumb"; break;
			case "G": $view = "lst_gallery"; break;
			default:
			case "L": $view = "lst"; break;
		}
		
//		print_R($this);
		$this->render("skins".DS.@$this->setup['skin'].DS.$view);
		
	}	
	
	/***
	 * @params	: string $bid
	 */
	function lst($bid=null){
	
		$this->set("bid",$bid);

		//권한 체크
		if( @$this->user['level'] >= @$this->level['lv_list'] ){

		}else{
			$this->redirect(array('controller'=>'users','action'=>'login','redirect:'.base64_encode('/board/lst/'.$bid)));
			//return $this->alert("권한이 없습니다.");
		}
//		$this->__lst($bid);


		switch(@$this->setup['list_style']){
			case "T": $view = "list_thumb"; break;
			case "G": $view = "list_gallery"; break;
			default:
			case "L": $view = "list"; break;
		}
		
//		print_R($this);
		$this->render("skins".DS.@$this->setup['skin'].DS.$view);
		
	}


	/***
	 * @params	: string $bid
	 * @params	: int $no
	 */
	function view($bid,$no=0){

		$this->set(compact('bid','no'));
		
		if( (int)$no == 0  ){
			return $this->alert("잘못된 접근입니다.",'/');
		}

		//권한 체크
		if( $this->action == "view" && $this->user['level'] >= $this->level['lv_read'] ) {

			$data = $this->Board->find('first',array('conditions'=>array('Board.deleted'=>null,'Board.bid'=>$bid,'Board.no'=>$no)));
			
			if( (int)$data['Board']['no'] == 0 ){
				return $this->alert("게시물이 삭제되었거나 존재하지 않습니다.",'/board/lst/'.$bid);	
			}

			foreach($data['Fileattach'] as $i=>$files){
				$data['Fileattach'][$i]['ext'] = $this->Fileattach->getFileExtension($files['name']);
			}
			
			//승인 상태 체크
			if( $this->setup['use_approve'] && $data['Board']['opt_approval'] == '0'){
				if( !$this->Session->Read('User.check') || 
				( $this->Session->Read('User.check') && $this->Session->Read('User.userid') != $data['Board']['userid'] ) ){
					return $this->alert("관리자 승인 대기 상태입니다.",'/board/lst/'.$bid);				
				}
			}

		}else{
			return $this->alert("읽기 권한이 없습니다.");
		}

		$data['Board']['crypt_userid'] = $this->Crypter->encrypt($data['Board']['userid'].'⇋'.time().'⇋'.$data['Board']['no']);		

		//tag
		$tags = $this->BoardTag->getByBno($bid,$no);
		$tag = array();
		foreach($tags as $item){			$tag[] = $item['Tag']['tag']; }
		$data['Board']['tags'] = implode(', ',$tag);


		//set title
		$this->set('title_for_layout',$data['Board']['subject'].' - '.$this->setup['bname']);		


		$sort_no = $data['Board']['sort_no'];


		$conditions = $this->create_conditions($bid);

		$ndata = $this->Board->find('first',array(
																	'conditions'=>array_merge(array('Board.deleted'=>null,'Board.bid'=>$bid,'Board.sort_no <'=>$sort_no),$conditions),
																	'fields'=>array('Board.no','Board.subject'),
																	'order'=>array('Board.sort_no'=>'desc')
																	)
												 );
		$next = $ndata['Board'];


		$pdata = $this->Board->find('first',array(
																	'conditions'=>array_merge(array('Board.deleted'=>null,'Board.bid'=>$bid,'Board.sort_no >'=>$sort_no),$conditions),
																	'fields'=>array('Board.no','Board.subject'),																	
																	'order'=>array('Board.sort_no'=>'asc')
																	)
												 );
		$prev = $pdata['Board'];



		$this->set(compact("data",'prev','next'));

		if( $this->setup['list_style'] == 'G' ){
			$this->render("skins".DS.$this->setup['skin'].DS."view_gallery");
		}else{
			$this->render("skins".DS.$this->setup['skin'].DS."view");
		}

		$this->Board->updateHit($no);		

	}



	/***
	 * @params	: string $bid
	 * @params	: int $no
	 */
	function vprint($bid,$no=0){
		Configure::write('debug',0);
		
		$this->layout = "default";
		
		$this->set(compact('bid','no'));
		
		if( (int)$no == 0  ){
			return $this->alert("잘못된 접근입니다.",'/');
		}

		//권한 체크
		if( $this->user['level'] >= $this->level['lv_read'] ) {

			$data = $this->Board->find('first',array('conditions'=>array('Board.deleted'=>null,'Board.bid'=>$bid,'Board.no'=>$no)));
			
			if( (int)$data['Board']['no'] == 0 ){
				return $this->alert("게시물이 삭제되었거나 존재하지 않습니다.",'/board/lst/'.$bid);	
			}

			foreach($data['Fileattach'] as $i=>$files){
				$data['Fileattach'][$i]['ext'] = $this->Fileattach->getFileExtension($files['name']);
			}
			
			//승인 상태 체크
			if( $this->setup['use_approve'] && $data['Board']['opt_approval'] == '0'){
				if( !$this->Session->Read('User.check') || 
				( $this->Session->Read('User.check') && $this->Session->Read('User.userid') != $data['Board']['userid'] ) ){
					return $this->alert("관리자 승인 대기 상태입니다.",'/board/lst/'.$bid);				
				}
			}

		}else{
			return $this->alert("읽기 권한이 없습니다.");
		}
		
		$this->set(compact("data"));
		


		$this->render("skins".DS.$this->setup['skin'].DS."print");		

	}
	
	/***
	 * @params	: string $bid
	 */
	function write($bid){
		
		$no = null;
		$this->set(compact('bid','no'));

		//권한 체크
		if( $this->action == "write" && $this->user['level'] >= $this->level['lv_write'] ){

		}else{
			return $this->alert("쓰기 권한이 없습니다.");
		}

		if( empty($this->data) ){
				$this->data['Board'] = $this->Session->read('User');
				$this->data['Board']['bid'] = $bid;
				if( @$this->data['Board']['check'] ){
					$this->data['Board']['passwd'] = Security::hash($this->Session->id(),'md5',true);
				}
				if( array_key_exists('category',$this->passedArgs) ){
					$this->data['Board']['category'] = $this->passedArgs['category'];
				}
		}else{
			$this->data['Board']['ip'] = $_SERVER['REMOTE_ADDR'];

			list($this->data['Board']['sort_gno'],$this->data['Board']['sort_no'],$this->data['Board']['sort_depth']) = $this->Board->createSort("bid='$bid'");
			
			//승인 기능 활성화 경우 opt_approval = 0 으로 설정
			$this->data['Board']['opt_approval'] = '0';

			if( $this->Board->save($this->data,true) ){
				$no = $this->Board->getLastInsertID();

				//파일 저장
				$this->Fileattach->link($this->Session->id(),'board',$no);				

				$this->BoardSetup->setTotalArticles($bid,$this->Board->find('count',array('conditions'=>array('Board.bid'=>$bid))));


				//글등록 확인 메일 발송
				if( $this->setup['use_feedback'] ){

					$this->Email->from = $this->data['Board']['name'].' <'.$this->data['Board']['email'].'>';
					$this->Email->subject = $this->data['Board']['subject'];


					//카테고리별 담당자 메일 발송
					if( $this->setup['use_category'] && $this->data['Board']['category']){
							$category =$this->BoardCategory->find('first',array('conditions'=>array('bid'=>$bid,'id'=>$this->data['Board']['category']),'fields'=>'email'));
							$this->Email->to = ' <'.$category['BoardCategory']['email'].'>';
							$this->Email->send($this->data['Board']['content']);

					}else{
						if( $this->setup['feedback_email'] ){
							$this->Email->to = ' <'.$this->setup['feedback_email'].'>';
							$this->Email->send($this->data['Board']['content']);
						}
					}

				}

				//SMS 문자 발송
				if( $this->setup['use_sms'] ){

					//게시판 담당자 sms 발송
					$msg = preg_replace(array('/\[:board:\]/','/\[:name:\]/'),array($this->setup['bname'],$this->data['Board']['name']),$this->setup['feedback_sms_message']);
					$this->DacomSms->send(date('Y-m-d H:i:s'),$this->setup['feedback_sms'],$this->setup['feedback_sms'],$msg);
					
				}//end of use sms
				
				//태그 등록
				if( $this->setup['use_tag'] ){
					$this->addTag($bid,$no,$this->data['Board']['tags']);
				}				

				$this->redirect(array('action'=>'view',$bid,$no));
			}else{
				$this->data['Board']['check'] = $this->Session->read('User.check');
				
				if( @$this->data['Board']['check'] ){
					$this->data['Board']['passwd'] = Security::hash($this->Session->id(),'md5',true);
				}else{
          $this->data['Board']['passwd'] = '';				
				}
			}

		}

		$this->render("skins".DS.$this->setup['skin'].DS."form");
	}


	/***
	 * @params	: string $bid
	 * @params	: int $no
	 */
	function reply($bid,$no){

		
		$this->set(compact('bid','no'));


		//권한 체크
		if( $this->action == "reply" && $this->user['level'] >= $this->level['lv_reply'] ){

		}else{
			return $this->alert("답글 등록 권한이 없습니다.");
		}


		$sort = $this->Board->getSortArray($no);
		$max_gno = $this->Board->getMaxSortNo($sort['sort_gno']);

		//답글 제한
		if( substr($max_gno,-2) == "99" ){
			return $this->alert("더이상 답글을 등록 할 수 없습니다.","view/$bid/".$no);
		}

		if( empty($this->data) ){

				$this->data = $this->Board->find("Board.bid='$bid' and Board.no=$no");

				$this->data['Board']['check'] = @$this->user['check']; //login check

				if( @$this->data['Board']['check'] ){
					$this->data['Board']['passwd'] = Security::hash($this->Session->id(),'md5',true);
				}else{
					$this->data['Board']['passwd'] = "";
					$this->data['Board']['email'] = "";
					$this->data['Board']['homepage'] = "";
				}

				$this->data['Board']['subject'] = "[re]".$this->data['Board']['subject'];


				$user = $this->Session->read('User');
				$this->data['Board']['name'] = $user['name'];
				$this->data['Board']['email'] = $user['email'];
				$this->data['Board']['homepage'] = $user['homepage'];
				$this->data['Board']['bid'] = $bid;



		}else{
			$this->data['Board']['no'] = '';
			$this->data['Board']['ip'] = $_SERVER['REMOTE_ADDR'];

			list($this->data['Board']['sort_gno'],$this->data['Board']['sort_no'],$this->data['Board']['sort_depth']) = $this->Board->createSort("bid='$bid'",$no);

			//승인 기능 활성화 경우 opt_approval = 0 으로 설정
			$this->data['Board']['opt_approval'] = '0';

			if( $this->Board->save($this->data,true) ){

				$parent_no = $no;

				$no = $this->Board->getLastInsertID();

				$this->Fileattach->link($this->Session->id(),'board',$no);

				//담당자 메일 발송
				if( $this->setup['use_feedback'] ){
						$data = $this->Board->read(null, $parent_no);

						$this->Email->from = $this->data['Board']['name'].' <'.$this->data['Board']['email'].'>';
						$this->Email->subject = $this->data['Board']['subject'];
						$this->Email->to = ' <'.$data['Board']['email'].'>';
						$this->Email->send($this->data['Board']['content']);
				}
				//SMS 문자 발송
				//
				if( $this->setup['use_sms'] ){
					$data = $this->Board->read(null,$parent_no);
					if( $data['Board']['mobile'] ){
					//게시판 담당자 sms 발송
						$msg = preg_replace(array('/\[:board:\]/','/\[:name:\]/'),array($this->setup['bname'],$this->data['Board']['name']),'[:board:] 답변이 등록되었습니다.');
						$this->DacomSms->send(date('Y-m-d H:i:s'),$data['Board']['mobile'],$this->setup['feedback_sms'],$msg);
					}

					
				}//end of use sms
				
				//태그 등록
				if( $this->setup['use_tag'] ){
					$this->addTag($bid,$no,$this->data['Board']['tags']);
				}				

				$this->BoardSetup->setTotalArticles($bid,$this->Board->find('count',array('conditions'=>array('Board.bid'=>$bid))));
				$this->redirect("view/$bid/".$no);
			}else{
				$this->data['Board']['check'] = $this->Session->read('User.check');
				
				if( @$this->data['Board']['check'] ){
					$this->data['Board']['passwd'] = Security::hash($this->Session->id(),'md5',true);
				}else{
          $this->data['Board']['passwd'] = '';				
				}
			}
		}

		$this->render("skins".DS.$this->setup['skin'].DS."form");
	}



	/***
	 * @params	: string $bid
	 * @params	: int $no
	 */
	function edit($bid,$no){

		$this->set(compact('bid','no'));


		$data = $this->Board->find("Board.bid='$bid' and Board.no=$no");

		//권한 체크
		if( ($this->user['level'] >= $this->level['lv_edit']) || ( !empty($this->user['userid']) && $data['Board']['userid'] == $this->user['userid'] ) ){

		}else{
			$checkNumber = $this->Session->read('Board.CheckNumber'.$this->action);

			if(  empty($checkNumber)  ){
				$this->redirect(array('action'=>'confirm',$bid,$no,$this->action));
			}else if( $checkNumber == $no ){
				//pass
			}else{
				return $this->flash("수정 권한이 없습니다.","javascript:window.history.back()");
			}
		}


		if( empty($this->data) ){

			$this->data = $data;
			$this->data['Board']['check'] = @$this->user['check']; //login check
			if( @$this->user['userid'] ){
				$this->data['Board']['passwd'] = Security::hash($this->Session->id(),'md5',true);
			}else{
				$this->data['Board']['passwd'] = '';
			}

			//tag
			$tags = $this->BoardTag->getByBno($bid,$no);
			$tag = array();
			foreach($tags as $item){			$tag[] = $item['Tag']['tag']; }
			$this->data['Board']['tags'] = implode(', ',$tag);
		}else{
			$this->Board->id = $no;
			$this->data['Board']['no'] = $no;
			$this->data['Board']['ip'] = $_SERVER['REMOTE_ADDR'];

			//승인 기능 활성화 경우 opt_approval = 0 으로 설정
			//글 수정이 발생된 경우 이미 승인이 되어 있더라도, 글 내용이 변경되는 것이 므로 관리자의 승인 다시 필요함
			$this->data['Board']['opt_approval'] = '0';
			
			
			if( $this->Board->save($this->data) ){
				
				$this->Fileattach->link($this->Session->id(),'board',$no);
				$this->BoardSetup->setTotalArticles($bid,$this->Board->find('count',array('conditions'=>array('Board.bid'=>$bid))));

				//태그 등록
				if( $this->setup['use_tag'] ){
					$this->addTag($bid,$no,$this->data['Board']['tags']);
				}
				
				$this->redirect(array('action'=>'view',$bid,$no));
			}else{
				$this->data['Board']['check'] = $this->Session->read('User.check');
				
				if( @$this->data['Board']['check'] ){
					$this->data['Board']['passwd'] = Security::hash($this->Session->id(),'md5',true);
				}else{
          $this->data['Board']['passwd'] = '';				
				}
			}
		}

		$this->render("skins".DS.$this->setup['skin'].DS."form");
	}

	/***
	 * @params	: string $bid
	 * @params	: int $no
	 */
	function delete($bid,$no){

		$this->autoRender = false;

		$this->set(compact('bid','no'));

		$data = $this->Board->find("Board.bid='$bid' and Board.no=$no");

		$checkNumber = $this->Session->read('Board.CheckNumber'.$this->action);
		//권한 체크
		if( ( $this->user['level'] >= $this->level['lv_delete']) 
			|| ( !empty($this->user['userid']) && $data['Board']['userid'] == @$this->user['userid'] ) ){
			if(  empty($checkNumber)  ){
				$this->redirect(array('action'=>'confirm',$bid,$no,$this->action));
			}else if( $checkNumber == $no ){
				//pass
			}else{
				$this->redirect(array('action'=>'confirm',$bid,$no,$this->action));
            }
		}else{

			if(  empty($checkNumber)  ){
				$this->redirect(array('action'=>'confirm',$bid,$no,$this->action));
			}else if( $checkNumber == $no ){
				//pass
			}else{
				return $this->alert("삭제 권한이 없습니다.");
			}
		}


		$this->Board->id = $no;
		if( $this->Board->updateDel() ){

			$this->BoardSetup->setTotalArticles($bid,$this->Board->find('count',array('conditions'=>array('Board.bid'=>$bid))));

			$this->redirect(array('action'=>'lst'.$bid));
		}else{
			return $this->alert("Error 삭제 할 수 없습니다.");
		}
	}

	/***
	 * @params	: string $bid
	 * @params	: int $no
	 */
	function confirm($bid,$no,$action){

		$this->set(compact('bid','no','action'));

		$error = false;
		$delAuthority = false;

		$data = $this->Board->find("Board.bid='$bid' and Board.no=$no",array('fields'=>'Board.subject,Board.userid'));

		if( empty($this->data) ){
			//삭제 모드일 경우
			if( "delete" == $action ){
				//삭제 권한 체크
				if( ( $this->user['level'] >= $this->level['lv_delete']) 
					|| ( !@empty($this->user['userid']) && $data['Board']['userid'] == @$this->user['userid'] ) ) $delAuthority = true;
			}else if( "edit" == $action ){
				//수정 모드인경우 로그인 상태시 수정페이지로 이동
				if( !empty($data['Board']['userid']) && @$this->user['userid'] == $data['Board']['userid'] ){
					$this->redirect(array('action'=>'edit',$bid,$no));
				}
			}
		}else{

			if( "delete" == $action ){
				if( ($this->user['level'] >= $this->level['lv_delete']) 
					|| ( !@empty($this->user['userid']) && $data['Board']['userid'] == @$this->user['userid'] ) ){

					$this->Session->write(array("Board.CheckNumber".$action=>$no));
					$this->redirect($action.DS.$bid.DS.$no);	
				}
			}

			if( true === $this->Board->checkPassword($bid,$no,$this->data['Board']['passwd']) ){
				$this->Session->write(array("Board.CheckNumber".$action=>$no));
				$this->redirect($action.DS.$bid.DS.$no);
			}else{
				$error = true;
			}
		}
		$this->set(compact('error','delAuthority'));

		$this->data = $data;
		$this->render("skins".DS.$this->setup['skin'].DS."confirm");
	}
	

	/***
	 *
	 */
	function webadm_lst($bid=null){
		$this->set("bid",$bid);



		//권한 체크
		if( $this->admin['level'] >= $this->level['lv_list'] ){

		}else{
			$this->Session->setFlash("권한이 없습니다.");
            $this->redirect(array('action'=>'/webadm'));
		}


		//setting url page parameters

		if( count($this->passedArgs) > 1 ){
			$this->data['Board'] = $this->passedArgs;
		}else{
			$this->passedArgs = $this->data['Board'] = $this->params['url'];
			$this->passedArgs[0] = $bid;
			unset($this->data['Board']['url']);
			unset($this->passedArgs['url']);

		}
		

		$conditions = $this->create_conditions($bid);
		$rows = $this->paginate('Board',$conditions);
			
		if( ereg("L|T|G",trim(@$this->params['url']['ls'])) ){
			$this->setup['list_style'] = trim($this->params['url']['ls']);
		}
		switch(@$this->setup['list_style']){
			case "T": $view = "list_thumb"; break;
			case "G": $view = "list_gallery"; break;
			default:
			case "L": $view = "list"; break;
		}
		
		$datas = array();
		foreach($rows as $i=>$row){
			$datas[$i] = $row;
			$spacer = '';
			for($depth = 0 ; $depth < $row['Board']['sort_depth']; $depth++){
				$spacer .= '&nbsp;&nbsp;';
			}
			$datas[$i]['Board']['spacer'] = $spacer;

			$datas[$i]['Fileattach'] = array();
			//파일
			if( $this->setup['use_file'] || eregi('T|G',$this->setup['list_style']) ){

				if( eregi('T|G',$this->setup['list_style']) ){
					$conditions = array(
							'plugin'=>'board',
							'parent_id'=>$row['Board']['no'],
							'deleted'=>null,
							'type RegExp'=>'^image',
					);
					$limit = 1;
				}else{
					$conditions = array(
							'plugin'=>'board',
							'parent_id'=>$row['Board']['no'],
							'deleted'=>null
					);
					$limit = null;
				}
				$files = $this->Fileattach->find('first',
					array(
						'conditions'=>$conditions,
						'fields'=>array('name','fsname'),
						'order'=>array('expose'=>'desc'),
						'limit'=>$limit
					)
				);
				
				if( @$files['Fileattach']['name'] ){
					$datas[$i]['Fileattach'] = $files['Fileattach'];
					$datas[$i]['Fileattach']['ext'] = $this->Fileattach->getFileExtension($files['Fileattach']['name']);

					if( $this->setup['list_style'] == "T" ){
					
						list($w,$h) = explode('x',$this->setup['thumb_size_list']);										
						$newImage = $bid.'_'.$w.'x'.$h.'_'.$datas[$i]['Fileattach']['fsname'];
						if( !file_exists(APP.'webroot'.DS.'files'.DS.'board'.DS.$bid.DS.'thumb'.DS.$newImage) ){
							$this->Image->resizeImage('resize',APP.'webroot/files/board/'.$bid, $datas[$i]['Fileattach']['fsname'], APP.'webroot/files/board/'.$bid.'/thumb', $newImage,$w,$h);
						}
					}elseif( $this->setup['list_style'] == "G" ){
						list($w,$h) = explode('x',$this->setup['thumb_size_gallery']);					
						$newImage = $bid.'_'.$w.'x'.$h.'_'.$datas[$i]['Fileattach']['fsname'];

						if( !file_exists(APP.'webroot'.DS.'files'.DS.'board'.DS.$bid.DS.'thumb'.DS.$newImage) ){
							$this->Image->resizeImage('resize',APP.'webroot/files/board/'.$bid, $datas[$i]['Fileattach']['fsname'], APP.'webroot/files/board/'.$bid.'/thumb', $newImage,$w,$h);
						}
					}

					if( @$newImage ) $datas[$i]['Fileattach']['thumb'] = '/files/board/'.$bid.'/thumb/'.$newImage;
				}
			}//end of files
		}
		
//공지글
		$nrows = array();
		if( @$this->setup['use_notice'] ){
			$nrows = $this->Board->find('all',array('conditions'=>array('Board.opt_notice'=>'1','Board.bid'=>$bid,'deleted'=>null)));
			
			foreach($nrows as $Tkey => $noti){
				$noti['Board']['subject'] = strcut($noti['Board']['subject'],$this->setup['maxlength']);	
			

			if( $this->setup['use_file'] ){
					$conditions = array(
							'plugin'=>'board',
							'parent_id'=>$noti['Board']['no'],
							'deleted'=>'0'
					);
					$limit = null;
				$files = $this->Fileattach->find('first',
					array(
						'conditions'=>$conditions,
						'fields'=>array('name','fsname'),
						'limit'=>$limit
					)
				);
				if( @$files['Fileattach']['name'] ){
					$nrows[$Tkey]['Fileattach'] = $files['Fileattach'];
					$nrows[$Tkey]['Fileattach']['ext'] = $this->Fileattach->getFileExtension($files['Fileattach']['name']);
				}else{
					$nrows[$Tkey]['Fileattach']['ext'] = 'none';
				}
			}//end of files

		}
		}		
		$this->set('nrows',$nrows);
		
		$this->set(compact('datas'));


		$this->render('webadm_'.$view);
		
	}



	/***
	 * @params	: string $bid
	 * @params	: int $no
	 */
	function webadm_view($bid,$no){

		$this->set(compact('bid','no'));



		//권한 체크
		if( $this->admin['level'] >= $this->level['lv_read'] ) {

		}else{
			$this->Session->setFlash("읽기 권한이 없습니다.");
            $this->redirect(array('action'=>'lst',$bid));
		}


		if( empty($this->data['Comment']) ){
			$this->data['Comment']['model'] = 'Board';
			$this->data['Comment']['model_key'] = $bid;
			$this->data['Comment']['model_id'] = $no;


			if( @$this->admin['userid'] ){
				
				$this->data['Comment']['userid'] = $this->admin['userid'];
				$this->data['Comment']['name'] = $this->admin['name'];
				$this->data['Comment']['passwd'] = Security::hash($this->Session->id(),'md5',true);
				$this->data['Comment']['email'] = $this->admin['email'];
				$this->data['Comment']['homepage'] = $this->admin['homepage'];

			}else{

			}


		}else{

			if( empty($this->data['Comment']['no']) ){
				$this->data['Comment']['ip'] = $_SERVER['REMOTE_ADDR'];
				if( $this->Comment->save($this->data) ){
					$this->BoardSetup->setTotalComments($bid,$this->Comment->find('count',array('conditions'=>array('Comment.model'=>'Board','Comment.model_key'=>$bid))));
					$this->redirect(array('action'=>'view',$bid,$no));
				}
			}else{//댓글 삭제

				$cmt = $this->Comment->read(null,$this->data['Comment']['no']);

				$chk = false;
				if(  $this->Session->Read('Admin.level') >= @$this->level['lv_delete'] ){
					$chk = true;
				}else{

					if( $cmt['Comment']['passwd'] == $this->data['Comment']['passwd'] ){
						$chk = true;
					}else{
						$message = "비밀번호를 확인 하십시오";
					}
				}

				if( $chk === true ){
					if( $this->Comment->del($this->data['Comment']['no']) ){

						$this->BoardSetup->setTotalComments($bid,$this->Comment->find('count',array('conditions'=>array('Comment.model'=>'Board','Comment.model_key'=>$bid))));

						$this->redirect(array('action'=>'view',$bid,$no));
					}else{
						$this->Session->setFlash($message,$this->layout,array(),'comment');
						$this->redirect(array('action'=>'view',$bid,$no));
					}
				}else{
						$this->Session->setFlash($message,$this->layout,array(),'comment');
						$this->redirect(array('action'=>'view',$bid,$no));
				}

			}
		}


		$data = $this->Board->find('first',array('conditions'=>array('Board.deleted'=>null,'Board.bid'=>$bid,'Board.no'=>$no)));

		$sort_no = $data['Board']['sort_no'];

		foreach($data['Fileattach'] as $i=>$files){
			$data['Fileattach'][$i]['ext'] = $this->Fileattach->getFileExtension($files['name']);
		}

		$tags = $this->BoardTag->getByBno($bid,$no);

		$tag = array();
		foreach($tags as $item){
			$tag[] = $item['Tag']['tag'];
		}
		$data['Board']['tags'] = implode(' , ',$tag);


		$conditions = $this->create_conditions($bid);

		$ndata = $this->Board->find('first',array(
																	'conditions'=>array_merge(array('Board.bid'=>$bid,'Board.deleted'=>null,'Board.sort_no <'=>$sort_no),$conditions),
																	'fields'=>array('Board.no','Board.subject'),
																	'order'=>array('Board.sort_no'=>'desc')
																	)
												 );
		$next = $ndata['Board'];


		$pdata = $this->Board->find('first',array(
																	'conditions'=>array_merge(array('Board.bid'=>$bid,'Board.deleted'=>null,'Board.sort_no >'=>$sort_no),$conditions),
																	'fields'=>array('Board.no','Board.subject'),																	
																	'order'=>array('Board.sort_no'=>'asc')
																	)
												 );
		$prev = $pdata['Board'];


		//comments list
		$comments = array();
		$_comments = $this->Comment->find('all',array('conditions'=>array('model'=>'Board','model_id'=>$no,'model_key'=>$bid,'deleted'=>null),'order'=>array('created'=>'desc')));
		foreach($_comments as $key=>$comment){
			$comments[$key] = $comment['Comment'];
			$comments[$key]['comment'] = preg_replace(array('/<script/','/on([a-z]+)=/'),array('<xscript','xon\\1='),$comment['Comment']['comment']);
		}

		$this->set('comments',$comments);


		$this->set(compact("data",'prev','next'));
		
		if( $this->setup['list_style'] == 'G' ){
			$this->render("webadm_view_gallery");
		}else{		
			$this->render("webadm_view");
		}
	}

/***
	 * @params	: string $bid
	 */
	function webadm_write($bid){
		
		$no = null;
		$this->set(compact('bid','no'));


		//권한 체크
		if( $this->admin['level'] >= $this->level['lv_write'] ){

		}else{
			$this->Session->setFlash("쓰기 권한이 없습니다.");
            $this->redirect(array('actipn'=>'lst',$bid));
		}


		if( empty($this->data) ){
				$this->data['Board'] = $this->Session->read('Admin');
				$this->data['Board']['bid'] = $bid;
				if( @$this->data['Board']['check'] ){
					$this->data['Board']['passwd'] = Security::hash($this->Session->id(),'md5',true);
				}

			
		}else{
		
			$this->data['Board']['ip'] = $_SERVER['REMOTE_ADDR'];

			list($this->data['Board']['sort_gno'],$this->data['Board']['sort_no'],$this->data['Board']['sort_depth']) = $this->Board->createSort("bid='$bid'");

			if( $this->Board->save($this->data,true) ){

				$no = $this->Board->getLastInsertID();

				$this->Fileattach->link($this->Session->id(),'board',$no);

				$this->BoardSetup->setTotalArticles($bid,$this->Board->find('count',array('conditions'=>array('Board.bid'=>$bid))));

				//태그 등록
				if( $this->setup['use_tag'] ){
					$this->addTag($bid,$no,$this->data['Board']['tags']);
				}
                
				$this->redirect(array('action'=>'view',$bid,$no));
			}else{

			}
		}

		$this->render("webadm_form");
	}

	/***
	 * @params	: string $bid
	 * @params	: int $no
	 */
	function webadm_delete($bid,$no){

		$this->autoRender = false;

		$this->set(compact('bid','no'));

		$data = $this->Board->find("Board.bid='$bid' and Board.no=$no");

		$checkNumber = $this->Session->read('Board.CheckNumberdelete');
		//권한 체크
		if( $this->admin['level'] >= $this->level['lv_delete']  ){
			if(  empty($checkNumber)  ){
				$this->redirect(array('action'=>'confirm',$bid,$no,'delete'));
			}else if( $checkNumber == $no ){
				//pass
			}else{
				$this->redirect(array('action'=>'confirm',$bid,$no,'delete'));
            }
		}else{

			if(  empty($checkNumber)  ){
				$this->redirect(array('action'=>'confirm',$bid,$no,'delete'));
			}else if( $checkNumber == $no ){
				//pass
			}else{
				$this->Session->setFlash("삭제 권한이 없습니다.");
                $this->redirect(array('action'=>'view',$bid,$no));
			}
		}



		if( $this->Board->delete($no) ){
			$this->Session->setFlash("삭제 되었습니다.");
            $this->redirect(array('action'=>'lst',$bid));
		}else{
			$this->flash("Error : 삭제 할 수 없습니다.");
            $this->redirect(array('action'=>'view',$bid,$no));
		}
	}


	/***
	 * @params	: string $bid
	 * @params	: int $no
	 */
	function webadm_edit($bid,$no){

		$this->set(compact('bid','no'));

		$data = $this->Board->find('first',array('conditions'=>array('Board.bid'=>$bid,'Board.no'=>$no)));


		$tags = $this->BoardTag->getByBno($bid,$no);
		$tag = array();
		foreach($tags as $item){
			$tag[] = $item['Tag']['tag'];
		}
		$data['Board']['tags'] = implode(' ',$tag);

		//권한 체크
		if( $this->admin['level'] >= $this->level['lv_edit']  ){

		}else{
			$checkNumber = $this->Session->read('Board.CheckNumber'.$this->action);

			if(  empty($checkNumber)  ){
				$this->redirect(array('action'=>'confirm',$bid,$no,'edit'));
			}else if( $checkNumber == $no ){
				//pass
			}else{
				$this->Session->setFlash("수정 권한이 없습니다.");
                $this->redirect(array('action'=>'view',$bid,$no));
			}
		}


		if( empty($this->data) ){


			$this->data = $data;
			$this->data['Board']['check'] = @$this->admin['check']; //login check
			$this->data['Board']['passwd'] = Security::hash($this->Session->id(),'md5',true);

		}else{
			$this->Board->id = $no;
			$this->data['Board']['no'] = $no;
			$this->data['Board']['ip'] = $_SERVER['REMOTE_ADDR'];
			if( $this->Board->save($this->data) ){

				$this->Fileattach->link($this->Session->id(),'board',$no);
				
				//태그 등록
				if( $this->setup['use_tag'] ){
					$this->addTag($bid,$no,$this->data['Board']['tags']);
				}

				$this->redirect(array('action'=>'view',$bid,$no));
			}else{

			}
		}

		$this->render("webadm_form");
	}


	/***
	 * @params	: string $bid
	 * @params	: int $no
	 */
	function webadm_reply($bid,$no){

		
		$this->set(compact('bid','no'));

		//권한 체크
		if( $this->admin['level'] >= $this->level['lv_reply'] ){

		}else{
			$this->Session->setFlash("답글 등록 권한이 없습니다.");
			$this->redirect(array('action'=>'view',$bid,$no));
		}


		$sort = $this->Board->getSortArray($no);
		$max_gno = $this->Board->getMaxSortNo($sort['sort_gno']);

		//답글 제한
		if( substr($max_gno,-2) == "99" ){
			$this->Session->setFlash("더이상 답글을 등록 할 수 없습니다.");
			$this->redirect(array('action'=>'view',$bid,$no));
		}

		if( empty($this->data) ){

				$this->data = $this->Board->find("Board.bid='$bid' and Board.no=$no");

				$this->data['Board']['check'] = @$this->admin['check']; //login check

				if( @$this->data['Board']['check'] ){
					$this->data['Board']['passwd'] = Security::hash($this->Session->id(),'md5',true);
				}else{
					$this->data['Board']['passwd'] = "";
					$this->data['Board']['email'] = "";
					$this->data['Board']['homepage'] = "";
				}

				$this->data['Board']['subject'] = "[re]".$this->data['Board']['subject'];


				$user = $this->Session->read('Admin');
				$this->data['Board']['name'] = $user['name'];
				$this->data['Board']['email'] = $user['email'];
				$this->data['Board']['homepage'] = $user['homepage'];
				$this->data['Board']['bid'] = $bid;



		}else{
			$this->data['Board']['ip'] = $_SERVER['REMOTE_ADDR'];

			list($this->data['Board']['sort_gno'],$this->data['Board']['sort_no'],$this->data['Board']['sort_depth']) = $this->Board->createSort("bid='$bid'",$no);


			if( $this->Board->save($this->data,true) ){
				$no = $this->Board->getLastInsertID();


				$this->Fileattach->link($this->Session->id(),'board',$no);

				$this->BoardSetup->setTotalArticles($bid,$this->Board->find('count',array('conditions'=>array('Board.bid'=>$bid))));


				//태그 등록
				if( $this->setup['use_tag'] ){
					foreach(explode(' ',$this->data['Board']['tags']) as $tag){
						if( $tagid = $this->Tag->add($tag) ){
							$this->BoardTag->save($bid,$no,$tagid);
						}
					}
				}


				$this->redirect(array('action'=>'view',$bid,$no));
			}else{

			}
		}

		$this->render("webadm_form");
	}

	/***
	 * @params	: string $bid
	 * @params	: int $no
	 */
	function webadm_confirm($bid,$no,$action){

		$this->set(compact('bid','no','action'));

		$error = false;
		$delAuthority = false;

		$data = $this->Board->find("Board.bid='$bid' and Board.no=$no",array('fields'=>'Board.subject,Board.userid'));

		if( empty($this->data) ){
			//삭제 모드일 경우
			if( "delete" == $action ){
				//삭제 권한 체크
				if( $this->admin['level'] >= $this->level['lv_delete']  ) $delAuthority = true;
			}
		}else{

			if( "delete" == $action ){
				if( ($this->admin['level'] >= $this->level['lv_delete'])  ){

					$this->Session->write(array("Board.CheckNumber".$action=>$no));
					$this->redirect(array('action'=>$action,$bid,$no));
				}
			}

			if( true === $this->Board->checkPassword($bid,$no,$this->data['Board']['passwd']) ){
				$this->Session->write(array("Board.CheckNumber".$action=>$no));
				$this->redirect(array('action'=>$action,$bid,$no));
			}else{
				$error = true;
			}
		}
		$this->set(compact('error','delAuthority'));

		$this->data = $data;
		$this->render("webadm_confirm");
	}

	function webadm_multidelete(){
		$this->layout = null;
		$this->autoRender = false;


		foreach($_POST['no'] as $no){
			if( $no == '0' ) continue;
			$this->Board->delete($no);
		}

		echo "ok";
	}



	function webadm_multiapprove($bid){
		$this->layout = null;
		$this->autoRender = false;
		
		foreach($_POST['no'] as $no){
			if( $no == '0' ) continue;
			$data = $this->Board->Read(null,$no);
			$approval = '1';
			if( $data['Board']['opt_approval'] ) $approval = '0';
			$this->Board->updateAll(array('Board.opt_approval'=>"'".$approval."'"),array('Board.no'=>$no));
		}

		echo "ok";

	}
	

	function webadm_multimove($bid){
		$this->layout = null;
		$this->autoRender = false;

		$movebid = $this->data['Board']['movebid'];
		$method = $this->data['Board']['method'];
		$success = false;
		foreach($_POST['no'] as $no){
			if( $no == '0' ) continue;

			unset($this->data['Board']);

			$data = $this->Board->read(null,$no);

			$this->data['Board'] = $data['Board'];
			$this->data['Board']['no'] = null;
			$this->data['Board']['bid'] = $movebid;
			list($this->data['Board']['sort_gno'],$this->data['Board']['sort_no'],$this->data['Board']['sort_depth']) = $this->Board->createSort("bid='$movebid'");
			
			//이동 게시판으로 게시물 Insert
			if( $this->Board->save($this->data,true) ){
				$parent_id = $this->Board->getInsertId();
				//이동인 경우 기존 정보 delete
				if( $method == 'move' ){
					$this->__filemove('move',$bid,$movebid,$no,$parent_id);
					$this->Board->delete($no);
				}else{
				//copy 인 경우 파일 복사
					$this->__filemove('copy',$bid,$movebid,$no,$parent_id);
				}

				$success = true;
			}else{
				$success = false;
			}

		}//end of foreach;

		if( $success == true )
			echo "success";
		else
			echo "failure";

	}

	/***
	 *
	 *
	 */
	function __filemove($mode,$bid,$movebid,$no,$parent_no){

			if (!class_exists('Folder')) {
				uses('folder');
			}

			$folder = new Folder(APP.'webroot/files/board/'.$movebid, true, 0777);

			$files = $this->Fileattach->find('all',array('conditions'=>array('plugin'=>'board','parent_id'=>$no)));

			if( $mode == 'move' ){

				foreach($files as $file){
					$file['Fileattach']['bid'] = $movebid;
					$file['Fileattach']['parent_id'] = $parent_no;

					$_file = explode('/',$file['Fileattach']['path']);
					$_file[2] = $movebid;
					$file['Fileattach']['path'] = implode('/',$_file);
					unset($_file);
					$_file = explode('/',$file['Fileattach']['fspath']);
					$_file[2] = $movebid;
					$file['Fileattach']['fspath'] = implode('/',$_file);

					//update query
					if( $this->Fileattach->save($file) ){
						$original_file = APP.'webroot/files/board/'.$bid.'/'.$file['Fileattach']['fsname'];
						$target_file = APP.'webroot/files/board/'.$movebid.'/'.$file['Fileattach']['fsname'];
						if( file_exists($original_file) ){
							copy($original_file,$target_file);
							@chmod($target_file,0666);
							@unlink($original_file);
						}
					}
				}


			}elseif( $mode == 'copy' ){

				foreach($files as $file){
					$file['Fileattach']['id'] = null;
					$file['Fileattach']['bid'] = $movebid;
					$file['Fileattach']['parent_id'] = $parent_no;

					$_file = explode('/',$file['Fileattach']['path']);
					$_file[2] = $movebid;
					$file['Fileattach']['path'] = implode('/',$_file);
					unset($_file);
					$_file = explode('/',$file['Fileattach']['fspath']);
					$_file[2] = $movebid;
					$file['Fileattach']['fspath'] = implode('/',$_file);

					//insert query
					if( $this->Fileattach->save($file) ){

						$original_file = APP.'webroot/files/board/'.$bid.'/'.$file['Fileattach']['fsname'];
						$target_file = APP.'webroot/files/board/'.$movebid.'/'.$file['Fileattach']['fsname'];
						if( file_exists($original_file) ){
							if( copy($original_file,$target_file) ){
								@chmod($target_file,0666);
							}
						}
					}else{
						echo 'error insert file';
					}
				}

			}
			
			return true;
	}


	function add100(){
		exit;
		$this->autoRender = false;
		$i = 0;
		set_time_limit(0);
		echo "=========================================================================================================<br />";
		echo "=========================================================================================================<br />";
		echo "=========================================================================================================<br />";
		echo "=========================================================================================================<br />";
		flush();
		$sno = 999999999900;
		while(1){

			$sno = (float)$sno - 100;
			$gno = $sno;
			$depth = 0;
			
			$subject  = "백만 게시물 페이징 속도 테스트".$i;
			$content = $subject;
			$ip = $_SERVER['REMOTE_ADDR'];

			$this->Board->query("insert into ".$this->Board->tablePrefix.$this->Board->table." (sort_no,sort_gno,sort_depth,bid,passwd,name,subject,content,ip,created,modified) values ($sno,$gno,$depth,'{$this->bid}','1234','블루비','$subject','$content','$ip',sysdate(),sysdate())");
			$i++;
			if( $i%10000 == 0 ){ echo $i.">"; flush();sleep(1); }
			if( $i==1000000 ){ flush();usleep(1000); break;}
		
		}//end of while
	}


	/***
	 *
	 */
	function afterFilter(){

	}
}//end of class
?>