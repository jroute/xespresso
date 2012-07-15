<?php

function urlshorten($url=null){
	ini_set('default_socket_timeout', 1);//네트워크 딜레이 현상을 최소화
	$rurl = 'http://'.$_SERVER['HTTP_HOST'].$url;
	$long_url = htmlspecialchars($rurl,ENT_QUOTES);
	$req = "http://api.bitly.com/v3/shorten?login=plani&apiKey=R_10153503b5ff429feab28d8ab1d52482&longUrl=".$long_url.'&format=json';
	$contents = @file_get_contents($req);

	if( isset($contents) ){
		$data = json_decode($contents,true);
		if( $data['status_code'] == 200 ){
			$rurl = $data['data']['url'];
		}
	}
	return $rurl;
	
}

print_r(urlshorten());
?>
asdfadf