
<?=$html->css(array("/board/css/skins/".$setup['skin'],'/board/css/gallery'),null,array('inline'=>false));?>

<div id="board-wrap">

	<?=$setup['skin_header']?>

	<?=$this->element('lst');?>

	<?=$setup['skin_footer']?>

</div>