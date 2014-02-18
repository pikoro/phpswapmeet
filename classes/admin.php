<?

class admin {

    function admin() {
        include_once('database.php');
        require('includes/config.php');
        $this->db = new database();
        $this->config = $config;
        $this->logger = new logger();
        $this->logger->logit("[admin] $_SESSION[id] accessed the admin page");
    }

    function list_users() {
        $sql = 'select * from ' . $this->config[database][prefix] . 'users';
        //echo $sql;
        $res = mysql_query($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $array[] = $row;
        }
        return $array;
    }

    function list_categories() {
        $sql = 'select * from ' . $this->config[database][prefix] . 'categories';
        //echo $sql;
        $res = mysql_query($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $array[] = $row;
        }
        return $array;
    }

    function delete_category($id) {
        $sql = 'delete from ' . $this->config[database][prefix] . 'categories where id = ' . $id;
        $res = mysql_query($sql);
        if (mysql_affected_rows($res) > 0) {
            $this->logger->logit("[admin] $_SESSION[id] deleted category $id");
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function delete_user($id) {
        $sql = 'delete from ' . $this->config[database][prefix] . 'users where id = ' . $id;
        $res = mysql_query($sql);
        if (mysql_affected_rows($res) > 0) {
            $this->logger->logit("[admin] $_SESSION[id] deleted user $id");
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_user_info($id) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'users where id = ' . $id;
        $res = mysql_query($sql);
        $array = mysql_fetch_assoc($res);
        return $array;
    }

    function update_user($user) {
        if ($user[active]) {
            $user[active] = 1;
        } else {
            $user[active] = 0;
        }
        //print_r($user);
        $sql = 'update ' . $this->config[database][prefix] . 'users set username="' . $user[username] . '", email1="' . $user[email1] . '", email2="' . $user[email2] . '", dob="' . $user[dob] . '", access_level="' . $user[access_level] . '", active="' . $user[active] . '", confirm_key="' . $user[confirm_key] . '" where id="' . $user[id] . '"';
        $res = mysql_query($sql);
        if ($res == 1) {
            $this->logger->logit("[admin] $_SESSION[id] updated user $user");
            echo '<h3>User has been updated.  Click <a href="?p=admin">here</a> to return to the menu</h3>';
            return TRUE;
        } else {
            echo '<h3>There was an error updating the user.  Click <a href="?p=admin">here</a> to return to the menu</h3>';
            return FALSE;
        }
    }

    function suspend_user($userid) {
        
    }

    function add_news($article) {
        $sql = 'insert into ' . $this->config[database][prefix] . 'news (`title`,`article`) values ("' . $article[title] . '","' . $article[article] . '")';
        //print_r($_POST);
        //echo $sql;
        $this->db->query($sql);
        $this->logger->logit("[admin] $_SESSION[id] added new news: $article[title]");
    }

}

?>