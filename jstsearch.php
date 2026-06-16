<?php 
	session_start();
    
    //set required access level for page - leave commented if available for all
	//1 - Users; 2 - admins; 3 - super users
    $page_access = 1;

    define('MyConst', TRUE);
    require_once("helpers/session.php");   
    header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
	//add Script filesize
	include 'helpers/scripts.php';
	

	//load db credentials and connection string - Uncomment if needed
    include 'helpers/dbh.php';
?>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="helpers/styles.css">
    <title>JST Member Search</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            //$("#jst_search").keyup(function(){
            $("#jst_search").on("input", function() {
                var input = $(this).val();
                //alert(input);
                if (input != ""){
                    $.ajax({
                        url:"./helpers/jstsearch.inc.php?cache_buster=" + Math.random(),
                        method:"POST",
                        data:{input:input},

                        success:function(data){
                            $("#jstsearch_result").html(data);
                        }
                    });
                } else {
                    $("#jstsearch_result").html("");
                }
            });
        });
    </script>
</head>
<body>
	<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
        $subtitle = "JST Member Search";
        include "helpers/header.inc.php"; 
        ?>

    
	<main>

    <?php

        if ($online == 0) {
           include "helpers/offline.php";
        } else {
    ?>

            <h1>Search Jamboree Service Team Members</h1>
            <label for="jst_search">Search by JST Name, email, or Reservation Code: </label>
            <input type="text" id="jst_search" autocomplete="off" placeholder="Search ..." autofocus >
<div style="margin:30px 0;">
    <caption><strong>Search Results Legend</strong></caption>
            <table style="border: none;">
            <tr>
                <th>Not Checked In Yet</td>
                <th style="background-color: yellow; color: black;">On site but packet not pulled</td>
                <th style="background-color: #9AB3D5; color: black;">On site and packet pulled</td>
                <th style="background-color: #CE1126; color: white;">On site but Pre Check In tasks incomplete</td>
                <th style="background-color: #006B3F; color: white;">One site and Checked In</td>
            </tr>
            </table>
        </div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Reservation Code</th>
                        <th>E-Mail</th>
                    </tr>
                </thead>

    <tbody id="jstsearch_result"></tbody>
        </table>
    
    
    <?php

        }
    ?>
	</main>
    <footer>
        <?php include "helpers/footer.inc.php"; ?>
    </footer>

</body>
</html>