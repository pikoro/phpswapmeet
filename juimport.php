<?php

// URL location of your feed

$feedUrls[]=array(241,'http://www.japanupdate.com/rss/auto.xml');
$feedUrls[]=array(336,'http://www.japanupdate.com/rss/land.xml');
$feedUrls[]=array(287,'http://www.japanupdate.com/rss/appl.xml');
$feedUrls[]=array(56,'http://www.japanupdate.com/rss/arts.xml');
$feedUrls[]=array(355,'http://www.japanupdate.com/rss/boat.xml');
$feedUrls[]=array(266,'http://www.japanupdate.com/rss/body.xml');
$feedUrls[]=array(82,'http://www.japanupdate.com/rss/book.xml');
$feedUrls[]=array(103,'http://www.japanupdate.com/rss/came.xml');
$feedUrls[]=array(141,'http://www.japanupdate.com/rss/clot.xml');
$feedUrls[]=array(196,'http://www.japanupdate.com/rss/coll.xml');
$feedUrls[]=array(214,'http://www.japanupdate.com/rss/comp.xml');
$feedUrls[]=array(352,'http://www.japanupdate.com/rss/dive.xml');
$feedUrls[]=array(421,'http://www.japanupdate.com/rss/educ.xml');
$feedUrls[]=array(256,'http://www.japanupdate.com/rss/elec.xml');
$feedUrls[]=array(271,'http://www.japanupdate.com/rss/fitn.xml');
$feedUrls[]=array(431,'http://www.japanupdate.com/rss/free.xml');
$feedUrls[]=array(287,'http://www.japanupdate.com/rss/furn.xml');
$feedUrls[]=array(411,'http://www.japanupdate.com/rss/game.xml');
$feedUrls[]=array(287,'http://www.japanupdate.com/rss/home.xml');
$feedUrls[]=array(57,'http://www.japanupdate.com/rss/infa.xml');
$feedUrls[]=array(294,'http://www.japanupdate.com/rss/jewe.xml');
$feedUrls[]=array(431,'http://www.japanupdate.com/rss/mscs.xml');
$feedUrls[]=array(330,'http://www.japanupdate.com/rss/musi.xml');
$feedUrls[]=array(352,'http://www.japanupdate.com/rss/outd.xml');
$feedUrls[]=array(431,'http://www.japanupdate.com/rss/pets.xml');

require ('includes/rss_fetch.inc');
require ('classes/database.php');
$db=new database();
$db->query('delete from fs_items where description = "Please contact seller directly."');
/*foreach ($feedUrls as $feed) {
    $rss = fetch_rss($feed[1]);

    foreach ($rss->items as $item) {
        $rowCount = 0;
        $sql = 'select id from fs_items where `name` = "'.$item[title].'"';
        $res = $db->get_res($sql);
        $rowCount = mysql_num_rows($res);
            echo 'Number of Rows: '.$rowCount."\r\n";
        if($rowCount == 0) {
            echo 'count2: '.$rowCount."\r\n";
            $isDupe = 'FALSE';
            echo 'Adding Item: '.$item[title]."\r\n";
        }else {
            echo 'Item is a Dupe: '.$item[title]."\r\n";
            $isDupe = 'TRUE';
        }
        if($isDupe == 'FALSE') {
            $tmpdate    = strtotime($item[pubdate]);
            //echo $tmpdate . "\r\n";
            $custid     =1;
            $name       =$item[title];
            $category   =$feed[0];
            $description='Please contact seller directly.';
            $condition  ='used';
            $post_type  ='sale';
            $notes      =$item[description];
            $list_date  =date("Y-m-d H:i:s", $tmpdate);
            $status     =1;
            //echo $list_date . "\r\n";
            $db->query(
                    'insert into fs_items (`custid`,`name`,`category`,`description`,`condition`,`post_type`,`notes`,`list_date`,`status`) values
        ("' . $custid . '","' . $name . '","' . $category . '","' . $description . '","' . $condition . '","' . $post_type
                    . '","' . $notes . '","' . $list_date . '","' . $status . '")');
        }
    }
}

/*function isDupe($title) {
    $db=new database();
    $sql = 'select * from fs_items where `name` = "'.$title.'"';
    $res = mysql_query($sql);
    if(count(mysql_num_rows($res))>0) {
        return TRUE;
    }else {
        return FALSE;
    }
}*/
// 15: Cars, Trucks
// 241: Cars

?>
