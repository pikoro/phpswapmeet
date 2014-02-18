<?php
    if(!$_SESSION[access] == 100){
        header('Location: '.$config[site][url].'/');
    } else {
        echo '<h1>'.$config[site][name].' Control Panel</h1>';
    }
    include_once('classes/admin.php');
    include_once('classes/listings.php');
    $listings = new listings();
    $admin = new admin();
    $news = new news();
	switch($_GET[q]){
		case 'manage_users':
			$user_list = $admin->list_users();
			manage_users($user_list);
			break;
		case 'edit_user':
			$user = $admin->get_user_info($_GET[id]);
			edit_user($user);
			break;
		case 'update_user':
			$admin->update_user($_POST);
			break;
        case 'manage_categories':
            $cat_list = $admin->list_categories();
            manage_categories($cat_list);
            break;
        case 'delete_category':
        	$admin->delete_category($_GET[id]);
        	$cat_list = $admin->list_categories();
        	echo '<h3>Category Deleted</h3>';
        	manage_categories($cat_list);
        	break;
        case 'add_category':
        	$admin->add_category();
        	$cat_list = $admin->list_categories();
        	echo '<h3>Category Added</h3>';
        	manage_categories($cat_list);
        	break;
        case 'add_news':
            $admin->add_news($_POST);
            echo '<h3>News Added</h3>';
            break;
        case 'manage_news':
            $news_list = $news->get_all_articles();
            manage_news($news_list);
            break;
        case 'new_news':
            add_news();
            break;
		default:
			show_menu();
			break;
	}

    function show_menu(){
		echo '<h2>Admin Menu</h2>
				<ul>User Functions
	    			<li><a href="?p=admin&q=manage_users">Manage Users</a></li>
				</ul>
                <ul>Site Functions
                    <li><a href="?p=admin&q=manage_categories">Manage Categories</a></li>
                    <li><a href="?p=admin&q=manage_news">Manage News Articles</a></li>
                </ul>
                ';
	}

	function manage_users($array){
		echo '<h2><a href="?p=admin">Admin Menu</a> > Manage Users</h2>';
		echo '<table class="userlist">
				<tr>
					<th>id</th>
					<th>username</th>
					<th>email</th>
                    <th>paypal_email</th>
					<th>dob</th>
					<th>access</th>
					<th>active</th>
					<th>action</th>
				</tr>';
		foreach($array as $user){
			if($user[active]== 1){$active = 'Yes';}else{$active = 'No';}
			echo '<tr>';
			echo '<td>'.$user[id].'</td>';
			echo '<td>'.$user[username].'</td>';
			echo '<td><a href="mailto:'.$user[email1].'">'.$user[email1].'</a></td>';
            echo '<td>'.$user[paypal_email].'</td>';
			echo '<td>'.$user[dob].'</td>';
			echo '<td>'.$user[access_level].'</td>';
			echo '<td>'.$active.'</td>';
			echo '<td><a href="?p=admin&q=edit_user&id='.$user[id].'">Edit</a> | <a href="?p=admin&q=delete_user&id='.$user[id].'">Delete</a> | <a href="?p=admin&q=suspend_user&id='.$user[id].'">Suspend</a></td>';
			echo '<tr>';
		}
		echo '</table>';


	}

	function edit_user($user){
		echo '<h2><a href="?p=admin">Admin Menu</a> > <a href="?p=admin&q=list_users">List Users</a> > Edit User</h2>';
		//print_r($user);
		if($user[active] == 1){ $checked = 'checked';}
		echo '<form name="edit_user" id="edit_user" method="POST" action="?p=admin&q=update_user">
				<table>
					<tr><th>ID:</th><td>'.$user[id].'</td></tr>
					<input type="hidden" id="id" name="id" value="'.$user[id].'"/>
					<tr><th>Username:</th><td><input type="text" name="username" value="'.$user[username].'" /></td></tr>
					<tr><th>Password:</th><td><input type="text" name="password" value="'.$user[password].'" /></td></tr>
					<tr><th>Primary Email:</th><td><input type="text" name="email1" value="'.$user[email1].'" /></td></tr>
					<tr><th>Paypal Email:</th><td><input type="text" name="paypal_email" value="'.$user[paypal_email].'" /></td></tr>
					<tr><th>Date of Birth:</th><td><input type="text" name="dob" value="'.$user[dob].'" /></td></tr>
					<tr><th>Access Level:</th><td><input type="text" name="access_level" value="'.$user[access_level].'" /></td></tr>
					<tr><th>Active?:</th><td><input type="checkbox" name="active" '.$checked.' /></td></tr>
					<tr><th>Confirm Key:</th><td><input type="text" name="confirm_key" value="'.$user[confirm_key].'" /></td></tr>
					<tr><th>Registration Date:</th><td><input type="text" name="registered" value="'.$user[registered].'" /></td></tr>
					<tr><th><input type="submit" value="Update" /></th><td>&nbsp;</td></tr>
				</table>
		</form>';

	}

    function manage_categories($array){
        echo '<h2><a href="?p=admin">Admin Menu</a> > Manage Categories</h2>';
        echo '<div><a href="?p=admin&q=add_category">Add Category</a></div>';
        echo '<table class="userlist">
                <tr>
                    <th>id</th>
                    <th>parent</th>
                    <th>category</th>
                    <th>status</th>
                    <th>action</th>
                </tr>';
        foreach($array as $category){
            if($category[status]== 1){$status = 'Yes';}else{$status = 'No';}
            echo '<tr>';
            echo '<td>'.$category[id].'</td>';
            echo '<td>'.$category[parent].'</td>';
            echo '<td>'.$category[category].'</td>';
            echo '<td>'.$status.'</td>';
            echo '<td><a href="?p=admin&q=edit_category&id='.$category[id].'">Edit</a> | <a href="?p=admin&q=delete_category&id='.$category[id].'">Delete</a> | <a href="?p=admin&q=suspend_category&id='.$category[id].'">Suspend</a></td>';
            echo '<tr>';
        }
        echo '</table>';

    }

    function add_category(){
        echo '<h2><a href="?p=admin">Admin Menu</a> > <a href="?p=admin&q=list_categories">Manage Categories</a> > Add Category</h2>';
		//print_r($user);
		if($category[active] == 1){ $checked = 'checked';}
		echo '<form name="add_category" id="add_category" method="POST" action="?p=admin&q=add_category">
				<table>
					<tr><th>Parent</th><td>'.$listings->parent_dropdown().'</td></tr>
					<tr><th>Category Name</th><td><input type="text" id="name" name="name" /></td></tr>
					<tr><th>Active</th><td><input type="checkbox" name="status" id="status" /></td></tr>
					<tr><th><input type="submit" value="Update" /></th><td>&nbsp;</td></tr>
				</table>
		</form>';

    }
    
    function manage_news($array){
        echo '<h2><a href="?p=admin">Admin Menu</a> > Manage News</h2>';
        echo '<a href="?p=admin&q=new_news">Add News</a>';
        if(count($array)>0){
            echo '<table class="userlist"><tr><th>ID</th><th>Title</th><th>Date</th><th>Action</th></tr>';
            foreach($array as $article){
                echo '<tr><td>'.$article[id].'</td><td>'.$article[title].'</td><td>'.$article[post_date].'</td><td>Edit | Delete</td></tr>';
            }
            echo '</table>';
        } else {
            echo '<h3>There are no news articles</h3>';
        }
    }
    
    function add_news(){
         echo '<h2><a href="?p=admin">Admin Menu</a> > <a href="?p=admin&q=manage_news">Manage News</a> > Add News</h2>';
         echo '<form id="news" name="news" method="post" action="?p=admin&q=add_news">
                <table class="userlist">
                    <tr><th>Title</th><td><input type="text" name="title" /></td></tr>
                    <tr><th>Article</th><td><textarea name="article" id="article" rows="10" cols="30"></textarea></td></tr>
                    <tr><td><input type="submit" value="Add News" /></td><td>&nbsp;</td></tr>
                </table>
                </form>';
                
    }


?>