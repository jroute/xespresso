<div id="navigation-bar">
	<?=$this->element("board/webadm_navigation_bar");?>
</div>

<div id='top-tabs'>
</div>

<div id='content'>

	<div id='board-wrap'>

		<div id='board-confirm-wrap'>

		<?=$form->create("Board",array('url'=>$this->here));?>
		<?=$form->hidden("bid")?>
		<?=$form->hidden("userid")?>
		<?=$form->error('bid','* 게시판 아이디 지정이 되지 않아 글 입력을 할 수 없습니다.')?>


		<?php if( $action == "edit" ):?>
			<h3 class='confirm-title'>글 수정</h3>
		<?php else:?>
			<h3 class='confirm-title'>글 삭제</h3>
		<?php endif;?>

		<table class="tbl">
		<col width="80" />
		<col width="*" />
		<tr><th>제목</th><td><?=$this->data['Board']["subject"]?></td></tr>
		<?php if( $delAuthority ):?>
			<tr><th>메시지</th><td>삭제하시겠습니까?</td></tr>
		<?php else:?>
			<tr><th>비밀번호</th><td><?=$form->password("passwd",array("class"=>"txt width150px"))?><?if( $error ){echo "<div class='error-message'>* 비밀번호를 확인하십시오</div>";}?></td></tr>
			<tr><th>메시지</th><td><div id='message-edit'>글 등록시 입력하신 비밀번호를 입력하십시오</div>	</td></tr>
		<?php endif?>

		</table>

		<div id="btn-area" class="gBtn gBtn1 floatright">
			<a><span><?=$form->submit('확인',array("div"=>false,'class'=>''));?></span></a>
			<?=$html->link('<span>취소</span>',array('action'=>'view',$bid,$no),array('class'=>'','escape'=>false));?>
		</div>
		<?=$form->end();?>

		</div>
	</div>

</div>