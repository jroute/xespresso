	

<?=$paginator->options(array('url' =>$this->passedArgs));?>

<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>


<div class='content-bar'>
<?=$form->create("User",array("action"=>"search","type"=>"get"))?>

<?=$form->select('grpid',$group,null,array('empty'=>':::: 그룹전체 ::::'))?> 
<?=$form->select('level',$level,null,array('empty'=>':::: 레벨전체 ::::'))?> 
<?=$form->select("sfield",array('name'=>'이름','userid'=>'아이디'),null,array('empty'=>false))?> <?=$form->text("keyword")?> 
<?=$form->submit("검색",array('div'=>false,'class'=>'btn'))?>

<?=$form->end();?>
</div>


<div id="content">



 <div><?=$paginator->counter(array('format' => 'Total : %count%, Page : %page%/%pages%'));?></div>

<table class='tbl-list'>
<col width='5%' />
<col width='9%' />
<col width='10%' />
<col width='*' />
<col width='11%' />
<col width='10%' />
<col width='11%' />
<col width='11%' />
<col width='11%' />
<col width='5%' />
<col width='5%' />
<col width='5%' />
<tr>
<th><?=$paginator->sort('번호', 'uno'); ?></th>
<th><?=$paginator->sort('그룹', 'grpid'); ?></th>
<th><?=$paginator->sort('아이디', 'userid'); ?></th>
<th><?=$paginator->sort('이름', 'name'); ?></th>
<th><?=$paginator->sort('연락처', 'mobile'); ?></th>
<th><?=$paginator->sort('레벨', 'level'); ?></th>
<th><?=$paginator->sort('가입일', 'created'); ?></th>
<th><?=$paginator->sort('수정일', 'modified'); ?></th>
<th><?=$paginator->sort('마지막접속일', 'lastlogin'); ?></th>
<th>수정</th>
<th>탈퇴</th>
<th>메모</th>
</tr>

<?foreach($data as $user):?>
<tr>
<td><?=$user['User']['uno']?></td>
<td>
<?
unset($GROUP);
$GROUP = array();

	foreach($user['UserGroup'] as $grp){
		$GROUP[] = @$group[$grp['grpid']];
	}
	echo @implode(", ",$GROUP);
?>
</td>
<td><b><?=$paginator->link($user['User']['userid'],array('action'=>'view',$user['User']['userid']))?></b></td>
<td><?=$paginator->link($user['User']['name'],array('action'=>'view',$user['User']['userid']))?></td>
<td><?=$user['User']['mobile']?></td>
<td><?=$level[$user['User']['level']]?></td>
<td><?=substr($user['User']['created'],2,14)?></td>
<td><?=substr($user['User']['modified'],2,14)?></td>
<td><?=substr($user['User']['lastlogin'],2,14)?></td>
<td><?php if( $user['User']['level'] != 0 ):?><?=$html->link($html->image('webadm/user_edit_16x16.gif',array('alt'=>'정보수정')),'edit/'.$user['User']['userid'],array('escape'=>false))?><?php endif;?></td>
<td><?php if( $user['User']['level'] ):?><?=$html->link($html->image('webadm/user_delete_16x16.gif',array('alt'=>'탈퇴')),array('action'=>'signout',$user['User']['userid']),array('escape'=>false,'id'=>'btn-signout'),'탈퇴처리 하시겠습니까?')?><?php endif;?></td>
<td><?=$html->image('webadm/user_memo_16x16.png',array('class'=>'memo hand','alt'=>'메모','id'=>'user-'.$user['User']['userid'].'-'.$user['User']['name']));?></td>
</tr>
<?endforeach;?>
</table>
<?=$paginator->prev('« 이전 ', null, null, array('class' => 'page-disabled'));?>
<?=$paginator->numbers(); ?>
<?=$paginator->next(' 다음 »', null, null, array('class' => 'page-disabled'));?>


</div>


<div id='memo' class="hide">
<form id='memo-form'>
<input type="hidden" name="data[User][userid]" id="memo-userid" value="" />
	<table class="tbl">
	<col width="15%" />
	<col width="85%" />
	<tr><th>이름</th><td><b><span id='memo-name'>Loading...</span></b> 님의 메모정보 입니다.</td></tr>
	<tr><td colspan="2"><textarea id='memo-text' class='txt w99ps' rows='10' name="data[User][memo]">Loading...</textarea></td></tr>
	<tr><th>업데이트</th><td><span id='memo-update'>Loading...</span></td></tr>

	</table>
</form>
</div>
<?=$javascript->codeBlock("

$(function(){

	$('.memo').click(function(){
		var _this = $(this);
		$('#memo').dialog({
			title:'메모정보',
			width:500,
			height:400,
			modal:true,
			buttons:{
				'닫기':function(){
					$('#memo-userid').val('');
					$('#memo-name').html('Loading....');
					$('#memo-text').val('Loading....');
					$('#memo-update').html('Loading...');
					$('#memo').dialog('destroy');
				},
				'저장':function(){
					$.ajax({
						url:'/webadm/users/set',
						type:'post',
						data:$('#memo-form').serialize(),
						dataType:'json',
						success:function(data){
							if( data['error'] == 'true' ){
								msg = '저장할 수 없습니다.';
							}else{
								msg = '저장되었습니다.';
								$('#memo-text').val(data['memo']);
								$('#memo-update').html(data['modified']);
							}							

							$.jGrowl(msg, { 
								theme: 'smoke',
								life: 1000,
								close: function(e,m,o) {

								}
							});
						}
					});
				}
			},
			open:function(){
				$('#memo-userid').val(_this.attr('id').split('-')[1]);
				$('#memo-name').html(_this.attr('id').split('-')[2]);
				$.ajax({
					url:'/webadm/users/get/' + _this.attr('id').split('-')[1],
					dataType:'json',
					success:function(data){
						$('#memo-text').val(data['memo']);
						$('#memo-update').html(data['modified']);
					}
				});
				$('#memo').show();
			},
			close:function(){
				$('#memo-userid').val('');
				$('#memo-name').html('Loading...');
				$('#memo-text').val('Loading...');
				$('#memo-update').html('Loading...');
				$('#memo').dialog('destroy');
			}
		});
	});
});

", array("inline"=>false))?>