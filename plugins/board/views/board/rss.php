<?php header("Content-type: text/xml; charset=utf-8");?><?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<title><![CDATA[<?=$site['name']?> <?=$setup['bname']?>]]></title>
		<link><?=$site['url']?></link>
		<description><?=$setup['bname']?></description>
		<language>ko</language>
		<pubDate><?=$setup['pubDate']?></pubDate>
		<generator>xEspresso</generator>
		<image>
		<title><?=$site['name']?></title>
		<url><?=$site['url']?><?=$site['logo']?></url>
		<link><?=$site['url']?>/board/lst/<?=$bid?></link>
		<width>200</width>

		<height>50</height>
		<description><?=$site['name']?></description>
		</image>
<?php foreach($items as $item):
		list($date,$time) = explode(' ',$item['Board']['created']);
		list($year,$month,$day) = explode("-",$date);
		list($hour,$minute,$second) = explode(":",$time);
		$item['Board']['pubDate'] = date("D, d M Y H:i:s +9000",mktime($hour,$minute,$second,$month,$day,$year));
?>
		<item>
			<title><![CDATA[<?=$item['Board']['subject']?>]]></title>
			<link><?=$site['url']?>/board/view/<?=$item['Board']['bid']?>/<?=$item['Board']['no']?></link>
			<description><![CDATA[
			<?=$item['Board']['content']?>
			]]></description>

			<?php foreach($item['BoardCategory'] as $category):
				 if( empty($category['name']) ) continue;
			?>
			<category><?=$category['name']?></category>
			<?php endforeach;?>


			<author><?=$item['Board']['name']?></author>
			<guid><?=$site['url']?>/board/view/<?=$item['Board']['bid']?>/<?=$item['Board']['no']?></guid>
			<comments></comments>

			<pubDate><?=$item['Board']['pubDate']?></pubDate>
		</item>
	<?php endforeach?>
	</channel>
</rss>

