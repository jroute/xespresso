
<?=$html->css(array("/js/jquery/ui/smoothness/jquery-ui-1.8.2.smoothness",'/js/jquery/plugins/ptTimeSelect/jquery.ptTimeSelect','/poll/css/poll'));?>
<?=$javascript->link(array('jquery/ui/smoothness/jquery-ui-1.8.2.smoothness.min','/js/jquery/plugins/ptTimeSelect/jquery.ptTimeSelect'), false);?>

<style type="text/css">
#question {
	list-style:none;
	margin-left:20px;
	*margin-left:10px;
}
#question li.que {
	margin-bottom:10px;
}

</style>

<?=$javascript->link('jquery/plugins/jquery.jbind-1.5.8.min')?>
<?=$javascript->codeBlock("

$(function() {
		$('.datepicker').datepicker({dateFormat:'yy-mm-dd',showAnim:'slideDown'});

		
});

",array("inline"=>false))?>

<p class="pb20"><img src="/images/sub/sub04_con6_1.gif" alt="설문조사입니다." /></p>


	<?=$form->create('PollSetup',array('id'=>'PollForm','url'=>array('controller'=>'poll','action'=>$this->action),'onsubmit'=>'return on_submit()'))?>
	<?=$form->hidden('id')?>

	<?=$form->hidden("sdate")?>
	<?=$form->hidden("edate")?>
	
        <table class="table_style3" summary="게시판">
          <tbody>
            <tr>
              <td width="131" class="tdcolor1 blz"><strong>제목</strong></td>
              <td width="561" class="tl"><?=$this->data['PollSetup']['title']?></td>

            </tr>
            <tr>
              <td class="tdcolor1 blz"><strong>시작일</strong></td>
              <td class="tl"><?=substr($this->data['PollSetup']['sdate'],0,10)?></td>
            </tr>
            <tr>
              <td class="tdcolor1 blz"><strong>종료일</strong></td>

              <td class="tl"><?=substr($this->data['PollSetup']['edate'],0,10)?></td>
            </tr>
<tr>
              <td height="145" colspan="2" class="blz">



	<ul id="question">

<?php foreach($Questions as $idx=>$question):

?>
	<li class="que">

			<b><?=$idx+1?>. <?=$question['PollQuestion']['question']?></b>

			<ul>
			
			<?
			if( $question['PollQuestion']['type'] == 'O' ):

				foreach( $question['PollItem'] as $item ):
				
					if( $question['PollQuestion']['select_type'] == 'S' ){
						$chk =  "<input type='radio' class='inpchk poll-".$question['PollQuestion']['id']."' options='".($idx+1).",".$question['PollQuestion']['id'].",".$question['PollQuestion']['select_type']."' name='data[answer][".$question['PollQuestion']['id']."]' value='".$item['id']."' />";
					}else{
						$chk = "<input type='checkbox' class='inpchk poll-".$question['PollQuestion']['id']."' options='".($idx+1).",".$question['PollQuestion']['id'].",".$question['PollQuestion']['select_type'].",".$question['PollQuestion']['select_num']."' name='data[answer][".$question['PollQuestion']['id']."][]' value='".$item['id']."' />";
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


	</td>	</tr>
	</table>
	<p style="padding:5px;text-align:center">
	<a href="#content"><img src="/images/sub/btn_poll.gif" alt="투표" id="btn-vote" /></a>
	<a href="#content"><img src="/images/sub/btn_cancel.gif" alt="취소" id="btn-list"  /></a>
	</p>
	
	<?=$form->end()?>


<?=$skin_footer?>


<?=$javascript->codeBlock("


$(function(){

	$('#btn-list').click(function(){
		window.location.href='/poll/index';
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