<?php
class Counter extends AppModel {
	var $name = "Counter";
//	var $useTable = false;

	function getBrowserIcon($browser){
			if( ereg("MSIE",$browser) ){
				if( ereg('3',$browser) ) $icon = 'ie3.png';
				else if( ereg('4',$browser) ) $icon = 'ie4.png';
				else if( ereg('5',$browser) ) $icon = 'ie5.png';
				else if( ereg('6',$browser) ) $icon = 'ie6.png';
				else if( ereg('7',$browser) ) $icon = 'ie7.png';
				else if( ereg('8',$browser) ) $icon = 'ie8.png';
				else if( ereg('9',$browser) ) $icon = 'ie9.png';
				else $icon = 'ie.png';
			}elseif(  eregi("Firefox",$browser) ){
				if( ereg('2',$browser))  $icon = 'firefox2.png';
				else if( ereg('3',$browser) ) $icon = 'firefox3.png';
				else if( ereg('4',$browser) ) $icon = 'firefox4.png';
				else $icon = 'firefox.png';
			}elseif(  eregi("chrome",$browser) ){
				$icon = 'chrome.png';
			}elseif(  eregi("camino",$browser) ){
				$icon = 'camino.png';
			}elseif(  eregi("epiphany",$browser) ){
				$icon = 'epiphany.png';
			}elseif(  eregi("firebird",$browser) ){
				$icon = 'firebird.png';
			}elseif(  eregi("flock",$browser) ){
				$icon = 'flock.png';
			}elseif(  eregi("galeon",$browser) ){
				$icon = 'galeon.png';
			}elseif(  eregi("icab",$browser) ){
				$icon = 'icab.png';
			}elseif(  eregi("konqueror",$browser) ){
				$icon = 'konqueror.png';
			}elseif(  eregi("netscape",$browser) ){
				$icon = 'netscape.png';
			}elseif(  eregi("omniweb",$browser) ){
				$icon = 'omniweb.png';
			}elseif(  eregi("opera",$browser) ){
				$icon = 'opera.png';
			}elseif(  eregi("phoenix",$browser) ){
				$icon = 'phoenix.png';
			}elseif(  eregi("safari",$browser) ){
				$icon = 'safari.png';
			}elseif(  eregi("seamonkey",$browser) ){
				$icon = 'seamonkey.png';
			}elseif(  eregi("swift",$browser) ){
				$icon = 'swift.png';
			}else $icon = '';

			return $icon;
	}

	function write($data){

		if(  $this->find('count',array('conditions'=>array('ip'=>$data['Counter']['ip'],'session'=>$data['Counter']['session'],"left(`created`,10)"=>date('Y-m-d')))) ){
			$this->query("update ".$this->tablePrefix.$this->table." set pv=pv+1 where `ip`='".$data['Counter']['ip']."' AND `session`='".$data['Counter']['session']."'");
		}else{
			$this->save($data);
		}
	}

	/***
	 * @params	: string(w);
	 */
	function getCount($w=null){
		switch($w){
			case "yesterday":
				$conditions = "left(`created`,10)='".date('Y-m-d',time()-86400)."'";
				break;
			case "today":
				$conditions = "left(`created`,10)='".date('Y-m-d',time())."'";
				break;
			default:
			case "total":
				$conditions = "";
				break;
		}

		$data = $this->find($conditions,"if(sum(uv) is not null, sum(uv), '0') as uv,if( sum(pv) is not null, sum(pv), '0') as pv ");
		return $data[0];
	}

	function getLastHits(){
		$rows = $this->find('all',array('limit'=>15,'order'=>array('created'=>'desc')));

		foreach($rows as $i=>$tmp){
			
			$rows[$i] = $tmp;
			$rows[$i][$this->name]['browserIcon'] = $this->getBrowserIcon($tmp[$this->name]['browser']);
			
		}

		return $rows;
	}

	function getBeginYear(){
		$data = $this->find(null,"left(MIN(created),4) as year");
		if( $data[0]['year'] ){
		return $data[0]['year'];
		}
		return date('Y');
	}

	function getRecentDays(){
		//현재 시간 부터 20일 전까지의 데이터를 그래프화
		return $this->query("select left(`created`,10) as date, sum(uv) as uv, sum(pv) as pv, ( sum(uv) +sum(pv)) as total from ".$this->tablePrefix.$this->table." where left(`created`,10) between '".date('Y-m-d',time()-(86400*20))."' AND '".date('Y-m-d')."' GROUP BY left(`created`,10) order by `created` asc");		
	}


	function getStatistics($w,$date=null){
		$logs = array();
		$table = $this->tablePrefix.$this->table;

		$max_height = 200;
		$max_total = 0;


		switch($w){
			case "time":
				$rows =  $this->query("select sum(uv) as uv , created as date from ".$table." where left(`created`,10)='$date' group by left(created,13)");

				foreach($rows as $i=>$data){
					$logs[$i]['uv'] = $data[0]['uv'];
					$logs[$i]['date'] = $data[$table]['date'];
					if( $logs[$i]['uv'] > $max_total ) $max_total = $logs[$i]['uv'];
				}
				foreach($logs as $i=>$log){
					unset($logs[$i]);
					$logs[$i] = $log;
					$logs[$i]['uvh'] = round((int)$log['uv']/$max_total*$max_height);
				}

				break;
			case "day":
				$rows =  $this->query("select mid(`created`,9,2) as day, sum(uv) as uv, sum(pv) as pv,( sum(uv) +  sum(pv) ) as total from ".$table." where left(`created`,7)='".substr($date,0,7)."' GROUP BY left(`created`,10)");

				foreach($rows as $i=>$data){
					$logs[$i]['uv'] = $data[0]['uv'];
					$logs[$i]['pv'] = $data[0]['pv'];
					$logs[$i]['day'] = $data[0]['day'];
					$logs[$i]['total'] = $data[0]['total'];
					if( $logs[$i]['total'] > $max_total ) $max_total = $logs[$i]['total'];
				}
				foreach($logs as $i=>$log){
					unset($logs[$i]);
					$logs[$i] = $log;
					$logs[$i]['uvh'] = round((int)$log['uv']/$max_total*$max_height);
					$logs[$i]['pvh'] = round((int)$log['pv']/$max_total*$max_height);
				}

				break;
			case "month":
				$rows =  $this->query("select mid(`created`,6,2) as month, sum(uv) as uv, sum(pv) as pv,( sum(uv) +  sum(pv) ) as total from ".$table." where left(`created`,4)='".substr($date,0,4)."' GROUP BY left(`created`,7)");

				foreach($rows as $i=>$data){
					$logs[$i]['uv'] = $data[0]['uv'];
					$logs[$i]['pv'] = $data[0]['pv'];
					$logs[$i]['month'] = $data[0]['month'];
					$logs[$i]['total'] = $data[0]['total'];
					if( $logs[$i]['total'] > $max_total ) $max_total = $logs[$i]['total'];
				}
				foreach($logs as $i=>$log){
					unset($logs[$i]);
					$logs[$i] = $log;
					$logs[$i]['uvh'] = round((int)$log['uv']/$max_total*$max_height);
					$logs[$i]['pvh'] = round((int)$log['pv']/$max_total*$max_height);
				}

				break;
			case "year":
				$rows =  $this->query("select left(`created`,4) as year, sum(uv) as uv, sum(pv) as pv,( sum(uv) +  sum(pv) ) as total from ".$table." where 1 GROUP BY left(`created`,4)");

				foreach($rows as $i=>$data){
					$logs[$i]['uv'] = $data[0]['uv'];
					$logs[$i]['pv'] = $data[0]['pv'];
					$logs[$i]['year'] = $data[0]['year'];
					$logs[$i]['total'] = $data[0]['total'];
					if( $logs[$i]['total'] > $max_total ) $max_total = $logs[$i]['total'];
				}
				foreach($logs as $i=>$log){
					unset($logs[$i]);
					$logs[$i] = $log;
					$logs[$i]['uvh'] = round((int)$log['uv']/$max_total*$max_height);
					$logs[$i]['pvh'] = round((int)$log['pv']/$max_total*$max_height);
				}

				break;
			case "browser":
				$rows =  $this->query("select browser as browser, sum(uv) as uv, sum(pv) as pv,( sum(uv) +  sum(pv) ) as total from ".$table." where 1 GROUP BY browser");

				foreach($rows as $i=>$data){
					$logs[$i]['uv'] = $data[0]['uv'];
					$logs[$i]['pv'] = $data[0]['pv'];
					$logs[$i]['browser'] = $data[$table]['browser'];
					$logs[$i]['browserIcon'] = $this->getBrowserIcon($data[$table]['browser']);
					$logs[$i]['total'] = $data[0]['total'];
					if( $logs[$i]['total'] > $max_total ) $max_total = $logs[$i]['total'];
				}
				foreach($logs as $i=>$log){
					unset($logs[$i]);
					$logs[$i] = $log;
					$logs[$i]['uvh'] = round((int)$log['uv']/$max_total*$max_height);
					$logs[$i]['pvh'] = round((int)$log['pv']/$max_total*$max_height);
				}

				break;
			case "os":
				$rows =  $this->query("select os as os, sum(uv) as uv, sum(pv) as pv,( sum(uv) +  sum(pv) ) as total from ".$table." where 1 GROUP BY os");


				foreach($rows as $i=>$data){
					$logs[$i]['uv'] = $data[0]['uv'];
					$logs[$i]['pv'] = $data[0]['pv'];
					$logs[$i]['os'] = $data[$table]['os'];
					$logs[$i]['total'] = $data[0]['total'];
					if( $logs[$i]['total'] > $max_total ) $max_total = $logs[$i]['total'];
				}
				foreach($logs as $i=>$log){
					unset($logs[$i]);
					$logs[$i] = $log;
					$logs[$i]['uvh'] = round((int)$log['uv']/$max_total*$max_height);
					$logs[$i]['pvh'] = round((int)$log['pv']/$max_total*$max_height);
				}

				break;
		}




		return $logs;

	}
}
?>