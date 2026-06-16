<?php
if(!defined('MyConst')) {
    die('');
 }

    //write log entry
    //load db credentials and connection string
    if (!isset($conn)) {
    include 'helpers/dbh.php';
    }

    $sql = "INSERT INTO jambo26_log (event_type, event_desc, user)
    VALUES ('$log_type', '$log_desc', '$user_log')";
    
    if (mysqli_query($conn, $sql)) {
        } else {
        echo "<p>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
        }
 ?>