<?
//print_r($_POST);
    if(!$_POST['continue']){

?>
<h3>Register</h3>
<form id="register" name="register" action="?p=admin.register" method="POST">
<table>
	<tr><th colspan="2">Please enter the following information to register for your <?=$config[site][name]?> account</th></tr>
	<tr><th colspan="2">You must be at least 18 years old to register</th></tr>
    <tr><th>Username</th><td><input type="text" name="username" id="username" /><span id="required">&nbsp;*</span></td></tr>
    <tr><th>Password</th><td><input type="password" name="password" id="password" /><span id="required">&nbsp;*</span></td></tr>
    <tr><th>Confirm Password</th><td><input type="password" name="password2" id="password2" /><span id="required">&nbsp;*</span></td></tr>
    <tr><th>Email Address</th><td><input type="text" name="email" id="email" /><span id="required">&nbsp;*</span></td></tr>
    <tr><th>Paypal Email</th><td><input type="text" name="paypal_email" id="paypal_email" />If you want to accecpt instant payments</td></tr>
    <tr><th>Date of Birth</th><td>
    <select name="month" id="month">
        <option value="01">January</option>
        <option value="02">Febuary</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
	   <option value="12">December</option>
    </select>
    <select name="day" id="day">
    	   <? for($i=1;$i<32;$i++) echo '<option value="'.$i.'">'.$i.'</option>'; ?>
    </select>
    <select name="year" id="year">
    	   <?
    	   	  $start_year = mktime(0,0,0,0,0,date("Y")-17);
    	   	  for($i=date("Y",$start_year);$i>1900;$i--) echo '<option value="'.$i.'">'.$i.'</option>';
    	   ?>
    </select><span id="required">&nbsp;*</span>

</td></tr>
    <tr><th>&nbsp;</th><td><input type="submit" name="continue" id="continue" value="Continue" /></td></tr>
</table>
</form>
<div id="required">&nbsp;* Required</div>
<?
    } else {

    	   include_once('classes/users.php');
    	   $user = new user();

    	   $array = $user->register();
    	   //print_r($array);
    	   if($array[0][0] == 'success'){
?>
	   <h3>Thank you for registering</h3>
	   Please check your email and paste the confirmation code from the email into the form below:<br>
	   <form id="confirm" name="confirm" action="?p=confirm" method="POST">
	   <table>
	   	  <tr><th>Email Address</th><td><input type="text" name="email" id="email" value="<?= $_POST[email] ?>" /></td></tr>
	   	  <tr><th>Confirmation Code</th><td><input type="text" name="code" id="code" /></td></tr>
            <tr><th>&nbsp;</th><td><input type="submit" name="confirm" id="confirm" value="Confirm" /></td></tr>
	   </table>
	   </form>
<?
    	   }
    }
?>

