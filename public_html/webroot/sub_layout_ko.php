<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title_for_layout?$title_for_layout:''; ?> #xespresso </title>
<meta name="title" content="<?php echo $title_for_layout?$title_for_layout:''; ?>" />
<meta name="keywords" content="제스프레소,xespresso,Java,JSP,PHP,JavaScript,HTML5,CSS3,iOS,iPhone,iPad,Android,jQuery,CakePHP,Codeigniter,Database,MySQL,MS-SQL,Oracle,PostgreSQL,SQLite,Server,Linux,Ubuntu,CentOS" />
<meta name="description" content="제스프레소(xespresso) 개발자 커뮤니티" />
<meta name="author" content="김정수(ngelux@gmail.com)" />
<meta name="copyright" content="Copyright(c) xespresso. all rights reserved." />
<meta name="reply-to" content="xespressonet@gmail.com" />
<link type="image/x-icon"  rel="shortcut icon" href="/images/xespresso.ico" />
<?php echo $html->css(array('default'));?>
<link rel="stylesheet" type="text/css" href="" media="screen" />
<link rel="stylesheet" type="text/css" href="" media="print" />
<?=$html->css("/js/jquery/ui/default/jquery-ui-1.8.14.custom")?>
<?php echo $javascript->link(array(
			'jquery/jquery-1.6.4.min',
			'jquery/ui/default/jquery-ui-1.8.14.custom.min',			
			'jquery/plugins/jquery.cookie',
			'flashobject',
			'menu'));?>
<?php echo $scripts_for_layout;?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25621504-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>

<body >
<?php echo $this->Session->flash(); ?>
            	
<?=$this->element('header');?>

<div id="container">

	<?php echo $content_for_layout; ?>
	
</div>      	

<div id="container">


</div>

<?=$this->element('footer');?>
            
<script type="text/javascript" src="/js/counter.js"></script>
</body>
</html>
<?php echo $this->element('sql_dump'); ?>