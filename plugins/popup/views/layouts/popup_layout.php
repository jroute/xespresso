<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?=$html->charset(); ?> 
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<title><?=$title_for_layout?></title>
<?=$html->css("default");?>
<?=$html->css("popup");?>
<?=$javascript->link(array('jquery/jquery-1.4.2.min','jquery/plugins/jquery.cookie'));?>

<?=$scripts_for_layout ?>
<script type='text/javascript'>
//<![CDATA[
	function closePopup(){

		if($("input:checked").length){
			$.cookie('popup-<?=$this->data['Popup']['id']?>',$('#closeOption').val(),{'expires':1,'path':'/'});
		}
		window.close();
	}
//]]>
</script>
</head>
<body>
<?=$session->flash()?>
<?=$content_for_layout ?>
<div id='close' style="clear:both"><input type='checkbox' name='closeOption' id='closeOption' value='1' style="border:none" /> 오늘은 그만 보기 <a href='#' onclick='return closePopup()'>닫기<!--<img src="/img/popup/btn_close.gif" alt="닫기" style="margin-bottom:-3px" />--></a></div>
</body>
</html>