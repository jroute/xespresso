	<div id="content-left">

		<div class="latest">
			<h3><?=$html->link('JavaScript - QnA','/board/lst/js-qna');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'js-qna',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	

		<div class="latest">
			<h3><?=$html->link('JavaScript','/board/lst/js-javascript');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'js-javascript',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
		
		<div class="latest">
			<h3><?=$html->link('Tip & Tech','/board/lst/js-tiptech');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'js-tiptech',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>		
		
		<div class="latest">
			<h3><?=$html->link('Lecture','/board/lst/js-lecture');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'js-lecture',
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