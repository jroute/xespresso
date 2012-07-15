
<div id="footer">


<div id="recent-latest">

		<div class="latest">
			<h3>최근게시물</h3>
			<ul class="ul-bullet-blue">
<?=$this->element('latest',array('plugin' => 'board',
																'bid'=>null,
                                'limit'=>5,
																'slen'=>50,
																'bname'=>TRUE
                                ));
?>
			</ul>		
		</div>	
		
		<div class="latest">
			<h3>최근댓글</h3>
			<ul class="ul-bullet-orange">
<?=$this->element('latest',array('plugin' => 'comment',
                                'limit'=>10,
																'length'=>44
                                ));
?>
			</ul>		
		</div>	
		
		<div class="latest">
	<a href="https://www.facebook.com/pages/xespresso/269153393108499" target="_blank"><img src="/img/iconset-sns/16x16-facebook.png" alt="Facebook xEspresso" /></a>
	<a href="http://twitter.com/#!/xespressonet" target="_blank"><img src="/img/iconset-sns/16x16-twitter.png" alt="Twitter xEspresso" /></a>		
		</div>
</div>
	<div id="copyright">
	Copyright © 2011 xEspresso. All rights reserved. 
	

	</div>
</div>