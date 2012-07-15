
<?=$javascript->link('fckeditor/fckeditor.js', false);?>
<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>

<div id='content'>
<div id="pages-wrap">


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

	<?=$form->create("Content",array("action"=>$this->action,'onsubmit'=>'return on_submit(this)'))?>
	<?=$form->hidden("id")?>

	<table class='tbl'>
	<col width='100' />
	<col width='*' />
	<tr><th>버전</th><td><?=$this->data['Content']['reversion']?></td></tr>
	<tr><th width='100'>언어</th><td><?=$form->select("lang",$language,@$lang,array('empty'=>false));?></td></tr>
	<tr><th>제목</th><td><?=$form->text("title",array("style"=>"width:99%;"));?><?=$form->error("title","제목을 입력하십시오");?></td></tr>
	<tr><td colspan='2'>
	<?=$form->textarea("content",array('id'=>'pagecontent'));?>
	<?php echo $editor->load($this->data['Content']['editor'],'pagecontent','98%','500'); ?> 
	<?=$form->error("content","내용을 입력하십시오");?>

	</td></tr>
	</table>
	
	<div class="floatright gBtn gBtn1 btn-area">
		<a><span><?=$form->submit("리버전(복원)",array('div'=>false));?></span></a>
		<?=$html->link("<span>목록</span>",array('action'=>'index'),array('id'=>'btn-list','escape'=>false));?>
	</div>
	<?=$form->end();?>
</div>


<?=$paginator->options(array('url' =>(count($this->passedArgs)  ? $this->passedArgs:$this->data['Content']['id'])));?>
<table class='tbl-list'>
<tr>
<th><?=$paginator->sort('버전', 'reversion'); ?></th>
<th><?=$paginator->sort('제목', 'title'); ?></th>
<th>미리보기</th>
<th><?=$paginator->sort('담당자', 'name'); ?></th>
<th><?=$paginator->sort('등록일', 'created'); ?></th>
</tr>

<?php foreach($reversions as $row):?>
<tr>
<td><?=$row['ContentReversion']['reversion']?></td>
<td class='td-left'><b><?=$row['ContentReversion']['title']?></b></td>
<td><?=$html->link('미리보기','revert/'.$this->data['Content']['id'].'/'.$row['ContentReversion']['id'])?></td>
<td><?=$row['ContentReversion']['name']?></td>
<td><?=substr($row['ContentReversion']['created'],2,14)?></td>
</tr>
<?php endforeach;?>
</table>

<div class='btn-area'>
	<div class='paging-area float-left'>
		<?=$paginator->prev('« Previous ', null, null, array('class' => 'page-disabled'));?>
		<?=$paginator->numbers(); ?>
		<?=$paginator->next(' Next »', null, null, array('class' => 'page-disabled'));?>
	</div>

	<div class="floatright gBtn1">
		<?=$html->link("<span>페이지 추가</span>",array('action'=>'add'),array('escape'=>false))?>
	</div>
</div>

</div>
