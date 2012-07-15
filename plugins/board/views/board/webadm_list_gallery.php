<?=$html->css(array('/board/css/gallery',"/board/css/skins/".$setup['skin']),null,array('inline'=>false));?>
<?=$javascript->link("webadm/boards",false)?>
<?=$paginator->options(array('url' =>(count($this->passedArgs)  ? $this->passedArgs:$bid)));?>

<div id="navigation-bar">
	<?=$this->element("board/webadm_navigation_bar");?>
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

	<br style='clear:both'>
	
	<?=$form->create('Board',array('id'=>'form-list'))?>
	<?=$form->hidden('bid',array('value'=>$bid))?>
	<div>
	<ul class='board-gallery'>
	<?php 
	list($tw,$th) = explode('x',$setup['thumb_size_gallery']);
	foreach($datas as $data):

	?>
	<li style="width:<?=$tw+10?>px;height:<?=$th+50?>px">
		<div class='thumb' style="height:<?=$tw+10?>px">
		<p><?php if( @$data['BoardFile']['thumb'] ): echo $paginator->link($html->image($data['BoardFile']['thumb']),array('plugin'=>false,'action'=>'view',$data['Board']['no']),array('escape'=>false)); endif;?></p>
		</div>
		<dl>		
			<dt style="overflow:hidden;height:18px"><?=$form->checkbox(null,array('name'=>'no[]','class'=>'allchk','value'=>$data['Board']['no']));?>
			<?=$paginator->link($data['Board']['subject'],array('plugin'=>false,'action'=>'view',$data['Board']['no']));?></dt>
			<dd><?=$data['Board']['name']?> | <?=substr(str_replace('-','.',$data['Board']['created']),0,10)?></dd>
			<?php if( $setup['use_approve'] ):?>
				<dt><span style="color:<?php if( $data['Board']['opt_approval'] ):?>blue<?php else:?>red<?php endif;?>"><?=$approval[$data['Board']['opt_approval']];?></dt>
			<?php endif;?>			
		</dl>
	</li>
	<?php endforeach;?>
	</ul>
	</div>
	<?=$form->end()?>
	
	
	<div id='paging-area' class="clearboth">
	<?=$paginator->prev($html->image('/board/img/skins/'.$setup['skin'].'/icon_prev.png'), array('tag'=>'span','escape'=>false), $html->image('/board/img/skins/'.$setup['skin'].'/icon_prev.png'), array('tag'=>'span','class' => 'page-disabled','escape'=>false));?>
	<?=$paginator->numbers(); ?>
	<?=$paginator->next($html->image('/board/img/skins/'.$setup['skin'].'/icon_next.png'), array('tag'=>'span','escape'=>false), $html->image('/board/img/skins/'.$setup['skin'].'/icon_next.png'), array('tag'=>'span','class' => 'page-disabled','escape'=>false));?>
	</div>

	<div id='btn-area' class="gBtn1 floatright">
			<?php if( $setup['use_approve'] ):?>
				<?=$html->link('<span>승인/비승인</span>','#',array('class'=>'','escape'=>false,'id'=>'btn-approve'));?>
			<?php endif;?>
						
			<?=$html->link('<span>게시물 이동/복사</span>','#',array('class'=>'','escape'=>false,'id'=>'btn-move'));?>

				
	<?=$html->link('<span>삭제</span>','#',array('id'=>'btn-delete','alt'=>'삭제','class'=>'','escape'=>false));?>
	<?=$html->link('<span>글쓰기</span>',"write/$bid",array('escape'=>false,'class'=>'','escape'=>false));?>
	</div>

	</div>


	</div>
</div>