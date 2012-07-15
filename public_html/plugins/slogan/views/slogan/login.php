<style type="text/css">
form {
	border:5px solid #f5f5f5;
	width:200px;
	padding:20px;
	margin:100px auto;
	text-align: center;
}
</style>

<?=$form->create('Auth',array('url'=>$this->here));?>
<?=$form->text('passwd');?>
<?=$form->submit('로그인',array('div'=>false));?>
<?=$form->end();?>