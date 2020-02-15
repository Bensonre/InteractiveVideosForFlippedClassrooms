<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/VideoQuestionsController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $packageID = $_GET['packageID'];
    $instructorID = $_GET['instructorID'];

    $database = new Database();
    $db = $database->connect();

    $controller = new VideoQuestionsController($db);
    $result = $controller->getQuestionsInPackage($packageID, $instructorID);

    $list = array();
    $result->bind_result($id, $text, $timeStamp);
    //$result->bind_result($id, $videoID, $questionID, $packageID, $instructorID, $questionTimeStamp);

    while($result->fetch()) {
        //$obj = array("ID" => $id, "VideoID" => $videoID, "QuestionID" => $questionID, "PackageID" => $packageID, 
          //           "InstructorID" => $instructorID, "QuestionTimeStamp" => $questionTimeStamp);
        $obj = array("ID" => $id, "QuestionText" => $text, "TimeStamp" => $timeStamp);
        array_push($list, $obj);
    }

    echo json_encode($list);
?>