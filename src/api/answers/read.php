<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/AnswerController.php';
    include_once '../../session_variables/session_variables.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $database = new Database();
    $db = $database->connect();

    $controller = new AnswerController($db);

    $result = null;
    if(!empty($_GET['questionID']) && isset($ivcStudentId) ) {
        $result = $controller->read($_GET['questionID'], $ivcStudentId);
    }

    echo json_encode($result);
?>