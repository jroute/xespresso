<?php
class PollSetup extends AppModel {
  var $name = "PollSetup";
  var $useTable = 'poll_setups';

  var $validate = array(
	'title' => array('rule' => 'notEmpty','required' => true)
  );


}
?>