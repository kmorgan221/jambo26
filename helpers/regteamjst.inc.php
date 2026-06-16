<?php
if(!defined('MyConst') AND !isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
  die('Nope');
  } 

include "dbh.php";
$html = "";
    if (isset($_GET['filter'])) {
        $checkstat = $_GET['filter'];
    }

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
} 

$sql= "SELECT * FROM jambo26_jst WHERE Checkin = {$checkstat} 
        AND (Complete = 0 OR (Complete = 1 AND TIMESTAMPDIFF(MINUTE, checkintime, NOW()) <= 1  ))
        ORDER BY LastName";

//get values

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) { 
echo "<div id='container'>";

while($row = mysqli_fetch_array($result)) {

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

  $color = ""; 
  $status = "";
  
  if ($checkin_status == 2) {
    $color = "#CE1126"; 
    $status = "Pre Check In Tasks Not Complete:";
    if ($packet == 1) {
      $status .= "<br>Packet has been pulled.";
    }
  }
  
  if (($checkin_status == 1) AND ($packet == 0)) {
    $color = "white";
    $status = "Staff Member is on site. Packet needs to be pulled.";
  }  
  
  if (($checkin_status == 1) AND ($packet == 1)) {
    $color = "#9AB3D5"; 
    $status = "Packet has been pulled and ready for Check-In";
  }

  if ($checkin_complete == 1) {
    $color = "#006B3F"; 
    $status = "Staff Member has already been checked in.";
  }

  $html .= "<a href='./jstprocess.php?rescode={$rescode}&return=ready'><div class='jst' style='background: linear-gradient(to bottom, {$color} 5%, white 75%);'>";
  $html .= "<P><strong>{$lastname}, {$firstname}</strong><br>";
  $html .= "{$status}</p>";
  $html .= "<p><strong>Session: </strong> {$session_name}</p>";
  $html .= "<p><strong>E-Mail: </strong>{$jst_email}<br>";
  $html .= "<strong>Reservation Code: </strong>{$rescode}<br>";
  $html .= "<strong>Position: </strong>{$position}</p>";

  if (($checkin_status == 2) AND ($checkin_complete != 1)) {
    $html .= "<p><strong>Incomplete Check In Tasks:</strong></p>";
    $html .= "<p>";
    if ($membership != 1) {
      $html .= "&#10060; <strong>Scouting America Registered</strong></br>";
    }

    $yptdate = "2025-08-01";
    if ($ypt >= $yptdate) {
        
    } else {
      $html .= "&#10060; <strong>SYT Complete</strong></br>";
    }

    if ($ahmr != "SUBMITTED") {
      $html .= "&#10060; <strong>AHMR Submitted</strong></br>";
    }
    
    if ($due >0 ) {
      $html .= "&#10060; <strong>All Fees Paid</strong></br>";
    }
    $html .= "</p>";
}

  $html .= "</div></a>";

  
  }

$html .= "</div>";
} else {

}
mysqli_close($conn);

echo $html;
?>