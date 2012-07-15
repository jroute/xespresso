<?php
class BoardSetup extends BoardAppModel {

	var $name = "BoardSetup";
	var $primaryKey = "bid";


	var $validate = array(
									'bid' => array('rule' =>array('custom', '/^[a-z0-9\_\-]{2,}$/i'),'minLength'=>1,'maxLength'=>30,'required' => true),
									'bname' => array('rule' => 'notEmpty','required' => true)
									);

	function add($bid,$bname,$options=array()){
		$data['BoardSetup'] = $options;
		$data['BoardSetup']['bid'] = $bid;
		$data['BoardSetup']['bname'] = $bname;
		$this->save($data);		
	}

	function getSetup($bid){
		$data = $this->find("bid='$bid'");
		return $data['BoardSetup'];
	}

	function setTotalComments($bid,$cnt){
		if( $this->query("update ".$this->tablePrefix.$this->table." set total_comment=$cnt where bid='$bid'") ){
			return false;
		}else{
			return true;
		}
	}
	function setTotalArticles($bid,$cnt){
		if( $this->query("update ".$this->tablePrefix.$this->table." set total_article=$cnt,modified=sysdate() where bid='$bid'") ){
			return false;
		}else{
			return true;
		}
	}
}
?>