<?=$html->css('/comment/css/comment',null,array('inline'=>false));?>
<?php
$_mailto = base64_encode(serialize($mailto));
$comments = $this->requestAction('comment/lst/'.$model.'/'.$id, array('return'));
?>

<div class="cmt-area">
<div class="cmt-title">
<h3><?=__('comment');?> (<?=count($comments);?>)</h3>
</div>
<?=$session->flash('comment')?>

<?php if( $session->read('User.userid') ):/*** Logined ***/?>
	<?=$form->create('Comment',array('url'=>array('plugin'=>'comment','controller'=>'comment','action'=>'save',$model,$key,$id,@$setup['use_captcha'], base64_encode($this->here))))?>
		<?=$form->hidden('Comment.return_url',array('value'=>$return_url));?>	
		<?=$form->hidden('Comment.mailto',array('value'=>$_mailto));?>
	

		<table class="cmt-tbl tbl">
		<col width="10%" />
		<col width="20%" />
		<col width="10%" />
		<col width="25%" />
		<col width="10%" />
		<col width="25%" />		
		<caption><?=__('Comment');?></caption>


		<?php if( $session->read('User.userid') ):/*** Logined ***/?>
			<?=$form->hidden('Comment.passwd',array('value'=>md5(time())))?><?=$form->error('Comment.passwd','비밀번호를 입력하십시오')?>
			<?=$form->hidden('Comment.homepage',array())?></td>
			<?=$form->hidden('Comment.name',array('value'=>$session->Read('User.name')))?>
			<?=$form->hidden('Comment.email',array('value'=>$session->Read('User.email')))?>
		<?php else:/*** Logined ***/?>
		<tr>
			<th><?=__('name')?></th>
			<td><?=$form->text('Comment.name',array('class'=>'cmt-text'))?><?=$form->error('Comment.name','이름을 입력하십시오')?></td>
			<th><?=__('email')?></th>
			<td><?=$form->text('Comment.email',array('class'=>'cmt-text'))?><?=$form->error('Comment.email','이메일 형식에 맞지 않습니다.')?></td>			
			<th><?=__('password')?></th>
			<td><?=$form->password('Comment.passwd',array('class'=>'cmt-text'))?><?=$form->error('Comment.passwd','비밀번호를 입력하십시오')?></td>
		</tr>
		<?php endif;?>

		<tr>
		<td colspan="6"><?=$form->textarea('Comment.comment',array('class'=>'cmt-textarea'))?><?=$form->error('Comment.comment','덧글을 작성 하십시오')?></td>
		</tr>
		
		<?php if( @$setup['use_captcha'] ):?>
		<tr><th><?=__('Captcha');?></th><td colspan="5">
<script type="text/javascript">
//<![CDATA[
		var captchacnt = 0;
		function recaptcha(){
			captchacnt++;$('#captcha-img').attr('src','/captcha/image/120/45?'+captchacnt);
		}
//]]>
</script>
	<img src="/captcha/image/120/45" id='captcha-img'  style="float:left;" />
	<p style="float:left;margin:3px;">
	<?=$form->text("captcha",array("class"=>"txt",'style'=>'width:120px;text-align:center;font-weight:bold;'))?><br />
	(<a href="javascript:void(0)" onclick="recaptcha(); return false;">이미지 새로고침</a>) 좌측에 보이는 문자를 입력하십시오
	</p>
	<div style="clear:both"><?=$form->error('captcha','보안문자가 일치 하지 않습니다. 확인 후 다시 입력하십시오');?></div>
	</td>	</tr>
		<?php endif?>
		
		</table>
		<div id='btn-area-comment'><?=$form->submit(__('comment',true),array('class'=>'button'))?></div>
	<?=$form->end();?>
	<br />
<?php endif;/* logined */?>	
<div id="cmt-list">
	<?php 
	foreach($comments as $row):?>
	
 		<div id="comment-<?=$row['Comment']['no']?>" class="comment-item">
 		
 			<div class="cmt-profile">
 				<span class="profile" bid="<?=$bid?>" data="<?=$row['Comment']['crypt_userid']?>">
				<?php if( $row['User']['profile'] ):?>
				<img class="profile" src="<?=$row['User']['profile']?>" width="48" height="48" alt="<?=$row['Comment']['name']?> 사진"  />
				<?php else:?>
				<img class="profile" src="/users/img/profile.png" width="48" height="48" alt="<?=$row['Comment']['name']?> 사진"  />		
				<?php endif;?> 			
				</span>
 			</div>
			
			<div class="cmt-content">
					<div class="cmt-author"><span class="author-name"><?=$row['Comment']['name']?></span></div>			

					<?=nl2br(htmlspecialchars($row['Comment']['comment']))?>
			
				<div class="cmt-date">
					<span class="cmt-ip"><?php @list($ip1,,$ip2) = explode('.',$row['Comment']['ip']); echo $ip1.'.***.***.'.$ip2;?></span>				
					<?=substr($row['Comment']['created'],0,16)?> 
					<span class='cmt-del'><a href="/comment/delete/<?=$model?>/<?=$id?>/<?=$row['Comment']['no']?>/<?=base64_encode($this->here)?>" onclick="delCmt('<?=$row['Comment']['userid']?>',<?=$row['Comment']['no']?>);return false;"><?=$html->image('/board/img/skins/default/icon_del.png',array('alt'=>'삭제'))?></a></span>
				</div>
				
			</div>
			 
		</div>
		
	<?php endforeach;?>
</div>

<div id="dialog-cmt-del" style='display:none' title="댓글 삭제">
<?=$form->create('Comment',array('id'=>'CommentDelForm','url'=>array('plugin'=>'comment','controller'=>'comment','action'=>'delete',$model,$key,$id,0,base64_encode($this->here))))?>
<?=$form->hidden('no');?>
<?php if( $session->Read('User.userid') ):?>
<div style='text-align:center;margin:20px auto;' id='cmtdel-message'>
댓글을 삭제하시겠습니까?
</div>
<?php else:?>
<div style='text-align:center;margin:20px auto' id='cmtdel-passwd'>
비밀번호 : <?=$form->password('passwd',array('value'=>'','class'=>'txt'));?>
</div>
<?php endif;?>



<?=$form->end();?>
</div>


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