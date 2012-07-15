


<div>

<?=$session->flash('comment')?>

	<?=$form->create('Comment',array('url'=>array('webadm'=>false,'plugin'=>'comment','controller'=>'comment','action'=>'save',$model,$key,$id,base64_encode($this->here))))?>
	

		<table class="cmt-tbl tbl">
		<col width="100" />
		<col width="*" />
		<col width="100" />
		<col width="*" />
		<?php if( $session->read('Admin.userid') ):/*** Logouted ***/?>
			
			<tr>
			<th><?=__('name')?></th><td><?=$form->text('Comment.name',array('class'=>'cmt-text'))?><?=$form->error('Comment.name','이름을 입력하십시오')?></td>
			<th><?=__('email')?></th><td><?=$form->text('Comment.email',array('class'=>'cmt-text'))?><?=$form->error('Comment.email','이메일 형식에 맞지 않습니다.')?>
			<?=$form->hidden('Comment.passwd',array('class'=>'cmt-text'))?><?=$form->error('Comment.passwd','비밀번호를 입력하십시오')?>
			<?=$form->hidden('Comment.homepage',array('class'=>'cmt-text'))?></td>
			</tr>

		<?php else:/*** Logined ***/?>

		<tr>
			<th><?=__('name')?></th><td><?=$form->text('Comment.name',array('class'=>'cmt-text'))?><?=$form->error('Comment.name','이름을 입력하십시오')?></td>
			<th><?=__('password')?></th><td><?=$form->password('Comment.passwd',array('class'=>'cmt-text'))?><?=$form->error('Comment.passwd','비밀번호를 입력하십시오')?></td>
			</tr>
			<tr>
			<th><?=__('email')?></th><td><?=$form->text('Comment.email',array('class'=>'cmt-text'))?><?=$form->error('Comment.email','이메일 형식에 맞지 않습니다.')?></td>
			<th><?=__('homepage')?></th><td><?=$form->text('Comment.homepage',array('class'=>'cmt-text'))?><?=$form->error('Comment.homepage','홈페이지 주소 형식에 맞지 않습니다.')?></td>
			</tr>

		<?php endif;?>

		<tr><th><?=__('comment')?></th><td colspan='3'><?=$form->textarea('Comment.comment',array('class'=>'cmt-textarea txt w99ps'))?><?=$form->error('Comment.comment','덧글을 작성 하십시오')?></td></tr>
		</table>
		<div id='btn-area-comment'><?=$form->submit(__('comment',true),array('class'=>'button'))?></div>
	<?=$form->end();?>
	
</div>	
	
	<br />

	<table class='cmt-tbl tbl'>
	<col width='100'>
	<col width='*'>
	<?php $comments = $this->requestAction('comment/lst/'.$model.'/'.$id, array('return'));?>
	<?php foreach($comments as $comment):?>
		<tr><th><?=$comment['Comment']['name']?>
		<?php if( $comment['Comment']['userid'] ):?><div>(<?=$comment['Comment']['userid']?>)</div><?php endif;?></th><td>

		<div><?=$comment['Comment']['comment']?></div> 
		
		<p class="right" style="padding:0;margin:0;color:#ccc;">
		<span class='cmt-ip'><?=$comment['Comment']['ip']?></span> , 
		<span class='cmt-date'><?=substr($comment['Comment']['created'],0,16)?> <span class='cmt-del'><a href='javascript:void(0)' onclick="delCmt('<?=$comment['Comment']['userid']?>',<?=$comment['Comment']['no']?>)"><?=$html->image('/board/img/skins/'.$setup['skin'].'/icon_del.png',array('alt'=>'삭제','style'=>'vertical-align:top;'))?></a></span></span>
		</p>
		</td></tr>
	<?php endforeach;?>
	</table>
	
	

<div id="dialog-cmt-del" style="display:none" title="댓글 삭제">
<?=$form->create('Comment',array('id'=>'CommentDelForm','url'=>array('webadm'=>false,'plugin'=>'comment','controller'=>'comment','action'=>'delete',$model,$key,$id,0,base64_encode($this->here))))?>
<?=$form->hidden('no');?>
<?=$form->hidden('passwd');?>
<div style="text-align:center;margin:20px auto;" id="cmtdel-message">
댓글을 삭제하시겠습니까?
</div>

<?=$form->end();?>
</div>
<script type='text/javascript'>
//<![CDATA[
function delCmt(uid, no){

	$('#CommentNo').val(no);

	
	$('#dialog-cmt-del').dialog({
		autoOpen:true,
		width: 300,
		height:180,
		modal:true,
		buttons: {
			"닫기": function() { 
				$(this).dialog("destroy"); 				
			},
			"삭제": function() { 
				$('#CommentDelForm').submit();
			} 
		}
	});
	return false;

};
//]]>
</script>