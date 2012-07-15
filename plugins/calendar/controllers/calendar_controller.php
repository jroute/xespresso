<?php
class CalendarController extends AppController {
	var $name = 'Calendar';

	var $components = array();
	var $uses = array('Calendar.Calendar');
	var $helpers = array();

	var $version = '1.0.0';
	
	var $date = null;

	function beforeFilter(){
		parent::beforeFilter();

		if( eregi("webadm_",$this->action) ){

		}else{

		}
		
	}

	function __setDate($date){
	
		if( eregi("^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$",$date) ){  	  
		    @list($year,$month,$day) = explode("-",$date); 
		}else{  
		  	$date = date('Y-m-d');		  
		    @list($year,$month,$day) = explode("-",$date);
		}  

		$this->date = $date;
		
		$this->set('date',$date);
		$this->set('year',$year);
		$this->set('month',$month);		
		$this->set('day',$day);				
		  
		$timestemp = mktime(0,0,0,$month,1,$year);  
		$start_week = date("w",$timestemp);  
		$last_day = date("t",$timestemp);  
		
		$this->set('start_week',$start_week);
		$this->set('last_day',$last_day);		
		
		  
		$prev_date = date("Y-m-d",mktime(0,0,0,$month-1,1,$year));  
		$next_date = date("Y-m-d",mktime(0,0,0,$month+1,1,$year)); 
		
		$this->set('prev_date',$prev_date);
		$this->set('next_date',$next_date);		

 		$sol2lun = $this->Calendar->getMonth($this->date);
		$this->set('sol2lun',$sol2lun);			
	}

	
	function index($date=null){
		
 		$this->__setDate($date);
 		

	}


	function webadm_index($date=null){
 		$this->__setDate($date);
 		
 		
	}



}
?>
