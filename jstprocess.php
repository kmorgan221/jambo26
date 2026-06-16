<?php 
	session_start();
    
    //set required access level for page - leave commented if available for all
	//1 - Users; 2 - admins; 3 - super users
    $page_access = 1;

    define('MyConst', TRUE);
    require_once("helpers/session.php"); 

    if (isset($_GET['return'])) {
        if ($_GET['return'] == "search") {
            $_SESSION['return_url'] = "./jstsearch.php";
        } else if ($_GET['return'] == "ready") {
            $_SESSION['return_url'] = "./jstready.php";
        }
    }
    
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
    <title>Process JST Check In</title>
</head>
<body>
	<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
        $subtitle = "Process Staff Member Check In";
        include "helpers/header.inc.php"; 
        ?>

    
	<main>

    <?php

        if ($online == 0) {
           include "helpers/offline.php";
        } else {
            if (isset($_GET['rescode'])) {
                $regid = $_GET['rescode'];
            } else {
                
                $regid = "";
            }
            //process actions
            //process Packet Pulled

            if (isset($_GET['packet'])) {
                $packet = $_GET['packet'];
                $sql = "UPDATE jambo26_jst SET packet={$packet} WHERE ReservationCode = '{$regid}'";
                mysqli_query($conn, $sql);
                
                //write log entry
                if ($packet == 1) {
                    $packet_action = "Pulled";
                } else {
                    $packet_action = "Returned";
                }
                
                $user_log = $_SESSION['userid'];
                $log_type = "JST";
                $log_desc = "Staff member {$regid} Packet {$packet_action} by {$user_log}";
                include 'helpers/log_entry.php';

            }

            //Process Check In

            if (isset($_GET['checkin'])) {
                $checkin = $_GET['checkin'];
                $sql = "UPDATE jambo26_jst SET Complete={$checkin}, checkintime = NOW() WHERE ReservationCode = '{$regid}'";
                mysqli_query($conn, $sql);

                //write log entry
                if ($checkin == 1) {
                    $checkin_action = "Checked In";
                } else {
                    $checkin_action = "Check In Cancelled";
                }

                $log_type = "JST";
                $log_desc = "Staff member {$regid} {$checkin_action}";
                $user_log = $_SESSION['userid'];
                include 'helpers/log_entry.php';
            }

            //display JST member info
            echo "<div>";   
            
            $sql = "SELECT * FROM jambo26_jst WHERE ReservationCode = '{$regid}'";

            $result = mysqli_query($conn, $sql);

            $row = mysqli_fetch_row($result);
            if (!mysqli_num_rows($result)) {

                echo "<P><strong>No Staff Member found with that ID.</p>";
            
            } else {
                
                $firstname = $row['0'];
                $lastname = $row['1'];
                $session_name = $row['2'];
                $jst_email = $row['3'];
                $rescode = $row['4'];
                $due = $row['5'];
                $ahmr = $row['6'];
                $ypt = $row['7'];
                $membership = $row['8'];
                $position = $row['9'];
                $checkin_status = $row['10'];
                $checkin_complete = $row['11'];
                $packet = $row['12'];
                
                $bkcolor = "";
                $statmsg = "";
                $txtcolor = "";
                
                if ($packet == 1) {
                    $bkcolor = "#9AB3D5";
                    $statmsg = "Packet has been pulled. Ready to Check In";
                    $txtcolor = "white";
                }

                if ($checkin_status == 2) {
                    $bkcolor = "#CE1126";
                    $statmsg = "Staff Member on site but Pre Check In Tasks Not Complete";
                    $txtcolor = "white";
                    if ($packet == 1) {
                        $statmsg .= "<br>Packet has been pulled.";
                    }
                }

                if ($checkin_complete == 1) {
                    $bkcolor = "#006B3F";
                    $statmsg = "Staff Member Check In Already Complete";
                    $txtcolor = "white";
                }


                echo "<div>";
                echo "<div style='background-color: {$bkcolor};'>";
                echo "<h3 style='color: {$txtcolor};'>{$firstname} {$lastname}<br>{$statmsg}</h3>";
                echo "</div>";
                echo "<p><strong>Session: {$session_name}</strong></p>";
                echo "<p><strong>Email: </strong>{$jst_email}<br>";
                echo "<strong>Reservation Code:</strong> {$rescode}<br>";
                echo "<strong>Position:</strong> {$position}</strong></p>";

                if (($checkin_status) == 2 AND ($checkin_complete != 1)) {
                    echo "<p><strong>Incomplete Check In Tasks:</p>";
                    echo "<p>";
                    if ($membership != 1) {
                        echo "&#10060; <strong>Scouting America Registered</strong></br>";
                    }
            
                    $yptdate = "2025-08-01";
                    if ($ypt >= $yptdate) {
                        
                    } else {
                        echo "&#10060; <strong>SYT Complete</strong></br>";
                    }
            
                    if ($ahmr != "SUBMITTED") {
                        echo "&#10060; <strong>AHMR Submitted</strong></br>";
                    }
                    
                    if ($due >0 ) {
                        echo "&#10060; <strong>All Fees Paid</strong></br>";
                    }
                    echo "</p></div>";
                }
            
            ?>
            
            <div>                
                <?php if ($packet == 0) { ?>
                    <a href="?rescode=<?php echo $rescode; ?>&packet=1" class="button">Pulled Packet</a>
                <?php } else { ?>
                    <a href="?rescode=<?php echo $rescode; ?>&packet=0" class="button">Return Packet</a>
                <?php } ?>

                <?php if ($checkin_complete == 0) { ?>
                    <a href="?rescode=<?php echo $rescode; ?>&checkin=1" class="button">Check In</a>
                <?php } else { ?>
                    <a href="?rescode=<?php echo $rescode; ?>&checkin=0" class="button">Cancel Check In</a>
                <?php } ?>
            </div>
            
            <?php
            }

      
        
        if ($_SESSION['return_url'] == "./jstready.php") {
            echo "<a href='{$_SESSION['return_url']}?chkstat={$checkin_status}'><div class='scbutton'>Return to Check In Dashboard</div></a>";
        } else {
            echo "<a href='{$_SESSION['return_url']}'><div class='scbutton'>Return to Search Page</div></a>";
        }
       
        
        

            echo "</div>";
        }
    ?>
	</main>
    <footer>
        <?php include "helpers/footer.inc.php"; ?>
    </footer>

</body>
</html>