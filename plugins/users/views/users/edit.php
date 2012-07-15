

<?php echo $html->css(array('/js/jquery/plugins/uploadify/uploadify','/users/css/default'),null,array('inline'=>false));?>
<?php echo $javascript->link(array(
				'/users/js/signup',
				'zipfinder',
				'jquery/plugins/uploadify/swfobject.js',
				'jquery/plugins/uploadify/jquery.uploadify.v2.1.4.min.js',				
				),array('inline'=>false)
			);
?>

<script type="text/javascript">
    var t = new Date();
    $(document).ready(function() {
      $('#profile_upload').uploadify({
        'uploader'  : '/js/jquery/plugins/uploadify/uploadify.swf',
        'script'    : '/users/uploadify/'+t.getTime(),
        'cancelImg' : '/js/jquery/plugins/uploadify/cancel.png',
        'auto'      : true,
//        'height'		: 45,
        'fileExt'     : '*.jpg;*.gif;*.png',
			  'fileDesc'    : '이미지 파일',
			  'scriptData': {'xdata':'<?=base64_encode($session->Read('User.userid')); ?>'},
        'onComplete'  : function(event, ID, fileObj, response, data) {
        	$('#profile-image').attr('src',response+'?'+t.getTime());
		    },
				'onError'     : function (event,ID,fileObj,errorObj) {
   		   alert(errorObj.type + ' Error: ' + errorObj.info);
		    }		    
      });
    });
</script>

<div id="log"></div>
    

<?=$skin_header?>

<div class="alert-message error"><?=$session->flash('user')?></div>

<?=$form->create("User",array('url'=>array('controller'=>$this->params['controller'],"action"=>$this->action),'onsubmit'=>'return edit()'))?>
<?=$form->hidden("uno")?>

<div class="clearfix">
	<label for="name">사진(아이콘)</label>
	<div class="input"><img src="<?=$profile?>" id="profile-image" width="128" height="128" alt="profile" />
	<input type="file" id="profile_upload" name="profile" size="10" />
		<div id="message-name">128x128 사이즈의 jpg,png,gif 이미지만 업로드 하실 수 있습니다.</div>
	</div>
</div>


<div class="clearfix">
	<label for="name">사용자명</label>
	<div class="input"><?=$form->text("name",array('size'=>20,'maxlength'=>12,'readonly'=>true))?>
	<div id="message-name"></div>
	<?=$form->error('name','사용자명을 입력하십시오');?></div>
</div>

<div class="clearfix">
	<label for="name">자기소개</label>
	<div class="input"><?=$form->textarea("introduce",array('id'=>'introduce','rows'=>3,'cols'=>30,'maxlength'=>200))?>
	<p class="help-block">100자 이내로 소개글을 작성해주세요</p>
	</div>
</div>

<div class="clearfix">
	<label for="userid">아이디</label>
	<div class="input"><?=$form->text("userid",array('size'=>15,'maxlength'=>12,'readonly'=>true))?>
	<?=$form->error('userid','아이디를 입력하십시오');?></div>
</div>

<div class="clearfix">
	<label for="passwd">비밀번호</label>
	<div class="input"><?=$form->password("passwd",array('id'=>'passwd','size'=>15,'maxlength'=>12))?>
                                <span class="error" style="color:red">회원정보 수정시 비밀번호를 입력하십시오</span> <?=$form->error('passwd','비밀번호를 입력하십시오');?></div>
</div>

<div class="clearfix">
	<label for="passwd2">비밀번호변경</label>
	<div class="input"><?=$form->password("passwd2",array('id'=>'passwd2','size'=>15))?> <span class="f11">6자 이상 12자의 영문,숫자,특수문자로 작성하여 주십시오 </span> <?=$form->error('passwd2','비밀번호를 입력하십시오');?></div>
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
	<label for="passwd2">웹사이트(블로그)</label>
	<div class="input"><?=$form->text("website",array('id'=>'website','size'=>15))?></div>
</div>

<div class="clearfix">
	<label for="passwd2">Facebook</label>
	<div class="input"><span class="sns">http://facebook.com/</span><?=$form->text("sns_facebook",array('id'=>'sns-facebook','size'=>15))?></div>
</div>

<div class="clearfix">
	<label for="passwd2">Twitter</label>
	<div class="input"><span class="sns">http://twitter.com/</span><?=$form->text("sns_twitter",array('id'=>'sns-twitter','size'=>15))?></div>
</div>

<div class="clearfix">
	<label for="passwd2">Me2day</label>
	<div class="input"><span class="sns">http://me2day.net/</span><?=$form->text("sns_me2day",array('id'=>'sns-me2day','size'=>15))?></div>
</div>


                    <div class="actions">
                    <?=$form->button('회원정보수정',array('type'=>'submit','class'=>'btn success'));?>
                    <?=$html->link('취소','/',array('escape'=>false,'class'=>'btn'))?>
                    </div>

<?=$form->end()?>



<script type='text/javascript'>
//<![CDATA[
function edit(){
	try{
		if( $.trim($('#passwd').val()).length < 6 )
		{
			window.alert('비밀번호를 입력하십시오');
			$('#passwd').focus();
			return false;
		}
		
		var pwd = $.trim($('#passwd2').val());
		var pwd_regexp = /^([a-zA-Z0-9@#$%&*\^\!\(\)]{6,12})$/;
		if( pwd != '' && !pwd_regexp.test(pwd) ){
			window.alert('비밀번호는 6~12자 이상 영문,숫자,특수문자 조합으로 입력하셔야 합니다.');
			$('#passwd2').focus();			
			return false;
		}		
		
		return true;
	}catch(e){
		window.alert(e.message);
	}
	return false;
}
//]]>
</script>


<?=$skin_footer?>