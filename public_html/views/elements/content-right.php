		<div class="latest">
			<h3><?=$html->link('최근소식','/board/lst/news');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'news',
                                'category' =>null,
                                'limit'=>3,
																'slen'=>35,
																'clen'=>40
                                ));
?>
			</ul>		
		</div>	
		
		<div class="latest">
			<h3><?=$html->link('행사/세미나','/board/lst/events');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'events',
                                'category' =>null,
                                'limit'=>3,
																'slen'=>35,
																'clen'=>40
                                ));
?>
			</ul>		
		</div>			
		
		<div class="latest">
			<h3><?=$html->link('수다방','/board/lst/suda');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'suda',
                                'category' =>null,
                                'limit'=>3,
																'slen'=>35,
																'clen'=>40
                                ));
?>
			</ul>		
		</div>					
		
	<div class="latest">		
			<h3><?=$html->link('공지사항','/board/lst/notice');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'notice',
                                'category' =>null,
                                'limit'=>3,
																'slen'=>35,
																'clen'=>40
                                ));
?>
			</ul>			
		</div>

		
		
		<div class="latest">
		
<script type="text/javascript"><!--
google_ad_client = "ca-pub-7837870281700467";
/* xespresso - right */
google_ad_slot = "5690582209";
google_ad_width = 200;
google_ad_height = 200;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

		
		</div>