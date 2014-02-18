<?
$items = new items();
 if($_POST[edit_item]){
 	 //print_r($_POST);
 	$error = $items->edit($_POST[id]);
    if(is_array($error)){
    	echo '<h2>Errors Encountered</h2>';
		while(list($key, $val) = each($error)){
			echo $val;
			echo "<br>\n";
		}
	} else {
		echo '<h3>Your Item has been updated!</h3>';
        echo '<h3>Return to your <a href="?p=desktop">desktop</a> or wait 3 seconds</h3>';
		   echo '<meta http-equiv="refresh" content="3;url='.$config[site][url].'/?p=desktop" />';
	}
 } else {
 	$id = $_GET[id];
 	$item = $items->get_details($id);
 	//print_r($item);
?>
<form id="edit_item" name="edit_item" enctype="multipart/form-data" method="POST" action="?p=edit_item">
<h2>Step 1:  Describe your Item</h2>
<table>
    <tr><th align="top">House Name</th><td><input type="text" id="name" value="<?=$item[name] ?>" name="name"/></td></tr>
     <tr><th>Listing Type</th><td>
     <input type="hidden" name="id" value="<?=$item[id]?>"/>
        <select id="category" name="category">
            <option value="1"<? if($item[category]==1){echo ' selected';}?>>Single Home</option>
            <option value="2"<? if($item[category]==2){echo ' selected';}?>>Apartment</option>
            <option value="3"<? if($item[category]==3){echo ' selected';}?>>Duplex</option>
        </select>
    </td></tr>
    <tr><th>Bedrooms</th><td>
        <select id="bed" name="bed">
            <option value="1"<? if($item[bed]==1){echo ' selected';}?>>1</option>
            <option value="2"<? if($item[bed]==2){echo ' selected';}?>>2</option>
            <option value="3"<? if($item[bed]==3){echo ' selected';}?>>3</option>
            <option value="4"<? if($item[bed]==4){echo ' selected';}?>>4</option>
            <option value="5"<? if($item[bed]==5){echo ' selected';}?>>5</option>
            <option value="6"<? if($item[bed]==6){echo ' selected';}?>>6+</option>
        </select>
    </td></tr>
    <tr><th>Bathrooms</th><td>
        <select id="bath" name="bath">
            <option value="1"<? if($item[bath]==1){echo ' selected';}?>>1</option>
            <option value="1.5"<? if($item[bath]=='1.5'){echo ' selected';}?>>1.5</option>
            <option value="2"<? if($item[bath]==2){echo ' selected';}?>>2</option>
            <option value="2.5"<? if($item[bath]=='2.5'){echo ' selected';}?>>2.5</option>
            <option value="3"<? if($item[bath]==3){echo ' selected';}?>>3</option>
            <option value="3.5"<? if($item[bath]=='3.5'){echo ' selected';}?>>3.5</option>
            <option value="4"<? if($item[bath]==4){echo ' selected';}?>>4+</option
        </select>
    </td></tr>
    <tr><th>Parking Spaces</th><td>
        <select id="parking" name="parking">
            <option value="1"<? if($item[parking]==1){echo ' selected';}?>>1</option>
            <option value="2"<? if($item[parking]==2){echo ' selected';}?>>2</option>
            <option value="3"<? if($item[parking]==3){echo ' selected';}?>>3</option>
            <option value="4"<? if($item[parking]==4){echo ' selected';}?>>4</option>
            <option value="5"<? if($item[parking]==5){echo ' selected';}?>>5</option>
            <option value="6"<? if($item[parking]==6){echo ' selected';}?>>6+</option>
        </select>
    </td></tr>
    <tr><th>Nearest Base</th><td>
        <select name="base">
            <option value="0"<? if($item[base]==0){echo ' selected';}?>>Any</option>
            <option value="1"<? if($item[base]==1){echo ' selected';}?>>Kinser</option>
            <option value="2"<? if($item[base]==2){echo ' selected';}?>>Futenma</option>
            <option value="3"<? if($item[base]==3){echo ' selected';}?>>Foster</option>
            <option value="4"<? if($item[base]==4){echo ' selected';}?>>Lester</option>
            <option value="5"<? if($item[base]==5){echo ' selected';}?>>Kadena</option>
            <option value="6"<? if($item[base]==6){echo ' selected';}?>>Torii Station</option>
            <option value="7"<? if($item[base]==7){echo ' selected';}?>>McTureous</option>
            <option value="8"<? if($item[base]==8){echo ' selected';}?>>Courtney</option>
            <option value="9"<? if($item[base]==9){echo ' selected';}?>>Schwab</option>
            <option value="10"<? if($item[base]==10){echo ' selected';}?>>Hansen</option>
        </select>
    </td></tr>
    <tr><th>Square Feet</th><td><input type="text" name="squarefeet" value="<?=$item[squarefeet]?>" id="squarefeet" />(No commas)</td></tr>
    <tr><th>Price</th><td><input type="text" name="price" value="<?=$item[price]?> "id="price" /> (Monthly Rent in Yen.  No &yen; sign)</td></tr>
</table>
<br>
<!--<h2>Step 2:  Upload a Photo</h2>
<h3>Try to make your photo clearly show the item you wish to trade (Max of 5 Photos)</h3>
<table>
    <tr><th>Photo</th><td><input type="file" name="photo[]" />(This will be the main photo)</td></tr>
     <tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
     <tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
     <tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
     <tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
</table> -->
<h2>Step 2:  Enter Description of Home</h2>
<h3>Additional information such as Location, Ocean View, large yard, etc...</h3>
<table>
    <tr><th>Additional Notes</th><td width="600px">
     <?php
$oFCKeditor = new FCKeditor('description') ;
$oFCKeditor->BasePath = 'fckeditor/' ;
$oFCKeditor->Value = $item[description] ;
$oFCKeditor->ToolbarSet = 'Basic';
$oFCKeditor->Create() ;
?>
</td></tr>
</table>
<input type="submit" value="Update Item" name="edit_item" />
</form>

<? } ?>