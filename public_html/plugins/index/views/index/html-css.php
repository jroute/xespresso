	<div id="content-left">

		<div class="latest">
			<h3><?=$html->link('HTML/CSS - QnA','/board/lst/web-qna');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'web-qna',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	

		<div class="latest">
			<h3><?=$html->link('HTML5/CSS3','/board/lst/web-htmlcss');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'web-htmlcss',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
		
		<div class="latest">
			<h3><?=$html->link('Tip & Tech','/board/lst/web-tiptech');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'web-tiptech',
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