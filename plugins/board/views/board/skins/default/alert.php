
<?=$html->css("/board/css/skins/".$setup['skin']);?>
<div id='board-wrap'>

	<?=$setup['skin_header']?>

	<div id='board-confirm-wrap'>
	

	<h4 class='confirm-title'>확인</h4>

		<table class="tbl-board-view">
	<caption><?=__('alert')?></caption>		
		<col width="80" />
		<col width="*" />
			<tr><th>메시지</th><td><?=$msg?></td></tr>
		</table>


		<div id='btn-area'>
			<?=$html->link(__('confirm',true),$return_url, array('class'=>'button','escape'=>false));?>
			<?=$html->link(__('list',true),array('plugin'=>false,'action'=>'lst',$bid), array('class'=>'button','escape'=>false));?>
		</div>

	</div>

	<?=$setup['skin_footer']?>

</div>