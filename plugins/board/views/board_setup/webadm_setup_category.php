<div id="navigation-bar">
	<?=$this->element('board_setup/webadm_navigation_bar');?>
</div>

<div id="top-tab">
	<?=$this->element('board_setup/webadm_tabs_board_setup')?>
</div>


<div id="content">
	<h1>카테고리 설정</h1>

	<div id="board-category">
	<?

	echo "<ul>";
	$beforSub = 0;
	foreach($categorys as $key=>$category){
		$sub = substr_count($category,'━');
		$category = strtr($category,array('━'=>''));
		if( $sub == $beforSub ){
			echo "<li key='$key'><span>$category</span>";
		}else if( $sub > $beforSub ){
			echo "\n<ul>\n<li key='$key'><span>$category</span>";
		}else if( $sub < $beforSub ){
			for( $i = 0 ; $i < ($beforSub-$sub) ; $i++ ){
				echo "</li></ul>\n";
			}
			echo "\n</li><li key='$key'><span>$category</span>";
		}


		$beforSub = $sub;
	}
	echo "</li></ul>";

	?>
	</div>


	<div id='board-category-form'>
	<?=$form->create('BoardSetup',array("url"=>$this->here,'onsubmit'=>'return false','id'=>'categoryForm'))?>
	<?=$form->hidden("bid")?>
	<?=$form->hidden("name")?>
	<?=$form->hidden("BoardCategory.action")?>
	<?=$form->hidden("BoardCategory.bid")?>
	<?=$form->hidden("BoardCategory.id")?>
	<?=$form->hidden("BoardCategory.parent_id")?>
	<?=$form->hidden("BoardCategory.name")?>
	<?=$form->error('bid','게시판 아이디 값이 필요합니다.');?>	
	<?=$form->error('name','카테고리 이름을 입력하셔야 합니다.');?>
	<table class="tbl">
	<tr>
		<th>추가</th>
		<td>
			<?=$form->text("newName")?>
			<?=$form->submit("확인",array('div'=>false,'id'=>'btn-add','class'=>'btn'))?>
		</td>
		</tr>
		<tr>
		<th>수정</th>
		<td>
			<?=$form->text("chgName")?>
			<?=$form->submit("확인",array('class'=>'btn','div'=>false,'id'=>'btn-edit'))?>
			<?=$form->submit("삭제",array('class'=>'btn','div'=>false,'id'=>'btn-del'))?>
		</td>
		</tr>
		<tr>
		<th>정렬</th>
		<td>
			<?=$form->button("위로",array('id'=>'btn-moveup','class'=>'btn'))?>
			<?=$form->button("아래로",array('id'=>'btn-movedown','class'=>'btn'))?>
		</td>
		</tr>
	</table>



	<?=$form->end()?>
	</div>

</div>


<script type='text/javascript'>
//<![CDATA[
$(function(){
	$('#board-category li span').each(function(index){
		$(this).css({'cursor':'pointer'});
		$(this).click(function(){
			$('#BoardSetupChgName').val($(this).text());
			$('#BoardCategoryId').val($(this).parent().attr('key'));
		},true);
	});

	//add category
	$('#btn-add').click(function(){
		$('#BoardCategoryId').val('')
		$('#BoardCategoryParentId').val('')

		var _name = $.trim($('#BoardSetupNewName').val());
		if( _name == "" ){
			window.alert("카테고리 명을 입력하십시오");
			return;
		}

		if( window.confirm("추가 하시겠습니까?") ){
			$('#BoardCategoryAction').val('');
			$('#BoardCategoryParentId').remove();
			$('#BoardCategoryName').val(_name);
			document.getElementById('categoryForm').submit();
		}

	});

	//edit category
	$('#btn-edit').click(function(){

		if( $('#BoardCategoryId').val() == "" ){
			window.alert("카테고리를 선택하십시오");
			return;
		}

		if( window.confirm("수정 하시겠습니까?") ){
			$('#BoardCategoryAction').val('');
			$('#BoardCategoryParentId').remove();
			$('#BoardCategoryName').val($('#BoardSetupChgName').val());
			document.getElementById('categoryForm').submit();
		}
	});



	//delete category
	$('#btn-del').click(function(){

		if( $('#BoardCategoryId').val() == "" ){
			window.alert("카테고리를 선택하십시오");
			return;
		}

		if( window.confirm("삭제 하시겠습니까?") ){
			$('#BoardCategoryAction').val('delete');
			document.getElementById('categoryForm').submit();
		}
	});


	//up
	$('#btn-moveup').click(function(){
		if( $('#BoardCategoryId').val() ){
			window.location.href = '/webadm/board_setup/category_moveup/<?=$bid?>/' + $('#BoardCategoryId').val() + "/1";
		}else{
			window.alert("카테고리를 선택하십시오");
		}
	});

	//down
	$('#btn-movedown').click(function(){
		if( $('#BoardCategoryId').val() ){
			window.location.href = '/webadm/board_setup/category_movedown/<?=$bid?>/' + $('#BoardCategoryId').val() + "/1";
		}else{
			window.alert("카테고리를 선택하십시오");
		}
	});

});
//]]>
</script>