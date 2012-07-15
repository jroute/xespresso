<?=$html->css(array('/board/css/jquery.galleria'),false);?>
<?=$javascript->link(array('/board/js/jquery.galleria'),false);?>
<?=$javascript->codeBlock("
    Galleria.loadTheme('/board/img/skins/default/gallery/classic/galleria.classic.js');
    
$(function(){
    // Initialize Galleria
    $('#galleria').galleria();

});
",array('inline'=>false));?>
<div id="navigation-bar">
	<?=$this->element("board/webadm_navigation_bar");?>
</div>

<div id='top-tabs'>
</div>

<div id='content'>

<div id='board-wrap'>

	<div id='board-view-wrap'>

	<?=$session->flash('board')?>

	<table class="tbl" >
	<col width='15%' />
	<col width='35%' />
	<col width='15%' />
	<col width='35%' />
	<tr>
	<th>제목</th><td colspan='3'><b><?=$data['Board']['subject']?></b></td>
	</tr>

	<?php if( $setup['use_category'] ):?>
		<tr><th>카테고리</th><td  colspan='3'><?=$data['BoardCategory']["name"]?></td></tr>
	<?php endif;//end of use_category?>

	<tr>
	<th>작성자</th><td><?=$data['Board']['name']?></td>
	<th>작성일</th><td><?=substr($data['Board']['created'],2,14)?></td>	
	</tr>


<?
/*********************** Begin File *************************/
if( $setup['use_file'] ):?>
	<tr>
	<th>파일</th><td  colspan='3'>
	<ul class="board-file-list">
	<?php foreach($data['BoardFile'] as $files ): if( ereg('jpeg|jpg|gif|png',$files['ext']) ) continue;?>
		<li><a href="/board/download/<?=$bid?>/<?=$no?>/<?=$files['id']?>"><img src='/board/img/exts/<?=$setup['skin_icon']?>/<?=$files['ext']?>.gif' border='0' alt="<?=$files['name']?>" /> <?=$files['name']?></a></li>
	<?php endforeach;?>
	</ul>
	</td>	
	</tr>
<?endif
/*********************** End File *************************/
?>


<?php if($setup['use_link1']):?>
	<tr><th>링크 #1</th><td colspan="3"><a href="<?=$data['Board']['link1']?>" target="_blank"><?=$data['Board']['link1']?></a></td></tr>
<?php endif?>
<?php if($setup['use_link2']):?>
	<tr><th>링크 #2</th><td colspan="3"><a href="<?=$data['Board']['link2']?>" target="_blank"><?=$data['Board']['link2']?></a></td></tr>
<?php endif?>



	<tr><td colspan='4' valign='top' style='min-height:200px;padding:10px;' height='200'>
	
		<div style='min-height:200px;' id='board-content-view'>



		
<?php if( @$setup['use_auto_fileview'] || @$setup['use_auto_mediaview'] ):?>
	<?php if( $setup['use_auto_fileview'] ):?>
		<div id="galleria">
	<?php endif;?>
	<?php 
		foreach($data['BoardFile'] as $files ):
		if( $setup['use_auto_fileview'] && eregi("(gif|jpg|png|bmp)$",$files['name'])):
			$size = @getimagesize(APP.'webroot/files/board/'.$bid.'/'.$files['fsname']);
			if( $size[0] > 600 ) $w = 600; else $w = $size[0];
		?>
		<?=$image->resize('/files/board/'.$bid.'/'.$files['fsname'], 600, 600,true);?>
	<?php elseif( $setup['use_auto_mediaview'] && eregi("(wmv|avi|asf|mp3|mp4)$",$files['name']) ):?>
		<?=$media->src($files['name'],"/files/board/".$bid."/".$files['fsname']);?>
	<?php endif;?>
	<?php endforeach?>

	<?php if( $setup['use_auto_fileview'] ):?>
		</div>
	<?php endif;?>
	<?php endif?>

	<br style="clear:both" />
	
	<?=$data['Board']['content']?>
	
	
	
	<div class="right"><?=$data['Board']['ip']?></div>
	</td></tr>
	<?php if( $setup['use_tag'] ):?>
		<tr><th>태그</th><td  colspan='3'><?=$data['Board']['tags']?></td></tr>
	<?php endif;//end of use_category?>
	</table>

	<br />
	<table id="tbl-neighbors" class="tbl">
	<col width='100' />
	<col width='*' />
	<tr><th class='prev'>다음글</th><td  class='prev'><b><?=$html->link($next['subject'],array_merge(array($bid,$next['no']),$this->params['named']))?></b></td></tr>
	<tr><th class='next'>이전글</th><td  class='next'><b><?=$html->link($prev['subject'],array_merge(array($bid,$prev['no']),$this->params['named']))?></b></td>
	</tr>
	</table>


<?php if( $setup['use_comment'] ):?>
	<br />
<?php	
echo $this->element('webadm_comment', array('plugin' => 'comment',
                                    'model' => 'Board',
                                    'key'=>$bid,
                                    'id' =>$data['Board']['no'],
                                    0,//captcha
                                    base64_encode($this->here)
                                    ));
?>
<?php endif;//use comment?>


	<div id='btn-area' class="gBtn1 floatright">
		<?=$html->link('<span>목록</span>',array_merge(array('plugin'=>false,'action'=>'lst',$bid),$this->params['named']),array('class'=>'small orange awesome','escape'=>false));?>

		<?=$html->link('<span>글등록</span>',array_merge(array('plugin'=>false,'action'=>'write',$bid),$this->params['named']),array('class'=>'small orange awesome','escape'=>false));?>
		<?=$html->link('<span>답글</span>',array_merge(array('plugin'=>false,'action'=>'reply',$bid,$data['Board']['no']),$this->params['named']),array('class'=>'small orange awesome','escape'=>false));?>
		<?=$html->link('<span>수정</span>',array_merge(array('plugin'=>false,'action'=>'edit',$bid,$data['Board']['no']),$this->params['named']),array('class'=>'small orange awesome','escape'=>false));?>
		<?=$html->link('<span>삭제</span>',array_merge(array('plugin'=>false,'action'=>'delete',$bid,$data['Board']['no']),$this->params['named']),array('class'=>'small orange awesome','escape'=>false));?>
	</div>

	</div>
</div>

</div>