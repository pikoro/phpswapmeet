<div id="homewelcome">
	<h1>Okinawa's Houses at your Fingertips</h1>
	<p>We currently offer listings supplied by Off-Base Military Housing Federation Members:
		<ul>
			<li><a href="http://www.american-family-housing.com">American Family Housing</a></li>
			<li><a href="http://www.central-housing.jp">Central Housing</a></li>
			<li><a href="http://www.dynastyhousing.jp">Dynasty Housing</a></li>
			<li>Nissin Housing</li>
			<li><a href="http://www.robinsonhousing.com">Robinson Housing</a></li>
			<li><a href="http://www.seasidehousing.jp">Seaside Housing</a></li>
			<li><a href="http://www.sky-offbase.com">Sky Housing</a></li>
			<li><a href="http://www.sunnys-housing.com">Sunny's Housing</a></li>
			
			
			
			
		</ul>
	</p>
</div>
<div id="newlistings">
	<h2>New Listings</h2>
	<? 	
		$new_listings = $listings->get_new(4); 
		// print_r($new_listings);
		foreach($new_listings as $item){
			echo '<div class="listing">
					<a href="?p=detail&item='.$item[id].'"><img height="74" width="114" src="'.$config[site][url].'/images/thumb/'.$items->get_main_picture($item[id]).'" /></a>
					<h3 class="maroon"><a href="?p=detail&item='.$item[id].'">'.$item[name].'</a></h3>
					<p class="location">Near '.$listings->get_base_name($item[base]).'</p>
					<p class="price">&yen;'.number_format($item[price]).'<span>/monthly</span></p>
					<p class="bedbathsqft">'.$item[bed].' Bed, '.$item[bath].' Bath, '.$item[squarefeet].' Sq Ft</p>
			</div>';
		}
		
	?>
	
</div>
<div id="featuredlisting">
	<h2>Featured Listing</h2>
	<?
		$featured = $listings->get_featured();
		echo '
		<div id="featuredwrap">
		<a href="?p=detail&item='.$featured[id].'"><img height="159" width="328" src="'.$config[site][url].'/images/'.$items->get_main_picture($featured[id]).'" /></a>
		<div class="address">
			<h3><a href="?p=detail&item='.$featured[id].'">'.$featured[name].'</a></h3>
			<p class="location">Near '.$listings->get_base_name($featured[base]).'</p>
		</div>
		<p class="price">&yen;'.number_format($featured[price]).'<span>/monthly</span></p>
		<p class="bedbathsqft">'.$featured[bed].' Bed, '.$featured[bath].' Bath, '.$featured[squarefeet].' Sq Ft</p>
		<p class="propertytype">Property Type: '.$listings->get_category_name($featured[category]).'</p>
	</div> 
	';
	?>
	
</div>