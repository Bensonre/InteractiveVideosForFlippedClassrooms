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
   
   $dbhost = 'fliiped-classroom.mysql.database.azure.com';//'oniddb.cws.oregonstate.edu';
   $dbname = 'fliiped-classroom';
   $dbuser = 'PowerRangers@fliiped-classroom';
   $dbpass = 'Mighty-Morphin';
   $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
   if ($mysqli->connect_errno) {
       echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
   }else{
    echo "MySql connected";
   }
// PHP Data Objects(PDO) Sample Code:
/*try {
    $conn = new PDO("sqlsrv:server = tcp:capstone2020.database.windows.net,1433; Database = Capstone", "PowerRangers", "Mighty-Morphin");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

   $result = $conn->query("SELECT ID FROM Students");
   			
			if ($result->rowCount() == 0) {
			echo "<p> There are no Students at this time</p>";	
			}

			else{ // make reviews	
					while ($row = $result->fetch()) {
                        echo  "<p> Student ID: ";
                        echo  $row['ID'];
                        echo "</p>";
                    }
            }

            $result = $conn->query("SELECT ID FROM Instructors");
   			
			if ($result->rowCount() == 0) {
			echo "<p> There are no Instructors at this time</p>";	
			}

			else{ // make reviews	
					while ($row = $result->fetch()) {
                        echo  "<p> Insructor ID: ";
                        echo  $row['ID'];
                        echo "</p>";
                    }
            }*/
?>
    <div class="containter PushLeft5">
    </div> 
    </body>
</html>
<script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
