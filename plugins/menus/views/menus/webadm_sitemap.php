<?=$html->css('/menus/css/slickmap')?>
<?
$active = array();
switch($lang){
	default:
	case "kor":
		$active[0] = 'active';
		break;
	case "eng":
		$active[1] = 'active';
		break;
}
?>

<div id="navigation-bar">
	<div id="navigation-title"><h3>사이트맵</h3></div>
	<div id="navigation-control">
		<?=$form->select('lang',$language,$lang,array('url'=>'/webadm/menus/sitemap','id'=>'change-lang','empty'=>false));?>
	</div>
</div>

<div id="content">

	<br />
	<br />
	<br />
	<br />
	<div class="sitemap">

	<h1>사이트 맵</h1>
	<ul  id="primaryNav">
	<li id="home"><a>Home</a></li><?
	$beforSub = 0;
		foreach($categories as $key=>$category){

		$sub = substr_count($category['name'],'━');
		$category['name'] = strtr($category['name'],array('━'=>''));

		if( $category['controller'] ){
			$link = '/'.implode('/',array($category['controller'],$category['action'],$category['pass'])).$category['params'];
		}else{
			$link = '';
		}

		if( $sub == $beforSub ){
			echo "<li id='$key'><a title='$key'>{$category['name']}<br /><span>$link</span></a>";
		}else if( $sub > $beforSub ){
			echo "\n<ul>\n<li id='$key'><a title='$key'>{$category['name']}<br /><span>$link</span></a>";
		}else if( $sub < $beforSub ){
			for( $i = 0 ; $i < ($beforSub-$sub) ; $i++ ){
				echo "</li></ul>\n";
			}
			echo "\n</li><li id='$key'><a title='$key'>{$category['name']}<br /><span>$link</span></a>";
		}


		$beforSub = $sub;
	}
	?>
	</li></ul>
	</li></ul>

	</div>

	</div>


</div>

