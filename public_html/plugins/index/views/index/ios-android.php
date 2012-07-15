	<div id="content-left">

		<div class="latest">
			<h3><?=$html->link('iOS/Android - QnA','/board/lst/app-qna');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'app-qna',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	

	
		<div class="latest">
			<h3><?=$html->link('iOS','/board/lst/app-ios');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'app-ios',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
		

		<div class="latest">
			<h3><?=$html->link('Android','/board/lst/app-android');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'app-android',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
				
		
		<div class="latest">
			<h3><?=$html->link('Tip & Tech','/board/lst/app-tiptech');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'app-tiptech',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>		
		
		<div class="latest">
			<h3><?=$html->link('Lecture','/board/lst/app-lecture');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'app-lecture',
                                'category' =>null,
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