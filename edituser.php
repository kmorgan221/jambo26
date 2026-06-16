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
    //include 'helpers/dbh.php';
?>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="helpers/styles.css">
    <title>User Maintenance</title>
</head>
<body>
	<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
       $subtitle = "User Maintenance / Edit Users";
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
            <a href="./edituser.php"><div class="button">Return to User Menu</div></a>
        <?php
        } else {
            echo "<P>Click on <strong>username</strong> to edit that user record. Click on <strong>Delete User</strong> to remove that user record.</h3>";
             //load db credentials and connection string
            include 'helpers/dbh.php';
            //check for existing username

            $sql = "SELECT * FROM jambo26_users WHERE user_access <=" . $_SESSION['user_access'];
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) { ?>

                <table>
                <tr><th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>User Access</th>
                <th>Delete User</th></tr>

            <?php
                while($row = mysqli_fetch_array($result)) { 
                    $id = $row['0'];
                    $lastname = $row['2'];
                    $firstname = $row['3'];
                    $useraccess  = $row['5'];
                    $user_name = $row['1'];
                    echo "<tr><td><span class='users'><strong><a href='./edituser.php?id=" . $id . "'>" . $user_name ."</a></strong></span></td>";
                    echo "<td>" . $firstname ."</td>";
                    echo "<td>" . $lastname ."</td>";
                
                    if ($useraccess==1) { $uaccess="Staff"; }
                    if ($useraccess==2) { $uaccess="Lead Team"; }
                    if ($useraccess==3) { $uaccess="Administrator"; }

                    echo "<td>" . $uaccess ."</td>";
                    if ($id != $_SESSION['id']){
                    echo "<td><a href='./deleteuser.php?id=$id'>Delete User: $user_name</a></td></tr>";
                    } else {
                        echo "<td></td></tr>";
                    }
                } ?>
                    </table>
                <?php
                } else {
                    echo "<h3>No Users Found</h3>";
                }
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