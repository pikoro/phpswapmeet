<?php
require('../includes/config.php');
$hostname_conn = $config[database][server];
$database_conn = $config[database][db];
$username_conn = $config[database][dbuser];
$password_conn = $config[database][dbpass];
$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR);
?>
<?php
// Query the database and get all the records from the Images table
mysql_select_db($database_conn, $conn);
if($_GET[type]=='parent'){
	$query_rsAll = 'select * from '.$config[database][prefix].'categories where status=1 and parent=0 order by id';
}
if($_GET[type]=='child'){
	$query_rsAll = 'select * from '.$config[database][prefix].'categories where status=1 and parent='.mysql_real_escape_string($_GET[parent]).' order by parent, id';
}
if($_GET[type]=='suggest'){
	$query_rsAll = 'select name from '.$config[database][prefix].'items';
}
$rsAll = mysql_query($query_rsAll) or die(mysql_error());
$row_rsAll = mysql_fetch_assoc($rsAll);
$totalRows_rsAll = mysql_num_rows($rsAll);

// Send the headers
header('Content-type: text/xml');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');
?><?php echo('<?xml version="1.0" encoding="utf-8"?>'); ?>
<root>
  <?php if ($totalRows_rsAll > 0) { // Show if recordset not empty ?>
  <?php do { ?>
	<row>
		<?php foreach ($row_rsAll as $column=>$value) { ?>
		<<?php echo $column; ?>><![CDATA[<?php echo $row_rsAll[$column]; ?>]]></<?php echo $column; ?>>
		<?php } ?>
	</row>
    <?php } while ($row_rsAll = mysql_fetch_assoc($rsAll)); ?>
	<?php } // Show if recordset not empty ?>
</root>
<?php
mysql_free_result($rsAll);
?>

