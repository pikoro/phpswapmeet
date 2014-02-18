<?

include_once('classes/search.php');
if($_POST[keyword]){
	$keyword = $_POST[keyword];
	$search = new search();
	$results = $search->do_search($keyword);
	if(!empty($results)){
	    echo '<h2>Search Results > '.$keyword.'</h2>';
	    //$listings->pager($results);
	    foreach($results as $result){
	    		$listings->show_item_listing($result[id]);
			/*echo '<div class="sidebarlt" style="height:60px; text-align:left; width:auto;">';
			echo '<div style="float:left"><a href="?p=detail&item='.$result[id].'"><img class="list_image" src="/'.$result[image].'" alt="'.$result[name].'" width="50" height="50"/></a></div>';
			echo '<div style="margin-left:70px; width: auto;"><b>'.$result[name].'</b></div>';
			echo '<div style="margin-left:70px; width: auto;">'.$result[description].'</div>';
			echo '<div style="margin-left:70px; width: auto;">Posted:'.$result[list_date].'</div>';
			echo '</div>'; 
			//print_r($item); */
		} 
	} else {
	   echo '<h3>Your search for '.$keyword.' returned 0 results</h3>';
        echo '<h3>Enter some Keywords in the box below to search again:</h3>
    <form id="search" name="search" method="post" action="?p=search&pageID=1">
    	   <input type="text" width="350" name="keyword" />&nbsp;<input type="submit" value="Search" />
    </form>';
        echo '<h2>Notify Me! (beta)</h2>';
        echo '<h4>Input your email address below to be notified when an item matching your search term is added to '.$config[site][name].'</h4>';
        echo '<h4>You do not need an account on '.$config[site][name].' to receive email notifications</h4>';
        echo '<form id="notify" name="notify" method="post" action="?p=search&pageID=1">
            <input type="hidden" name="search_term" value="'.$_POST[keyword].'">
            <input type="text" width="350" name="email" />&nbsp;<input type="submit" value="Notify" />
            </form>';
	}
} elseif($_POST[email]) {
    $search = new search();
    $search->add_notification($_POST[email],$_POST[search_term]);
    echo '<h1>Notification Added!</h1>';
} else {
	echo '<h3>Enter some Keywords in the box below to search:</h3>
    <form id="search" name="search" method="post" action="?p=search&pageID=1">
    	   <input type="text" width="350" name="keyword" />&nbsp;<input type="submit" value="Search" />
    </form>';
}

?>