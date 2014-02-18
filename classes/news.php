<?

class news {

    function news() {
        require('includes/config.php');
        $this->db = new database();
        $this->config = $config;
    }

    function get_all_articles() {
        $sql = 'select * from ' . $this->config[database][prefix] . 'news ORDER BY id DESC';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $array[] = $row;
        }
        return $array;
    }

    function show_news() {
        // Need to add something here
    }

}
