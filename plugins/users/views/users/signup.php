

<?php echo $javascript->link(array(
				'/users/js/signup',
				'zipfinder'
				),array('inline'=>false)
			);
?>




<?=$skin_header?>

<!-- 컨텐츠 영역-->


<?=$form->create("User",array('url'=>array('controller'=>$this->params['controller'],'action'=>$this->action),'onsubmit'=>'return signup()'))?>
<?=$form->hidden("uno")?>


<div class="clearfix">
	<label for="name">사용자명</label>
	<div class="input"><?=$form->text("name",array('id'=>'name','size'=>20,'maxlength'=>12))?> <span class="f11">사이트에서 이용가능한 고유한 사용자 명(닉네임)을 입력하십시오</span>
	<div id="message-name"></div>
	<?=$form->error('name','사용자명을 입력하십시오');?></div>
</div>

<div class="clearfix">
	<label for="userid">아이디</label>
	<div class="input"><?=$form->text("userid",array('id'=>'userid','size'=>15,'maxlength'=>12))?> 6 ~ 12자의 영문소문자/숫자 조합, 첫글자는 숫자불가, 한글아이디 불가 
	<div id="message-userid"></div>
	<?=$form->error('userid','아이디를 입력하십시오');?></div>
</div>

<div class="clearfix">
	<label for="passwd">비밀번호</label>
	<div class="input"><?=$form->password("passwd",array('id'=>'passwd','size'=>15,'maxlength'=>12))?>
                                <span class="f11">6자 이상 12자까지의 영문,숫자,특수문자로 작성하여 주십시오 </span> <?=$form->error('passwd','비밀번호를 입력하십시오');?></div>
</div>

<div class="clearfix">
	<label for="passwd2">비밀번호확인</label>
	<div class="input"><?=$form->password("passwd2",array('id'=>'passwd2','size'=>15))?> 비밀번호를 다시 한번 입력하십시오. <?=$form->error('passwd2','비밀번호를 입력하십시오');?></div>
</div>

<div class="clearfix">
	<label for="email">이메일</label>
	<div class="input">
                            <?=$form->text("email_id",array('id'=>'email-id','size'=>12))?> @ 
             					     	<?=$form->text('email_host',array('id'=>'email-host','size'=>15));?>                            
                            <?=$form->select('em_host',array(
                            'gmail.com'=>'gmail.com',
					                  'nate.com'=>'nate.com',      
					                  'naver.com'=>'naver.com',
					                  'yahoo.co.kr'=>'yahoo.co.kr',					                  					                    					                  
        	  					      'hotmail.com'=>'hotmail.com',					                                      
					                  'empal.com'=>'empal.com',
					                  'freechal.com'=>'freechal.com',
					                  'korea.com'=>'korea.com',
          					        'lycos.co.kr'=>'lycos.co.kr',
					                  'paran.com'=>'paran.com',
             					     	'none'=>'직접입력'),null,array('id'=>'select-emhost','empty'=>'::선택::'));?>
	<div id="message-email"></div>
	</div>
</div>


<div class="clearfix">
	<label for="passcode">보안문자</label>
	<div class="input"><img id="captcha" src="/captcha/image/200/60" alt="CAPTCHA Image" style="float:left;"/>
                            <p style="float:left;margin:0 0 0 5px;">
                           	좌측 이미지안의 글자를 입력하세요<br />
                            <?=$form->text('captcha',array('id'=>'passcode','size'=>20,'maxlength'=>6));?><br />
                            <a href="javascript:void(0)" onclick="document.getElementById('captcha').src = '/captcha/image/200/60?' + Math.random(); return false" ><img style="margin-top:3px;" src="/users/img/btn_captcha_reflash.gif" alt="아이디중복확인" /></a>
                            </p>
                            <div style="clear:both"><?=$form->error('captcha','보안문자 입력정보가 일치하지 않습니다.');?> </div>
                            </div>
</div> 

                    
                    <div class="actions">
                    <?=$form->button('회원가입',array('type'=>'submit','class'=>'btn success'));?>
                    <?=$html->link('회원가입취소','/',array('escape'=>false,'class'=>'btn'))?>
                    </div>

<?=$form->end()?>



<?=$skin_footer?>


<script type='text/javascript'>
//<![CDATA[

//]]>
</script>
