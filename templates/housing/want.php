<?


if($_GET[q]){
	switch($_GET[q]){
		case 'add':
			$item = $_GET[item];
			$owner = $items->check_owner($item);

			if($owner == $_SESSION[id]){
				echo '<h3>Cannot add an item that you own to your Wanted list.  You alread have it!</h3>';
                echo '<h3>Return to your <a href="?p=desktop">desktop</a> or wait 3 seconds</h3>';
				echo '<meta http-equiv="refresh" content="3;url='.$config[site][url].'/?p=desktop" />';
			} else {
				$items->add_want($item);
				echo '<h3>Item added to want list</h3>';
				echo '<h3>Return to your <a href="?p=desktop">desktop</a> or wait 3 seconds</h3>';
				echo '<meta http-equiv="refresh" content="3;url='.$config[site][url].'/?p=desktop" />';
			}
			break;
		case 'remove':
			$items->remove_want($_GET[id]);
			echo '<h3>Item removed from want list</h3>';
			echo '<h3>Return to your <a href="?p=desktop">desktop</a> or wait 3 seconds</h3>';
			echo '<meta http-equiv="refresh" content="3;url='.$config[site][url].'/?p=desktop" />';
			break;

	}
} else {

}


?>