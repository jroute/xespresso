<?php



function urlshorten($url=null,$flag=true){
	ini_set('default_socket_timeout', 1);//네트워크 딜레이 현상을 최소화
	$rurl = 'http://'.$_SERVER['HTTP_HOST'].$url;
	if( $flag == false ) return $rurl;
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




function dday($date) {
	if( $date == null ) return 0;
	
	list($dy,$dm,$dd) = explode('-',substr($date,0,10));
	
  $dtime = floor((time()+32400)/86400);
  $dtemp = floor(mktime(0,0,0,$dm,$dd,$dy)/86400);
 
  $dday = $dtime - $dtemp - 1;

  if($dday > 0){
			return '+'.$dday++;
  }elseif($dday == 0){
			return 0;		
  }else{
  		return $dday;
  }
 
  
}





	function u8_strcut($str, $start, $end, $encoding='utf-8')
	{
		echo $encoding;
		mb_internal_encoding($encoding);
		echo $str_len = mb_strlen($str);
		if( $end > $str_len ) $end = $str_len;

		$re_arr = array();    
		$re_icount = 0;
		for($i = $start; $i < ($start+$end);$i++){
			$ch = ord($str{$i});
			echo '-'.$i;
			echo '-'.$ch.'<br />';
		
			if($ch<128){$re_arr[$re_icount++]= mb_substr($str,$i,1);}        
			else if($ch<224){$re_arr[$re_icount++]= mb_substr($str,$i,2);$i+=1;}        
			else if($ch<240){$re_arr[$re_icount++]= mb_substr($str,$i,3);$i+=2;}        
			else if($ch<248){$re_arr[$re_icount++]= mb_substr($str,$i,4);$i+=3;}        
		}

		return implode('',$re_arr);
	}

	function strcut_utf8($str, $len, $checkmb=false, $tail='...') {
		preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
		$m    = $match[0];
		$slen = strlen($str);  // length of source string
		$tlen = strlen($tail); // length of tail string
		$mlen = count($m);     // length of matched characters
	   
		if ($slen <= $len) return $str;
		if (!$checkmb && $mlen <= $len) return $str;
		
		$ret   = array();
		$count = 0;
		
		for ($i=0; $i < $len; $i++) {
			$count += ($checkmb &&  strlen($m[$i]) > 1)?2:1;

			if ($count + $tlen > $len) break;
				$ret[] = $m[$i];
			}

			return join('', $ret).$tail;
	}


    function strcut($string,$cut_size=0,$tail = '...') {
        if($cut_size<1 || !$string) return $string;
        
        if( function_exists('mb_strimwidth') ){
        
        	return mb_strimwidth($string,0,$cut_size,$tail);
        }

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
    
    
    function signencode($ostr){//7910121233316 >> 791012 6011168
    	$salt = array(9,0,6,1,4,3,8,2,5,7);
		 	$str = substr(str_replace('-','',$ostr),6);
    	$tmp = null;
    	for($i = 0 ; $i < strlen($str); $i++ ){
    		$tmp .= $salt[(int)$str[$i]];
    	}
    	return substr($ostr,0,6).$tmp;
    }
    
   
    function signdecode($ostr){
    	$salt = array(9,0,6,1,4,3,8,2,5,7);
    	$str = substr(str_replace('-','',$ostr),6);
    	$tmp = null;
    	for($i = 0 ; $i < strlen($str); $i++ ){
    		$tmp .= array_shift(array_keys($salt,(int)$str[$i]));
    	}
    	return substr($ostr,0,6).$tmp;    	
    }


