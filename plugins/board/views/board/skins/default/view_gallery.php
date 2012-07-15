<?=$html->css(array('/board/css/jquery.galleria',"/board/css/skins/".$setup['skin']),false);?>
<?=$javascript->link(array('/board/js/jquery.galleria'),false);?>
<?=$javascript->link(array('/board/js/board'),false);?>



<?=$javascript->codeBlock("
    Galleria.loadTheme('/board/img/skins/default/gallery/classic/galleria.classic.js');
$(function(){
    // Initialize Galleria  
    $('#galleria').galleria();
    


});
",array('inline'=>false));?>

<div id='board-wrap'>

	<?=$setup['skin_header']?>

	<div id='board-view-wrap'>
	<?=$session->flash('board')?>



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
			<span class="name">
			
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
		<?=$image->resize('/files/board/'.$bid.'/'.$files['fsname'], 600, 600,true,array('target'=>'_blank','longdesc'=>'/files/board/'.$bid.'/'.$files['fsname']));?>
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
		<?=$html->link(__('list',true),array_merge(array('action'=>'lst',$bid),$this->params['named']),array('escape'=>false,'class'=>'button'));?>

		<?php if( (int)$session->Read('User.level') >= $level['lv_write'] ):?><?=$html->link(__('write',true),array_merge(array('action'=>'write',$bid),$this->params['named']),array('escape'=>false,'class'=>'button'));?><?php endif?>
		<?php if( (int)$session->Read('User.level') >= $level['lv_reply'] ):?><?=$html->link(__('reply',true),array_merge(array('action'=>'reply',$bid,$data['Board']['no']),$this->params['named']),array('escape'=>false,'class'=>'button'));?><?php endif?>
		<?php if( (int)$session->Read('User.level') >= $level['lv_edit']  
		|| ( $data['Board']['userid'] && $session->Read('User.userid') == $data['Board']['userid']) 
		|| !$data['Board']['userid']):?><?=$html->link(__('modify',true),array_merge(array('action'=>'edit',$bid,$data['Board']['no']),$this->params['named']),array('escape'=>false,'class'=>'button'));?><?php endif?>
		<?php if( (int)$session->Read('User.level') >= $level['lv_delete']  
		|| ( $data['Board']['userid'] && $session->Read('User.userid') == $data['Board']['userid']) || !$data['Board']['userid'] ):?><?=$html->link(__('delete',true),array_merge(array('action'=>'delete',$bid,$data['Board']['no']),$this->params['named']),array('escape'=>false,'class'=>'button'));?><?php endif?>
	</div>

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

	$('#board-content-view img').css('cursor','pointer');
	$('#board-content-view img').lightBox();

});
",array('inline'=>false))?>