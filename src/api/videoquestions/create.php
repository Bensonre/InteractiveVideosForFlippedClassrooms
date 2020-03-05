<?php

include_once '../../database/Database.php';
include_once '../../controllers/VideoQuestionsController.php';
include_once '../../controllers/PackagesController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$databaseEntryCreated = false;

$data = json_decode($_POST['data']);
$packageID = $data->packageID;
$questionID = $data->questionID;
$instructorID = $data->instructorID;
$timestamp = $data->timestamp;

$database = new Database();
$db = $database->connect();

$videoQuestionsController = new VideoQuestionsController($db);
$packageController = new PackageController($db);

$videoID = $packageController->getVideoIdOfPackage($packageID);

if ($videoQuestionsController->create($videoID, $questionID, $packageID, $instructorID, $timestamp)) {
    $databaseEntryCreated = true;
}

$response = array("success" => 0, "message" => "Your question was not successfully added.");

if ($databaseEntryCreated) {
    $response["success"] = 1;
    $response["message"] = "Your question was successfully added.";
}

echo json_encode($response);
?>