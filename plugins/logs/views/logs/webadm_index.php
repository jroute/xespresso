
<style type="text/css">
.uv { background:rgb(17, 68, 119) ; }
.pv { background: rgb(51, 119, 182); border-bottom:1px solid #808080;}

.date { font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif; font-size:10px !important;}

.state {
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	border:1px solid #DFDFDF;
}
.state th {
	background:#DFDFDF;
	padding:5px;
	text-align:left;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
}
.state td {
	border-bottom:1px solid #DFDFDF;
	padding:5px;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
}

.wrap h2 {
	font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
	font-size:24px;
	font-style:italic;
	color:#464646;
}
.num {
	text-align:left;
	margin:0 5px 0 5px;
	font-family:tahoma;
	font-size:9px;
}
</style>
<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>




<div id="content">

<h1>접속 통계</h1>

<table width="100%" class="state">
<thead>
<tr>
<th></th>
<th>Total</th>
<th>Yesterday</th>
<th>Today</th>
</tr>
</thead>
<tbody>

<tr>
<td> <div style="background: rgb(17, 68, 119) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; width: 10px; height: 10px; float: left; margin-top: 4px; margin-right: 5px;"/></div>Visitors </td>
<td><?=$count['uv']['total']?></td>
<td><?=$count['uv']['yesterday']?></td>
<td><?=$count['uv']['today']?></td>
</tr>

<tr>
<td> <div style="background: rgb(51, 119, 182) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; width: 10px; height: 10px; float: left; margin-top: 4px; margin-right: 5px;"/></div> Pageviews </td>
<td><?=$count['pv']['total']?></td>
<td><?=$count['pv']['yesterday']?></td>
<td><?=$count['pv']['today']?></td>
</tr>

</tbody>
</table>

<br />

<table width="100%" height="220" class="state-graph">
<?php 
foreach($logs as $date=>$data):

$style = '';
if( date('w',strtotime($date))==0 ) $style = "style='border-left: 2px dotted gray;'";
?>
<td align="center" valign="bottom" width="4.5%" <?=$style?>>
<div class="uv" style="height:<?=@$data['uvh']?>px" title="<?=$data['uv']?>"></div>
<div class="pv" style="height:<?=@$data['pvh']?>px" title="<?=$data['pv']?>"></div>
<div class='date'><?=date('m.d',strtotime($date))?></div>
<div class='num'><div style="background: rgb(17, 68, 119) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; width: 8px; height: 8px; float: left; margin-top: 4px; margin-right: 5px;"/></div> <?=$data['uv']?></div>
<div class='num'><div style="background: rgb(51, 119, 182) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; width: 8px; height: 8px; float: left; margin-top: 4px; margin-right: 5px;"/></div> <?=$data['pv']?></div>
</td>
<?
endforeach;?>
</table>



	<div class="wrap">
		<h2>Last hits</h2>

		<table width="100%" class="state">
		<thead>
		<tr>
			<th>Date</th>
			<th>Time</th>
			<th>IP</th>
			<th>Page</th>
			<th>OS</th>
			<th>Browser</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach($hits as $data): $hit = array_shift($data);
		list($date,$time) = explode(' ',$hit['created']);
		?>
		<tr>
			<td><?=$date?></td>
			<td><?=$time?></td>
			<td><img width="18" height="12" border="0" src="http://api.hostip.info/flag.php?ip=<?=$hit['ip']?>"/><?=$hit['ip']?></td>
			<td><?=$hit['page']?></td>
			<td><?=$hit['os']?></td>
			<td><div style="width:110px;height:21px;overflow:hidden"><?php if( $hit['browserIcon'] ){ echo $html->image('webadm/browsers/'.$hit['browserIcon'],array('width'=>18,'align'=>'middle')); }?> <?=$hit['browser']?></div></td>
		</tr>
		<?php endforeach;?>
		</tbody>
		</table>

	</div>
</div>