<?

class database {

    function database() {
        require('includes/config.php');
        mysql_connect($config[database][server], $config[database][dbuser], $config[database][dbpass]);
        mysql_select_db($config[database][db]);
    }

    function query($sql) {
        try {
            mysql_query($sql);
        } catch (Exception $e) {
            echo 'A database error has occured.  Please contact the site administrator: ' . $e;
        }
    }

    function get_res($sql) {
        try {
            $res = mysql_query($sql);
            return $res;
        } catch (Exception $e) {
            echo 'A database error has occured.  Please contact the site administrator: ' . $e;
        }
    }

    function get_array($sql) {
        try {
            $res = mysql_query($sql);
            for ($i = 0; $i < mysql_num_rows($res); $i++) {
                $array[] = mysql_fetch_array($res);
            }
            return $array;
        } catch (Exception $e) {
            echo 'A database error has occured.  Please contract the site administrator: ' . $e;
        }
    }

    function get_assoc($sql) {
        try {
            $res = mysql_query($sql);
            for ($i = 0; $i < mysql_num_rows($res); $i++) {
                $array[] = mysql_fetch_assoc($res);
            }
            return $array;
        } catch (Exception $e) {
            echo 'A database error has occured.  Please contract the site administrator: ' . $e;
        }
    }
    
     function get_obj($sql) {
        try {
            $res = mysql_query($sql);
            for ($i = 0; $i < mysql_num_rows($res); $i++) {
                $array[] = mysql_fetch_object($res);
            }
            return $array;
        } catch (Exception $e) {
            echo 'A database error has occured.  Please contract the site administrator: ' . $e;
        }
    }

// Prepared statements below here

    function prepared_select_assoc(){
        $mysqli = new mysqli($config[database][server],$config[database][dbuser],$config[database][dbpass],$config[database][db]);
        if ($mysqli->connect_errno){
            echo "Failed to connecto to MySqL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $stmt->fetch_assoc();

        return $row;
    }

    function close() {
        mysql_close();
    }

    function release($res) {
        mysql_free_result($res);
    }

}
