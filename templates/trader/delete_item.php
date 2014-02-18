<?

$items = new items();
if ($_GET[id]) {
    $owner_id = $items->check_owner(filter_input(INPUT_GET, 'id'));
    if ($owner_id == $_SESSION[id]) {
        if (!filter_input(INPUT_GET, 'action') == 'delete') {
            echo '<h3>Are you sure you want to delete this item?</h3>';
            echo '<a href="?p=delete_item&id=' . filter_input(INPUT_GET, 'id') . '&action=delete">Yes</a> <a href="?p=desktop">Cancel</a><br>';
        } else {
            $items->delete(filter_input(INPUT_GET, 'id'));
            echo '<h3>Item Deleted</h3>';
            echo '<h3>Return to your <a href="?p=desktop">desktop</a> or wait 3 seconds</h3>';
            echo '<meta http-equiv="refresh" content="3;url=' . $config[site][url] . '/?p=desktop" />';
        }
    } else {
        echo '<h3>You cannot delete this item since it is not yours</h3>';
    }
}
?>