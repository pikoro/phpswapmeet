<div id="listingwrap">
<?

if($_GET[item]){
	$item = $_GET[item];
	$array = $items->get_details($item);
	if(empty($array)) {
		echo '</div><h3>We\'re Sorry, the item you have requested is invalid or no longer available</h3>';
	} else {
		?><div id="sidebar">
        <h1>Home Details</h1>
        <?
        	$agency_info = $users->get_agency_info($array[agency]);
        	echo '<h2>This listing provided by:</h2>';
        	echo '<h3>'.$agency_info[en_name].'</h3>
        	<a style="color:#FFF" href="'.$agency_info[url].'">'.$agency_info[url].'</a><br>
        	Phone: '.$agency_info[phone].'<br>';
        	if($agency_info[fax] != ''){
			echo 'Fax: '.$agency_info[fax].'<br>';
        	}
        	echo 'Email: <a style="color:#FFF" href="mailto:'.$agency_info[email].'?subject=I saw '.$array[name].' on '.$config[site][name].'&body=I would like more information about this house.">'.$agency_info[email].'</a><br>';
        	
        ?>
    </div>
            <div id="post-<?=$array[id]?>">
                <div id="imageslides">
                <? 
                	$pictures = $items->get_all_pictures($array[id]);
                	$counter=0; 
                	foreach ($pictures as $pic){
                		$counter++;
					echo '
<div>
	<img class="right" src="'.$config[site][url].'/images/'.$pic.'" height="438" width="630" alt="'.$array[name].'" />
</div>
					      ';
                	}
                ?>
                </div>
                <div id="imagesnav">
                    <ul class="right">
                    <?
                    	$i=1;
                    	while($i<=$counter){
                    		echo '<li><span class="jFlowControl">'.$i.'</span></li>';
                    		$i++;
                    	}
                    ?>
                    </ul>
                    <span class="jFlowPrev left">Previous</span>
                    <span class="jFlowNext right">Next</span>
                </div>
                    <div class="clear"></div>
                <div id="listingdetail">
                    <div class="address">
                        <h3><?=$array[name]?></h3>
                                                    <p class="location">Near <?=$listings->get_base_name($array[base])?></p>
                                                                            <p class="right price">&yen;<?=number_format($array[price])?>                                                                            <span>/monthly</span></p>
                                            </div>
                    <div class="clear"></div>                                        
                                            <p class="bedbathsqft"><?=$array[bed]?> Bed, <?=$array[bath]?> Bath, <?=$array[squarefeet]?> Sq Ft</p>
                                            <p class="propertytype">Property Type: <?=$listings->get_category_name($array[category])?></p>
                    <h4>Property Description</h4>
                    <p><?=$array[description]?></p>
                </div>
            </div>
	</div>
<?
	}

} else {
	echo '<h3>We\'re Sorry, you have not selected an item</h3>';
}

?>
	