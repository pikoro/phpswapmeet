<?

class database {

    function database() {
        require('includes/config.php');
        mysql_connect($config[database][server], $config[database][dbuser], $config[database][dbpass]);
        mysql_select_db($config[database][db]);
        //$this->logger = new logger();
    }

    function query($sql) {
        @mysql_query($sql);
    }

    function get_res($sql) {
        $res = @mysql_query($sql);
        return $res;
    }

    function get_array($sql) {
        $res = @mysql_query($sql);
        for ($i = 0; $i < @mysql_num_rows($res); $i++) {
            $array[] = @mysql_fetch_array($res);
        }
        return $array;
    }

    function close() {
        @mysql_close();
    }

    function release($res) {
        mysql_free_result($res);
    }

}

