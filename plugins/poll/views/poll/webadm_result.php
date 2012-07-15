<?=$html->css(array("/js/jquery/ui/smoothness/jquery-ui-1.8.2.smoothness",'/js/jquery/plugins/ptTimeSelect/jquery.ptTimeSelect','/poll/css/webadm'));?>

<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>


<div id="content">

<h1>설문 결과</h1>


	<table class='tbl'>
	<col width='15%' />
	<col width='85%' />
	<tr><th>제목</th><td><?=$this->data['PollSetup']['title']?></td></tr>
	<tr><th>시작일</th><td><?=substr($this->data['PollSetup']['sdate'],0,16)?></td></tr>
	<tr><th>종료일</th><td><?=substr($this->data['PollSetup']['edate'],0,16)?></td></tr>
	<tr><th>참여인원</th><td><?=$persons?> 명</td></tr>	
	<tr><th>오픈</th><td><?=$this->data['PollSetup']['open'] == 'Y' ? '공개':'비공개'?></td></tr>
	<tr><td colspan="2">

	<ul id='question'>

<?php foreach($questions as $idx=>$question):

?>
	<li class="que">

			<b><?=$idx+1?>. <?=$question['PollQuestion']['question']?></b>

			<ul>
			
			<?
			if( $question['PollQuestion']['type'] == 'O' ):

				foreach( $question['PollItem'] as $item ):
					$ps = @round(($item['vote']/$item['total'])*100);
					$width = $ps/100*500;
				?>
				<li>
					<?=$item['item']?> <?php if($item['etc']):?>(<span class='etc-list' id='<?=$question['PollQuestion']['type']?>-<?=$this->data['PollSetup']['id']?>-<?=$question['PollQuestion']['id']?>-<?=$item['id']?>'>기타 답변보기</span>)<?php endif?> [ <?=$ps?>%, <?=$item['vote']?>/<?=$item['total']?> ]
					<br />
					<span class='graph' style='width:<?=$width?>px'></span>
				
				</li>
				<?php endforeach;?>
			<?php else://주관식?>

			<span class='etc-list' id='<?=$question['PollQuestion']['type']?>-<?=$this->data['PollSetup']['id']?>-<?=$question['PollQuestion']['id']?>-'>답변보기</span>

			<?php endif?>

			</ul>

	</li>
<?php endforeach;?>

	</ul>	

	</td>	</tr>
	</table>

</div>
	<div class='content-bar'>
		<?=$form->button("이전",array('id'=>'btn-back','class'=>'button'))?>
	</div>


<div id='dialog' title="결과보기"></div>

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

		$('#dialog').dialog({
			modal:true,
			width:700,
			height:500,
			open:function(){
				$.ajax({
					url:'/webadm/poll/itemetc/' + pid + '/' + qtype + '/' + qid + '/' + iid,
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