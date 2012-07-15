<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>제스프레소(xespresso) 개발자 커뮤니티</title>
<link href="/css/default.css" rel="stylesheet" type="text/css" />
<meta name="keywords" content="제스프레소,xespresso,Java,JSP,PHP,JavaScript,HTML5,CSS3,iOS,iPhone,iPad,Android,jQuery,CakePHP,Codeigniter,Database,MySQL,MS-SQL,Oracle,PostgreSQL,SQLite,Server,Linux,Ubuntu,CentOS" />
<meta name="description" content="제스프레소(xespresso) 개발자 커뮤니티" />
<meta name="author" content="김정수(ngelux@gmail.com)" />
<meta name="copyright" content="Copyright(c) xespresso. all rights reserved." />
<meta name="reply-to" content="xespressonet@gmail.com" />
<link type="image/x-icon"  rel="shortcut icon" href="/images/xespresso.ico" />
<?php echo $javascript->link(array(
	'jquery/jquery-1.6.4.min',
	'jquery/plugins/jquery.cookie',
	'flashobject',
	'menu'
));?>


<script type="text/javascript">
//<![CDATA[
/* TAB */
$(function(){


		<?php foreach($popups as $popup):
			$id = $popup['Popup']['id'];
			$dimensions = $popup['Popup']['dimensions'];
			$scrollbars = $popup['Popup']['scrollbars'];
			list($x,$y,$width,$height) = explode(",",$dimensions);
		?>
			//alert($.cookie('popup-<?=$id?>'));
		if( $.cookie('popup-<?=$id?>') == null ){ 
			var popup<?=$id?> = window.open('/popup/view/<?=$id?>','popup_<?=$id?>','scrollbars=<?=$scrollbars?>,width=<?=trim($width)?>,height=<?=trim($height)?>,top=<?=trim($x)?>,left=<?=trim($y)?>'); 
			popup<?=$id?>.focus(); 
	
		}
		<?php endforeach;?>
});
//]]>
</script>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="" />
<meta name="copyright" content="" />
<meta name="reply-to" content="" />
</head>
<body>
<?php echo $session->flash();?>

<?php echo $this->element('header');?>


<div id="container">


	<div id="content-left">
	
		<div class="latest">
			<h3><?=$html->link('Java/JSP','/java');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>array('java','java-jsp','java-qna','java-tiptech','java-lecture'),
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>	
		</div>		
		
		<div class="latest">
			<h3><?=$html->link('PHP','/php');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>array('php','php-qna','php-qna','php-tiptech','php-frameworks'),
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>	
		</div>				


		<div class="latest">
			<h3><?=$html->link('iOS/Android','/ios-android');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>array('app-ios','app-android','app-qna','app-tiptech'),
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>	
		</div>				

		<div class="latest">
			<h3><?=$html->link('Database','/database');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>array('db','db-qna'),
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>	
		</div>

		<div class="latest">
			<h3><?=$html->link('WAS','/was');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>array('was-qna','was'),
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>	
		</div>	
				
		<div class="latest">
			<h3><?=$html->link('Server','/server');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>array('sv-linux','sv-windows','sv-lecture'),
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>	
		</div>						

		<div class="latest">
			<h3><?=$html->link('JavaScript','/javascript');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>array('js-javascript','js-lecture','js-qna','js-tiptech'),
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>
		</div>	
					
		<div class="latest">
			<h3><?=$html->link('HTML/CSS','/html-css');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>array('web-htmlcss','web-qna','web-tiptech'),
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>	
		</div>
		
		<div class="latest">
			<h3><?=$html->link('Community','/community');?></h3>
			<ul>
<?=$this->element('latest',array('plugin' => 'board',
                                'bid'=>array('notice','pds','devtools','news','events','suda','gallery','inquire'),
                                'category' =>null,
                                'limit'=>5,
																'slen'=>30,
																'clen'=>40
                                ));
?>
			</ul>	
		</div>		
		

		
	
		
			
	</div>
	
	<div id="content-right">
		<?=$this->element('content-right');?>
		<div class="latest">
			<h3>Sponsor by</h3>
			<ul style="list-style:none;margin:0;">
			<li style="border:1px solid #f5f5f5"><a href="http://plani.co.kr" target="_blank"><img src="/images/banners/plani.png" /></a></li>
			</ul>
		</div>
	</div>


		<div class="google-adsense" style="clear:both;margin:5px 0 15px 0;text-align:cener;height:90px;">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-7837870281700467";
/* xespresso-bottom */
google_ad_slot = "5605626054";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
		</div>



</div>






<?=$this->element('footer');?>






<script type="text/javascript" src="/js/counter.js"></script>
</body>
</html>
<?php echo $this->element('sql_dump'); ?>