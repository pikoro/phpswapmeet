<?
if($_GET[cat]=="free"){
    $item_list = $items->get_free_items();
    echo '<h2>Free Stuff</h2>';
      $listings->pager($item_list);
      echo '
            <script type="text/javascript">
                            revealDiv('.$_GET[pageID].');
                      </script>';

} elseif($_GET[cat]){
	if(!$_GET[sub]){
		$category = $_GET[cat];
		echo '<table id="categories">';
		$categories = $listings->get_child_categories($category);
	    $i = 0;
	    for($i=0;$i<count($categories);$i++){
    		   if($k>2) $k=0;
    		   switch($k){
    	   		  case 0:
    	   	  		 echo '<tr><td><li><a href="?p=browse&cat='.$category.'&sub='.$categories[$i][id].'&pageID=1">'.$categories[$i][category].' ('.$listings->count_items($categories[$i][id]).')</a></li></td>';
    	   	  		 break;
    	   		  case 1:
    	   	  		 echo '<td><li><a href="?p=browse&cat='.$category.'&sub='.$categories[$i][id].'&pageID=1">'.$categories[$i][category].' ('.$listings->count_items($categories[$i][id]).')</a></li></td>';
    	   	  		 break;
    	   		  case 2:
    	   	  		 echo '<td><li><a href="?p=browse&cat='.$category.'&sub='.$categories[$i][id].'&pageID=1">'.$categories[$i][category].' ('.$listings->count_items($categories[$i][id]).')</a></li></td></tr>';
    	   	  		 break;
		   }
		   $k++;
	    } // End Listing Child Categories
	    echo '</table>';
	    echo '<h2>&nbsp;</h2>';
	    $category = $_GET[cat];
	    $item_list = $listings->get_child_items($category);
	    //print_r($item_list);
			echo '<h2>'.$listings->get_category_name($category).'</h2>';
			for($j=0;$j<count($item_list);$j++){
				//echo count($item_list[$j]);
				if(count($item_list[$j]>0)){
					//print_r($item_list[$j]);
					for($c=0;$c<count($item_list[$j]);$c++){
						$sub_listings[] = $item_list[$j][$c];
					}
				}
			}
			//print_r($sub_listings);
			$listings->pager($sub_listings);

	        echo '
            <script type="text/javascript">
							revealDiv('.$_GET[pageID].');
				      </script>';
			/*foreach($item_list as $item){
				$i=0;
				while($i<count($item)){
				    $listings->show_item_listing($item[$i][id]);
					$i++;
					//print_r($item);
				}
			} */
	} else {  // We're on sub category listing.

		$category = $_GET[cat];
		$subcat = $_GET[sub];
		$items = $listings->get_items($subcat);

        echo '<h2><a href="?p=browse&cat='.$category.'&pageID=1">'.$listings->get_category_name($category).'</a> &gt; '.$listings->get_category_name($subcat).'</h2>';

		if(empty($items)){
			echo '<h3>We\'re sorry, there are no items listed for this Category</h3>';
		} else {
			$listings->pager($items);
			echo '
            <script type="text/javascript">
						revealDiv('.$_GET[pageID].');
			      </script>';

		}
	}
} else { // Must want to see everything
	$everything = $listings->get_all();
    echo '<h2>Everything</h2>';
		$listings->pager($everything);
        echo '
        <script type="text/javascript">
						revealDiv('.$_GET[pageID].');
			      </script>';
}

?>

