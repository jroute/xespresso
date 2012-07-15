
<?=$html->css("/board/css/skins/".$setup['skin']);?>

<div id='board-wrap'>

	<?=$setup['skin_header']?>

	<div id='board-confirm-wrap'>
	<?=$form->create("Board",array('url'=>$this->here));?>
	<?=$form->hidden("bid")?>
	<?=$form->hidden("userid")?>
	<?=$form->error('bid','* 게시판 아이디 지정이 되지 않아 글 입력을 할 수 없습니다.')?>


	<?php if( $action == "edit" ):?>
		<h4 class='confirm-title'><?=__('modify')?></h4>
	<?php elseif($action == "delete" ):?>
		<h4 class='confirm-title'><?=__('delete')?></h4>
	<?php else:?>
		<h4 class='confirm-title'><?=__('confirm')?></h4>	
	<?php endif;?>

	<table class="tbl-board-view">
	<caption><?=__('confirm')?></caption>	
	<col width="80" />
	<col width="*" />
	<tr><th><?=__('subject')?></th><td><?=$form->label($this->data['Board']["subject"])?></td></tr>
	<?php if( $delAuthority ):?>
		<tr><th><?=__('message')?></th><td><?=__('del-qmsg')?></td></tr>
	<?php else:?>
		<tr><th><?=__('password')?></th><td><?=$form->password("passwd",array("class"=>"txt width150px"))?><?if( $error ){echo "<div class='error-message'>* 비밀번호를 확인하십시오</div>";}?></td></tr>
		<tr><th><?=__('message')?></th><td><div id='message-edit'><?=__('del-msg')?></div>	</td></tr>
	<?php endif?>

	</table>

	<div id='btn-area'>
		<?=$form->submit(__('confirm',true),array("div"=>false,'class'=>'button'));?>
		<?=$html->link(__('cancel',true),array_merge(array('plugin'=>false,'action'=>'view',$bid,$no)),array('class'=>'button','escape'=>false));?>
	</div>
	<?=$form->end();?>

	</div>
<?=$setup['skin_footer']?>

</div>