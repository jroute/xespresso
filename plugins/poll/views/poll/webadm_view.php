
<?=$html->css(array("/js/jquery/ui/smoothness/jquery-ui-1.8.2.smoothness",'/js/jquery/plugins/ptTimeSelect/jquery.ptTimeSelect','/poll/css/default'));?>

<script type="text/javascript" src="/js/jquery/plugins/ptTimeSelect/jquery.ptTimeSelect.js"></script>

<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>


<?=$javascript->link('jquery/plugins/jquery.jbind-1.5.8.min')?>
<?=$javascript->codeBlock("

$(function() {
		$('.datepicker').datepicker({dateFormat:'yy-mm-dd',showAnim:'slideDown'});

		
});

",array("inline"=>false))?>

<div id="content">

<h1>팝업 추가</h1>


	<?=$form->create('PollSetup',array('id'=>'PollForm','url'=>array('controller'=>'poll','action'=>$this->action),'onsubmit'=>'return on_submit()'))?>
	<?=$form->hidden('id')?>

	<?=$form->hidden("sdate")?>
	<?=$form->hidden("edate")?>
	<table class='tbl'>
	<col width='15%' />
	<col width='85%' />
	<tr><th>제목</th><td><?=$this->data['PollSetup']['title']?></td></tr>
	<tr><th>시작일</th><td><?=$this->data['PollSetup']['sdate']?></td></tr>
	<tr><th>종료일</th><td><?=$this->data['PollSetup']['edate']?></td></tr>
	<tr><th>참여인원</th><td><?=$persons?> 명</td></tr>		
	<tr><th>오픈</th><td><?=$this->data['PollSetup']['open'] == 'Y' ? '공개':'비공개'?></td><td></td></tr>
	<tr><td colspan="2">

	<ul id='question'>

<?php foreach($Questions as $idx=>$question):

?>
	<li class="que">

			<b><?=$idx+1?>. <?=$question['PollQuestion']['question']?></b>

			<ul>
			
			<?
			if( $question['PollQuestion']['type'] == 'O' ):

				foreach( $question['PollItem'] as $item ):
				
					if( $question['PollQuestion']['select_type'] == 'S' ){
						$chk =  "<input type='radio' class='poll-".$question['PollQuestion']['id']."' options='".($idx+1).",".$question['PollQuestion']['id'].",".$question['PollQuestion']['select_type']."' name='data[answer][".$question['PollQuestion']['id']."]' value='".$item['id']."' />";
					}else{
						$chk = "<input type='checkbox' class='poll-".$question['PollQuestion']['id']."' options='".($idx+1).",".$question['PollQuestion']['id'].",".$question['PollQuestion']['select_type'].",".$question['PollQuestion']['select_num']."' name='data[answer][".$question['PollQuestion']['id']."][]' value='".$item['id']."' />";
					}
				?>
				<li><?=$chk?> <?=$item['item']?>
				<?if($item['etc']):?>(<input type='text' name='data[answeretc][<?=$question['PollQuestion']['id']?>][<?=$item['id']?>]' size="15" id="answeretc-<?=$question['PollQuestion']['id']?>-<?=$item['id']?>" />)<?endif?>
				</li>
				<?endforeach;?>
			<?else:?>

			<textarea style='width:90%;height:40px' class="poll-<?=$question['PollQuestion']['id']?>" options="<?=($idx+1).",".$question['PollQuestion']['id'].",T,".$question['PollQuestion']['select_num']?>" name='data[answer][<?=$question['PollQuestion']['id']?>]'></textarea>

			<?endif?>

			</ul>

	</li>
<?php endforeach;?>

	</ul>	


	<div class="margin5 center">
	<?=$form->button("투표",array('type'=>'button','id'=>'btn-vote','class'=>'button'))?>
	<?=$form->button("결과",array('type'=>'button','id'=>'btn-result','class'=>'button'))?>	
	</div>

	</td>	</tr>
	</table>

	<?=$form->end()?>


</div>

	<div class="floatright gBtn gBtn1">
		<a><span><?=$form->button("목록",array('type'=>'button','id'=>'btn-list','class'=>'button'))?></span></a>
		<a><span><?=$form->button("수정",array('type'=>'button','id'=>'btn-edit','class'=>'button'))?></span></a>
	</div>


<?=$javascript->codeBlock("


$(function(){

	$('#btn-list').click(function(){
		window.location.href='/webadm/poll/index';
	});
	$('#btn-result').click(function(){
		window.location.href='/webadm/poll/result/".$this->data['PollSetup']['id']."';
	});	

	$('#btn-edit').click(function(){
		window.location.href='/webadm/poll/edit/{$this->data['PollSetup']['id']}';
	});

		
	$('#btn-vote').click(function(){

		validate = true;
		before_class = null;

		$('[class^=poll]').each(function(){
			var _this = $(this);
			var options = _this.attr('options').split(',');

			if( before_class == _this.attr('class') ) return true;

			var chk = false;
			var cnt = 0;
			$('.poll-' + options[1]).each(function(index){
				if( options[2] == 'S' ){
					if($(this).is(':checked') == true ) chk = true;
				}else if( options[2] == 'M' ){
					if($(this).is(':checked') == true ) cnt++;
				}
			});

			if( _this.is(':checked') == true ){
				if( $('#answeretc-' + options[1] + '-' + _this.val()).is('input') == true && $('#answeretc-' + options[1] + '-' + _this.val()).val() == '' ){
					window.alert( options[0] + '번 질문 추가 항목을 입력하십시오');
					$('#answeretc-' + options[1] + '-' + _this.val()).focus();
					validate = false;
					return false;
				}	
			}

			if(  options[2] == 'S'  && chk == false ){
				before_class = 'poll-' + options[1];
				window.alert( options[0] + '번 질문에 답하세요');
				validate = false;
				return false;
			}else if( options[2] == 'M' ){
				if( cnt != options[3] ){
					before_class = 'poll-' + options[1];
					window.alert( options[0] + '번 질문은 ' + options[3] + '개 항목을 선택하십시오' );
					validate = false;
					return false;
				}
			}else if( options[2] == 'T' ){
				if( $(this).val() == '' ){
					window.alert( options[0] + '번 질문에 답하세요');
					validate = false;
					return false;
				}
			}

		});

		if( validate == true ){
			$.ajax({
				url:'/poll/vote/{$this->data['PollSetup']['id']}',
				type:'POST',
				data:$('#PollForm').serialize(),
				success:function(data){
					alert(data);
				}
			});
		}

	});
});


",array('inline'=>false))?>