

<?php echo $html->css("/board/css/skins/".$setup['skin'],null,array('inline'=>false));?>
<?php echo $javascript->link(array('/board/js/board'),false);?>
<?php $syntaxHighlighter->load(&$javascript);?>


<?php echo $this->element("board/profile",array('position'=>'right','align'=>'top','tail'=>'top'));?>


<div id='board-wrap'>

	<?php echo $setup['skin_header']?>

	<?php echo $session->flash('board')?>

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
			<span class="name profile" bid="<?=$bid?>" data="<?=$data['Board']['crypt_userid']?>">
			<?php if( $data['User']['profile'] ):?>
			<img class="profile" src="<?=$data['User']['profile']?>" width="20" height="20" alt="<?=$data['Board']['name']?> 사진"  />
			<?php endif;?>			
			<?=$data['Board']['name']?></span><span class="hit"><?=__('hit');?> : <?=$data['Board']['hit']?></span>
			<br style="clear:both" />			
		</p>
		
		<?php if( $setup['use_link1'] || $setup['use_link2'] ):?>
		<p id="meta">

			<?php if( $data['Board']['link1'] ):?><span style="margin-left:10px">Link #1 : <?=$html->link($data['Board']['link1'],$data['Board']['link1'],array('target'=>'_blank'));?></span><?php endif;?>
			<?php if( $data['Board']['link2'] ):?><span style="margin-left:10px">Link #2 : <?=$html->link($data['Board']['link2'],$data['Board']['link2'],array('target'=>'_blank'));?></span><?php endif;?>
			</span>
		</p>
		<?php endif;?>
		
	</div>

	
	<?=$this->element('view_service');?>
	
	<?=$this->element('view_snsbuttons');?>	
	
		
	<div style='min-height:250px;' id="board-content-view">
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


	<?php echo $syntaxHighlighter->convert($data['Board']['content'])?>

	</div>
	<?php if( $setup['use_tag'] ):?>
	<p class="tag" id="tag">태그(Tag) : <?=$data['Board']['tags']?></p>
	<?php endif;?>
	<?=$this->element('view_qrcode');?>



<?php
/*********************** Begin Comment *************************/
if( $setup['use_comment'] ):?>
	<br />
<?
echo $this->element('comment', array('plugin' => 'comment',
                                    'model' => 'Board.Board',
                                    'key'=>$bid,
                                    'id' =>$data['Board']['no'],
                                   	'return_url'=>$this->here,
                                    'mailto'=>array(
                                    	'name'=>$data['Board']['name'],
                                    	'email'=>$data['Board']['email'],
                                    	'subject'=>__('회원님의 글에 댓글을 남겼습니다.',true),
                                    	)
                                    ));
?>
<?php endif;//use comment
/*********************** End Comment *************************/
?>

	<br />
	<table id="tbl-neighbors" >
	<col width='100' />
	<col width='*' />
	<tr>
	<th class='prev'><?=__('next')?> <?=$html->image('/board/img/skins/'.$setup['skin'].'/arrow1.jpg')?></th><td class='prev'><b>&nbsp;<?=$html->link($next['subject'],array_merge(array($bid,$next['no']),$this->params['named']))?></b></td></tr>
	<tr><th class='next'><?=__('prev')?> <?=$html->image('/board/img/skins/'.$setup['skin'].'/arrow2.jpg')?></th><td class='next'><b>&nbsp;<?=$html->link($prev['subject'],array_merge(array($bid,$prev['no']),$this->params['named']))?></b></td>
	</tr>
	</table>


	<div id='btn-area'>
		<?=$html->link(__('list',true),array_merge(array('plugin'=>false,'action'=>'lst',$bid),$this->params['named']),array('escape'=>false,'class'=>'button'));?>

		<?php if( (int)$session->Read('User.level') >= $level['lv_write'] ):?><?=$html->link(__('write',true),array_merge(array('plugin'=>false,'action'=>'write',$bid),$this->params['named']),array('escape'=>false,'class'=>'button'));?><?php endif?>
		<?php if( (int)$session->Read('User.level') >= $level['lv_reply'] ):?><?=$html->link(__('reply',true),array_merge(array('plugin'=>false,'action'=>'reply',$bid,$data['Board']['no']),$this->params['named']),array('escape'=>false,'class'=>'button'));?><?php endif?>
		<?php if( (int)$session->Read('User.level') >= $level['lv_edit']  
		|| ( $data['Board']['userid'] && $session->Read('User.userid') == $data['Board']['userid']) 
		|| !$data['Board']['userid']):?><?=$html->link(__('modify',true),array_merge(array('plugin'=>false,'action'=>'edit',$bid,$data['Board']['no']),$this->params['named']),array('escape'=>false,'class'=>'button'));?><?php endif?>
		<?php if( (int)$session->Read('User.level') >= $level['lv_delete']  
		|| ( $data['Board']['userid'] && $session->Read('User.userid') == $data['Board']['userid']) || !$data['Board']['userid'] ):?><?=$html->link(__('delete',true),array_merge(array('plugin'=>false,'action'=>'delete',$bid,$data['Board']['no']),$this->params['named']),array('escape'=>false,'class'=>'button'));?><?php endif?>
	</div>




<?php /********************* view 하단 리스트 출력 시작 *********************/ ?>
<?php if( $setup['use_viewlist'] ):?>

	<div id="view-list">
	<?=$this->element('lst');?>	
	</div>
		
<?php endif;?>
<?php /********************* view 하단 리스트 출력 끝 *********************/ ?>





	<?=$setup['skin_footer']?>

</div>


<?=$javascript->link('jquery/plugins/lightbox/jquery.lightbox-0.5',false)?>
<?=$html->css('/js/jquery/plugins/lightbox/css/jquery.lightbox-0.5');?>
<?=$javascript->codeBlock("
$(function(){

	$('a.lightbox').lightBox();

});
",array('inline'=>false))?>