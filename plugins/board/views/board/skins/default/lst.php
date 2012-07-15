<?=$this->element("board/profile",array('position'=>'left','align'=>'top','tail'=>'top'));?>

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
		<?=$form->select("category",$categories,null,array('empty'=>__(':: Category ::',true),'onchange'=>"document.getElementById('SearchForm').submit()"))?>
		<?=$form->end();?>
		<?php endif;?>
		<?php if( $setup['use_rss'] ):?>
		<?=$html->link($html->image('/board/img/icons/'.$setup['skin_icon'].'/rss.png'),'rss/'.$bid,array('escape'=>false,'style'=>'float:left;'));?>
		<?php endif?>
		</div>


	</div>


	<table class="tbl-board-list">
	<caption><?=__('list')?></caption>	
	<col width="50" />
	<col width="*" />
	<col width="100" />
	<col width="80" />
	<col width="45" />
	<thead>
		<tr>
		<th><?=$paginator->sort(__('num',true),'sort_no',array('url'=>array('plugin'=>false)))?></th>
		<th><?=$paginator->sort(__('subject',true),'subject',array('url'=>array('plugin'=>false)))?></th>
		<th><?=$paginator->sort(__('name',true),'name')?></th>
		<th nowrap="nowrap"><?=$paginator->sort(__('created',true),'created',array('url'=>array('plugin'=>false)))?></th>
		<th><?=$paginator->sort(__('hit',true),'hit',array('url'=>array('plugin'=>false)))?></th>
		</tr>
	</thead>
	<tbody>
	<?php if( count($rows) === 0 ):?>
	<tr><td colspan='6' height='60' class='aligncenter'><?= __('notdata')?></td></tr>
	<?php endif?>

	<?php foreach($nrows as $data):?>
		<tr>
		<td>ⓝ</td>
		<td class='alignleft'><?=$html->link($data['Board']['subject'],array_merge(array('plugin'=>false,'action'=>'view',$bid,$data['Board']['no']),$this->params['named']));?>
		<?php if( $data['Board']['total_comment'] != 0 ):?><span class="total-comment">[<?=$data['Board']['total_comment']?>]</span><?php endif?>
		<?php if($setup['use_file'] && @$data['Fileattach']['name']):?><?=$html->image('/board/img/icons/'.$setup['skin_ext'].'/icon_disk_list.png',array('alt'=>@$data['Fileattach']['name'],'width'=>16,'height'=>16))?><?php endif?>
<?php if( substr($data['Board']['created'],0,10) >= date('Y-m-d',time()-86400*7) ):?><span class="new"><?=$html->image('/board/img/icons/'.$setup['skin_icon'].'/icon_new.gif')?></span><?php endif;?>
		</td>
		<td>
		<span class="profile" bid="<?=$bid?>" data="<?=$data['Board']['crypt_userid']?>">
		<?php if( $data['User']['profile'] ):?>
		<img class="profile" src="<?=$data['User']['profile']?>" width="20" height="20" alt="<?=$data['Board']['name']?> 사진"  />
		<?php endif;?>			
		<?=$data['Board']['name']?></span></td>
		<td nowrap="nowrap"><?=substr($data['Board']['created'],2,8)?></td>
		<td><?=$data['Board']['hit']?></td>
		</tr>
	<?php endforeach;?>



	<?php foreach($rows as $data):?>
		<tr>
		<td><?=@$vno--?></td>
		<td class="alignleft"><?=$data['Board']['spacer']?><?=$html->link($data['Board']['subject'],array_merge(array('plugin'=>false,'action'=>'view',$bid,$data['Board']['no']),$this->params['named']));?>
		<?php if( $data['Board']['total_comment'] != 0 ):?><span class="total-comment">[<?=$data['Board']['total_comment']?>]</span><?php endif?>
<?php if($setup['use_file'] && @$data['Fileattach']['name']):?><?=$html->image('/board/img/icons/'.$setup['skin_ext'].'/icon_disk_list.png',array('alt'=>@$data['Fileattach']['name'],'class'=>'list-file','width'=>16,'height'=>16))?><?php endif?>		
<?php if( substr($data['Board']['created'],0,10) >= date('Y-m-d',time()-86400*7) ):?><span class="new"><?=$html->image('/board/img/icons/'.$setup['skin_icon'].'/icon_new.gif')?></span><?php endif;?>
		</td>
		<td>
				<span class="profile" bid="<?=$bid?>" data="<?=$data['Board']['crypt_userid']?>">
		<?php if( $data['User']['profile'] ):?>
		<img class="profile" src="<?=$data['User']['profile']?>" width="20" height="20" alt="<?=$data['Board']['name']?> 사진"  />
		<?php endif;?>
		<?=$data['Board']['name']?></span></td>
		<td nowrap="nowrap"><?=substr($data['Board']['created'],2,8)?></td>
		<td><?=$data['Board']['hit']?></td>
		</tr>
	<?php endforeach;?>




	</tbody>
	</table>

	<div id='btn-area'>
	<?php if( (int)$session->Read('User.level') >= $level['lv_write'] ):?>
	<?=$paginator->link(__('write',true),array('plugin'=>false,'controller'=>'board','action'=>'write'),array('escape'=>false,'class'=>'button'));?>
	<?php endif;?>
	</div>


	<div id='paging-area'>
	<?=$paginator->prev($html->image('/board/img/skins/'.$setup['skin'].'/icon_prev.png'), array('tag'=>'span','escape'=>false), $html->image('/board/img/skins/'.$setup['skin'].'/icon_prev.png'), array('tag'=>'span','class' => 'page-disabled','escape'=>false));?>
	<?=$paginator->numbers(array('plugin'=>false,'modulus'=>8)); ?>
	<?=$paginator->next($html->image('/board/img/skins/'.$setup['skin'].'/icon_next.png'), array('tag'=>'span','escape'=>false), $html->image('/board/img/skins/'.$setup['skin'].'/icon_next.png'), array('tag'=>'span','class' => 'page-disabled','escape'=>false));?>
	</div>

	<div id='search-area'>
		<?=$form->create("Board",array('url'=>array('plugin'=>false,'controller'=>'board','action'=>'lst',$bid),'type'=>'get'))?>
		<?=$form->hidden("category")?>
		<?=$form->checkbox("ss",array('style'=>'margin:0;border:none;','checked'=>true))?><?=$form->label("ss",__('subject',true))?>
		<?=$form->checkbox("sc",array('style'=>'margin:0;border:none;'))?><?=$form->label("sc",__('content',true))?>
		<?=$form->checkbox("sn",array('style'=>'margin:0;border:none;'))?><?=$form->label("sn",__('name',true))?> 
		<?=$form->text("keyword")?>
		 <?=$form->submit('검색',array('alt'=>'Search','style'=>'border:none;vertical-align:middle','class'=>'button','div'=>false))?>
		<?=$form->end();?>
	</div>

	</div><!-- id=board-list -->
	
	
	