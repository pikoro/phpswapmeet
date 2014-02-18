<?

require('includes/config.php');
include('classes/database.php');

$db = new database();

$sql = 'select id, image from fs_items';
$res = $db->get_res($sql);
while($row=mysql_fetch_object($res)){
	$item_id = $row->id;
	$image = $row->image;
	$tmpimage = explode('/',$image);
	$imagename = $tmpimage[1];
	$tmpext = explode('.',$imagename);
	$front=$tmpext[0];
	$back=$tmpext[1];

	if($back != 'jpg' || $back != 'JPG'){
        `convert images/$imagename images/$front.jpg`; // convert into jpeg
        //unlink('images/'.$imagename);
        $imagename= $front.'.jpg';
	}
	$new_img = 'new-'.$imagename;
	$op_img = '2-'.$new_img;
    `convert images/$imagename -quality 50 -resize 600x600 images/$new_img`; // resize image
	//`jpegtran -copy none images/$new_img > images/$op_img`;
	`convert -quality 40 -resize 65x65 images/$new_img images/thumb/$imagename`; // resize thumbnail
	unlink('images/'.$imagename); // remove original file
	@copy('images/'.$new_img,'images/'.$imagename); // copy new file to original name
	unlink('images/'.$new_img); // remove new file
	//copy('images/'.$new_img,'images/thumb/' .$new_img); // copy to thumb dir
	//db it
	$sql2='insert into fs_images (item_id, imagename) values ("'.$item_id. '","'.$imagename.'")';
	echo $sql2 . "\r\n";
	mysql_query($sql2);
}

?>