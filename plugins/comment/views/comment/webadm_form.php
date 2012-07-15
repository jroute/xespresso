<?=$javascript->link('fckeditor/fckeditor')?>


<link rel="stylesheet" type="text/css" href="/js/jquery/plugins/ptTimeSelect/jquery.ptTimeSelect.css" />

<script type="text/javascript" src="/js/jquery/plugins/ptTimeSelect/jquery.ptTimeSelect.js"></script>

<?=$javascript->codeBlock("

$(function() {
		$('.datepicker').datepicker({dateFormat:'yy-mm-dd',showAnim:'slideDown'});

		
});

",array("inline"=>false))?>

<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>

<div id="top-tab">
	<div id="ctab">
		<ul class='ul-tab'>
		<li><?=$html->link('팝업목록','index')?></li>
		<li class='active'><?=$html->link('팝업추가','add')?></li>
		</ul>
	</div>
</div>

<div id="content">


	<?=$form->create('Popup',array("url"=>$this->here,'onsubmit'=>'return on_submit()'))?>
	<?=$form->hidden('id')?>
	<?=$form->hidden("dimensions")?>

	<?=$form->hidden("sdate")?>
	<?=$form->hidden("edate")?>
	<table class='tbl'>
	<col width='15%' />
	<col width='40%' />
	<col width='45%' />
	<tr><th>제목</th><td colspan='3'><?=$form->text("title",array('size'=>'80'))?><?=$form->error("title",'제목을 입력하십시오')?></td></tr>
	<tr><th>오픈일</th><td>
<?php list($sdate,$stime) = explode(" ", $this->data['Popup']['sdate']);?>
날짜 : <input type='text' name='sdate' id='sdate' size='10' value="<?=$sdate?>" class="datepicker" />
시간 : <input type='text' name='stime' id='stime' size='5' value="<?=$stime?>"  class="timepicker" />

</td><td>시간은 [HH:MM] 형식으로 입력하십시오</td></tr>
	<tr><th>종료일</th><td>
<?php list($edate,$etime) = explode(" ", $this->data['Popup']['edate']);?>
날짜 : <input type='text' name='edate' id='edate' size='10' value="<?=$edate?>" class="datepicker"  />
시간 : <input type='text' name='etime' id='etime' size='5' value="<?=$etime?>"  class="timepicker"  />

</td><td>시간은 [HH:MM] 형식으로 입력하십시오</td></tr>

	<tr><th>좌표 & 사이즈</th><td>
	<?php list($x,$y,$w,$h) = explode(",", $this->data['Popup']['dimensions']);?>

	<span style='word-spacing:16px;'>X :</span> <input type='text' name='x' id='x' size='2' value="<?=$x?>" />px , 
	<span style='word-spacing:16px;'>Y :</span> <input type='text' name='y' id='y' size='2' value="<?=$y?>"  />px
<br />
	가로 : <input type='text' name='w' id='width' size='2' value="<?=$w?>"  />px , 
	세로 : <input type='text' name='h' id='height' size='2' value="<?=$h?>"  />px
	<?=$form->error("dimensions",'좌표 및 사이즈를 입력하십이오')?></td><td>좌표 값과 창 크기를 입력하십시오</td></tr>
	<tr><th>오픈</th><td><?=$form->radio("state",array('Y'=>'오픈','N'=>'닫힘'),array('legend'=>false))?></td><td></td></tr>
	<tr><th>스크롤바</th><td><?=$form->radio("scrollbars",array('1'=>'보임','0'=>'숨김'),array('legend'=>false))?></td><td></td></tr>

	<tr><td colspan="3"><?=$form->textarea("content",array('id'=>'pcontent'))?>
	<?php echo $editor->load('ckeditor','pcontent'); ?> 
	<?=$form->error('content','* 내용을 입력하십시오')?>
	</td>	</tr>
	</table>
	<?=$form->submit("확인",array('class'=>'button'))?>
	<?=$form->end()?>


</div>

<?=$javascript->codeBlock("

function on_submit(){

	$('#PopupDimensions').val( $('#x').val() + ',' + $('#y').val() + ',' + $('#width').val() + ',' + $('#height').val() );

	$('#PopupSdate').val( $('#sdate').val() + ' ' + $('#stime').val() );
	$('#PopupEdate').val( $('#edate').val() + ' ' + $('#etime').val() );

	$('#PopupWebadmEditForm').submit();
}

",array('inline'=>false))?>