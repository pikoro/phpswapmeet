<?

class items {

    function items() {
        require('includes/config.php');
        //require('classes/database.php');
        $this->config = $config;
        $this->db = new database();
        $this->logger = new logger();
    }

    function add() {
        // Filter input
        $sessionId = filter_input(INPUT_SESSION, 'id');
        $name = filter_input(INPUT_POST, 'name');
        $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
        $description = filter_input(INPUT_POST, 'description');
        $condition = filter_input(INPUT_POST, 'condition');
        $post_type = filter_input(INPUT_POST, 'post_type');
        $value = filter_input(INPUT_POST, 'value');
        $notes = filter_input(INPUT_POST, 'notes');

        $sql = 'insert into ' . $this->config[database][prefix] . 'items (`custid`,`name`,`category`,`description`,`condition`,`post_type`,`value`,`notes`) values ("' . $sessionId . '","' . $name . '","' . $category . '","' . $description . '","' . $condition . '","' . $post_type . '","' . $value . '","' . $notes . '")';
        //echo $sql;
        $inst = $this->db->query($sql); // Stick the item into the db
        //$item_id = mysqli_insert_id($inst);
        $item_id = mysql_insert_id($inst);
        //print_r($_FILES);
        $this->logger->logit("[items] $_SESSION[id] added a new item");
        for ($i = 0; $i < count($_FILES['photo']['name']); $i++) {
            $filename = $_FILES['photo']['name'][$i];
            if ($filename != '') {
                $filename = $this->config[site][homedir] . '/' . $this->config[settings][imagedir] . 'file' . $i; // specify new temp filename
                move_uploaded_file($_FILES['photo']['tmp_name'][$i], $filename); // Moves file to image directory
                `convert -flatten $filename $filename.jpg`; // Change it to a JPEG
                unlink($filename); // delete new temp file
                $new_filename = md5_file($filename . '.jpg') . '.jpg'; // Generate new filename based on md5 hash
                $new_img = $this->config[site][homedir] . '/' . $this->config[settings][imagedir] . $new_filename; // set new path
                $thumb_image = $this->config[site][homedir] . '/' . $this->config[settings][imagedir] . 'thumb/' . $new_filename;
                `convert $filename.jpg -quality 80 -resize 600x600 $new_img`; // resize image
                `convert -quality 80 -resize 100x100 $filename.jpg $thumb_image`; // resize thumbnail to 100pxx100px
                $sql = 'insert into ' . $this->config[database][prefix] . 'images (item_id, imagename) values ("' . $item_id . '","' . $new_filename . '")';
                $this->db->query($sql);
            }
        }
        // End New Image Processing

        return $error; // not sure why I put this here
    }

    function edit($item) {
        $sessionId = filter_input(INPUT_SESSION, 'id');
        $name = filter_input(INPUT_POST, 'name');
        $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
        $description = filter_input(INPUT_POST, 'description');
        $condition = filter_input(INPUT_POST, 'condition');
        $post_type = filter_input(INPUT_POST, 'post_type');
        $value = filter_input(INPUT_POST, 'value');
        $notes = filter_input(INPUT_POST, 'notes');

        $my_item = $this->get_item_permission($item, $_SESSION[id]);
        if ($my_item == TRUE) {
            $sql = 'update ' . $this->config[database][prefix] . 'items set `name`="' . $name . '", `category`="' . $category . '", `description`="' . $description . '", `condition`="' . $condition . '", `post_type`="' . $post_type . '",`value` = "' . $value . '", `notes`="' . $notes . '" where `id`=' . $item . ' and `custid` = ' . $sessionId;
            //echo $sql;
            $this->db->query($sql);
            $this->logger->logit("[items] $_SESSION[id] edited item $item");
        } else {
            $error["permissions"] = "This is not your item.";
            $this->logger->logit("[security] $_SESSION[id] attempted to edit item $item which is not theirs");
        }
        return $error;
    }

    function delete($item) {
        $sql = 'delete from ' . $this->config[database][prefix] . 'items where id=' . mysql_real_escape_string($item);
        mysql_query($sql);
        $sql = 'delete from ' . $this->config[database][prefix] . 'wanted where item_id=' . mysql_real_escape_string($item);
        mysql_query($sql);
        $this->logger->logit("[items] $_SESSION[id] deleted item $item");
    }

    function get_my_item_count() {
        $sql = 'select count(id) as count from ' . $this->config[database][prefix] . 'items where custid = ' . $_SESSION[id];
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->count;
        }
    }

    function get_my_items() {
        $sql = 'select * from ' . $this->config[database][prefix] . 'items where custid = ' . $_SESSION[id] . ' order by id DESC';
        $array = $this->db->get_array($sql);
        return $array;
    }

    function get_details($item) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'items where id=' . mysql_real_escape_string($item);
        $array = $this->db->get_array($sql);
        return $array[0];
    }

    function count_available() {
        $sql = 'select count(id) as count from ' . $this->config[database][prefix] . 'items';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->count;
        }
    }

    function count_my_wanted($id) {
        $sql = 'select count(id) as count from ' . $this->config[database][prefix] . 'wanted where user_id = ' . $id;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->count;
        }
    }

    function add_want($id) {
        $sql = 'insert into ' . $this->config[database][prefix] . 'wanted (`user_id`,`item_id`) values ("' . $_SESSION[id] . '","' . $id . '")';
        //echo $sql;
        $this->db->query($sql);
        $this->logger->logit("[items] $_SESSION[id] added item $id to their want list");
    }

    function remove_want($id) {
        $sql = 'delete from ' . $this->config[database][prefix] . 'wanted where id=' . $id;
        $this->db->query($sql);
        $this->logger->logit("[items] $_SESSION[id] removed item $id from their want list");
    }

    function get_my_wanted($userid) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'wanted where user_id = ' . $userid . ' order by id DESC';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $array[] = $row;
        }
        return $array;
    }

    function get_item_name($item) {
        $sql = 'select name from ' . $this->config[database][prefix] . 'items where id=' . $item;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->name;
        }
    }

    function get_item_permission($item, $userid) {
        $sql = 'select custid from ' . $this->config[database][prefix] . 'items where id=' . mysql_real_escape_string($item);
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            if ($row->custid == $userid) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    function check_owner($item) {
        $sql = 'select custid from ' . $this->config[database][prefix] . 'items where id=' . mysql_real_escape_string($item);
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->custid;
        }
    }

    function get_users_items($userid) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'items where custid=' . mysql_real_escape_string($userid) . ' and status=1';
        //echo $sql;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $array[] = $row;
        }
        return $array;
    }

    function get_main_picture($item) {
        $sql = 'select imagename from ' . $this->config[database][prefix] . 'images where item_id = ' . $item . ' LIMIT 1';
        //echo $sql;
        $res = $this->db->get_res($sql);
        if (mysql_num_rows($res) == 0) {
            return 'no_image.jpg';
        } else {
            while ($row = mysql_fetch_object($res)) {
                return $row->imagename;
            }
        }
    }

    function get_all_pictures($item) {
        $sql = 'select imagename from ' . $this->config[database][prefix] . 'images where item_id = ' . $item . ' LIMIT 0,5';
        //echo $sql;
        $res = $this->db->get_res($sql);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_object($res)) {
                $array[] = $row->imagename;
            }
        }
        return $array;
    }

    function count_users_items($id) {
        $sql = 'select count(id) as count from ' . $this->config[database][prefix] . 'items where status=1 and custid = ' . $id;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->count;
        }
    }

    function get_free_items() {
        $sql = 'select * from ' . $this->config[database][prefix] . 'items where post_type="free"';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $array[] = $row;
        }
        return $array;
    }

}
