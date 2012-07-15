<?php

if( file_exists(APP.'webroot'.DS.'main.php') ){
	include(APP.'webroot'.DS.'main.php');
}else{
?>
/webroot/main.php 파일을 생성하십시오
<?php
}
?>