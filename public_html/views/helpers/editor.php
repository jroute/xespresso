<?php 
class EditorHelper extends Helper
{
	var $editor = array(
		'ckeditor'=>'CKEditor',
		'cheditor'=>'CHEditor'
	);

    function load($type='cheditor',$id, $w='99%',$h=300) {
		
		$did = "";
        foreach (explode('/', $id) as $v) {
             $did .= ucfirst($v);
        }
        

		switch($type){
			default:
			case "ckeditor":

		        return <<<__CODE__

<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
//<![CDATA[

	CKEDITOR.replace( '{$id}',
		{
			width:'{$w}',
			height:'{$h}',
		//*
			toolbar :'xEspresso'
		});

//]]>
</script>

__CODE__;

				break;

			case "cheditor":
				
			if( !ereg('%',$w) ) $w = $w.'px';
			if( !ereg('%',$h) ) $h = $h.'px';

		        return <<<__CODE__

<script type="text/javascript" src="/js/cheditor/cheditor.js"></script>
<script type="text/javascript">
//<![CDATA[
	
	var cheditor = new cheditor("cheditor");
	cheditor.config.editorHeight = '{$h}';             // 에디터 세로폭입니다.
	cheditor.config.editorWidth = '{$w}';                // 에디터 가로폭입니다.
	cheditor.config.imgReSize = true;
	cheditor.config.fullHTMLSource = false;
	cheditor.inputForm = "{$id}";
	
	function getImages ()
	{
		var img = cheditor.getImages();
	
		if(img){
			var txt = '';
			for (var i=0; i < img.length; i++){
				txt += '저장 URL: '    + img[i]['fileUrl'] + '\\n' +
						'저장 파일명: ' + img[i]['origName'] + '\\n' +
						'원본 파일명: ' + img[i]['fileName'] + '\\n' +
						'파일 크기: '   + img[i]['fileSize'] + '\\n\\n'
			}//end of for
			alert(txt);
		}else{
	     alert('삽입한 이미지 정보가 없습니다.');
	  }
	
	  cheditor.returnFalse();
	}
	
	function getHtmlContent(){
	    alert(cheditor.outputHTML());
		cheditor.returnFalse();
	}
	
	function getBodyContent(){
		alert(cheditor.outputBodyHTML());
		cheditor.returnFalse();
	}
	
	function getTextContent(){
	    alert(cheditor.outputBodyText());
		cheditor.returnFalse();
	}
	
	function getContentLength(){
	    alert(cheditor.inputLength());
	}
	
	function getDocumentLength(){
	    alert(cheditor.contentsLengthAll());
	}
	
	
	cheditor.run();

//]]>
</script>
__CODE__;

				break;
		}//end switch;
    }//end of function load
    

    function page($type='cheditor',$id, $w='98%',$h=300) {

		$did = "";
        foreach (explode('/', $id) as $v) {
             $did .= ucfirst($v);
        }

		switch($type){
			default:
			case "ckeditor":

		        return <<<__CODE__

<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
//<![CDATA[
var _editor = null;
function setEditor(){

    var instance = CKEDITOR.instances['{$id}'];
    if(instance)
    {
        CKEDITOR.remove(instance);
    }

		_editor = CKEDITOR.replace( '{$id}',
		{
			width:'{$w}',
			height:'{$h}',
		//*
			toolbar :
			[
				['Source','DocProps','-','Save','NewPage','Preview','-','Templates'],
				['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
				['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
//				['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
				'/',
				['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
				['OrderedList','UnorderedList','-','Outdent','Indent','Blockquote'],
				['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
				['Link','Unlink','Anchor'],
				['Image','Flash','Table','Rule','Smiley','SpecialChar','PageBreak'],
				'/',
				['Style','FontFormat','FontName','FontSize'],
				['TextColor','BGColor'],
				['ShowBlocks'] // No comma for the last row.
				
			]
			//*/
		});
}
//]]>
</script>

__CODE__;

				break;

			case "cheditor":
				
			if( !ereg('%',$w) ) $w = $w.'px';
			if( !ereg('%',$h) ) $h = $h.'px';

		        return <<<__CODE__

<script type="text/javascript" src="/js/cheditor/cheditor.js"></script>
<script type="text/javascript">
//<![CDATA[
var _editor = null;
function setEditor(){
	
	_editor = new cheditor("cheditor");
	_editor.config.editorHeight = '{$h}';             // 에디터 세로폭입니다.
	_editor.config.editorWidth = '{$w}';                // 에디터 가로폭입니다.
	_editor.config.imgReSize = true;
	_editor.config.fullHTMLSource = false;
	_editor.inputForm = "{$id}";
	
	function getImages ()
	{
		var img = cheditor.getImages();
	
		if(img){
			var txt = '';
			for (var i=0; i < img.length; i++){
				txt += '저장 URL: '    + img[i]['fileUrl'] + '\\n' +
						'저장 파일명: ' + img[i]['origName'] + '\\n' +
						'원본 파일명: ' + img[i]['fileName'] + '\\n' +
						'파일 크기: '   + img[i]['fileSize'] + '\\n\\n'
			}//end of for
			alert(txt);
		}else{
	     alert('삽입한 이미지 정보가 없습니다.');
	  }
	
	  _editor.returnFalse();
	}
	
	function getHtmlContent(){
	    alert(_editor.outputHTML());
		_editor.returnFalse();
	}
	
	function getBodyContent(){
		alert(_editor.outputBodyHTML());
		_editor.returnFalse();
	}
	
	function getTextContent(){
	    alert(_editor.outputBodyText());
		_editor.returnFalse();
	}
	
	function getContentLength(){
	    alert(_editor.inputLength());
	}
	
	function getDocumentLength(){
	    alert(_editor.contentsLengthAll());
	}
	
	
	_editor.run();
}
//]]>
</script>
__CODE__;

				break;
		}//end switch;
    }//end of function page    
}//end of class