<?php

// URL location of your feed

$feedUrls[]=array
    (
    241,
    'http://www.us-autosales.com/rss.php'
    );
require ('includes/rss_fetch.inc');
require ('classes/database.php');
$db=new database();

foreach ($feedUrls as $feed)
    {
    $rss = fetch_rss($feed[1]);

    foreach ($rss->items as $item){
        //$tmpdate    = strtotime($item[pubdate]);
        //echo $tmpdate . "\r\n";
        $tmpprice = explode(' ',$item[price]);
        $tmpprice2 = explode(',',$tmpprice[0]);
        $tmpprice3 = $tmpprice2[0].$tmpprice2[1];
        $tmpprice4 = explode('$',$tmpprice3);
        $tmpprice = implode('',$tmpprice4);
        $custid     =44;
        $name       =$item[title];
        $category   =$feed[0];
        $description='US AutoSales Store';
        $condition  ='used';
        $post_type  ='sale';
        $thumbnail  =$item[thumbnail];
        $value      =$tmpprice;
        $carid      =$item[carid];
        $notes      ='<p>'.$item[description].'<br>More pictures available at: <a href="'.$item[link].'">'.$item[link].'</a><br><h4>See more great cars at <a href="http://www.us-autosales.com">US AutoSales</a></h4></p>';
        $list_date  =date("Y-m-d H:i:s");
        $status     =1;
        //echo $list_date . "\r\n";
        $sql = 'insert into fs_items (`custid`,`name`,`category`,`description`,`condition`,`post_type`,`notes`,`list_date`,`status`,`value`) values ("'.$custid.'","'.$name.'","'.$category.'","'.$description.'","'.$condition.'","'.$post_type.'","'.mysql_real_escape_string($notes).'","'.$list_date.'","'.$status.'","'.$value.'")';
        //echo $sql.'<br>';
        mysql_query($sql) || die(mysql_error());
        $new_id = mysql_insert_id(); // This should contain the new id of the last record we just inserted
        $imagequery = 'insert into fs_images values (NULL,"'.$new_id.'","'.$thumbnail.'")';
        //echo $imagequery.'<br>';
        mysql_query($imagequery) || die(mysql_error());
        $command = 'wget -c http://www.us-autosales.com/uploads/'.$carid.'/'.$thumbnail.' -P ./images/';
        $command2= 'convert -quality 40 -resize 65x65 ./images/'.$thumbnail.' ./images/thumb/'.$thumbnail;
        $tmpcmd = `$command`; 
        $tmpcmd = `$command2`;
        //echo $command.'<br>';
        //echo $command2;
        }
    }

?>