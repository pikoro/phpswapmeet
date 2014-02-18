<?

include_once('classes/search.php');
echo '<div id="listingwrap">';
if($_POST['action']=='search'){
	$keyword = $_POST[keyword];
	$search = new search();
	$results = $search->do_search($_POST['type'],$_POST['min_price'],$_POST['max_price'],$_POST['base'],$_POST['bed'],$_POST['bath']);
	if(!empty($results)){
		echo '<div id="sidebar">
        <h1>Search Results</h1>
    </div>';
	    //echo '<h2>Search Results</h2>';
	    //$listings->pager($results);
	    foreach($results as $result){
	    	    //print_r($result);
	    	    echo '<div class="searchresult">
	    	    	<a href="?p=detail&item='.$result[id].'"/><img class="left" width="281" height="195" src="'.$config[site][url].'/images/'.$items->get_main_picture($result[id]).'" /></a>
	    	    	<div class="listinginfo">
	    	    		<div class="address">
	    	    			<h3><a href="?p=detail&item='.$result[id].'">'.$result[name].'</a></h3>
	    	    			<p class="location">Near '.$listings->get_base_name($result[base]).'</p>
	    	    		</div>
	    	    		<p class="price">&yen;'.number_format($result[price]).'
	    	    		<p class="bedbathsqft">'.$result[bed].' Bed, '.$result[bath].', '.$result[squarefeet].' Sq Ft</p>
	    	    		<p class="propertytype">Property Type: '.$listings->get_category_name($result[category]).'</p>
	    	    	</div>
	    	    </div>
	    	    	';
	    		/*$listings->show_item_listing($result[id]);
			echo '<div class="sidebarlt" style="height:60px; text-align:left; width:auto;">';
			echo '<div style="float:left"><a href="?p=detail&item='.$result[id].'"><img class="list_image" src="/'.$result[image].'" alt="'.$result[name].'" width="50" height="50"/></a></div>';
			echo '<div style="margin-left:70px; width: auto;"><b>'.$result[name].'</b></div>';
			echo '<div style="margin-left:70px; width: auto;">'.$result[description].'</div>';
			echo '<div style="margin-left:70px; width: auto;">Posted:'.$result[list_date].'</div>';
			echo '</div>'; 
			//print_r($item); */
		} 
	} else {
	   echo '<h2>Your search returned 0 results</h2>';
        echo '<h1>Start your search</h1>
          	<form method="post" name="search" action="?p=search">
                <input type="hidden" name="action" value="search" />
                <table border="0"  cellspacing="0" class="search">
                	<tr><th>Type: </th><td><select name="type">
                						<option value="0" selected="selected">Any</option>
                						<option value="1" >Single Home</option>
                						<option value="2" >Apartment</option>
                						<option value="3" >Duplex</option>
                						</select></td></tr>
                     <tr><th>Price Range: </th><td>
                     <select name="min_price">
                     	<option value="0" selected="selected">Any</option>
                     	<option value="0">0</option>
                     	<option value="140000">140,000</option>
                     	<option value="150000">150,000</option>
                     	<option value="155000">155,000</option>
                     	<option value="160000">160,000</option>
                     	<option value="165000">165,000</option>
                     	<option value="180000">180,000</option>
                     	<option value="190000">190,000</option>
                     	<option value="200000">200,000</option>
                     	<option value="210000">210,000</option>
                     	<option value="225000">225,000</option>
                     	<option value="235000">235,000</option>
                     	<option value="240000">240,000</option>
                     	<option value="250000">250,000</option>
                     	<option value="280000">280,000</option>
                     	<option value="300000">300,000</option>
                     	<option value="320000">320,000</option>
                     </select>~<select name="max_price">
                     	<option value="0" selected="selected">Any</option>
                     	<option value="0">0</option>
                     	<option value="140000">140,000</option>
                     	<option value="150000">150,000</option>
                     	<option value="155000">155,000</option>
                     	<option value="160000">160,000</option>
                     	<option value="165000">165,000</option>
                     	<option value="180000">180,000</option>
                     	<option value="190000">190,000</option>
                     	<option value="200000">200,000</option>
                     	<option value="210000">210,000</option>
                     	<option value="225000">225,000</option>
                     	<option value="235000">235,000</option>
                     	<option value="240000">240,000</option>
                     	<option value="250000">250,000</option>
                     	<option value="280000">280,000</option>
                     	<option value="300000">300,000</option>
                     	<option value="320000">320,000+</option>
                     	</select></td></tr>
                     <tr><th>Nearest Base: </th><td><select name="base"><option value="0" selected="selected">Any</option><option value="1" >Kinser</option><option value="2" >Futenma</option><option value="3" >Foster</option><option value="4" >Lester</option><option value="5" >Kadena</option><option value="6" >Torii Station</option><option value="7" >McTureous</option><option value="8" >Courtney</option><option value="9" >Schwab</option><option value="10" >Hansen</option></select></td></tr>
                     <tr><th>Bedrooms: </th><td><select id="bed" name="bed">
     	<option value="0" selected="selected">Any</option>
    		<option value="1">1</option>
    		<option value="2">2</option>
    		<option value="3">3</option>
    		<option value="4">4</option>
    		<option value="5">5</option>
    		<option value="6">6+</option>
    	</select></td>
                     </tr>
                     <tr>
                              <th>Bathrooms: </th>
                              <td><select id="bath" name="bath">
          <option value="0">Any</option>
    		<option value="1">1</option>
    		<option value="1.5">1.5</option>
    		<option value="2">2</option>
    		<option value="2.5">2.5</option>
    		<option value="3">3</option>
    		<option value="3.5">3.5</option>
    		<option value="4">4+</option>
    	</select></td>
               	</tr>
                	<tr>
                    		<th><input type="submit" value="Search" /></th>
                            <th style="text-align:left;">&nbsp;</th>
                    </tr>
            	</table>
                </form>';
	}
} elseif($_POST[email]) {
    $search = new search();
    $search->add_notification($_POST[email],$_POST[search_term]);
    echo '<h1>Notification Added!</h1>';
} else {
	echo '<!-- Search Box -->
			<h1>Start your search</h1>
          	<form method="post" name="search" action="?p=search">
                <input type="hidden" name="action" value="search" />
                <table border="0"  cellspacing="0" class="search">
                	<tr><th>Type: </th><td><select name="type">
                						<option value="0" selected="selected">Any</option>
                						<option value="1" >Single Home</option>
                						<option value="2" >Apartment</option>
                						<option value="3" >Duplex</option>
                						</select></td></tr>
                     <tr><th>Price Range: </th><td>
                     <select name="min_price">
                     	<option value="0" selected="selected">Any</option>
                     	<option value="0">0</option>
                     	<option value="140000">140,000</option>
                     	<option value="150000">150,000</option>
                     	<option value="155000">155,000</option>
                     	<option value="160000">160,000</option>
                     	<option value="165000">165,000</option>
                     	<option value="180000">180,000</option>
                     	<option value="190000">190,000</option>
                     	<option value="200000">200,000</option>
                     	<option value="210000">210,000</option>
                     	<option value="225000">225,000</option>
                     	<option value="235000">235,000</option>
                     	<option value="240000">240,000</option>
                     	<option value="250000">250,000</option>
                     	<option value="280000">280,000</option>
                     	<option value="300000">300,000</option>
                     	<option value="320000">320,000</option>
                     </select>~<select name="max_price">
                     	<option value="0" selected="selected">Any</option>
                     	<option value="0">0</option>
                     	<option value="140000">140,000</option>
                     	<option value="150000">150,000</option>
                     	<option value="155000">155,000</option>
                     	<option value="160000">160,000</option>
                     	<option value="165000">165,000</option>
                     	<option value="180000">180,000</option>
                     	<option value="190000">190,000</option>
                     	<option value="200000">200,000</option>
                     	<option value="210000">210,000</option>
                     	<option value="225000">225,000</option>
                     	<option value="235000">235,000</option>
                     	<option value="240000">240,000</option>
                     	<option value="250000">250,000</option>
                     	<option value="280000">280,000</option>
                     	<option value="300000">300,000</option>
                     	<option value="320000">320,000+</option>
                     	</select></td></tr>
                     <tr><th>Nearest Base: </th><td><select name="base"><option value="0" selected="selected">Any</option><option value="1" >Kinser</option><option value="2" >Futenma</option><option value="3" >Foster</option><option value="4" >Lester</option><option value="5" >Kadena</option><option value="6" >Torii Station</option><option value="7" >McTureous</option><option value="8" >Courtney</option><option value="9" >Schwab</option><option value="10" >Hansen</option></select></td></tr>
                     <tr><th>Bedrooms: </th><td><select id="bed" name="bed">
     	<option value="0" selected="selected">Any</option>
    		<option value="1">1</option>
    		<option value="2">2</option>
    		<option value="3">3</option>
    		<option value="4">4</option>
    		<option value="5">5</option>
    		<option value="6">6+</option>
    	</select></td>
                     </tr>
                     <tr>
                              <th>Bathrooms: </th>
                              <td><select id="bath" name="bath">
          <option value="0">Any</option>
    		<option value="1">1</option>
    		<option value="1.5">1.5</option>
    		<option value="2">2</option>
    		<option value="2.5">2.5</option>
    		<option value="3">3</option>
    		<option value="3.5">3.5</option>
    		<option value="4">4+</option>
    	</select></td>
               	</tr>
                	<tr>
                    		<th><input type="submit" value="Search" /></th>
                            <th style="text-align:left;">&nbsp;</th>
                    </tr>
            	</table>
                </form>';
}
echo '</div>';
?>