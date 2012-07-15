<?php


$editor_id = $editor_id ? $editor_id:'editor';



?>

<link href="/fileattach/css/swfupload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/fileattach/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="/fileattach/js/handler.js"></script>
<script type="text/javascript" src="/fileattach/js/fileattach.js"></script>

<script type="text/javascript">
//<![CDATA[


	function pasteImage(path){
	
		var align = arguments[0];

		if( swfCurrentObj == null ){
			alert("파일을 선택하세요~!!");
			return;
		}
		fname = $(swfCurrentObj).attr('name');

		if( /(jepg|jpg|png|gif|bmp)$/i.test(fname) ){
			if( align == "L" ){
				swfImg = '<img align="left" border="0" src="/' + $(swfCurrentObj).attr('src') + '" alt="' + fname + '" />';
			}else if( align == "R" ){
				swfImg = '<img align="right" border="0" src="/' + $(swfCurrentObj).attr('src') + '" alt="' + fname + '"/>';
			}else{
				swfImg = '<img border="0" src="/' + $(swfCurrentObj).attr('src') + '" alt="' + fname + '"/>';
			}
		}else{
			swfImg = '<a href="/fileattach/download/' +  $(swfCurrentObj).attr('id') + '" title="' + fname + '">' + fname + '</a>';
		}

		try{

			var oEditor = CKEDITOR.instances.<?=$editor_id;?>;
			
			if (oEditor.mode == 'wysiwyg' ){
				oEditor.insertHtml( swfImg ) ;
			}else{
				alert( 'You must be on WYSIWYG mode!' ) ;
			}
			
		}catch(e){
		
			try{
				cheditor.insertContents(swfImg);
			}catch(e){
				alert(e.message);
			}
			
		}
	}//end of pasteImage;
	
	function finit(){

		var settings = {
			flash_url : "/fileattach/js/swfupload/Flash/swfupload.swf",
			upload_url: "/fileattach/init",	// Relative to the SWF file
			post_params: {'module':"<?=@$module?>",'model':"<?=@$model?>",'dir':"<?=@$dir?>",'parent_id':"<?=@$id?>","PHPSESSID":"<?=@$session->id();?>"},
			file_size_limit : "<?=@$file_size_limit;?> MB",
			file_types : "<?=$file_types;?>",
			file_types_description : "Files",
			file_upload_limit : <?=@$file_upload_limit?>,
			file_queue_limit : file_count,
			custom_settings : {
				progressTarget : "fsUploadProgress",
				cancelButtonId : "btnCancel"
			},
			debug: false,

			// Button settings
			button_image_url: "/fileattach/img/XPButtonNoText_61x22.png",	// Relative to the Flash file
			button_width: "62",
			button_height: "22",
			button_placeholder_id: "spanButtonPlaceHolder",
			button_text: '<span class="theFont">Upload</span>',
			button_text_style: ".theFont { font-family:Dotum; font-size: 9pt; }",
			button_text_left_padding: 12,
			button_text_top_padding: 3,
				
			// The event handler functions are defined in handlers.js
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
			queue_complete_handler : queueComplete	// Queue plugin event
		};

		swfu = new SWFUpload(settings);


	}

	function uploadSuccess(file, serverData) {
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setComplete();
			progress.setStatus("Complete.");
			progress.toggleCancel(false);
			data = eval(serverData);

			if(data.error != 0 ){
				window.alert(data.error);
				return;
			}

			file_count++;

				var label = '';
				if( /(jpeg|jpg|gif|png)$/i.test(data.name) ){
					label = " <input type='radio' name='label' class='flabel' value='" + data.bid +":" + data.id + ":' />";
				}
							
			$('#file-list').append($('<li id="' + data.id + '" size="' + data.size + '" src="' + data.path + data.fsname + '" onclick="setFile(this)"  name="' + data.name + '"  onmouseover="filepreview(this)"></li>').html("<a href='javascript:void(0)'  onclick=\"delFile(" + data.id + ")\"><img src='/fileattach/img/icon_del.png' alt='Delete File'  border='0' /></a> " + data.name + label ));

			file_size = get_file_size_string(file_size)+parseFloat(data.size);

			$('#file-size').text(get_file_size(file_size));
			$('#file-count').text(file_count);
			
			setFileExpose();
		} catch (ex) {
			this.debug(ex);
		}
	}


//]]>
</script>



<script type='text/javascript'>
//<[DATA[			

var	file_count	 = 0;
var file_size	 = 0;
var file_size_limit = "<?=@$file_size_limit;?> MB";
var file_upload_limit = "<?=@$file_upload_limit?>";

$(function(){


	$.ajax({
		url:'/fileattach/get',
		type:'POST',
		data:{'module':"<?=@$module?>",'model':"<?=@$model?>",'dir':"<?=@$dir?>",'parent_id':"<?=@$id?>","PHPSESSID" : "<?=$session->id();?>"},
		dataType:'json',
		success:function(json){

			for( i = 0; i < json.length; i++){
				file_count++;

				file_size += parseFloat(json[i].size);

				var label = '';
				if( /(jpeg|jpg|gif|png)$/i.test(json[i].name) ){
					checked = '';
					if( json[i].expose == '1' ) checked = 'checked="checked"';
					label = " <input type='radio' name='label' class='flabel' value='"+json[i].id+ ":" + json[i].parent_id +"' " + checked + " />";
				}
				
				$('#file-list').append($('<li id="' + json[i].id + '" size="' + json[i].size + '" src="' + json[i].path + json[i].fsname+ '" name="' + json[i].name + '" onclick="setFile(this)" onmouseover="filepreview(this)"></li>').html("<a href='javascript:void(0)' onclick=\"delFile(" + json[i].id + ")\"><img src='/fileattach/img/icon_del.png' alt='Delete File'  border='0' /></a> " + json[i].name + label));
			}

			$('#file-size').text(get_file_size(file_size));
			$('#file-count').text(file_count);

			finit();
			
			setFileExpose();
		}
	});

});
//]]>
</script>

<div id="swfupload">
	<div style="margin-left:118px">File : <span id="file-count">0</span> / <?=$file_upload_limit;?> ,  Size : <span id="file-size">0 MB</span> / <?=$file_size_limit?> MB</div>
	<table class='tbl-board-file'>
	<col width='110' />
	<col width='*' />
	<col width='80' />
	<tr>
	<td><div id='preview-img'></div></td>
	<td><div id='file-area'><ul id='file-list'></ul></div>
	</td>
	<td align='right'>

	<div><span id="spanButtonPlaceHolder"></span></div>

	<div style="margin-top:20px">
	<a href="javascript:void(0)" onclick="pasteImage('L')"><img src="/fileattach/img/bt_instimage_left.gif" border="0" alt="선택한 이미지를 왼쪽 정렬로 붙여 넣기 합니다." /></a>
	<a href="javascript:void(0)" onclick="pasteImage()"><img src="/fileattach/img/bt_instimage.gif" border="0" alt="선택한 이미지를 일반 정렬로 붙여 넣기 합니다."  /></a>
	<a href="javascript:void(0)" onclick="pasteImage('R')"><img src="/fileattach/img/bt_instimage_right.gif" border="0" alt="선택한 이미지를 오른쪽 정렬로 붙여 넣기 합니다."  /></a>
	</div>
	</td>
	</tr>
	</table>
	<div id="fsUploadProgress"></div>

</div>
