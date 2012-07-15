<?php 

class BoardFileUploadComponent extends Object {
	
	/* component configuration */
	var $name = 'BoardFileUploadComponent';
	var $params = array();
	var $errorCode = null;
	var $errorMessage = null;
	
	// file and path configuration
	var $uploadpath;
	var $webpath = '/files/';
	var $overwrite = false;
	var $filename;
	var $savefilename;

	
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	/**
	 * Contructor function
	 * @param Object &$controller pointer to calling controller
	 */
	function startup(&$controller) {
		// initialize members
		$this->uploadpath = APP.'webroot'.DS.'files'.DS;

		//keep tabs on mr. controller's params
		$this->params = $controller->params;

	}
	
	/**
	 * Uploads a file to location
	 * @return boolean true if upload was successful, false otherwise.
	 */
	function upload($bid) {
		$ok = false;

		$this->uploadpath .= 'board'.DS.$bid .DS;

		if ($this->validate()) {
			$this->filename = $this->params['form']['Filedata']['name'];
			$ok = $this->write();
		}
		
		if (!$ok) {
			header("HTTP/1.0 500 Internal Server Error");	//this should tell SWFUpload what's up
			$this->setError();	//this should tell standard form what's up
		}
		
		return ($ok);
	}
	
	/**
	 * finds a unique name for the file for the current directory
	 * @param array an array of filenames which exist in the desired upload directory
	 * @return string a unique filename for the file
	 */
	function findUniqueFilename($existing_files = null) {
		// append a digit to the end of the name
		$filenumber = 0;
		$filesuffix = '';
		$fileparts = explode('.', $this->filename);
		$fileext = '.' . array_pop($fileparts);
		$filebase = implode('.', $fileparts);

		if( !eregi("jpeg|jpg|png|gif",$fileext) ){
			$this->savefilename = $this->microtime_float().$fileext.'.x';
		}else{
			$this->savefilename = $this->microtime_float().$fileext;
		}


		if (is_array($existing_files)) {
			do {
				$newfile = $filebase . $filesuffix . $fileext;
				$filenumber++;
				$filesuffix = '(' . $filenumber . ')';
			} while (in_array($newfile, $existing_files));
		}
		
		return $newfile;
	}

	/**
	 * moves the file to the desired location from the temp directory
	 * @return boolean true if the file was successfully moved from the temporary directory to the desired destination on the filesystem
	 */
	function write() {
	
		// Include libraries
		if (!class_exists('Folder')) {
			App::Import('Core','Folder');
//			uses('folder');
		}
		
		$moved = false;
		$folder = new Folder($this->uploadpath, true, 0777);
		
		if (!$folder) {
			$this->setError(1500, 'File system save failed.', 'Could not create requested directory: ' . $this->uploadpath);
		} else {
			if (!$this->overwrite) {
				$contents = $folder->read();  //get directory contents
				$this->filename = $this->findUniqueFilename($contents[1]);  //pass the file list as an array
			}
			if (!($moved = move_uploaded_file($this->params['form']['Filedata']['tmp_name'], $this->uploadpath . $this->savefilename))) {
				$this->setError(1000, 'File system save failed.');
			}
			@chmod($this->uploadpath . $this->savefilename,0666);
		}
		return $moved;
	}
	
	/**
	 * validates the post data and checks receipt of the upload
	 * @return boolean true if post data is valid and file has been properly uploaded, false if not
	 */
	function validate() {
		$post_ok = isset($this->params['form']['Filedata']);
		$upload_error = $this->params['form']['Filedata']['error'];
		$got_data = (is_uploaded_file($this->params['form']['Filedata']['tmp_name']));
		
		if (!$post_ok){
			$this->setError(2000, 'Validation failed.', 'Expected file upload field to be named "Filedata."');
		}
		if ($upload_error){
			$this->setError(2500, 'Validation failed.', $this->getUploadErrorMessage($upload_error));
		}
		return !$upload_error && $post_ok && $got_data;
	}
	
	/**
	 * parses file upload error code into human-readable phrase.
	 * @param int $err PHP file upload error constant.
	 * @return string human-readable phrase to explain issue.
	 */
	function getUploadErrorMessage($err) {
		$msg = null;
		switch ($err) {
			case UPLOAD_ERR_OK:
				break;
			case UPLOAD_ERR_INI_SIZE:
				$msg = ('The uploaded file exceeds the upload_max_filesize directive ('.ini_get('upload_max_filesize').') in php.ini.');
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$msg = ('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.');
				break;
			case UPLOAD_ERR_PARTIAL:
				$msg = ('The uploaded file was only partially uploaded.');
				break;
			case UPLOAD_ERR_NO_FILE:
				$msg = ('No file was uploaded.');
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$msg = ('The remote server has no temporary folder for file uploads.');
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$msg = ('Failed to write file to disk.');
				break;
			default:
				$msg = ('Unknown File Error. Check php.ini settings.');
		}
		
		return $msg;
	}
	
	/**
	 * sets an error code which can be referenced if failure is detected by controller.
	 * note: the amount of info stored in message depends on debug level.
	 * @param int $code a unique error number for the message and debug info
	 * @param string $message a simple message that you would show the user
	 * @param string $debug any specific debug info to include when debug mode > 1
	 * @return bool true unless an error occurs
	 */
	function setError($code = 1, $message = 'An unknown error occured.', $debug = '') {
		$this->errorCode = $code;
		$this->errorMessage = $message;
		if (DEBUG) {
			$this->errorMessage .= $debug;
		}
		return true;
	}


	function _ajaxupload(&$setup,$bid,$no=null,$sessid=null,$fpath="",$ftype="*.*",$fsize="100 MB",$limit="10"){
		

		$fileupload =<<<__FILEUPLOAD__
<script type='text/javascript' src='/js/ajaxupload.js'></script>
<script type= "text/javascript">
/*<![CDATA[*/
function finit(){

	var button = $('#fileupload');

	new AjaxUpload(button,{
		//action: 'upload-test.php', // I disabled uploads in this example for security reasons
		action: '/board/fileupload/{$bid}/{$no}', 
		name:'Filedata',
		onSubmit : function(file, ext){


			if( board_file_size > get_file_size_string(board_limit_size) ){
				window.alert("더이상 파일 업로드를 할 수 없습니다.\\n파일 용량 초과");
				return false;
			}

			if( board_file_count >= board_limit_count ){
				window.alert("더이상 파일 업로드를 할 수 없습니다.\\n파일 업로드 개수 초과");
				return false;
			}

			// change button text, when user selects file			
			button.val('Uploading');
			
			// If you want to allow uploading only 1 file at time,
			// you can disable upload button
			this.disable();
			
			// Uploding -> Uploading. -> Uploading...
			interval = window.setInterval(function(){
				var text = button.text();
				if (text.length < 13){
					button.val(text + '.');					
				} else {
					button.val('Uploading');				
				}
			}, 200);
		},
		onComplete: function(file, response){
			button.val('Upload');

			window.clearInterval(interval);

			json = eval(response);

			// enable upload button
			this.enable();
			if(json.error != 0 ){
				window.alert(json.error);
				return;
			}
			// add file to the list
			$('#file-list').append($('<li id="' + json.id + '" size="' + json.size + '" src="' + json.path + '" name="' + json.name + '" onclick="setFile(this)" onmouseover="filepreview(this)"></li>').html("<a href='javascript:void(0)' onclick=\"delFile('{$bid}', " + json.id + ")\"><img src='/board/img/skins/default/icon_del.png' alt='Delete File'  border='0' /></a> " + json.name));
			board_file_count++;
			board_file_size = board_file_size+json.size;
			$('#board-file-size').text(get_file_size(board_file_size));
			$('#board-file-count').text(board_file_count);

		}
	});

}
/*]]>*/
</script>

__FILEUPLOAD__;

		return $fileupload;
	}


	function _swfupload(&$setup,$bid,$no,$sessid,$fpath,$ftype,$fsize,$limit){

		$fsize = $fsize.' MB';

		$swfupload = <<<__SWFUPLOAD__
<link href="/js/swfupload/default.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='/js/swfupload/swfupload.js'></script>
<script type="text/javascript" src="/js/swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="/js/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="/js/swfupload/board_handlers.js"></script>

<script type="text/javascript">
//<![CDATA[

	function finit(){

		var settings = {
			flash_url : "/js/swfupload/Flash/swfupload.swf",
			upload_url: "/board/fileupload/{$bid}/{$no}",	// Relative to the SWF file
			post_params: {'bid':"{$bid}",'parent_id':"{$no}","PHPSESSID" : "{$sessid}"},
			file_size_limit : "{$fsize}",
			file_types : "{$ftype}",
			file_types_description : "Files",
			file_upload_limit : {$limit},
			file_queue_limit : board_file_count,
			custom_settings : {
				progressTarget : "fsUploadProgress",
				cancelButtonId : "btnCancel"
			},
			debug: false,

			// Button settings
			button_image_url: "/js/swfupload/buttons/XPButtonNoText_61x22.png",	// Relative to the Flash file
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

			board_file_count++;

				var label = '';
				if( /(jpeg|jpg|gif|png)$/i.test(data.name) ){
					label = " <input type='radio' name='label' class='flabel' value='" + data.bid +":" + data.id + ":' />";
				}
							
			$('#file-list').append($('<li id="' + data.id + '" size="' + data.size + '" src="' + data.path + data.fsname + '" onclick="setFile(this)"  name="' + data.name + '"  onmouseover="filepreview(this)"></li>').html("<a href='javascript:void(0)'  onclick=\"delFile('" + data.bid + "', " + data.id + ")\"><img src='/board/img/skins/default/icon_del.png' alt='Delete File'  border='0' /></a> " + data.name + label ));

			board_file_size = board_file_size+parseFloat(data.size)
			$('#board-file-size').text(get_file_size(board_file_size));
			$('#board-file-count').text(board_file_count);
			
			setFileExpose();
		} catch (ex) {
			this.debug(ex);
		}
	}


//]]>
</script>

__SWFUPLOAD__;
		return $swfupload;
	}


	/***
	 * $type : file | swfupload
	 */
	function output(&$setup,$bid,$no=null,$sessid=null,$fpath="",$ftype="*.*",$fsize="100",$limit="10") {
		
		switch($setup['fileupload_type']){
			case "swfupload":
				$_upload = $this->_swfupload($setup,$bid,$no,$sessid,$fpath,$ftype,$fsize,$limit);
				$button_upload = '<div><span id="spanButtonPlaceHolder"></span></div>';
				break;
			default:
			case "ajaxupload":
				$_upload = $this->_ajaxupload($setup,$bid,$no,$sessid=null,$fpath,$ftype,$fsize,$limit);
				$button_upload = '<div style="margin-left:117px"><input type="button" value="Upload" id="fileupload" /></div>';
				break;
		}

		$upload = <<<__UPLOAD__
<link href="/board/css/board.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='/board/js/board.js'></script>
<script type='text/javascript'>
//<[DATA[			
var board_bid		= "$bid";
var board_no		= "$no";
var board_file_count	 = 0;
var board_file_size	 = 0;
var board_limit_size = "$fsize MB";
var board_limit_count = "$limit";

$(function(){


	$.ajax({
		url:'/board/getFileList/{$bid}',
		type:'POST',
		data:{'parent_id':'{$no}'},
		dataType:'json',
		success:function(json){

			for( i = 0; i < json.length; i++){
				board_file_count++;

				board_file_size += parseFloat(json[i].size);
				
				var label = '';
				if( /(jpeg|jpg|gif|png)$/i.test(json[i].name) ){
					checked = '';
					if( json[i].expose == '1' ) checked = 'checked="checked"';
					label = " <input type='radio' name='label' class='flabel' value='"+json[i].bid+":"+json[i].id+ ":" + json[i].parent_id +"' " + checked + " />";
				}
				
				$('#file-list').append($('<li id="' + json[i].id + '" size="' + json[i].size + '" src="' + json[i].path + json[i].fsname+ '" name="' + json[i].name + '" onclick="setFile(this)" onmouseover="filepreview(this)"></li>').html("<a href='javascript:void(0)' onclick=\"delFile('{$bid}'," + json[i].id + ")\"><img src='/board/img/skins/default/icon_del.png' alt='Delete File'  border='0' /></a> " + json[i].name + label));
			}

			$('#board-file-size').text(get_file_size(board_file_size));
			$('#board-file-count').text(board_file_count);

			finit();
			
			setFileExpose();
		}
	});

});
//]]>
</script>

<div id="swfupload">
	<div style="margin-left:118px">File : <span id='board-file-count'>0</span> / $limit ,  Size : <span id='board-file-size'>0 MB</span> / $fsize MB</div>
	<table class='tbl-board-file'>
	<col width='110' />
	<col width='*' />
	<col width='80' />
	<tr>
	<td><div id='preview-img'></div></td>
	<td><div id='file-area'><ul id='file-list'></ul></div>
	</td>
	<td align='right'>
	$button_upload
	<div style='margin-top:20px'>
	<a href="javascript:void(0)" onclick="pasteImage('L')"><img src='/board/img/skins/default/bt_instimage_left.gif' border='0' alt="선택한 이미지를 왼쪽 정렬로 붙여 넣기 합니다." /></a>
	<a href="javascript:void(0)" onclick="pasteImage()"><img src='/board/img/skins/default/bt_instimage.gif' border='0' alt="선택한 이미지를 일반 정렬로 붙여 넣기 합니다."  /></a>
	<a href="javascript:void(0)" onclick="pasteImage('R')"><img src='/board/img/skins/default/bt_instimage_right.gif' border='0' alt="선택한 이미지를 오른쪽 정렬로 붙여 넣기 합니다."  /></a>
	</div>
	</td>
	</tr>
	</table>
	<div id="fsUploadProgress"></div>

</div>

__UPLOAD__;



		return $upload.$_upload;
	}
}