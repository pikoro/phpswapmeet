<?
    if($_POST[login]){
    	   //include_once('classes/users.php');
    	   //$user = new user();

    	   $username = ereg_replace('[^a-zA-Z0-9]', '', $_POST['username']);
    	   $password = $_POST[password];

    	   $users->login($username,$password);

    } elseif($_POST[forgot]){
    // Forgot Password

    	   $errors = $users->reset_password($_POST[email]);
    	   if(is_array($errors)){
    	   	  echo '<h3>There were problems resetting your password:</h3>';
	   	  foreach($errors as $error){
		  	 echo '<h3>'.$error.'</h3>';
	   	  }
    	   } else {
    	   	  echo '<h3>Your password has been emailed to the requested address.</h3>';
	   }
	} else {

?>
<h3>Please Login</h3>
<form name="login" method="post">
	<table><tr><th width="20">Username:</th><td><input type="text" name="username" id="username" /></td></tr>
	<tr><th width="20">Password:</th><td><input type="password" name="password" id="password" /></td></tr>
	<tr><th><input type="submit" name="login" value="Login"/></th><td><input type="reset" value="Clear"/></td></tr>
</form>
<script>
		document.body.onLoad = document.login.username.focus();
		</script>

<tr><th colspan="2"><h3>Forgot your password? Enter your email address and click "Continue".</h3></th></tr>
<form name="forgot" method="post">
	<tr><th width="20">Email:</th><td><input type="text" name="email" id="email"/></td></tr>
    <tr><th width="20"><input type="submit" name="forgot" value="Continue"/></th></tr>
	</table>
</form>


<?
    }
?>