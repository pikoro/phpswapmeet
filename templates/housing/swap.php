<?
if(!$_SESSION[id]){
	echo '<h1>You must be logged in to view this page</h1>';
} else {

	if($_GET[q]){
		switch($_GET[q]){
			case 'contact':
				contact($_GET[user],$_GET[item]);
				break;
			case 'send':
			$message = new messages();
			//print_r($_POST);
				$message->send($_SESSION[id],$_POST[to],$_POST[subject],$_POST[message]);
				echo '<h3>Your message has been sent to '.ucwords($users->get_username($_POST[to])).'</h3>';
				echo '<h4>Click <a href="?p=desktop">here</a> to return to your desktop</h4>';
				break;
		}
	}
}

function contact($userid,$item){
		$swap = new swap();
		$users = new user();
		$items = new items();
		// Code here for a form with dropdown pre-filled contact information about the item
		$to = $users->get_username($userid);
		$from = ucwords($_SESSION[username]);

	    echo '<h2>'.$message[subject].'</h2>';
	    echo '<form id="contact" name="contact" method="post" action="?p=swap&q=send">';
		echo 'From: '.$from.'<br>';
		echo 'To: '.$to.'<br>';
		echo 'Subject: Item #'.$item.' - '.$items->get_item_name($item).'<br>';
		echo 'Message: '.$swap->get_first_messages($item).'<br>';
		echo '<hr color="#99CC00">';
		echo '<input type="submit" name="submit" value="Send Message" />';
        echo '<input type="hidden" name="subject" value="Item #'.$item.' - '.$items->get_item_name($item).'" />';
        echo '<input type="hidden" name="to" value="'.$userid.'" />';

		//echo '<div class="sidebarlt"></div>';
		echo '</form>';

}
?>