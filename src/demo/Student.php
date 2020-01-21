<?php
$currentpage = "Student";
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
?>
    <div class="containter PushLeft5">
            <?php include "../components/StudentComponent.php"; ?>
    </div> 
    </body>
</html>
<script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
