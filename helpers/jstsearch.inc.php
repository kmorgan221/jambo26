<?php
if(!defined('MyConst') AND !isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    die('unauthorized');
 }
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
include "dbh.php";

if (isset($_POST['input'])) {
  $input = $_POST['input'];
  
  $sql= "SELECT * FROM jambo26_jst WHERE FirstName LIKE '{$input}%'
        OR LastName LIKE '{$input}%' 
        OR ReservationCode LIKE '{$input}%'
        OR JSTEmail LIKE '{$input}%'
        ORDER BY LastName";

//get values

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) { 


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

$bkcolor = "white";
$txtcolor = "black";

if ($checkin_status == 2) {
  $bkcolor = "#CE1126";
  $txtcolor = "white";
}

if (($checkin_status == 1) AND ($packet == 0)) {
  $bkcolor = "yellow";
  $txtcolor = "black";
}

if (($checkin_status != 2) AND ($packet == 1)) {
  $bkcolor = "#9AB3D5"; 
  $txtcolor = "black";
}

if ($checkin_complete == 1) {
  $bkcolor = "#006B3F";
  $txtcolor = "White";
}

  echo "<tr>";
  echo "<td style='background-color: {$bkcolor}; color: {$txtcolor};'><a class='jst_link' href='./jstprocess.php?rescode={$rescode}&return=search'>{$firstname} {$lastname}</a></td>";
  echo "<td>{$rescode}</td>";
  echo "<td>{$jst_email}</td>";
  echo "</tr>";

}

}
}


?>