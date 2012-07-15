<div id="navigation-bar">
	<div id="navigation-title"><h3>팝업존 관리</h3></div>
	<div id="navigation-control">
	</div>

</div>
<?=$form->create('Popupzone',array('url'=>$this->here,'type'=>'file'));?>
<?=$form->hidden('id');?>
<div id="content">


	<table class='tbl'>
	<col width="100" />		
	<col width="*" />	

		<tr>
		<th>제목</th>
		<td><?=$form->text('title')?></td>
		</tr>
		<tr>		
		<th>배너 이미지</th>		
		<td><?=$form->file('usrfile')?>  size : 245px * 116px;
		<?php if( $this->data['Popupzone']['banner'] ):?>
			<br />
			<?=$html->image('/files/popupzone/'.$this->data['Popupzone']['banner']);?>
			<?=$form->checkbox('delfile')?>삭제
		<?php endif;?>
		
		</td>
		</tr>	
		<tr>
		<th>링크</th>		
		<td><?=$form->text('link')?></td>	
		</tr>

	</table>
</div>

<div class="floatright gBtn gBtn1">
		<a><span><?=$form->submit('등록',array('div'=>false,'id'=>'btn-add','class'=>'button'));?></span></a>
		<a><span><?=$form->button('취소',array('type'=>'button','id'=>'btn-cancel','class'=>'button'));?></span></a>
	
</div>

<?=$form->end();?>

<?=$javascript->codeBlock("
$(function(){

	$('#btn-cancel').click(function(){
		window.history.back();
	})
	
});
",array('inline'=>false));?>
