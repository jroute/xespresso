$(function(){

	$('#copy-url').click(function(){
		$('#copy-url').copy();
	})

	$('#btn-cancel').click(function(){
		$('#MenuParentId').val('');
		$('#add-title').text('추가');
	});



		$('#menu-category li a').click(function(){
			if( $(this).attr('noEvent') == 'true' ){
			

			$('#add-title').html('추가');
			$('#MenuChgName').val('');

			$('#MenuParentId').val('');
			$('#MenuId').val('');
			$('#menu-url').val('');
						
				return;
			}
			//reset edit form
			$('select').each(function(index){
				$(this).val('');
			});


			$('#add-title').html('<b>['+$(this).text()+']</b> 하위 메뉴 추가');
			$('#MenuChgName').val($(this).text());

			var pid = $(this).parent().attr('id').replace('node');

			$('#MenuParentId').val(pid);
			$('#MenuId').val(pid);

			$('#menu-url').val('/menus/sub/'+pid);

			// set options
			$.ajax({
						url: "/webadm/menus/ajax_options/" + pid,
						dataType:'json',
						cache: false,
						success: function(json){
						
							if( json == false ) return;
							$('input[type=radio]').each(function(index){

									if( $(this).val() == json['Menu'].controller ) $(this).attr('checked','checked');

								return;
							});

							$('#MenuSubmenu').val(json['Menu'].submenu);
							if( json['Menu'].model == 'Link' ){
								$('#' + json['Menu'].controller + 'Link').val(json['Menu'].link);
							}else{

							}

							$('#MenuController').val(json['Menu'].controller);
							$('#MenuModel').val(json['Menu'].model);
							$('#MenuAction').val(json['Menu'].action);
							$('#MenuPass').val(json['Menu'].pass);
							$('#' + json['Menu'].controller + 'Pass').val(json['Menu'].pass);

							$('#MenuParams').val(json['Menu'].params);

							$('#MenuX').val(json['Menu'].x);
							$('#MenuY').val(json['Menu'].y);
							$('#MenuZ').val(json['Menu'].z);
						}
			});// end of $.ajax
			return false;
		});


	//add category
	$('#btn-add').click(function(){
		$('#MenuId').val('')

		var _name = $.trim($('#MenuNewName').val());
		if( _name == "" ){
			window.alert("카테고리 명을 입력하십시오");
			return;
		}

		if( $('#MenuParentId').val() ){
			var msg = "하위 메뉴를 추가";
		}else{
			var msg = "메뉴를 추가";
		}

		if( window.confirm(msg + " 하시겠습니까?") ){
			$('#MenuMethod').val('');
			$('#MenuName').val(_name);
			//$('#MenuIndexForm').submit();
			document.getElementById('MenuIndexForm').submit();
		}

	});

	//edit category
	$('#btn-edit').click(function(){
		var controller = null;
		$('input[type=radio]').each(function(){
			if(this.checked == true ){
				controller = this.value;
				$('#MenuModel').val(controller);//set model
				return;
			}
		});
		if( $('#MenuId').val() == "" ){
			window.alert("카테고리를 선택하십시오");
			return;
		}

		if( window.confirm("수정 하시겠습니까?") ){

			$('#MenuController').val($('#' + controller + 'Controller').val());
			$('#MenuModel').val($('#' + controller + 'Model').val());
			$('#MenuAction').val($('#' + controller + 'Action').val());
			$('#MenuPass').val($('#' + controller + 'Pass').val());
			$('#MenuParentId').remove();
			$('#MenuName').val($('#MenuChgName').val());
			//$('#MenuIndexForm').submit();
			document.getElementById('MenuIndexForm').submit();
		}
	});



	//delete category
	$('#btn-del').click(function(){

		if( $('#MenuId').val() == "" ){
			window.alert("카테고리를 선택하십시오");
			return;
		}

		if( window.confirm("삭제 하시겠습니까?") ){
			$('#MenuMethod').val('delete');
			//$('#MenuIndexForm').submit();
			document.getElementById('MenuIndexForm').submit();
		}
	});


	//up
	$('#btn-up').click(function(){
		if( $('#MenuId').val() ){
			window.location.href = '/webadm/menus/moveup/' + $('#MenuId').val() + "/1";
		}else{
			window.alert("메뉴를 선택하십시오");
		}
	});

	//down
	$('#btn-down').click(function(){
		if( $('#MenuId').val() ){
			window.location.href = '/webadm/menus/movedown/' + $('#MenuId').val() + "/1";
		}else{
			window.alert("메뉴를 선택하십시오");
		}
	});

});