	<?php if (($online != 0) AND  (!isset($_SESSION['userid']))) { ?>
		<li <?php echo $menuclass; ?> ><a href="jstcheckin.php">JST Checkin</a></li>
	<?php } ?>
	
	<?php if (isset($_SESSION['user_access']) && $_SESSION['user_access'] >= 1) { ?>
		<li <?php echo $menuclass; ?> ><a href="dashboard.php">Dashboard</a></li>
	<?php } ?>
	
	<?php if (isset($_SESSION['user_access']) && $_SESSION['user_access'] >= 2) { ?>	
		<li <?php echo $menuclass; ?> ><a href="administration.php">Admin</a></li>
	<?php } ?>
	
	<?php if (isset($_SESSION['user_access']) && $_SESSION['user_access'] >= 1) { ?>	
		<li <?php echo $menuclass; ?> ><a href="editprofile.php?id=<?php echo $_SESSION['id']; ?>">Profile</a></li>
	<?php } ?>

	<?php if (isset($_SESSION['user_access'])) { ?>	
		<li <?php echo $menuclass; ?> ><a href="logout.php">Logout</a></li>
	<?php } ?>

	<?php if (!isset($_SESSION['user_access'])) { ?>	
		<li <?php echo $menuclass; ?> ><a href="login.php">Login</a></li>
	<?php } ?>