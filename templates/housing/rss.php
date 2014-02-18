<?
	require('includes/config.php');
	$sql = 'select * from '.$config[database][prefix].'items limit 0,10';
	$res = mysql_query($sql);
	header("Content-Type: application/xml; charset=UTF-8");
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
	echo '<rss version="2.0">';
	echo '<channel>';
	echo '<title>'.$config[site][name].'</title>';
	echo '<link>'.$config[site][url].'</link>';
	echo '<description>'.$config[site][tagline].'</description>';
	echo '<image>';
	echo '	<title>'.$config[site][shortname].'</title>';
	echo '	<url>'.$config[site][logo].'</url>';
	echo '	<link>'.$config[site][logo].'</link>';
	echo '	<width></width>';
	echo '	<height></height>';
	echo '</image>';
	while($row = mysql_fetch_object($res)){
		echo '<item>';
		echo '<title>'.$row->name.'</title>';
		echo '<link>'.$config[site][url].'/?p=detail&item='.$row->id.'</link>';
		echo '<description>'.$row->description.'</description>';
		echo '</item>';
	}
	echo '</channel>';
	echo '</rss>';
	echo '</xml>';



?>