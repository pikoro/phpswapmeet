<?

class logger {

    function logger() {
        require('includes/config.php');
        $this->config = $config;
        $this->db = new database();
    }

    function logit($entry) {
        $sql = 'insert into ' . $this->config[database][prefix] . 'log (`entry`) value ("[' . $_SERVER['REMOTE_ADDR'] . '] ' . $entry . '")';
        //echo $sql;
        $this->db->query($sql);
    }

}

?>