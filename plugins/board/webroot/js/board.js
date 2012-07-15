
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
	function delFile(bid, id){
		if( confirm('삭제하시겠습니까?') ){
			$.ajax({
				url:'/board/filedelete/' + bid + '/' + id,
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
						
						board_file_size= board_file_size-parseFloat(size)
						$('#board-file-size').text(get_file_size(board_file_size));
						$('#board-file-count').text(--board_file_count);
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

	function pasteImage(path){
		var align = arguments[0];

		if( swfCurrentObj == null ){
			alert("파일을 선택하세요~!!");
			return;
		}
		fname = $(swfCurrentObj).attr('name');

		if( /(jepg|jpg|png|gif)$/i.test(fname) ){
			if( align == "L" ){
				swfImg = '<img align="left" border="0" src="/' + $(swfCurrentObj).attr('src') + '" alt="' + fname + '" />';
			}else if( align == "R" ){
				swfImg = '<img align="right" border="0" src="/' + $(swfCurrentObj).attr('src') + '" alt="' + fname + '"/>';
			}else{
				swfImg = '<img border="0" src="/' + $(swfCurrentObj).attr('src') + '" alt="' + fname + '"/>';
			}
		}else{
			swfImg = '<a href="/board/download/' + board_bid + '/' + board_no + '/' +  $(swfCurrentObj).attr('id') + '" title="' + fname + '">' + fname + '</a>';
		}

		try{

			var oEditor = CKEDITOR.instances.boardeditor;
			
			if (oEditor.mode == 'wysiwyg' ){
				oEditor.insertHtml( swfImg ) ;
			}else{
				alert( 'You must be on WYSIWYG mode!' ) ;
			}
		}catch(e){

			try{
				cheditor.insertContents(swfImg);
			}catch(e){
				alert(e.message);
			}
		}
	}
	
function setFileExpose(){

		$('.flabel').unbind('click');
		$('.flabel').click(function(){
			data = $(this).val().split(':');
			$.ajax({
				url:'/board/file_expose/'+data[0]+'/'+data[1]+'/'+data[2],
				success:function(rst){
					if( rst == 'success' ){
					}else{
						window.alert('리스트(메인) 노출 이미지 지정에 실패하였습니다. 다시 시도하십시오');
					}
				}
			})
		})

}


	function openWinSNS(openUrl) {
		var winObj;
		winObj = window.open(openUrl,"WinSNS","width=1000, height=700");
	}

	function openWinSNS2(openUrl) {
		var winObj;
		winObj = window.open(openUrl,"WinSNS2","width=600, height=364, scrollbars=no, resizable=no");
	}


var fSize = '0.95em';

function fontsize(state){

    fSize = fSize.split('em')[0];
    fSize = parseFloat(fSize);
    if (state == '+' && fSize <= parseFloat(1.7)) {
        fSize = fSize + 0.2;
    } else if (state == '-' && fSize >= parseFloat(0.7)) {
        fSize = fSize - 0.2;
    } else if (state == '') {
        fSize = 0.75;
    } else {
        //alert('최소, 최대값입니다.');
    }
    fSize = fSize + 'em';
    $('#board-content-view').css({'font-size':fSize});

}



$(function(){

	$('.sns').click(function(){
		var $this = $(this);
		var _media = $(this).attr('class');
		if( _media.indexOf('twitter') != -1 ){
				openWinSNS($this.attr('href'));
		}else if( _media.indexOf('me2day') != -1 ){
				openWinSNS($this.attr('href'));
		}else if( _media.indexOf('facebook') != -1 ){
				openWinSNS2($this.attr('href'));
		}else if( _media.indexOf('delicious') != -1 ){
				openWinSNS($this.attr('href'));
		}
		return false;
	});
	
	
	$('.filelist').css({display:'none'})
	$('.btn-attachfile').click(function(){
		if($('.filelist').css('display') == 'none' ){
			$('.filelist').slideDown();
		}else{
			$('.filelist').slideUp();		
		}
	});
	
	$('.svc-font-large').click(function(){
		fontsize('+');
		return false;		
	});
	$('.svc-font-small').click(function(){
		fontsize('-');	
		return false;
	});	
	
	$('.svc-print').click(function(){
		var winPrint; 
		winPrint = window.open($(this).attr('href'),'winPrint','width=700,height=600,menubars=yes,scrolling=yes,resizable=yes');
		return false;
	})
})//end of doucment.ready















