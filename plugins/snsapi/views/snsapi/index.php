
<meta charset="UTF-8" />
<script type="text/javascript" src="/js/jquery/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
$(function(){
	$('#me2day').click(function(){
		if( $(this).is(':checked') == true ){
			window.open('/snsapi/me2day','me2win','width=800,height=500');
		}
	});
	$('#twitter').click(function(){
		if( $(this).is(':checked') == true ){	
			window.open('/snsapi/twitter','twt2win','width=800,height=500');	
		}
	});	
	$('#facebook').click(function(){
		if( $(this).is(':checked') == true ){	
			window.open('/snsapi/facebook','fbwin','width=800,height=500,scrollbars=yes');	
		}
	});		
})
</script>
<form action="/sns/write" method="post">
<input type="checkbox" name="me2day" id="me2day" value="1" /><img src="/img/me2day_logo.gif" />
<input type="checkbox" name="twitter" id="twitter" value="1" /><img src="/img/twitter_logo.gif" />
<input type="checkbox" name="facebook" id="facebook" value="1" /><img src="/img/facebook_logo.gif" />
<textarea rows="5" cols="50" name="data" ></textarea>
<input type="submit" value="등록" />
</form>