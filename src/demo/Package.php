<?php
    session_start();
    $_SESSION['instructorId'] = 99;
    $currentpage = "Instructor";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Flipped Classroom: Student</title>
    <link rel="stylesheet" href="../css/Site-Style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://vjs.zencdn.net/7.6.6/video-js.css" rel="stylesheet" />
    <script>
        var ivcInstructorId = <?php echo $_SESSION['instructorId']; ?>;
    </script>
</head>

<body>
    <?php include "../includes/header.php"; ?>

    <div class="container mt-3">
            <?php include "../components/PackageComponent.php"; ?>
    </div> 

    <script src="https://vjs.zencdn.net/7.6.6/video.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>
