<?php

include_once '../../database/Database.php';
include_once '../../controllers/QuestionController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$databaseEntryCreated = false;

$id       = $_POST['wutQ'];
$question = $_POST['question'];
$category = $_POST['category'];
$c1       = $_POST['c1'];
$c2       = $_POST['c2'];
$c3       = $_POST['c3'];
$c4       = $_POST['c4'];
$correct  = $_POST['correct'];

var_dump($id, $question, $category, $c1, $c2, $c3, $c4, $correct);

$database = new Database();
$db = $database->connect();

$controller = new QuestionController($db);
if ($controller->update($id, $question, $category, $c1, $c2, $c3, $c4, $correct)) {
    $databaseEntryCreated = true;
} else {
    echo "\nUpdate Question Failed\n";
}

echo "\nredirecting...\n";
/*header("Location: {$_SERVER["HTTP_REFERER"]}");*/

?>
