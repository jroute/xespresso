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

<?
if (isset($message)) {
    echo '<p class="error">'.$message.'</p>';
}
?>

<div id="content-wrap">
	
		
		<?=$form->create('OpenidUrl', array('url' =>$this->here));?>
			<div>
	         <ul>
	         		<li><?=$form->text('openid',array('size'=>20,'class'=>'openidtxt'));?></li>
	         </ul>
	     </div>
	         <p><?=$form->submit('Sign in',array('div'=>false))?></p>	     
	    <?=$form->end();?>

</div>

</body>
</html>
