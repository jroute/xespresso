<?php
class MypageController extends MypageAppController {

	var $name = "Mypage";
	var $uses = array(
		'Board.Board',
		'Board.BoardFile',
		'Certificates.CertificateCategory',
		'Certificates.CertificateCourse',
		'Certificates.CertificateEnroll',		
		'Certificates.Certificate',	
		'Facilities.Facilitie',
		'Lecturers.Lecturer',
		'Persnal.PersnalVisasupport',	
		'Persnal.Persnal',
	);
	var $components = array();

	var $paginate = array(
				'Board'=>array(
									'conditions'=>array('Board.deleted'=>null),
									'limit'=>10,
									'order' => array(
													'Board.created' => 'desc'
									)
					)				
	);



	/***
	*
	*
	*/	
	function beforeFilter(){
		parent::beforeFilter();
		$this->set('title_for_layout','Mypage');

		$this->set('paginate',$this->paginate);
		$this->set('nationality',$this->Persnal->country);
		
		//로그인 체크
		if( $this->Session->Read('Persnal.userid') == "" ){
			$this->redirect(array('plugin'=>false,'controller'=>'persnal','action'=>'login'));
		}
	}
	
	
	/***
	*
	*
	*/
	function index(){

	}
	
	
	/***
	* Desc.		: 교육 신청 목록
	* Date		: 2010-10-06
	* Author	: blueb
	*/
	function course_list(){
	
		$this->set('navigation_for_layout','            	<p class="fl"><img src="/images/title/h2_title_34.gif" alt="Course Registration" /></p>
                <p class="spot">Home &gt; My page &gt; <span>Course Registration</span></p>');
	
		$userid = $this->Session->Read('Persnal.userid');
		
		$curdate = date('Y-m-d');
		
		//In Progress Courses
		$rows_in = $this->CertificateEnroll->find('all',array('conditions'=>array(
						'CertificateEnroll.deleted'=>null,
						'CertificateEnroll.userid'=>$userid,
						'Certificate.edu_edate >='=>$curdate
						),
						'order'=>array('Certificate.edu_edate'=>'desc'))
		);

		//Closed Courses
		$rows_closed = $this->CertificateEnroll->find('all',array('conditions'=>array(
						'CertificateEnroll.deleted'=>null,
						'CertificateEnroll.userid'=>$userid,
						'Certificate.edu_edate <'=>$curdate
						),						
						'order'=>array('Certificate.edu_edate'=>'desc'))
		);		
		
		
		$this->set(compact('rows_in','rows_closed'));
		$this->render('course_list');
	}
	
	/***
	* Desc.		: 교육 신청 뷰
	* Date		: 2010-10-06
	* Author	: blueb
	* @params	$id	: 교육신청 고유번호
	*/	
	function course_view($id){
	
		$this->set('navigation_for_layout','<p class="fl"><img src="/images/title/h2_title_34.gif" alt="Course Registration" /></p>
                <p class="spot">Home &gt; My page &gt; <span>Course Registration</span></p>');
                	
		$this->data = $this->CertificateEnroll->find('first',array('conditions'=>array(
					'CertificateEnroll.id'=>$id,		
					'CertificateEnroll.deleted'=>null,
					'CertificateEnroll.userid'=>$this->Session->Read('Persnal.userid')
					)));

		if( @$this->data['CertificateEnroll']['id'] == ''){
			$this->SessionAlert('No data!');
			$this->redirect(array('action'=>'course_list'));	
		}
		
		$this->data['Lecturer'] = array_shift($this->Lecturer->Read(null,$this->data['Certificate']['lecturer']));
		$this->data['Lecturer2'] = array_shift($this->Lecturer->Read(null,$this->data['Certificate']['lecturer2']));
		$this->data['Lecturer3'] = array_shift($this->Lecturer->Read(null,$this->data['Certificate']['lecturer3']));
		
		$this->render('course_view');
	}	

	/***
	* Desc.		: 숙박 목록
	* Date		: 2010-10-07
	* Author	: 고유미
	* @params	$id
	*/	
	function room_list(){

		$this->set('navigation_for_layout','<p class="fl"><img src="/images/title/h2_title_35.gif" alt="Accommodation Reservation" /></p>
                <p class="spot">Home &gt; My page &gt; <span>Accommodation Reservation</span></p>');

		$userid = $this->Session->Read('Persnal.userid');
		
		//In Progress Courses
		$rows = $this->Facilitie->find('all',array('conditions'=>array('Facilitie.deleted'=>null,'Facilitie.userid'=>$userid),'order'=>array('created'=>'desc')));
		$this->set('rows',$rows);
		$this->render('room_list');
	
	
	}	
	
	/***
	* Desc.		: 숙박 뷰
	* Date		: 2010-10-07
	* Author	: 고유미
	* @params	$id	: 숙박신청 고유번호
	*/	
	function room_view($id){

       $this->set('navigation_for_layout','<p class="fl"><img src="/images/title/h2_title_35.gif" alt="Reserve Room" /></p>
                <p class="spot">Home &gt; My page &gt; <span>Reserve Room</span></p>');
                
                
	   $this->data = $this->Facilitie->Read(null,$id);
	   
		if( @$this->data['Facilitie']['id'] == '' ){
			$this->SessionAlert('No data!');
			$this->redirect(array('action'=>'room_list'));	
		}	   
	
	}		


	function faq_list(){

		$this->set('navigation_for_layout','<p class="fl"><img src="/images/title/h2_title_36.gif" alt="My Q&A" /></p>
                <p class="spot">Home &gt; My page &gt; <span>My Q&A</span></p>');

		$userid = $this->Session->Read('Persnal.userid');
		
		$conditions = array(
						 'Board.bid'=>'eqna',
		                 'Board.sort_depth'=>0,
						 'Board.userid'=>$userid
					   );

		$rows = $this->paginate('Board',$conditions);
		

		for($i=0; $i<count($rows); $i++){

			 $reply[$i] = $this->Board->find('count',array('conditions'=>array(
												'Board.deleted'=>null,
												'Board.bid'=>'eqna',
												'Board.sort_gno'=>$rows[$i]['Board']['sort_gno'],
												'Board.no !='=>$rows[$i]['Board']['no'])
										  )
									);
		 }

		 
	
		$this->set('rows',$rows);
		$this->set('reply',$reply);
		$this->render('faq_list');
	
	}	
	

	function faq_view($id){

       $this->set('navigation_for_layout','<p class="fl"><img src="/images/title/h2_title_36.gif" alt="My Q&A" /></p>
                <p class="spot">Home &gt; My page &gt; <span>My Q&A</span></p>');
                
                
	   $this->data = $this->Board->Read(null,$id);

	  


	   $reply = $this->Board->find('all',array('conditions'=>array(
												'Board.deleted'=>null,
												'Board.bid'=>'eqna',
												'Board.sort_gno'=>$this->data['Board']['sort_gno'],
												'Board.no !='=>$this->data['Board']['no'] )
										  )
									);
	     
		
		foreach($this->data['BoardFile'] as $i=>$files){
				$this->data['BoardFile'][$i]['ext'] = $this->Board->getExtension($files['name']);
			}


		for($i=0; $i<count($reply); $i++){

			    foreach($reply[$i]['BoardFile'] as $i=>$files){
				$reply[$i]['BoardFile'][$i]['ext'] = $this->Board->getExtension($files['name']);
			}
		}
		
			

	   $this->set('reply',$reply);
	
	}		


	function getExtension($file){
		$ext = strtolower(array_pop(explode(".",$file)));
		if( empty($ext) ) return 'none';

		if( in_array($ext,$this->extension) ){
			return $ext;
		}else{
			return 'unknown';
		}
	}
}
?>