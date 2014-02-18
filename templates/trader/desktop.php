<?php
    if(!$_SESSION[username]){
        header('Location: '.$config[site][url].'/');
    } else {
        echo '<h1> '.$_SESSION[username].'\'s Desktop</h1>';
    }
?>
<h2><a href="?p=edit_profile">Edit Profile</a></h2>
<h2>Messages</h2>
<div class="sidebarlt">
<?
    $messages = new messages();
    $listing = new listings();
    $inbox_id = $messages->get_inbox_id($_SESSION[id]);
    $sent_id  = $messages->get_sent_id($_SESSION[id]);
    $trash_id = $messages->get_trash_id($_SESSION[id]);
    $folders = $messages->get_folders($_SESSION[id]);
    //print_r($folders);
    //echo count($folders);

    if(count($folders)==0){
    	   echo '<h3>You have not yet <a href="?p=confirm">confirmed</a> your account</h3>';
    } else {
    	   echo '<ul>';
        foreach($folders as $folder){
    	       echo '<li><a href="?p=msgs&fid='.$folder[id].'">'.$folder[folder_name].'</a> (';
		       if($messages->count_unread_messages($folder[id])>0){
		   	    echo '<b>'.$messages->count_messages($folder[id]).'</b>)</li>';
		       } else {
    	       echo $messages->count_messages($folder[id]).')</li>';
		       }
        }
        echo '</ul>';
    }


?>
</div>
<h2>Your Store Link</h2>
<p>You can use the following link to send other people directly to your items, for example, in other classified ads.</p>
<h4><a href="http://<?= $_SESSION[username] ?>.okitrader.com">http://<?= $_SESSION[username] ?>.okitrader.com</a></h4><br>
<h2>Things I Want</h2>
<div class="sidebarlt" style="color:#000;">
<?

$wanted = $items->get_my_wanted($_SESSION[id]);
//print_r($wanted);
if(count($wanted)>0){
	for($i=0;$i<count($wanted);$i++){
		//echo $wanted[$i][id];

	    $listing->show_item_listing($wanted[$i][item_id]);
	    echo '<div style="margin-top:-2px;"><a href="?p=want&id='.$wanted[$i][id].'&q=remove">Remove from Want List</a></div>';
	}
} else {
	echo 'I have not added any items to my want list';
}



?></div>
<h2>Things I Have</h2><div style="text-align:right;font-size:small; float:right; margin-right:10px;"><? if($_SESSION[active]==1){echo '<a href="?p=add_item"><img src="templates/'.$config[site][template].'/images/add-item.png" width="100"/></a>';}?></div>
<div class="sidebarlt">

<?
	$my_items = $items->get_my_items();
	//print_r($my_items);
	echo 'I have '.count($my_items).' Items in My List';
	for($i=0;$i<count($my_items);$i++){
		$listing->show_item_listing($my_items[$i][id]);
		//print_r($my_items[$i]);
	}



?></div>