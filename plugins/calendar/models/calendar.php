<?php


/*

id 	시퀀스
sgi 	단기년도
sy	양력 년도
sm	양력 월
sd	양력 일
ly	음력 년도
lm	음력 월
ld	음력 일
hyganjee	년도를 기준으로 하는 한문 간지(입춘을 기준으로 함)
kyganjee	년도를 기준으로 하는 한글 간지(입춘을 기준으로 함)
hmganjee	월을 기준으로 하는 한문 간지(절기를 기준으로함)
kmganjee	월을 기준으로 하는 한글 간지(절기를 기준으로함)
hdganjee	일을 기준으로 하는 한문 간지
kdganjee	일을 기준으로 하는 한글 간지
hweek	한문 요일(日, 月, 火, 水, 木, 金, 土)
kweek	한글 요일(일, 월, 화, 수, 목, 금, 토)
stars	28수(角, 亢, 저, 房, 心, 尾, 箕.....)
moon_state	월령(삭/망 : 그믐(합삭)- 달이 안보임/보름(보름달)
moon_time	삭/망시간(삭이나 망이 될 때 그 시간: 200608092006)
leap_month	윤달 정보(평달 0, 윤달 1)
month_size	달의 크기(그 달이 음력 29일 소월인 경우 0, 음력 30일까지 있는 대월인 경우 1)
hterms	한문 24절기(立春,雨水,驚蟄,春分,淸明.....)
kterms	한글 24절기(입춘,우수,경칩,춘분,청명.....)
terms_time 	절입시간(200608080053 : 양력 2006년 8월 8일 0시 53분)
keventday	특정 기념일(한식,초복,중복,말복)
ddi	띠 (쥐,소,호랑이,토끼,용,뱀,말,양,원숭이,닭,개,돼지)
sol_plan	양력 기념일(신정,삼일절,개천절 등)
lun_plan	음력 기념일(설날,단오,칠월칠석 등)
holiday 	기념일 (국경일과 법정 공휴일: 1, 아니면 0)

http://blog.naver.com/mirckorea/30007756259
[출처] 만세력 MySQL DB(단기,양력,음력,간지,절기,28수,월령,기념일등)|작성자 울보천사

*/



class Calendar extends AppModel {

	var $name = "Calendar";
	var $useTable = 'calendar_sol2lun';
	var $primaryKey = 'id';


	var $nationalHolidayName = array('신정','설날','설날','설날','삼일절','어린이날','석가탄신일','현충일','광복절','추석','추석','추석','개천절','성탄절');
	var $nationalHolidayDate = array("01-01","L12-30","L01-01","L01-02","03-01","05-05","L04-08","06-06","08-15","L08-14","L08-15","L08-16","10-03","12-25");

	function getMonth($date){
 		@list($y,$m,$d) = explode('-',$date);
 		$cals = $this->find('all',array('conditions'=>array('CONCAT(sy,"-",sm)'=>$y.'-'.(int)$m),
 					'fields'=>array('sy','sm','sd','ly','lm','ld','holiday','sol_plan','lun_plan','kweek','leap_month')));	
 			
 		$month = array();		
 		foreach($cals as $cal){
 			$solar = sprintf('%04d-%02d-%02d',$cal['Calendar']['sy'],$cal['Calendar']['sm'],$cal['Calendar']['sd']);
 			$lunar = sprintf('%04d-%02d-%02d',$cal['Calendar']['ly'],$cal['Calendar']['lm'],$cal['Calendar']['ld']); 			
 			$month[$solar] = $cal['Calendar'];
 			$month[$solar]['lunar'] = $lunar;
 			$month[$solar]['nholiday'] = $this->nationalHoliday($solar,$lunar);
 			
 		}
 		return $month;
	}
	
	
	function nationalHoliday($solar,$lunar){
		foreach($this->nationalHolidayDate as $date){
			if( ereg('^L',$date) && substr($lunar,5) == substr($date,1) ){//음력
				return true;
				break;
			}elseif( substr($solar,5) == $date ){
				return true;
				break;
			}
		}//end of foreach;
		return false;
	}

}
?>