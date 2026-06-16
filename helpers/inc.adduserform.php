<?php
if(!defined('MyConst')) {
  die('');
} 

//If form submitted, save User Info
if (!empty($_POST)) {
 if (!isset($_POST['password']) OR ($_POST['password'] == $_POST['verifypass'])) {

  //echo "<h3>Password Matches</h3>"; 
  //load db credentials and connection string
  include 'helpers/dbh.php';
  //check for existing username



  $sql = "SELECT * FROM jambo26_users WHERE username = '".$_POST['username']."'";
  $result = mysqli_query($conn, $sql);
	if (!mysqli_num_rows($result) OR isset($_POST['id'])) {
    
    if (($_POST['pageaction'] == "AddUser") AND ($_POST['password'] == "")) {
      echo "<P>Please enter a password for new user.</p>";
    } else {
      $user = filter_var($_POST['username'], FILTER_SANITIZE_STRING);

      $fname = filter_var($_POST['First_Name'], FILTER_SANITIZE_STRING);
      $lname = filter_var($_POST['Last_Name'], FILTER_SANITIZE_STRING);
      $u_access = filter_var($_POST['user_access'], FILTER_SANITIZE_STRING);

      if ($_POST['pageaction']=="AddUser") {
          $sql = "INSERT INTO jambo26_users (username, Last_Name, First_Name, ";
          if ($_POST['password'] != "") { 
            $sql .= "password, ";
          }
          $sql .= "user_access) ";
          $sql .= "VALUES ('$user', '$lname', '$fname', ";
          if ($_POST['password'] != "") { 
            $pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $pwd = password_hash($pass, PASSWORD_DEFAULT);
            $sql .= "'$pwd', ";
          } 
          $sql .= "'$u_access')";
      }

      if ($_POST['pageaction']=="EditUser") {
        $sql = "UPDATE jambo26_users 
        SET username='$user', 
        Last_Name='$lname', 
        First_Name='$fname', ";
        
        if ($_POST['password'] != "") { 
          $pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
          $pwd = password_hash($pass, PASSWORD_DEFAULT);
          $sql .= "password='$pwd', ";
        }
        
        $sql .= "user_access='$u_access'
        WHERE id=$id;";
    }

      if (mysqli_query($conn, $sql)) {
      echo "<p>User record successfully updated.</p>";
    } else {
      echo "<p>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
    }

    //write log entry
            
    $log_type = "User Maintenance";
    if ($_POST['pageaction']=="AddUser") {
      $log_desc = "New user added: " . $user;
    }

    if ($_POST['pageaction']="EditUser")  {
      $log_desc = "User record updated: " . $user;
    }
    $user_log = $_SESSION['userid'];
    
    include 'helpers/log_entry.php';
    mysqli_close($conn);
    }

  } else {

    echo "<p>Username already exists - please try again!</p>";
    mysqli_close($conn);
  }

  //$pagetype = "EditUser";
  if ($_POST['user_access'] == 1) { $access = "Staff"; }
  if ($_POST['user_access'] == 2) { $access = "Lead Team"; }
  if ($_POST['user_access'] == 3) { $access = "Administrator"; }
  
} else {
  //Password does not match - ask for input
  echo "<h3>Password Does Not Match</h3>";
  
 }
 $user_name = $_POST['username'];
 $firstname = $_POST['First_Name'];
 $lastname = $_POST['Last_Name'];
 $useraccess = $_POST['user_access'];
}
?>

<?php
  //check if a userid is given
  if (isset($id)) {
    //load db credentials and connection string
    include 'helpers/dbh.php';
    //check for existing username

    $sql = "SELECT * FROM jambo26_users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
        
    if (!mysqli_num_rows($result)) {
      echo "<h4>No user profile found for that ID.</h4>";
    } else {
      $row = mysqli_fetch_row($result);  
        
      $id = $row['0'];
      $lastname = $row['2'];
      $firstname = $row['3'];
      $useraccess  = $row['5'];
      $user_name = $row['1'];
      echo "<h3>User Profile for: " . $firstname . " " .$lastname . "</h3>";
    }
} 
?>

<form action="" method="post" autocomplete="off">
  <input type="hidden" name="pageaction" value="<?php echo $pagetype; ?>">
  <?php if (isset($id)) { ?>
    
    <input type="hidden" name="id" value="<?php echo $id; ?>">
  <?php } ?>

            <div class="inline">
                <label for="username">Username</label>

                <input type="text" placeholder="Enter your username" id="username" name="username" 
                <?php if (isset($user_name)) { ?>
                  value="<?php echo $user_name; ?>"  
                <?php } else { ?> 
                value="" 
                <?php } ?>                
                autofocus required>
            </div>

            <div class="inline">
            <?php if ($pagetype=="AddUser") {?>
            <label for="user_access">User Access Level:</label>
              <select id="user_access" name="user_access" required>
                <option value="" disabled selected>Choose Access Level</option>
                
                <option value="1" 
                  <?php if(isset($useraccess) && $useraccess == 1) { ?> Selected="selected"<?php } ?>
                >Staff</option>
                
                <option value="2"
                <?php if(isset($useraccess) && $useraccess == 2) { ?> Selected="selected"<?php } ?>
                >Lead Team</option>
              
                <?php if ($_SESSION['user_access'] == 3 ) { ?>
                <option value="3" 
                <?php if(isset($useraccess) && $useraccess == 3) { ?> Selected="selected"<?php } ?>
                >Administrator</option>
                <?php } ?>
              
              </select>
            <?php } else {
              if (!isset($access) AND $useraccess == 1) { $access = "Staff"; $uaccess=1; }
              if (!isset($access) AND $useraccess == 2) { $access = "Lead Team"; $uaccess=2; }
              if (!isset($access) AND $useraccess == 3) { $access = "Administrator"; $uaccess=3; }
             ?>
              <label for="user_acces2">User Access Level:</label>
              <input type="text"  id="user_access2" name="user_access" value="<?php echo $access; ?>" disabled>
              <input type="hidden" name="user_access" value="<?php echo $uaccess; ?>">

            <?php }?>

            </div>

            <div class="inline" required>
                <label for="first_name">First Name</label>
                <input type="text" placeholder="Enter your first name" id="first_name" name="First_Name" 
                <?php if (isset($firstname)) { ?>
                  value="<?php echo $firstname; ?>"  
                <?php } else { ?> 
                value="" 
                <?php } ?>   
                required>
            </div>

            <div class="inline" required>
                <label for="last_name">Last Name</label>
                <input type="text" placeholder="Enter your last name" id="last_name" name="Last_Name" 
                <?php if (isset($lastname)) { ?>
                  value="<?php echo $lastname; ?>"  
                <?php } else { ?> 
                value="" 
                <?php } ?>   
                required>
            </div>
            
            <div class="inline" required>
                <label for="password">Password</label>
                <input type="password" placeholder="Enter your password" id="password" name="password" value="" autocomplete="new-password">
            </div>

            <div class="inline" required>
                <label for="verifypass"> Verify Password</label>
                <input type="password" placeholder="Verfiy your password" id="verifypass" name="verifypass" value="" autocomplete="new-password">
            </div>
            
            <input type="submit">
    </form>