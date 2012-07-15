<?=$paginator->options(array('url'=>array_merge(array('plugin'=>false),$this->passedArgs)));?>
<?=$html->css("/board/css/skins/".$setup['skin'],null,array('inline'=>false));?>
<?=$javascript->link("/board/js/webadm_board",false)?>

<div id="navigation-bar">
	<?=$this->element("board/webadm_navigation_bar");?>
</div>

<div id='top-tabs'>
</div>

<div id='content'>
	
	<div id='board-wrap'>

	
		<div>
			<div id='board-list-page' style="float:left;">
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

			<div id='board-list-category' style="float:right">
			<?php if( $setup['use_category'] ):?>
			<?=$form->create("Board",array('id'=>'SearchForm','url'=>array('plugin'=>false,'controller'=>$this->params['controller'],'action'=>$this->action,$bid),'type'=>'get'))?>
			<?=$form->select("category",$categories,null,array('empty'=>__(':: All ::',true),'onchange'=>"document.getElementById('SearchForm').submit()"))?>
			<?=$form->end();?>
			<?php endif?>
			</div>
		</div>
	
	
		<?=$form->create('Board',array('id'=>'form-list','style'=>'clear:both'))?>
		<?=$form->hidden('bid',array('value'=>$bid))?>
		<?=$form->hidden('movebid')?>
		<table class="tbl-list">
		<col width="25" />
		<col width="50" />
		<col width="*" />
		<col width="100" />
		<col width="120" />
		<col width="50" />
		<?php if( $setup['use_approve'] ):?><col width="60" /><?php endif;?>		
		<thead>
			<tr>
			<th><?=$form->checkbox('null',array('id'=>'allchk'))?></th>
			<th><?=$paginator->sort('번호','sort_no')?></th>
			<th><?=$paginator->sort('제목','subject')?></th>
			<th nowrap="nowrap"><?=$paginator->sort('작성자','name')?></th>
			<th><?=$paginator->sort('작성일','created')?></th>
			<th nowrap="nowrap"><?=$paginator->sort('조회수','hit')?></th>
			<?php if( $setup['use_approve'] ):?><th><?=$paginator->sort('승인','opt_approval')?></th><?php endif;?>
			</tr>
		</thead>
		<tbody>
		<?php if( count($datas) === 0 ):?>
		<tr><td colspan='8' height='50' align='center'>등록된 정보가 없습니다.</td></tr>
		<?php endif?>
		
	<?php foreach($nrows as $data):?>
	
			<tr>
			<td><?=$form->checkbox(null,array('name'=>'no[]','class'=>'allchk','value'=>$data['Board']['no']));?></td>
			<td>ⓝ</td>
			<td class='left'><?=$paginator->link($data['Board']['subject'],array('action'=>'view',$data['Board']['no']));?>
		<?php if( $data['Board']['total_comment'] != 0 ):?><span class='list-comment'>[<?=$data['Board']['total_comment']?>]</span><?php endif?>			
<?php if($setup['use_file'] && @$data['Fileattach']['name']):?><?=$html->image('/board/img/icons/'.$setup['skin_ext'].'/icon_disk_list.png',array('alt'=>@$data['Fileattach']['name'],'width'=>16,'height'=>16,'align'=>'middle'))?><?php endif?>
			
			</td>
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
			<td class='left'><?=$data['Board']['spacer']?><?=$paginator->link($data['Board']['subject'],array('action'=>'view',$data['Board']['no']));?>
		<?php if( $data['Board']['total_comment'] != 0 ):?><span class='list-comment'>[<?=$data['Board']['total_comment']?>]</span><?php endif?>
<?php if($setup['use_file'] && @$data['Fileattach']['name']):?><?=$html->image('/board/img/icons/'.$setup['skin_ext'].'/icon_disk_list.png',array('alt'=>@$data['Fileattach']['name'],'width'=>16,'height'=>16,'align'=>'middle'))?><?php endif?>
			
			</td>
			<td><?=$data['Board']['name']?></td>
			<td><?=str_replace('-','.',substr($data['Board']['created'],2,14))?></td>
			<td><?=$data['Board']['hit']?></td>
			<?php if( $setup['use_approve'] ):?>
				<td><span style="color:<?php if( $data['Board']['opt_approval'] ):?>blue<?php else:?>red<?php endif;?>"><?=$approval[$data['Board']['opt_approval']];?></td>
			<?php endif;?>		
			</tr>
		<?php endforeach;?>
		<tbody>
		</table>
		<?=$form->end();?>
		<div id="btn-area" class="gBtn1 floatright">
			
			<?php if( $setup['use_approve'] ):?>
				<?=$html->link('<span>승인/비승인</span>','#',array('class'=>'','escape'=>false,'id'=>'btn-approve'));?>
			<?php endif;?>
						
			<?=$html->link('<span>게시물 이동/복사</span>','#',array('class'=>'','escape'=>false,'id'=>'btn-move'));?>
			<?=$html->link('<span>삭제</span>','#',array('class'=>'','escape'=>false,'id'=>'btn-delete'));?>
									
			<?=$html->link('<span>글쓰기</span>',array('action'=>'write',$bid),array('class'=>'','escape'=>false));?>
		</div>
	
		<div id='paging-area'>
		<?=$paginator->prev($html->image('/board/img/skins/default/icon_prev.png'), array('style'=>'vertical-align:top','tag'=>'span','escape'=>false), 
		$html->image('/board/img/skins/default/icon_prev.png'), array('style'=>'vertical-align:top','tag'=>'span','class' => 'page-disabled','escape'=>false));?>
		<?=$paginator->numbers(); ?>
		<?=$paginator->next($html->image('/board/img/skins/default/icon_next.png'), array('style'=>'vertical-align:top','tag'=>'span','escape'=>false), 
		$html->image('/board/img/skins/default/icon_next.png'), array('style'=>'vertical-align:top','tag'=>'span','class' => 'page-disabled','escape'=>false));?>
		</div>
	
		
		<div id='search-area' class="gBtn1 gBtn">
		<?=$form->create("Board",array('url'=>array('plugin'=>false,'controller'=>'board','action'=>'lst',$bid),'type'=>'get'))?>
		<?php if( $setup['use_tag'] ):?><?=$form->checkbox("tag")?><?=$form->label("sfield0","키워드")?>&nbsp;<?php endif?>
		<div class="floatleft" style="margin:1px;">
		<?=$form->checkbox("ss",array('checked'=>'checked'))?><?=$form->label("sfield1","제목")?>&nbsp;
		<?=$form->checkbox("sc")?><?=$form->label("sfield2","내용")?>&nbsp;
		<?=$form->checkbox("sn")?><?=$form->label("sfield3","작성자")?>&nbsp;
		<?=$form->text("keyword",array('class'=>'txt'))?> 
		</div> 
		<a><span><?=$form->submit('검색',array('class'=>'','div'=>false,'align'=>'absmiddle'))?></span></a>
		<?=$form->end();?>
		</div>
	
	
	</div>

	
	
	<div id="move" style="display:none">
		<?=$form->create(null,array('id'=>'form-move','url'=>array('controller'=>'boards',"action"=>'move',$bid)))?>
		<table class='tbl'>
		<tr><th>선택한 게시물 수</th><td><span id='move-ea'>0</span> 개</td></tr>
		<tr><th>이동/복사 선택</th><td><?=$form->radio('mode',array('move'=>'이동','copy'=>'복사'),array('value'=>'move','class'=>'move-mode','legend'=>false))?></td></tr>
		<tr><th>게시판 선택</th><td><?=$form->select('bid',$BoardAll,null,array('id'=>'move-bid'),false)?></td></tr>
		</table>
		<?=$form->end()?>
	</div>	
</div>