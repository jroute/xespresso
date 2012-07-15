<?php
class Comment extends CommentAppModel {

	var $name = "Comment";
	var $primaryKey = 'no';

	var $validate = array(
									'model' => array('rule' => 'notEmpty','required' => true),	
									'model_key' => array('rule' => 'notEmpty','required' => true),									
									'model_id' => array('rule' => 'notEmpty','required' => true),									
									'name'=>array(
										'rule'=>'notEmpty', 
										'required'=>true
									),
									'email'=>array('rule'=>'email', 'allowEmpty'=>true),
									'homepage'=>array('rule' => 'url', 'allowEmpty'=>true),
									'passwd' => array('rule' => 'notEmpty', 'required' => true),
									'comment' => array('rule' => 'notEmpty', 'required' => true)
									);

	var $belongsTo = array(
				'User'=>array(
		    			'className'=>'User',
		    			'fields'=>array('User.profile'),
		    			'foreignKey'=>'userid'
		    		)
		                            
	);

	function latest($limit=5,$cut=45){
	
		$conditions = array('Comment.deleted'=>null);

		$this->unbindModel(array('belongsTo'=>array('User')));
		$rows = $this->find('all',array(
						'conditions'=>$conditions,
						'fields'=>array('Comment.no','Comment.return_url','Comment.comment','Comment.created','Comment.userid','Comment.name','Comment.email'),
						'limit'=>$limit,
						'order'=>array('Comment.created'=>'DESC')
					)
		);
		$data = array();
		foreach($rows as $key=>$row){
			$data[$key] = $row['Comment'];
			$data[$key]['comment'] = strcut($row['Comment']['comment'],$cut);
		}
		return $data;
	}

}//end of class Comment
