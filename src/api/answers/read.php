<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/AnswerController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $database = new Database();
    $db = $database->connect();

    $controller = new AnswerController($db);

    if(!empty($_GET['questionID']) && !empty($_GET['studentID']) ) {
        $result = $controller->read($_GET['questionID'], $_GET['studentID']);
        if ($result != null) {
            echo json_encode($result);
        }
    }

    echo json_encode(false);
?>