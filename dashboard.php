<?php 
	session_start();
    
    //set required access level for page - leave commented if available for all
	//1 - Users; 2 - admins; 3 - super users
    $page_access = 1;

    define('MyConst', TRUE);
    require_once("helpers/session.php");    
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
	//add Script filesize
	include 'helpers/scripts.php';
	

	//load db credentials and connection string - Uncomment if needed
    //include 'helpers/dbh.php';
?>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="helpers/styles.css">
    <title>Registration Team Dashboard</title>
</head>
<body>
	<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
        $subtitle = "Registration Team Dashboard";
        include "helpers/header.inc.php"; 
        ?>

    
	<main>

    <?php

        if ($online == 0) {
           include "helpers/offline.php";
        } else {
    ?>

    <h1>Registration Team Dashboard</h1>
	<div>
        <?php if ($_SESSION['userid'] != "oparrow") { ?>
    <div class="admin">
		<h3>Staff Member Check In Options</h3>
		<a href="./jstready.php?chkstat=1"><div class="button">Staff Fast Pass Ready</div></a>
		<a href="./jstready.php?chkstat=2"><div class="button">Staff Standard Check In</div></a>
        <a href="./jstsearch.php"><div class="button">Staff Search</div></a>
        <a href=""><div class="button">Staff Check In Progress</div></a>
        <a href="./jstcheckin.php"><div class="button">Staff Check In Form</div></a>
	</div>

    <?php } ?>
		
	<div class="admin">
		<h3>Sub Camp Check In Options</h3>
		<a href=""><div class="scbutton">Op Arrow Worksheet</div></a>
		<?php if ($_SESSION['userid'] != "oparrow") { ?> 
        <a href=""><div class="scbutton">Sub Camp Check In</div></a>
        <?php } ?>
        <a href=""><div class="scbutton">Unit/Council Search</div></a>
        <a href=""><div class="scbutton">Sub Camp Check In Progress</div></a>
		
	</div>



    </div>
    
    <?php
        }
    ?>

	</main>
    <footer>
        <?php include "helpers/footer.inc.php"; ?>
    </footer>

</body>
</html>