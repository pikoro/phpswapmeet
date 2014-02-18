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
		   echo '<meta http-equiv="refresh" content="3;url=http://www.okinawaswap.com/?p=desktop" />';
	}
 } else {
 	$id = $_GET[id];
 	$item = $items->get_details($id);
 	//print_r($item);
?>

<form id="edit_item" name="edit_item" enctype="multipart/form-data" method="POST" action="?p=edit_item">
<h2>Edit your Item</h2>
<table>
    <input type="hidden" name="id" value="<?= $item[id] ?>" />
	<tr><th>Item Name</th><td><input type="text" name="name" value="<?= $item[name]?>" /> (50 Character Limit)</td></tr>
	<tr><th>Category</th><td><?= $listings->category_dropdown($item[category]) ?></td></tr>
	<tr><th>Item Description</th><td><input type="text" maxlength="90" name="description" value="<?= $item[description]?>"/> (90 Character Limit)</td></tr>
     <tr><th>Condition</th><td><select name="condition" id="condition">
	<option value="new" <? if($item[condition] == 'new') echo 'selected' ?>>New</option>
	<option value="almost new" <? if($item[condition] == 'almost new') echo 'selected' ?>>Almost New</option>
	<option value="used" <? if($item[condition] == 'used') echo 'selected' ?>>Used</option>
	<option value="worn" <? if($item[condition] == 'worn') echo 'selected' ?>>Worn</option>
	<option value="well worn" <? if($item[condition] == 'well worn') echo 'selected' ?>>Well Worn</option>
	<option value="falling apart" <? if($item[condition] == 'falling apart') echo 'selected' ?>>Falling Apart</option>
	<option value="broken" <? if($item[condition] == 'broken') echo 'selected' ?>>Broken</option>
	</select></td></tr>
	<tr><th>Post Type</th><td><select name="post_type" id="post_type">
	<option value="swap" <? if($item[post_type] == 'swap') echo 'selected' ?>>Swap</option>
	<option value="sell" <? if($item[post_type] == 'sell') echo 'selected' ?>>Sale</option>
	<option value="swap or sell" <? if($item[post_type] == 'swap or sell') echo 'selected' ?>>Swap or Sell</option>
	<option value="free" <? if($item[post_type] == 'free') echo 'selected' ?>>Free</option>
	</select></td></tr>
    <tr><th>Price</th><td>$<input type="text" name="value" id="value" value="<?= $item[value] ?>" /> (Value in Dollars.  No $ sign)</td></tr>
</table>
<table>
	<tr><th>Additional Notes</th><td width="600px">
     <?php
$oFCKeditor = new FCKeditor('notes') ;
$oFCKeditor->BasePath = 'fckeditor/' ;
$oFCKeditor->Value = $item[notes] ;
$oFCKeditor->ToolbarSet = 'Basic';
$oFCKeditor->Create() ;
?>
</td></tr>
</table>
<input type="submit" value="Update Item" name="edit_item" />
</form>

<? } ?>