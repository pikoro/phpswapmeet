<?
 if($_POST[add_item]){
 	 //print_r($_POST);
 	$error = $items->add();
    if(is_array($error)){
    	echo '<h2>Errors Encountered</h2>';
		while(list($key, $val) = each($error)){
			echo $val;
			echo "<br>\n";
		}
	} else {
		echo '<h3>Your Item has been added!  Go to your <a href="?p=desktop">Desktop</a> to see it</h3>';
	}
 } else {
?>

<script language="JavaScript" type="text/javascript" src="includes/xpath.js"></script>
<script language="JavaScript" type="text/javascript" src="includes/SpryData.js"></script>
<script language="JavaScript" type="text/javascript" src="includes/SpryAutoSuggest.js"></script>
<link href="includes/SpryAutoSuggest.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	var dsParents = new Spry.Data.XMLDataSet("classes/query2xml.php?type=parent","/root/row");
	var dsSubs = new Spry.Data.XMLDataSet("classes/query2xml.php?type=child&parent={dsParents::id}","/root/row");
    var dsTitles = new Spry.Data.XMLDataSet("classes/query2xml.php?type=suggest", "/root/row", { sortOnLoad: "name" });
</script>

<h1>Add your item in 3 easy steps:</h1>
<form id="add_item" name="add_item" enctype="multipart/form-data" method="POST" action="?p=add_item">
<h2>Step 1:  Describe your Item</h2>
<h3>Keep this section about just the Item itself, as if it were new.  Details go in Step 3</h3>
<h4>Examples: Panasonic Car Stereo, 1Gb DRAM Module, Sony Vaio Laptop</h4>
<table>
	<tr><th align="top">Item Name</th><td>
	<div id="suggest" style="float:left; position:absolute;">
		<input type="text" id="name" name="name"/>
		<div id="asName" spry:region="dsTitles">
			<div spry:repeat="dsTitles" spry:suggest="{name}">
				<div class="list">{name}</div>
			</div>
		</div>
		</div>
 (50 Character Limit)</td>Suggestions appear as you type</tr>
 <script type="text/javascript">
	var as1 = new Spry.Widget.AutoSuggest('suggest', 'asName', 'dsTitles', 'name',{hoverSuggestClass:'highlight', containsString: true});
</script>

	<tr><th>Main Category</th><td>
    <span spry:region="dsParents" id="parentSelector">
		<select spry:repeatchildren="dsParents" name="parentSelect" onchange="document.forms[1].subSelect.disabled = true; dsParents.setCurrentRowNumber(this.selectedIndex);">
			<option value="{id}">{category}</option>
		</select>
	</span>
	</td></tr>
	<tr><th>Sub Category</th><td>
    <span spry:region="dsSubs" id="subSelector">
		<select spry:repeatchildren="dsSubs" id="subSelect" name="category">
			<option value="{id}">{category}</option>
		</select>
	</span>
	</td></tr>
	<tr><th>Item Description</th><td><input type="text" maxlength="90" name="description" /> (90 Character Limit)</td></tr>
	<tr><th>Condition</th><td><select name="condition" id="condition">
	<option value="new" >New</option>
	<option value="almost new" >Almost New</option>
	<option value="used" selected>Used</option>
	<option value="worn" >Worn</option>
	<option value="well worn" >Well Worn</option>
	<option value="falling apart" >Falling Apart</option>
	<option value="broken" >Broken</option>
	</select></td></tr>
	<tr><th>Post Type</th><td><select name="post_type" id="post_type">
	<option value="swap" >Swap</option>
	<option value="sale" >Sale</option>
	<option value="swap or sell" selected>Swap or Sell</option>
	<option value="free" >Free</option>
	</select></td></tr>
    <tr><th>Price</th><td>$<input type="text" name="value" id="value" /> (Value in Dollars.  No $ sign)</td></tr>
</table>
<h2>Step 2:  Upload a Photo</h2>
<h3>Try to make your photo clearly show the item you wish to trade (Max of 5 Photos)</h3>
<table>
	<tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
     <tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
     <tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
     <tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
     <tr><th>Photo</th><td><input type="file" name="photo[]" /></td></tr>
</table>
<h2>Step 3:  Enter Additional Notes</h2>
<h3>Additional information such as item condition, color, etc...  Basically the same stuff you would list in a classified ad listing</h3>
<table>
	<tr><th>Additional Notes</th><td width="600px">
     <?php
$oFCKeditor = new FCKeditor('notes') ;
$oFCKeditor->BasePath = 'fckeditor/' ;
$oFCKeditor->Value = $_POST[description] ;
$oFCKeditor->ToolbarSet = 'Basic';
$oFCKeditor->Create() ;
?>

<!--	<textarea name="notes" id="notes" rows="10" cols="70"></textarea> --></td></tr>
</table>
<input type="submit" value="Add Item" name="add_item" />
</form>

<? } ?>
