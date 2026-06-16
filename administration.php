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
    <title>Document</title>
</head>
<body>
	<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
        $subtitle = "Adminstration Options";
        include "helpers/header.inc.php"; 
        ?>

    
	<main>

    <?php

        if ($online == 0) {
           include "helpers/offline.php";
        } else {
			
    ?>

        <h1>JST Forward Fast Administration</h1>
		<div>
			<div class="admin">
				<h3>User Management</h3>
				<a href="./adduser.php"><div class="button">Add User</div></a>
				<a href="./edituser.php"><div class="button">Edit User</div></a>
			</div>
			
			<div class="admin">
				<h3>System Logs</h3>
				<a href="./viewlogs.php"><div class="button">View Logs</div></a>
			</div>
		
		



		<?php  
			if ($_SESSION['user_access'] == 3) { ?>
				<div class="admin">
				<h3>Site Display Settings</h3>
				<hr width=75% align=left>				

			<?php
				if (!empty($_POST)) {

										
					$_SESSION['offline_message'] = $_POST['offline_desc'];

					if (isset($_POST['offline'])) {
						$_SESSION['online_status'] = 0;
					} else {
						$_SESSION['online_status'] = 1;
					}
					$config = array(
						'online' => $_SESSION['online_status'],
						'offline_msg'=> $_SESSION['offline_message'],
					);

					// Write the PHP code to a file
					$file = 'helpers/config.php';
					$content = "<?php\n\n";
					$content .= "if(!defined('MyConst')) {\n";
					$content .= "die('');\n";
					$content .= "} \n";
					$content .= "\$config = " . var_export($config, true) . ";\n\n";
					$content .= "?>";


					file_put_contents($file, $content);
					echo "<p>Site Display Status updated.</p>";
					//write log entry
					    				
					$log_type = "System";
					$log_desc = "Updated offline status and offline message";
					$user_log = $_SESSION['userid'];
					
					include 'helpers/log_entry.php';
					
				}
			
		?>


				<form action="administration.php" method="post">
				<div>
					<label class="switch" for="checkbox">
						<input type="checkbox"  id="checkbox" name="offline" 
						<?php
							if ($_SESSION['online_status'] == 0) {
								echo "checked";
							}
							 ?>
						>
						<div class="slider round"></div>
					</label>
					<span style="padding: 8px;"><strong>Site Offline?</span>
				</div>
				
				<div class="offline_text">
					<label for="offline_desc">Offline Message</label>
					<textarea id="offline_desc" name="offline_desc" style="margin-left:15px;"><?php echo $_SESSION['offline_message']; ?></textarea>
				</div>
				<input type="submit"  value="Apply Site Settings">
				</form>
			<?php }  ?>
        </div>    
    <?php
		echo "</div>";
        }
    ?>
	</main>
    <footer>
        <?php include "helpers/footer.inc.php"; ?>
    </footer>

</body>
</html>