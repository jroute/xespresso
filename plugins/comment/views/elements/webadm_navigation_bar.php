	<div id="navigation-title"><h3>팝업 관리</h3></div>
	<div id="navigation-control">
		<?=$form->select('lang',$language,$lang,array('url'=>$html->url(array('action'=>$this->action)),'id'=>'change-lang','empty'=>false));?>
	</div>
