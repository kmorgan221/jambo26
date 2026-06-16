<?php
if(!defined('MyConst') AND !isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    die('unauthorized');
 }
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jambo26";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

 ?>