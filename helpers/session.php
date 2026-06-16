<?php
//check if called directly
if(!defined('MyConst')) {
    die('');
  }

  //check for inactivity - log out after 30 minutes
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    header("Location: ./logout.php", true);  //redirect to logout page
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp


//Check if authorized for page

if ($page_access != 0) {
  	if (!isset($_SESSION['user_access']) OR $_SESSION['user_access'] < $page_access) {
		//echo "Got this far";
		header("Location: ./", true); 
		exit;
	}
}
  
	require_once('config.php');
    //$config = include('config.php'); 
	$_SESSION['online_status'] = $config['online'];
	$_SESSION['offline_message'] = $config['offline_msg'];

	//Check if logged in, Check if site offline if not logged in
	if (!isset($_SESSION['userid'])) {		
		$online = $config['online'];
		$offline_msg = $config['offline_msg'];
	} else {
		$online = 'logged in';	
	}

  ?>