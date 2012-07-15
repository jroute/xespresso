<?php $paginator->options(array('url' =>array_merge($this->passedArgs,array('plugin'=>false,'action'=>'lst'))));?>


	<div id="board-list">

	<div id="board-list-top">

		<div id="board-list-page">
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
		<?=$html->link($html->image('/board/img/icons/'.$setup['skin_icon'].'/rss.png'),array('plugin'=>false,'action'=>'rss',$bid),array('escape'=>false));?>
		<?php endif?>
		</div>


	</div>

	<br style="clear:both">

	<ul class="board-gallery">
	
	<?php 
	list($tw,$th) = explode('x',$setup['thumb_size_gallery']);	
	foreach($rows as $data):
	?>
	
	<li style="width:<?=$tw+10?>px;height:<?=$th+50?>px">
		<div class='thumb' style="height:<?=$tw+10?>px">
		<p><?php if( @$data['Fileattach']['thumb'] ): echo $paginator->link($html->image($data['Fileattach']['thumb']),array('plugin'=>false,'action'=>'view',$data['Board']['no']),array('escape'=>false)); endif;?></p>
		</div>
		<dl>
			<dt style="overflow:hidden;height:18px">
<!-- 			<?=$form->checkbox(null,array('name'=>'no[]','class'=>'allchk','value'=>$data['Board']['no']));?> -->
			
<?php if( substr($data['Board']['created'],0,10) >= date('Y-m-d',time()-86400*7) ):?><span class="new"><?=$html->image('/board/img/icons/'.$setup['skin_icon'].'/icon_new.gif')?></span><?php endif;?>	
<?php if( $data['Board']['total_comment'] != 0 ):?><span class="total-comment">[<?=$data['Board']['total_comment']?>]</span><?php endif?>
			
			<?=$paginator->link($data['Board']['subject'],array('plugin'=>false,'action'=>'view',$data['Board']['no']));?>
			
		
			
			</dt>
			<dd>
		<?php if( $data['User']['profile'] ):?>
		<img class="profile" src="<?=$data['User']['profile']?>" width="20" height="20" alt="<?=$data['Board']['name']?> 사진"  />
		<?php endif;?>
			<?=$data['Board']['name']?> | <?=substr(str_replace('-','.',$data['Board']['created']),2,8)?></dd>
		</dl>
	</li>
	<?php endforeach;?>
	</ul>

	<br style="clear:both">
	
	<div id="btn-area">
	<?php if( (int)$session->Read('User.level') >= $level['lv_write'] ):?>
	<?=$html->link(__('write',true),array('plugin'=>false,'action'=>'write',$bid),array('escape'=>false,'class'=>'button'));?>
	<?php endif;?>
	</div>


	<div id="paging-area">
	<?=$paginator->prev($html->image('/board/img/skins/'.$setup['skin'].'/icon_prev.png'), array('tag'=>'span','escape'=>false), $html->image('/board/img/skins/'.$setup['skin'].'/icon_prev.png'), array('tag'=>'span','class' => 'page-disabled','escape'=>false));?>
	<?=$paginator->numbers(); ?>
	<?=$paginator->next($html->image('/board/img/skins/'.$setup['skin'].'/icon_next.png'), array('tag'=>'span','escape'=>false), $html->image('/board/img/skins/'.$setup['skin'].'/icon_next.png'), array('tag'=>'span','class' => 'page-disabled','escape'=>false));?>
	</div>

	</div>
