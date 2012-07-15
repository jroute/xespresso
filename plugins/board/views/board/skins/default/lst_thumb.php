<?php $paginator->options(array('url' =>array_merge($this->passedArgs,array('plugin'=>false,'action'=>'lst'))));?>


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
		<?=$form->create("Board",array('id'=>'SearchForm','url'=>array('controller'=>$this->params['controller'],"action"=>'lst',$bid),'type'=>'get','style'=>'float:left'))?>
		<?=$form->select("category",$categories,null,array('onchange'=>"document.getElementById('SearchForm').submit()"))?>
		<?=$form->end();?>
		<?php endif?>
		<?php if( $setup['use_rss'] ):?>
		<?=$html->link($html->image('/board/img/icons/'.$setup['skin_icon'].'/rss.png'),'rss/'.$bid,array('escape'=>false,'style'=>'float:left;'));?>
		<?php endif?>
		</div>


	</div>


	<table class="tbl-board-list">
	<caption><?=__('list')?></caption>	
	<col width="50" />
	<col width="50" />
	<col width="*" />
	<col width="100" />
	<col width="100" />
	<col width="50" />
	<thead>
		<tr>
		<th>번호</th>
		<th>이미지</th>
		<th>제목</th>
		<th>작성자</th>
		<th>작성일</th>
		<th>읽은수</th>
		</tr>
	</thead>
	<tbody>
	<?php if( count($rows) === 0 ):?>
	<tr><td colspan='6' height='60' class='aligncenter'>등록된 데이터가 없습니다.</td></tr>
	<?php endif?>
	<?php foreach($rows as $data):

	?>
		<tr>
		<td><?=@$vno--?></td>
		<td><?php if( @$data['Fileattach']['thumb'] ): echo $html->image($data['Fileattach']['thumb']); endif;?></td>
		<td class='alignleft'><?=$paginator->link($data['Board']['subject'],array('action'=>'view',$data['Board']['no']))?>
<?php if( $data['Board']['total_comment'] != 0 ):?><span class="total-comment">[<?=$data['Board']['total_comment']?>]</span><?php endif?>
		<?php if($setup['use_file'] && @$data['Fileattach']['name']):?><?=$html->image('/board/img/icons/'.$setup['skin_ext'].'/icon_disk_list.png',array('alt'=>@$data['Fileattach']['name'],'width'=>16,'height'=>16))?><?php endif?>
<?php if( substr($data['Board']['created'],0,10) >= date('Y-m-d',time()-86400*7) ):?><span class="new"><?=$html->image('/board/img/icons/'.$setup['skin_icon'].'/icon_new.gif')?></span><?php endif;?>		
		
		</td>
		<td><?=$data['Board']['name']?></td>
		<td><?=substr($data['Board']['created'],2,14)?></td>
		<td><?=$data['Board']['hit']?></td>
		</tr>
	<?php endforeach;?>
	<tbody>
	</table>


	<div id='btn-area'>
	<?php if( (int)$session->Read('User.level') >= $level['lv_write'] ):?>
	<?=$html->link(__('write',true),array('plugin'=>false,'action'=>'write',$bid),array('class'=>'button'));?>
	<?php endif;?>
	</div>


	<div id='paging-area'>
	<?=$paginator->prev($html->image('/board/img/skins/'.$setup['skin'].'/icon_prev.png'), array('tag'=>'span','escape'=>false), $html->image('/board/img/skins/'.$setup['skin'].'/icon_prev.png'), array('tag'=>'span','class' => 'page-disabled','escape'=>false));?>
	<?=$paginator->numbers(); ?>
	<?=$paginator->next($html->image('/board/img/skins/'.$setup['skin'].'/icon_next.png'), array('tag'=>'span','escape'=>false), $html->image('/board/img/skins/'.$setup['skin'].'/icon_next.png'), array('tag'=>'span','class' => 'page-disabled','escape'=>false));?>
	</div>
	</div>

