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
    //mysqli_query($conn, "SET time_zone = '-4:00';");
?>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="helpers/styles.css">
    <title>View System Logs</title>
</head>
<body>
	<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
       $subtitle = "System Logs";
        include "helpers/header.inc.php"; 
        ?>

    
	<main>

    <?php

        if ($online == 0) {
           include "helpers/offline.php";
        } else {

            // Pagination parameters
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
            $records_per_page = 25;
            $offset = ($page - 1) * $records_per_page;

            $sql = "SELECT * FROM jambo26_log ORDER BY event_time DESC LIMIT $offset, $records_per_page";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) { ?>
            <h1>System Logs</h1>
            <table>
            <tr>
                <th>Log ID</th>
                <th>Date/Time</th>
                <th>Event Type</th>
                <th>Event Description</th>
                <th>User</th>
            </tr>

            <?php
                while($row = mysqli_fetch_array($result)) { 
                    $log_id = $row['0'];
                    $event_type = $row['1'];
                    $event_desc = $row['2'];
                    $event_user  = $row['3'];
                    $timestamp = $row['4'];
                    ?>
                <tr>
                    <td><?php echo $log_id; ?></td>
                    <td><?php echo $timestamp; ?></td>
                    <td><?php echo $event_type; ?></td>
                    <td><?php echo $event_desc; ?></td>
                    <td><?php echo $event_user; ?></td>
                </tr>
            <?php } ?>
                </table>
            <?php
            // Pagination links
                $sql = "SELECT COUNT(log_id) AS total FROM jambo26_log";
                //$result = $conn->query($sql);
                $result = mysqli_query($conn, $sql);
                //$row = $result->fetch_assoc();
                $row = mysqli_fetch_array($result);
                $total_pages = ceil($row["total"] / $records_per_page);

                echo "<br><br>Pages: ";
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a href='?page=$i'>$i</a> ";
                }
            } else {

                echo "<h3>No Logs Found</h3>";
            }

        }
    ?>
	</main>
    <footer>
        <?php include "helpers/footer.inc.php"; ?>
    </footer>

</body>
</html>