<?php
if(!defined('MyConst')) {
    die('');
 }
 		$userid = $_SESSION['userid'];
		$_SESSION = array();

		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}	

		session_destroy();
		echo "<h2>You have been logged out!</h2>";
		 //write log entry
		 $log_type = "User Maintenance";
		 $log_desc = "User Log Out: " . $userid;
		 $user_log = $userid;
		 
		 include 'helpers/log_entry.php';
		 mysqli_close($conn);
 ?>
 
 	<a href="./"><div class="button">Continue</div></a>