<?

class messages {

    function messages() {
        require('includes/config.php');
        include_once('classes/users.php');
        include_once('classes/database.php');
        $this->config = $config;
        $this->db = new database();
        $this->logger = new logger();
    }

    function inbox() {
        
    }

    function send($from, $to, $subject, $message) {
        $user = new user();
        // Insert the message into the recipiant's Inbox
        $sql = 'insert into ' . $this->config[database][prefix] . 'messages (`from`,`to`,`subject`,`message`,`folder`) values ("' . $from . '","' . $to . '","' . mysql_real_escape_string($subject) . '","' . mysql_real_escape_string($message) . '","' . $this->get_inbox_id($to) . '")';
        // Also put a copy into the sender's Sent Box
        $sql2 = 'insert into ' . $this->config[database][prefix] . 'messages (`from`,`to`,`subject`,`message`,`folder`,`status`) values ("' . $from . '","' . $to . '","' . mysql_real_escape_string($subject) . '","' . mysql_real_escape_string($message) . '","' . $this->get_sent_id($from) . '","1")';
        $this->db->query($sql);
        $this->db->query($sql2);
        $headers = 'From: ' . $this->config[site][name] . ' <' . $this->config[site][noreply] . '>' . "\r\n" .
                'X-Mailer: OkinawaSwap' . "\r\n" .
                'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                'To: ' . $user->get_username($to) . ' <' . $user->get_email_address($to) . '>' . "\r\n";
        $message = 'You have received the following message from ' . ucwords($user->get_username($from)) . ' on ' . $this->config[site][name] . ':<br><br>' . $message . '<br>';
        mail("", '[' . $this->config[site][name] . '] ' . $subject, $message, $headers, '-f' . $this->config[site][noreply]);
        $this->logger->logit("[message] $from to $to: $subject");
    }

    function remove($mid) {
        
    }

    function write() {
        
    }

    function move($mid, $from_folder, $to_folder) {
        $sql = 'update ' . $this->config[database][prefix] . 'messages set `folder`=' . mysql_real_escape_string($to_folder) . ' where id = ' . $mid;
        $this->db->query($sql);
        if (mysql_affected_rows() > 0) {
            $this->logger->logit("[message] $_SESSION[id] moved message $mid from $from_folder to $to_folder");
            echo '<h3>Your message has been moved from ' . ucwords($this->get_folder_name($from_folder)) . ' to ' . ucwords($this->get_folder_name($to_folder)) . '</h3>';
            echo '<h3>Return to your <a href="?p=desktop">desktop</a> or wait 3 seconds</h3>';
            echo '<meta http-equiv="refresh" content="3;url='.$this->config[site][url].'/?p=desktop" />';
        } else {
            echo '<h3>There was an error moving your message.  Please Try again.</h3>';
            echo '<h3>Return to your <a href="?p=desktop">desktop</a> or wait 3 seconds</h3>';
            echo '<meta http-equiv="refresh" content="3;url='.$this->config[site][url].'/?p=desktop" />';
        }
    }

    function empty_trash() {
        
    }

    function get_folders($id) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'folders where user_id =' . $id;
        $folders = $this->db->get_array($sql);
        return $folders;
    }

    function count_messages($fid) {
        $sql = 'select count(id) as count from ' . $this->config[database][prefix] . 'messages where folder=' . $fid;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->count;
        }
    }

    function count_unread_messages($fid) {
        $sql = 'select count(id) as count from ' . $this->config[database][prefix] . 'messages where status=0 and folder=' . $fid;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->count;
        }
    }

    function get_messages($folder) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'messages where folder=' . $folder . ' order by id DESC';
        $array = $this->db->get_array($sql);
        return $array;
    }

    function create_folders($id) {
        $sql1 = 'insert into ' . $this->config[database][prefix] . 'folders (user_id,folder_name) values (' . $id . ',"Inbox")';
        $sql2 = 'insert into ' . $this->config[database][prefix] . 'folders (user_id,folder_name) values (' . $id . ',"Sent")';
        $sql3 = 'insert into ' . $this->config[database][prefix] . 'folders (user_id,folder_name) values (' . $id . ',"Trash")';
        $this->db->query($sql1);
        $this->db->query($sql2);
        $this->db->query($sql3);
        $this->logger->logit("[signup] Folders created for user $id");
    }

    function create_welcome_message($uid) {
        $from = 1;
        $to = $uid;
        $subject = 'Welcome to ' . $this->config[site][name] . '!';
        $message = 'Now that you have confirmed your account, you might be thinking, "What do I do now?".
	   	  Well, for starters, how about browsing the items on the site and see if there is anything you like?<br>
	   	  You could also start going around your house, digging in closets and rooting through the garage for
	   	  things you\'d like to get rid of.<br>
		  Then, take a picture of that item, type up a description, and add it
	   	  to your list of "Things I Have" on your <a href="?p=desktop">Desktop</a>.<br>
		  <br>
	   	  All in all, we hope you enjoy your experience, and <a href="?p=contact">drop us a message</a> if you have
	   	  any questions.  You might also try visiting the <a href="?p=faq">Frequently Asked Questions</a> page to
	   	  find what you are looking for.<br>
		  <br>
	   	  Enjoy,<br>
		  <br>
	   	  The ' . $this->config[site][name] . ' Team';

        $this->send($from, $to, $subject, $message);
        $this->logger->logit("[signup] Welcome message sent to $uid");
    }

    function get_inbox_id($uid) {
        $sql = 'select id from ' . $this->config[database][prefix] . 'folders where user_id=' . $uid . ' and folder_name="Inbox"';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->id;
        }
    }

    function get_trash_id($uid) {
        $sql = 'select id from ' . $this->config[database][prefix] . 'folders where user_id=' . $uid . ' and folder_name="Trash"';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->id;
        }
    }

    function get_sent_id($uid) {
        $sql = 'select id from ' . $this->config[database][prefix] . 'folders where user_id=' . $uid . ' and folder_name="Sent"';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->id;
        }
    }

    function get_message($mid) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'messages where id=' . $mid;
        $message = $this->db->get_array($sql);
        return $message[0];
    }

    function mark_read($mid) {
        $sql = 'update ' . $this->config[database][prefix] . 'messages set status=1 where id=' . $mid . ' limit 1';
        $this->db->query($sql);
    }

    function check_folder_permissions($user, $folder) {
        $sql = 'select user_id from ' . $this->config[database][prefix] . 'folders where id=' . $folder;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            if ($row->user_id == $user) {
                return TRUE;
            } else {
                $this->logger->logit("[security] $user attempted to access $folder which is not theirs");
                return FALSE;
            }
        }
    }

    function check_message_permissions($user, $message) {
        $sql = 'select `to`, `from`, `folder` from ' . $this->config[database][prefix] . 'messages where id=' . $message;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            $my_folder = $this->check_folder_permissions($user, $row->folder);
            $is_sent = $this->get_sent_id($user);
            $is_trash = $this->get_trash_id($user);
            //echo "<br>My Folder: $my_folder, Is Sent: $is_sent, Is Trash: $is_trash<br>";
            if ($is_sent == $row->folder) {
                if ($my_folder == TRUE)
                    return TRUE;
            }
            if ($is_trash == $row->folder) {
                if ($my_folder == TRUE)
                    return TRUE;
            }
            if ($user == $row->to) {
                if ($my_folder == TRUE)
                    return TRUE;
            } else {
                $this->logger->logit("[security] $user attempted to access $message which is not theirs");
                return FALSE;
            }
        }
    }

    function get_folder_name($fid) {
        $sql = 'select folder_name from ' . $this->config[database][prefix] . 'folders where id = ' . $fid;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->folder_name;
        }
    }

}
