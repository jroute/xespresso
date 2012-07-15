
<div id="content">


<h1>회원 그룹 설정</h1>


<?=$form->create("UserGroupSetup",array('url'=>$this->here))?>
<?=$form->hidden('grpid',array('value'=>$id));?>
<table class='tbl'>
<col width="20%" />
<col width="80%" />
<tr><th>그룹 명</td><td><?=$form->text("grp_name")?><?=$form->error('grp_name','그룹명을 입력하십시오');?></td></tr>
<tr><th>그룹 설명</td><td><?=$form->text("grp_note")?><?=$form->error('grp_note','그룹 설명을 입력하십시오');?></td></tr>
</table>
<p class="right">
<?php if( $id ):?>
	<?=$form->submit("수정",array('div'=>false,'class'=>'small awesome orange'))?>
<?php else:?>
	<?=$form->submit("저장",array('div'=>false,'class'=>'small awesome orange'))?>
<?php endif;?>

<?=$html->link('취소',array('action'=>'group'),array('class'=>'small awesome orange'));?>
</p>
<?=$form->end()?>

<table class='tbl-list'>
<col width="15%" />
<col width="30%" />
<col width="35%" />
<col width="10%" />
<col width="10%" />
<tr>
<th>그룹 ID</th>
<th>그룹 명</th>
<th>그룹 설명</th>
<th>수정</th>
<th>삭제</th>
</tr>

<?foreach($gdata as $group):
$grp = $group['UserGroupSetup'];
?>
<tr>
<td><?=$grp['grpid']?></td>
<td><?=$grp['grp_name']?></td>
<td><?=$grp['grp_note']?></td>
<td><?=$html->link("수정",array('action'=>"group",$grp['grpid']));?></td>
<td><?=$html->link("삭제",array('action'=>"group_del",$grp['grpid']),null,'삭제하시겠습니까?');?></td>
</tr>
<?endforeach;?>
</table>


</div>