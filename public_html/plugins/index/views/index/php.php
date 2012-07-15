	<div id="content-left">

		<div class="latest">
			<h3><?=$html->link('PHP - QnA','/board/lst/php-qna');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'php-qna',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	

		<div class="latest">
			<h3><?=$html->link('PHP Frameworks','/board/lst/php-frameworks');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'php-frameworks',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
	
		<div class="latest">
			<h3><?=$html->link('CakePHP','/board/lst/php-frameworks/category:8');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'php-frameworks',
                                'category' =>8,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
		

		<div class="latest">
			<h3><?=$html->link('CodeIgniter','/board/lst/php-frameworks/category:9');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'php-frameworks',
                                'category' =>9,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>
		
		<div class="latest">
			<h3><?=$html->link('PHP','/board/lst/php');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'php',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>						
		
		<div class="latest">
			<h3><?=$html->link('Tip & Tech','/board/lst/php-tiptech');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'php-tiptech',
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>		
		
		<div class="latest">
			<h3><?=$html->link('Lecture','/board/lst/php-lecture');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>'php-lecture',
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