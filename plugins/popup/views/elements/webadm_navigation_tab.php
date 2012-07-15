	<div id="ctab">
		<ul class='ul-tab'>
		<li <?php if( $this->action=='webadm_index'):?>class="active"<?php endif;?>><?=$html->link('팝업목록',array('plugin'=>false,'action'=>'index','language:'.$lang))?></li>
		<li <?php if( $this->action=='webadm_add'):?>class="active"<?php endif;?>><?=$html->link('팝업추가',array('plugin'=>false,'action'=>'add','language:'.$lang))?></li>
		</ul>
	</div>