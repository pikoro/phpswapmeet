<?php

if ($_POST[id]) {
    $users->update_profile();
    echo '<h2>Profile Updated</h2>';
    echo '<b>Click <a href="?p=desktop">here</a> to go to your desktop or wait 3 seconds.</b>';
    echo '<meta http-equiv="refresh" content="3;url=' . $config[site][url] . '/?p=desktop" />';
} else {

    $user = $users->get_user_info($_SESSION[id]);
    echo '<h2>Update your Profile</h2>';
    if ($user[active] == 1) {
        $checked = 'checked';
    }
    echo '<form name="edit_user" id="edit_user" method="POST" action="?p=edit_profile&q=update_user">
				<table>
					<tr><th>ID:</th><td>' . $user[id] . '</td></tr>
					<input type="hidden" id="id" name="id" value="' . $user[id] . '"/>
					<tr><th>Username:</th><td>' . $user[username] . '</td></tr>
					<tr><th>Primary Email:</th><td width="250"><input type="text" name="email1" width="100%" value="' . $user[email1] . '" /></td></tr>
					<tr><th>Paypal Email:</th><td width="250"><input type="text" name="paypal_email" width="100%" value="' . $user[paypal_email] . '" /></td></tr>
					<tr><th>Date of Birth:</th><td><input type="text" name="dob" value="' . $user[dob] . '" /></td></tr>
					<tr><th>Registration Date:</th><td>' . $user[registered] . '</td></tr>
					<tr><th><input type="submit" value="Update" /></th><td>&nbsp;</td></tr>
				</table>
		</form>';
}
?>