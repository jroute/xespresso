<?php exit;?>
<form enctype="multipart/form-data" method="post">
<input type="file" name="file" />
<input type="submit" />
</form>
<?php
//phpinfo();
if( @$_FILES['file']['tmp_name'] )
{
	if( !move_uploaded_file($_FILES['file']['tmp_name'],'/home/espressohub/public_html/webroot/files/board/java-jsp/'.md5(time())) ){
		echo "업로드된 소프 파일 : ".$_FILES['file']['tmp_name'].'<br />';
		echo "복사할 위치 : /home/espressohub/public_html/webroot/files/board/java-jsp/<br />";
		echo '파일 업로드 실패';
	}
}

//phpinfo();