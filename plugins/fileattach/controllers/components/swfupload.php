<?php 

class SwfuploadComponent extends Object {
	
	/* component configuration */
	var $name = 'SwfuploadComponent';
	var $params = array();
	var $errorCode = null;
	var $errorMessage = null;
	
	// file and path configuration
	var $uploadpath;
	var $webpath = '/files/';
	var $overwrite = false;
	var $filename;
	var $savefilename;
	var $filetype = null;

	
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
	function upload($dir) {
		$ok = false;

		$this->uploadpath .= $dir .DS;

		if ($this->validate()) {
			$this->filename = $this->params['form']['Filedata']['name'];
			$this->filetype = $this->params['form']['Filedata']['type'];			
			$ok = $this->write();

		}

		if (!$ok) {
//			header("HTTP/1.0 500 Internal Server Error");	//this should tell SWFUpload what's up
			if( $this->errorCode == '' ){
				$this->setError();	//this should tell standard form what's up
			}
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
		$fileext = strtolower(array_pop($fileparts));
		$filebase = implode('.', $fileparts);

		if( !eregi("/swf|flv|mov|avi|asf|wmv|bmp|jpeg|jpg|png|gif|pdf/i", $fileext) ){
			$this->savefilename = sprintf('%s.%s',md5($this->filename.$this->microtime_float()),$fileext.'_');
		}else{
			$this->savefilename = sprintf('%s.%s',md5($this->filename.$this->microtime_float()),$fileext);
		}


		if (is_array($existing_files)) {
			do {
				$newfile = $filebase . $filesuffix . '.' . $fileext;
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
			
			if( !is_dir($this->uploadpath))
			{
				$this->setError(1000, 'Not exists folder. Path : '.$this->uploadpath);
			}
			elseif( !file_exists($this->params['form']['Filedata']['tmp_name']) )
			{
				$this->setError(1000, 'Not exists file.');
			}
			elseif (!($moved = move_uploaded_file($this->params['form']['Filedata']['tmp_name'], $this->uploadpath . $this->savefilename))) 
			{
			
				if (!($moved = copy($this->params['form']['Filedata']['tmp_name'], $this->uploadpath . $this->savefilename))) 
				{
					$this->setError(1000, 'File system save failed.(copy)');			
				}else{
					$this->setError(1000, 'File system save failed.');
				}
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

}
