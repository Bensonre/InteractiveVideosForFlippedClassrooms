<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/AnswerController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $data = json_decode($_POST['data']);
    $studentId = $data->studentId;
    $questionId = $data->questionId;
    $answerId = $data->answerId;

    $database = new Database();
    $db = $database->connect();

    $controller = new AnswerController($db);

    $res = array("success" => false);
    if(isset($_POST['data'])) {
        $result = $controller->create($studentId, $questionId, $answerId);
        if ($result) {
            $res['success'] = true;
        }
     }
    echo json_encode($res);
?>