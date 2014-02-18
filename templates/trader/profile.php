<?

$listings = new listings();
$items = new items();
$users = new user();

if(!$_GET[id]){
    echo '<h3>We\'re sorry, you have not selected a valid user</h3>';
} else {
    echo '<h2>'.ucwords($users->get_username($_GET[id])).'\'s Items</h2>';
    $item_list = $items->get_users_items($_GET[id]);
    //print_r($item_list);
    $listings->pager($item_list);
    echo '<script type="text/javascript">
                    revealDiv('.$_GET[pageID].');
              </script>';
}

?>