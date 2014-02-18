<?

if ($_GET[item]) {
    $item = filter_input(INPUT_GET, 'item');
    $array = $items->get_details($item);
    if (empty($array)) {
        echo '<h3>We\'re Sorry, the item you have requested is invalid or no longer available</h3>';
    } else {
        echo '<SCRIPT language="JavaScript">
				<!-- 
				function mouse_click(name){ 
					document.BigImage.src = name; 
				} 
				//-->
		</SCRIPT>';
        echo '<div><h2>' . $array[name] . '</h2><span style="float:right;"><a href="?p=profile&id=' . $array[custid] . '&pageID=1">' . $users->get_username($array[custid]) . '</a> (' . $feedback->get_feedback_num($array[custid]) . ')</span></div>';
        echo '<h4>' . $array[description] . '</h4>';
        echo '<div class="detail_container">';
        echo '<div class="pic_wrapper">';
        echo '<div class="detail_main_pic">';
        echo '<img name="BigImage" src="' . $config[settings][imagedir] . $items->get_main_picture($item) . '" alt="' . $array[name] . '" width="400px" />';

        echo '</div><br>';
        echo '<div class="detail_thumbs">';
        $thumbs = $items->get_all_pictures($array[id]);
        //print_r($thumbs);
        for ($i = 0; $i < count($thumbs); $i++) {
            echo '<input type="image" width="100px" src="' . $config[settings][imagedir] . 'thumb/' . $thumbs[$i] . '" onClick="mouse_click(this.name)" name="' . $config[settings][imagedir] . $thumbs[$i] . '" />';
        }
        echo '</div>';
        echo '</div>';
        echo '<div style="clear:right;"></div>';
        echo '<div class="sidebarlt">
		<b>Condition: ' . ucwords($array[condition]) . '<br>
		Item Type: ' . ucwords($array[post_type]) . '</b><br>';
        if ($array[value] > 0) {
            echo 'Price: $ ' . $array[value] . '</b><br>';
        }
        echo 'Desription:<br>' . $array[notes] . '</div>';

        if ($_SESSION[id]) {
            echo '<div class="sidebardk">';
            echo '<a href="?p=want&item=' . $array[id] . '&q=add">Add to my Want List</a><br>';
            echo '<a href="?p=swap&item=' . $array[id] . '&q=contact&user=' . $array[custid] . '">Contact Owner</a><br>';
            echo '<a href="?p=profile&id=' . $array[custid] . '&pageID=1">View User\'s Other items</a><br>';
            echo '<a href="?p=browse&cat=' . $listings->get_parent_category($array[category]) . '&sub=' . $array[category] . '&pageID=1">View other items like this one</a><br>';
            if ($array[post_type] == 'sell' || $array[post_type] == 'swap or sell') {
                if (!$array[value] == '' && !$users->get_paypal_address($array[custid]) == '') {
                    echo '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=' . $users->get_paypal_address($array[custid]) . '&lc=JP&item_name=[' . $config[site][name] . ']' . $array[name] . '&item_number=' . $array[id] . '&amount=' . $array[value] . '&currency_code=USD&cn=Add%20special%20instructions%20to%20seller%3a&no_shipping=2&bn=PP%2dBuyNowBF%3abtn_paynowCC_LG%2egif%3aNonHosted"><img src="https://www.paypal.com/en_US/JP/i/btn/btn_buynowCC_LG.gif" alt="Purchase with Paypal"/></a><br/>';
                }
            }
            if ($_SESSION[id] == $array[custid]) {
                echo '<a href="?p=edit_item&id=' . $array[id] . '">Edit This Item</a><br>';
            }
            echo '</div>';
        } else {
            echo '<p>Please <a href="?p=login">Login</a> to get more information about this item</p>';
        }
        echo '</div>';
    }
} else {
    echo '<h3>We\'re Sorry, you have not selected an item</h3>';
}