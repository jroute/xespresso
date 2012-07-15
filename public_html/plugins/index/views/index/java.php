	<div id="content-left">

		<div class="latest">
			<h3><?=$html->link('Java/JSP - QnA','/board/lst/java-qna');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'java-qna',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	

		<div class="latest">
			<h3><?=$html->link('Java/JSP','/board/lst/java-jsp');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'java-jsp',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
		
		<div class="latest">
			<h3><?=$html->link('Tip & Tech','/board/lst/java-tiptech');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'java-tiptech',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>		
		
		<div class="latest">
			<h3><?=$html->link('Lecture','/board/lst/java-lecture');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'java-lecture',
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