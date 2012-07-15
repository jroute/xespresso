
function signup(){

	try{
		if( _check_name == false ){
			window.alert("사용자명 체크가 이루어지지 않았습니다.");
			$('#name').focus();
			return false;
		}
		
		if( _check_userid == false ){
			window.alert("아이디 체크가 이루어지지 않았습니다.");
			return false;
		}

		
		//비밀버호 체크
		var pwd = $.trim($('#passwd').val());
		var pwd_regexp = /^([a-zA-Z0-9@#$%&*\^\!\(\)]{6,12})$/;
		if( !pwd_regexp.test(pwd) ){
			window.alert('비밀번호는 6~12자 이상 영문,숫자,특수문자 조합으로 입력하셔야 합니다.');
			$('#passwd').focus();			
			return false;
		}
		if( $('#passwd').val() != $('#passwd2').val() ){
			window.alert('비밀번호가 일치하지 않습니다.');
			$('#passwd2').focus();
			return false;
		}
		
		
		if( _check_email == false ){
			window.alert("E-mail 체크가 이루어지지 않았습니다.");
			return false;
		}		
		
		if( $('#passcode').val().length < 2 ){
			window.alert("보안 문자를 입력하십시오.");
			$('#passcode').focus();
			return false;	
		}		
		
		return true;
	}catch(e){
		window.alert(e.message);
	}		
	return false;
}


$(function(){
	
	
	$('#select-emhost').bind('change',function(){
		if( $(this).val() == 'none' || $(this).val() == '' ){
			$('#email-host').val('');		
		}else{
			$('#email-host').val($(this).val());
		}
	});
	
	//별명 체크
	_check_name = false;
	$('#name').blur(function(){
		$.ajax({
			url:'/users/check/name',
			cache:false,
			type:'POST',
			dataType:'json',
			data:{data:$('#name').val()},
			success:function(json){
			  if( json ){
				  if( json.result == 'true' ){
						_check_name  = true;
						$('#message-name').html('사용 가능합니다.').removeAttr('class').addClass('alert-message block-message info');
				  }else if( json.result == 'duplicate' ){
						$('#message-name').html('이미 사용중 입니다. 다시 입력 사용하십시오').removeAttr('class').addClass('alert-message block-message error');
				  }else{
						$('#message-name').html('입력 내용을 확인 하십시오').removeAttr('class').addClass('alert-message block-message error');
				  }
			  }			
			}
		})
	})
	
	
	//아이디 체크
	_check_userid = false;
	$('#userid').blur(function(){
		$.ajax({
			url:'/users/check/userid',
			cache:false,
			type:'POST',
			dataType:'json',
			data:{data:$('#userid').val()},
			success:function(json){
			  if( json ){
				  if( json.result == 'true' ){
						_check_userid  = true;
						$('#message-userid').html('사용 가능한 아이디입니다.').removeAttr('class').addClass('alert-message block-message info');
				  }else if( json.result == 'duplicate' ){
						$('#message-userid').html('이미 사용중인 아이디입니다. 다른 아이디을 사용하십시오').removeAttr('class').addClass('alert-message block-message error');
				  }else{
						$('#message-userid').html('입력 내용을 확인 하십시오').removeAttr('class').addClass('alert-message block-message error');
				  }
			  }			
			}
		})
	})	
	
	//이메일 체크
	_check_email = false;
	$('#email-host').blur(function(){
		_validate_email();
	});
	$('#select-emhost').blur(function(){
		_validate_email();
	});	

});

function _validate_email(){
		$.ajax({
			url:'/users/check/email',
			cache:false,
			type:'POST',
			dataType:'json',
			data:{data:$('#email-id').val()+'@'+$('#email-host').val()},
			success:function(json){
			  if( json ){
				  if( json.result == 'true' ){
						_check_email  = true;
						$('#message-email').html('사용 가능한 E-mail입니다.').removeAttr('class').addClass('alert-message block-message info');
				  }else if( json.result == 'duplicate' ){
						$('#message-email').html('이미 사용중인 E-mail입니다. 다른 E-mail을 사용하십시오').removeAttr('class').addClass('alert-message block-message error');
				  }else{
						$('#message-email').html('E-mail 정보가 올바르지 않습니다.').removeAttr('class').addClass('alert-message block-message error');
				  }
			  }			
			}
		});
}
