<?
 if($_POST[add_item]){
 	$error = $items->add();
    if(is_array($error)){
    	echo '<h2>Errors Encountered</h2>';
		while(list($key, $val) = each($error)){
			echo $val;
			echo "<br>\n";
		}
	} else {
		echo '<h3>Your Item has been added!  Go to your <a href="?p=desktop">Management Page</a> to see it</h3>';
	}
 } else {
?>

<script language="JavaScript" type="text/javascript" src="includes/xpath.js"></script>
<script language="JavaScript" type="text/javascript" src="includes/SpryData.js"></script>
<br>
<h3>Add your listing in 3 easy steps:</h3>
<form id="add_item" name="add_item" enctype="multipart/form-data" method="POST" action="?p=add_item">
<h2>Step 1:  Describe your Item</h2>
<table>
	<tr><th align="top">House Name</th><td><input type="text" id="name" name="name"/></td></tr>
 	<tr><th>Listing Type</th><td>
    	<select id="category" name="category">
    		<option value="1">Single Home</option>
    		<option value="2">Apartment</option>
    		<option value="3">Duplex</option>
    	</select>
    </td></tr>
    <tr><th>Bedrooms</th><td>
    	<select id="bed" name="bed">
    		<option value="1">1</option>
    		<option value="2">2</option>
    		<option value="3">3</option>
    		<option value="4">4</option>
    		<option value="5">5</option>
    		<option value="6">6+</option>
    	</select>
    </td></tr>
    <tr><th>Bathrooms</th><td>
    	<select id="bath" name="bath">
    		<option value="1">1</option>
    		<option value="1.5">1.5</option>
    		<option value="2">2</option>
    		<option value="2.5">2.5</option>
    		<option value="3">3</option>
    		<option value="3.5">3.5</option>
    		<option value="4">4+</option
    	</select>
    </td></tr>
    <tr><th>Parking Spaces</th><td>
    	<select id="parking" name="parking">
    		<option value="1">1</option>
    		<option value="2">2</option>
    		<option value="3">3</option>
    		<option value="4">4</option>
    		<option value="5">5</option>
    		<option value="6">6+</option>
    	</select>
    </td></tr>
    <tr><th>Nearest Base</th><td>
    	<select name="base">
    		<option value="0" selected>Any</option>
    		<option value="1" >Kinser</option>
    		<option value="2" >Futenma</option>
    		<option value="3" >Foster</option>
    		<option value="4" >Lester</option>
    		<option value="5" >Kadena</option>
    		<option value="6" >Torii Station</option>
    		<option value="7" >McTureous</option>
    		<option value="8" >Courtney</option>
    		<option value="9" >Schwab</option>
    		<option value="10" >Hansen</option>
    	</select>
    </td></tr>
    <tr><th>Square Feet</th><td><input type="text" name="squarefeet" id="squarefeet" />(No commas)</td></tr>
    <tr><th>Price</th><td><input type="text" name="price" id="price" /> (Monthly Rent in Yen.  No &yen; sign)</td></tr>
</table>
<br>
<h2>Step 2:  Upload a Photo</h2>
<h3>Try to make your photo clearly show the item you wish to trade (Max of 5 Photos)</h3>
<table>
	<tr><th>Photo</th><td><input type="file" name="photo[]" />(This will be the main photo)</td></tr>
     <tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
     <tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
     <tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
     <tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
</table>
<h2>Step 3:  Enter Description of Home</h2>
<h3>Additional information such as Location, Ocean View, large yard, etc...</h3>
<table>
	<tr><th>Additional Notes</th><td width="600px">
     <?php
$oFCKeditor = new FCKeditor('description') ;
$oFCKeditor->BasePath = 'fckeditor/' ;
$oFCKeditor->Value = $_POST[description] ;
$oFCKeditor->ToolbarSet = 'Basic';
$oFCKeditor->Create() ;
?>
</td></tr>
</table>
<input type="submit" value="Add Item" name="add_item" />
</form>

<? } ?>
