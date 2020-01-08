<?php
$currentpage = "Instructor";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Flipped Classroom: Student</title>
    <link rel="stylesheet" href="Site-Style.css">
</head>

<body>
<?php
   include "header.php";
   
   #include 'connectvars.php';	
   
   #$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
   #if (!$conn) {
   #        die('Could not connect: ' . mysql_error());
   #}
?>
    <div class="containter PushLeft5">
            <?php include "CreateQuestionsComponent.php"; ?>
    </div> 
    </body>
</html>
