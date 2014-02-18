<?
// Not sure where I got this, but I definately didn't write it.  Just fixed it though, it was horribly coded - Aaron

require('../includes/config.php');
$hostname_conn = $config[database][server];
$database_conn = $config[database][db];
$username_conn = $config[database][dbuser];
$password_conn = $config[database][dbpass];
$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(), E_USER_ERROR);

// Query the database and get all the records from the Images table
mysql_select_db($database_conn, $conn);
if ($_GET[type] == 'parent') {
    $query_rsAll = 'select * from ' . $config[database][prefix] . 'categories where status=1 and parent=0 order by id';
}
if ($_GET[type] == 'child') {
    $query_rsAll = 'select * from ' . $config[database][prefix] . 'categories where status=1 and parent=' . mysql_real_escape_string($_GET[parent]) . ' order by parent, id';
}
if ($_GET[type] == 'suggest') {
    $query_rsAll = 'select name from ' . $config[database][prefix] . 'items';
}
$rsAll = mysql_query($query_rsAll) or die(mysql_error());
$row_rsAll = mysql_fetch_assoc($rsAll);
$totalRows_rsAll = mysql_num_rows($rsAll);

// Send the headers
header('Content-type: text/xml');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');
echo('<?xml version="1.0" encoding="utf-8"?>'
 . '<root>');
if ($totalRows_rsAll > 0) { // Show if recordset not empty 
    echo '<row>';
    foreach ($row_rsAll as $column => $value) {
        echo '<' . $column . '><"[CDATA[' . $row_rsAll[$column] . ']]></' . $column . '>';
    }
    echo '</row>';
} while ($row_rsAll = mysql_fetch_assoc($rsAll));

echo '</root>';

mysql_free_result($rsAll);
