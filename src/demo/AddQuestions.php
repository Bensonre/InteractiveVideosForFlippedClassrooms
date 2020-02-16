<?php
    session_start();
    $currentpage = "Instructor";
    $_SESSION['instructorId'] = 99;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Flipped Classroom: Student</title>
    <link rel="stylesheet" href="../css/Site-Style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://vjs.zencdn.net/7.6.6/video-js.css" rel="stylesheet" />
    <link href="../dependencies/dist/videojs.markers.css" rel="stylesheet">
    <script>
        var ivcInstructorId = <?php echo $_SESSION['instructorId']; ?>;
    </script>
</head>

<body>
    <div class="container">
            <?php include "../components/AddQuestionsComponent.php"; ?>
    </div>

    <script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
    <script src='../dependencies/dist/videojs-markers.js'></script>
    <script src="../js/add-questions-component.js"></script>

</body>
</html>
