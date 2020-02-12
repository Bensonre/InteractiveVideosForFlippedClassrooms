<?php

include_once '../../database/Database.php';
include_once '../../controllers/VideoQuestionsController.php';
include_once '../../controllers/PackagesController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$databaseEntryCreated = false;

$packageID = $_POST['select-package'];
$questionID = $_POST['select-question'];
$timestamp = $_POST['timestamp'];

$database = new Database();
$db = $database->connect();

$controller = new VideoQuestionsController($db);
$packageController = new PackageController($db);

$videoID = $packageController->getVideoIdOfPackage($packageID);

if ($controller->create($videoID, $questionID, $packageID, $timestamp)) {
    $databaseEntryCreated = true;
}

$response = array("success" => 0, "message" => "Your question was not successfully added.");

if ($databaseEntryCreated) {
    $response["success"] = 1;
    $response["message"] = "Your question was successfully added.";
}

header("Location: {$_SERVER["HTTP_REFERER"]}"); // temporary

echo json_encode($response);

?>