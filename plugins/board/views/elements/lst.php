<?php
$params = '';
foreach($this->params['named'] as $key=>$val){
	$params .= '/'.$key.':'.$val;
}

echo $this->requestAction('board/ls/'.$bid.$params, array('return'));
