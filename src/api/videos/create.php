<?php

include_once '../../database/Database.php';
include_once '../../controllers/VideoController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$fileUploaded = false;
$databaseEntryCreated = false;

// Upload the file to the server.
$targetdir = "../../video_files/";
$pathdir = "../video_files/";
$targetfile = $targetdir . basename($_FILES['local-video-file']['name']);
$targetpath = $pathdir . basename($_FILES['local-video-file']['name']);

$fileName = $_FILES["local-video-file"]["name"];

if (move_uploaded_file($_FILES['local-video-file']['tmp_name'], $targetfile)) {
    $fileUploaded = true;
}

// Create a record within the database for this file.
$database = new Database();
$db = $database->connect();

$instructorId = 99; // TODO: replace with actual instructor id from $_SESSION variable

$controller = new VideoController($db);
if ($controller->create($instructorId, $_FILES['local-video-file'], $_FILES['local-video-file']['name'], $targetpath)) {
    $databaseEntryCreated = true;
}

$response = array("success" => 0, "message" => "Your file was not successfully uploaded.");

if ($fileUploaded && $databaseEntryCreated) {
    $response["success"] = 1;
    $response["message"] = "Your file was successfully uploaded.";
}

echo json_encode($response);

?>
