<?=$html->css('/search/css/search',false);?>

<div id="content">


<?php foreach($rows as $division=>$search_rows):?>

	<p>
	<h3>
	<?php 
	switch($division){
		case 'board':
			echo "게시판 검색";
			break;
		case 'comment':
			echo "댓글 검색";		
			break;
		case 'page':
			echo "컨텐츠 검색";
			break;
	}
	?>
	</h3>
	</p>


	
<?php
	switch($division){
		case 'board':
?>
	<ul>
	<?php foreach($search_rows as $row):
		$data = array_shift($row);
	?>
	
		<li>
		<p class="title"><?=$html->link($data['subject'],array('plugin'=>false,'controller'=>'board','action'=>'view',$data['bid'],$data['no']))?></p>
		<p class="date"><?=$data['name']?>, <?=$data['created']?></p>
		<p class="content"><?=strcut(strip_tags($data['content']),300)?></p>
		<p class="link"><?=$html->link('http://'.$_SERVER['HTTP_HOST'].'/board/view/'.$data['bid'].'/'.$data['no'],array('webadm'=>false,'plugin'=>false,'controller'=>'board','action'=>'view',$data['bid'],$data['no']),array('target'=>'_blank'))?></p>
		</li>
		
	<?php endforeach;?>
	</ul>	
	<hr class="hr" />
<?php
			break;
		case 'comment':
?>
	<ul>
	<?php foreach($search_rows as $row):
		$data = array_shift($row);
	?>
	
		<li>
		<p class="title"><?=$html->link(strcut(strip_tags($data['comment']),80),array('plugin'=>false,'controller'=>'board','action'=>'view',$data['model_key'],$data['model_id']))?></p>
		<p class="date"><?=$data['name']?>, <?=$data['created']?></p>
		<p class="link"><?=$html->link('http://'.$_SERVER['HTTP_HOST'].'/board/view/'.$data['model_key'].'/'.$data['model_id'],array('webadm'=>false,'plugin'=>false,'controller'=>'board','action'=>'view',$data['model_key'],$data['model_id']),array('target'=>'_blank'))?></p>
		</li>		
	<?php endforeach;?>
	</ul>		
	<hr class="hr" />	
<?php
			break;
		case 'page':
?>
	<ul>
	<?php foreach($search_rows as $row):
		$data = array_shift($row);
	?>
	
		<li>
		<p class="title"><?=$html->link($data['title'],array('plugin'=>false,'controller'=>'pages','action'=>'view',$data['id']))?></p>
		<p class="date"><?=$data['created']?></p>
		<p class="content"><?=strcut(strip_tags($data['content']),300)?></p>
		<p class="link"><?=$html->link('http://'.$_SERVER['HTTP_HOST'].'/pages/'.$data['id'],'/pages/'.$data['id'],array('target'=>'_blank'))?></p>		
		</li>		
	<?php endforeach;?>
	</ul>		
	<hr class="hr" />	
<?php
			break;						
	}
	?>	




<?php endforeach;?>

</div>