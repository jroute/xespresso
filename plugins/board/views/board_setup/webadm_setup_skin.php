<div id="navigation-bar">
	<?=$this->element('board_setup/webadm_navigation_bar');?>
</div>

<div id="top-tab">
<?=$this->element('board_setup/webadm_tabs_board_setup')?>
</div>


<div id="content">
	<h1>게시판 설정</h1>

	<?=$form->create('BoardSetup',array("url"=>$this->here))?>
	<?=$form->hidden("bid")?>
	<?=$form->hidden("bname")?>
	<table class='tbl'>
	<col width="100" />
	<col width="*" />
	<tr><th>게시판이름</th><td colspan='3'><?=$html->link($this->data['BoardSetup']['bname'],'/boards/lst/'.$this->data['BoardSetup']['bid'],array('target'=>'_blank'),false,false)?></td></tr>
	<tr><th>상단 HTML</th><td><?=$form->textarea("skin_header",array("style"=>"width:99%;height:150px"))?></td></tr>
	<tr><th>하단 HTML</th><td><?=$form->textarea("skin_footer",array("style"=>"width:99%;height:150px"))?></td></tr>
	</table>


	<br />
	<h3>Skin</h3>
	<table class='tbl tdstyle1'>
	<col width="150" />
	<col width="100" />
	<col width="200" />
	<col width="*" />
	<col width="50" />
	<col width="150" />
	<tr>
	<th>아이디</th>
	<th>색상</th>
	<th>스킨명</th>
	<th>스킨 설명</th>
	<th>버전</th>
	<th>개발자</th>
	</tr>

	<?php foreach($skins as $skin):?>	
		<tr>
		<td><?=$form->radio("skin",array($skin['Information']['folder']=>$skin['Information']['folder']))?></td>
		<td><?=$skin['Information']['color']?></td>
		<td><b><?=$skin['Information']['name']?></b></td>
		<td><?=$skin['Information']['description']?></td>
		<td class='td-center'><?=$skin['Information']['version']?></td>
		<td><?=$skin['Author']['name']?></td>
		</tr>
	<?php endforeach;?>	
</table>


<br/>

	<h3>Icons</h3>
	<table class='tbl tdstyle1'>
	<col width="150" />
	<col width="*" />
	<col width="150" />
	<tr>
	<th>아이디</th>
	<th>미리보기</th>
	<th>개발자</th>
	</tr>

	<?php foreach($icons as $icon):?>	
		<tr>
		<td><?=$form->radio("skin_icon",array($icon['Information']['folder']=>$icon['Information']['folder']))?></td>
		<td>
		<?for($i=0;$i<=6;$i++):?>
			<?=$html->image('/board/img/icons/'.$icon['Information']['folder'].'/'.$icon['Icons']['item'.$i])?>
		<?endfor?></td>
		<td><?=$icon['Author']['name']?></td>
		</tr>
	<?php endforeach;?>	
	</table>
	
<br />

	<h3>File Extensions</h3>
	<table class='tbl tdstyle1'>
	<col width="150" />
	<col width="*" />
	<col width="150" />
	<tr>
	<th>아이디</th>
	<th>미리보기</th>
	<th>개발자</th>
	</tr>

	<?php foreach($exts as $icon):?>	
		<tr>
		<td><?=$form->radio("skin_ext",array($icon['Information']['folder']=>$icon['Information']['folder']))?></td>
		<td>
		<?php for($i=0;$i<=9;$i++):?>
			<?=$html->image('/board/img/exts/'.$icon['Information']['folder'].'/'.$icon['Icons']['item'.$i])?>
		<?endfor?>
		<td><?=$icon['Author']['name']?></td>
		</td>
		</tr>
	<?php endforeach;?>	

</table>



<div class="btn-area gBtn gBtn1 floatright">
	<a><span><?=$form->submit("확인",array('class'=>'button'))?></span></a>
</div>


	<?=$form->end()?>

</div>