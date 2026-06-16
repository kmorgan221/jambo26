<?php 
	session_start();
    //set required access level for page - leave commented if available for all
	//1 - Users; 2 - admins; 3 - super users
    $page_access = 0;
    define('MyConst', TRUE);
    require_once("helpers/session.php");    
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
    <title>ELEVATE Your Access - Staff Check In</title>
</head>
<body>
	<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
        $subtitle = "Jamboree Staff Check-In";
        include "helpers/header.inc.php"; 
        ?>

    
	<main>
        <?php if ($online == 0) {
         include "helpers/offline.php";
    } else {
            include "helpers/inc.jstcheckin.php";
    } ?>
        
	</main>
    <footer>
        <?php include "helpers/footer.inc.php"; ?>
    </footer>

</body>
</html>