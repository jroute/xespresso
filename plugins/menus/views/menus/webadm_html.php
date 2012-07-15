
<?=$javascript->link(array('jquery/plugins/jsTree/tree_component','jquery/plugins/jsTree/_lib/css','jquery/plugins/jsTree/_lib/jquery.cookie'),false)?>
<?=$html->css(array(
	'/menus/css/style.css',
	'/js/jquery/plugins/jsTree/tree_component'
))?>


<?=$javascript->codeBlock('

$(document).ready(function(){

    $("#tree").tree({
    data    : {
        type    : "predefined", // ENUM [json, xml_flat, xml_nested, predefined]
        method  : "GET",        // HOW TO REQUEST FILES
        async   : false,        // BOOL - async loading onopen
        async_data : function (NODE) { return { id : $(NODE).attr("id") || 0 } }, // PARAMETERS PASSED TO SERVER
        url     : false,        // FALSE or STRING - url to document to be used (async or not)
        json    : false,        // FALSE or OBJECT if type is JSON and async is false - the tree dump as json
        xml     : false         // FALSE or STRING
    },
    selected    : false,        // FALSE or STRING or ARRAY
    opened      : [],           // ARRAY OF INITIALLY OPENED NODES
    languages   : [],           // ARRAY of string values (which will be used as CSS classes - so they must be valid)
    path        : false,        // FALSE or STRING (if false - will be autodetected)
    cookies     : {prefix:"tree1"},        // FALSE or OBJECT (prefix, open, selected, opts - from jqCookie - expires, path, domain, secure)
    ui      : {
        dots        : true,     // BOOL - dots or no dots
        rtl         : false,    // BOOL - is the tree right-to-left
        animation   : 0,        // INT - duration of open/close animations in miliseconds
        hover_mode  : true,     // SHOULD get_* functions chage focus or change hovered item
        scroll_spd  : 4,
        theme_path  : false,    // Path to themes
        theme_name  : "default",// Name of theme
        context     : false
        /*
        [
            {
                id      : "create",
                label   : "Create",
                icon    : "create.png",
                visible : function (NODE, TREE_OBJ) { if(NODE.length != 1) return false; return TREE_OBJ.check("creatable", NODE); },
                action  : function (NODE, TREE_OBJ) { TREE_OBJ.create(false, TREE_OBJ.selected); }
            },
            "separator",
            {
                id      : "rename",
                label   : "Rename",
                icon    : "rename.png",
                visible : function (NODE, TREE_OBJ) { if(NODE.length != 1) return false; return TREE_OBJ.check("renameable", NODE); },
                action  : function (NODE, TREE_OBJ) { TREE_OBJ.rename(); }
            },
            {
                id      : "delete",
                label   : "Delete",
                icon    : "remove.png",
                visible : function (NODE, TREE_OBJ) { var ok = true; $.each(NODE, function () { if(TREE_OBJ.check("deletable", this) == false) ok = false; return false; }); return ok; },
                action  : function (NODE, TREE_OBJ) { $.each(NODE, function () { TREE_OBJ.remove(this); }); }
            }
        ]
    */
    },

    rules   : {
        multiple    : false,    // FALSE | CTRL | ON - multiple selection off/ with or without holding Ctrl
        metadata    : false,    // FALSE or STRING - attribute name (use metadata plugin)
        type_attr   : "rel",    // STRING attribute name (where is the type stored if no metadata)
        multitree   : false,    // BOOL - is drag n drop between trees allowed
        createat    : "bottom", // STRING (top or bottom) new nodes get inserted at top or bottom
        use_inline  : false,    // CHECK FOR INLINE RULES - REQUIRES METADATA
        clickable   : "all",    // which node types can the user select | default - all
        renameable  : "all",    // which node types can the user select | default - all
        deletable   : "all",    // which node types can the user delete | default - all
        creatable   : "all",    // which node types can the user create in | default - all
        draggable   : "none",   // which node types can the user move | default - none | "all"
        dragrules   : "all",    // what move operations between nodes are allowed | default - none | "all"
        drag_copy   : false,    // FALSE | CTRL | ON - drag to copy off/ with or without holding Ctrl
        droppable   : [],
        drag_button : "left"
    },
    lang : {
        new_node    : "New folder",
        loading     : "Loading ..."
    },
    callback    : {             // various callbacks to attach custom logic to
        // before focus  - should return true | false
        beforechange: function(NODE,TREE_OBJ) { return true },
        beforeopen  : function(NODE,TREE_OBJ) { return true },
        beforeclose : function(NODE,TREE_OBJ) { return true },
        // before move   - should return true | false
        beforemove  : function(NODE,REF_NODE,TYPE,TREE_OBJ) { return true },
        // before create - should return true | false
        beforecreate: function(NODE,REF_NODE,TYPE,TREE_OBJ) { return true },
        // before rename - should return true | false
        beforerename: function(NODE,LANG,TREE_OBJ) { return true },
        // before delete - should return true | false
        beforedelete: function(NODE,TREE_OBJ) { return true },

        onselect    : function(NODE,TREE_OBJ) { },                  // node selected
        ondeselect  : function(NODE,TREE_OBJ) { },                  // node deselected
        onchange    : function(NODE,TREE_OBJ) { },                  // focus changed
        onrename    : function(NODE,LANG,TREE_OBJ,RB) { },              // node renamed ISNEW - TRUE|FALSE, current language
        onmove      : function(NODE,REF_NODE,TYPE,TREE_OBJ,RB) { }, // move completed (TYPE is BELOW|ABOVE|INSIDE)
        oncopy      : function(NODE,REF_NODE,TYPE,TREE_OBJ,RB) { }, // copy completed (TYPE is BELOW|ABOVE|INSIDE)
        oncreate    : function(NODE,REF_NODE,TYPE,TREE_OBJ,RB) { }, // node created, parent node (TYPE is createat)
        ondelete    : function(NODE, TREE_OBJ,RB) { },                  // node deleted
        onopen      : function(NODE, TREE_OBJ) { },                 // node opened
        onopen_all  : function(TREE_OBJ) { },                       // all nodes opened
        onclose     : function(NODE, TREE_OBJ) { },                 // node closed
        error       : function(TEXT, TREE_OBJ) { },                 // error occured
        // double click on node - defaults to open/close & select
        ondblclk    : function(NODE, TREE_OBJ) { TREE_OBJ.toggle_branch.call(TREE_OBJ, NODE); TREE_OBJ.select_branch.call(TREE_OBJ, NODE); },
        // right click - to prevent use: EV.preventDefault(); EV.stopPropagation(); return false
        onrgtclk    : function(NODE, TREE_OBJ, EV) { },
        onload      : function(TREE_OBJ) { },
        onfocus     : function(TREE_OBJ) { },
        ondrop      : function(NODE,REF_NODE,TYPE,TREE_OBJ) {}
    }

    });
});
',array('inline'=>false))?>

<div id="navigation-bar">
	<div id="navigation-title"><h3>상/하 컨텐츠 관리</h3></div>
	<div id="navigation-control">
		<?=$form->select('lang',$language,$lang,array('url'=>'/webadm/menus/html','id'=>'change-lang','empty'=>false));?>
	</div>
</div>

<div id="content">

	<div id="menu-html">
		
		<div id="tree">
		
			<ul class='simpleTree'>
			<li id="root" class="root">Home
			<?
		
			echo "<ul id='tree-menu' class='filetree'>";
			$beforSub = 0;
		
			foreach($categories as $key=>$category){
				$sub = substr_count($category,'━');
				$category = strtr($category,array('━'=>''));
		
				if( $sub == $beforSub ){
					echo "<li id='$key' ><a title='$key'>$category</a>";
				}else if( $sub > $beforSub ){
					echo "\n<ul>\n<li id='$key' ><a title='$key'>$category</a>";
				}else if( $sub < $beforSub ){
					for( $i = 0 ; $i < ($beforSub-$sub) ; $i++ ){
						echo "</li></ul>\n";
					}
					echo "\n</li><li id='$key' ><a title='$key'>$category</a>";
				}
		
		
				$beforSub = $sub;
			}
			echo "</li></ul>";
		
			?>
			</li>
			</ul>
		</div>
	</div>


	<div id="html-src">
		<?=$form->create('Menu',array('id'=>'mform',"url"=>$this->here,'onsubmit'=>'return false'))?>
		<?=$form->hidden("Menu.id")?>
		<table class='tbl-list'>
		<tr><th id='add-title' class='th-left'>머리글</th></tr>
		<tr><td class='td-left'>
				<?=$form->textarea("html_header",array('id'=>'html_header','rows'=>10,'class'=>'w99ps'))?>
		</td></tr>
		</table>

		<table class='tbl-list'>
		<tr><th id='add-title' class='th-left'>바닥글</th></tr>
		<tr><td class='td-left'>
				<?=$form->textarea("html_footer",array('id'=>'html_footer','rows'=>10,'class'=>'w99ps'))?>
		</td></tr>
		</table>
        <div class="margin5 center">
        <?=$form->button("저장",array('div'=>false,'id'=>'btn-save','class'=>'button'))?>
        </div>

		<?=$form->end()?>

	</div>

</div>


<script type='text/javascript'>
//<![CDATA[
$(function(){

	$('#menu-html li a').each(function(index){

		var pid = $(this).parent().attr('id');
		$('#MenuId').val(pid);
		$(this).css({'cursor':'pointer'});
		$(this).click(function(){

        	var pid = $(this).parent().attr('id');
			$('#MenuId').val(pid);

			// set options
			$.ajax({
						url: "/webadm/menus/ajax_options/" + pid,
						dataType:'json',
						cache: false,
						success: function(json){
							$('#html_header').val(json['Menu'].html_header?json['Menu'].html_header:" ");
							$('#html_footer').val(json['Menu'].html_footer?json['Menu'].html_footer:" ");
						}
			});// end of $.ajax

		},true);


	});

	
	$('#btn-save').click(function(){
			// set options
			$.ajax({
						url: "/webadm/menus/html",
						type:'post',
						data:$('#mform').serialize(),
						cache: false,
						success: function(rst){
							if(rst == 'success' ){
								window.alert('저장되었습니다.');
							}else{
								window.alert('오류 : 저장 할 수 없습니다.');
							}
							
						}
			});// end of $.ajax
	});

});
//]]>
</script>