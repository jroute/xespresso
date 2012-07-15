<div id="navigation-bar">
	<?=$this->element("board/webadm_navigation_bar");?>
</div>

<div id='top-tabs'>
</div>

<div id='content'>

<div id='board-wrap'>

	<div id='board-form-wrap'>
<script type="text/javascript">
//<![CDATA[
function on_submit(frm){

	try{
		<?php if( $setup['editor'] == 'cheditor' ):?>frm.elements['data[Board][content]'].value = cheditor.outputBodyHTML();	<?php endif;?>
	}catch(e){

	}
	return true;
}
//]]>
</script>
	<?=$form->create("Board",array('url'=>array('controller'=>$this->params['controller'],"action"=>$this->action.'/'.$bid.'/'.$no),'onsubmit'=>'return on_submit(this)'));?>
	<?=$form->hidden("bid")?>
	<?=$form->hidden("userid")?>
	<?=$form->error('bid','* 게시판 아이디 지정이 되지 않아 글 입력을 할 수 없습니다.')?>
	<table class="tbl">
	<col width="15%" />
	<col width="85%" />
	
<?php if( $setup['use_approve'] ):?>
	<tr><th>승인</th><td><?=$form->input("opt_approval",array('type'=>'radio','options'=>array('0'=>' 비승인 ','1'=>' 승인 '),'default'=>'1','legend'=>false))?></td></tr>
<?php endif;//end of use_approve?>
	
<?php if( $setup['use_notice'] ):?>
	<tr><th>공지글</th><td><?=$form->checkbox("opt_notice")?>상단 공지하기</td></tr>
<?php endif;//end of use_notice?>

<?php if( $setup['use_category'] ):?>
	<tr><th>카테고리</th><td><?=$form->select("category",$categories,null,array('empty'=>'::선택::'))?></td></tr>
<?php endif;//end of use_category?>
	<tr><th>제목</th><td><?=$form->text("subject",array("class"=>"txt w99ps"))?><?=$form->error('subject')?></td></tr>

<?php if( @$session->Read('Admin.check') ):?>
	<tr><th>작성자</th><td><?=$form->text("name",array('class'=>'txt'))?><?=$form->error('name')?>
	<?=$form->hidden("passwd",array("class"=>"txt width150px"))?><?=$form->error('passwd','* 비밀번호를 입력하십시오')?>
	</td></tr>
<?php else:?>
	<tr><th>작성자</th><td><?=$form->text("name",array("class"=>"txt w150px"))?><?=$form->error('name','* 작성자를 입력하십시오')?></td></tr>
	<tr><th>비밀번호</th><td><?=$form->password("passwd",array("class"=>"txt w150px"))?><?=$form->error('passwd','* 비밀번호를 입력하십시오')?></td></tr>
<?php endif;?>


	<tr><th>이메일</th><td><?=$form->text("email",array("class"=>"txt w50px"))?><?=$form->error('email','* 이메일 형식에 맞지 않습니다.')?></td></tr>
<?php if( $setup['use_homepage'] ):?>	
	<tr><th>홈페이지</th><td><?=$form->text("homepage",array("class"=>"txt w250px"))?><?=$form->error('homepage','* 홈페이지 주소를 입력하십시오! ex) http://example.com')?></td></tr>
<?php endif;?>


<?php if($setup['use_link1']):?>
	<tr><th>링크 #1</th><td><?=$form->text("link1",array("class"=>"txt w99ps"))?></td></tr>
<?php endif?>
<?php if($setup['use_link2']):?>
	<tr><th>링크 #2</th><td><?=$form->text("link1",array("class"=>"txt w99ps"))?></td></tr>
<?php endif?>


	<tr><td colspan="3" align="center"><?=$form->textarea("content",array("id"=>"boardeditor",'rows'=>30,'style'=>'width:100%'))?>
	<?php echo $editor->load($setup['editor'],'boardeditor'); ?> 
	<?=$form->error('content')?>
	</td>	</tr>


<?php if( $setup['use_tag'] ):?>
	<tr><th>태그</th><td><?=$form->text("tags",array("class"=>"txt w99ps"))?><br />태그(키워드)를 공백으로 구분하여 입력하세요</td></tr>
<?php endif;//end of use_category?>


<?php if($setup['use_file']):?>
	<tr><td colspan="3">
	
<?php		
echo $this->element('swfupload', array('plugin'=>'fileattach',
																		'module'=>'board',
                                    'model'=>'Board.Board',
                                    'dir'=>'board'.DS.$bid,
                                    'id' =>@$this->data['Board']['no'],
                                    'file_size_limit'=>$setup['fileupload_size'],//MB
                                    'file_types'=>$setup['fileupload_ext'],//
                                    'file_upload_limit'=>$setup['fileupload_limit'],
																		'editor_id'=>'boardeditor'//위지윅 에디터 아이디
                                   ));		                                    
?>
	</td>	</tr>
<?php endif;?>	

	</table>

	<div id="btn-area" class="gBtn1 gBtn floatright">
		<a><span><?=$form->submit('저장',array('class'=>'small orange awesome',"div"=>false));?></span></a>
		<?=$html->link('<span>목록</span>',array('action'=>'lst',$bid),array('class'=>'small orange awesome','escape'=>false));?>
	</div>
	<?=$form->end();?>

	</div>

</div>

</div>