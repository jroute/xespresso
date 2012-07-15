$(function(){
	$('.datepicker').datepicker({dateFormat:'yy-mm-dd'});
	



	$('#q-del').click(function(){
		if( (idx-1) == 0 ) return;
		$('.que:eq(' + ((--idx)) +')').remove();

	});
	
	$('.del-que').click(function(){
		if( $('#question>li').length < 2 ){
			window.alert("더 이상 삭제 할 수 없습니다. 질문은 하나 이상 등록하셔야 합니다.");
			return;
		}
		var qid = $(this).attr('id');

		$('#question>li').each(function(){
			_this = $(this);
			if( _this.find('.del-que').attr('id') == qid ){
				_this.slideUp(500,function(){$(this).remove();});
				return false;			
			}
		})


		

	});	

	
	
	$( "#question" ).sortable({
		delay: 300,
		axis: "y",
//		placeholder: "ui-state-highlight",
		start:function(event, ui){
			
		},
		stop:function(event, ui){
//			alert(ui.item.attr('id'));
		},
		update:function(event, ui){
			$('.que').each(function(index){
				$(this).children().val(index);
			})

		},		
	});
	$( "li" ).disableSelection();

		

})



function setEvent(){

	//객관식 / 주관식 선택시 이벤트
	$('.qtype').unbind('change');
	$('.qtype').bind('change',function(){

		var _idx = $(this).attr('id').split('-')[1];

		if( $(this).val() == 'O' ){
			$('#items-' + _idx).show();
			$('#select-options-' + _idx).show();
		}else if ( $(this).val() == 'S' ){
			$('#items-' + _idx).hide();
			$('#select-options-' + _idx).hide();
		}
	});

	//단일/다중 선택
	$('.qselecttype').unbind('change');
	$('.qselecttype').bind('change',function(){
		var _idx = $(this).attr('id').split('-')[1];
		if( $(this).val() == 'S' ){
			$('#select-num-' + _idx).hide();
		}else if ( $(this).val() == 'M' ){
			$('#select-num-' + _idx).show();
		}
	});


	$('.add-item').unbind('click');
	$('.add-item').click(function(event){

		var _this = $(this);
		var _idx = _this.attr('id').split('-')[1];
		
		var templ = "<!--data--><li><input name='data[PollQuestion][{n}][items][]' type='text' size='40' value=''  /> <input type='checkbox' name='data[PollQuestion][{n}][itemetc][{idx}]' value='1' />추가입력</li><!--data-->";

//		var node = $(templ).bindTo({n:_idx,idx:$('#item-list-'+(_idx) + ' li').get().length});
				
		$(templ.replace(/{n}/g,_idx).replace(/{idx}/g,$('#item-list-'+(_idx) + ' li').get().length)).appendTo('#item-list-'+_idx);


		

	});

	$('.del-item').unbind('click');
	$('.del-item').click(function(){
		var _this = $(this);
		var _idx = _this.attr('id').split('-')[1];
		
		if( $('#item-list-'+_idx + ' li').get().length == 1 ) return;
		$('#item-list-'+_idx + ' li:eq(' + ($('#item-list-'+_idx + ' li').get().length -1)+ ')').remove();
	});


}


function on_submit(){

	$('#PollSetupSdate').val( $('#sdate').val() + ' ' + $('#stime').val() );
	$('#PollSetupEdate').val( $('#edate').val() + ' ' + $('#etime').val() );

	return true;
}