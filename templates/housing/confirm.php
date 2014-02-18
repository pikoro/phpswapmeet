<?php

if(!$_POST && !$_GET[confirm]){
    echo '<h3>Thank you for registering</h3>
	   Please check your email and paste the confirmation code from the email into the form below:<br>
	   <form id="confirm" name="confirm" action="?p=confirm" method="POST">
	   <table>
	   	  <tr><th>Email Address</th><td><input type="text" name="email" id="email" /></td></tr>
	   	  <tr><th>Confirmation Code</th><td><input type="text" name="code" id="code" /></td></tr>
            <tr><th>&nbsp;</th><td><input type="submit" name="confirm" id="confirm" value="Confirm" /></td></tr>
	   </table>
	   </form>';
}


if($_POST[confirm]){
    include_once('includes/config.php');
    include_once('classes/database.php');
    include_once('classes/messages.php');
    $db = new database();
    $messages = new messages();

    $email = $_POST[email];
    $key = ereg_replace('[^a-zA-Z0-9]', '', $_POST['code']);

    $sql = 'select id,email1,confirm_key,active from `'.$config[database][prefix].'users` where `email1` = "'.$email.'"';
    //echo $sql;
    $array = $db->get_array($sql);
	//print_r($array);
	//print_r($_POST);
	//echo 'Key: '.$key;
    if($array[0][active]!=1){

        if($key == $array[0][confirm_key]){
    	       $sql2 = 'update '.$config[database][prefix].'users set active=1, access_level=10 where id="'.$array[0][id].'"';
    	       //echo $sql2;
    	       $db->query($sql2);
    	       $messages->create_folders($array[0][id]);
    	       $messages->create_welcome_message($array[0][id]);
	       echo '<h3>Thank you for confirming your email address.  You may now <a href="?p=login">Login</a>.</h3>';
        } else {
    	       echo '<h3>We\'re sorry, your confirmation code does not match.  Please copy and paste directly from the email you received to assure correctness</h3>';
        }
    } else {
    	   echo '<h3>You have already confirmed your account</h3>';
    }
} else {
    if($_GET[confirm]){
        include_once('includes/config.php');
        include_once('classes/database.php');
        include_once('classes/messages.php');
        $db = new database();
        $messages = new messages();
        $email = $_GET[email];

        $key = ereg_replace('[^a-zA-Z0-9]', '', $_GET['code']);

        $sql = 'select id,email1,confirm_key, active from `'.$config[database][prefix].'users` where `email1` = "'.$email.'"';
        //echo $sql;
        $array = $db->get_array($sql);
	    //print_r($array);
	    //print_r($_POST);
	    //echo 'Key: '.$key;
	   if($array[0][active]!=1){
            if($key == $array[0][confirm_key]){
    	           $sql2 = 'update '.$config[database][prefix].'users set active=1, access_level=10 where id="'.$array[0][id].'"';
    	           //echo $sql2;
    	           $db->query($sql2);
    	           $messages->create_folders($array[0][id]);
    	           $messages->create_welcome_message($array[0][id]);
	           echo '<h3>Thank you for confirming your email address.  You may now <a href="?p=login">Login</a>.</h3>';
        		 } else {
    	       	 	echo '<h3>We\'re sorry, your confirmation code does not match.  Please copy and paste directly from the email you received to assure correctness</h3>';
			 }
	   } else {
	   	  echo '<h3>You have already confirmed your account</h3>';
	   }
    }
}
  ?>
