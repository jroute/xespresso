<div id="navigation-bar">
	<?=$this->element('board_setup/webadm_navigation_bar');?>
</div>

<div id="top-tab">
<?=$this->element('board_setup/webadm_tabs_board_setup')?>
</div>


<div id="content">
	<h1>필터링</h1>

	<?=$form->create('BoardSetup',array("url"=>$this->here))?>
	<?=$form->hidden("bid")?>
	<table class='tbl'>
	<col width="100" />
	<col width="*" />
	<col width="100" />
	<col width="*" />
	<tr>
	<th>게시판이름</th><td colspan='3'><?=$form->text("bname",array('style'=>'border:none;width:99%','readonly'=>'readonly'))?></td></tr>
	<tr><th>아이피차단</th><td><?=$form->textarea("filter_ip",array("style"=>"width:200px;height:200px"))?></td>
	<th>데이터차단</th><td><?=$form->textarea("filter_word",array("style"=>"width:200px;height:200px"))?></td>
	</tr>
	</table>




<div class="btn-area gBtn gBtn1 floatright">
	<a><span><?=$form->submit("확인",array('class'=>'button'))?></span></a>
</div>



	<?=$form->end()?>

</div>