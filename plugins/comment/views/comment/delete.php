

<?=$html->css("/css/buttons/default.css");?>
	<?=$form->create("Comment",array('url'=>$this->here,'style'=>'margin:30px'));?>

	<table>
	<col width="80" />
	<col width="*" />
	<?php if( $authority ):?>
		<tr><th><?=__('message')?></th><td><?=__('del-qmsg')?></td></tr>
	<?php else:?>
		<tr><th><?=__('password')?></th><td><?=$form->password("passwd",array("class"=>"txt width150px"))?>
		<?php if( $error ){ echo " <span class='error-message'>* 비밀번호를 확인하십시오</span>"; } ?></td></tr>
		<tr><th><?=__('message')?></th><td><div id='message-edit'><?=__('del-msg')?></div>	</td></tr>
	<?php endif?>

	</table>

	<div id='btn-area'>
		<?=$form->submit(__('confirm',true),array("div"=>false,'class'=>'awesome samll blue'));?>
		<?=$html->link(__('cancel',true),$redirect,array('class'=>'awesome samll blue','escape'=>false));?>
	</div>
	<?=$form->end();?>
