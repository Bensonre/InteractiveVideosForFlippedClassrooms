<?php
$currentpage = "Instructor";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Flipped Classroom: Student</title>
    <link rel="stylesheet" href="../css/Site-Style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
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
