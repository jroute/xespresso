<?=$paginator->options(array('url' =>$this->passedArgs));?>
<?php $vno = $paginator->counter('%count%')-($paginator->counter('%page%')-1)*$paginate['Popupzone']['limit'];?>

<div id="navigation-bar">
	<div id="navigation-title"><h3>팝업존 관리</h3></div>
	<div id="navigation-control">
	</div>

</div>

<div id="content">

  <?=$paginator->counter(array('format' => 'Total : %count%, Page : %page%/%pages%'));?>

	<table class='tbl-list'>
	<col width="40" />
	<col width="100" />		
	<col width="150" />	
	
	<col width="40" />
	<col width="40" />		
	<tr>
	<th><?=$paginator->sort('번호', 'id'); ?></th>
	<th><?=$paginator->sort('이미지', 'EducationCourse.title'); ?></th>
	<th><?=$paginator->sort('제목', 'EducationCourse.category'); ?> / 링크</th>
	<th>수정</th>
	<th>삭제</th>	
	</tr>
	
	<?php foreach($rows as $row):$data = array_shift($row);?>

		<tr>
		<td><?=$vno--?></td>
		<td><?=$html->image('/files/popupzone/'.$data['banner']);?></td>		
		<td style="left"><?=@$data['title'];?><br /><?=@$data['link'];?></td>		
		<td><?=$paginator->link($html->image('webadm/table_edit_16x16.gif',array('alt'=>'수정')),array('action'=>'edit',$data['id']),array('escape'=>false))?></td>
		<td><?=$html->link($html->image('webadm/table_delete_16x16.gif',array('alt'=>'삭제')),array('action'=>'delete',$data['id']),array('escape'=>false),'삭제하시겠습니까?')?></td>	
		</tr>
	<?php endforeach;?>
	</table>


</div>

<div class="content-bar">
	<div class="float-left">
		<?=$paginator->prev('« 이전 ', null, null, array('class' => 'page-disabled'));?>
		<?=$paginator->numbers(); ?>
		<?=$paginator->next(' 다음 »', null, null, array('class' => 'page-disabled'));?>
	</div>
	<div class="floatright gBtn gBtn1">
		<a><span><?=$form->button('등록',array('id'=>'btn-add','class'=>'button'));?></span></a>
	</div>
</div>

<?=$javascript->codeBlock("
$(function(){
	$('#btn-add').click(function(){
		window.location.href = '".$html->url(array('action'=>'add'))."';
	});
	
	$('.state').bind('change',function(){
		_this = $(this);
		if( window.confirm('변경하시겠습니까?') ){
			$.ajax({
				url:'/webadm/popupzone/change_state',
				cache:false,
				data:{'data[id]':$(this).attr('id'),'data[state]':$(this).val()},
				type:'post',
				success:function(rst){
					if( rst == 'success' ){
						window.alert('변경되었습니다.');
					}else{
						window.alert('오류 : 시스템 점검이 필요 합니다.');
						_this.val(rst.split(':')[1]);
					}
				}
			});
		}
	});
	
});
",array('inline'=>false));?>
