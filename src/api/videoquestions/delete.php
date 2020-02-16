<?php

include_once '../../database/Database.php';
include_once '../../controllers/VideoQuestionsController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$databaseEntryDeleted = false;

$id = json_decode($_POST['id']);

$database = new Database();
$db = $database->connect();

$videoQuestionsController = new VideoQuestionsController($db);

if ($videoQuestionsController->delete($id)) {
    $databaseEntryDeleted = true;
}

$response = array("success" => 0, "message" => "Your question was not successfully removed.");

if ($databaseEntryDeleted) {
    $response["success"] = 1;
    $response["message"] = "Your question was successfully removed.";
}

echo json_encode($response);
?>