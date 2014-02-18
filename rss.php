<?
	require('includes/config.php');
	require('classes/database.php');
	require('classes/listings.php');
	require('classes/items.php');
	require('classes/log.php');

	$db = new database();
	$listings = new listings();
	$items = new items();
	if($_GET[cat]){
	    $children = $listings->get_child_category_nums($_GET[cat]);
	    if(count($children)<1){
	    	  $sql = 'select * from '.$config[database][prefix].'items where category = '.mysql_real_escape_string($_GET[cat]).' order by id DESC limit 0,10';
	    } else {
	    	  // print_r($children);
	    	  $comma_seperated = implode(",",$children);
	    	  $sql = 'select * from '.$config[database][prefix].'items where category in ('.$comma_seperated.') order by id DESC limit 0,10';
	    }
	} else {
		$sql = 'select * from '.$config[database][prefix].'items order by id DESC limit 0,10';
	}
	//echo $sql;
	$res = mysql_query($sql);
	header("Content-Type: application/xml; charset=UTF-8");
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
	/* echo '<?xml-stylesheet type="text/css" href="/xml.css" ?>';
	 echo '<?xml-stylesheet type="text/xsl" href="/stylesheet.xsl" ?>'; */
	echo '<rss version="2.0">';
	echo '<channel>';
	echo '<title>'.$config[site][name];
	if($_GET[cat]){
        $cat_name = htmlspecialchars($listings->get_category_name($_GET[cat]));
		echo ' - '.$cat_name;
	}
	echo '</title>';
	echo '<link>'.$config[site][url].'</link>';
	echo '<language>'.$config[site][lang].'</language>';
	echo '<webMaster>'.$config[site][contact].'</webMaster>';
	echo '<copyright>&amp;copy;'.date("Y").' '.$config[site][url].'</copyright>';
	echo '<description>'.$config[site][tagline].'</description>';
	echo '<image>';
	echo '	<title>'.$config[site][short_name].'</title>';
	echo '	<url>'.$config[site][url].'/templates'.$config[site][logo].'</url>';
	echo '	<link>'.$config[site][url].'</link>';
	echo '	<width></width>';
	echo '	<height></height>';
	echo '</image>';
	while($row = mysql_fetch_object($res)){
		echo '<item>';
		echo '	<title>'.$row->name.'</title>';
		echo '	<link>'.$config[site][url].'/?p=detail&amp;item='.$row->id.'</link>';
		echo '	<pubDate>'.$row->list_date.'</pubDate>';
        if($cat_name){echo '  <category><![CDATA['.$cat_name.']]></category>';}
		echo '	<description>'.$row->description.'</description>';
        echo '  <content><![CDATA['.$row->notes.']]></content>';
		echo '</item>';
	}
	echo '<description>'.$config[site][tagline].'</description>';
	echo '</channel>';
	echo '</rss>';



?>