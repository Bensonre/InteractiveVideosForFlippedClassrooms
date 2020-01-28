<?php
$currentpage = "Instructor";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Flipped Classroom: Student</title>
    <link rel="stylesheet" href="../css/Site-Style.css">
	<link href="https://vjs.zencdn.net/7.6.6/video-js.css" rel="stylesheet" />
</head>

<body>
<?php
   include "../includes/header.php";
   
   $dbhost = 'oniddb.cws.oregonstate.edu';
   $dbname = 'bensonre-db';
   $dbuser = 'bensonre-db';
   $dbpass = 'AM8sgjoZzOQxVAeS';
   $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
   if ($mysqli->connect_errno) {
       echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
   }

   $query = "SELECT ID FROM `Students`";
   		$result = mysqli_query($mysqli, $query);	
			
			if (mysqli_num_rows($result) == 0) {
			echo "<p> There are no Students at this time</p>";	
			}

			else{ // make reviews	
					while ($row = mysqli_fetch_assoc($result)) {
                        echo  "<p> Student ID: ";
                        echo  $row['ID'];
                        echo "</p>";
                    }
            }

            $query = "SELECT ID FROM `Instructors`";
            $result = mysqli_query($mysqli, $query);	
             
             if (mysqli_num_rows($result) == 0) {
             echo "<p> There are no teachers at this time</p>";	
             }
 
             else{ // make reviews	
                     while ($row = mysqli_fetch_assoc($result)) {
                         echo  "<p> Student ID";
                         echo  $row['ID'];
                         echo "</p>";
                     }
             }
   //$mysqli->close();

?>
    <div class="containter PushLeft5">
    </div> 
    </body>
</html>
<script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
