<div id="navigation-bar">
	<?=$this->element('board_setup/webadm_navigation_bar');?>
</div>

<div id="top-tab">
<?=$this->element('board_setup/webadm_tabs_board_setup')?>
</div>


<div id="content">
	<h1>게시판 레벨(권한) 설정</h1>
	<?=$form->create('BoardSetup',array("url"=>$this->here))?>
	<?=$form->hidden("bid")?>
	<?=$form->hidden("bname")?>
	<table class="tbl">
	<col width="150" />
	<col width="*" />
	<th>게시판이름</th><td><?=$form->text("bname",array('style'=>'border:none;width:99%','readonly'=>'readonly'))?></td></tr>
	</table>
	
<hr class="hr"/>

	<table class='tbl'>
	<col width="150" />
	<col width="250" />
	<col width="*" />
	<tr><th >기능</th><th>레벨</td><th>설명</td></tr>
	<tr><th class='th-left'>목록</th>
	<td><?=$form->select('lv_list',$level,null,array('empty'=>false))?> 이상</td><td> 목록 접근 권한 설정</td></tr>
	<tr><th class='th-left'>읽기</th>
	<td><?=$form->select('lv_read',$level,null,array('empty'=>false))?> 이상</td><td> 글 읽기 접근 권한 설정</td></tr>
	<tr><th class='th-left'>쓰기</th>
	<td><?=$form->select('lv_write',$level,null,array('empty'=>false))?> 이상</td><td> 글 쓰기 접근 권한 설정</td></tr>
	<tr><th class='th-left'>답글</th>
	<td><?=$form->select('lv_reply',$level,null,array('empty'=>false))?> 이상</td><td> 답글 접근 권한 설정 - 부운영자 이상 권장</td></tr>
	<tr><th class='th-left'>수정</th>
	<td><?=$form->select('lv_edit',$level,null,array('empty'=>false))?> 이상</td><td> 수정 접근 권한 설정 - 부운영자 이상 권장</td></tr>
	<tr><th class='th-left'>삭제</th>
	<td><?=$form->select('lv_delete',$level,null,array('empty'=>false))?> 이상</td><td> 삭제 접근 권한 설정 - 부운영자 이상 권장</td></tr>

	<tr><th class='th-left'>댓글쓰기</th>
	<td><?=$form->select('lv_cmt_write',$level,null,array('empty'=>false))?> 이상</td><td> 댓글 쓰기 접근 권한 설정</td></tr>

	<tr><th class='th-left'>공지사항</th>
	<td><?=$form->select('lv_notice',$level,null,array('empty'=>false))?> 이상</td><td> 공지사항 등록 권한 설정</td></tr>
	<tr><th class='th-left'>HTML모두허용</th>
	<td><?=$form->select('lv_html',$level,null,array('empty'=>false))?> 이상</td><td> HTML 모두 허용 권한 설정 </td></tr>
	</table>


<div class="btn-area gBtn gBtn1 floatright">
	<a><span><?=$form->submit("확인",array('class'=>'button'))?></span></a>
</div>

	<?=$form->end()?>

</div>