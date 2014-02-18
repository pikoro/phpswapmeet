<?php

class user {

    function user() {
        require('includes/config.php');
        include_once('includes/functions.php');
        include_once('database.php');
        $this->db = new database();
        $this->functions = new functions($config);
        $this->config = $config;
    }

    function login($username, $password) {
        $sql = 'select id, username, password, access_level, active from ' . $this->config[database][prefix] . 'users where username="' . $username . '"';
        //echo $sql;
        $user = $this->db->get_array($sql);
        //print_r($user);
        if ($user[0][password] == sha1(filter_input(INPUT_POST, 'password'))) {
            $_SESSION[loggedin] = 1;
            $_SESSION[access] = $user[0][access_level];
            $_SESSION[username] = $user[0][username];
            $_SESSION[id] = $user[0][id];
            $_SESSION[active] = $user[0][active];
            echo '<b>You are now logged in. Click <a href="?p=desktop">here</a> to go to your desktop or wait 3 seconds.</b>';
            echo '<meta http-equiv="refresh" content="3;url=' . $this->config[site][url] . '/?p=desktop" />';
        } else {
            echo '<b>Username or Password do not match the values in our database</b>';
        }
        //print_r($_SESSION);
    }

    function add() {
        
    }

    function delete($id) {
        $sql = 'delete from ' . $this->config[database][prefix] . 'users where id = ' . $id;
        $res = mysql_query($sql);
    }

    function activate($cust_id) {
        
    }

    function disable($cust_id) {
        
    }

    function update_profile() {
        $username = ereg_replace('[^a-zA-Z0-9]', '', filter_input(INPUT_POST, 'username'));
        $password = ereg_replace('[^a-zA-Z0-9]', '', filter_input(INPUT_POST, 'password'));
        $password2 = ereg_replace('[^a-zA-Z0-9]', '', filter_input(INPUT_POST, 'password2'));
        $dob = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
        $email1 = ereg_replace('[^a-zA-Z0-9\@\.\_]', '', filter_input(INPUT_POST, 'email1', FILTER_SANITIZE_EMAIL));
        $paypal_email = ereg_replace('[^a-zA-Z0-9\@\.\_]', '', filter_input(INPUT_POST, 'paypal_email', FILTER_SANITIZE_EMAIL));
        $sql = 'update ' . $this->config[database][prefix] . 'users set `email1` = "' . $email1 . '", `paypal_email` = "' . $paypal_email . '" where `id` = ' . $_SESSION[id];
        mysql_query($sql);
    }

    function register() {
        $username = ereg_replace('[^a-zA-Z0-9]', '', filter_input(INPUT_POST, 'username'));
        $password = ereg_replace('[^a-zA-Z0-9]', '', filter_input(INPUT_POST, 'password'));
        $password2 = ereg_replace('[^a-zA-Z0-9]', '', filter_input(INPUT_POST, 'password2'));
        $dob = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
        $res = mysql_query('select * from ' . $this->config[database][prefix] . 'users where username="' . $username . '"');
        if (mysql_num_rows($res) > 0) {
            $error[] = 'That username is already in use';
        }
        mysql_free_result($res);
        if ($password != $password2) {
            $error[] = 'Passwords do not match';
        }

        $email1 = ereg_replace('[^a-zA-Z0-9\@\.\_]', '', filter_input(INPUT_POST, 'email1', FILTER_SANITIZE_EMAIL));
        $paypal_email = ereg_replace('[^a-zA-Z0-9\@\.\_]', '', filter_input(INPUT_POST, 'paypal_email', FILTER_SANITIZE_EMAIL));
        $sql = 'select * from ' . $this->config[database][prefix] . 'users where email1 = "' . $email1 . '"';
        $res = $this->db->get_res($sql);
        if (mysql_num_rows($res) > 0) {
            $error[] = 'That email address has already been registered.';
        }
        $phone = ereg_replace('[^0-9\-]', '', filter_input(INPUT_POST, 'phone'));
        $confirm_key = $this->createConfirmKey(13);

        $sql = 'insert into ' . $this->config[database][prefix] . 'users (username,password,email1,paypal_email,dob,access_level,active,confirm_key,registered) values ("' . mysql_real_escape_string($username) . '","' . sha1($password) . '","' . mysql_real_escape_string($email) . '","' . mysql_real_escape_string($paypal_email) . '","' . $dob . '","0","0","' . $confirm_key . '","' . date("Y-m-d h:i:s") . '")';
        // echo $sql;
        if (count($error) > 0) {
            echo '<h3>The following error(s) have occured:</h3>';
            foreach ($error as $errors) {
                echo '<h3 style="color:red;">' . $errors . '</h3>';
            }
            echo '<h3>Please go <a href="javascript:history.back(1)">back</a></h3>';
            return $error;
        } else {
            $this->db->query($sql);
            $this->send_confirm_mail($email, $username, $password, $confirm_key);
            $array[] = array('success', $email, $username, $password, $confirm_key);
            return $array;
        }
    }

    function send_confirm_mail($email, $username, $password, $confirm_key) {
        $to = $email;
        $subject = '[' . $this->config[site][name] . '] Confirm your email address';
        $message = 'Thank you for registering at ' . $this->config[site][name] . '<br><br>
	   Your username and password are as follows:<br><br>
	   Username: ' . $username . '<br>
	   Password: ' . $password . '<br><br>
	   Click the following link to activate your account:<br>
	   <a href="' . $this->config[site][url] . '/?p=confirm&confirm=yes&email=' . $email . '&code=' . $confirm_key . '">' . $this->config[site][url] . '/?p=confirm&confirm=yes&email=' . $email . '&code=' . $confirm_key . '</a><br>
	   or<br>
	   Please copy and paste the following confirmation code into the registration form in your browser to confirm your email address:<br><br>
	   Confirmation Code: ' . $confirm_key . '<br><br>
	   Thank You<br>
	   ' . $this->config[site][name] . '<br>
	   ' . $this->config[site][tagline];

        $headers = 'From: ' . $this->config[site][noreply] . "\r\n" .
                'X-Mailer: ' . $this->config[site][short_name] . "\r\n" .
                'Content-Type: text/html; charset=UTF-8' . "\r\n";
        // echo $message;
        mail($to, $subject, $message, $headers, '-f' . $this->config[site][noreply]);
    }

    function createConfirmKey($length) {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double) microtime() * 1000000);
        $i = 0;
        $code = '';
        while ($i <= $length) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $code = $code . $tmp;
            $i++;
        }
        return strtoupper($code);
    }

    function get_username($id) {
        $sql = 'select username from ' . $this->config[database][prefix] . 'users where id = ' . $id;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->username;
        }
    }

    function get_paypal_address($id) {
        $sql = 'select paypal_email from ' . $this->config[database][prefix] . 'users where id=' . $id;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->paypal_email;
        }
    }

    function get_email_address($id) {
        $sql = 'select email1 from ' . $this->config[database][prefix] . 'users where id=' . $id;
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->email1;
        }
    }

    function total_users() {
        $sql = 'select count(id) as count from ' . $this->config[database][prefix] . 'users where active = 1';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_object($res)) {
            return $row->count;
        }
    }

    function reset_password($email) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'users where `email1` ="' . mysql_real_escape_string($email) . '"';
        $res = $this->db->get_res($sql);
        if (mysql_num_rows($res) == 0) {
            $errors[] = 'That email address is not registered in our records';
        } else {
            while ($row = mysql_fetch_object($res)) {
                $id = $row->id;
            }
            $new_pass = $this->createConfirmKey(8);
            $sql2 = 'update ' . $this->config[database][prefix] . 'users set `password`="' . sha1($new_pass) . '" where `id`=' . $id;
            $this->db->query($sql2);
            $this->send_new_password($id, $email, $new_pass);
        }
        return $errors;
    }

    function send_new_password($id, $email, $new_pass) {
        $to = $email;
        $subject = '[' . $this->config[site][name] . '] Your Password has been Reset';
        $message = '<br>
========================================================================<br>
============== THIS IS AN AUTOMATED MESSAGE, DO NOT REPLY ==============<br>
========================================================================<br><br>

    	   You have requested to reset your password for ' . $this->config[site][name] . '<br><br>

	   Your new password follows:<br><br>
	   Password: ' . $new_pass . '<br><br>

	   Thank You<br>
	   ' . $this->config[site][name] . '<br>
	   ' . $this->config[site][tagline];

        $headers = 'From: ' . $this->config[site][noreply] . "\r\n" .
                'X-Mailer: ' . $this->config[site][short_name] . "\r\n" .
                'Content-Type: text/html; charset=UTF-8' . "\r\n";
        // echo $message;
        mail($to, $subject, $message, $headers, '-f' . $this->config[site][noreply]);
    }

    function get_user_info($id) {
        $sql = 'select * from ' . $this->config[database][prefix] . 'users where id = ' . $id;
        $res = mysql_query($sql);
        $array = mysql_fetch_assoc($res);
        return $array;
    }

    function get_user_id($username) {
        $sql = 'select id from ' . $this->config[database][prefix] . 'users where username = "' . $username . '"';
        $res = mysql_query($sql);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_object($res)) {
                return $row->id;
            }
        } else {
            return NULL;
        }
    }

    function get_userlist() {
        $sql = 'select * from ' . $this->config[database][prefix] . 'users where active=1';
        $res = $this->db->get_res($sql);
        while ($row = mysql_fetch_assoc($res)) {
            $array[] = $row;
        }
        return $array;
    }

}
