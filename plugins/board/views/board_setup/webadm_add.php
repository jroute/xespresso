<div id="navigation-bar">
	<?=$this->element('board_setup/webadm_navigation_bar');?>
</div>

<div id="top-tab">
	<div id="ctab">
		<ul class='ul-tab'>
		<li class="active"><?=$html->link('게시판추가',array('plugin'=>'board','controller'=>'board_setup','action'=>'add'))?></li>
		<li><?=$html->link('게시판목록',array('plugin'=>'board','controller'=>'board_setup','action'=>'index'))?></li>
		</ul>
	</div>
</div>


<div id="content">

<h1>게시판 추가</h1>


	<?=$form->create('BoardSetup',array("url"=>$this->here))?>
	<table class='tbl'>
	<tr><th>아이디</th><td><?=$form->text("bid")?><?=$form->error("bid",'게시판 아이디 규칙을 따르십시오')?></td><td>영문 또는 숫자만 입력 가능합니다.(1~30자)</td></tr>
	<tr><th>이름</th><td><?=$form->text("bname")?><?=$form->error("bname",'게시판 이름을 작성하십시오')?></td><td>게시판 이름을 작성합니다.</td></tr>


	<tr><th>리스트 스타일</th><td><?=$form->radio("list_style",array("L"=>"목록형","T"=>"Thumbnail 리스트 형","G"=>"갤러리 형"),array('value'=>'L',"legend"=>false))?></td><td>리스트 페이지의 스타일을 지정합니다.</td></tr>
	<tr><th>리스트 출력 개수</th><td><?=$form->text("list_rows",array('value'=>15,'size'=>'3'))?></td><td>출력될 리스트의 개수를 지정합니다.</td></tr>

	<tr><th>카테고리 사용</th><td><?=$form->checkbox("use_category")?></td><td>카테고리를 사용합니다.</td></tr>
	<tr><th>댓글 사용</th><td><?=$form->checkbox("use_comment")?></td><td>댓글을 사용합니다.</td></tr>

	</table>

	<div class="btn-area gBtn gBtn1 floatright">
		<a><span><?=$form->submit("확인",array('class'=>'button'))?></span></a>
	</div>
	<?=$form->end()?>


</div>