
<?php


if(!defined('MyConst')) {
    die('');
 }
?>
 
<nav>
 <?php include "helpers/menu.php"; ?>

</nav>
<header>
<div class="headertitle">
	<div>
		<a href="./"><img src="images\elevate-300.png" style="padding: 0 15px 0 0;"></a>
		<!-- <picture style="padding: 0 15px 0 0;">
			<source srcset="images\elevate-1000.png" media="(min-width:1000px)">
			<source srcset="images\elevate-600.png" media="(min-width:600px)">
			<img src="images\elevate-300.png">
		</picture> -->
	</div>
	<div>
	<h2>2026 Jamboree Registration and Access<br>ELEVATE Your Access!</h1 style="margin-block-end: 0;">
	<?php if (isset($subtitle)) {
	 echo "<h2>".$subtitle."</h2>";
 } ?>
	</div>
</div>

</header>

