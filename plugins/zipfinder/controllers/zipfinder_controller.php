<?php

App::import('Vendor', 'JSON',array('file'=>'JSON.php'));

class ZipfinderController extends AppController {
	var $name = 'Zipfinder';
	var $uses = array('Zipfinder.Zipcode');
	var $autoRender = false;
	function search(){
		Configure::write('debug',0);
//		print_r($this);
		if( $this->params['form']['keyword'] ){
			$keyword = str_replace(array("'",'-','or','OR'),'',$this->params['form']['keyword']);
			$rows = $this->Zipcode->find('all',array('conditions'=>array('dong like'=>'%'.$keyword.'%')));
			$data = array();
			foreach($rows as $i=>$row){
				$data[$i]['code'] = $row['Zipcode']['zipcode'];
				$data[$i]['addr'] = $row['Zipcode']['sido'].' '.$row['Zipcode']['gugun'].' '.$row['Zipcode']['dong'];
				$data[$i]['addr2'] = $row['Zipcode']['sido'].' '.$row['Zipcode']['gugun'].' '.$row['Zipcode']['dong'].' '.$row['Zipcode']['bungi'];
				
			}
			$json = new Services_JSON();
			print($json->encode($data));
		}
	}
}
?>
