<?php
  // Define database connection constants
   $dbhost = 'fliiped-classroom.mysql.database.azure.com';
   $dbname = 'capstone';
   $dbuser = 'PowerRangers@fliiped-classroom';
   $dbpass = 'Mighty-Morphin';
   $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
   if ($mysqli->connect_errno) {
       echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
   }
?>
