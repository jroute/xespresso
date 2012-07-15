<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title_for_layout?$title_for_layout:''; ?></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="Plani" />
<meta name="copyright" content="Copyright(c) KIGAM. all rights reserved." />
<meta name="reply-to" content="" />
<link type="image/x-icon"  rel="shortcut icon" href="" />
<?php echo $html->css(array('default'));?>
<link rel="stylesheet" type="text/css" href="" media="screen" />
<link rel="stylesheet" type="text/css" href="" media="print" />
<?php echo $javascript->link(array('jquery/jquery-1.6.2.min','flashobject','menu'));?>
<?php echo $scripts_for_layout;?>
</head>

<body >
<?php echo $this->Session->flash(); ?>            	
            	
<?php echo $content_for_layout; ?>
         
</body>
</html>
<?php echo $this->element('sql_dump'); ?>