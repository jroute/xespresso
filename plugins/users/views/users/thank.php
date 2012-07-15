<?=$skin_header?>

<div style="margin:0 auto;width:500px;border:1px solid #f5f5f5;board-radius:4px 4px 4px 4px;padding:20px;">

	<h2>회원가입을 축하드립니다.</h2>
	
	<p style="margin:20px 0">
	<?=$html->link('홈페이지로 이동','/',array('class'=>'btn'));?>
	
	<?=$html->link('로그인','/users/login',array('class'=>'btn success'));?>
	</p>

</div>

<?=$skin_footer?>
      