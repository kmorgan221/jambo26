<?php 
	session_start();
    
    //set required access level for page - leave commented if available for all
	//1 - Users; 2 - admins; 3 - super users
    $page_access = 2;

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
    include 'helpers/dbh.php';
?>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="helpers/styles.css">
    <title>Delete User</title>
</head>
<body>
	<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
        $subtitle = "Delete User Profile";
        include "helpers/header.inc.php"; 
        ?>

    
	<main>

    <?php

        if ($online == 0) {
           include "helpers/offline.php";
        } else {

            if (!isset($_GET['id'])) {
                echo "<h3>NO USER SELECTED</h3>";
            } else {
                if ($_GET['id'] == $_SESSION['id']) {
                    echo "<h3>You cannot delete your own profile!</h3>";
                    ?>
                
                <a href="./edituser.php"><div class="button">Return to User Menu</div></a>
                    
                <?php
                    } else if (isset($_GET['del']) AND $_GET['del'] =="yes") {
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM jambo26_users WHERE id=$id";
	
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_row($result);

                    if (mysqli_num_rows($result) > 0) {
                        $lastname = $row['2'];
                        $firstname = $row['3'];
                        $useraccess  = $row['5'];
                        $user_name = $row['1'];

                    $sql = "DELETE FROM jambo26_users WHERE id=$id";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_affected_rows($conn) == 1 ) {
                        echo "<h3>User Proflie Deleted</h3><p>User profile for <strong> " . $firstname . " "  . $lastname . "</strong> has been deleted.</p>";

                            //write log entry
                                $log_type = "User Maintenance";
                                $log_desc = "User Profile Deleted: " . $user_name;
                                $user_log = $_SESSION['userid'];
                                
                                include 'helpers/log_entry.php';
                                mysqli_close($conn);
                    ?>

                    <a href="./edituser.php"><div class="button">Return to User Menu</div></a>
                    <?php
                    }

                    }

                
                
            } else if (!isset($_GET['del'])) {
                   
                    $sql = "SELECT * FROM jambo26_users WHERE id=".$_GET['id'];
	
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_row($result);

                    if (mysqli_num_rows($result) > 0) {
                        
                        $id = $row['0'];
                        $lastname = $row['2'];
                        $firstname = $row['3'];
                        $useraccess  = $row['5'];
                        $user_name = $row['1'];

                        echo "<h3>User profile will be deleted for</h3>";
                        echo "<p>Are you sure you want to delete profile for <strong>" . $firstname . " " . $lastname . "</strong>?"; 
                        ?>
                        
                        <a href="./deleteuser.php?id=<?php echo $id ?>&del=yes"><div class="button">YES! Delete User</div></a>
                        <a href="./edituser.php"><div class="button">DO NOT DELETE! Return to User Menu</div></a>
                <?php
                    } else {

                        echo "<h3>No users found</h3>";
                    }
                
                }

            }
        }
    ?>
	</main>
    <footer>
        <?php include "helpers/footer.inc.php"; ?>
    </footer>

</body>
</html>