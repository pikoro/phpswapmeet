<?

class listings {

    function listings() {
        require('includes/config.php');
        include_once('classes/database.php');
        include_once('classes/items.php');
        $this->db = new database();
        $this->config = $config;
        $this->items = new items();
        $this->logger = new logger();
    }

    function search() {
        
    }

    function get_categories() {
        $sql = 'select * from ' . $this->config[database][prefix] . 'categories where parent=0 and status = 1';
        //echo $sql;
        $array = $this->db->get_array($sql);
        return $array;
    }

    function category_dropdown($catid = 0) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'categories where status=1 order by parent, id';
        $array = $this->db->get_array($sql);
        //print_r($array);
        echo '<select name="category" id="category">
    	';
        echo '<option value="0">Select a Category</option>';

        foreach ($array as $category) {

            if ($category[parent] == 0) {
                if ($catid == $category[id]) {
                    $selected = ' selected ';
                } else {
                    $selected = '';
                }
                echo '<option value="' . $category[id] . '"' . $selected . '>' . $category[category] . '</option>
				';
                $sql2 = 'select * from ' . $this->config[database][prefix] . 'categories where parent=' . $category[id] . ' and status=1 order by id';
                //echo $sql2;
                $res = $this->db->get_res($sql2);
                while ($row = mysql_fetch_object($res)) {
                    if ($catid == $row->id) {
                        $selected = ' selected ';
                    } else {
                        $selected = '';
                    }
                    echo '<option value="' . $row->id . '"' . $selected . '>--' . $row->category . '</option>
				';
                }
            }
        }
        echo '</select>';
    }

    function count_items($category) {
        $items = 0;
        $sql = 'select count(id) as count from ' . $this->config[database][prefix] . 'items where category=' . mysql_real_escape_string($category);
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            $items = $row->count;
            return $items;
        }
    }

    function count_children_items($category) {
        $items = 0;
        $sql = 'select id from ' . $this->config[database][prefix] . 'categories where parent = ' . mysql_real_escape_string($category);
        //echo $sql;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            $cat_ids[] = $row->id;
        }
        for ($i = 0; $i < count($cat_ids); $i++) {
            $items = $items + $this->count_items($cat_ids[$i]);
        }
        return $items;
    }

    function get_parent_category($category) {
        $parent = 0;
        $sql = 'select parent from ' . $this->config[database][prefix] . 'categories where id = ' . mysql_real_escape_string($category) . ' limit 1';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            $parent = $row->parent;
            return $row->parent;
        }
    }

    function get_child_categories($category) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'categories where parent = ' . mysql_real_escape_string($category) . ' and status=1';
        $array = $this->db->get_array($sql);
        return $array;
    }

    function get_child_category_nums($category) {
        $sql = 'select id from ' . $this->config[database][prefix] . 'categories where parent = ' . mysql_real_escape_string($category);
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            $array[] = $row->id;
        }
        return $array;
    }

    function get_items($category) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'items where category = ' . mysql_real_escape_string($category);
        $array = $this->db->get_array($sql);
        return $array;
    }

    function get_child_items($category) {
        $categories = $this->get_child_categories($category); // list of each category id
        for ($i = 0; $i < count($categories); $i++) {
            $child_items[] = $this->get_items($categories[$i][id]);
        }
        return $child_items;
    }

    function get_category_name($category) {
        $sql = 'select category from ' . $this->config[database][prefix] . 'categories where id = ' . mysql_real_escape_string($category) . ' and status=1';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->category;
        }
    }

    function get_featured() {
        $sql = 'select * from ' . $this->config[database][prefix] . 'items order by list_date DESC limit 0,6 ';
        //echo $sql;
        $array = $this->db->get_array($sql);
        return $array;
    }

    function get_all() {
        $sql = 'select * from ' . $this->config[database][prefix] . 'items where status=1 order by list_date DESC';
        //echo $sql;
        $array = $this->db->get_array($sql);
        return $array;
    }

    function show_item_listing($id) {
        $array = $this->items->get_details($id);

        echo '<div class="sidebarlt" style="height:auto; text-align:left; width:auto;">';
        echo '<div style="text-align: center; position:relative; vertical-align: middle; border:1px solid #AAA; width:65px; height:65px;"><a href="?p=detail&item=' . $array[id] . '"><img height="65" width="65" src="' . $this->config[settings][imagedir] . 'thumb/' . $this->items->get_main_picture($array[id]) . '" alt="' . $array[name] . '" /></a></div>';
        echo '<div style="margin-left:80px; margin-top:-75px; width: auto;"><b><a href="?p=detail&item=' . $array[id] . '">' . $array[name] . '</a></b>';
        if ($array[custid] == $_SESSION[id]) {
            echo '<span style="float:right; margin-top:-25px;"><a href="?p=edit_item&id=' . $array[id] . '">Edit</a></span>';
        }
        echo '</div>';
        echo '<div style="margin-left:80px; width: auto;">Condition: <b>' . ucwords($array[condition]) . '</b> Type of Post: <b>' . ucwords($array[post_type]) . '</b></div>';
        echo '<div style="margin-left:80px; width: auto;">' . $array[description] . '</div>';
        echo '<div style="margin-left:80px; width: auto;">Posted:' . $array[list_date];
        if ($array[custid] == $_SESSION[id]) {
            echo '<span style="float:right; margin-top:-10px;"><a href="?p=delete_item&id=' . $array[id] . '">Delete</a></span>';
        }
        echo '</div>';
        echo '</div>';
    }

    function pager($data) {
        require_once 'Pager/Pager.php';
        $pager_params = array(
            'mode' => 'Jumping', // Can be Jumping or Sliding
            'append' => true, //append the GET parameters to the url
            'path' => '',
            'fileName' => 'javascript:revealDiv(%d)', //Pager replaces "%d" with the page number...
            'perPage' => $this->config[site][per_page], //show items per page from config file
            'delta' => 5,
            'itemData' => $data
        );
        $pager = & Pager::factory($pager_params);
        $n_pages = $pager->numPages();
        $links = $pager->getLinks($_GET[pageID]);
        echo '<div style="text-align:center">' . $links['all'] . '</div>
            ';
        for ($i = 1; $i <= $n_pages; ++$i) {

            echo '<div class="page" id="page' . $i . '">
            ';
            echo '<h2>Page ' . $i . '</h2>
            ';
            foreach ($pager->getPageData($i) as $item) {
                $this->show_item_listing($item[id]);
            }
            echo '</div>';
        }
        echo '<div>' . $links['all'] . '</div>';
        echo '
        <script type="text/javascript">
    			var n_pages = ' . $n_pages . ';
			    function revealDiv(n)
			    {
			        for (var count = 1; count <= n_pages; count++) {
			          document.getElementById("page"+count).style.display = \'none\';
			        }
			        document.getElementById("page"+n).style.display = \'block\';
			    }
				</script>
				';
    }

}
