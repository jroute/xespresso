<div id="navigation-bar">
	<?=$this->element('board_setup/webadm_navigation_bar');?>
</div>

<div id="top-tab">
<?=$this->element('board_setup/webadm_tabs_board_setup')?>
</div>

<div id="content">
	<h1>게시판 설정</h1>
	<?=$form->create('BoardSetup',array("url"=>$this->here))?>
	<table class='tbl'>
	<tr><th>아이디</th><td><?=$form->text("bid",array('readonly'=>'readonly'))?></td><td>영문 또는 숫자만 입력 가능합니다.(1~30자)</td></tr>
	<tr><th>이름</th><td><?=$form->text("bname")?></td><td>게시판 이름을 작성합니다.</td></tr>


	<tr><th>리스트 스타일</th><td><?=$form->radio("list_style",array("L"=>"목록형","T"=>"Thumbnail 리스트 형","G"=>"갤러리 형","M"=>"동영상 타입"),array("legend"=>false))?><br />
	리스트형 썸네일 사이즈 : <?=$form->text('thumb_size_list')?><br />
	갤러리형 썸네일 사이즈 : <?=$form->text('thumb_size_gallery')?>	
	</td><td>리스트 페이지의 스타일을 지정합니다.</td></tr>
	<tr><th nowrap>리스트 출력 개수</th><td><?=$form->text("list_rows",array('size'=>'3'))?></td><td>출력될 리스트의 개수를 지정합니다.</td></tr>
	<tr><th>제목 길이제한</th><td><?=$form->text("maxlength")?></td><td>리스트레 출력될 제목길이를 제한합니다.</td></tr>
	<tr><th>공지기능 사용</th><td><?=$form->checkbox("use_notice")?></td><td>공지기능을 사용합니다.</td></tr>
	<tr><th>카테고리 사용</th><td><?=$form->checkbox("use_category")?></td><td>카테고리를 사용합니다.</td></tr>

	<tr><th>뷰하단 리스트 출력</th><td><?=$form->checkbox("use_viewlist")?></td><td>뷰 하단에 리스트를 출력합니다.</td></tr>
	
	<tr><th>위지윅 에디터 선택</th><td><?=$form->select("editor",array('ckeditor'=>'CKEditor','cheditor'=>'CHEditor'),null,array('empty'=>false))?></td><td>글 등록시 사용되는 위지윅에디터를 선택합니다.</td></tr>

	<tr><th>Captcha 사용</th><td><?=$form->checkbox("use_captcha")?></td><td>스팸방지를 위해 글등록시 보안문자를 입록하도록 설정합니다.</td></tr>

	<tr><th>승인 사용</th><td><?=$form->checkbox("use_approve")?></td><td>관리자 승인 있어야 글을 표출 합니다.</td></tr>
	
	<tr><th>RSS 사용</th><td><?=$form->checkbox("use_rss")?></td><td>RSS 사용합니다.</td></tr>
	<tr><th>댓글 사용</th><td><?=$form->checkbox("use_comment")?></td><td>댓글을 사용합니다.</td></tr>

	<tr><th>홈페이지 입력</th><td><?=$form->checkbox("use_homepage")?></td><td>글 등록시 홈페이지 정보를 등록할 수 있습니다.</td></tr>
	<tr><th>링크사용#1</th><td><?=$form->checkbox("use_link1")?></td><td>글 등록시 링크 정보를 등록할 수 있습니다.</td></tr>
	<tr><th>링크사용#2</th><td><?=$form->checkbox("use_link2")?></td><td>글 등록시 링크 정보를 등록할 수 있습니다.</td></tr>

	<tr><th>이미지파일표시</th><td><?=$form->checkbox("use_auto_fileview")?></td><td>첨부된 이미지 파일을 내용과 함께 표시 합니다.</td></tr>


	<tr><th>파일업로드형태</th><td><?=$form->select("fileupload_type",array('ajaxupload'=>'AJAX Upload','swfupload'=>'SWF upload'),null,array('empty'=>false))?></td><td></td></tr>
	<tr><th>파일업로드파일수</th><td><?=$form->select("fileupload_limit",array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>9,'10'=>10,'15'=>15,'20'=>20),null,array('empty'=>false))?></td><td></td></tr>

	<tr><th>파일첨부 사용</th><td><?=$form->checkbox("use_file")?></td><td>파일업로드를 사용합니다.</td></tr>
    <tr><th>파일용량 제한</th><td><?=$form->text("fileupload_size",array('class'=>'right','size'=>5))?> MB (<span style="color:red">서버 허용 용량 : <?=ini_get('post_max_size')?></span>) </td><td>파일용량을 제한합니다.</td></tr>
	<tr><th>허용 파일 확장자</th><td><?=$form->text("fileupload_ext")?></td><td>*.* : 모든 파일 허용, *.jpg; *.gif; *.png : 이미지만 허용</td></tr>
	<tr><th>글등록 메일 확인</th><td><?=$form->checkbox("use_feedback")?> 이메일 <?=$form->text('feedback_email')?></td><td>글등록 확인 메일을 받아 볼 경우 사용합니다.<br />
	* 카테고리 추가시 메일정보를 입력하면 각 카테고리 별로 메일이 발송됩니다.</td></tr>
	<tr><th>태그입력 허용</th><td><?=$form->checkbox("use_tag")?></td><td>글 등록시 태그(키워드) 입력을 받습니다.</td></tr>
	<tr><th>SMS 수신</th><td><?=$form->checkbox("use_sms")?>
	<br />휴대폰번호 <?=$form->text("feedback_sms")?>
	<br />메시지내용 <?=$form->text("feedback_sms_message",array('class'=>'w300px'))?>
	</td><td>글 등록시 문자로 등록내용을 받습니다.<br />
	치환자 : 게시판명 [:board:], 작성자 [:name:]
	</td></tr>

	</table>


<div class="btn-area gBtn gBtn1 floatright">
	<a><span><?=$form->submit("확인",array('class'=>'button'))?></span></a>
</div>

	<?=$form->end()?>

</div>
