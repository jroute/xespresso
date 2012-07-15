<?php
class Fileattach extends AppModel {
	var $name = "Fileattach";
	var $useTable = 'fileattachs';


	var $validate = array(
				'plugin' => array('rule' => 'notEmpty','required' => true),
				'parent_id' => array('rule' => 'notEmpty','required' => true),
				'name' => array('rule' => 'notEmpty','required' => true),
				'fsname' => array('rule' => 'notEmpty','required' => true)
				);

	var $extensions = array(
		'ai','arg','avi',
		'bmp','dll','doc','docx',
		'eps','exe',
		'file','fla',
		'gif','gz',
		'htm','html','hwp',
		'jpg','jpeg',
		'lzh',
		'mid','mov','mp3','mp4','mpeg',
		'pdf','png','ppt','pptx','psd',
		'sql','swf',
		'tar','ttf','txt','tgz',
		'wav',
		'xls','xlsx',
		'Z','zip','rar');
	
	//게시물 등록시 게시물 등록 후 parent_id 값 연결
	function link($sessid,$plugin,$id){
		$this->updateAll(array('parent_id'=>$id),array('deleted'=>null,'plugin'=>$plugin,'session_id'=>$sessid,'OR'=>array('parent_id'=>null,'parent_id'=>0)));
	}
	
	function del($plugin,$id){
	
		$rows = $this->find('all',array('conditions'=>array('deleted'=>null,'plugin'=>$plugin,'parent_id'=>$id)));
		foreach($rows as $row){	
			parent::del($row['Fileattach']['id']);
		}

	}
	


	
	function getFileExtension($filename){
//		$ext = substr($filename,strrpos($filename,'.')+1);
		$ext = strtolower(array_pop(explode(".",$filename)));
		
		if( in_array($ext,$this->extensions) ){
			return $ext;
		}else{
			return 'unknown';
		}
	}


	function getMIMEType($filename = null) {
		if ($filename) {
			$ext = $this->getFileExtension($filename);
			switch (strtolower($ext)) {
				// Image
				case 'gif':
					return 'image/gif';
				case 'jpeg':case 'jpg':case 'jpe':
					return 'image/jpeg';
				case 'png':
					return 'image/png';
				case 'tiff':case 'tif':
					return 'image/tiff';
				case 'bmp':
					return 'image/bmp';
				// Sound
				case 'wav':
					return 'audio/x-wav';
				case 'mpga':case 'mp2':case 'mp3':
					return 'audio/mpeg';
				case 'm3u':
					return 'audio/x-mpegurl';
				case 'wma':
					return 'audio/x-msaudio';
				case 'ra':
					return 'audio/x-realaudio';
				// Document
				case 'css':
					return 'text/css';
				case 'html':case 'htm':case 'xhtml':
					return 'text/html';
				case 'rtf':
					return 'text/rtf';
				case 'sgml':case 'sgm':
					return 'text/sgml';
				case 'xml':case 'xsl':
					return 'text/xml';
				case 'hwp':case 'hwpml':
					return 'application/x-hwp';
				case 'pdf':
					return 'application/pdf';
				case 'odt':case 'ott':
					return 'application/vnd.oasis.opendocument.text';
				case 'ods':case 'ots':
					return 'application/vnd.oasis.opendocument.spreadsheet';	
				case 'odp':case 'otp':
					return 'application/vnd.oasis.opendocument.presentation';
				case 'sxw':case 'stw':	
					return '	application/vnd.sun.xml.writer';
				case 'sxc':case 'stc':	
					return '	application/vnd.sun.xml.calc';
				case 'sxi':case 'sti':	
					return '	application/vnd.sun.xml.impress';
				case 'doc':
					return 'application/vnd.ms-word';
				case 'xls':case 'xla':case 'xlt':
				case 'xlb':
					return 'application/vnd.ms-excel';			
				case 'ppt':case 'ppa':case 'pot':case 'pps':
					return 'application/vnd.mspowerpoint';//ie 7 ¹®Á¦ »ý±è
				case 'vsd':case 'vss':case 'vsw':
					return 'application/vnd.visio';
				case 'docx':case 'docm':
				case 'pptx':case 'pptm':
				case 'xlsx':case 'xlsm':	
					return 'application/vnd.openxmlformats';
				case 'csv':
					return 'text/comma-separated-values'; 
				// Multimedia
				case 'mpeg':case 'mpg':case 'mpe':
					return 'video/mpeg';
				case 'qt':case 'mov':
					return 'video/quicktime';
				case 'avi':case 'wmv':
					return 'video/x-msvideo';
				// Compression
				case 'bz2':
					return 'application/x-bzip2';
				case 'gz':case 'tgz':
					return 'application/x-gzip';
				case 'tar':
					return 'application/x-tar';
				case 'tgz':					
				case 'zip':
					return 'application/zip';
				case 'rar':
					return 'application/x-rar-compressed';
				case '7z':
					return 'application/x-7z-compressed';
				case 'alz':
					return 'application/x-alzip';				
			}
		}
		return '';
	}
		
}
?>