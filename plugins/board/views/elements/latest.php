<?php

$rows = $this->requestAction('/board/latest', array('return',
	'bid'=>@$bid,
	'category'=>@$category,
	'limit'=>@$limit,
	'slen'=>@$slen,
	'clen'=>@$clen,
	'bname'=>@$bname
	)
);
?>
<?php foreach($rows as $row):?>
<li>
<?php if( @$bname ):?><div>[<?=$html->link($row['bname'],'/board/lst/'.$row['bid'])?>] <span>- <?=date('m.d',strtotime($row['created']))?></span> </div> <?php endif;?>
<?=$html->link($row['subject'],$row['link']);?>
<?php if( $row['total_comment'] ):?><span class="total-comment">[<?=$row['total_comment']?>]</span><?php endif;?>
<?php if( substr($row['created'],0,10) >= date('Y-m-d',time()-86400*7) ):?> <span class="new"><?=$html->image('/board/img/icons/01/icon_new.gif')?></span><?php endif;?>
</li>
<?php endforeach;?>