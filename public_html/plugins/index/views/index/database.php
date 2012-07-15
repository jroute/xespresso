	<div id="content-left">

		<div class="latest">
			<h3><?=$html->link('Database - Q&A','/board/lst/db-qna');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'db-qna',
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	
		
		<div class="latest">
			<h3><?=$html->link('Database','/board/lst/db');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'db',
                                'category'=>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>			
		
		<div class="latest">
			<h3><?=$html->link('MySQL','/board/lst/db/category:22');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'db',
                                'category'=>22,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	

	
		<div class="latest">
			<h3><?=$html->link('MS-SQL','/board/lst/db/category:23');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'db',
                                'category'=>23,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
		

		<div class="latest">
			<h3><?=$html->link('Oracle','/board/lst/db/category:24');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'db',
                                'category'=>24,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
				
		<div class="latest">
			<h3><?=$html->link('PostgreSQL','/board/lst/db/category:25');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'db',
                                'category'=>25,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
		
		<div class="latest">
			<h3><?=$html->link('SQLite','/board/lst/db/category:26');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'db',
                                'category'=>26,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	

		<div class="latest">
			<h3><?=$html->link('DB2','/board/lst/db/category:42');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'db',
                                'category'=>42,
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