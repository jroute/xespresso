<?php
class PollItem extends AppModel {
  var $name = "PollItem";
  var $useTable = 'poll_items';

  var $validate = array(
	'item' => array('rule' => 'notEmpty','required' => true)
  );

}
?>