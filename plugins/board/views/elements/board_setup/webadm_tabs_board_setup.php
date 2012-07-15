<?
$options1 = $options2 = $options3 = $options4 = $options5 = array();
switch($this->params['action']){
	case "webadm_edit":			$options1 = "class='active'"; break;
	case "webadm_edit_skin":	$options2 = "class='active'"; break;
	case "webadm_edit_level":	$options3 = "class='active'"; break;
	case "webadm_edit_filter":	$options4 = "class='active'"; break;
	case "webadm_edit_category":	$options5 = "class='active'"; break;
}
?>
<div id="ctab">
	<ul class='ul-tab'>
	<li><?=$html->link('게시판목록',array('plugin'=>'board','controller'=>'board_setup','action'=>'index'))?></li>
	<li <?=$options1?>><?=$html->link('기본설정',array('plugin'=>'board','controller'=>'board_setup','action'=>'edit',$bid))?></li>
	<li <?=$options2?>><?=$html->link('스킨설정',array('plugin'=>'board','controller'=>'board_setup','action'=>'edit_skin',$bid))?></li>
	<li <?=$options3?>><?=$html->link('권한설정',array('plugin'=>'board','controller'=>'board_setup','action'=>'edit_level',$bid))?></li>
	<li <?=$options4?>><?=$html->link('필터링',array('plugin'=>'board','controller'=>'board_setup','action'=>'edit_filter',$bid))?></li>
	<li <?=$options5?>><?=$html->link('카테고리설정',array('plugin'=>'board','controller'=>'board_setup','action'=>'edit_category',$bid))?></li>
	</ul>
</div>
