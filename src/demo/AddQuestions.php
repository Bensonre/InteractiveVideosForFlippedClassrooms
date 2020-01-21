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
   
   include 'connectvars.php';
   $dbhost = 'oniddb.cws.oregonstate.edu';
   $dbname = 'bensonre-db';
   $dbuser = 'bensonre-db';
   $dbpass = 'AM8sgjoZzOQxVAeS';
   $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
   if ($mysqli->connect_errno) {
       echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
   }

   $query = "SELECT Cid FROM Customer WHERE Email = '$username'";
   	$result = mysqli_query($mysqli, $query);
   //echo 'Successfully connected to database!';
   //$mysqli->close();

?>
    <div class="containter PushLeft5">
            <?php include "../components/AddQuestionsComponent.php"; ?>
    </div> 
    </body>
</html>
<script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
