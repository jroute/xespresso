<?php
class AppModel extends Model
{

  /**
  *
  * ex. 
  * $this->validateAttributes(array('pc_email', 'mb_email'));
  * $this->validateAttributes(array('only' => array('pc_email', 'mb_email')));
  * $this->validateAttributes(array('except' => array('pc_email', 'mb_email')));
  */
  function validateAttributes($attributes = array(), $options = array()) {
    $tgt_attributes = $attributes;
    if (isset($attributes['except'])) {
      foreach ($attributes['except'] as $attr) {
        unset($this->validate[$attr]);
      }
      $results = parent::validates($options);
    } else {
      if (isset($attributes['only'])) {
        $tgt_attributes = $attributes['only'];
      }
      $tgt_attributes = array_fill_keys($tgt_attributes, true);
      $tmp_validate = $this->validate;
      $this->validate = array_intersect_key($this->validate, $tgt_attributes);
      $results = parent::validates($options);
      $this->validate = $tmp_validate;
    }
    return $results;
  }

  /**
  * integer d
  *
  */
  function beforeSave() {
    foreach ($this->_schema as $field => $properties) {
      if ($this->_schema[$field]['type'] === 'integer' && isset($this->data[$this->alias][$field])) {
        if ($this->data[$this->alias][$field] === '') {
          $this->data[$this->alias][$field] = null;
        }
      }
    }
    return true;
  }

  /* transactions */
  function begin() {
    $db =& ConnectionManager::getDataSource($this->useDbConfig);
    $db->begin($this);
  }

  function commit() {
    $db =& ConnectionManager::getDataSource($this->useDbConfig);
    $db->commit($this);
  }

  function rollback() {
    $db =& ConnectionManager::getDataSource($this->useDbConfig);
    $db->rollback($this);
  }
  
  function del($id){
  	if( $this->updateAll(array($this->name.'.deleted'=>"sysdate()"),array($this->name.'.'.$this->primaryKey=>$id)) ){
	  	return true;
	  }
	  
	  return false;
  }

	//Captcha Validate
	function compcaptcha($data){
		$data = array_pop($data);
		if( strcmp($data,@$_SESSION['securimage_code_value']) == 0 ) return true;
		return false;
	}


  function unbindModelAll() {
		foreach(array(
    	'hasOne' => array_keys($this->hasOne),
      'hasMany' => array_keys($this->hasMany),
      'belongsTo' => array_keys($this->belongsTo),
      'hasAndBelongsToMany' => array_keys($this->hasAndBelongsToMany)
      ) as $relation => $model)
    {
      	$this->unbindModel(array($relation => $model));
  	}
	} 

	function strCut($string,$cut_size=0,$tail = '...') {
        if($cut_size<1 || !$string) return $string;

        $chars = Array(12, 4, 3, 5, 7, 7, 11, 8, 4, 5, 5, 6, 6, 4, 6, 4, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 4, 4, 8, 6, 8, 6, 10, 8, 8, 9, 8, 8, 7, 9, 8, 3, 6, 7, 7, 11, 8, 9, 8, 9, 8, 8, 7, 8, 8, 10, 8, 8, 8, 6, 11, 6, 6, 6, 4, 7, 7, 7, 7, 7, 3, 7, 7, 3, 3, 6, 3, 9, 7, 7, 7, 7, 4, 7, 3, 7, 6, 10, 6, 6, 7, 6, 6, 6, 9);
        $max_width = $cut_size*$chars[0]/2;
        $char_width = 0;

        $string_length = strlen($string);
        $char_count = 0;

        $idx = 0;
        while($idx < $string_length && $char_count < $cut_size && $char_width <= $max_width) {
            $c = @ord(substr($string, $idx,1));
            $char_count++;
            if($c<128) {
                $char_width += @(int)$chars[$c-32];
                $idx++;
            } else {
                $char_width += $chars[0];
                $idx += 3;
            }
        }
        $output = substr($string,0,$idx);
        if(strlen($output)<$string_length) $output .= $tail;
        return $output;
    }


	//xss filter
	function XSS($data){
		$patterns = array(
			'/<iframe/',
			'/<script/',
			'/on([a-zA-Z])=/'
		);

		$replaces = array(
			'&lt;iframe',
			'&lt;xscript',
			'/xon\\1/'
		);

		return preg_replace($patterns,$replaces,$data);
	}
}//end of class