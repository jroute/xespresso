<?php 
class FckHelper extends Helper
{
    function load($id, $toolbar = 'Default',$w='100%',$h=300,$time=0,$expand='true') {
		$did = "";
        foreach (explode('/', $id) as $v) {
             $did .= ucfirst($v);
        }

        return <<<__FCK_CODE__
<script type="text/javascript">
//<![CDATA[
	fckLoader_$did = function () {
		bFCKeditor_$did = new FCKeditor('$did','$w','$h');
		bFCKeditor_$did.Config['ToolbarStartExpanded'] = $expand ;
		bFCKeditor_$did.BasePath = '/js/fckeditor/';
		bFCKeditor_$did.ToolbarSet = '$toolbar';
		bFCKeditor_$did.ReplaceTextarea();
	}

	setTimeout("fckLoader_$did()",$time);
//]]>
</script>
__FCK_CODE__;
    }
}