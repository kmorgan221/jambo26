<?php
//check if called directly
if(!defined('MyConst')) {
    die('');
  }
	//check if $_SESSION['login_failed'] exists
	if (!isset($_SESSION['login_failed'])) {
	//	$_SESSION['login_failed'] == '';
	}


	//check if login form submitted
	
	if (!empty($_POST)) {
	
	//process login

	//Login user
	$user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
	$pwd = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

	//check if valid user and login
	if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }	
	
    $sql = "SELECT * FROM jambo26_users WHERE username = '".$user."'";
	
	$result = mysqli_query($conn, $sql);

	

	$row = mysqli_fetch_row($result);
	if (mysqli_num_rows($result) > 0 AND password_verify($pwd, $row['4'])) {
		
		$_SESSION['id'] = $row['0'];
		$_SESSION['Last_Name'] = $row['2'];
		$_SESSION['First_Name'] = $row['3'];
		$_SESSION['user_access'] = $row['5'];
		$_SESSION['userid'] = strtolower($user);
	
		$_SESSION['login_failed'] = 'false';
		
	echo "<p>Welcome, " . $_SESSION['First_Name'] . " " . $_SESSION['Last_Name'] . ". You are now logged in.</p>";

	 //write log entry
	 $log_type = "User Maintenance";
	 $log_desc = "User Logged In: " . $_SESSION['userid'];
	 $user_log = $_SESSION['userid'];
	 
	 include 'helpers/log_entry.php';
	 mysqli_close($conn);

	 ?>
	
	<a href="./"><div class="button">Continue</div></a>
	
	<?php
	} else {
		echo "<h3>Username or Password do not match!</h3><p>Please try again.</p>";
		$_SESSION['login_failed'] = 'true';
	
	}

	//end IF condition if form was posted
	} 
	

	//If form not sibmitted or login incorrect then show login form
		if (empty($_POST) OR $_SESSION['login_failed'] == 'true') {
//		if (empty($_POST)) {
			
			include 'helpers/login_form.php';
			
		//end if for login form
		}

	
		
	
	

?>