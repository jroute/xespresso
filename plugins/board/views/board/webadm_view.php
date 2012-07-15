<?=$html->css("/board/css/skins/".$setup['skin'],null,array('inline'=>false));?>
<?=$javascript->link(array('/board/js/board'));?>

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
	<th>제목</th><td colspan='3'>
	<?php if( $setup['use_approve'] && $data['Board']['opt_approval'] == '0' ):?><span style="color:red;margin-right:5px;">[비승인]</span><?php endif;?>
	<b><?=$data['Board']['subject']?></b></td>
	</tr>

	<?php if( $setup['use_category'] ):?>
		<tr><th>카테고리</th><td  colspan='3'><?=$data['BoardCategory']["name"]?></td></tr>
	<?php endif;//end of use_category?>

	<tr>
	<th>작성자</th><td><?=$data['Board']['name']?></td>
	<th>작성일</th><td><?=substr($data['Board']['created'],2,14)?></td>	
	</tr>


<?php if($setup['use_link1']):?>
	<tr><th>링크 #1</th><td colspan="3"><a href="<?=$data['Board']['link1']?>" target="_blank"><?=$data['Board']['link1']?></a></td></tr>
<?php endif?>
<?php if($setup['use_link2']):?>
	<tr><th>링크 #2</th><td colspan="3"><a href="<?=$data['Board']['link2']?>" target="_blank"><?=$data['Board']['link2']?></a></td></tr>
<?php endif?>



	<tr><td colspan='4' valign='top' style='min-height:200px;padding:10px;' height='200'>
	
	<?=$this->element('view_service');?>
		
		<div style='min-height:200px;' id="board-content-view">
		<!--
<?php 
if( @$setup['use_auto_fileview'] || @$setup['use_auto_mediaview'] ):?>
	<?php 
		foreach($data['BoardFile'] as $files ):
		if( $setup['use_auto_fileview'] && eregi("(gif|jpg|png|bmp)$",$files['name'])):
			$size = @getimagesize(APP.'webroot/files/board/'.$bid.'/'.$files['fsname']);
			if( $size[0] > 550 ) $w = 550; else $w = $size[0];
		?>
		<p><?=$image->resize('/files/board/'.$bid.'/'.$files['fsname'],550,550,true);?></p>
	<?php elseif( $setup['use_auto_mediaview'] && eregi("(wmv|avi|asf|mp3|mp4)$",$files['name']) ):?>
		<?=$media->src($files['name'],"/files/board/".$bid."/".$files['fsname']);?>
	<?php endif;?>
	<?php endforeach?>

<?php endif?>
	-->
	<?=$data['Board']['content']?>
	
	<div class="right"><?=$data['Board']['ip']?></div>
	
	</div>
	
	<?=$this->element('view_service');?>
		
	</td></tr>
	<?php if( $setup['use_tag'] ):?>
		<tr><th>태그</th><td  colspan='3'><?=$data['Board']['tags']?></td></tr>
	<?php endif;//end of use_category?>
	</table>

	<br />
	<table id="tbl-neighbors" class="tbl">
	<col width='100' />
	<col width='*' />
	<tr><th class='prev'>다음글</th><td  class='prev'><b><?=$html->link($next['subject'],array_merge(array('plugin'=>false,$bid,$next['no']),$this->params['named']))?></b></td></tr>
	<tr><th class='next'>이전글</th><td  class='next'><b><?=$html->link($prev['subject'],array_merge(array('plugin'=>false,$bid,$prev['no']),$this->params['named']))?></b></td>
	</tr>
	</table>


<?php if( $setup['use_comment'] ):?>
	<br />

<?
echo $this->element('webadm_comment', array('plugin' => 'comment',
                                    'model' => 'Board.Board',
                                    'key'=>$bid,
                                    'id' =>$data['Board']['no'],
                                    0,
                                    base64_encode($this->here)
                                    ));
?>

<?php endif;//use comment?>


	<div id="btn-area" class="gBtn1 floatright">
		<?=$html->link('<span>목록</span>',array_merge(array('plugin'=>false,'action'=>'lst',$bid),$this->params['named']),array('class'=>'','escape'=>false));?>

		<?=$html->link('<span>글등록</span>',array_merge(array('plugin'=>false,'action'=>'write',$bid),$this->params['named']),array('class'=>'','escape'=>false));?>
		<?=$html->link('<span>답글</span>',array_merge(array('plugin'=>false,'action'=>'reply',$bid,$data['Board']['no']),$this->params['named']),array('class'=>'','escape'=>false));?>
		<?=$html->link('<span>수정</span>',array_merge(array('plugin'=>false,'action'=>'edit',$bid,$data['Board']['no']),$this->params['named']),array('class'=>'','escape'=>false));?>
		<?=$html->link('<span>삭제</span>',array_merge(array('plugin'=>false,'action'=>'delete',$bid,$data['Board']['no']),$this->params['named']),array('class'=>'','escape'=>false));?>
	</div>

	</div>
</div>

</div>