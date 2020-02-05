<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/AnswerController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $database = new Database();
    $db = $database->connect();

    $controller = new AnswerController($db);

    if(!empty($_POST['questionID']) && !empty($_POST['choiceID']) && !empty($_POST['studentID']) ) {
        $success = $controller->update($_POST['questionID'], $_POST['choiceID'], $_POST['studentID']);
        if ($success) {
            echo "Answer updated.";
        }
    }

    echo "Answer was not successfully updated.";
?>