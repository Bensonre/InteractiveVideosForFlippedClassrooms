<?php

include_once '../../database/Database.php';
include_once '../../controllers/CombineController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$databaseEntryUpdated = false;

$id = $_POST['id'];
$timestamp = $_POST['timestamp'];

$database = new Database();
$db = $database->connect();

$CombineController = new CombineController($db);

if ($CombineController->update($id, $timestamp)) {
    $databaseEntryUpdated = true;
}

$response = array("success" => 0, "message" => "Your question was not successfully updated.");

if ($databaseEntryUpdated) {
    $response["success"] = 1;
    $response["message"] = "Your question was successfully updated.";
}

echo json_encode($response);
?>