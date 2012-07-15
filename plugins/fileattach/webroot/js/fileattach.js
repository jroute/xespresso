function get_file_size_string(size) {

	_sz = size.split(' ');

	sz = parseInt(_sz[0],10);
	sign = _sz[1];

	if (sign == 'Bytes' ) {
		file_size = sz;
	}else if (sign == 'KB' ) {
		file_size = sz*1024;
	}else if (sign == 'MB' ) {
		file_size = sz*(1024*1024);
	}else if (sign == 'GB' ) {
		file_size = sz*(1024*1042*1024);
	}else if (sign == 'TB' ) {
		file_size = sz*(1024*1042*1024*1024);
	}else{
		file_size = 0;
	}
	return file_size;
}


function get_file_size(size) {

	kb = 1024;
	mb = 1024 * kb;
	gb = 1024 * mb;
	tb = 1024 * gb;
		
	if (size < kb) {
		file_size = size + ' Bytes';
	}else if ( size < mb) {
		sz = Math.round(size/kb);
		file_size = sz+' KB';
	}else if ( size < gb) {
		sz = Math.round(size/mb);
		file_size = sz + ' MB';
	}else if ( size < tb) {
		sz = Math.round(size/gb);
		file_size = sz + ' GB';
	}else{
		sz = Math.round(size/tb);
		file_size = sz + ' TB';
	}
	return file_size;
}



	//파일 삭제
	function delFile(id){
		if( confirm('삭제하시겠습니까?') ){
			$.ajax({
				url:'/fileattach/delete',
				type:'post',
				data:{'id':id},
				success:function(result){
					if( result == "ok" ){	
						
						size = $('#' + id).attr('size');
						$('#' + id).slideUp(1000,function(){
									$('#' + id).remove()

									if( $(swfCurrentObj).attr('id') == id ){
										swfCurrentObj = null;
										$('#preview-img').empty();
									}
								}
						);
						
						file_size= file_size-parseFloat(size)
						$('#file-size').text(get_file_size(file_size));
						$('#file-count').text(--file_count);
					}else{
						window.alert('삭제 할 수 없습니다.');
					}
				}
			});
		}
	}

	var swfCurrentObj = null;
	function setFile(obj){
		obj.className = "swfactive";
		if( swfCurrentObj == obj ) return;
		if( swfCurrentObj ) swfCurrentObj.className = '';
		swfCurrentObj = obj;
	}

	function filepreview(obj){
		var _this = $(obj);	

		if( /(jpg|gif|png)$/i.test(_this.attr('src')) ){
			$('#preview-img').empty();
			$('#preview-img').append($('<img>').attr({'src':'/' + _this.attr('src'),'width':100,'height':75}));
		}
	};

	
function setFileExpose(){

		$('.flabel').unbind('click');
		$('.flabel').click(function(){
			data = $(this).val().split(':');
			$.ajax({
				url:'/fileattach/expose/'+data[0]+'/'+data[1],
				success:function(rst){
					if( rst == 'success' ){
					}else{
						window.alert('리스트(메인) 노출 이미지 지정에 실패하였습니다. 다시 시도하십시오');
					}
				}
			})
		})

}