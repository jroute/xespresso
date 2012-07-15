<?
$active = array();

switch($this->params['action']){
	case "webadm_edit":
	case "webadm_add":
		$active[1] = "class='active'"; break;
	default:
		$active[0] = "class='active'";
}



?>
<div id="ctab">
	<ul class='ul-tab'>
	<li <?=@$active[0]?>><?=$html->link('설문목록','/webadm/poll/index')?></li>
	<li <?=@$active[1]?>><?=$html->link('설문추가','/webadm/poll/add')?></li>
	</ul>
</div>
