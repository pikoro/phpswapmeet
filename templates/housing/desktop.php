<?php
    if(!$_SESSION[username]){
        header('Location: '.$config[site][url].'/');
    } else {
        echo '<br><h3> '.ucwords($_SESSION[username]).'\'s Desktop</h3>';
    }
    //print_r($_SESSION);
?>
<h2><a href="?p=edit_profile">Edit Profile</a></h2>
<h2><a href="?p=logout">Logout</a></h2>
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

<h2>Your Public Listings</h2>
 <p>You can use the following link to send other people directly to your listings.</p>
<h4><a href="http://<?= $_SESSION[username] ?>.<?=$config[site][domain]?>">http://<?= $_SESSION[username] ?>.<?=$config[site][domain]?></a></h4><br>
<!--
<? if($_SESSION[access] >= 20){
?>
<h3>Additionaly, you can upload a logo to appear on your store's front page: (660x100)</h3>
<form id="logo_upload" name="logo_upload" id="logo_upload" method="post" action="?p=store&f=logo_upload">
<input type="file" name="logo" id="logo">
</form>
<br>
<?}?> -->

<h2>My Listings</h2><div style="text-align:right;font-size:small; float:right; margin-right:10px;"><? 
	if($_SESSION[active]==1){
		echo '<a id="btnright" href="?p=add_item">Add Listing</a>';
	}?>
	</div>
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