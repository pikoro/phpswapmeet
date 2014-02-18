<?

$listings = new listings();
$items = new items();
$users = new user();
echo '<h2>Trading Tables</h2>';
	$userlist = $users->get_userlist();
	echo '<ul>';
	foreach($userlist as $user){
		$user[num_items] = $items->count_users_items($user[id]);
		if($user[num_items] > 0){
			echo '<li><a href="?p=store&name='.$user[username].'">'.ucwords($user[username]).' ('.$user[num_items].' items)</a></li>';
		}
		
	}
	echo '</ul>';
    echo '<script type="text/javascript">
                    revealDiv(';
                    if(!$_GET[pageID]){
					echo '1';
                    }else{
					echo $_GET[pageID];
                    }
                    echo ');	
              </script>';


?>