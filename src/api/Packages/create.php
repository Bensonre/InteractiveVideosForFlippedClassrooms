<?php

include_once '../../database/Database.php';
include_once '../../controllers/PackageController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$fileUploaded = false;
$databaseEntryCreated = false;

// Upload the file to the server.
$targetdir = "../../video_files/";
$pathdir = "../video_files/";
$targetfile = $targetdir . basename($_FILES['fileToUpload']['name']);
$targetpath = $pathdir . basename($_FILES['fileToUpload']['name']);

$fileName = $_FILES["fileToUpload"]["name"];
echo "$fileName";

if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetfile)) {
    echo 'File successfully upload to the server.\n';
    $fileUploaded = true;
}

// Create a record within the database for this file.
$database = new Database();
$db = $database->connect();

$instructorId = 99; // TODO: replace with actual instructor id from $_SESSION variable

$controller = new PackageController($db, $instructorId, $_FILES['fileToUpload'], $_FILES['fileToUpload']['name'], $targetpath);
if ($controller->create()) {
    $databaseEntryCreated = true;
}

echo "\nredirecting...\n";
header("Location: {$_SERVER["HTTP_REFERER"]}");

?>