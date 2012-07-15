<?php
class ContentReversion extends AppModel {
	var $name = "ContentReversion";
	var $useTable = 'contents_reversions';

	var $validate = array(
									'title' => array('rule' => 'notEmpty','required' => true),
									'content' => array('rule' => 'notEmpty','required' => true)
									);


	function _get_reversion($pid){
		$data = $this->find('first',array('conditions'=>array('parent_id'=>$pid),'fields'=>array('Max(reversion) as reversion')));
		$reversion = array_shift(array_shift($data));
		return ( empty($reversion) === true ) ? 1:$reversion+1;
	}

	function add($pid,$tmp,$sess){
		unset($tmp['id']);
		$data['ContentReversion'] = $tmp;
		$data['ContentReversion']['parent_id'] = $pid;
		$data['ContentReversion']['reversion'] = $this->_get_reversion($pid);

		$data['ContentReversion']['userid'] = $sess['userid'];
		$data['ContentReversion']['name'] = $sess['name'];
		$this->save($data);
	}
}
?>