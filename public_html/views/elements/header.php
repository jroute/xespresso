

<div id="header">

	<div id="top">
		<div id="logo">
			<a href="/">
			<img src="/images/xespresso32.png" />
			x<span>e</span>spresso</a>
		</div>
		
		<div id="spot-menu">
			<?php if( $session->Read('User.userid')):?>
			  <?=$html->link('Logout','/users/logout');?> | <?=$html->link('Mypage','/users/edit');?>			
			<?php else:?>
			  <?=$html->link('Login','/users/login/redirect:'.base64_encode(env('REQUEST_URI')));?> | <?=$html->link('Sign Up','/users/agree');?>
			<?php endif;?>
		</div>
	</div>

	<div id="menu">
		<ul id="ul-menu">
			<li><?=$html->link('HTML/CSS','/html-css')?>
				<ul>
					<li><?=$html->link('Q&A','/board/lst/web-qna')?></li>	
					<li><?=$html->link('HTML/CSS','/board/lst/web-htmlcss')?></li>					
					<li><?=$html->link('HTML5','/board/lst/web-htmlcss/category:16')?></li>
					<li><?=$html->link('CSS3','/board/lst/web-htmlcss/category:17')?></li>
					<li><?=$html->link('Tip&Tech','/board/lst/web-tiptech')?></li>
				</ul>
			</li>
			
			
			<li><?=$html->link('JavaScript','/javascript')?>
				<ul>
					<li><?=$html->link('Q&A','/board/lst/js-qna')?></li>
					<li><?=$html->link('JavaScript','/board/lst/js-javascript')?></li>
					<li><?=$html->link('jQuery','/board/lst/js-javascript/category:3')?></li>					
					<li><?=$html->link('Tip&Tech','/board/lst/js-tiptech')?></li>				
					<li><?=$html->link('Lecture','/board/lst/js-lecture')?></li>	
				</ul>
			</li>
			
			
			<li><?=$html->link('JAVA/JSP','/java')?>
				<ul>
					<li><?=$html->link('Q&A','/board/lst/java-qna')?></li>
					<li><?=$html->link('JAVA/JSP','/board/lst/java-jsp')?></li>
					<li><?=$html->link('Tip&Tech','/board/lst/java-tiptech')?></li>
					<li><?=$html->link('Lecture','/board/lst/java-lecture')?></li>						
				</ul>
			</li>
			
			
			<li><?=$html->link('PHP','/php')?>
				<ul>
					<li><?=$html->link('Q&A','/board/lst/php-qna')?></li>		
					<li><?=$html->link('PHP','/board/lst/php')?></li>
					<li><?=$html->link('PHP Frameworks','/board/lst/php-frameworks')?></li>					
					<li><?=$html->link('CakePHP','/board/lst/php-frameworks/category:8')?></li>
					<li><?=$html->link('Codeigniter','/board/lst/php-frameworks/category:9')?></li>
					<li><?=$html->link('Yii','/board/lst/php-frameworks/category:32')?></li>
					<li><?=$html->link('Zend','/board/lst/php-frameworks/category:33')?></li>										
					<li><?=$html->link('Tip&Tech','/board/lst/php-tiptech')?></li>		
					<li><?=$html->link('Lecture','/board/lst/php-lecture')?></li>				
				</ul>
			</li>
			
			
			<li><?=$html->link('iOS/Android','/ios-android')?>
				<ul>
					<li><?=$html->link('Q&A','/board/lst/app-qna')?></li>			
					<li><?=$html->link('iOS','/board/lst/app-ios')?></li>
					<li><?=$html->link('Android','/board/lst/app-android')?></li>
					<li><?=$html->link('Tip&Tech','/board/lst/app-tiptech')?></li>		
					<li><?=$html->link('Lecture','/board/lst/app-lecture')?></li>						
				</ul>
			</li>
			
			
			<li><?=$html->link('Database','/database')?>
				<ul>
					<li><?=$html->link('Q&A','/board/lst/db-qna')?></li>				
					<li><?=$html->link('Database','/board/lst/db')?></li>					
					<li><?=$html->link('MySQL','/board/lst/db/category:22')?></li>
					<li><?=$html->link('MS-SQL','/board/lst/db/category:23')?></li>					
					<li><?=$html->link('Oracle','/board/lst/db/category:24')?></li>
					<li><?=$html->link('PostgreSQL','/board/lst/db/category:25')?></li>
					<li><?=$html->link('SQLite','/board/lst/db/category:26')?></li>
					<li><?=$html->link('DB2','/board/lst/db/category:42')?></li>
				</ul>
			</li>
			
			<li><?=$html->link('WAS','/was')?>
				<ul>
					<li><?=$html->link('Q&A','/board/lst/was-qna')?></li>				
					<li><?=$html->link('WAS','/board/lst/was')?></li>					
					<li><?=$html->link('Apache','/board/lst/was/category:34')?></li>
					<li><?=$html->link('Tomcat','/board/lst/was/category:35')?></li>					
					<li><?=$html->link('Jeus','/board/lst/was/category:36')?></li>
					<li><?=$html->link('Websphere','/board/lst/was/category:37')?></li>
				</ul>
			</li>			
			
			
			<li><?=$html->link('Server','/server')?>
				<ul>
					<li><?=$html->link('Q&A','/board/lst/sv-qna')?></li>				
					<li><?=$html->link('Linux','/board/lst/sv-linux')?></li>
					<li><?=$html->link('Ubuntu','/board/lst/sv-linux/category:11')?></li>
					<li><?=$html->link('CentOS','/board/lst/sv-linux/category:12')?></li>
					<li><?=$html->link('Windows Server','/board/lst/sv-windows')?></li>
					<li><?=$html->link('Lecture','/board/lst/sv-lecture')?></li>					
				</ul>
			</li>
			
			
			<li><?=$html->link('CoffeeBreak','/community')?>
				<ul>
					<li><?=$html->link('공지사항','/board/lst/notice')?></li>
					<li><?=$html->link('개발자료','/board/lst/pds')?></li>
					<li><?=$html->link('개발툴','/board/lst/devtools')?></li>					
					<li><?=$html->link('최근소식','/board/lst/news')?></li>
					<li><?=$html->link('행사/세미나','/board/lst/events')?></li>							
					<li><?=$html->link('수다방','/board/lst/suda')?></li>
					<li><?=$html->link('포토존','/board/lst/gallery')?></li>		
					<li><?=$html->link('문의하기','/board/lst/inquire')?></li>							
					
				</ul>
			
			</li>
			<li class="last">
				<form action="/search/index">
				<input type="text" name="q" value="<?=@$q?>" size="10" />
				<input type="submit" class="submit" />
				</form>
			
			</li>
		</ul>
	</div>	
</div>	