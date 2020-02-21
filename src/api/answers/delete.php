<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/AnswerController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $database = new Database();
    $db = $database->connect();

    $controller = new AnswerController($db);

    $success = false;
    if(!empty($_GET['id'])) {
        $result = $controller->delete($_GET['id']);
        if ($result) {
            $success = true;
        }
    }

    echo json_encode($success);
?>