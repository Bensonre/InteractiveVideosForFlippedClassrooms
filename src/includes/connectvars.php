<?php
  // Define database connection constants
   $dbhost = 'oniddb.cws.oregonstate.edu';
   $dbname = 'bensonre-db';
   $dbuser = 'bensonre-db';
   $dbpass = 'AM8sgjoZzOQxVAeS';
   $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
   if ($mysqli->connect_errno) {
       echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
   }
?>