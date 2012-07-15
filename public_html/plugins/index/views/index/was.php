	<div id="content-left">

		<div class="latest">
			<h3><?=$html->link('WAS - Q&A','/board/lst/was-qna');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'was-qna',
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	
		
		<div class="latest">
			<h3><?=$html->link('WAS','/board/lst/was');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'was',
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>			
		
		<div class="latest">
			<h3><?=$html->link('Apache','/board/lst/was/category:34');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'was',
                                'category'=>34,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	

	
		<div class="latest">
			<h3><?=$html->link('Tomcat','/board/lst/was/category:35');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'was',
                                'category'=>35,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
		

		<div class="latest">
			<h3><?=$html->link('Jeus','/board/lst/was/category:36');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'was',
                                'category'=>36,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
				
		<div class="latest">
			<h3><?=$html->link('Websphere','/board/lst/was/category:37');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'was',
                                'category'=>37,
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