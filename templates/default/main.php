

    <h1><strong><?= $config[site][name] ?></strong> - A free online Swap Meet for Okinawa!</h1>
    <p>It's fast and easy to get started.  Simply sign up for a new account (valid email address required), confirm your account, and start making your lists.  Upload images and descriptions of your stuff and start searching for things you want.  It's that easy!</p>
    <h2>Search</h2>
    <p>Enter some Keywords in the box below to search for items people would like to swap:</p>
    <form id="search" name="search" method="post" action="?p=search">
    	   <input type="text" width="350" name="keyword" />&nbsp;<input type="submit" value="Search" />
    </form>
    <p>&nbsp;</p>
    <h2>Browse</h2>
    <p>
    <h3>Select a category below to browse the items in that category or view them <a href="?p=browse&pageID=1">All</a></h3>
    <table id="categories">
    <?
    include_once('classes/listings.php');
    $listings = new listings();
    $i = 0;
    $categories = $listings->get_categories();
    for($i=0;$i<count($categories);$i++){
    	   if($k>2) $k=0;
    	   switch($k){
    	   	  case 0:
    	   	  	 echo '<tr><td><li><a href="?p=browse&cat='.$categories[$i][id].'&pageID=1">'.$categories[$i][category].' ('.$listings->count_children_items($categories[$i][id]).')</a></li></td>';
    	   	  	 break;
    	   	  case 1:
    	   	  	 echo '<td><li><a href="?p=browse&cat='.$categories[$i][id].'&pageID=1">'.$categories[$i][category].' ('.$listings->count_children_items($categories[$i][id]).')</a></li></td>';
    	   	  	 break;
    	   	  case 2:
    	   	  	 echo '<td><li><a href="?p=browse&cat='.$categories[$i][id].'&pageID=1">'.$categories[$i][category].' ('.$listings->count_children_items($categories[$i][id]).')</a></li></td></tr>';
    	   	  	 break;
	   }
	   $k++;
    }
    ?>
    </table>
    </p>
    <h2>Recently Added</h2>
    <div>
<?

    	   $featured = $listings->get_featured();
     for($i=0;$i<count($featured);$i++){
         $listings->show_item_listing($featured[$i][id]);

		//print_r($my_items[$i]);
	}
?>
    </div>

    </div>
    <br class="clearFloat" />
