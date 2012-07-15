<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>

<div id='content'>
<div id="pages-wrap">


<script type="text/javascript">
//<![CDATA[
function on_submit(frm){
	<?php if( $this->data['Content']['editor'] == 'cheditor' ):?>
		frm.elements['data[Content][content]'].value = cheditor.outputBodyHTML();
	<?php endif;?>
}
//]]>
</script>

	<?=$form->create("Content",array('url'=>$this->here,'onsubmit'=>'return on_submit(this)'))?>
	<?=$form->hidden("id")?>
	<table class='tbl'>
	<col width='100' />
	<col width='*' />
	<tr><th width='100'>언어</th><td><?=$form->select("lang",$language,null,array('empty'=>false));?></td></tr>
	<tr><th>메뉴</th><td><?=$form->select("Menu.id",@$menus,null,array('empty'=>'::메뉴선택::'));?></td></tr>	
	<tr><th>제목</th><td><?=$form->text("title",array("style"=>"width:99%;"));?><?=$form->error("title","제목을 입력하십시오");?></td></tr>
	<tr><th>Editor</th><td><?=$form->select("editor",$editor->editor,null,array('id'=>'select-editor','empty'=>false));?></td></tr>
	<tr><td colspan='2' align="center">
	<?=$form->textarea("content",array('id'=>'editor'));?>
	<?php echo $editor->load($this->data['Content']['editor'],'editor','99%','500'); ?> 
	<?=$form->error("content","내용을 입력하십시오");?>
	</td></tr>
	
		<tr>
	<td colspan="2">
<?php		
echo $this->element('swfupload', array('plugin'=>'fileattach',
																		'module'=>'contents',
                                    'model'=>'Contents.Content',
                                    'dir'=>'contents',
                                    'id' =>@$this->data['Content']['id'],
                                    'file_size_limit'=>5,//MB
                                    'file_types'=>'*.jpg,*.png,*.gif',//
                                    'file_upload_limit'=>10,
																		'editor_id'=>'editor'//위지윅 에디터 아이디
                                   ));		                                    
?>
	</td></tr>
	
	</table>
	
	<div class="btn-area floatright gBtn gBtn1 ">
		<a><span><?=$form->submit("저장",array('class'=>'awesome','div'=>false));?></span></a>
		<?=$html->link("<span>목록</span>",array('action'=>'index'),array('escape'=>false,'id'=>'btn-list'));?>
		<?=$html->link("<span>페이지 추가</span>",array('action'=>'add'),array('id'=>'btn-add','div'=>false,'escape'=>false))?>
	</div>
	<?=$form->end();?>
</div>

<?php if( @$this->data['Content']['id'] ):?>
<?=$paginator->options(array('url' =>(count($this->passedArgs)  ? $this->passedArgs:@$this->data['Content']['id'])));?>
<table class='tbl-list'>
<tr>
<th><?=$paginator->sort('버전', 'reversion'); ?></th>
<th><?=$paginator->sort('제목', 'title'); ?></th>
<th>미리보기</th>
<th><?=$paginator->sort('담당자', 'name'); ?></th>
<th><?=$paginator->sort('등록일', 'created'); ?></th>
</tr>

<?php foreach($reversions as $page):?>
<tr>
<td><?=$page['ContentReversion']['reversion']?></td>
<td class='td-left'><b><?=$page['ContentReversion']['title']?></b></td>
<td><?=$html->link('미리보기','revert/'.$this->data['Content']['id'].'/'.$page['ContentReversion']['id'])?></td>
<td><?=$page['ContentReversion']['name']?></td>
<td><?=substr($page['ContentReversion']['created'],2,14)?></td>
</tr>
<?php endforeach;?>
</table>

<div class="btn-area">
	<div class='paging-area'>
		<?=$paginator->prev('« 이전 ', null, null, array('class' => 'page-disabled'));?>
		<?=$paginator->numbers(); ?>
		<?=$paginator->next(' 다음 »', null, null, array('class' => 'page-disabled'));?>
	</div>

</div>
<?php endif?>
</div>

<?php $javascript->codeBlock("
$(function(){

	$('#select-editor').bind('change',function(){
		window.location.href = '".$html->url(array('action'=>$this->action,@$this->data['Content']['id']))."/editor:'+$(this).val();
	});
});
",array('allowCache'=>true,'safe'=>true,'inline'=>false))?>

