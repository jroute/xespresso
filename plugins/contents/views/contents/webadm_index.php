<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>

<?=$paginator->options(array('url' =>$this->passedArgs));?>


<div id="content">


  <?=$paginator->counter(array('format' => 'Total : %count%, Page : %page%/%pages%'));?>

<table class='tbl-list'>
<col width="7%" />
<col width="10%" />
<col width="*" />
<col width="10%" />
<col width="12%" />
<col width="12%" />
<col width="5%" />
<col width="5%" />
<tr>
<th><?=$paginator->sort('페이지번호', 'id'); ?></th>
<th><?=$paginator->sort('메뉴', 'Menu.name'); ?></th>
<th><?=$paginator->sort('제목', 'title'); ?></th>
<th>미리보기</th>
<th><?=$paginator->sort('등록일', 'created'); ?></th>
<th><?=$paginator->sort('수정일', 'modified'); ?></th>
<th>수정</th>
<th>삭제</th>
</tr>

<?php foreach($datas as $row):?>
<tr>
<td><?=$row['Content']['id']?></td>
<td><?=$row['Menu']['name']?></td>
<td class='td-left'><b><?=$paginator->link($row['Content']['title'],array('action'=>'edit',$row['Content']['id']))?></b></td>
<td><?=$html->link('미리보기','/contents/'.$row['Content']['id'],array('target'=>'_blank'))?></td>
<td><?=str_replace('-','.',substr($row['Content']['created'],2,14))?></td>
<td><?=str_replace('-','.',substr($row['Content']['modified'],2,14))?></td>
<td><?=$paginator->link($html->image('webadm/table_edit_16x16.gif',array('alt'=>'수정')),array('plugin'=>false,'action'=>'edit',$row['Content']['id']),array('escape'=>false))?></td>
<td class="center"><?=$html->link($html->image('webadm/table_delete_16x16.gif',array('alt'=>'삭제')),
							array('plugin'=>false,'action'=>'delete',$row['Content']['id']),array('escape'=>false),'삭제하시겠습니까?')?></td>
</tr>
<?php endforeach;?>
</table>

<div class='btn-area'>
	<div class='paging-area float-left'>
		<?=$paginator->prev('« 이전 ', null, null, array('class' => 'page-disabled'));?>
		<?=$paginator->numbers(); ?>
		<?=$paginator->next(' 다음 »', null, null, array('class' => 'page-disabled'));?>
	</div>

	<div class="floatright btn-area gBtn1">
		<?=$html->link("<span>페이지 추가</span>",array('plugin'=>false,'action'=>'add','language'=>$lang),array('id'=>'btn-add','div'=>false,'escape'=>false))?>
	</div>
</div>


<!-- <div class='search-area'>
<?=$form->create("User",array("action"=>"search","type"=>"get"))?>
<?=$form->text("keyword")?>
<?=$form->submit("검색",array('div'=>false))?>
<?=$form->end();?>
</div> -->

</div>
