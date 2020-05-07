<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/PackageController.php';
    include_once '../../session_variables/session_variables.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $data = json_decode($_POST['data']);
    $packageId = $data->packageId;
    $title = $data->title;
    $videoId = $data->videoId;

    $databaseEntryCreated = false;

    $database = new Database();
    $db = $database->connect();

    $controller = new PackageController($db);

    if ($controller->update($packageId, $title, $ivcInstructorId, $videoId)) {
        $databaseEntryCreated = true;
    }

    $response = array("success" => 0, "message" => "The package was not successfully updated.");

    if($databaseEntryCreated == true) {
        $response['success'] = 1;
        $response['message'] = "The package was successfully updated.";
    }

    echo json_encode($response);
?>