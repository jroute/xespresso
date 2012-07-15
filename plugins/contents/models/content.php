<?php
class Content extends AppModel {
	var $name = "Content";
//	var $useTable = false;

	var $validate = array(
									'title' => array('rule' => 'notEmpty','required' => true),
									'content' => array('rule' => 'notEmpty','required' => true)
									);

	var $hasMany = array(
				'Rating' => 
                     array('className'   => 'Rating',
                           'foreignKey'  => 'model_id',
                           'conditions' => array('Rating.model' => 'Page.Page'),
                           'dependent'   => true,
                           'exclusive'   => true                         
                           )
	);

}
?>