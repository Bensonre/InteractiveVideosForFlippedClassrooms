<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/VideoController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $databaseEntryCreated = false;

    $data = json_decode($_POST['data']);
    $id = $data->id;
    $title = $data->title;

    $database = new Database();
    $db = $database->connect();

    $controller = new VideoController($db);
    if ($controller->update($id, $title)) {
        $databaseEntryCreated = true;
    }

    $response = array("success" => 0, "message" => "Your title was not successfully uploaded.");

    if ($databaseEntryCreated) {
        $response["success"] = 1;
        $response["message"] = "Your title was successfully updated.";
    }

    echo json_encode($response);
?>