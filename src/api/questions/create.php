<?php

include_once '../../database/Database.php';
include_once '../../controllers/QuestionController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$databaseEntryCreated = false;

$question = $_POST['question'];
$category = $_POST['category'];
$c1       = $_POST['a1'];
$c2       = $_POST['a2'];
$c3       = $_POST['a3'];
$c4       = $_POST['a4'];
$correct  = $_POST['correct'];

$database = new Database();
$db = $database->connect();

$controller = new CreateQuestionController($db, $question, $category, $c1, $c2, $c3, $c4, $correct);
if ($controller->create()) {
    $databaseEntryCreated = true;
}
echo "<script type='text/javascript'>alert('message');</script>";

echo "\nredirecting...\n";
header("Location: {$_SERVER["HTTP_REFERER"]}");

?>
