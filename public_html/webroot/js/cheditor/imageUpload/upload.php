<?php
// ---------------------------------------------------------------------------
//                              CHXImage
//
// �� �ڵ�� ���� ���ؼ� �����˴ϴ�.
// ȯ�濡 �°� ���� �Ǵ� �����Ͽ� ����� �ֽʽÿ�.
//
// ---------------------------------------------------------------------------

require_once("config.php");

//----------------------------------------------------------------------------
//
//
$tempfile = $_FILES['file']['tmp_name'];
$filename = $_FILES['file']['name'];

// demo.html ���Ͽ��� ������ SESSID ���Դϴ�.
$sessid   = $_POST['sessid'];

// ���� ���� �̸�
// $savefile = SAVE_DIR . '/' . $_FILES['file']['name'];

$pos = strrpos($filename, '.');
$ext = substr($filename, $pos, strlen($filename));
$random_name = random_generator() . $ext;
$savefile = SAVE_DIR . '/' . $random_name;
move_uploaded_file($tempfile, $savefile);
$imgsize = getimagesize($savefile);
$filesize = filesize($savefile);

if (!$imgsize) {
	$filesize = 0;
	$random_name = '-ERR';
	unlink($savefile);
};

$rdata = sprintf( "{ fileUrl: '%s/%s', filePath: '%s/%s', origName: '%s', fileName: '%s', fileSize: '%d' }",
	SAVE_URL,
	$random_name,
	SAVE_DIR,
	$random_name,
	$filename,
	$random_name,
	$filesize );

echo $rdata;

function random_generator ($min=8, $max=32, $special=NULL, $chararray=NULL) {
// ---------------------------------------------------------------------------
//
//
    $random_chars = array();
    
    if ($chararray == NULL) {
        $str = "abcdefghijklmnopqrstuvwxyz";
        $str .= strtoupper($str);
        $str .= "1234567890";

        if ($special) {
            $str .= "!@#$%";
        }
    }
    else {
        $str = $charray;
    }

    for ($i=0; $i<strlen($str)-1; $i++) {
        $random_chars[$i] = $str[$i];
    }

    srand((float)microtime()*1000000);
    shuffle($random_chars);

    $length = rand($min, $max);
    $rdata = '';
    
    for ($i=0; $i<$length; $i++) {
        $char = rand(0, count($random_chars) - 1);
        $rdata .= $random_chars[$char];
    }
    return $rdata;
}

?>
