<?=$html->css(array('/users/css/default'),null,array('inline'=>false));?>

<?=@$skin_header?>


<?php if ($session->check('Message.auth')) $session->flash('auth');?>


<div id="login-box">
<?=$form->create('User', array('url'=>$this->here));?>
<?=$form->hidden('redirect',array('value'=>@$redirect));?>
                

<div class="clearfix">
	<label for="userid">아이디</label>
	<div class="input"><?=$form->text('userid',array('id'=>'userid','size'=>'16','tabindex'=>'1'));?></div>
</div>	

<div class="clearfix">
	<label for="passwd">비밀번호</label>
	<div class="input"><?=$form->password('passwd',array('id'=>'passwd','size'=>'16','tabindex'=>'2'));?></div>
</div>

<div class="clearfix">
	<label for="submit"></label>
	<div class="input"><button type="submit" id="submit" class="btn primary">로그인</button></div>
</div>


<div class="clearfix">
	<label></label>
	<div class="input">	
<?=$html->link('아이디/비밀번호찾기',array('action'=>'find'),array('escape'=>false));?>
 |
<?=$html->link('회원가입',array('action'=>'agree'),array('escape'=>false));?>
	</div>
</div>	
<?=$form->end();?>             
</div>

<?=@$skin_footer?>