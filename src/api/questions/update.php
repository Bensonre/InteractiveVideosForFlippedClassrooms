<?php

  include_once '../../database/Database.php';
  include_once '../../controllers/QuestionController.php';

  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  $databaseEntryCreated = false;

  $database = new Database();
  $db = $database->connect();

  $controller = new QuestionController($db);

  if(
    !empty($_POST['id']) &&
    !empty($_POST['question']) &&
    !empty($_POST['category']) &&
    !empty($_POST['a1']) &&
    !empty($_POST['a2']) &&
    !empty($_POST['a3']) &&
    !empty($_POST['a4']) &&
    !empty($_POST['correct'])
  ){
    $controller->id       = $_POST['id'];
    $controller->question = $_POST['question'];
    $controller->category = $_POST['category'];
    $controller->c1       = $_POST['a1'];
    $controller->c2       = $_POST['a2'];
    $controller->c3       = $_POST['a3'];
    $controller->c4       = $_POST['a4'];
    $controller->correct  = $_POST['correct'];



    if ($controller->update()) {
        $databaseEntryCreated = True;
    } else {
      echo json_encode(array("message" => "Couldn't Update Question"));
    }
   } else {
      echo json_encode(array("message" => "Can't Create Question. Insufficient Data."));
   }

   if($databaseEntryCreated == True) {
     echo json_encode(array("message" => "Question Updated"));
   }

  header("Location: {$_SERVER["HTTP_REFERER"]}");
?>
