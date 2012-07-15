

$(function(){

	//사용자 메뉴
	$('#account li > a').click(function(){
		$('.dropdown').toggle();
	})

	$('.tbl-list tr:odd').css('background','#F5F5F5');

	var trbg = null;
	$('.tbl-list tr').bind('mouseover',function(){
		trbg = $(this).css('background');
		$(this).css('background','#ECF5FC');
	});

	$('.tbl-list tr').bind('mouseout',function(){
		$(this).css('background',trbg);
	});


	$('#change-lang').bind('change',function(){
		window.location.href = $(this).attr('url')+"/language:"+$(this).val();
	})

});


function Q(name,link){


	if( $('body').is('#add-quickmenu') == false ){
		$('body').append($("<div id='add-quickmenu'></div>"));
			
		$('#add-quickmenu').html("<form id='quickform' onsubmit='return false'><input type='hidden' name='data[QuickMenu][icon]' value='mobilesafari.png' /><table class='tbl'><tr><th>아이콘</th><td><img src='/img/webadm/quickicons/mobilesafari.png' width='40' /></td><td rowspan='3'><div id='quick-icons' style='width:60px;height:120px;'></div></td></tr><tr><th>메뉴명</th><td><input type='text' name='data[QuickMenu][name]' id='quick-name' /></td></tr><tr><th>링크정보</th><td><input type='text' name='data[QuickMenu][link]' id='quick-link' /></td></tr></table><div class='margin5 center'><button id='btn-quick-add'>확인</button> <button id='btn-quick-close'>닫기</button></div></form>");
	}

	$('#add-quickmenu').dialog({
			title:'퀵 메뉴 등록',
			width:400,
			height: 250,
			modal: true,
			open:function(){
				_this = $(this);
				$('#quick-name').val(name);
				$('#quick-link').val(link);

				$('#btn-quick-close').click(function(){
					_this.dialog('destroy');
				});

				$('#btn-quick-add').click(function(){
					var now = new Date();

					if( $('#quick-name').val() == '' ){
						window.alert('메뉴명을 입력하십시오');
						return;
					}
					if( $('#quick-link').val() == '' ){
						window.alert('링크정보를 입력하십시오');
						return;
					}	

					$.ajax({
						url:'/webadm/qmenus/add/' + now.getTime(),
						type:'POST',
						dataType:'json',
						data:$('#quickform').serialize(),
						success:function(data){
							$('#quickmenus').append($("<li id='qid-" + data.id + "'><a href='" + data.link + "' title='" + data.name + "'><img src='/img/webadm/quickicons/"+ data.icon +"' width='40' /></li>"));
							$('#add-quickmenu').dialog('destroy');
						}
					});
				});
			}
	});

}