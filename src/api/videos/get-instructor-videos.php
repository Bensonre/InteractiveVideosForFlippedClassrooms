<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/VideoController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $instructorId = $_GET['instructorId'];

    $database = new Database();
    $db = $database->connect();

    $controller = new VideoController($db);
    $result = $controller->getInstructorVideos($instructorId);

    $list = array();
    $result->bind_result($id, $title, $instructorId, $filePath, $dateModified);

    while($result->fetch()) {
        $obj = array('id' => $id, 'title' => $title, 'instructorId' => $instructorId, 
                     'filePath' => $filePath, 'dateModified' => $dateModified);
        array_push($list, $obj);
    }

    echo json_encode($list);
?>