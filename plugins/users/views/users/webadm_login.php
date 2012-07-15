<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>관리자 로그인</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('webadm','/users/css/webadm_login'));
		echo $javascript->link(array(
			'jquery/jquery-1.4.2.min'			
		));

	?>
</head>
<body>


<?php if ($session->check('Message.auth')) $session->flash('auth');?>

<?php
if (isset($message)) {
    echo '<p class="error">'.$message.'</p>';
}
?>

<div id="content-wrap">
	
	<div id="wrapper">
	
		
		<?php echo $form->create('User', array('action' => 'login'));?>
		<div id="login_wrap">
			<div id="login">
	         <ul>
	         		<li><?=$form->text('userid',array('size'=>20,'class'=>'id'));?></li>
	           	<li><?=$form->password('passwd',array('size'=>20,'class'=>'id'));?></li>
	         </ul>
	     </div>
	         <p><?=$form->submit('/users/img/login_btn.gif',array('div'=>false))?></p>	     
	    </div>
	    <?=$form->end();?>

	</div>

</div>

</body>
</html>
