<?php
class PollQuestion extends AppModel {
  var $name = "PollQuestion";
  var $useTable = 'poll_questions';

  var $validate = array(
	'question' => array('rule' => 'notEmpty','required' => true)
  );

  var $hasMany = array(
	  'PollItem'=>array(
			'className' => 'PollItem',
			'foreignKey' => 'question_id',
			'conditions' => array('PollItem.deleted' =>null),
			'order' => 'PollItem.created DESC'
		)
	);
}
?>