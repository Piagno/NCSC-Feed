<?php
require 'feed.php';
header("Cache-Control: no-cache");
$url = 'https://www.ncsc.admin.ch/';
$feed = new feed($url,'NCSC');
$feed->author = 'NCSC';
$rawData = file_get_contents('https://www.ncsc.admin.ch/ncsc/de/home/aktuell/im-fokus/_jcr_content/par/columncontrols/items/0/column/teaserlist_512694191.content.paging-1.html');
$filteredData = (explode('<nav>',(explode('</nav>',$rawData,)[1]))[0]);
$list = explode('<div class="row">',$filteredData);
$skipfirst = true;
foreach($list as $item){
	if($skipfirst == false){
		$link = ('https://www.ncsc.admin.ch'.(explode('"',explode('href="',$item)[1])[0]));
		$title = (explode('"',(explode('title="',$item)[1]))[0]);
		$text = (explode('</div>',(explode('<div>',explode('<div class="wrapper">',$item)[1])[1]))[0]);
		$rssItem = $feed->newItem($link,$title);
		$rssItem->content = $text;
		$rssItem->contentType = 'html';
		$rssItem->link = $link;
	}
	$skipfirst = false;
}
$feed->printFeed();