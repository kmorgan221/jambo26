<?php 
	session_start();
    //set required access level for page - leave commented if available for all
	//1 - Users; 2 - admins; 3 - super users
    $page_access = 1;
    define('MyConst', TRUE);
    require_once("helpers/session.php");    
?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php 
	//add Script filesize
	include 'helpers/scripts.php';
   
    

    //load db credentials and connection string
    
    if (isset($_GET['chkstat'])) {
        $checkstat = $_GET['chkstat'];
    }
    $subtitle = "Jamboree Staff Check-In Dashboard";
	
    if (isset($checkstat) and $checkstat == 1) {
        $subtitle .="<br>Pre-Arrival Tasks Complete";
    } else if (isset($checkstat) and $checkstat == 2) {
        $subtitle .="<br>Pre-Arrival Tasks Incomplete";
    }
?>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="helpers/styles.css">
    <title>Complete Staff Check In</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
            $(document).ready(function(){
                // Function to update content
                function updateContent(filterValue) {
                    $.ajax({
                        url: "./helpers/regteamjst.inc.php?cache_buster=" + Math.random(),
                        type: "GET", // Change type to GET
                        data: { filter: filterValue }, // Pass filterValue as data
                        dataType: "html",
                        success: function(response){
                            $("#jstdata").html(response);
                        },
                        error: function(xhr, status, error){
                            console.error(status + ": " + error);
                        }
                    });
                }

                // Update content immediately when the page loads
                // Assuming $filterValue is your PHP variable containing the filter value
                updateContent(<?php echo $checkstat; ?>);

                // Update content every minute
                setInterval(function() {
                    // Call updateContent with the filter value
                    updateContent(<?php echo $checkstat; ?>);
                }, 30000); // 30000 milliseconds = 30 seconds
            });
        </script>
</head>
<body>
		<!-- This is the header block.  The <header> tags are in the header.inc.php file. -->
        <?php 
        
        include "helpers/header.inc.php"; 
        ?>

    
		
 
	
	<main>
    <div id="jstdata"></div>
    
	</main>
    <footer>
        <?php include "helpers/footer.inc.php"; ?>
    </footer>

</body>
</html>