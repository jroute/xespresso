<?
ini_set('session.use_trans_sid', 0);
ini_set('url_rewriter.tags', '');
ini_set('session.serialize_handler', 'php');
ini_set('session.use_cookies', 1);
ini_set('session.name', 'PLANI');
ini_set('session.cookie_lifetime', 3600);
ini_set('session.cookie_path', '/');
ini_set('session.auto_start', 0);
//ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'].'/tmp/' . 'sessions');

session_start();

$session = @$_SESSION['Persnal'];


?>