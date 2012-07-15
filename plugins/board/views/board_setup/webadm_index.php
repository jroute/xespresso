<div id="navigation-bar">
	<?=$this->element('board_setup/webadm_navigation_bar');?>
</div>

<div id="top-tab">
<div id="ctab">
	<ul class='ul-tab'>
	<li><?=$html->link('게시판추가',array('plugin'=>'board','controller'=>'board_setup','action'=>'add'))?></li>
	<li class="active"><?=$html->link('게시판목록',array('plugin'=>'board','controller'=>'board_setup','action'=>'index'))?></li>
	</ul>
</div>
</div>


<div id="content">

<h1>게시판 목록</h1>

<table class='tbl-list'>
<tr>
<th>아이디</th>
<th>이름</th>
<th>글수</th>
<th>댓글수</th>
<th>미리보기</th>
<th>환경설정</th>
<th>생성일</th>
<th>수정일</th>
</tr>

<?php 
foreach($bsetup as $key=>$setup):
$set = $setup['BoardSetup'];
?>
<tr>
<td class="left"><strong style="font-weight:bold"><?=$set['bid']?></strong></td>
<td class='td-left'><b><?=$set['bname']?></b></td>
<td><?=$set['total_article']?></td>
<td><?=$set['total_comment']?></td>
<td><?=$html->link('미리보기',array('plugin'=>'board','controller'=>'board','action'=>'lst',$set['bid'],'webadm'=>false),array('target'=>'_blank'))?></td>
<td><?=$html->link('환경설정',array('plugin'=>'board','controller'=>'board_setup','action'=>'edit',$set['bid']))?></td>
<td><?=substr($set['created'],2,14)?></td>
<td><?=substr($set['modified'],2,14)?></td>
</tr>
<?endforeach;?>
</table>


</div>