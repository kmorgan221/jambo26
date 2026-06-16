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
    <title>Edit Profile</title>
</head>
<body>
	<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
       $subtitle = "Edit Profile: " . $_SESSION['First_Name']. " " .$_SESSION['Last_Name'];
       
        include "helpers/header.inc.php";
        $pagetype="EditUser";
        ?>

    
	<main>

    <?php

        if ($online == 0) {
           include "helpers/offline.php";
        } else {
    
        if (isset($_GET['id']))  {
            
            $id = $_GET['id'];
            include "helpers/inc.adduserform.php"; ?>
<?php
        } else {
            echo "<h3>This will show the table of users the logged in user can edit</h3>";
        }
    ?>

    
    
    <?php

        }
    ?>
	</main>
    <footer>
        <?php include "helpers/footer.inc.php"; ?>
    </footer>

</body>
</html>