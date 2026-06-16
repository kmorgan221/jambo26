<?php 
	session_start();
    //set required access level for page - leave commented if available for all
	//1 - Users; 2 - admins; 3 - super users
    $page_access = 0;
    define('MyConst', TRUE);
    require_once("helpers/session.php");    
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
    <title>Jambo Forward Fast</title>
</head>
<body>
	<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
        
        include "helpers/header.inc.php"; 
        ?>

    
	<main>

    <?php

        if ($online == 0) {
           include "helpers/offline.php";
        } else {
    ?>
    
    <h1>ELEVATE Your Access in 2026</h1><p>We're preparing for your arrival at the Bechtel Summit Reserve this July for the 2026 National Jamboree.</p>
<p>Get more information on the 2026 National 
   Jamboree at <a href=https://jamboree.scouting.org/ target=blank>https://jamboree.scouting.org/</a></p>
        
    <?php

        }
    ?>
	</main>
    <footer>
        <?php include "helpers/footer.inc.php"; ?>
    </footer>

</body>
</html>