

<?=$paginator->options(array('url' =>$this->passedArgs));?>
<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>

<div id="content">

<h1>접속 로그</h1>


  <?=$paginator->counter(array('format' => 'Total : %count%, Page : %page%/%pages%'));?>

<table class='tbl-list'>
<tr>
<th><?=$paginator->sort('고유번호', 'id'); ?></th>
<th><?=$paginator->sort('상태', 'state'); ?></th>
<th><?=$paginator->sort('날짜', 'created'); ?></th>
<th><?=$paginator->sort('아이디', 'userid'); ?></th>
<th><?=$paginator->sort('이름', 'name'); ?></th>
<th><?=$paginator->sort('레벨', 'level'); ?></th>
<th><?=$paginator->sort('아이피', 'level'); ?></th>
</tr>

<?foreach($rows as $row):?>

	<tr>
	<td rowspan='2'><?=$row['Logs']['id']?></td>
	<td><?=$row['Logs']['state']?></td>
	<td><?=substr($row['Logs']['created'],2)?></td>
	<td><?=$row['Logs']['userid']?></td>
	<td><b><?=$row['Logs']['name']?></b></td>
	<td><?=$row['Logs']['level']?></td>
	<td><b><?=$row['Logs']['ip']?></b></td>
	</tr>
	<tr><td colspan='6' class='td-left'>
		<ul style='margin:0'>
			<li><?=$row['Logs']['agent']?></li>
			<li><?=$row['Logs']['referral']?></li>
			<li><?=$row['Logs']['cookie']?></li>
		</ul>
	</td></tr>

<?endforeach;?>

</table>
<?=$paginator->prev('« Previous ', null, null, array('class' => 'page-disabled'));?>
<?=$paginator->numbers(); ?>
<?=$paginator->next(' Next »', null, null, array('class' => 'page-disabled'));?>




</div>