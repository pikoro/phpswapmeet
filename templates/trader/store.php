<?

$listings = new listings();
$items = new items();
$users = new user();

if(!$_GET[name]){
    echo '<h3>We\'re sorry, you have not selected a valid user</h3>';
} else {
	$id = $users->get_user_id($_GET[name]);
    echo '<h2>'.ucwords($users->get_username($id)).'\'s Items</h2>';
    $item_list = $items->get_users_items($id);
    //print_r($item_list);
    $listings->pager($item_list);
    echo '<script type="text/javascript">
                    revealDiv(';
                    if(!$_GET[pageID]){
					echo '1';
                    }else{
					echo $_GET[pageID];
                    }
                    echo ');	
              </script>';
}

?>