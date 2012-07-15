<div id="navigation-bar">
	<div id="navigation-title"><h3>사이트 관리</h3></div>
	<div id="navigation-control">
	</div>

</div>


<div id="content">


	<?=$form->create('Site',array('url'=>'/webadm/setup/site','type'=>'file'))?>
	<?=$form->hidden("id")?>
	<table class='tbl'>
	<col width="100" />
	<col width="*" />
	<col width="350" />		
	<tr><th>사이트명</th><td><?=$form->text("name",array('class'=>'w99ps'))?><?=$form->error("name",'사이트명을 입력하십시오')?></td><td>사이트명을 입력합니다.</td></tr>
	<tr><th>사이트 타이틀</th><td><?=$form->text("title",array('class'=>'w99ps'))?><?=$form->error("title",'사이트 타이틀을 입력합시오')?></td><td>타이틀에 표시될 사이트명을 입력합니다.</td></tr>


	<tr><th>도메인</th><td><?=$form->text("url")?></td><td>사이트 도메인 주소를 입력합니다.</td></tr>
	<tr><th>이메일</th><td><?=$form->text("email")?></td><td>관리자 메일 정보를 입력합니다.</td></tr>

	<tr><th>연락처</th><td><?=$form->text("tel")?></td><td></td></tr>
	<tr><th>팩스</th><td><?=$form->text("fax")?></td><td></td></tr>

	<tr><th>메일링 발송자명</th><td><?=$form->text("mailing_name",array('class'=>'w99ps'))?></td><td>메일링 발송시 사용할 발송자명 입니다.</td></tr>
	<tr><th>메일링 메일</th><td><?=$form->text("mailing_email",array('class'=>'w99ps'))?></td><td>메일링 발송시 사용할 메일 주소입니다.</td></tr>
	<tr><th>관리자 타이틀</th><td><?=$form->text("webadm_title",array('class'=>'w99ps'))?><?=$form->error("webadm_title",'관리자 타이틀을 입력합시오')?></td><td>관리자 페이지 타이틀에 표시될 텍스트를 입력합니다.</td></tr>	
	<tr><th>관리자 로고</th><td>
	<?=$html->image($this->data['Site']['logo'])?><br />
	<?=$form->file("logo")?></td><td>관리자 페이지에 사용되는 로고파일을 설정합니다. 200*50 ( jpg,gif 만 가능합니다.)</td></tr>
	</table>
	<div class="btn-area gBtn gBtn1 floatright">	
		<a><span><?=$form->submit("저장",array())?></span></a>
	</div>	
	<?=$form->end()?>

<br class="clearboth" />

<?=$form->create("Level",array('url'=>'/webadm/setup/level'))?>
<table class='tbl-list'>
<tr>
<th>레벨번호</th>
<th>레벨명</th>
<th>기본 레벨명</th>

</tr>
<?php foreach($this->data['Level'] as $lv=>$ln):?>
	<tr>
	<td><?=$form->label('_'.$lv.'')?></td>
	<td><?=$form->text(null,array('name'=>'data[Level]['.$lv.']','value'=>$ln))?></td>
	<td><?=$form->label("_".$default_levels[$lv])?></td>

	</tr>
<?php endforeach?>
</table>
	<div class="btn-area gBtn gBtn1 floatright">
		<a><span><?=$form->submit("저장",array())?></span></a>
	</div>
<?=$form->end()?>




</div>