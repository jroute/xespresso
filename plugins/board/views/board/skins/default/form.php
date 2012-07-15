
<?=$html->css("/board/css/skins/".$setup['skin']);?>

<div id='board-wrap'>

	<?=$setup['skin_header']?>

	<div id="board-form-wrap">

<script type="text/javascript">
//<![CDATA[
$(function(){
	if( $('#tags').val() == '' ){
		$('#tags').val($('#tags').attr('holdplacer'))
	}
	$('#tags').focus(function(){
		if( $('#tags').val() == $('#tags').attr('holdplacer') ){
			$('#tags').val('');
		}
	}).blur(function(){
		if( $('#tags').val() == '' ){
			$('#tags').val($('#tags').attr('holdplacer'));
		}	
	})
});
function on_submit(frm){
	try{
		<?php if( $setup['editor'] == 'cheditor' ):?>frm.elements['data[Board][content]'].value = cheditor.outputBodyHTML();	<?php endif;?>
		
		if( $('#tags').val() == $('#tags').attr('holdplacer') ){
			$('#tags').val('');
		}
		
	}catch(e){

	}
	return true;
}
//]]>
</script>

	<?=$form->create("Board",array('url'=>'/'.$this->params['controller'].'/'.$this->action.'/'.$bid.'/'.$no,'onsubmit'=>'return on_submit(this)'));?>
	<?=$form->hidden("bid")?>
	<?=$form->hidden("no")?>
	<?=$form->hidden("userid")?>
	<?=$form->error('bid','* 게시판 아이디 지정이 되지 않아 글 입력을 할 수 없습니다.')?>
	<table class="tbl-board-view">
	<caption><?=__('write')?></caption>	
	<col width="15%" />
	<col width="85%" />
<?php if( $setup['use_category'] ):?>
	<tr><th><?=__('category')?></th><td><?=$form->select("category",$categories)?></td></tr>
<?php endif;//end of use_category?>
	<tr><th><?=__('subject')?></th><td><?=$form->text("subject",array("class"=>"txt width99ps"))?><?=$form->error('subject')?></td></tr>

<?php if( @$this->data['Board']['check'] ):?>
	<tr><th><?=__('name')?></th><td><?=$form->label($session->data['Board']['name'])?><?=$form->hidden("name",array("label"=>"test"))?><?=$form->error('name','* 작성자를 입력하십시오')?>
	<?=$form->hidden("passwd",array("class"=>"txt width150px"))?><?=$form->error('passwd','* 비밀번호를 입력하십시오')?>
	</td></tr>
<?php else:?>
	<tr><th><?=__('name')?></th><td><?=$form->text("name",array("class"=>"txt width150px"))?><?=$form->error('name','* 작성자를 입력하십시오')?></td></tr>
	<tr><th><?=__('password')?></th><td><?=$form->password("passwd",array("class"=>"txt width150px"))?><?=$form->error('passwd','* 비밀번호를 입력하십시오')?></td></tr>
<?php endif;?>


	<tr><th><?=__('email')?></th><td><?=$form->text("email",array("class"=>"txt width250px"))?><?=$form->error('email','* 이메일 형식에 맞지 않습니다.')?></td></tr>
	<tr><th><?=__('homepage')?></th><td><?=$form->text("homepage",array("class"=>"txt width250px"))?><?=$form->error('homepage','* 홈페이지 주소를 입력하십시오! ex) http://example.com')?></td></tr>
	
<?php if( $setup['use_link1'] ):?>
	<tr><th><?=__('링크#1')?></th><td><?=$form->text("link1",array("class"=>"txt width250px"))?></td></tr>
<?php endif;?>	
<?php if( $setup['use_link2'] ):?>
	<tr><th><?=__('링크#2')?></th><td><?=$form->text("link2",array("class"=>"txt width250px"))?></td></tr>
<?php endif;?>		
	
	<tr><td colspan="3"><?=$form->textarea("content",array('id'=>'boardeditor'))?>
	<?php echo $editor->load($setup['editor'],'boardeditor'); ?> 
	<?=$form->error('content')?>
	</td>	</tr>

<?php if($setup['use_tag']):?>
	<tr><th><?=__('태그')?></th><td><?=$form->text("tags",array('id'=>'tags',"class"=>"txt width99ps",'holdplacer'=>'태그와 태그는 쉼표로 구분하며 입력하실 수 있습니다.'))?></td></tr>
<?php endif;?>

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
                                    'editor_id'=>'boardeditor'
                                   ));		                                    
?>
	
	</td>	</tr>
<?php endif?>


<?php if($setup['use_captcha']):?>
	<tr><th>보안문자</th><td>
<script type="text/javascript">
//<![CDATA[
		var captchacnt = 0;
		function recaptcha(){
			captchacnt++;$('#captcha-img').attr('src','/captcha/image/200/60?'+captchacnt);
		}
//]]>
</script>
	<img src="/captcha/image/200/60" id='captcha-img'  style="float:left;" />
	<p style="float:left;margin:3px;">
	 좌측에 보이는 문자를 입력하십시오 
	<br />
	<?=$form->text("captcha",array("class"=>"txt",'style'=>'width:120px;text-align:center;font-weight:bold;'))?><br />
	(<a href="javascript:void(0)" onclick="recaptcha(); return false;">이미지 새로고침</a>)
	</p>
	<div style="clear:both"><?=$form->error('captcha','보안문자가 일치 하지 않습니다. 확인 후 다시 입력하십시오');?></div>
	</td>	</tr>
<?php endif?>

	</table>

	<div id='btn-area'>
		<?php if( $setup['use_approve'] && !$session->Read('User.check') ):?>
		<span>비회원 글 등록,수정시에는 관리자 승인 후에만 목록에서 확인 하실 수 있습니다.</span>
		<?php endif;?>
	
		<?=$form->submit(__('write',true),array("div"=>false,'style'=>'border:none','class'=>'button'));?>
		<?=$html->link(__('cancel',true),"javascript:window.history.back()",array('class'=>'button'));?>
		<?=$html->link(__('list',true),array('action'=>'lst',$bid,"page:".@$this->passedArgs['page'],"/category:".@$this->passedArgs['category']),array('class'=>'button'));?>
	</div>
	<?=$form->end();?>

	</div>
<?=$setup['skin_footer']?>

</div>