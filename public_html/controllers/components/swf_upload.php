<?php 
/* $Id$ */
/**
 * SwfUploadComponent - A CakePHP Component to use with SWFUpload
 * Copyright (C) 2006-2007 James Revillini <james at revillini dot com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 2.1 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

/**
 * SwfUploadComponent - A CakePHP Component to use with SWFUpload
 * Thanks to Eelco Wiersma for the original explanation on handling 
 * uploads from SWFUpload in CakePHP. Also, thanks to gwoo for guidance 
 * and help refactoring for performance optimization and readability.
 * @author James Revillini http://james.revillini.com
 * @version 0.1.4
 */
 
/**
 * @package SwfUploadComponent
 * @subpackage controllers.components
 */
class SwfUploadComponent extends Object {
	
	/* component configuration */
	var $name = 'SwfUploadComponent';
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
		$this->uploadpath = 'files' . '/';

		//keep tabs on mr. controller's params
		$this->params = $controller->params;

	}
	
	/**
	 * Uploads a file to location
	 * @return boolean true if upload was successful, false otherwise.
	 */
	function upload($path) {
		$ok = false;

		$this->uploadpath .= $path . '/';

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
			$this->savefilename = md5($this->filename.$this->microtime_float()).$fileext.'_';
		}else{
			$this->savefilename = md5($this->filename.$this->microtime_float()).$fileext;
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
			uses('folder');
		}
		
		$moved = false;
		$folder = new Folder($this->uploadpath, true, 0777);
		
		if (!$folder) {
			$this->setError(1500, 'File system save failed.', 'Could not create requested directory: ' . $this->uploadpath);
		} else {
			if (!$this->overwrite) {
				$contents = $folder->ls();  //get directory contents
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


	function output($bid,$no=null,$sessid=null,$fpath="",$ftype="*.*",$fsize="100 MB",$limit="10") {

		$swfupload = <<<__SWFUPLOAD__
<link href="/js/swfupload/default.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='/js/swfupload/swfupload.js'></script>
<script type="text/javascript" src="/js/swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="/js/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="/js/swfupload/boards_handlers.js"></script>

<script type='text/javascript'>
//<![CDATA[

	$(function(){

		var settings = {
			flash_url : "/js/swfupload/Flash/swfupload.swf",
			upload_url: "/boards_files/upload/$fpath",	// Relative to the SWF file
			post_params: {'bid':"{$bid}",'parent_id':"{$no}","PHPSESSID" : "{$sessid}"},
			file_size_limit : "{$fsize}",
			file_types : "{$ftype}",
			file_types_description : "Files",
			file_upload_limit : {$limit},
			file_queue_limit : 0,
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

	});


	$.ajax({
		url:'/boards_files/get_file_list',
		type:'POST',
		data:{'parent_id':'{$no}'},
		dataType:'json',
		success:function(json){

			for( i = 0; i < json.length; i++){
				$('#file-list').append($('<li id="' + json[i].id + '" src="' + json[i].fspath + '" name="' + json[i].name + '" onclick="setFile(this)" onmouseover="filepreview(this)"></li>').html("<a href='javascript:void(0)' onclick='delFile(" + json[i].id + ")'><img src='/img/boards/skins/default/icon_del.png' alt='삭제'  border='0' /></a> " + json[i].name));
			}
		}
	});

	//파일 삭제
	function delFile(id){
		if( confirm('삭제하시겠습니까?') ){
			$.ajax({
				url:'/boards_files/delete/' + id,
				success:function(result){
					if( result == "ok" ){	
						
						$('#' + id).slideUp(1000,function(){
									$('#' + id).remove()

									if( $(swfCurrentObj).attr('id') == id ){
										swfCurrentObj = null;
										$('#preview-img').empty();
									}
								}
						);
						
					}else{
						window.alert('삭제 할 수 없습니다.');
					}
				}
			});
		}
	}

	var swfCurrentObj = null;
	function setFile(obj){
		obj.className = "swfactive";
		if( swfCurrentObj == obj ) return;
		if( swfCurrentObj ) swfCurrentObj.className = '';
		swfCurrentObj = obj;
	}

	function filepreview(obj){
		var _this = $(obj);	

		if( /(jpeg|jpg|gif|png)$/i.test(_this.attr('src')) ){
			$('#preview-img').empty();
			$('#preview-img').append($('<img>').attr({'src':'/' + _this.attr('src'),'width':100,'height':75}));
		}
	};

	function pasteImage(){
		var align = arguments[0];

		if( swfCurrentObj == null ){
			alert("파일을 선택하세요~!!");
			return;
		}
		fname = swfCurrentObj.getAttribute('name');

		if( /(jpeg|jpg|png|gif)$/i.test(fname) ){
			if( align == "L" ){
				swfImg = '<img align="left" border="0" src="/' + $(swfCurrentObj).attr('src') + '" alt="' + fname + '" />';
			}else if( align == "R" ){
				swfImg = '<img align="right" border="0" src="/' + $(swfCurrentObj).attr('src') + '" alt="' + fname + '"/>';
			}else{
				swfImg = '<img border="0" src="/' + $(swfCurrentObj).attr('src') + '" alt="' + fname + '"/>';
			}
		}else{
			swfImg = '<a href="/' + $(swfCurrentObj).attr('src') + '" title="' + fname + '">' + fname + '</a>';
		}

		try{
			var oEditor = CKEDITOR.instances.boardeditor;
			
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
	}

//]]>
</script>
<style type='text/css'>
	#preview-img {
		border:1px solid #808080;
		width:100px;
		height:75px;
	}

	#file-area {
		border:1px solid #808080;
		width:100%;
		height:75px;
		overflow:auto;
	}

	#file-list {
		list-style:none;
	}

	.swfactive {
		background:#11A0D0;
		color:#fff;
	}
	.progressContainer {
		margin:5px 0 !important;
	}
</style>


<div id="swfupload">
	<table class='tbl-board-file'>
	<col width='110' />
	<col width='*' />
	<col width='80' />
	<tr>
	<td><div id='preview-img'></div></td>
	<td><div id='file-area'><ul id='file-list'></ul></div>
	</td>
	<td align='right'><div>	<span id="spanButtonPlaceHolder"></span></div>
	<div id="divStatus" style='display:none'>0 Files</div>
	<div style='margin-top:20px'>
	<a href="javascript:void(0)" onclick="pasteImage('L')"><img src='/img/boards/skins/default/bt_instimage_left.gif' border='0' alt="선택한 이미지를 왼쪽 정렬로 붙여 넣기 합니다." /></a>
	<a href="javascript:void(0)" onclick="pasteImage()"><img src='/img/boards/skins/default/bt_instimage.gif' border='0' alt="선택한 이미지를 일반 정렬로 붙여 넣기 합니다."  /></a>
	<a href="javascript:void(0)" onclick="pasteImage('R')"><img src='/img/boards/skins/default/bt_instimage_right.gif' border='0' alt="선택한 이미지를 오른쪽 정렬로 붙여 넣기 합니다."  /></a>
	</div>
	</td>
	</tr>
	</table>
	<table>
		<tr><td width="110"></td><td><div id="fsUploadProgress"></div></td></tr>
	</table>
</div>

__SWFUPLOAD__;

		return $swfupload;
	}
}
