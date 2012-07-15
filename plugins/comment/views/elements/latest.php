<?php

$rows = $this->requestAction('/comment/latest', array('return',
	'limit'=>$limit,
	'length'=>$length,
	)
);
?>
<?php foreach($rows as $row):?>
<li><span>[<?=date('m.d',strtotime($row['created']))?>]</span> <?=$html->link($row['comment'],sprintf('%s#comment-%s',$row['return_url'],$row['no']));?><?php if( substr($row['created'],0,10) == date('Y-m-d') ):?> <span class="new"><?=$html->image('/board/img/icons/01/icon_new.gif')?></span><?php endif;?></li>
<?php endforeach;?>