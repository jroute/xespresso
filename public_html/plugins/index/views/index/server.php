	<div id="content-left">

		<div class="latest">
			<h3><?=$html->link('Server - Q&A','/board/lst/sv-qna');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'sv-qna',
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	
		
		<div class="latest">
			<h3><?=$html->link('Linux Server','/board/lst/sv-linux');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'sv-linux',
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>			
		
		<div class="latest">
			<h3><?=$html->link('Windows Server','/board/lst/sv-windows');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'sv-windows',
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	

	
		<div class="latest">
			<h3><?=$html->link('Ubuntu','/board/lst/sv-linux/category:11');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'sv-linux',
                                'category'=>11,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
		

		<div class="latest">
			<h3><?=$html->link('CentOS','/board/lst/sv-linux/category:12');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'sv-linux',
                                'category'=>12,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
				
		<div class="latest">
			<h3><?=$html->link('Lecture','/board/lst/sv-lecture');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'sv-lecture',
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