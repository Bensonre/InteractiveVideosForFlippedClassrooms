<?php

include_once '../../database/Database.php';
include_once '../../controllers/VideoQuestionsController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$databaseEntryUpdated = false;

$id = $_POST['id'];
$timeStamp = $_POST['timeStamp'];

$database = new Database();
$db = $database->connect();

$videoQuestionsController = new VideoQuestionsController($db);

if ($videoQuestionsController->update($id, $timeStamp)) {
    $databaseEntryUpdated = true;
}

$response = array("success" => 0, "message" => "Your question was not successfully updated.");

if ($databaseEntryUpdated) {
    $response["success"] = 1;
    $response["message"] = "Your question was successfully updated.";
}

echo json_encode($response);
?>