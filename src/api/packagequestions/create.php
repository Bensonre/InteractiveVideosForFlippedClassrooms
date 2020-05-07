<?php

include_once '../../database/Database.php';
include_once '../../controllers/CombineController.php';
include_once '../../controllers/PackageController.php';
include_once '../../session_variables/session_variables.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$databaseEntryCreated = false;

$data = json_decode($_POST['data']);
$packageID = $data->packageID;
$questionID = $data->questionID;
$timestamp = $data->timestamp;

$database = new Database();
$db = $database->connect();

$CombineController = new CombineController($db);
$packageController = new PackageController($db);

$videoID = $packageController->getVideoIdOfPackage($packageID);

if ($CombineController->create($videoID, $questionID, $packageID, $ivcInstructorId, $timestamp)) {
    $databaseEntryCreated = true;
}

$response = array("success" => 0, "message" => "Your question was not successfully added.");

if ($databaseEntryCreated) {
    $response["success"] = 1;
    $response["message"] = "Your question was successfully added.";
}

echo json_encode($response);
?>