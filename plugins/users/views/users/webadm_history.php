
<?=$paginator->options(array('url'=>array_merge(array('plugin'=>false),$this->passedArgs)));?>
<?php $vno = $paginator->counter('%count%')-($paginator->counter('%page%')-1)*$paginate['UserHistory']['limit'];?>
			
<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>


<div class="content-bar gBtn gBtn1" >
<?=$form->create("UserHistory",array("action"=>"history","type"=>"get"))?>
<div class="floatleft" style="padding:3px">
<?=$form->select("sfield",array(
						'uname'=>'사용자 이름','userid'=>'사용자 아이디',
						'aname'=>'접근자 이름','accessid'=>'접근자 아이디',
						'message'=>'내용','ip'=>'아이피'),null,array('empty'=>false))?> <?=$form->text("keyword")?> 
</div>						
<a><span><?=$form->submit("검색",array('div'=>false,'class'=>'btw'))?></span></a>

<?=$form->end();?>
</div>


<div id="content">

<div><?=$paginator->counter(array('format' => 'Total : %count%, Page : %page%/%pages%'));?></div>

<table class='tbl-list'>

<tr>
<th><?=$paginator->sort('번호', 'id'); ?></th>
<th><?=$paginator->sort('사용자', 'accessid'); ?></th>
<th><?=$paginator->sort('아이피', 'ip'); ?></th>
<th><?=$paginator->sort('내용', 'message'); ?></th>
<th><?=$paginator->sort('가입일', 'created'); ?></th>

</tr>

<?php foreach($rows as $row):?>
<tr>
<td><?=$vno--?></td>
<td><?=$paginator->link($row['UserHistory']['aname'].'('.$row['UserHistory']['accessid'].')',array('action'=>'view',$row['UserHistory']['accessid']))?></td>
<td><?=$row['UserHistory']['ip']?></td>
<td class="left"><?php if( $row['UserHistory']['userid'] ):?><?=$paginator->link($row['UserHistory']['uname'].'('.$row['UserHistory']['userid'].')',array('action'=>'view',$row['UserHistory']['userid']),array('style'=>'color:#eeaa33'))?> <?php endif;?><?=$row['UserHistory']['message']?></td>
<td><?=substr($row['UserHistory']['created'],2,14)?></td>
</tr>
<?php endforeach;?>
</table>
<?=$paginator->prev('« 이전 ', null, null, array('class' => 'page-disabled'));?>
<?=$paginator->numbers(); ?>
<?=$paginator->next(' 다음 »', null, null, array('class' => 'page-disabled'));?>


</div>

<?=$javascript->codeBlock("

$(function(){

});

", array("inline"=>false))?>