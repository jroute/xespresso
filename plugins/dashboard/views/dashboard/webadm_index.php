<?php echo $html->css(array('/dashboard/css/style'));?>
<?php $javascript->link('/dashboard/js/dashboard',false);?>

<div>

<!-- section 1 -->
<div class="column" id="section-1">
	
		<div class="dashboard-box" id="db-recent">
		<div class="dashboard-title">최근 글</div>
		<div class="dashboard-content" style="padding:4px;">
			<table class='tbl-list' style="">

			<?php foreach($RecentArticles as $row):?>
			<tr>
			<td class="left">
			<div style="color:#999;font-size:8pt;"><?=str_replace('-','.',substr($row['Board']['created'],2,8))?> | <?=$row['Board']['bname']?></div>
			<?=$html->link($row['Board']['subject'],'/webadm/board/view/'.$row['Board']['bid'].'/'.$row['Board']['no'])?></td>
			</tr>
			<?php endforeach;?>
			</table>
		</div>	
	</div>

</div>	

<!-- section 2 -->
<div class="column" id="section-2">

	<div class='dashboard-box' id="db-user">
		<div class='dashboard-title'>회원 통계</div>
		<div class="dashboard-content">
			<ul>
			<li>전체 회원 : <?=@$users['total']?> 명</li>
			<li>어제 가입 : <?=@$users['today']?> 명</li>
			<li></li>
			</ul>
		</div>
	</div>
	
	
</div>	

<!-- section 3 -->
<div class="column" id="section-3">


	

	
	<div class='dashboard-box' id="db-counter">
		<div class='dashboard-title'>방문 통계</div>
		<div class="dashboard-content">
		<ul>
		<li>전체 : 
			<ul>
			<li style='color:red'>방문자 수 : <?=@$counter['total']['uv']?></li>
			<li>페이지 뷰 : <?=@$counter['total']['pv']?></li>
			</ul>
		</li>
		<li>오늘 :
			<ul>
			<li style='color:red'>방문자 수 : <?=@$counter['today']['uv']?></li>
			<li>페이지 뷰 : <?=@$counter['today']['pv']?></li>
			</ul>
		</li>
		<li>어제 : 
			<ul>
			<li style='color:red'>방문자 수 : <?=@$counter['yesterday']['uv']?></li>
			<li>페이지 뷰 : <?=@$counter['yesterday']['pv']?></li>
			</ul>
		</ul>
		</div>
	</div>
</div>

</div>
