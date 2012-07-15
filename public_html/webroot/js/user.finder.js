//

var _auth_id = null;
$(function(){

	var checkid_src = "<form id='form-checkid' onsubmit='return checkId()'><div style='text-align:center;margin:20px;'><input type='text' name='chkid' id='chkid' style='border:1px solid #CCCCCC'  /> <button type='button'  class='ui-state-default ui-corner-all' id='btn-checkid'>중복확인</button></div>";
	checkid_src += "<div id='checkid-message' style='text-align:center;'></div>";
	checkid_src += "</form>";

	$('body').append($("<div id='div-checkid' style='display:none;overfow:hidden'>").html(checkid_src));


	$('#checkid').css('cursor','pointer');
	$('#btn-checkid').click(function(){ checkId() });
	$('#checkid').click(function(){
		
		$('#div-checkid').dialog({
					width:450,
					height:250,
					title:'ID 중복확인',
					modal:true,
					buttons: {
						"닫기": function() { 
							$(this).dialog("close"); 
						}
					},
					open:function(){
						$('#div-checkid').show();
						$('#chkid').val($('#userid').val());
						$('#checkid-message').html('아이디 입력 후 [중복확인] 버튼을 클릭해주세요');
					},
					close:function(){
						$('#div-checkid').dialog("destroy");
					}
				});
	});

});


function checkId(){

	var _id = $.trim($('#chkid').val());

	if( _id == '' || /([a-zA-Z0-9]{5,20})/i.test(_id) == false ){
		window.alert('아이디는 영문, 숫자 조합 5~20자리로 입력하실 수 있습니다.');
		return false;
	}

	var date = new Date();
	$.ajax({
		url:'/users/checkid/'+date.getTime(),
		type:'POST',
		data:$('#form-checkid').serialize(),
		dataType:"json",
		success: function(json){
		  if( json ){
			  if( json.result == 'ok' ){
					_auth_id  =json.chkid;
					$('#checkid-message').html('<b>' + json.chkid + '</b> 는 사용하실 수 있습니다. <br /><br /><button type="button"  class="ui-state-default ui-corner-all" id="btn-useid" onclick="checkIdOk()">사용하기</button>');
			  }else if( json.result == 'duplicate' ){
					$('#checkid-message').html('<b>' + json.chkid + '</b> 는 이미 사용중입니다. ');
			  }else{
					$('#checkid-message').html('시스템 오류가 발생하였습니다.');
			  }
		  }
		}//end of onSuccess
	  });
	  return false;
}


function checkIdOk(){
	
	if( _auth_id ){
		$('#userid').val(_auth_id);
		$('#div-checkid').dialog("destroy");
	}else{
		window.alert('아이디 중복 확인이 진행되지 않았습니다.');
	}
}