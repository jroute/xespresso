
<?=$html->css("/board/css/skins/".$setup['skin']);?>
<?=$javascript->link(array('/board/js/board'));?>

<div id="board-wrap">


	<div id="read-header">
	
		<div id="subject">
			<h1>
				<?php if( $setup['use_category'] && @$data['BoardCategory']["name"] ):?>
					<span class="category">[<?=$data['BoardCategory']["name"]?>] </span>
				<?php endif;//end of use_category?>	
				<?=$data['Board']['subject']?>
			</h1>
		
			<span class="date"><?=substr($data['Board']['created'],2,14)?></span>

		</div>

		
		<p id="meta">
			<span class="name"><?=$data['Board']['name']?></span><span class="hit"><?=__('hit');?> : <?=$data['Board']['hit']?></span>
			<br style="clear:both" />			
		</p>
		
	</div>

	
		
	<div style="min-height:250px;" id="board-content-view">
<?php 
if( @$setup['use_auto_fileview'] ):?>
	<?php foreach($data['BoardFile'] as $files ):
		if( eregi("(gif|jpg|png|bmp)$",$files['name'])):?>
		<p><a href="/files/board/<?=$bid?>/<?=$files['fsname']?>" class="lightbox"><?=$image->resize('/files/board/'.$bid.'/'.$files['fsname'],600,600)?></a></p>
	<?php elseif( eregi('(png)$',$files['name']) ):
			$size = @getimagesize(APP.'webroot/files/board/'.$bid.'/'.$files['fsname']);
			if( $size[0] > 550 ) $w = 550; else $w = $size[0];
		?>
		<p><a href="/files/board/<?=$bid?>/<?=$files['fsname']?>" class="lightbox"><img src="/files/board/<?=$bid?>/<?=$files['fsname']?>" width="<?=$w?>" /></a></p>	
	<?php endif;
	endforeach?>

<?php endif?>

	<?=$data['Board']['content']?>

	</div>
	

	
</div>

<?=$javascript->codeBlock("
$(function(){
	window.print();
});
",array('inline'=>false));?>

