$(function(){
	//전체 체크
	$('#allchk').click(function(){
		var _this = $(this);

		$('.allchk').each(function(index){
		
			if( _this.is(':checked') == true ){
				$(this).attr('checked',true);
			}else{

				$(this).attr('checked',false);
			}
		});

	});

	

	//게시물이동
	$('#btn-move').click(function(){

		if( chked() == false ){
			window.alert('게시물을 선택하십시오');
			return;
		}
		chkcnt = $('.allchk:checked').get().length;
		$('#move').dialog({
			title:'게시물 이동/복사',
			width:450,
			height:220,
			modal:true,
			buttons:{
				'닫기':function(){
					$('#move').dialog('destroy');
				},
				'게시물 이동/복사':function(){

					$('#BoardMovebid').val( $('#move-bid').val() );

					if( $('#BoardMovebid').val() == "" ){
						window.alert("이동/복사할 게시판 선택이 되지 않았습니다.");
						return;
					}

					if( $('#BoardModeMove').is(':checked') ) mode='move'; 
					else mode='copy';

					$.ajax({
						url:'/webadm/board/multimove/'+$('#BoardBid').val(),
						type:'post',
						data:$('#form-list').serialize() + '&data%5BBoard%5D%5Bmethod%5D=' + mode,
						success:function(data){

							if( $('#BoardModeMove').is(':checked') ) method='이동'; 
							else method='복사';

							if( data == "success" ){
								$.jGrowl('게시물이 ' + method + ' 되었습니다.<br />페이지를 다시 로드 합니다.', { 
									theme: 'smoke',
									life: 1000,
									close: function(e,m,o) {
										window.location.reload();
									}
								});
							}else{
								$.jGrowl('게시물 ' + method + '을 할 수 없습니다.', { 
									theme: 'smoke',
									life: 1000
								});
							}
						}
					});
				}
			},
			open:function(){
				$('#move-ea').html(chkcnt);
				$('#move').show();
			},
			close:function(){
				$('#move').dialog('destroy');
			}
		});
	});

	//선택 삭제
	$('#btn-delete').click(function(){

		if( chked() == false ){
			window.alert('게시물을 선택하십시오');
			return;
		}

		if( window.confirm('선택한 게시물을 삭제 하시겠습니까?') == true ){
			$.ajax({
				url:'/webadm/board/multidelete/' + $('#BoardBid').val(),
				type:'post',
				data:$('#form-list').serialize(),
				success:function(rst){
					if( rst == 'ok' ){
						$.jGrowl('삭제 되었습니다.', { 
							theme: 'smoke',
							life: 1000,
							close: function(e,m,o) {
								window.location.reload();
							}
						});
					}else{
						
					}
				}
			});
		}

	});
	
});



function chked(){
	var chk = false;
	$('.allchk').each(function(index){
		if( $(this).is(':checked') == true ){
			chk = true;
			return false;
		}
	});
	return chk;
}