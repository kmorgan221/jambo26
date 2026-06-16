<?php 
	session_start();
    //set required access level for page - leave commented if available for all
	//1 - Users; 2 - admins; 3 - super users
    $page_access = 0;
    define('MyConst', TRUE);
    //require_once("helpers/session.php");    
    //load db credentials and connection string
    include 'helpers/dbh.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="helpers/styles.css">
    <?php
	//add Script filesize
	include 'helpers/scripts.php';
?>
    <title>Jambo Forward Fast - JST Check In</title>
</head>
<body>
	<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
        $subtitle = "Jamboree Service Team Check-In";
   //  include "helpers/header.inc.php"; 
        ?>

    
	<main>
        <?php  include "helpers/inc.jstcheckin.php";    ?>
	</main>


</body>
</html>