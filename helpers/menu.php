<?php
if(!defined('MyConst')) {
    die('');
 }
//Menu Options

$menuclass = "";
?>

	<ul class="sidebar">
		
		<li onclick=hideSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg"  height="26" viewBox="0 96 960 960" width="26"><path d="m249 849-42-42 231-231-231-231 42-42 231 231 231-231 42 42-231 231 231 231-42 42-231-231-231 231Z"/></svg></a></li>
		
	<?php include "helpers/menuitems.php"; ?>
	
	</ul>


<?php $menuclass = "class=hideOnMobile"; ?>

    <ul>
      <li><a href="./">ELEVATE Your Access</a></li>
	  
	  <?php include "helpers/menuitems.php"; ?>
      
      <li class="menu-button" onclick=showSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" fill="white" height="26" viewBox="0 96 960 960" width="26"><path d="M120 816v-60h720v60H120Zm0-210v-60h720v60H120Zm0-210v-60h720v60H120Z"/></svg></a></li>
    </ul>
 



<?php

?>