<?=$html->css(array("/js/jquery/ui/smoothness/jquery-ui-1.8.2.smoothness",'/js/jquery/plugins/ptTimeSelect/jquery.ptTimeSelect'));?>
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


.graph {
	background:#FFCC33;
	height:5px;
	line-height:5px;
	font-size:5px;
	display:block;
}
</style>

<?=$javascript->link('jquery/plugins/jquery.jbind-1.5.8.min')?>
<?=$javascript->codeBlock("

$(function() {
		$('.datepicker').datepicker({dateFormat:'yy-mm-dd',showAnim:'slideDown'});

		
});

",array("inline"=>false))?>

<p class="pb20"><img src="/images/sub/sub04_con6_1.gif" alt="설문조사입니다." /></p>


	<?=$form->create('PollSetup',array('url'=>array('controller'=>'poll','action'=>$this->action),'onsubmit'=>'return on_submit()'))?>
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


	<ul id='question'>

<?php foreach($questions as $idx=>$question):

?>
	<li>

			<b><?=$idx+1?>. <?=$question['PollQuestion']['question']?></b>

			<ul>
			
			<?
			if( $question['PollQuestion']['type'] == 'O' ):

				foreach( $question['PollItem'] as $item ):
					$ps = round(($item['vote']/($item['total']?$item['total']:1))*100);
					$width = $ps/100*500;
					if( $width == 0 ) $width = 1;
				?>
				<li>
					<?=$item['item']?> <?if($item['etc']):?>(<span class='etc-list' id='<?=$question['PollQuestion']['type']?>-<?=$this->data['PollSetup']['id']?>-<?=$question['PollQuestion']['id']?>-<?=$item['id']?>'>기타 답변보기</span>)<?endif?> [ <?=$ps?>%, <?=$item['vote']?>/<?=$item['total']?> ]
					<br />
					<span class='graph' style='width:<?=$width?>px'></span>
				
				</li>
				<?endforeach;?>
			<?else:?>

			<span class='etc-list' id='<?=$question['PollQuestion']['type']?>-<?=$this->data['PollSetup']['id']?>-<?=$question['PollQuestion']['id']?>-<?=$item['id']?>'>답변보기</span>

			<?endif?>

			</ul>

	</li>
<?php endforeach;?>

	</ul>	

	</td>	</tr>
	</table>
	
	<p style="margin:5px;text-align:center">
		<img src="/images/sub/btn_list.gif" alt="목록"  id="btn-back" style='cursor:pointer' />
	</p>
	
	<?=$form->end()?>
	

<div id='dialog' title="결과보기"></div>

<?=$skin_footer?>

<?=$javascript->codeBlock("


$(function(){

	$('#btn-back').click(function(){
		window.history.back();
	});

	$('.etc-list').click(function(){
		
		qtype	= $(this).attr('id').split('-')[0];
		pid		= $(this).attr('id').split('-')[1];
		qid		= $(this).attr('id').split('-')[2];
		iid			= $(this).attr('id').split('-')[3];
		var now = new Date();
		$('#dialog').dialog({
			modal:true,
			width:700,
			height:500,
			open:function(){
				$.ajax({
					url:'/poll/itemetc/' + pid + '/' + qtype + '/' + qid + '/' + iid + '/' + now.getTime(),
					success:function(data){
						$('#dialog').html(data);
					}
				});
			},
			close:function(){
				$('#dialog').dialog('destroy');
			}
		});
	});

});


",array('inline'=>false))?>