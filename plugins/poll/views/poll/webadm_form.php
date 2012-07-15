<?=$javascript->link(array(
			'jquery/plugins/jquery.jbind-1.5.8.min',
			'jquery/plugins/ptTimeSelect/jquery.ptTimeSelect',
			'/poll/js/poll')
,false)?>
<?=$html->css(array('/js/jquery/plugins/ptTimeSelect/jquery.ptTimeSelect.css','/poll/css/default'),null,array('inline'=>false));?>
			
			
<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>

<style type="text/css">
#question {
	list-style:none;
	margin-left:-30px;
	*margin-left:10px;
}
#question li.que {
	margin-bottom:10px;
}

</style>

<div id="log">

</div>
<div id="content">

<h1>설문 추가</h1>

	<?=$form->create('PollSetup',array('url'=>array('controller'=>'poll','action'=>$this->action),'onsubmit'=>'return on_submit()'))?>
	<?=$form->hidden('id')?>

	<?=$form->hidden("sdate")?>
	<?=$form->hidden("edate")?>
	<table class='tbl'>
	<col width='15%' />
	<col width='40%' />
	<col width='45%' />
	<tr><th>제목</th><td colspan='3'><?=$form->text("title",array('size'=>'80'))?><?=$form->error("title",'제목을 입력하십시오')?></td></tr>
	<tr><th>시작일</th><td>
			<?php @list($sdate,$stime) = @explode(" ", @$this->data['PollSetup']['sdate']);?>
			날짜 : <input type='text' name='sdate' id='sdate' size='10' value="<?=$sdate?>" class="datepicker" />
			시간 : <input type='text' name='stime' id='stime' size='5' value="<?=substr($stime,0,5)?>"  class="timepicker" />

<?=$form->error("sdate",'시작일을 입력하십이오')?></td><td>시간은 [HH:MM] 형식으로 입력하십시오</td></tr>
	<tr><th>종료일</th><td>
			<?php @list($edate,$etime) = explode(" ", $this->data['PollSetup']['edate']);?>
			날짜 : <input type='text' name='edate' id='edate' size='10' value="<?=$edate?>" class="datepicker"  />
			시간 : <input type='text' name='etime' id='etime' size='5' value="<?=substr($etime,0,5)?>"  class="timepicker"  />

	<?=$form->error("edate",'종료일을 입력하십이오')?></td><td>시간은 [HH:MM] 형식으로 입력하십시오</td></tr>

	<tr><th>오픈</th><td><?=$form->input("open",array('type'=>'radio','legend'=>false,'options'=>array('Y'=>'오픈','N'=>'닫힘'),'default'=>'Y'))?></td><td></td></tr>
	<tr><td colspan="3">
	<span id='q-add' class='hand'><img src="/poll/img/icon-add.png" alt="추가" /></span>
	<span id='q-del' class='hand'><img src="/poll/img/icon-del.png" alt="삭제" /></span>

	<ul id="question">

<?php foreach($Questions as $idx=>$question):
?>
	<li id='q-<?=$idx?>' class='que'>
	<?=$form->hidden(null,array('name'=>'data[PollQuestion]['.$idx.'][sort]','value'=>$idx));?>
	<table class='tbl'>
	<col width='15%' />
	<col width='85%' />
	<tr><th>옵션</th><td><?=$form->select(null,array('O'=>'객관식','S'=>'주관식'),$question['PollQuestion']['type'],array('name'=>'data[PollQuestion]['.$idx.'][type]','id'=>'type-'.$idx,'class'=>'qtype'),false)?> 
	<span id='select-options-<?=$idx?>'>
	<?=$form->select(null,array('S'=>'단일선택','M'=>'다중선택'),$question['PollQuestion']['select_type'],array('name'=>'data[PollQuestion]['.$idx.'][select_type]','id'=>'select_type-'.$idx,'class'=>'qselecttype'),false)?> 
		<span id='select-num-<?=$idx?>' style='display:<?if( $question['PollQuestion']['select_type'] == 'S' ): echo 'none'; else: echo 'inline'; endif?>'>
		<?=$form->select(null,array('2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10'),$question['PollQuestion']['select_num'],array('name'=>'data[PollQuestion]['.$idx.'][select_num]','id'=>'select_num-'.$idx),false)?> 개 다중 선택가능
		</span>
	</span>
	</td></tr>
	<tr><th> <a href="javascript:void(0)" class="del-que" id="qdel-<?=$idx+1?>"><img src="/poll/img/icon-del.png" alt="삭제" /></a> 질문 #<?=$idx+1?></th><td>
	<?=$form->hidden(null,array('name'=>'data[PollQuestion]['.$idx.'][qid]','value'=>$question['PollQuestion']['id'],'id'=>'sort-'.$idx))?>
	<?=$form->text(null,array('name'=>'data[PollQuestion]['.$idx.'][question]','value'=>$question['PollQuestion']['question'], 'class'=>'w99ps'))?></td></tr>
	<tr id='items-<?=$idx?>' <?if( $question['PollQuestion']['type'] == 'S' ): echo "style='display:none'"; endif?>><th>답변<br /><a href="javascript:void(0)" class="add-item" id="add-<?=$idx?>"><img src="/poll/img/icon-add.png" alt="추가" /></a> <a href="javascript:void(0)" class="del-item" id="del-<?=$idx?>"><img src="/poll/img/icon-del.png" alt="삭제" /></a></th><td>
		<ul id="item-list-<?=$idx?>">
		<?
			if( $question['PollQuestion']['type'] == 'O' ):

				foreach( $question['PollItem'] as $i=>$item ):
				?>
				<li>
				<input name='data[PollQuestion][<?=$idx?>][itemid][]' type='hidden' value="<?=$item['id']?>"  /> 

				<input name='data[PollQuestion][<?=$idx?>][items][]' type='text' size='40' value="<?=$item['item']?>"  /> 
				<input type='checkbox' name='data[PollQuestion][<?=$idx?>][itemetc][<?=$i?>]' value='1' <?if( $item['etc'] ):?>checked="checked"<?endif;?> />추가입력</li>
				<?endforeach;?>
			<?endif;?>
			</ul>
	</td></tr>
	</table>

	</li>
<?php endforeach;?>
	</ul>	

	</td>	</tr>
	</table>
	<div id="btn-area" class="floatright gBtn gBtn1">
	<a><span><?=$form->submit("저장",array('div'=>false, 'class'=>'button'))?></span></a>
	<a><span><?=$form->button("목록",array('class'=>'button','type'=>'button','id'=>'btn-list'))?></span></a>
	</div>
	<?=$form->end()?>


</div>

<div id="template" style="display:none">
	<!--data-->
	<input type="hidden" id="PollSetupOpen" value="{n}" name="data[PollQuestion][{n}][sort]" id="sort-{n}">	
	<table class='tbl'>
	<col width='15%' />
	<col width='85%' />
	<tr><th>옵션</th><td><?=$form->select(null,array('O'=>'객관식','S'=>'주관식'),null,array('name'=>'data[PollQuestion][{n}][type]','id'=>'type-{n}','class'=>'qtype','empty'=>false))?> 
	<span id='select-options-{n}'>
	<?=$form->select(null,array('S'=>'단일선택','M'=>'다중선택'),null,array('name'=>'data[PollQuestion][{n}][select_type]','id'=>'select_type-{n}','class'=>'qselecttype','empty'=>false))?> 
		<span id='select-num-{n}' style='display:none'>
		<?=$form->select(null,array('2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10'),null,array('name'=>'data[PollQuestion][{n}][select_num]','id'=>'select-num-{n}','empty'=>false))?> 개 다중 선택가능
		</span>
	</span>
	</td></tr>
	<tr><th> <a href="javascript:void(0)" class="del-que" id="qdel-{qn}"><img src="/poll/img/icon-del.png" alt="삭제" /></a> 질문 #{qn}</th><td><?=$form->text(null,array('name'=>'data[PollQuestion][{n}][question]','class'=>'w99ps'))?></td></tr>
	<tr id='items-{n}'><th>답변<br /><a href="javascript:void(0)" class="add-item" id="add-{n}"><img src="/poll/img/icon-add.png" alt="추가" /></a> <a href="javascript:void(0)" class="del-item" id="del-{n}"><img src="/poll/img/icon-del.png" alt="삭제" /></a></th><td>
		<ul id="item-list-{n}"><li><input name='data[PollQuestion][{n}][items][0]' type='text' size='40' value=''  /> <input type='checkbox' name='data[PollQuestion][{n}][itemetc][0]' value='1' />추가입력</li></ul>
	</td></tr>
	</table>
	<!--data-->
</div>

<?=$javascript->codeBlock("

var idx = ".@count($Questions).";


//load event;
$(function(){

	$('#btn-list').click(function(){
		window.location.href = '/webadm/poll/index';
	});

	var template = $('#template').html();

".((@$this->data['PollSetup']['id']) ? "":
	"$('#question').append($(\"<li id='q-\" + idx + \"' class='que'></li>\"));

	$(template.replace(/{n}/g,idx++).replace(/{qn}/g,idx)).appendTo('#q-'+(idx-1));
	
	")."

	$('#q-add').click(function(){
//		var node = $(template).bindTo({n:idx++,qn:idx});

		$('#question').append($(\"<li id='q-\" + idx + \"' class='que'></li>\"));
		$(template.replace(/{n}/g,idx).replace(/{qn}/g,idx+1)).appendTo('#q-'+idx);
		idx++;		
		setEvent();

	});




	setEvent();

});

",array('inline'=>false))?>