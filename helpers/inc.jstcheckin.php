<?php
if(!defined('MyConst')) {
  die('');
} 



if (!empty($_POST)) {
// Start Form Processing 
 echo "<h3>Welcome to the National Jamboree!</h3>";

 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }	
    $regid = $_POST['rescode'];
    $sql = "SELECT * FROM jambo26_jst WHERE ReservationCode = '{$regid}'";

    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_row($result);
    if (!mysqli_num_rows($result)) {

        echo "<P><strong>No records found under that reservation code.</strong>  Please verify your reservation code and try again.</br>If you cannot resolve please enter the Ruby Welcome Center and enter the Standard Queue and a registration team member will help get you checked in.</p>";
        $invalid = 1;
        $log_type = "JST";
        $log_desc = "Attempted Check in.  Invalid Reservation Code Entered. Res code: {$_POST['rescode']} -  Name: {$_POST['First_Name']} {$_POST['Last_Name']}";

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

//Check if entered First and Last Name Matches

        if (($firstname != $_POST['First_Name']) OR ($lastname != $_POST['Last_Name'])) {
        $invalid = 1;
        $invalid_message = "<P><Strong>First or Last Name do not match registration</strong>. Please correct and resubmit, or if you cannot resolve please enter the Ruby Welcome Center and enter the Standard Queue and a registration team member will help get you checked in.</p>";
        $jstid = $_POST['rescode'];
        $fname = $_POST['First_Name'];
        $lname = $_POST['Last_Name'];
        $jstemail = $_POST['Email'];

        $log_type = "JST";
        $log_desc = "Staff member First or Last Name do not match registration. Enterend information was: Res code: {$_POST['rescode']} -  Name: {$_POST['First_Name']} {$_POST['Last_Name']}";

        } else {

        echo "<h3>{$firstname} {$lastname}</h3>";
        echo "<p><strong>Session: {$session_name}</strong></p>";
        echo "<p><strong>Email: </strong>{$jst_email}<br>";
        echo "<strong>Reservation Code:</strong> {$rescode}<br>";
        echo "<strong>Position:</strong> {$position}</strong></p>";

        echo"<h2>Check In Status</h2>";

        $checkin_ready = 0;
        $incomplete = '';
        echo "<p>";
        if ($membership == 1) {
            echo "&#9989;";
        } else {
            echo "&#10060;";
            $checkin_ready =$checkin_ready + 1;
            $incomplete = "Membership not Current: ";
        }
        echo "<strong>Scouting America Registered</strong></br>";

        $yptdate = "2025-08-01";
        if ($ypt >= $yptdate) {
            echo "&#9989;";
        } else {
            echo "&#10060;";
            $checkin_ready =$checkin_ready + 1;
            $incomplete .= "SYT not Current: ";
        }
        echo "<strong>SYT Complete</strong></br>";

        if ($ahmr == "SUBMITTED") {
            echo "&#9989;";
        } else {
            echo "&#10060;";
            $checkin_ready =$checkin_ready + 1;
            $incomplete .= "AHMR Not Submitted: ";
        }
        echo "<strong>AHMR Submitted</strong></br>";

        if ($due < 1) {
            echo "&#9989;";
        } else {
            echo "&#10060;";
            $checkin_ready =$checkin_ready + 1;
            $incomplete .= "Jambo Fees Still Due: ";
        }
        echo "<strong>All Fees Paid</strong></br>";
        echo "</p>";

        if ($checkin_status == 1) {

            echo "<P>You have already completed the pre-checkin process. Please proceed into the <em>Ruby Welcome Center</em> to pickup your packet.</p>";
            $log_type = "JST";
            $log_desc = "Staff member {$firstname} {$lastname} duplicate check-in.  All prereqs complete, ready to check in and issue Staff packet.";
        } else if ($checkin_status == 2)  {
            echo "<P><strong>You have already completed the pre-checkin process, but your pre arrival tasks are not complete.</strong> Please proceed into the <em>Ruby Welcome Center</em> and join the <strong>General Check In Queue</strong> to complete the check in process.</p>";
            $log_type = "JST";
            $log_desc = "Staff member {$firstname} {$lastname} duplicate check-in.  Not all prereqs are complete, proceed to standard queue. {$incomplete}";

        } else if ($checkin_complete == 1) {
            echo "<h2>Your Check in already complete. Enjoy Jambo!</h2>";
            $log_type = "JST";
            $log_desc = "Staff member {$firstname} {$lastname} duplicate check-in.  Check In already complete and packet issued.";


        } else {


        if ($checkin_ready == 0) {
            echo "<h2>Registration Confirmed</h2>
            <P>Welcome 2026 National Jamboree! Your Jamboree Staff registration is confirmed and we're ready to complete your check in process.  Please proceed into the <em>Ruby Welcome Center</em> and join the <strong>Staff ELEVATE! </strong> queue and a registration team member will have your check in packet ready.</p>";

            $sql = "UPDATE jambo26_jst SET Checkin=1 WHERE ReservationCode = '{$rescode}'";
            mysqli_query($conn, $sql);

            $log_type = "JST";
            $log_desc = "Staff member {$firstname} {$lastname} registration confirmed and check-in ready. All prereqs complete, ready to check in and issue Staff packet.";

        } else {
            echo "<h3>Your pre-arrival registration tasks are not complete.</h3><p>Your reservation code has been confirmed, but our records indicate you have not completed all the pre-arrival registration tasks. Please proceed into the <em>Ruby Welcome Center</em> and join the <strong>General Check In Queue</strong> to complete the check in process.</p>";
            $sql = "UPDATE jambo26_jst SET Checkin=2 WHERE ReservationCode = '{$rescode}'";
            mysqli_query($conn, $sql);

              $log_type = "JST";
              $log_desc = "Staff member {$firstname} {$lastname} registration confirmed but all prereqs not complete. Proceed to Standard Queue to complete check in. {$incomplete}";
        }

    }
    }

}
	 //write log entry
	 
     if (isset($_SESSION['userid'])) {
	 $user_log = $_SESSION['userid'];

     } else {
        $user_log = "";
     }
	 
	 include 'helpers/log_entry.php';
	 mysqli_close($conn);

//End Form Processing
} 

if (((isset($invalid)) AND ($invalid == 1)) OR (empty($_POST))) {
    
    if (isset($_GET['regid']) AND (!isset($invalid))) {
    //JST ID provided - Pre populate JST info in form
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }	
        $regid = $_GET['regid'];
        $sql = "SELECT * FROM jambo26_jst WHERE ReservationCode = '{$regid}'";
        
        $result = mysqli_query($conn, $sql);
    
        
    
        $row = mysqli_fetch_row($result);
        if (mysqli_num_rows($result) > 0) {

        $jstid = $_GET['regid'];
        $fname = $row['0'];
        $lname = $row['1'];
        $jstemail = $row['3'];

    }

        
    }
    
?>

     <h2>Jamboree Staff Check In</h2>

    <?php if (isset($jstid)) { ?>
<p><strong>Once you arrived at the Ruby Welcome Center,</strong> please confirm your name, email address, and Jamboree Reservation Code to ELEVATE Your Access.</p>
<?php } else { ?>
<p><strong>Once you arrived at the Ruby Welcome Center,</strong> please enter your name, email address, and Jamboree Reservation Code to ELEVATE Your Access.</p>
<?php } ?>
<h3><strong>Please do not SUBMIT this form until you have arrived on site at the Ruby Welcome Center.</strong></h3>

<?php if (isset($invalid_message )) { echo $invalid_message; } ?>

<form action="" method="post">
    <div class="inline">
        <label for="first_name">First Name</label>
        <input type="text" placeholder="Enter your first name" id="first_name" name="First_Name" autofocus required
        <?php if (isset($fname)) { ?>
            value="<?php echo $fname; ?>"
        <?php }  ?>
        >
    </div>

    <div class="inline">
        <label for="last_name">Last Name</label>
        <input type="text" placeholder="Enter your last name" id="last_name" name="Last_Name" required
        <?php if (isset($lname)) { ?>
            value="<?php echo $lname; ?>"
        <?php }  ?>
        >
    </div>
    <div class="inline">
        <label for="email">Email Address</label>
        <input type="email" placeholder="Enter your email (used for Staff Registration)" id="email" name="Email" required
        <?php if (isset($jstemail)) { ?>
            value="<?php echo $jstemail; ?>"
        <?php }  ?>
        >
    </div>

    <div class="inline">
        <label for="rescode">Reservation Code</label>
        <input type="text" placeholder="Enter your Reservation Code" id="rescode" name="rescode" required
        <?php if (isset($jstid)) { ?>
            value="<?php echo $jstid; ?>"
        <?php }  ?>
        >
    </div>

    <div class="checkbox">
        <input type="checkbox" placeholder="Enter your last name" id="onsite" name="onsite" value="Yes" required>
        <label for="onsite">YES! I am on site at the Ruby Welcome Center and ready to Check In</label>
    </div>
    <input type="submit">
</form>
<?php } ?>