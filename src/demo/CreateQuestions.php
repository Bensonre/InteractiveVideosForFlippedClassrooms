<?php
    session_start();
    $currentpage = "Instructor";
    $_SESSION['instructorId'] = 99;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Flipped Classroom: Student</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        var ivcInstructorId = <?php echo $_SESSION['instructorId']; ?>;
    </script>
</head>

<body>
    <?php include "../includes/header.php"; ?>
	
    <div class="container mt-3">
        <?php include "../components/CreateQuestionComponent.php"; ?>
    </div>

    </body>
</html>
<script src="../js/question-component.js"></script>
