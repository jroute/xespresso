<style type="text/css">
.user-profile {
	width:250px;
	height:100px;
}
.user-profile img {
	float:left;
	margin-right:10px;
}
.user-profile div {
	text-align:left;
	margin:0 0 3px 0;
}
.user-profile div.website a {
	color:#0000FF;
}
.user-profile div.info {
	float:left;
}

.user-profile div.intro {
	clear:both;
	color:gray;
}
</style>

<div class="user-profile">
	<img src="<?=$data['User']['profile']?>" width="64" height="64" />
	<div class="info">
		<div class="name"><?=$data['User']['name']?></div>
		<div class="website"><a href="<?=$data['User']['website']?>" target="_blank"><?=$data['User']['website']?></a></div>
		<div class="sns">
			<a href="http://facebook.com/<?=$data['User']['sns_facebook']?>"><img src="/img/iconset-sns/16x16-facebook.png" widht="16" height="16" /></a>
			<a href="http://twitter.com/<?=$data['User']['sns_twitter']?>"><img src="/img/iconset-sns/16x16-twitter.png" widht="16" height="16" /></a>
			<a href="http://me2day.net/<?=$data['User']['sns_me2day']?>"><img src="/img/iconset-sns/16x16-me2day.png" widht="16" height="16" /></a>		
		</div>		
	</div>
	<div class="intro"><?=$data['User']['introduce']?></div>	
</div>