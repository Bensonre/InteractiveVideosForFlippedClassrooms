<?php
    session_start();
    $currentpage = "Instructor";
    $_SESSION['instructorId'] = 99;
    $ivcInstuctorId = $_SESSION['instructorId'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Flipped Classroom: Student</title>
    <link rel="stylesheet" href="../css/Site-Style.css">
    <link href="https://vjs.zencdn.net/7.6.6/video-js.css" rel="stylesheet" />
    <link href="../dependencies/dist/videojs.markers.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <?php include "../includes/header.php" ?>
    
    <div class="container mt-3">
        <?php include "../components/ivcCombineComponent.php"; ?>
    </div>

    <script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
    <script src='../dependencies/dist/videojs-markers.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script onload="ivcInstructorIdInitializer(<?php echo $ivcInstuctorId; ?>);" src="../js/ivcIdInitializer.js"></script>
    <script onload="ivcPathToSrcInitializer('../../');" src="../js/ivcPathToSrcInitializer.js"></script>
    <script src="../js/ivcCombineComponent.js"></script>
    <script src="../js/ivcUpdateVideoTime.js"></script>
</body>
</html>
