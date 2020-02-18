<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/VideoController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $database = new Database();
    $db = $database->connect();

    $controller = new VideoController($db);
    $result = $controller->read($_POST['id']);

    $result->bind_result($id, $title, $instructorId, $filePath, $dateModified);

    $result->fetch();
    $obj = array('id' => $id, 'title' => $title, 'instructorId' => $instructorId, 
                 'filePath' => $filePath, 'dateModified' => $dateModified);
 
    echo json_encode($obj);
?>