<?php

class feedback {

    function feedback() {
        require('includes/config.php');
        require('classes/database.php');
        $this->config = $config;
        $this->db = new database();
    }

    function get_feedback_num($custid) {
        $feedback = 0;
        $sql = 'select value from ' . $this->config[database][prefix] . 'feedback where `to_user` = ' . $custid;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            $feedback = $feedback + $row->value;
        }
        return $feedback;
    }

    function get_feedback_detail($id) {
        $sql = 'select * from ' . $this->config[databse][prefix] . 'feedback where id = ' . $id;
        $array = $this->db->get_array($sql);
        return $array;
    }

    function get_all_feedback($custid) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'feedback where to_user = ' . $custid;
        $array = $this->db->get_array($sql);
        return $array;
    }

    function add($to_user, $from_user, $item, $value, $note) {
        $sql = 'insert into ' . $this->config[database][prefix] . 'feedback (`to_user`,`from_user`,`item`,`value`,`note`) values ("' . $to_user . '","' . $from_user . '","' . $item . '","' . $value . '","' . mysql_real_escape_string($note) . '")';
        $this->db->query($sql);
    }

}
