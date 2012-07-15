<?php
class PollAnswer extends AppModel {
  var $name = "PollAnswer";
  var $useTable = 'poll_answers';

  var $validate = array(
	'poll_id' => array('rule' => 'notEmpty','required' => true),
	'question_id' => array('rule' => 'notEmpty','required' => true),
  );

}
?>