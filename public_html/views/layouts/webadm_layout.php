<?php
$admin = $session->read('Admin');

$active = array();
switch($this->params['controller']){
	case "dashboard":		
	case "popup":
	case "poll":	
	case "logs":		
									$active['dash']		= 'active-dash'; break;
	case "cms":				$active['cms']			= 'active'; break;
	case "persnal":
	case "users":					$active['users']				= 'active'; break;	
	case "contents":			$active['contents']		= 'active'; break;
	case "menus":					$active['menus']				= 'active'; break;
	case "board_setup":
	case "board":			$active['board']		= 'active'; break;
	
}

?>
<?=$html->docType('xhtml-trans');?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?=$html->charset(); ?> 
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<title><?=$title_for_layout?></title>
<?=$html->css(array('webadm','gBtn/gBtn'))?>
<?=$html->css("/js/jquery/ui/default/jquery-ui-1.8.14.custom")?>
<?=$html->css("/js/jquery/plugins/jGrowl/jquery.jgrowl")?>
<?=$html->css("/js/jquery/plugins/contextMenu/jquery.contextMenu")?>
<?=$javascript->link(array(
	'jquery/jquery-1.6.3.min',
	'jquery/plugins/jquery.cookie',	
	'jquery/ui/default/jquery-ui-1.8.14.custom.min',
	'jquery/plugins/jGrowl/jquery.jgrowl_compressed',
	'jquery/plugins/jquery.qtip-1.0.0.min',
	'webadm/webadm'
));?>


<script type='text/javascript'>
//<![CDATA[
$(function(){

	$('.message').slideDown('fast');
	setTimeout(function(){
		$('.message').slideUp('fast');
	},2000);

});
//]]>
</script>
<?=$scripts_for_layout ?>
</head>
<body>
<?=$session->flash()?>
<!-- s header -->
<div id="header">
	<div id="top-navi">
		<div id="inner-navi">
			<a href="/webadm" id="logo" style="font-size:16pt;color:#fff;font-weight:bold;margin-right:20px;">xEspresso</a>
		
			<ul class="menu">
				<li class='dashboard <?=@$active['dash']?>'><?=$html->link('홈','/webadm/dashboard')?></li>
				<?php if( $session->Read('Admin.userid') == 'plani' ):?>
				<li class='<?=@$active['menus']?>'><?=$html->link('메뉴 관리',array('plugin'=>'menus','controller'=>'menus','action'=>'index'));?></li>	
				<?php endif;?>
				<li class='<?=@$active['users']?>'><?=$html->link('회원 관리',array('plugin'=>'users','controller'=>'users','action'=>'index'));?></li>				
				<li class='<?=@$active['contents']?>'><?=$html->link('컨텐츠 관리',array('plugin'=>'contents','controller'=>'contents','action'=>'index'));?></li>
				<li class='<?=@$active['board']?>'><?=$html->link('게시판 관리',array('plugin'=>'board','controller'=>'board','action'=>'lst','notice'));?></li>									
			</ul>
					
			<div id="search">
				
				<?=$form->create('Search',array('url'=>'/webadm/search','type'=>'get','id'=>'nav-search'));?>
				<?=$form->submit(null,array('div'=>false,'id'=>'nav-search-submit'));?>			
				<?=$form->text('q',array('id'=>'nav-search-text'));?>
				<?=$form->end();?>
			</div>
			
			<ul id="account" class="menu">
			<li ><a href="#"><?=$admin['name']?></b>님 접속중</a>
				<div class="dropdown">
				<ul class="menu-dropdown">
				<li><?=$html->link('설정',array('plugin'=>'setup','controller'=>'setup','action'=>'index'),array('escape'=>false));?></li>
				<li><?=$html->link('개인정보수정',array('plugin'=>'users','controller'=>'users','action'=>'edit',$this->Session->Read('Admin.userid')),array('escape'=>false));?></li>				
				<li><?=$html->link('로그아웃',"/webadm/users/logout",array('escape'=>false))?></li>
				</ul>
				</div>
			</li>
			</ul>
		</div>
					
	</div>
	
		
</div>
<!-- e header -->
		

<!-- s wrap -->
<div id="wrap">

	<div id="container">


<!-- begin sub menu -->
			<div id="submenu">

				<ul id="ul-submenu">
					<?php if( eregi("^(board)",$this->params['controller']) ):?>
						<?php foreach($boards as $b):?>
								<li><?php echo $html->link($b['BoardSetup']['bname'],array('plugin'=>'board','controller'=>'board','action'=>'lst',$b['BoardSetup']['bid']))?></li>
						<?php endforeach?>
					<?php endif?>

					<?php if( eregi("^(menus)",$this->params['controller']) ):?>
						<li><?php echo $html->link('메뉴관리',array('action'=>'index'))?></li>
						<li><?php echo $html->link('사이트맵',array('action'=>'sitemap'))?></li>												
						<li><?php echo $html->link('상/하 컨텐츠 관리',array('action'=>'html'))?></li>						
					<?php endif?>

					<?php if( eregi("^(users)",$this->params['controller']) ):?>
						<li><?php echo $html->link('회원목록',array('action'=>'index'))?></li>
						<li><?php echo $html->link('회원등록',array('action'=>'add'))?></li>
						<li><?php echo $html->link('회원접근이력',array('action'=>'history'))?></li>						
					<?php endif?>
				
							
					<?php if( eregi("dashboard|popupzone|sms|log|popup|contents|poll|mailing",$this->params['controller']) ):?>
						<li><?=$html->link('팝업관리',array('plugin'=>'popup','controller'=>'popup','action'=>'index'))?></li>
						<li><?=$html->link('팝업존','/webadm/popupzone/index')?></li>						
						<li><?=$html->link('설문조사','/webadm/poll/index')?></li>
						<!--						
						<li><?=$html->link('메일발송','/webadm/mailing/index')?></li>
						<li><?=$html->link('SMS발송','/webadm/sms/index')?></li>
						-->

						<li><?=$html->link('접속로그','/webadm/logs/index')?>
							<ul>
							<li><?=$html->link('관리자 접속 로그','/webadm/logs/admins')?></li>
							<li><?=$html->link('사용자 접속 로그','/webadm/logs/users')?></li>
							</ul>
						</li>
						<li><?=$html->link('접속 통계','/webadm/logs/counter')?></li>												
					<?php endif?>
															
					</ul>

			</div>
			<!-- e sub menu -->	
			
	<div id="content-wrap">
				<?=$content_for_layout ?>		
	</div>			
</div>
<!-- e wrap -->
	
</div>

<div id="footer">

Powered by <a href="http://xespresso.net" target="_blank" title="http://xespresso.net">http://xespresso.net</a></div>

</body>
</html>

<?php echo $this->element('sql_dump'); ?>