<?php
    include_once '../database/Database.php';
    include_once '../controllers/PackageController.php';
    include_once '../session_variables/session_variables.php';
    $database = new Database();
    $db = $database->connect();
      
    $controller = new PackageController($db);
    $res = $controller->readAllWithInstructorId($ivcInstructorId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Interactive Videos | Browse</title>
</head>
<body>
    <?php
        $packages = array();
        $result = $res->get_result();
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $r = array(
                    "id" => $row['ID'],
                    "title" => $row['Title'],
                    "instructorId" => $row['InstructorID'],
                    "videoId"=> $row['VideoID'],
                    "dateModified" => $row['DateModified']
                ); 
                array_push($packages, $r);
            }
        }

        for ($i = 0; $i < count($packages); $i++) {
            echo "<form method='POST' action='Student.php?id=" . $packages[$i]["id"] . "'>";
            echo "<input type='submit' value='" . $packages[$i]["title"] . "'></input>";
            echo "</form>";
        }
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>