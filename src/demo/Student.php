<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Flipped Classroom: Student</title>
	<link href="https://vjs.zencdn.net/7.6.6/video-js.css" rel="stylesheet" />
    <link href="../dependencies/videojs-overlay/node_modules/videojs-overlay/dist/videojs-overlay.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="../css/student-component.css" rel="stylesheet">
</head>

<body>
    <?php include "../includes/header.php"; ?>

    <div class="container mt-3">
        <?php include "../components/ivcStudentComponent.php"; ?>
    </div> 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
    <script src="../dependencies/videojs-overlay/node_modules/videojs-overlay/dist/videojs-overlay.min.js"></script>
    <script src="../dependencies/videojs-youtube/Youtube.min.js"></script>
    
    <script onload="ivcPathToSrcInitializer('../../');" src="../js/ivcPathToSrcInitializer.js"></script>
    <script src="../js/ivcStudentComponent.js"></script>
</body>
</html>

