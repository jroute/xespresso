<?=$html->css(array(
	'/js/drag-drop-folder-tree/css/drag-drop-folder-tree',
	'/js/drag-drop-folder-tree/css/context-menu',	
	'/menus/css/style'
),null,array('inline'=>false))?>

<?=$javascript->link(array(
	'drag-drop-folder-tree/ajax',
	'drag-drop-folder-tree/context-menu',
	'drag-drop-folder-tree/drag-drop-folder-tree',
	'/menus/js/control',
	'/menus/js/drag-drop-folder-tree'	
),false)?>


<div id="navigation-bar">
	<div id="navigation-title"><h3>메뉴관리</h3></div>
	<div id="navigation-control">
		<?=$form->select('lang',$language,$lang,array('url'=>'/webadm/menus/index','id'=>'change-lang','empty'=>false));?>
	</div>
</div>


<div id="content">
	<h1>메뉴 설정</h1>

	<div id="menu-category">


		<ul id="dhtmlgoodies_topNodes" class="dhtmlgoodies_tree">
		<li id="node0" noDrag="true" noSiblings="true" noDelete="true" noRename="true"> <a href="#" noEvent="true">메인</a>
		<?
	
			if(array_key_exists(0, $categories)) {
			    echo $tree->getCategories(0, $categories[0], $categories);
			}
	
		?>
		</li>
		</ul>

	</div>
	

	<div id='menu-category-form'>


		<?=$form->create('Menu',array('url'=>$this->here,'onsubmit'=>'return false','id'=>'MenuIndexForm'))?>
		<?=$form->hidden("Menu.method")?>
		<?=$form->hidden("Menu.lang",array('value'=>$lang))?>		
		<?=$form->hidden("Menu.id")?>
		<?=$form->hidden("Menu.parent_id",array('value'=>$parentid))?>
		<?=$form->hidden("Menu.name")?>
		<?=$form->hidden("Menu.link")?>
		<?=$form->hidden("Menu.plugin")?>		
		<?=$form->hidden("Menu.model")?>
		<?=$form->hidden("Menu.controller")?>
		<?=$form->hidden("Menu.action")?>
		<?=$form->hidden("Menu.pass")?>
		<table class='tbl-list' style="width:400px">
		<tr><th id='add-title' class='th-left'>추가</th></tr>
		<tr><td class='td-left'>
				<?=$form->text("newName",array('size'=>30))?>
				<?=$form->button("추가",array('div'=>false,'id'=>'btn-add','class'=>'btn'))?>
				<?=$form->button("취소",array('div'=>false,'id'=>'btn-cancel','class'=>'btn'))?>
		</td></tr>
		<tr><th class='th-left'>수정</th></tr>
		<tr><td class='td-left'>
			<?=$form->text("chgName",array('size'=>30))?>
			<?=$form->button("확인",array('div'=>false,'id'=>'btn-edit','class'=>'btn'))?>
			<?=$form->button("삭제",array('div'=>false,'id'=>'btn-del','class'=>'btn'))?>

			<div id='menu-module'>
				<table class='tbl-menu-module' style="width:100%">
				<tr>
					<th class="left" nowrap='nowrap'>링크정보</th>
					<td class='td-left' id='copy-url'><input id='menu-url' style='border:none;width:99%' /></td>
				</tr>
				<tr>
					<th class="left" nowrap='nowrap'>서브메뉴</th>
					<td class='td-left'><?=$form->select("submenu",$submenus)?></td>
				</tr>
				<tr>
					<th class="left" nowrap='nowrap'><?=$form->radio('module',array('Link'=>'링크'))?></th>
					<td class='td-left'><?=$form->text("Link.link",array('value'=>'http://','size'=>30,'class'=>'menu-pass w150px'))?>
					<?=$form->text("Link.key",array('size'=>10))?>
					</td>
				</tr>
				<?php foreach($modules as $module):?>
				<tr>
					<th class="left" nowrap='nowrap'>
					<?=$form->hidden($module['controller'].".model",array('value'=>$module['model']))?>
					<?=$form->hidden($module['controller'].".controller",array('value'=>$module['controller']))?>
					<?=$form->hidden($module['controller'].".action",array('value'=>$module['action']))?>
					<?=$form->radio('module',array($module['controller']=>$module['name']))?></th>
					<td class='td-left'><?=$form->select($module['controller'].".pass",$module['data'],null,array('class'=>'menu-pass','empty'=>'::: 컨텐트 선택 :::'))?></td>
				</tr>
				<?php endforeach;?>

				<tr>
					<th class='center'>+</th>
					<td class='td-left' id='copy-url'>
					x : <?=$form->text('x',array('size'=>'2'))?>
					y : <?=$form->text('y',array('size'=>'2'))?>
					z : <?=$form->text('z',array('size'=>'2'))?>
					<div>플래시 메뉴 인덱스로 이용하시면 됩니다.</div>
					</td>
				</tr>

				<tr>
					<th class="left">Params</th>
					<td class='td-left' id='copy-url'><?=$form->text('params',array('class'=>'menu-pass w99ps'))?><div>/category:값/page:1 현식으로 입력하세요</td>
				</tr>

				</table>
			</div>
		</td></tr>
		<tr><th class='th-left'>정렬</th></tr>
		<tr><td class='td-left'><?=$form->button("▲ 위로",array('id'=>'btn-up','class'=>'btn'))?><?=$form->button("▼ 아래로",array('id'=>'btn-down','class'=>'btn'))?></td></tr>
		</table>

		<?=$form->end()?>

	</div>

</div>

