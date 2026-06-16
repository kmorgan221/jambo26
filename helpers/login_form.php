<?php
//check if called directly
if(!defined('MyConst')) {
    die('');
  }
	
?>

 <form action="login.php" method="post">
            <div class="inline">
                <label for="username">Username</label>
                <input type="text" placeholder="Enter your user name" id="username" name="user" 

                <?php if (isset($user)) {  ?>
                  value="<?php echo $user; ?>"
			         	<?php } ?>
                autofocus >
            </div>

            <div class="inline">
                <label for="password">Password</label>
                <input type="password" placeholder="Enter your password" id="password" name="password" value="">
            </div>
            
            <input type="submit"  value="Login">
    </form>