<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>

<?=$paginator->options(array('url' =>$this->passedArgs));?>

<div id="content">

<h1>회원 목록</h1>


 <div><?=$paginator->counter(array('format' => 'Total : %count%, Page : %page%/%pages%'));?></div>

<table class='tbl-list'>
<col width='5%' />
<col width='*' />
<col width='25%' />
<col width='5%' />
<col width='15%' />
<col width='5%' />
<col width='5%' />
<col width='5%' />
<tr>
<th><?=$paginator->sort('번호', 'id'); ?></th>
<th><?=$paginator->sort('제목', 'title'); ?></th>
<th><?=$paginator->sort('기간', 'sdate'); ?></th>
<th>참여</th>
<th><?=$paginator->sort('등록일', 'created'); ?></th>
<th>결과</th>
<th>수정</th>
<th>삭제</th>
</tr>

<?php foreach($this->data as $row):?>
<tr>
<td><?=$row['PollSetup']['id']?></td>
<td class='left'><b><?=$paginator->link($row['PollSetup']['title'],array('action'=>'view',$row['PollSetup']['id']))?></b></td>
<td><?=substr($row['PollSetup']['sdate'],2,14)?> ~ <?=substr($row['PollSetup']['edate'],2,14)?></td>
<td><?=$row['PollSetup']['persons']?></td>
<td><?=substr($row['PollSetup']['created'],2,14)?></td>
<td><?=$html->link($html->image("webadm/chart_bar_16x16.png",array('alt'=>'결과')),'result/'.$row['PollSetup']['id'],array('escape'=>false))?></td>
<td><?=$html->link($html->image('webadm/table_edit_16x16.gif',array('alt'=>'수정')),'edit/'.$row['PollSetup']['id'],array('escape'=>false))?></td>
<td><?=$html->link($html->image('webadm/table_delete_16x16.gif',array('alt'=>'삭제')),'delete/'.$row['PollSetup']['id'],array('escape'=>false),"삭제하시겠습니까?")?></td>
</tr>
<?php endforeach;?>
</table>




</div>



<div class='content-bar'>
	<div class='paging-area float-left'>
<?=$paginator->prev('« 이전 ', null, null, array('class' => 'page-disabled'));?>
<?=$paginator->numbers(); ?>
<?=$paginator->next(' 다음 »', null, null, array('class' => 'page-disabled'));?>
	</div>
	<div class="floatright gBtn gBtn1">	
		<a><span><?=$form->button("설문추가",array('div'=>false,'class'=>'button','id'=>'btn-add'))?></span></a>
	</div>
</div>

<!--
<div class='content-bar center clear'>
<?=$form->create("User",array("action"=>"search","type"=>"get"))?>
<?=$form->select("sfield",array('name'=>'이름','userid'=>'아이디'),null,array('empty'=>false))?> <?=$form->text("keyword")?>
<?=$form->submit("검색",array('div'=>false,'class'=>'btn'))?>
<?=$form->end();?>
</div>
-->

<?=$javascript->codeBlock("
$(function(){
	$('#btn-add').click(function(){
		window.location.href = '/webadm/poll/add';
	});	
});
",array('inline'=>false));?>