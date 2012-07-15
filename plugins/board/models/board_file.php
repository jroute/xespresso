<?php 
class BoardFile extends BoardAppModel {
	var $name = 'BoardFile';

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
    

	function getFiles($parentId){

		$file = $this->find(array(
						"conditions"=>array("parent_id"=>$parentId),
						"order"=>array('sort'=>'desc')
						));

		return $file['Files'];

	}

	function getFileSize($bid,$parent_id,$sess_id){
		if( $parent_id ){
			$conditions = " AND parent_id=".$parent_id;
		}else{
			$conditions = " AND session_id='".$sess_id."' and parent_id=0";
		}
		$data = $this->query("select sum(size) as size from `".$this->tablePrefix.$this->table."` WHERE 1 AND bid='".$bid."'".$conditions);
		return array_shift(array_shift(array_shift($data)));
	}

	//임시등록 정보 삭제
	function fileDelete($bid,$sess_id){
		if( $this->query("delete from ".$this->tablePrefix.$this->table." where bid='".$bid."' and session_id='".$sess_id."' and parent_id=0") ){

		}
	}
	
	function fileSave($parent_id,$sess_id){
	
		if( !$this->updateAll(array('parent_id'=>$parent_id),array('session_id'=>$sess_id,'parent_id'=>0)) ){
			echo 'Error : '.str_replace(ROOT,'',__FILE__)." line: ". __LINE__; exit;
		}
		if( !empty($parent_id) && !$this->query("update ".$this->tablePrefix.$this->table." set parent_id=".$parent_id." where session_id='".$sess_id."' and parent_id=0") ){
			return true;
		}else{
			return false;
		}
	}

	function remove($id,$parentId=null,$sort=null){

		if( $id ){
			$this->id = $id;
			$data = $this->find();
		}else{
			$data = $this->find('all',array(
							"conditions"=>array("parent_id"=>$parentId,'sort'=>$sort),
							"order"=>array('sort'=>'desc')
							));
		}
		if( count($data) > 0  ){

			foreach($data as $_file ){
				$file = $_file['BoardFile'];
				if( @unlink(APP.'files/board/'.$file['fspath']) ){

				}else{

				}
				$this->delete($file['id']);
			}
		}
	}


	function getExtension($file){
		$ext = strtolower(array_pop(explode(".",$file)));
		if( empty($ext) ) return 'none';

		if( in_array($ext,$this->extensions) ){
			return $ext;
		}else{
			return 'unknown';
		}
	}
	
	
	function getFileExtension($filename){
		$ext = substr($filename,strrpos($filename,'.')+1);
		
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