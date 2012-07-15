<?=$javascript->link("webadm/boards",false)?>
<?=$paginator->options(array('url' =>(count($this->passedArgs)  ? $this->passedArgs:$bid)));?>



<?=$javascript->codeBlock("

$(function(){
	//전체 체크
	$('#allchk').click(function(){
		var _this = $(this);

		$('.allchk').each(function(index){
		
			if( _this.is(':checked') == true ){
				$(this).attr('checked',true);
			}else{

				$(this).attr('checked',false);
			}
		});

	});
	
});

",array("inline"=>false));?>

<?=$html->css("/board/css/skins/".$setup['skin'],null,array('inline'=>false));?>
<div id="navigation-bar">
	<?=$this->element("board/webadm_navigation_bar");?>
</div>

<div id='top-tabs'>
</div>

<div id='content'>


<div id='board-wrap'>

	<div id='board-list'>

	<div id='board-list-top'>


		<div id='board-list-page'>
		<span class="page-info">
			<?php $vno = $paginator->counter('%count%')-($paginator->counter('%page%')-1)*$setup['list_rows'];?>
			<?=$paginator->counter(array('format' => 'Total : %count%, Page : %page%/%pages%'));?>
		</span>
		
		<span class="list-type">
			<?=$html->link('List',"lst/$bid?ls=L",array('class'=>'ls-list'));?>
			<?=$html->link('Thumbnail',"lst/$bid?ls=T",array('class'=>'ls-thumb'));?>
			<?=$html->link('Gallery',"lst/$bid?ls=G",array('class'=>'ls-gallery'));?>
		</span>
		</div>

		
		<div id='board-list-category'>
		<?php if( $setup['use_category'] ):?>
		<?=$form->create("Board",array('id'=>'SearchForm','url'=>array("action"=>$this->action,$bid),'type'=>'get'))?>
		<?=$form->select("category",$categories,null,array('onchange'=>"document.getElementById('SearchForm').submit()"))?>
		<?=$form->end();?>
		<?php endif?>
		</div>


	</div>

	<?=$form->create('Board',array('id'=>'form-list'))?>
	<?=$form->hidden('bid',array('value'=>$bid))?>
	<table class="tbl-list">
	<col width="25" />
	<col width="50" />
	<col width="50" />
	<col width="*" />
	<col width="100" />
	<col width="100" />
	<col width="50" />
	<?php if( $setup['use_approve'] ):?><col width="60" /><?php endif;?>			
	<thead>
		<tr>
		<th><?=$form->checkbox('null',array('id'=>'allchk'))?></th>
		<th><?=$paginator->sort('번호','sort_no')?></th>
		<th>이미지</th>
		<th><?=$paginator->sort('제목','subject')?></th>
		<th nowrap="nowrap"><?=$paginator->sort('작성자','name')?></th>
		<th><?=$paginator->sort('작성일','created')?></th>
		<th nowrap="nowrap"><?=$paginator->sort('조회수','hit')?></th>
		<?php if( $setup['use_approve'] ):?><th><?=$paginator->sort('승인','opt_approval')?></th><?php endif;?>		
		</tr>
	</thead>
	<tbody>
	<?php if( count($datas) === 0 ):?>
	<tr><td colspan='7' height='60' class='aligncenter'>등록된 데이터가 없습니다.</td></tr>
	<?php endif?>
	
		
	<?php foreach($nrows as $data):?>
	
			<tr>
			<td><?=$form->checkbox(null,array('name'=>'no[]','class'=>'allchk','value'=>$data['Board']['no']));?></td>
			<td>ⓝ</td>
			<td><?php if( @$data['BoardFile']['thumb'] ): echo $html->image($data['BoardFile']['thumb']); endif;?></td>
			<td class='left'><?=$paginator->link($data['Board']['subject'],array('plugin'=>false,'action'=>'view',$data['Board']['no']));?></td>
			<td><?=$data['Board']['name']?></td>
			<td><?=str_replace('-','.',substr($data['Board']['created'],2,14))?></td>
			<td><?=$data['Board']['hit']?></td>
			<?php if( $setup['use_approve'] ):?>
				<td><span style="color:<?php if( $data['Board']['opt_approval'] ):?>blue<?php else:?>red<?php endif;?>"><?=$approval[$data['Board']['opt_approval']];?></td>
			<?php endif;?>			
			</tr>
			
	<?php endforeach;?>
	
		
	<?php foreach($datas as $data):?>
		<tr>
		<td><?=$form->checkbox(null,array('name'=>'no[]','class'=>'allchk','value'=>$data['Board']['no']));?></td>
		<td><?=@$vno--?></td>
		<td><?php if( @$data['BoardFile']['thumb'] ): echo $html->image($data['BoardFile']['thumb']); endif;?></td>
		<td class='left'><?=$paginator->link($data['Board']['subject'],array('plugin'=>false,'action'=>'view',$data['Board']['no']))?></td>
		<td><?=$data['Board']['name']?></td>
		<td><?=substr($data['Board']['created'],2,14)?></td>
		<td><?=$data['Board']['hit']?></td>
		<?php if( $setup['use_approve'] ):?>
			<td><span style="color:<?php if( $data['Board']['opt_approval'] ):?>blue<?php else:?>red<?php endif;?>"><?=$approval[$data['Board']['opt_approval']];?></td>
		<?php endif;?>			
		</tr>
	<?php endforeach;?>
	<tbody>
	</table>
	<?=$form->end();?>

	<div id='btn-area' class="gBtn1 floatright">
	
			<?php if( $setup['use_approve'] ):?>
				<?=$html->link('<span>승인/비승인</span>','#',array('class'=>'','escape'=>false,'id'=>'btn-approve'));?>
			<?php endif;?>
						
			<?=$html->link('<span>게시물 이동/복사</span>','#',array('class'=>'','escape'=>false,'id'=>'btn-move'));?>
				
	<?=$html->link('<span>삭제</span>','#',array('id'=>'btn-delete','class'=>'','escape'=>false));?>
	<?=$html->link('<span>글쓰기</span>',array('action'=>'write',$bid),array('class'=>'','escape'=>false));?>
	</div>


	<div id='paging-area' class="clearboth">
	<?=$paginator->prev($html->image('boards/skins/'.$setup['skin'].'/icon_prev.png'), array('tag'=>'span','escape'=>false), $html->image('boards/skins/'.$setup['skin'].'/icon_prev.png'), array('tag'=>'span','class' => 'page-disabled','escape'=>false));?>
	<?=$paginator->numbers(); ?>
	<?=$paginator->next($html->image('boards/skins/'.$setup['skin'].'/icon_next.png'), array('tag'=>'span','escape'=>false), $html->image('boards/skins/'.$setup['skin'].'/icon_next.png'), array('tag'=>'span','class' => 'page-disabled','escape'=>false));?>
	</div>
	</div>

</div>


</div>