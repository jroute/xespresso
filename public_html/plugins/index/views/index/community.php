	<div id="content-left">


	
		<div class="latest">
			<h3><?=$html->link('공지사항','/board/lst/notice');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'notice',
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
		

		<div class="latest">
			<h3><?=$html->link('최근소식','/board/lst/news');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'news',
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
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
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
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
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
		


		<div class="latest">
			<h3><?=$html->link('개발자료','/board/lst/pds');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'pds',
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
				
		<div class="latest">
			<h3><?=$html->link('개발툴','/board/lst/devtools');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'devtools',
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
				
			<div class="latest">
			<h3><?=$html->link('포토존','/board/lst/gallery');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'gallery',
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
					
			
	</div>
	
	<div id="content-right">
		<?=$this->element('content-right');?>
	</div>