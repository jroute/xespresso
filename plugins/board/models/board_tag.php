<?php
class BoardTag extends BoardAppModel {

	var $name = "BoardTag";
	var $useTable = 'board_tags';

	var $validate = array(
		'bno' => array('rule' => 'notEmpty','required' => true),
		'tagid' => array('rule' => 'notEmpty','required' => true)
	);

	var $belongsTo = array(
		'Tag' =>array(
			'className'=>'Tag',
			'foreignKey'=>'tagid'
		)
	);
	

	function save($bid,$bno=null,$tagid=null){

		if( empty($bid) || empty($bno) || empty($tagid) ) return false;

		$data['BoardTag']['id'] = null;
		$data['BoardTag']['bid'] = $bid;
		$data['BoardTag']['bno'] = $bno;
		$data['BoardTag']['tagid'] = $tagid;

		$chk = $this->find('count',array('conditions'=>array('bid'=>$bid,'bno'=>$bno,'tagid'=>$tagid)));
		if( $chk > 0 ) return true;

		if( parent::save($data,false) ){
			return true;
		}else{
			return false;
		}
	}

	function getByBno($bid,$bno){
		return $this->find('all',array('conditions'=>array('bid'=>$bid,'bno'=>$bno)));
	}

	function getByBid($bid){
		return $this->find('all',array('conditions'=>array('bid'=>$bid)));
	}

	function del($bid,$no,$exeptid=array()){
		
		if( $this->query("delete from ".$this->tablePrefix.$this->table." where bid='".$bid."' and bno=".$no." and  tagid NOT IN  (".@implode(',',$exeptid).")") ){
			return false;
		}else{
			return true;
		}
	}

}
