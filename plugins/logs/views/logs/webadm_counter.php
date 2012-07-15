<?
$class = array();

switch(@$this->params['pass'][0]){
	default:
	case "time":			$class[0] = 'active'; break;
	case "day":			$class[1] = 'active'; break;
	case "month":		$class[2] = 'active'; break;
	case "year":			$class[3] = 'active'; break;
	case "browser":	$class[4] = 'active'; break;
	case "os":			$class[5] = 'active'; break;
}
?>


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
</style>

<div id="navigation-bar">
	<div id="navigation-title"><h3>접속 통계</h3></div>
	<div id="navigation-control">

	</div>
</div>


<div id="top-tab">
	<div id="ctab">
		<ul class='ul-tab'>
		<li class="<?=@$class[0]?>"><?=$html->link('시간','counter')?></li>
		<li class="<?=@$class[1]?>"><?=$html->link('일','counter/day')?></li>
		<li class="<?=@$class[2]?>"><?=$html->link('월','counter/month')?></li>
		<li class="<?=@$class[3]?>"><?=$html->link('연도','counter/year')?></li>
		<li class="<?=@$class[4]?>"><?=$html->link('브라우져','counter/browser')?></li>
		<li class="<?=@$class[5]?>"><?=$html->link('운영체제','counter/os')?></li>
		</ul>
	</div>

</div>


<div id="content">

<h1>접속 통계</h1>


<div style='text-align:center;padding:10px;margin:10px;font-size:2.1em;font-family:tahoma;font-weight:bold;'>
	Total : <?=$counter['total']['uv']?>/<?=$counter['total']['pv']?>,&nbsp;&nbsp;
	Today : <?=$counter['today']['uv']?>/<?=$counter['today']['pv']?>,&nbsp;&nbsp;
	Yesterday : <?=$counter['yesterday']['uv']?>/<?=$counter['yesterday']['pv']?>
</div>


<?=$form->create('Logs',array('url'=>$this->here))?>
<?=$form->select('year',$selectOptions['year'])?>
<?=$form->select('month',$selectOptions['month'])?>
<?=$form->select('day',$selectOptions['day'])?>
<?=$form->submit('확인',array('div'=>false))?>
<?=$form->end();?>


<?if( $w == "" || $w == "time" ):?>



<table class='state' width="100%" height="230">
<tr>
<?
	
for($i = 0 ; $i < 24 ; $i++ ):
	$uv = 0;
	$uvh = 0;
	foreach($data as $cnt){
		$time = substr(@$cnt['date'],11,2);
		if( trim($time) == sprintf('%02d',$i) ){
			$uv = @$cnt['uv'];
			$uvh = @$cnt['uvh'];
			break;
		}
	}
	$style='';
	if( date('H') == sprintf('%02d',$i) ) $style = "style='background:#FFD2A0'";
?>
<td <?=$style?> valign="bottom">
<div class='pv' style='height:<?=$uvh?>px;' title="<?=$uv?>"></div>
<div class="date"><?=sprintf('%02d',$i)?></div>
</td>
<?endfor;?>
</tr>
</table>

<?elseif( $w == "day" ):?>


<table class='state' width="100%" height="230">
<tr>
<?for($i = 1 ; $i <= 31 ; $i++ ):
	$uvh = $pvh = $uv = $pv = 0;
	foreach($data as $cnt){
		if( @$cnt['day'] == sprintf('%02d',$i) ){
			$uv = @$cnt['uv'];
			$pv = @$cnt['pv'];
			$uvh = @$cnt['uvh'];
			$pvh = @$cnt['pvh'];
			break;
		}
	}

	$style='';
	if( date('d') == sprintf('%02d',$i) ) $style = "style='background:#FFD2A0'";

?>

<td <?=$style?> valign="bottom">
<div class="uv" style="height:<?=$uvh?>px" title="<?=$uv?>"></div>
<div class="pv" style="height:<?=$pvh?>px" title="<?=$pv?>"></div>
<?=sprintf('%02d',$i)?>
</td>
<?endfor;?>
</tr>
</table>

<?php elseif( $w == "month" ):?>


<table class='state' width="100%" height="230">
<tr>
<?php for($i = 1 ; $i <= 12 ; $i++ ):
	$uvh = $pvh = $uv = $pv = 0;
	foreach($data as $cnt){

		if( @$cnt['month'] == sprintf('%02d',$i) ){
			$uv = @$cnt['uv'];
			$pv = @$cnt['pv'];
			$uvh = @$cnt['uvh'];
			$pvh = @$cnt['pvh'];
			break;
		}
	}

	$style='';
	if( date('m') == sprintf('%02d',$i) ) $style = "style='background:#FFD2A0'";
?>
<td <?=$style?> valign="bottom">
<div class="uv" style="height:<?=$uvh?>px" title="<?=$uv?>"></div>
<div class="pv" style="height:<?=$pvh?>px" title="<?=$pv?>"></div>
<?=sprintf('%02d',$i)?>
</td>
<?endfor;?>
</tr>
</table>


<?php elseif( $w == "year" ):?>

<table class='state' width="100%" height="230">
<tr>
<?
foreach($data as $cnt):
	$uv = 0;
	$pv = 0;
	$uv = @$cnt['uv'];
	$pv = @$cnt['pv'];
	$uvh = @$cnt['uvh'];
	$pvh = @$cnt['pvh'];

	$style='';
	if( date('Y') == $cnt['year'] ) $style = "style='background:#FFD2A0'";
?>
<td <?=$style?> valign="bottom">
<div class="uv" style="height:<?=$uvh?>px" title="<?=$uv?>"></div>
<div class="pv" style="height:<?=$pvh?>px" title="<?=$pv?>"></div>
<?=$cnt['year']?>
</td>
<?php endforeach;?>
</tr>
</table>

<?php elseif( $w == "browser" ):?>

<table class='state' width="100%" height="230">
<tr>
<?
foreach($data as $cnt):
	$uv = 0;
	$pv = 0;
	$uv = @$cnt['uv'];
	$pv = @$cnt['pv'];
	$uvh = @$cnt['uvh'];
	$pvh = @$cnt['pvh'];

?>
<td valign="bottom">
<div class="uv" style="height:<?=$uvh?>px" title="<?=$uv?>"></div>
<div class="pv" style="height:<?=$pvh?>px" title="<?=$pv?>"></div>
<div style="margin:2px;width:130px;height:32px;overflow:hidden"><?=$html->image('webadm/browsers/'.$cnt['browserIcon'],array('align'=>'middle'));?> <?=$cnt['browser']?></div>
</td>
<?php endforeach;?>
</tr>
</table>


<?php elseif( $w == "os" ):?>


<table class='state' width="100%" height="230">
<tr>
<?
foreach($data as $cnt):
	$uv = @$cnt['uv'];
	$pv = @$cnt['pv'];
	$uvh = @$cnt['uvh'];
	$pvh = @$cnt['pvh'];

?>
<td valign="bottom">
<div class="uv" style="height:<?=$uvh?>px" title="<?=$uv?>"></div>
<div class="pv" style="height:<?=$pvh?>px" title="<?=$pv?>"></div>
<div style="width:130px;height:18px;overflow:hidden"><?=$cnt['os']?></div>
</td>
<?endforeach;?>
</tr>
</table>


<?endif?>


</div>