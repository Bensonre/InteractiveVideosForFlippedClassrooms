<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/AnswerController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $database = new Database();
    $db = $database->connect();

    $controller = new AnswerController($db);

    $success = false;
    if(isset($_POST['questionID']) && isset($_POST['choiceID']) && isset($_POST['studentID']) ) {
        $result = $controller->create($_POST['questionID'], $_POST['choiceID'], $_POST['studentID']);
        if ($result) {
            $success = true;
        }
     }
    echo json_encode($success);
?>