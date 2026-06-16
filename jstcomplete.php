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
   
    

    //load db credentials and connection string
    include 'helpers/dbh.php';
?>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="helpers/styles.css">
    <title>Complete JST Check In</title>
</head>
<body>
		<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
        $subtitle = "Jamboree Service Team Check-In Dashboard<br>
		Pre-Arrival Tasks Complete";
        include "helpers/header.inc.php"; 
        ?>

    
		
 
	
	<main>
<h3>hello</h3>
    <?php

        if ($online == 0) {
           include "helpers/offline.php";
        } else {
 
 // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
        
        
    $sql = "SELECT * FROM jambo26_jst WHERE Checkin = '1' AND Complete = '0' ORDER BY LastName";

	//get values
	$returnarticle = "jstdetail.php";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) { 
		echo "<div id='container'>";
    
        while($row = mysqli_fetch_array($result)) {
            //echo "<a href=https://jamboforwardfast.org/completecheckin?RegistrationCode=" . $row['4'] . "&return=jstcopmlete.php><div class='jst'>";

            echo "<a href=https://google.com target=blank><div class='jst'>";
            echo "<h3>" . $row['1'] . ", " . $row['0'] . "</h3>";
            echo "<p><strong>Session: " . $row['2'] . "</strong></p>";
            echo "<p>" . $row['3'] . "<br>";
            echo "<strong>Reservation Code:</strong> " . $row['4'] . "<br>";
            echo "<strong>Position:</strong> " . $row['9'] . "</strong></p>";
            echo "<p><a href=process?RegistrationCode=" . $row['4'] . "&return=". $returnarticle .">Complete Check In</a></p>";
            echo "</div></a>";
        }
        
    echo "</div>";
        }
	}
    ?>
	</main>
    <footer>
        <?php include "helpers/footer.inc.php"; ?>
    </footer>

</body>
</html>