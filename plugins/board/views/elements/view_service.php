	<div class="board-service">
		<span class="attachfile"><?php if( $setup['use_file'] ):?><img src='/board/img/icons/<?=$setup['skin_ext']?>/icon_disk_view.png' border='0' alt="<?=__('Attach File')?>" /> <a href="#header" class="btn-attachfile"><?=__('Attach File')?> <span class="filecount">(<?=count($data['Fileattach'])?>)</span></a><?php endif;?></span>




		
		
		<span class="sns">
		<a href="http://twitter.com/home?status=<?=urlencode($data['Board']['subject'])?> <?=urlshorten($this->here);?>" class="sns twitter"><?=__('twitter');?></a>
		<a href="http://www.facebook.com/sharer.php?u=<?=urlshorten($this->here,false);?>&amp;t=<?=urlencode($data['Board']['subject'])?>" class="sns facebook"><?=__('facebook');?></a>
		<a href="http://me2day.net/posts/new?new_post[body]=<?=urlencode('"'.$data['Board']['subject'].'"')?>:<?=urlshorten($this->here);?>&amp;new_post[tags]=<?=urlencode($data['Board']['subject'])?>" class="sns me2day"><?=__('me2day');?></a>
		<a href="http://www.delicious.com/save?v=5&noui&jump=close&url=<?=urlshorten($this->here,false);?>&amp;title=<?=urlencode($data['Board']['subject'])?>" class="sns delicious"><?=__('delicious');?></a>						
		</span>
		
		
		<span class="service">
		
		<span class="svc-font">
			<a class="svc-font-text"><?=__('font');?> </a>
			<a class="svc-font-large">+ <?=__('font large');?></a>
			<a class="svc-font-small">- <?=__('font small');?></a>
		</span>
						
		<a href="<?=$html->url(array_merge($this->passedArgs,array('action'=>'vprint')))?>" class="svc-print"><?=__('print');?></a>
<!-- 		<a href="" class="svc-email">E-mail</a> -->
		</span>		
	</div>
<?php
/*********************** Begin File *************************/
if( $setup['use_file'] ):?>
	<div class="filelist">
	<ul>
	<?php foreach($data['Fileattach'] as $files ):?>
		<li><a href="/board/download/<?=$bid?>/<?=$no?>/<?=$files['id']?>"><img src='/board/img/icons/<?=$setup['skin_ext']?>/icon_download.png' border='0' alt="<?=$files['name']?>" /> <?=$files['name']?></a></li>
	<?php endforeach;?>
	</ul>
	</div>
<?php endif
/*********************** End File *************************/
?>