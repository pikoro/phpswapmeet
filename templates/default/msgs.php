<?
include_once('classes/messages.php');
include_once('classes/users.php');
$messages = new messages();
$users = new user();

if($_POST){
    if($_POST[reply]){
    	   $messages->send($_POST[from],$_POST[to],$_POST[subject],$_POST[message]);
    	   echo '<h3>Your message has been sent!</h3>';
           echo '<h3>Return to your <a href="?p=desktop">desktop</a> or wait 3 seconds</h3>';
		   echo '<meta http-equiv="refresh" content="3;url=http://www.okinawaswap.com/?p=desktop" />';
    }
} else {

    switch($_GET[q]){
    	   case 'reply':
    	   	  reply($_GET[mid]);
    	   	  break;


    }
    if(!$_GET[q]){
        if(!$_GET[fid]){
            echo '<h3>Error.  You have not selected a valid folder</h3>';
           echo '<h3>Return to your <a href="?p=desktop">desktop</a> or wait 3 seconds</h3>';
		   echo '<meta http-equiv="refresh" content="3;url=http://www.okinawaswap.com/?p=desktop" />';
        } else {
            $fid = $_GET[fid];
            if(!$_GET[mid]){

                if($messages->check_folder_permissions($_SESSION[id],$fid) == TRUE){
	                $msgs = $messages->get_messages($_GET[fid]);
	                echo '<h2><a href="?p=desktop">Desktop</a> > '.$messages->get_folder_name($fid).'</h2>';
	                echo '<ul>';
                    echo '<table class="userlist">
	                	<tr><th>From</th><th>To</th><th>Date</th><th>Subject</th></tr>';

	                for($i=0;$i<count($msgs);$i++){
	                	echo '<tr><td>'.ucwords($users->get_username($msgs[$i][from])).'</td>
                                  <td>'.ucwords($users->get_username($msgs[$i][to])).'</td>
                                  <td>'.$msgs[$i][date].'</td>
                                  <td><a';
                             if($msgs[$i][status] == 1) echo ' style="font-weight:normal; color:grey;" ';
                             echo ' href="?p=msgs&fid='.$fid.'&mid='.$msgs[$i][id].'">'.$msgs[$i][subject].'</a></td>
                             </tr>';
/*	                	   echo '<li><a ';
    		               if($msgs[$i][status] == 1) echo 'style="font-weight:normal; color:grey;" ';
    		               echo 'href="?p=msgs&fid='.$fid.'&mid='.$msgs[$i][id].'">'.$msgs[$i][subject].'</a></li>'; */
		            }
		            echo '</table>';
                } else {
		            echo '<h3>You do not have permission to access this folder</h3>';
                    echo '<h3>Return to your <a href="?p=desktop">desktop</a> or wait 3 seconds</h3>';
		   			echo '<meta http-equiv="refresh" content="3;url=http://www.okinawaswap.com/?p=desktop" />';
                }
                echo '</ul>';
            }
            if($_GET[mid]){
		        $mid = $_GET[mid];
		        if($messages->check_message_permissions($_SESSION[id],$mid)== TRUE){

			        $message = $messages->get_message($mid);
			        echo '<h3><a href="?p=desktop">Desktop</a> > <a href="?p=msgs&fid='.$fid.'">'.$messages->get_folder_name($fid).'</a> > '.$message[subject].'</h3>';
			        $messages->mark_read($mid);
			        //print_r($message);
			        echo '<h2>'.$message[subject].'</h2>';
			        echo 'From: '.ucwords($users->get_username($message[from])).'<br>';
			        echo 'To: '.ucwords($users->get_username($message[to])).'<br>';
			        echo 'Subject: '.$message[subject].'<br>';
			        echo 'Sent: '.$message[date].'<br>';
			        echo '<hr color="#99CC00"><p>'.$message[message].'</p><br>';
			        echo '<div class="sidebarlt"><a href="?p=msgs&fid='.$fid.'&mid='.$message[id].'&q=trash">Move to Trash</a>';
				   if($message[from]!=$_SESSION[id]){
			         	   echo ' | <a href="?p=msgs&fid='.$fid.'&mid='.$message[id].'&q=reply">Reply</a></div>';
				   }
		        } else {
			        echo '<h3>You do not have permission to access this message</h3>';
                    echo '<h3>Return to your <a href="?p=desktop">desktop</a> or wait 3 seconds</h3>';
		   			echo '<meta http-equiv="refresh" content="3;url=http://www.okinawaswap.com/?p=desktop" />';
		        }
            }
        }
    } else {
    	   if($_GET[q]=='trash'){
    	   	  if($_GET[a]=='yes'){
		  		 //echo '<h4>Moved to Trash</h4>';
		  		 $messages = new messages();
		  		 $messages->move($_GET[mid],$_GET[fid],$messages->get_trash_id($_SESSION[id]));
		  		 echo '<h4>Click <a href="?p=desktop">here</a> to return to your desktop</h4>';
    	   	  } else {
	   		      echo '<h3>Are you sure that you want to move this message to the trash?</h3>';
	   		      echo '<a href="?p=msgs&fid='.$_GET[fid].'&mid='.$_GET[mid].'&q=trash&a=yes">Yes | <a href="?p=desktop">Cancel</a>';
		  	  }
    	   }
    }
}

function reply($mid){
    $messages = new messages();
    $users = new user();
    $fid = $_GET[fid];
    $message = $messages->get_message($mid);
    //print_r($message);
    if($message[from] == $_SESSION[id]){
        echo '<h3>You cannot send a message to yourself</h3>';
        echo '<h3>Return to your <a href="?p=desktop">desktop</a> or wait 3 seconds</h3>';
        echo '<meta http-equiv="refresh" content="3;url=http://www.okinawaswap.com/?p=desktop" />';   
    } else {
        echo '<h3><a href="?p=desktop">Desktop</a> > <a href="?p=msgs&fid='.$fid.'"> '.$messages->get_folder_name($fid).'</a> > <a href="?p=msgs&fid='.$fid.'&mid='.$mid.'">'.$message[subject].'</a> > Reply</h3>';
        echo '<form id="reply" name="reply" action="?p=msgs" method="post">';
        echo 'From: '.ucwords($users->get_username($_SESSION[id])).'<br>';
        echo '<input type="hidden" name="from" value="'.$_SESSION[id].'" />';
        echo 'To: '.ucwords($users->get_username($message[from])).'<br>';
        echo '<input type="hidden" name="to" value="'.$message[from].'" />';
        if(substr_count($message[subject],'RE:')>0){
            echo 'Subject: '.$message[subject].'</br>';
        } else {
            echo 'Subject: RE: '.$message[subject].'</br>';
        }
        echo '<input type="hidden" name="subject" value="RE: '.$message[subject].'" />';
        $oFCKeditor = new FCKeditor('message') ;
        $oFCKeditor->BasePath = '/fckeditor/' ;
        $oFCKeditor->ToolbarSet = 'Basic';
        $oFCKeditor->Value= '<br><i>On '.$message[date].' '.ucwords($users->get_username($message[from])).' sent:</i><br><p>"'.$message[message].'"</p>';
        $oFCKeditor->Create() ;
        echo '<input type="submit" name="reply" value="Reply" />';
        echo '</form>';
    }


}

?>