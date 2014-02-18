<?

class swap {

    function swap() {
        require('includes/config.php');
        include_once('classes/users.php');
        include_once('classes/items.php');
        $this->config = $config;
        $this->users = new user();
        $this->items = new items();
        $this->db = new database();
    }

    function log_swap() {
        
    }

    function do_swap() {
        
    }

    function get_first_messages($item) {
        $subject = '<select id="message" name="message">';
        $subject.= '<option value="">Please Select a Message</option>';
        $subject.= '<option value="Is this item still available?">Is this item still available?</option>';
        $subject.= '<option value="What is it\'s condition?">What is it\'s condition?</option>';
        $subject.= '<option value="I would like to purchase this item.">I would like to purchase this item.</option>';
        $subject.= '<option value="I want to trade you something for this item.">I want to trade you something for this item.</option>';
        $subject.= '</select>';
        return $subject;
    }

    function count_today() {
        $sql = 'select count(id) as count from ' . $this->config[database][prefix] . 'swap_log where trade_date like "' . date("Y-m-d") . '%"';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->count;
        }
    }

    function count_month() {
        $sql = 'select count(id) as count from ' . $this->config[database][prefix] . 'swap_log where trade_date like "' . date("Y-m") . '%"';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->count;
        }
    }

    function count_all() {
        $sql = 'select count(id) as count from ' . $this->config[database][prefix] . 'swap_log';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->count;
        }
    }

}